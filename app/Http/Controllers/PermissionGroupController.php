<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PermissionGroup;

use Illuminate\Support\Facades\Session;

class PermissionGroupController extends Controller

{

    function __construct()

    {

        //  $this->middleware('permission:Permission Group List|Permission Group Create|Permission Group Edit|Permission Group Delete', ['only' => ['index','store']]);

        //  $this->middleware('permission:Permission Group create', ['only' => ['create','store']]);

        //  $this->middleware('permission:Permission Group Edit', ['only' => ['edit','update']]);

        //  $this->middleware('permission:Permission Group Delete', ['only' => ['destroy']]);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $permissiongroup = PermissionGroup::orderBy('id','DESC')->get();

        return view('backend.PermissionGroup.index',compact('permissiongroup'));

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('backend.PermissionGroup.add');

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $this->validate($request, [

            'name' => 'required|unique:permissions,name',

        ]);

        PermissionGroup::create(['name' => $request->input('name')]);

         Session::put('success','Successfully created permission group');

        return redirect()->route('permission_group.index');

    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        //

    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $permissiongroup = PermissionGroup::find($id);

        return view('backend.PermissionGroup.edit', compact('permissiongroup'));

    }

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)

    {

        $this->validate($request, [

            'name' => 'required'

        ]);

        $permissiongroup = PermissionGroup::find($id);

        $permissiongroup->name = $request->input('name');

        $permissiongroup->save();

         Session::put('success','Successfully update permission group');

        return redirect()->route('permission_group.index');

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $permissiongroup=PermissionGroup::find($id);

        if($permissiongroup){

            $status=$permissiongroup->delete();

            if($status){

                 Session::put('success','permission group successfully deleted');

                return redirect()->route('permission_group.index');

            }

            else{

                return back()->with('error','Data not found');

            }

        }

    }

}

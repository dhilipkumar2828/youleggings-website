<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PermissionGroup;

use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\Session;

class PermissionController extends Controller

{

 function __construct()

    {

        //  $this->middleware('permission:Permission List|Permission Create|Permission Edit|Permission Delete', ['only' => ['index','store']]);

        //  $this->middleware('permission:Permission Create', ['only' => ['create','store']]);

        //  $this->middleware('permission:Permission Edit', ['only' => ['edit','update']]);

        //  $this->middleware('permission:Permission Delete', ['only' => ['destroy']]);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $permission = Permission::orderBy('id','DESC')->get();

        return view('backend.permission.index', compact('permission'));

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {$permissionGroup = PermissionGroup::get();

        return view('backend.permission.add',compact('permissionGroup'));

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        // $this->validate($request, [

        //     'name' => 'required|unique:permissions,name',

        // ]);

        // Permission::create(['name' => $request->input('name')]);

        // $request->syncPermissionGroups($request->permission_group_id);

        // return redirect()->route('permission.index')->with('success','Successfully created permission');

        $Permission = new Permission();

        $Permission->name = $request->name;

        $Permission->permission_group_id = $request->permission_group_id;

        $Permission->save();

       // $Permission = PermissionGroup::find($request->permission_group_id);

          Session::put('success','Successfully created Permission');

        return redirect()->route('permission.index');

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

        $permission = Permission::find($id);

        return view('backend.permission.edit', compact('permission'));

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

        $permission = Permission::find($id);

        $permission->name = $request->input('name');

        $permission->save();

             Session::put('success','Successfully update permission');

       return redirect()->route('permission.index');

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $permission=Permission::find($id);

        if($permission){

            $status=$permission->delete();

            if($status){

                 Session::put('error','permission successfully deleted');

                return redirect()->route('permission.index');

            }

            else{

                return back()->with('error','Data not found');

            }

        }

    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\Session;

class AssignRoleToUserController extends Controller

{

    // public function __construct()

    // {

    //     $this->middleware(['permission:|edit articles']);

    // }

   function __construct()

    {

         $this->middleware('permission:Assign User Role List|Assign User Role Create|Assign User Role Edit|Assign User Role Delete', ['only' => ['index','store']]);

         $this->middleware('permission:Assign User Role Create', ['only' => ['create','store']]);

         $this->middleware('permission:Assign User Role Edit', ['only' => ['edit','update']]);

         $this->middleware('permission:Assign User Role Delete', ['only' => ['destroy']]);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $users =User::with('roles')->get();

        return view('backend.Assign_role_user.index',compact('users'));

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        $users = User::get();

        $roles = Role::get();

        return view('backend.Assign_role_user.add',compact('users','roles'));

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $user = User::find($request->user_id);

      //  $role = Role::find($request->role_id);

        $user->syncRoles($request->role_name);

         Session::put('success',"Role Assgined to successfully created");

        return redirect()->route('Assign_role_user.index');

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

        $selectuser =User::with('roles')->find($id);

        $users = User::get();

        $roles = Role::get();

        return view('backend.Assign_role_user.edit ',compact('selectuser','users','roles'));

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

        $user = User::find($id);

        //$role = Role::find($request->role_id);

        $user->syncRoles($request->role_id);

         Session::put('success','Role Update to  $user->email successfully created');

        return redirect()->route('Assign_role_user.index');

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        //

    }

}

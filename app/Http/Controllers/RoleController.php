<?php

namespace App\Http\Controllers;

use App\Models\PermissionGroup;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\Session;

use Auth;

class RoleController extends Controller

{

    function __construct()

    {

        $this->middleware('permission:role-view|role-add|role-edit|role-delete', ['only' => ['index','add']]);

        $this->middleware('permission:role-add', ['only' => ['add','store']]);

        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);

        $this->middleware('permission:role-delete', ['only' => ['delete']]);

        $this->userid=@Auth::user()->id;

        $this->username=@Auth::user()->name;

        }

    public function index(){

        $roles=Role::get();

        return view('backend.roles.index',compact('roles'));

    }

    public function add(){

        $roles=Role::all();

        $permissions = Permission::get();

        $permissionGroups = PermissionGroup::with('permissions')->get();

        return view('backend.roles.add',compact('roles','permissions','permissionGroups'));

    }

    public function edit(Request $request, $id){

        $roles = Role::find($id);

        $permissions = Permission::get();

        $permissionGroups = PermissionGroup::with('permissions')->get();

        return view('backend.roles.edit',compact('roles','permissions','permissionGroups'));

    }

    public function store(Request $request){

        $role = Role::create(['name' => $request->input('role')]);

        $role->syncPermissions($request->input('permission'));

        if($role){

            Session::put('success','Successfully created Role');

           return redirect('roleview');

    }

}

public function update(Request $request, $id){

    $role = Role::find($id);

    $role->name = $request->input('role');

    $role->save();

    $role->syncPermissions($request->input('permission'));

    Session::put('success','Successfully updated Role');

    return redirect('roleview');

}

public function delete(Request $request, $id){

    $role=Role::where('id',$id)->delete();

    Session::put('error','Successfully deleted Role');

    return redirect('roleview');

}

}

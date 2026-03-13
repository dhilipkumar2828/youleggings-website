<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\User;

use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;

use App\Models\Visitors;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public $userid;
    public $username;

    function __construct()

    {

        $this->middleware('permission:user-view|user-add|user-edit|user-delete', ['only' => ['index','store']]);

        $this->middleware('permission:user-add', ['only' => ['create','store']]);

        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);

        $this->middleware('permission:user-delete', ['only' => ['destroy']]);

        $this->userid=@Auth::user()->id;

        $this->username=@Auth::user()->name;

        }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $Users =User::orderBy('id','DESC')->where('role','!=','customer')->get();

        return view('backend.user.view',compact('Users'));

    }

    public function userStatus(Request $request)

    {

    //    dd($request->all());

    if($request->mode=='true'){

        DB::table('users')->where('id',$request->id)->update(['status'=>'active']);

    }

    else{

        DB::table('users')->where('id',$request->id)->update(['status'=>'inactive']);

    }

    return response()->json(['msg'=>'Successfully update status','status'=>true]);

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        $roles=Role::get();

        return view('backend.user.add',compact('roles'));

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $duplicate_email=User::where('email',$request->email)->first();

        if(isset($duplicate_email)){

            $resval=false;

            return response()->json(['error'=>'Email already exists','resval'=>$resval]);

        }else{

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        // Store photo if present
        if ($request->has('photo')) {
            $data['photo'] = $request->photo;
        }

        $user = User::create($data);

        $user->assignRole($request->input('role'));

        $resval=true;

        return response()->json(['resval'=>$resval]);

    }

    }

    public function visitors(Request $request)

    {

    // $userIp = \Request::ip();

    // $locationData = \Location::get($userIp);

    // dd($locationData);

    $visitors =visitors::orderBy('id','DESC')->get();

    return view('backend.user.visitors',compact('visitors'));

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

        $roles=Role::get();

        $user=User::find($id);

        if($user){

            return view('backend.user.edit',compact('user','roles'));

        }

        else{

            return back()->with('error','Data not  found');

        }

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

        $User=User::find($id);

        $duplicate_email=User::where('email',$request->email)->where('id','!=',$id)->first();

        if(isset($duplicate_email)){

            $resval=false;

            return response()->json(['error'=>'Email already exists','resval'=>$resval]);

        }else{

        $data = $request->all();

        // Handle password update if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        // Handle photo update
        if ($request->has('photo')) {
            $data['photo'] = $request->photo;
        }

        $User->update($data);

        // User::where('id',$id)->update(['name'=>$request->name,'email'=>$request->email,'password'=>Hash::make($request->password),'phone'=>$request->phone,'role'=>$request->role]);

        $User->roles()->detach();

        $User->assignRole($request->input('role'));

        Session::put('success','user successfully updated');

        return redirect()->route('user.index');

        }

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $user=User::find($id);

        if($user){

            $status=$user->delete();

            if($status){

               Session::put('error','user successfully deleted');

                return redirect()->route('user.index');

            }

            else{

                return back()->with('error','Data not found');

            }

        }

        else{

            return back()->with('error','Data not  found');

        }
    }

    public function customerlist()
    {
        $Users = User::orderBy('id','DESC')->where('role','customer')->get();
        return view('backend.user.view',compact('Users'));
    }

    public function customerview($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::get();
        return view('backend.user.edit',compact('user', 'roles'));
    }
}

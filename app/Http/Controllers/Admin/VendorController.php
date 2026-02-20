<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Vendor;

use App\Models\Purchese;

use App\Models\Product;

use App\Models\Coupon;

use App\Models\User;

use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class VendorController extends Controller

{

    function __construct()

    {

         $this->middleware('permission:Vendor List|Vendor Create|Vendor Edit|Vendor Delete', ['only' => ['index','store']]);

         $this->middleware('permission:Vendor Create', ['only' => ['create','store']]);

         $this->middleware('permission:Vendor Edit', ['only' => ['edit','update']]);

         $this->middleware('permission:Vendor Delete', ['only' => ['destroy']]);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $vendor=Vendor::get();

        return view('backend.vendor.vendors',compact('vendor'));

    }

public function merchants(){

    $vendor=Vendor::get();

    return view('backend.merchants.merchants',compact('vendor'));

}

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('backend.vendor.vendors-create');

    }

    public function vendor_status(Request $request)

    {

    //    dd($request->all());

    if($request->mode=='true'){

        DB::table('vendor')->where('id',$request->id)->update(['status'=>'active']);

    }

    else{

        DB::table('vendor')->where('id',$request->id)->update(['status'=>'inactive']);

    }

    return response()->json(['msg'=>'Successfully update status','status'=>true]);

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

     public function duplicate_user(Request $request){

        $duplicate_check=DB::table('users')->where('email',$request->user_name)->first();

        if(!empty($duplicate_check)){

            $validation="duplicate";

     }else{

        $validation="no_duplicate";

     }

     return response()->json((['validation'=>$validation]));

    }

    public function store(Request $request)

    {

        $duplicate_check=DB::table('users')->where('email',$request->user_name)->first();

        if(!empty($duplicate_check)){

            return back()->with('error','Data not found');

    }else{

// $this->validate($request,[

//     'vendor_id'=>'string|required',

//     'vendor_name'=>'string|required',

//     'shop_name'=>'string|required',

//     'date_of_birth'=>'string|required',

//     'gender'=>'string|required',

//     'email'=>'string|nullable|required',

//     'mobile_number'=>'nullable|numeric|required',

//     'website'=>'nullable|required',

//     'address'=>'nullable|string|required',

//     'pincode'=>'nullable|numeric|required',

//     'bankname'=>'nullable|string|required',

//     'account_number'=>'nullable|numeric|required',

//     'branch'=>'nullable|string|required',

//     'account_holder_name'=>'nullable|string|required',

//     'ifsc_code'=>'nullable|string|required',

//     'tax_name'=>'nullable|string|required',

//     'tax_number'=>'string|numeric|required',

//     'pan_number'=>'string|required',

//     'status'=>'nullable|in:active,inactive',

// ]);

$data=$request->all();

//dd($data);

$request->validate([

    'logo' => 'required',

]);

// $fileName = $request->get('vendor_id').'.'.$request->file('logo')->extension();

// $request->file('logo')->store(public_path('uploads').'/'.$fileName);

// $data['logo']=$fileName;

$status=Vendor::create($data);

$data1['name']=$data['vendor_name'];

$data1['photo']=$data['logo'];

$data1['phone']=$data['mobile_number'];

$data1['type']="vendor";

$data1['address']=$data['address'];

$data1['email']=$data['user_name'];

$data1['password']= Hash::make($data['password']);

$userid=User::create($data1);

$user = User::find($userid->id);

      //  $role = Role::find($request->role_id);

      $role_name='vendor';

      $user->syncRoles($role_name);

if($status){

    Session::put('success','Vendor create successfully');

    return redirect()->route('vendors.index');

}

else{

    return back()->with('error','Data not found');

}

    }

    }

    /**

     * Display the specified resource.

     *

     * @param  \App\Models\Vendor  $vendor

     * @return \Illuminate\Http\Response

     */

    public function show(Vendor $vendor)

    {

        //

    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Models\Vendor  $vendor

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

      $vendor=Vendor::find($id);

      if($vendor){

        return view('backend.vendor.vendors-edit',compact('vendor'));

    }

    else{

        return back()->with('error','Data not  found');

    }

    }

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Models\Vendor  $vendor

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request,$id)

    {

        $vendor=Vendor::find($id);

        if($vendor){

            // return view('backend.banner.edit',compact('banner'));

           // return $request->all();

           $this->validate($request,[

            'vendor_name'=>'string|required',

            'shop_name'=>'string|required',

            'date_of_birth'=>'string|required',

            'gender'=>'string|required',

            'email'=>'nullable|required',

            'mobile_number'=>'nullable|numeric|required',

            'website'=>'nullable|required',

            'address'=>'nullable|string|required',

            'pincode'=>'nullable|numeric|required',

            'bankname'=>'nullable|string|required',

            'account_number'=>'nullable|numeric|required',

            'branch'=>'nullable|string|required',

            'account_holder_name'=>'nullable|string|required',

            'ifsc_code'=>'nullable|string|required',

            'tax_name'=>'nullable|string|required',

            'tax_number'=>'string|numeric|required',

            'pan_number'=>'string|required',

            'status'=>'nullable|in:active,inactive',

             'logo' => 'required',

        ]);

   $data=$request->all();

//         if($request->file('logo')){

//             $request->validate([

//                 'logo' => 'required|mimes:jpg,png',

//             ]);

//   $fileName = $request->get('vendor_id').'.'.$request->file('logo')->extension();

          //  $request->file('logo')->store(public_path('uploads'), $fileName);

// $request->file('logo')->store(public_path('uploads').'/'.$fileName);

//             $data['logo']=$fileName;

//         }

        $status=$vendor->fill($data)->save();

        if($status){

             Session::put('success','Vendor Successfully Updated ');

            return redirect()->route('vendors.index');

        }else{

            return back()->with('error','something went worng!');

        }

        }

        else{

            return back()->with('error','Data not  found');

        }

    }

    public function merchants_edit($id)

    {

      $vendor=Vendor::find($id);

      if($vendor){

        return view('backend.merchants.merchants-edit',compact('vendor'));

    }

    else{

        return back()->with('error','Data not  found');

    }

    }

    public function merchants_update(Request $request,$id)

    {

                $vendor=Vendor::find($id);

        if($vendor){

            // return view('backend.banner.edit',compact('banner'));

           // return $request->all();

           $this->validate($request,[

            'vendor_name'=>'string|required',

           'date_of_birth'=>'string|required',

            'gender'=>'string|required',

            'email'=>'nullable|required',

            'mobile_number'=>'nullable|required',

            'address'=>'nullable|string|required',

            'pincode'=>'nullable|numeric|required',

            'status'=>'nullable|in:active,inactive',

        ]);

   $data=$request->all();

        $status=$vendor->fill($data)->save();

        if($status){

             Session::put('success','Merchants Successfully Updated');

            return redirect()->route('merchants');

        }else{

            return back()->with('error','something went worng!');

        }

        }

        else{

            return back()->with('error','Data not  found');

        }

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Models\Vendor  $vendor

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $vendor=Vendor::find($id);

        if($vendor){

            $status=$vendor->delete();

            if($status){

               Session::put('error','Vendor successfully deleted');

                return redirect()->route('vendors.index');

       }

            else{

                return back()->with('error','Data not found');

            }

        }

        else{

            return back()->with('error','Data not  found');

        }

    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Suppliers;

use Auth;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class SuppliersController extends Controller

{

    function __construct()

    {

         $this->middleware('permission:Supplier List|Supplier Create|Supplier Edit|Supplier Delete', ['only' => ['index','store']]);

         $this->middleware('permission:Supplier Create', ['only' => ['create','store']]);

         $this->middleware('permission:Supplier Edit', ['only' => ['edit','update']]);

         $this->middleware('permission:Supplier Delete', ['only' => ['destroy']]);

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

        $user=(Auth::user()->roles[0]->id == 1) ?['1',$this->userid] : [$this->userid];

        $suppliers=Suppliers::whereIn('created_by',$user)->orderBy('id','DESC')->get();

        return view('backend.suppliers.suppliers',compact('suppliers'));

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('backend.suppliers.suppliers-create');

    }

    public function supplier_status(Request $request)

    {

    //    dd($request->all());

    if($request->mode=='true'){

        DB::table('suppliers')->where('id',$request->id)->update(['status'=>'active']);

    }

    else{

        DB::table('suppliers')->where('id',$request->id)->update(['status'=>'inactive']);

    }

    return response()->json(['msg'=>'Successfully update status','status'=>true]);

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

$this->validate($request,[

    'supplier_name'=>'string|required',

    'email'=>'nullable|required',

    'mobile_number'=>'nullable|numeric|required',

    'website'=>'nullable|required',

    'address'=>'nullable|string|required',

    'pincode'=>'nullable|numeric|required',

    'description'=>'string|required',

    'status'=>'nullable|in:active,inactive',

]);

$data=$request->all();

//dd($data);

$request->validate([

    'logo' => 'required',

]);

$data['created_by']=$this->userid;

$status=Suppliers::create($data);

if($status){

    Session::put('success','Supplier create successfully');

    return redirect()->route('suppliers.index');

}

else{

    return back()->with('error','Data not found');

}

    }

    /**

     * Display the specified resource.

     *

     * @param  \App\Models\Suppliers  $suppliers

     * @return \Illuminate\Http\Response

     */

    public function show(Suppliers $suppliers)

    {

   //

    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Models\Suppliers  $suppliers

     * @return \Illuminate\Http\Response

     */

    public function edit(Suppliers $suppliers,$id)

    {

        $suppliers=Suppliers::find($id);

        if($suppliers){

          return view('backend.suppliers.suppliers-edit',compact('suppliers'));

      }

      else{

          return back()->with('error','Data not  found');

      }

    }

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Models\Suppliers  $suppliers

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request,$id)

    {

        $suppliers=Suppliers::find($id);

        if($suppliers){

            // return view('backend.banner.edit',compact('banner'));

           // return $request->all();

           $this->validate($request,[

            'supplier_name'=>'string|required',

            'email'=>'nullable|required',

            'mobile_number'=>'nullable|numeric|required',

            'website'=>'nullable|required',

            'address'=>'nullable|string|required',

            'pincode'=>'nullable|numeric|required',

            'description'=>'string|required',

            'status'=>'nullable|in:active,inactive',

        ]);

   $data=$request->all();

        $status=$suppliers->fill($data)->save();

        if($status){

             Session::put('success','Supplier Successfully Updated ');

            return redirect()->route('suppliers.index');

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

     * @param  \App\Models\Suppliers  $suppliers

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $suppliers=Suppliers::find($id);

        if($suppliers){

            $status=$suppliers->delete();

            if($status){

               Session::put('error','Supplier successfully deleted');

                return redirect()->route('suppliers.index');

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

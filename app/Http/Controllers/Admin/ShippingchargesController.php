<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shippingcharges;

use DB;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

use Auth;

class ShippingchargesController extends Controller

{

     function __construct()

    {

         $this->middleware('permission:tax-view|tax-add|tax-edit|tax-delete', ['only' => ['index','store']]);

         $this->middleware('permission:tax-add', ['only' => ['create','store']]);

         $this->middleware('permission:tax-edit', ['only' => ['edit','update']]);

         $this->middleware('permission:tax-delete', ['only' => ['destroy']]);

        //  $this->userid=@Auth::user()->id;

        //  $this->username=@Auth::user()->name;

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $tax=Shippingcharges::orderBy('id','DESC')->get();

        return view('backend.shippingcharges.shippingcharges',compact('tax'));

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('backend.tax.tax-add');

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

            'tax_name'=>'required|string',

            'percentage'=>'required',

            'status'=>'required|in:active,inactive',

       ]);

       $data=$request->all();

    //   $data['created_by']=$this->userid;

       $status=Shippingcharges::create($data);

       if($status){

           Session::put('success','Shippingcharges successfully created');

           return redirect()->route('tax.index');

       }

       else{

           return back()->with('error','Something went wrong');

       }

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

     public function shippingchargesedit()

    {

        $shipping= DB::table('shippingcharges')->where('ship_id',1)->get();

        $shipping_id = '1';

        if($shipping){

            return view('backend.shippingcharges.shippingcharges-edit',compact('shipping','shipping_id'));

        }

        else{

            return back()->with('error','Shippingcharges not  found');

        }

    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $tax=Shippingcharges::find($id);

        if($tax){

            return view('backend.tax.tax-edit',compact('tax'));

        }

        else{

            return back()->with('error','Shippingcharges not  found');

        }

    }

    public function taxstatus(Request $request)

    {

    if($request->mode=='true'){

        DB::table('taxes')->where('id',$request->id)->update(['status'=>'active']);

    }

    else{

        DB::table('taxes')->where('id',$request->id)->update(['status'=>'inactive']);

    }

    return response()->json(['msg'=>'Successfully update status','status'=>true]);

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

        if(!empty($request->from_amount)){

            DB::table('shippingcharges')->where('ship_id',1)->delete();

            $form_amounts = $request->from_amount;

            foreach($form_amounts as $i => $vals){

                $datas = array(

                    'ship_id'=>1,

                    'from'=>$request->from_amount[$i],

                    'to'=>$request->to_amount[$i],

                    'amount'=>$request->ship_amount[$i],

                    'amount1'=>$request->ship_amount1[$i],

                    'dis_amount'=>$request->dis_amount[$i],

                    'dis_amount1'=>$request->dis_amount1[$i]

                    );

                    DB::table('shippingcharges')->insert($datas);

            }

        }

        Session::put('success','Successfully updated Shippingcharges');

        return redirect()->route('shippingchargesedit');

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $tax=Shippingcharges::find($id);

        if($tax){

            $status=$tax->delete();

            if($status){

               Session::put('error','Shippingcharges successfully deleted');

                return redirect()->route('tax.index');

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

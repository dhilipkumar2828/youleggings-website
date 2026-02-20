<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Purchase;

use App\Models\PurchaseProduct;

use App\Models\Product;

use App\Models\VendorItem;

use App\Models\VendorItemAttribute;

use App\Models\Coupon;

use App\Models\Vendor;

use App\Models\Quotation;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

class PurchaseController extends Controller

{

     function __construct()

    {

         $this->middleware('permission:Purchase List|Purchase Create|Purchase Edit|Purchase Delete', ['only' => ['index','store']]);

         $this->middleware('permission:Purchase Create', ['only' => ['create','store']]);

         $this->middleware('permission:Purchase Edit', ['only' => ['edit','update']]);

         $this->middleware('permission:Purchase Delete', ['only' => ['destroy']]);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $purchase=Purchase::get();

        return view('backend.purchase.purchase-request',compact('purchase'));

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('backend.purchase.purchase-request-create');

    }

    public function vendorproduct(Request $request)

    {

       $data=VendorItem::where('vendoritem.vendor_id',$request->id)->join('products','products.id','=','vendoritem.product_id')->get(['vendoritem.*','products.title']);

        return response()->json(["vendordata"=>$data,'status'=>true]);

    }

    public function vendorproductitem(Request $request)

    {

       $data=VendorItemAttribute::where('vendoritem_attribute.vendor_item_id',$request->id)->get();

        return response()->json(["vendoritemdata"=>$data,'status'=>true]);

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

 //       dd($request->all());

        $data=$request->all();

        //return $data;

        $vendor=explode('|',$request->get('vendor'));

        $vid=$vendor[0];

        $vname=$vendor[1];

        $sdata=[

            "id"=>NULL,

            "purchase_request_id"=>$request->get('purchase_request_id'),

            "purchase_request_name"=>$request->get('purchase_request_name'),

            "requester"=> $request->get('requester'),

            "vendor_id"=>$vid,

            "vendor_name"=>$vname,

            "vendor_items_id"=>$request->get('vendor_items_id'),

            "status"=>($request->get('status'))? 'active':'active',

        ];

        $status=Purchase::create($sdata);

        $id=$status->id;

        for($j=0;$j<count($data['product_id']);$j++){

            for($i=0;$i<count($data['attribute_id'][$data['product_id'][$j]]);$i++){

        $data1=[

            "id"=>NULL,

            "purchase_request_id"=>@$id,

            "vendor_item_id"=>@$request->get('vendor_item_id')[$j],

            "product_id"=>$request->get('product_id')[$j],

            "product_name"=>$request->get('product_name')[$j],

            "attribute_id"=>$data['attribute_id'][$request->get('product_id')[$j]][$i],

            "attribute_name"=>$data['attribute_name'][$request->get('product_id')[$j]][$i],

            "attribute_value"=>$data['attribute_value'][$request->get('product_id')[$j]][$i],

            "quantity"=>$data['qty'][$request->get('product_id')[$j]][$i],

            "buying_price"=>$data['buying_price'][$request->get('product_id')[$j]][$i],

            "tax_rate"=>$data['tax_rate'][$j]

        ];

        //print_r($data1);

        $status1=PurchaseProduct::create($data1);

        }

    }

        if($status1){

            Session::put('success','Purchase Request create successfully');

            return redirect()->route('purchase.index');

        }

        else{

            return back()->with('error','Data not found');

        }

    }

    public function purchasestatus(Request $request)

    {

    //    dd($request->all());

    if($request->mode=='true'){

        DB::table('purchase')->where('id',$request->id)->update(['status'=>'active']);

    }

    else{

        DB::table('purchase')->where('id',$request->id)->update(['status'=>'inactive']);

    }

    return response()->json(['msg'=>'Successfully update status','status'=>true]);

    }

    public function quotationstatus(Request $request)

    {

    //    dd($request->all());

    if(count(Quotation::orderBy('id','DESC')->limit('1')->get('id')) > 0):

        foreach(Quotation::orderBy('id','DESC')->limit('1')->get('estimate_id') as $item):

        $eid="EST-0000".(explode('-',$item->estimate_id)[1]+1);

        endforeach;

    else:

        $eid="EST-00001";

    endif;

        Quotation::create(['purchase_request_id'=>$request->get('id'),'estimate_id'=>$eid,'status'=>'Not Approved']);

    return response()->json(['msg'=>'Successfully update status','status'=>true]);

    }

    /**

     * Display the specified resource.

     *

     * @param  \App\Models\Purchese  $purchese

     * @return \Illuminate\Http\Response

     */

    public function show(Purchese $purchese)

    {

        //

    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Models\Purchese  $purchese

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $purchase=Purchase::find($id);

        $pid=$purchase->id;

        $purchaseproduct=PurchaseProduct::where("purchase_request_id","=",$pid)->groupBy('product_id')->get();

        if($purchase){

          return view('backend.purchase.purchase-request-edit',compact('purchase','purchaseproduct'));

      }

      else{

          return back()->with('error','Data not  found');

      }

    }

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Models\Purchese  $purchese

     * @return \Illuminate\Http\Response

     */

    public function  update(Request $request, $id)

    {

        $data=$request->all();

        $status=0;

        $update=Purchase::where(["id"=>$id])->update(['purchase_request_name'=>$data['purchase_request_name'],'requester'=>$data['requester']]);

        $purchaseitem=Purchase::where(["id"=>$id])->get();

        if($purchaseitem){

            for($j=0;$j<count($data['product_id']);$j++){

        $purchase1=PurchaseProduct::where(["purchase_request_id"=>$data['purchase_request_id'],"product_id"=>$data['product_id'][$j],"attribute_id"=>$data['attribute_id'][$data['product_id'][$j]]])->count();

        if($purchase1){

            for($i=0;$i<count($data['qty'][$data['product_id'][$j]]);$i++){

        $status=PurchaseProduct::where(["purchase_request_id"=>$data['purchase_request_id'],"product_id"=>$data['product_id'][$j],"attribute_id"=>$data['attribute_id'][$data['product_id'][$j]][$i]])->update(["quantity"=>$data['qty'][$data['product_id'][$j]][$i],"buying_price"=>$data['buying_price'][$data['product_id'][$j]][$i]]);

    }

    }

    else{

        for($i=0;$i<count($data['qty'][$data['product_id'][$j]]);$i++){

        $data1=[

            "id"=>NULL,

            "purchase_request_id"=>@$data['purchase_request_id'],

            "vendor_item_id"=>@$data['vendor_item_id'][$j],

            "product_id"=>$data['product_id'][$j],

            "product_name"=>$data['product_name'][$j],

            "attribute_id"=>$data['attribute_id'][$data['product_id'][$j]][$i],

            "attribute_name"=>$data['attribute_name'][$data['product_id'][$j]][$i],

            "attribute_value"=>$data['attribute_value'][$data['product_id'][$j]][$i],

            "quantity"=>$data['qty'][$data['product_id'][$j]][$i],

            "buying_price"=>$data['buying_price'][$data['product_id'][$j]][$i]

        ];

        //print_r($data1);

       // dd($data1);

        $status1=PurchaseProduct::create($data1);

    }

    }

            }

         if($status){

            Session::put('success','Purchase Request Update successfully');

            return redirect()->route('purchase.index');

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

     * @param  \App\Models\Purchese  $purchese

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $purchase=Purchase::find($id);

        if($purchase){

            $purchaseitem=PurchaseProduct::where(["purchase_request_id"=>$id])->delete();

            $status=$purchase->delete();

            if($status){

                 Session::put('error','Purchase Request Update successfully');

                return redirect()->route('purchase.index');

             }else{

                 return back()->with('error','something went worng!');

             }

        }

        else{

            return back()->with('error','Data not  found');

        }

    }

}

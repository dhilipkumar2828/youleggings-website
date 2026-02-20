<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Vendor;

use App\Models\VendorItem;

use App\Models\VendorItemAttribute;

use App\Models\Purchese;

use App\Models\Product;

use App\Models\ProductAttribute;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

class VendorItemController extends Controller

{

  function __construct()

    {

         $this->middleware('permission:Vendor Item List|Vendor Item create|Vendor Item edit|Vendor Item delete', ['only' => ['index','store']]);

         $this->middleware('permission:Vendor Item Create', ['only' => ['create','store']]);

         $this->middleware('permission:Vendor Item Edit', ['only' => ['edit','update']]);

         //$this->middleware('permission:vendoritem delete', ['only' => ['destroy']]);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $vendor=VendorItem::join('vendor','vendor.id','=','vendoritem.vendor_id')->join('products','products.id','=','vendoritem.product_id')->join('brands','brands.id','=','products.brand_id')->join('categories','categories.id','=','products.cat_id')->get(['vendoritem.*','products.title','products.size_guide','brands.title as brandtitle','categories.title as cattitle']);

        return view('backend.vendor-items.vendors-item',compact('vendor'));

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('backend.vendor-items.vendors-item-create');

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

// $this->validate($request,[

//     'coupon_code'=>'string|required',

//     'product_id'=>'nullable|exists:products,id',

//     'start_date'=>'nullable',

//     'end_date'=>'nullable',

//     'amount'=>'nullable|numeric|required',

//     'discount'=>'nullable|string|required',

//     'discount_type'=>'string|required',

//     'Status'=>'nullable|in:active,inactive',

// ]);

$data=$request->all();

//return $data;

$vendor=explode('|',$request->get('vendor'));

$product=explode('|',$request->get('product_id'));

$vid=$vendor[0];

$vname=$vendor[1];

$vitemid=$request->get('vendor_item_id');

for($i=0;$i<count($product);$i++){

$sdata=[

    "id"=>NULL,

    "vendor_item_id"=>$vitemid,

    "vendor_id"=>$vid,

    "vendor_name"=>$vname,

    "product_id"=>$product,

    "product_name"=>$request->get('product_name')[$i],

    "buying_price"=>0,

    "tax_rate"=>$request->get('tax_rate')[$i],

];

$status=VendorItem::create($sdata);

$id=$status->id;

for($j=0;$j<count($data['attribute_id'][$product]);$j++){

$data1=[

    "id"=>NULL,

    "vendor_item_id"=>@$id,

    "product_id"=>$product,

    "attribute_id"=>$data['attribute_id'][$product][$j],

    "attribute_name"=>$data['attribute_name'][$product][$j],

    "attribute_value"=>$data['attribute_value'][$product][$j],

    "quantity"=>$data['qty'][$product][$j],

    "status"=>$data['status'][$product][$j],

    "buying_price"=>$data['buying_price'][$product][$j],

];

//print_r($data1);

$status1=VendorItemAttribute::create($data1);

}

}

if($status1){

   Session::put('success','Vendor Item create successfully');

    return redirect()->route('vendoritem.index');

}

else{

    return back()->with('error','Data not found');

}

 }

    public function status(Request $request)

    {

    //    dd($request->all());

    if($request->mode=='true'){

        DB::table('vendoritem')->where('id',$request->id)->update(['status'=>'active']);

    }

    else{

        DB::table('vendoritem')->where('id',$request->id)->update(['status'=>'inactive']);

    }

    return response()->json(['msg'=>'Successfully update status','status'=>true]);

    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show(Request $request)

    {

        $id=$request->get('id');

        $vendoritem=VendorItem::where(['id'=>$id])->get();

      $product=Product::where(['id'=>$vendoritem[0]->product_id])->get();

        $vendoritemattribute=VendorItemAttribute::where(['vendor_item_id'=>$id])->get();

        return response()->json(["product"=>$product,"vendordata"=>$vendoritem,"attributedata"=>$vendoritemattribute,'status'=>true]);

    }

    public function getvalues(Request $request)

    {

        $value=$request->get('value');

        $pid=$request->get('pid');

      $product=ProductAttribute::where(['product_id'=>$pid,'arrtibute_value'=>$value])->get();

        return response()->json(["product"=>$product,'status'=>true]);

    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $vendoritem=VendorItem::find($id);

 $vid=$vendoritem->id;

            $vendoritemattribute=VendorItemAttribute::where(["vendor_item_id"=>$vid])->get();

            if($vendoritem){

              return view('backend.vendor-items.vendors-item-edit',compact('vendoritem','vendoritemattribute'));

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

        $data=$request->all();

        $vendoritem=VendorItemAttribute::where(["vendor_item_id"=>$id])->get();

   if($vendoritem){

   for($j=0;$j<count($data['attribute_id'][$request->get('product_id')]);$j++){

$status=VendorItemAttribute::where(["attribute_id"=>$data['attribute_id'][$request->get('product_id')][$j]])->update(["quantity"=>$data['qty'][$request->get('product_id')][$j],"buying_price"=>$data['buying_price'][$request->get('product_id')][$j],"status"=>$data['status'][$request->get('product_id')][$j]]);

                }

if($status){

    Session::put('success','Vendor Item Successfully Updated');

    return redirect()->route('vendoritem.index');

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

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        //

    }

}

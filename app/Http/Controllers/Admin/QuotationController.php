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

use App\Models\PurchaseOrder;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class QuotationController extends Controller

{

    function __construct()

    {

         $this->middleware('permission:Quotation List', ['only' => ['index','store']]);

         $this->middleware('permission:Quotation View', ['only' => ['show']]);

        //  $this->middleware('permission:Warehouse edit', ['only' => ['edit','update']]);

        //  $this->middleware('permission:Warehouse delete', ['only' => ['destroy']]);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $quotation=Quotation::join('purchase','purchase.id','=','quotation.purchase_request_id')->get(['purchase.*','quotation.id as qid','quotation.estimate_date','quotation.estimate_id']);

      return view('backend.purchase.quotations',compact('quotation'));

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

$data['purchase_order_id']=$request->get('purchase_order_id');

$data['purchase_request_id']=$request->get('purchase_request_id');

$data['quotation_id']=$request->get('quotation_id');

$data['order_date']=date('Y-m-d H:i:s');

$data['delivery_date']='';

$data['description']='';

$data['status']='Ordered';

     $status=PurchaseOrder::create($data);

       if($status){

        Session::put('success','Purchase Order create successfully');

        return redirect()->route('purchaseorder.index');

    }

    else{

        return back()->with('error','Data not found');

    }

    }

    /**

     * Display the specified resource.

     *

     * @param  \App\Models\Quotation  $quotation

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        $estimate=Quotation::find($id);

        $prid=$estimate->purchase_request_id;

        $quotation=Purchase::find($prid);

        $pid=$quotation->id;

        $purchaseproduct=PurchaseProduct::where("purchase_request_id","=",$pid)->groupBy('product_id')->get();

        if($quotation){

          return view('backend.purchase.quotations-view',compact('estimate','quotation','purchaseproduct'));

      }

      else{

          return back()->with('error','Data not  found');

      }

    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Models\Quotation  $quotation

     * @return \Illuminate\Http\Response

     */

    public function edit(Quotation $quotation)

    {

        //

    }

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Models\Quotation  $quotation

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)

    {

        $quotation=Quotation::where(['purchase_request_id'=>$id])->update(['estimate_date'=>$request->get('estimate_date'),'status'=>'Approved']);

        if($quotation){

            Session::put('success','Quotation Approved successfully');

            return redirect()->route('quotation.index');

        }

        else{

            return back()->with('error','Data not  found');

        }

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Models\Quotation  $quotation

     * @return \Illuminate\Http\Response

     */

    public function destroy(Quotation $quotation)

    {

        //

    }

}

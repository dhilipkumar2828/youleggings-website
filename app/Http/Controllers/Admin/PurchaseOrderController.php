<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\PurchaseOrder;

use App\Models\Purchase;

use App\Models\PurchaseProduct;

use App\Models\Product;

use App\Models\VendorItem;

use App\Models\VendorItemAttribute;

use App\Models\Coupon;

use App\Models\Vendor;

use App\Models\Quotation;

use App\Models\Invoice;

use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

use PDF;

class PurchaseOrderController extends Controller

{

    function __construct()

    {

        $this->middleware('permission:Purchase Order List', ['only' => ['index','store']]);

        //$this->middleware('permission:Warehouse create', ['only' => ['create','store']]);

        $this->middleware('permission:Purchase Order Edit', ['only' => ['edit','update']]);

        //$this->middleware('permission:Warehouse delete', ['only' => ['destroy']]);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $purchaseorder=PurchaseOrder::join('purchase','purchase.id','=','purchase_order.purchase_request_id')->join('purchaseproduct','purchaseproduct.purchase_request_id','=','purchase_order.purchase_request_id')->groupBy('purchase_order.purchase_request_id')->get(['purchase.*','purchase_order.*',PurchaseOrder::raw('sum(purchaseproduct.buying_price) as total_amount')]);

        return view('backend.purchase.purchase-order',compact('purchaseorder'));

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

        $id=$request->get('id');

        $val=$request->get('val');

        $purchaseorder=PurchaseOrder::find($id);

        if($purchaseorder){

        $data['status']=$val;

        $status=$purchaseorder->fill($data)->save();

    echo "success";

    }

    }

    /**

     * Display the specified resource.

     *

     * @param  \App\Models\PurchaseOrder  $purchaseOrder

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        $purchaseorder=PurchaseOrder::find($id);

        $pid=$purchaseorder->purchase_request_id;

        $purchase=Purchase::find($pid);

        $purchaseproduct=PurchaseProduct::where("purchase_request_id","=",$pid)->groupBy('product_id')->get();

        if($purchaseorder){

          return view('backend.purchase.purchase-order-view',compact('purchase','purchaseorder','purchaseproduct'));

      }

      else{

          return back()->with('error','Data not  found');

      }

    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Models\PurchaseOrder  $purchaseOrder

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $data['purchase_order_id']=$id;

    if(count(Invoice::orderBy('id','DESC')->limit('1')->get('id')) > 0):

        foreach(Invoice::orderBy('id','DESC')->limit('1')->get('invoice_id') as $item):

        $data['invoice_id']="IV-0000".(explode('-',$item->invoice_id)[1]+1);

        endforeach;

    else:

        $data['invoice_id']="IV-00001";

    endif;

    $prid=PurchaseOrder::find($id);

    $prid1=$prid->purchase_request_id;

    $amount=PurchaseProduct::where(['purchase_request_id'=>$prid1])->get(PurchaseProduct::raw('sum(buying_price) as amount'));

    $data['invoice_date']=date('Y-m-d');

        $data['note']='';

        $data['payment']='';

        $data['amount']=$amount[0]['amount'];

        $data['status']='active';

        $link=\App\Http\Controllers\Admin\PurchaseOrderController::savePdfInvoice($data['invoice_id'],$amount[0]['amount'],$prid1);

        $data['invoice_link']=$link;

        $status=Invoice::create($data);

             $lid=$status->id;

               if($status){

                 Session::put('success','Invoice create successfully');

                return redirect()->route('invoice.index');

            }

            else{

                return back()->with('error','Data not found');

            }

    }

    public static function savePdfInvoice($id,$amount,$prid)

{

    $pdetails   = PurchaseOrder::where(["purchase_order.purchase_request_id"=>$prid])->join('purchase','purchase.id','=','purchase_order.purchase_request_id')->join('purchaseproduct','purchaseproduct.purchase_request_id','=','purchase_order.purchase_request_id')->get(['purchase.*','purchase_order.*']);

    $productd= PurchaseProduct::where(['purchase_request_id'=>$prid])->get();

    $taxrate= PurchaseProduct::where(['purchase_request_id'=>$prid])->groupBy('tax_rate')->get();

    $vendor= Vendor::find($pdetails[0]['vendor_id']);

    $amount         = $amount;

     $gstAmount      = $taxrate;

     $totalAmount    = $amount;

    /** first param is the blade template, second param is the array of data need for the invoice */

    $pdf = PDF::loadView('backend.purchase.pdf-invoice', [

        'invoicedetail'       => $pdetails,

        'productdetail' =>$productd,

        'invoiceid'=>$id,

        'vendor'=>$vendor,

        'userDetails'   => '',

        'amount'        => $amount,

         'gstAmount'     => $gstAmount,

         'totalAmount'   => $totalAmount,

    ]);

    /** Creating the unique name for pdf */

    $invoiceName = $id.'-'.time().'_'.date('Y-m-d').'.pdf';

    /** Save the PDF to /public/uploads/invoices/ folder */

    $pdf->save(public_path('uploads/invoices/'. $invoiceName));

   // $pdf->stream(public_path('uploads/invoices/'. $invoiceName));

    return $invoiceName;

}

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Models\PurchaseOrder  $purchaseOrder

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)

    {

        $purchaseorder=PurchaseOrder::find($id);

        if($purchaseorder){

        $data['delivery_date']=$request->get('delivery_date');

        $data['description']=$request->get('description');

        $status=$purchaseorder->fill($data)->save();

        }

        if($status){

           Session::put('success','Purchase Order Update successfully');

            return redirect()->route('purchaseorder.index');

        }

        else{

            return back()->with('error','Data not  found');

        }

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Models\PurchaseOrder  $purchaseOrder

     * @return \Illuminate\Http\Response

     */

    public function destroy(PurchaseOrder $purchaseOrder)

    {

        //

    }

}

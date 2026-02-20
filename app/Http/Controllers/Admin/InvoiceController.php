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

class InvoiceController extends Controller

{

     function __construct()

  {

       $this->middleware('permission:Invoice List', ['only' => ['index']]);

      // $this->middleware('permission:vendoritem create', ['only' => ['create','store']]);

       $this->middleware('permission:Invoice Edit', ['only' => ['edit','update']]);

       //$this->middleware('permission:vendoritem delete', ['only' => ['destroy']]);

  }

 /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $invoice=Invoice::join('purchase_order','purchase_order.id','=','invoice.purchase_order_id')->join('purchaseproduct','purchaseproduct.purchase_request_id','=','purchase_order.purchase_request_id')->join('purchase','purchase.id','=','purchase_order.purchase_request_id')->groupBy('purchase_order.purchase_request_id')->get(['purchase.*','purchase_order.*','purchase_order.purchase_order_id as purchase_id','invoice.*',PurchaseOrder::raw('sum(purchaseproduct.buying_price) as total_amount')]);

        return view('backend.purchase.invoice',compact('invoice'));

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        //

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        //

    }

    /**

     * Display the specified resource.

     *

     * @param  \App\Models\invoice  $invoice

     * @return \Illuminate\Http\Response

     */

    public function show(invoice $invoice)

    {

        //

    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Models\invoice  $invoice

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $invoice=Invoice::find($id);

        $poid=$invoice->purchase_order_id;

        $purchaseorder=PurchaseOrder::find($poid);

        $pid=$purchaseorder->purchase_request_id;

        $purchase=Purchase::find($pid);

        $purchaseproduct=PurchaseProduct::where("purchase_request_id","=",$pid)->groupBy('product_id')->get();

        if($purchaseorder){

          return view('backend.purchase.invoice_view',compact('purchase','purchaseorder','purchaseproduct','invoice'));

      }

      else{

          return back()->with('error','Data not  found');

      }

    }

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Models\invoice  $invoice

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request,$id)

    {

        $invoice=Invoice::find($id);

        if($invoice){

     $data['payment']=$request->get('invoice_payment');

        $data['note']=$request->get('invoice_note');

        $status=$invoice->fill($data)->save();

        }

        if($status){

           Session::put('success','Invoice Update successfully');

           return redirect()->route('invoice.index');

        }

        else{

            return back()->with('error','Data not  found');

        }

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Models\invoice  $invoice

     * @return \Illuminate\Http\Response

     */

    public function destroy(invoice $invoice)

    {

        //

    }

    public static function savePdfInvoice($id)

{

    $priceDetails   = Invoice::find($id);

    $amount         = $priceDetails['amount'];

    // $gstAmount      = $priceDetails['gstAmount'];

    // $totalAmount    = $priceDetails['totalAmount'];

    /** first param is the blade template, second param is the array of data need for the invoice */

    $pdf = PDF::loadView('backend.purchase.pdf-invoice', [

        'project'       => $id,

        'userDetails'   => '',

        'amount'        => $amount,

        // 'gstAmount'     => $gstAmount,

        // 'totalAmount'   => $totalAmount,

    ]);

    /** Creating the unique name for pdf */

    $invoiceName = $priceDetails->unique_id.'-'.time().'_'.date('Y-m-d').'.pdf';

    /** Save the PDF to /public/uploads/invoices/ folder */

    $pdf->save(public_path('uploads/invoices/'. $invoiceName));

}

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Shipping;

use App\Models\Order;

use App\Models\Sales;

use App\Models\OrderProduct;

use App\Models\CustomerTable;

use App\Models\Category;

use App\Models\Vendor;

use App\Models\Product;

use App\Models\ProducteAttribute;

use PDF;

use DB;

use App\Models\Purchase;

use App\Models\PurchaseProduct;

use App\Models\PurchaseOrder;

use App\Models\Inventory;

use App\Models\InventoryProduct;

use Illuminate\Http\Request;

class ReportController extends Controller

{

    function __construct()

    {

         $this->middleware('permission:Sales Report List', ['only' => ['index','productsalesreport']]);

         $this->middleware('permission:Product Sales Report List', ['only' => ['productpurchasereport']]);

         $this->middleware('permission:Product Purchase Report List', ['only' => ['productstockreport']]);

         $this->middleware('permission:Product Stock Report List', ['only' => ['taxreport']]);

         $this->middleware('permission:Expense Report List', ['only' => ['expensereport']]);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $salesreport=Order::get();

        $customer_name=Order::join('customer','orders.customer_id','=','customer.id')->get(['customer.name']);

        $qty=Order::join('order_products','orders.id','=','order_products.order_id')->groupBy('order_products.order_id')->get(DB::raw("SUM(quantity) as quantity"));

        $productjoin=OrderProduct::join('products','order_products.product_id','=','products.id')->get(['products.vendor_id']);

        return view('backend.report.sales-report',compact('salesreport','customer_name','qty'));

    }

    public function productsalesreport()

    {

        $salesproductreport=Order::join('order_products','order_products.order_id','=','orders.id')->join('products','products.id','=','order_products.product_id')->get(['order_products.*','orders.order_id','orders.status','products.*']);

       $products=OrderProduct::join('products','order_products.product_id','=','products.id')->get(['order_products.product_id']);

       $stock=OrderProduct::join('products','order_products.product_id','=','products.id')->get(['products.*']);

       $stock_cnt=array();

       foreach($stock as $s){

          $value=OrderProduct::where('product_id','=',$s->id)->count();

          array_push($stock_cnt,$value);

       }

       return view('backend.report.product-sales-report',compact('salesproductreport','stock','stock_cnt'));

    }

    public function productpurchasereport()

    {

        $purchaseproductreport=PurchaseOrder::join('purchaseproduct','purchaseproduct.purchase_request_id','=','purchase_order.purchase_request_id')->get();

        return view('backend.report.product-purchase-report',compact('purchaseproductreport'));

    }

    public function productstockreport()

    {

        $productstockreport=Inventory::join('inventoryproduct','inventoryproduct.inventory_id','=','inventory.id')->join('warehouse','warehouse.id','=','inventory.warehouse')->get();

        return view('backend.report.product-stock-report',compact('productstockreport'));

    }

    public function taxreport()

    {

        return view('backend.report.tax-report');

    }

    public function expensereport()

    {

        $product=Product::get();

        $month=['01','02','03','04','05','06','07','08','09','10','11','12'];

        $data=[];

        foreach($product as $item){

          $year_total=$overall_total_exc=$overall_total_tax=$overall_total_inc=0;

            for($i=0;$i<count($month);$i++){

$producttotal=OrderProduct::whereMonth('created_at','=',$month[$i])->where(['product_id'=>$item->id])->get([OrderProduct::raw('sum((order_products.amount/100)*order_products.tax_rate) as tax_price'),OrderProduct::raw('sum(order_products.amount) as amount'),OrderProduct::raw('sum(order_products.total_tax) as total_tax'),OrderProduct::raw('sum(order_products.tax_rate) as tax_rate')]);

@$year_total +=(int)$producttotal[0]['amount'];

if(empty($data[$item->title])){

@$data['product'][$item->title][$month[$i]]=(int)$producttotal[0]['amount'];

if($i == 11){

@$data['product'][$item->title]['year_total']=$year_total;

}

}

else{

    @$data['product'][$item->title][$month[$i]]+=(int)$producttotal[0]['amount'];

    if($i == 11){

    @$data['product'][$item->title]['year_total']+=$year_total;

    }

}

@$overall_total_exc +=(int)$producttotal[0]['amount'];

@$overall_total_tax +=(int)$producttotal[0]['tax_price'];

@$overall_total_inc +=(int)$producttotal[0]['total_tax'];

if(empty($data['total_exc'])){

@$data['total_exc'][$month[$i]]=$producttotal[0]['amount'];

@$data['total_tax'][$month[$i]]=$producttotal[0]['tax_price'];

@$data['total_inc'][$month[$i]]=$producttotal[0]['total_tax'];

//overall total

if($i == 11){

@$data['total_exc']['overall_total_exc']=$overall_total_exc;

@$data['total_tax']['overall_total_tax']=$overall_total_tax;

@$data['total_inc']['overall_total_inc']=$overall_total_inc;

}

}

else{

    @$data['total_exc'][$month[$i]]+=$producttotal[0]['amount'];

    @$data['total_tax'][$month[$i]]+=$producttotal[0]['tax_price'];

    @$data['total_inc'][$month[$i]]+=$producttotal[0]['total_tax'];

    //overall total

    if($i == 11){

@$data['total_exc']['overall_total_exc']+=$overall_total_exc;

@$data['total_tax']['overall_total_tax']+=$overall_total_tax;

@$data['total_inc']['overall_total_inc']+=$overall_total_inc;

}

}

}

    }

    return view('backend.report.expense-report',compact('data'));

    }

    public function expensepdf(Request $request)

    {

        $bodydata=$request->get('data');

         $pdf = PDF::loadView('backend.report.expense-pdf',['bodydata'=>$bodydata]);

    //     /** Creating the unique name for pdf */

         $invoiceName = 'expense-report-'.time().'_'.date('Y-m-d').'.pdf';

    //     /** Save the PDF to /public/uploads/invoices/ folder */

         $pdf->save(public_path('uploads/expensepdf/'. $invoiceName));

    //    // $pdf->stream(public_path('uploads/invoices/'. $invoiceName));

    //  return $invoiceName;

     //  return   $pdf->download($invoiceName);

       echo 'uploads/expensepdf/'. $invoiceName;

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

     * @param  \App\Models\Report  $report

     * @return \Illuminate\Http\Response

     */

    public function show(Report $report)

    {

        //

    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Models\Report  $report

     * @return \Illuminate\Http\Response

     */

    public function edit(Report $report)

    {

        //

    }

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Models\Report  $report

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, Report $report)

    {

        //

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Models\Report  $report

     * @return \Illuminate\Http\Response

     */

    public function destroy(Report $report)

    {

        //

    }

}

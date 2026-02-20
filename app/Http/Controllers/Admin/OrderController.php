<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Reason;
use App\Models\BillingAddress;
use App\Models\ShippingAddress;
use App\Models\Transaction;
use Illuminate\Support\Facades\Session;
use App\Models\OrderProduct;
use App\Traits\PriceTrait;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use PDF;

class OrderController extends Controller
{
        use PriceTrait;
      function __construct()
    {
         $this->middleware('permission:all_orders-view', ['only' => ['create']]);
         $this->middleware('permission:all_orders-edit|recieved_orders-edit|confirmed_orders-edit|processing_orders-edit|delivered_orders-edit|filter', ['only' => ['view_detail']]);
         $this->middleware('permission:recieved_orders-view', ['only' => ['pending']]);
         $this->middleware('permission:confirmed_orders-view', ['only' => ['confirmed']]);
         $this->middleware('permission:processing_orders-view', ['only' => ['progress']]);
         $this->middleware('permission:delivered_orders-view', ['only' => ['deliver']]);

        //  $this->middleware('permission:Return List', ['only' => ['return']]);
        //  $this->middleware('permission:Return View', ['only' => ['view_detail']]);
        //  $this->middleware('permission:Cancel List', ['only' => ['cancel']]);
        //  $this->middleware('permission:Cancel View', ['only' => ['view_detail']]);
        //  $this->middleware('permission:COD List', ['only' => ['cod']]);
        //  $this->middleware('permission:COD View', ['only' => ['view_detail']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
        $searchTerm = $request->get('search');
        $perPage = $request->get('per_page', 25);
        $order = Order::query();

         $order = Order::leftJoin('payments', 'payments.order_id', 'orders.id')
             ->leftJoin('billing_address', 'billing_address.order_id', 'orders.id')

             ->selectRaw('orders.*, payments.payment_id, billing_address.first_name as billing_first_name,billing_address.phone_number as billing_phone_number'
);

            //  $order = Order::query()
            //  ->leftJoin('billing_address', 'orders.order_id', '=', 'billing_address.first_name')
            //  ->select('orders.*', 'billing_address.first_name as first_name');

             if ($searchTerm) {
                $order = $order->where(function ($query) use ($searchTerm) {
                    $query->where('orders.order_id', 'LIKE', '%' . $searchTerm . '%')
                          ->orWhere('orders.tracking_id', 'LIKE', '%' . $searchTerm . '%')
                          ->orWhere('orders.payment_type', 'LIKE', '%' . $searchTerm . '%')
                          ->orWhere('orders.payment_status', 'LIKE', '%' . $searchTerm . '%')
                          ->orWhere('billing_address.first_name', 'LIKE', '%' . $searchTerm . '%')
                          ->orWhere('billing_address.phone_number', 'LIKE', '%' . $searchTerm . '%')

                          ->orWhere('orders.total', 'LIKE', '%' . $searchTerm . '%');
                });
            }

            $order = $order->orderBy('orders.id', 'DESC')->paginate($perPage)->withQueryString();

         $orderDetails = OrderProduct::groupBy('order_id')->selectRaw('sum(quantity) as cnt, order_id')->get()->keyBy('order_id');

         $status = 'all';
         return view('backend.order.orders', compact('order', 'orderDetails', 'status'));
     }

     public function filter(Request $request, $status)
     {
         $perPage = $request->get('per_page', 25); // Default to 10 if not set

         $order = Order::query();

         $order = Order::leftJoin('payments', 'payments.order_id', 'orders.id')
             ->leftJoin('billing_address', 'billing_address.order_id', 'orders.id')

             ->selectRaw('orders.*, payments.payment_id, billing_address.first_name as billing_first_name,billing_address.phone_number as billing_phone_number'
);

         $searchTerm = $request->get('search');
         if ($searchTerm) {
            $order = $order->where(function ($query) use ($searchTerm) {
                $query->where('orders.order_id', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('orders.tracking_id', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('orders.payment_type', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('orders.payment_status', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('billing_address.first_name', 'LIKE', '%' . $searchTerm . '%')
                      ->orWhere('billing_address.phone_number', 'LIKE', '%' . $searchTerm . '%')

                      ->orWhere('orders.total', 'LIKE', '%' . $searchTerm . '%');
            });
        }

         $order = $order->where('orders.payment_status', $status)->orderBy('orders.id', 'desc')->paginate($perPage)->withQueryString();

         $orderDetails = OrderProduct::groupBy('order_id')->selectRaw('sum(quantity) as cnt, order_id')->get()->keyBy('order_id');

         return view('backend.order.orders', compact('order', 'orderDetails', 'status'));
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $order=Order::get();
        return view('backend.order.orders',compact('order'));
    }

    public function progress(Request $request)
    {
                /*
                $id="24";
                $text_message="https://prrayashacollections.com/".$id;
                $key = "8cnx5PVTXSCKxjZy";
                $mbl = "8015203449";
                $firstname="sabari";
                $tracking_id="1032";
                $message_content = "Hi {#var#}.Good things are on their way: your order was just shipped! You can track your order here {#var#} with this tracking Number {#var#}- PRRAYASHACOLLECTIONS.";
                $message_content = preg_replace('/\{#var#\}/', $firstname, $message_content, 1);
                $message_content = preg_replace('/\{#var#\}/',$text_message, $message_content, 1);
                 $message_content = preg_replace('/\{#var#\}/', $tracking_id, $message_content, 1);

                $encoded_message_content = urlencode($message_content);
                $senderid = "PRRCOL";
                $route = "1";
                $templateid = "1707172060259475222";
                $url = "https://sms.textspeed.in/vb/apikey.php?apikey=$key&senderid=$senderid&templateid=$templateid&number=$mbl&message=$encoded_message_content";
                $output = file_get_contents($url);
                print_r($url);die;
                */

        $order=Order::where(['status'=>'Processing'])->where('payment_status','paid');

        $searchTerm =  $request->get('search');
        $order = $order->where(function ($query) use ($searchTerm) {
            $query->where('orders.order_id', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('orders.tracking_id', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('orders.total', 'LIKE', '%' . $searchTerm . '%');
        });

        $order = $order->orderBy('orders.id','desc')->paginate(10);
        return view('backend.order.progress',compact('order'));
    }
    public function cancel(Request $request)
    {

         $order=Order::where(['status'=>'Cancelled']);

        $searchTerm =  $request->get('search');
        $order = $order->where(function ($query) use ($searchTerm) {
            $query->where('orders.order_id', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('orders.tracking_id', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('orders.total', 'LIKE', '%' . $searchTerm . '%');
        });

        $order = $order->orderBy('orders.id','desc')->paginate(10);

        return view('backend.order.cancel',compact('order'));
    }
    public function pending(Request $request)
    {
      //  $user=(Auth::user()->roles[0]->id == 1) ?['1',$this->userid] : [$this->userid];

          $order=Order::where(['status'=>'received']);

        $searchTerm =  $request->get('search');
        $order = $order->where(function ($query) use ($searchTerm) {
            $query->where('orders.order_id', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('orders.tracking_id', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('orders.total', 'LIKE', '%' . $searchTerm . '%');
        });

        $order = $order->orderBy('orders.id','desc')->paginate(10);

        return view('backend.order.pending',compact('order'));
    }
    public function cod()
    {
        $order=Order::where(['status'=>'COD'])->orderBy('orders.id','desc')->get();
        return view('backend.order.cod',compact('order'));
    }
    public function return()
    {
        $order=Order::where(['status'=>'Returned'])->orderBy('orders.id','desc')->get();
        return view('backend.order.return',compact('order'));
    }
    public function confirmed()
    {
        $order=Order::where(['status'=>'Confirmed'])->orderBy('orders.id','desc')->get();
        return view('backend.order.confirmed',compact('order'));
    }
  public function deliver()
    {
        $order = Order::where('status', 'Delivered')
                        ->orderBy('orders.id', 'desc')
                        ->paginate(10);

        return view('backend.order.deliver', compact('order'));
    }
    //  public function cash_on()
    // {
    //     $order=Order::where(['status'=>'COD'])->orderBy('orders.id','desc')->get();
    //     return view('backend.order.cod',compact('order'));
    // }
     public function view_detail($id)
    {
        $id=$id;
        $data=OrderProduct::where('order_id',$id)->get();

        $discount_amt=array();
        $product_name=array();
        $deleted_products = array(); // To track deleted products
        $deactivated_products = array();

        foreach($data as $key=>$d){
            // $product=DB::table('products')->where('id',$d->product_id)->first();

            $product=DB::table('products')->where('id',$d->product_id)->first();

            $product = Product::withTrashed()->find($d->product_id);

            if (!$product) {
                // Handle case where product is completely missing from database
                $deleted_products[] = [
                    'product_id' => $d->product_id,
                    'message' => 'This product has been permanently deleted.'
                ];
                $product_name[] = 'Unknown Product (Deleted)';
                $data[$key]['discount_value'] = 0;
                array_push($discount_amt, 0);
                continue;
            }

            // If the product is soft-deleted, set the alert and proceed
            if ($product->trashed()) {
                $deleted_products[] = [
                    'product_id' => $d->product_id,
                    'message' => 'This product has been deleted.'
                ];
                $product_name[] = $product->name . ' (Deleted)';
            } elseif ($product->status == 'inactive') {
                // If the product is deactivated, show the deactivation alert
                $deactivated_products[] = [
                    'product_id' => $d->product_id,
                    'message' => 'This product has been deactivated.'
                ];
                $product_name[] = $product->name . ' (Deactivated)';
            } else {
                // If product is not deleted or deactivated, process it normally
                $product_name[] = $product->name;

            $product_variant=DB::table('product_variants')->where('product_id',$d->product_id)->where('variants',$d->option)->first();
            array_push($product_name,$product->name);
            if($product->discount_type == "fixed"){
                $data[$key]['discount_value']=$product->discount;
            }else{
                $discount= $this->fetchSalePrice($product_variant->regular_price,$product->tax_id,$product->discount,$product->discount_type);
                $data[$key]['discount_value']=$discount['discount_price'];
            }
            array_push($discount_amt,$data[$key]['discount_value']);
        }
    }

        $order=Order::find($id);

      $billing_address=BillingAddress::where('order_id',$id)->first();
        $shipping_address=ShippingAddress::where('order_id',$id)->first();

        if(isset($billing_address)){
        $state=DB::table('state_list')->where('id',$billing_address->state)->first();
        }else{
            $state='';
        }

        $delivery_charge = ($order->deliver_charge == '' || $order->deliver_charge == 'NULL') ? 0.00 : $order->deliver_charge;

        if($order){

               if(isset($_REQUEST['status']) && $_REQUEST['status']=="paid"){

                  $previousOrder = Order::where('id', '<', $id)->where('payment_status','paid')->max('id');
            $nextOrder = Order::where('id', '>', $id)->where('payment_status','paid')->min('id');

    } else if(isset($_REQUEST['status']) && $_REQUEST['status']=="unpaid"){
          $previousOrder = Order::where('id', '<', $id)->where('payment_status','unpaid')->max('id');
            $nextOrder = Order::where('id', '>', $id)->where('payment_status','unpaid')->min('id');

    } else {
               $previousOrder = Order::where('id', '<', $id)->max('id');
            $nextOrder = Order::where('id', '>', $id)->min('id');
    }

       return view('backend.order.view-detail',compact('id','discount_amt','product_name','delivery_charge','state','order','data','billing_address','shipping_address','nextOrder','previousOrder','deleted_products','deactivated_products'));
        }
    }

    public function pdf($id){
        $data=OrderProduct::where('order_id',$id)->get();

        $discount_amt=array();
        $product_name=array();
        foreach($data as $key=>$d){
            $product=DB::table('products')->where('id',$d->product_id)->first();
            $product_variant=DB::table('product_variants')->where('product_id',$d->product_id)->where('variants',$d->option)->first();
            array_push($product_name,$product->name);
            if($product->discount_type == "fixed"){
                $data[$key]['discount_value']=$product->discount;
            }else{
                $discount= $this->fetchSalePrice($product_variant->regular_price,$product->tax_id,$product->discount,$product->discount_type);
                $data[$key]['discount_value']=$discount['discount_price'];
            }
            array_push($discount_amt,$data[$key]['discount_value']);
        }

        $order=Order::find($id);

        $billing_address=BillingAddress::where('order_id',$id)->first();
        $shipping_address=ShippingAddress::where('order_id',$id)->first();
        if(isset($billing_address)){
        $state=DB::table('state_list')->where('id',$billing_address->state)->first();
        }else{
            $state='';
        }

        $delivery_charge = ($order->deliver_charge == '' || $order->deliver_charge == 'NULL') ? 0.00 : $order->deliver_charge;

        if($order){
       return view('backend.order.pdf',compact('discount_amt','product_name','delivery_charge','state','order','data','billing_address','shipping_address'));
        }
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
    public function reasonStatus(Request $request)
    {
    //    dd($request->all());
    if($request->mode=='true'){
        DB::table('reasons')->where('id',$request->id)->update(['status'=>'active']);
    }
    else{
        DB::table('reasons')->where('id',$request->id)->update(['status'=>'inactive']);
    }
    return response()->json(['msg'=>'Successfully update status','status'=>true]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $order=Order::find($id);
        $delivery_charge=2.00;
        if($order){
            return view('backend.order.view-detail',compact('order','delivery_charge'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function orderstatus(Request $request)
    {
        //return $request->input('order_id');
       // $order=Order::find($id);
        //$order=Order::find($id);
        // $this->validate($request,[
        //     'status'=>'in:Pending,Confirmed,Processing,Delivered,Returned,Cancelled',
        //     'payment_status'=>'in:paid,unpaid',
        // ]);
        $order=Order::find($request->get('order_id'));

        if($order){
            // if($request->get('status')=='delivered'){
            //     foreach($order->products as $item){
            //         $product=Product::where('id',$item->pivot->product_id)->first();
            //         $stock=$product->stock;
            //         $stock -=$item->pivot->quantity;
            //         $product->update(['stock'=>$stock]);

            //     }
            // }

             DB::table('orders')->where('id',$order->id)->update(['tracking_id'=>$request->tracking_id]);

            if($request->status=="Delivered"){

                $tracking_id = $request->tracking_id;
                $customer = DB::table('shipping_address')->where('order_id', $order->id)->first();
                $firstname = $customer->sfirst_name;
                $sphone_number = $customer->sphone_number;
                /*$url_shortener = DB::table('url_shortener')->where('order_id', $order->id)->first();
                if($url_shortener){
                    $k=$url_shortener->shortened_url;
                   $url1="https://taslim.oceansoftwares.in/url.php";

                }else{
                    $url1='';
                }
                */

                $id=$order->id;
                // $text_message="https://prrayashacollections.com/".$id;
                // $text_message = "t.ly/BTfxA?id=".$id;
                // $text_message = "tinyurl.com/2wrmt8xn?id=".$id;
                // $text_message = "rb.gy/uqo7g5?id=".$id;
                $text_message = "bit.ly/prrshipp";

                $key = "8cnx5PVTXSCKxjZy";
                $mbl = $sphone_number;
                //$firstname="sabari";
               // $tracking_id="1032";
                $message_content = "Hi {#var#}.Good things are on their way: your order was just shipped! You can track your order here {#var#} with this tracking Number {#var#}- PRRAYASHACOLLECTIONS.";
                $message_content = preg_replace('/\{#var#\}/', $firstname, $message_content, 1);
                $message_content = preg_replace('/\{#var#\}/',$text_message, $message_content, 1);
                 $message_content = preg_replace('/\{#var#\}/', $tracking_id, $message_content, 1);

                    $encoded_message_content = urlencode($message_content);
                    $senderid = "PRRCOL";
                    $route = "1";
                    $templateid = "1707172060259475222";
                    $url = "https://sms.textspeed.in/vb/apikey.php?apikey=$key&senderid=$senderid&templateid=$templateid&number=$mbl&message=$encoded_message_content";
                 try {
                     $context = stream_context_create(array(
    'http' => array('ignore_errors' => true),
));
                    $output = file_get_contents($url, false, $context);
                } catch(Exception $e) {

                }

                //print_r($url);die;

                /*
                $text_message="prrayashacollections.com/public/order_pdf/{$order->id}";
                $key = "8cnx5PVTXSCKxjZy";
                $mbl = $sphone_number;

                $message_content = "Hi {#var#}.Good things are on their way: your order was just shipped! You can track your order here {#var#} with this tracking Number {#var#}- PRRAYASHACOLLECTIONS.";
                $message_content = preg_replace('/\{#var#\}/', $firstname, $message_content, 1);
                $message_content = preg_replace('/\{#var#\}/',$text_message, $message_content, 1);
                 $message_content = preg_replace('/\{#var#\}/', $tracking_id, $message_content, 1);

                $encoded_message_content = urlencode($message_content);
                $senderid = "PRRCOL";
                $route = "1";
                $templateid = "1707172060259475222";
                $url = "https://sms.textspeed.in/vb/apikey.php?apikey=$key&senderid=$senderid&templateid=$templateid&number=$mbl&message=$encoded_message_content";
                $output = file_get_contents($url);

               //print_r($message_content);die;
               */
            }
            $datas = Order::where('id',$request->get('order_id'))->update(['payment_status'=>$request->get('payment_status'),'status'=>$request->get('status')]);

            //$status=Order::where('id',$request->get('order_id'))->update(['status'=>$request->get('status')]);
            Transaction::where('order_id',$request->get('order_id'))->update(['transaction_status'=>$request->get('status')]);
            //$status=$order->fill($data)->save();
             if($datas){
                Session::put('success','Order successfully updated');
                // return redirect()->route('order.index');
                 return redirect()->route('view_detail',[$order->id]);
            }
            else{
                Session::put('error','Error, Please try again');
            }
        }
    // $data=$request->all();
    //    $status=Order::where('id',$request->get('order_id'))->update(['status'=>get('status')]);
    //     //$status=$order->fill($data)->save();
    //     if($status){
    //         request()->session()->flash('success','Order successfully updated');
    //     }
    //     else{
    //         request()->session()->flash('error','Error, Please try again');
    //     }
    //     return redirect()->route('order.index');
    }

   public function notifications(Request $req)
   {

               $curr_date=date('Y-m-d');
               $new_order = DB::table('orders')->select('orders.*','products.title','products.photo','order_products.amount','order_products.quantity')
               ->join('order_products', 'orders.id', '=', 'order_products.order_id')
               ->join('products', 'products.id', '=', 'order_products.product_id')
               ->where('orders.created_at','like',$curr_date.'%')
               ->get();
               $noti_count=count($new_order);
               $reqd['notifi_count']=$noti_count;
               $reqd['new_order']=$new_order;
               //echo json_encode($reqd);
   }

   public function suborders(Request $request){
    $suborders=DB::table('suborders')->orderBy('id','desc')->get();
    $total_amt=0;
$sum_arr=array();
foreach($suborders as $order){
    $get_amt=DB::table('suborders_items')->select(DB::raw('sum(amount) as amount'))->where('suborders_id',$order->id)->first();
    $total_amt =$get_amt->amount;
    array_push($sum_arr,$total_amt);
}

    if($request->type=="edit"){
        $edit_suborders=DB::table('suborders')->where('id',$request->id)->first();
        $get_customer=DB::table('customer')->where('id',$edit_suborders->customer_id)->first();
        $get_vendor=DB::table('vendor')->where('id',$edit_suborders->vendor_id)->first();
        return response()->json(['edit_suborders'=>$edit_suborders,'get_customer'=>$get_customer,'get_vendor'=>$get_vendor]);
    }

    return view('backend.suborders.suborders',compact('suborders','sum_arr'));
   }

      public function suborders_items(Request $request,$id){
        $sub_orders=DB::table('suborders')->where('id',$id)->first();
        $suborders_items=DB::table('suborders_items')->where('suborders_id',$id)->get();
        $suborders=DB::table('suborders_items')->where('suborders_id',$id)->first();
        $data=OrderProduct::where('order_id',$suborders->order_id)->get();
        $order=Order::find($suborders->order_id);
        $reason=Reason::orderBy('order_id','desc')->get();
        return view('backend.suborders.suborders_items',compact('sub_orders','suborders_items','order','data','reason'));
        }

   public function update_suborders(Request $request){
   DB::table('suborders')->where('id',$request->id)->update(['payment_status'=>$request->payment_status,'status'=>$request->status]);
   return redirect()->back()->with('message', 'Updated Successfully');
   }

   public function approve_request(Request $request){
   DB::table('order_products')->where('id',$request->order_productsid)->update(['status'=>"Cancelled",'cancellation_fee'=>$request->cancellation_fee]);
   // DB::table('suborders_items')->where('id',$request->suborders_id)->update(['status'=>"Cancelled",'cancellation_fee'=>$request->cancellation_fee]);
    return response()->json(['msg'=>'Updated Successfully']);
}

    public function pdfdownload(Request $request){

        $pdf = PDF::loadView('backend.order.pdf');
        return $pdf->download();
    }
    public function deleteOrders(Request $request)
    {
        $orderIds = $request->input('order_ids');
        if ($orderIds) {
            Order::whereIn('id', $orderIds)->delete();
            return redirect()->back()->with('success', 'Selected orders have been deleted.');
        }

        return redirect()->back()->with('error', 'No orders selected.');
    }

}

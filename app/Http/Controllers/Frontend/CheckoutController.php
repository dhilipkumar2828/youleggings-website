<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Str;
use Session;
use Cart;
use Redirect;
use App\Models\User;
use Mail;
use App\Mail\OrderMail;
use App\Models\Usedcoupon;
use App\Models\Shipping;
use App\Models\Payment;
use App\Models\Coupon;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Banner;
use App\Models\Suborders;
use App\Models\Subordersitems;
use App\Models\Sales;
use App\Models\BillingAddress;
use App\Models\OrderProduct;
use App\Traits\PriceTrait;
use App\Traits\CouponTrait;
use App\Models\CustomerTable;
use App\Models\Product;
use App\Models\CartTable;
use App\Models\ProductAttribute;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use App\Traits\SMSTrait;
use Illuminate\Support\Facades\Log;
use App\Models\Guest;

class CheckoutController extends Controller
{
    use PriceTrait;
    use SMSTrait;
    public function checkout1()
    {
        $this->sessionremove();
        $paymentmethod = PaymentMethod::where("status", "on")->get();

        /*
        $fullname1 = "https://taslim.oceansoftwares.in/url.php";
        $shorturl = "https://taslim.oceansoftwares.in/url.php?id=k";
        $fullname = "sabari";
        $key = "8cnx5PVTXSCKxjZy";
        $mbl = "8015203449";
        $message_content = "Hi {#var#}, We are so glad that you placed an order with us! Here's your e-bill with order details Bill {#var#}. We will share the tracking link once it's shipped. PRRCOL";

        // Replace the first occurrence of {#var#} with $fullname1
       // $message_content = preg_replace('/\{#var#\}/', $fullname1, $message_content, 1);

        // Replace the remaining occurrence(s) of {#var#} with $fullname
        $message_content = str_replace('{#var#}', $shorturl, $message_content);

        // URL encode the message content
        $encoded_message_content = urlencode($message_content);

        $senderid = "PRRCOL";
        $route = "1";
        $templateid = "1707171887562080754";
        $url = "https://sms.textspeed.in/vb/apikey.php?apikey=$key&senderid=$senderid&templateid=$templateid&number=$mbl&message=$encoded_message_content";

        // Get the output from the URL
        $output = file_get_contents($url);

        // Optionally, you can debug the output
         var_dump($output);
           print_r($output);die;

        */

        if (Auth::guard('users')->check()) {
            $user = Auth::guard('users')->user();

        } elseif (Auth::guard('guest')->check()) {

            $user = Auth::guard('guest')->user();
            $carts = Session::get('cart',[]);

            if(!empty($carts)){
                foreach($carts as $key => $cart){
                    $duplicate_check=DB::table('cart_tables')->where('product_varient',$cart['product_varients_id'])->where('customer_id',$user->id)->where('type',2)->first();
                    if(empty($duplicate_check)){
                        $data=new CartTable;
                        $data->product_id = $cart['product_id'];
                        $data->product_name = $cart['product_name'];
                        $data->product_qty = $cart['product_qty'];
                        $data->product_color = $cart['product_color'];
                        $data->product_varient = $cart['product_varients_id'];
                        $data->price = $cart['price'];
                        $data->arrtibute_name=$cart['variant'];
                        $data->status = 'active';
                        $data->customer_id = $user->id;
                        $data->type = 2;
                        $data->save();
                    }
                }
            }

        } else {
            return redirect()->route('user.auth');
        }

     $products=DB::table('cart_tables')->select('cart_tables.*')->Join('product_variants','product_variants.id','cart_tables.product_varient')->where('product_variants.in_stock','>',0)->where('customer_id',$user->id)->get();

        // $products = DB::table('cart_tables')
        //     ->where('customer_id', $user->id)
        //     ->where('status', 'active')
        //     ->get();

        $states = DB::table('state_list')->pluck('state', 'id', 'shipping_charge');

        $tamilnadu_shiprate = DB::table('state_list')
            ->where('state', 'TAMIL NADU')
            ->first();

        $sub_amt = 0;
        $minimum_amt = 500;
        $sale_price = [];
        foreach ($products as $pro) {
            $product = Product::where('id', $pro->product_id)
                ->where('status', 'active')
                ->first();

            if ($product) {
                $product_variant = DB::table('product_variants')
                    ->where('product_id', $product->id)
                    ->where('variants', $pro->arrtibute_name)
                    ->first();

                if ($product_variant) {
                    $saleprice = $this->fetchSalePrice($product_variant->regular_price, $product->tax_id, $product->discount, $product->discount_type);
                    array_push($sale_price, $saleprice['sale_price']);
                    $sub_amt += number_format($pro->price, 2, '.', '') * $pro->product_qty;
                }
            }
        }

        $gsttax = DB::table('taxes')->where('id', 1)->first();
        $shipping = 0;

        if ($tamilnadu_shiprate->id == 31) {
            $shipping = $sub_amt / 100 * $gsttax->percentage;
        } else {
            $shipping = $sub_amt / 100 * $gsttax->percentage1;
        }

        $coupon = Session::get('coupon', []);

        if (count($coupon) > 0) {
            $amt = (($sub_amt) * $coupon['discount'] / 100);
            $totalAmount = ($shipping + $sub_amt) - $amt;
        } else {
            $totalAmount = $shipping + $sub_amt;
        }

        $deliverycharges = '';
        $deliverydetails = DB::table('shippingcharges')
            ->where('from', '<=', $sub_amt)
            ->where('to', '>=', $sub_amt)
            ->first();

        if (!empty($deliverydetails)) {
            $deliverycharges = $deliverydetails->amount;
        }

        $carts = CartTable::where('status', 'active')
            ->where('customer_id', $user->id)
            ->get();

        $billing_address = BillingAddress::where('customer_id', $user->id)
            ->orderBy('id', 'desc')
            ->first();

        $shipping_address = ShippingAddress::where('customer_id', $user->id)
            ->orderBy('id', 'desc')
            ->first();

        $shipid = $tamilnadu_shiprate->id;

        return view('frontend.pages.checkout.checkout', compact('minimum_amt', 'shipid', 'coupon', 'billing_address', 'shipping_address', 'carts', 'shipping', 'sale_price', 'totalAmount', 'user', 'paymentmethod', 'products', 'states', 'sub_amt', 'deliverycharges'));
    }

    public function checkout_store(Request $request){
        date_default_timezone_set('Asia/Kolkata');

        // Initialize variables
        $coupon = Session::get('coupon', []);
        $user_id = '';

        if (Auth::guard('users')->check()) {
            $user_id = auth()->guard('users')->user()->id;
        } elseif (Auth::guard('guest')->check()) {
            $user_id = auth()->guard('guest')->user()->id;
        }

        $carts = DB::table('cart_tables')->selectRaw('cart_tables.*')
            ->Join('product_variants', 'product_variants.id', 'cart_tables.product_varient')
            ->where('product_variants.in_stock', '>', 0)
            ->where('customer_id', $user_id)
            ->get();

        $delivercharge = $request->deliver_charge;
        $sub_amt = 0;
        $tax_rate = 0;

        // Calculate subtotal and tax rate
        foreach($carts as $cart){
            $product = DB::table('products')->where('id', $cart->product_id)->first();
            $productvariant = ProductVariant::where('status', 'active')->where('product_id', $cart->product_id)->where('variants', $cart->arrtibute_name)->first();

            $stockLockCount = DB::table('stock_lock')->where('product_varient', $productvariant->id)
                ->whereRaw('created_at >= now() - interval 5 minute')
                ->sum('qty');

            if (($productvariant->in_stock - $stockLockCount) < $cart->product_qty) {
                $response['success'] = false;
                $response['msg'] = $cart->product_name . ' stock is ordered by someone. Kindly try later.';
                return response()->json(['response' => $response]);
            }

            $sub_amt += ($cart->product_qty * $cart->price);
            $value = $this->fetchSalePrice($productvariant->regular_price, $product->tax_id, $product->discount, $product->discount_type);
            $tax_rate += $value['tax_price'];
        }

        $discountAmount = 0;  // Initialize to 0 by default

       if (count($coupon) > 0) {
    $coupan_id = $coupon['id'];
    $coupan_details = DB::table('coupon')->where('id', $coupan_id)->first();
    $couponProductId = $coupan_details->product_id;

    if ($couponProductId > 0) {
        // Retrieve cart data
        $cartDataa = DB::table('cart_tables')->where('customer_id', $user_id)->where('product_id', $couponProductId)->first();

        // Check if cart data is found
        if ($cartDataa) {
            $cartProductEachPrice = ($cartDataa->product_qty * $cartDataa->price);

            if ($coupan_details->offer_details == 1) {
                $amt = $cartProductEachPrice - $coupon['discount'];
            } else {
                $amt = (($cartProductEachPrice) * $coupon['discount'] / 100);
            }
        } else {
            // Handle case when cart data is not found
            $amt = 0; // Set amt to 0 or an appropriate default value
        }
    } else {
        if ($coupan_details->offer_details == 1) {
            $amt = $coupon['discount'];
        } else {
            $amt = (($sub_amt) * $coupon['discount'] / 100);
        }
    }

    // Ensure coupon discount is fetched from session or set to 0 if not available
    $discountAmount = session('coupon')['discount'] ?? 0;

    $totalAmount = $sub_amt + $request->deliver_charge - $discountAmount - $request->ship_discount_amount;
    $discount_rate = $amt;
} else {
    $totalAmount = $request->deliver_charge + $sub_amt - $request->ship_discount_amount;
    $discount_rate = 0;
}

        // Ensure the total amount is not negative
        $totalAmount = max(0, $totalAmount);

        // GST and shipping calculations
        $tamilnadu_shiprate = DB::table('state_list')->where('id', $request->billing_address['state'])->first();
        $gsttax = DB::table('taxes')->where('id', 1)->first();

        if ($tamilnadu_shiprate->id == 31) {
            $shipping = $sub_amt / 100 * $gsttax->percentage;
        } else {
            $shipping = $sub_amt / 100 * $gsttax->percentage1;
        }

        // Generate order ID
        $ordersdetails = DB::table('orders')->where('status', '!=', '')->orderBy('id', 'desc')->first();
        $order_id = empty($ordersdetails->order_id) ? '001' : '00' . ($ordersdetails->id + 1);

        // Create the order
        $order = new Order;
        $order->order_id = $order_id;
        $order->tracking_id = ''; // Adjust tracking_id logic if needed
        $order->customer_id = $user_id;
        $order->sub_total = $sub_amt;
        $order->tax_rate = $tax_rate;
        $order->gst = $shipping;
        $order->total = $totalAmount;
        $order->discound_amount = $discountAmount;
        $order->deliver_charge = $request->deliver_charge;
        $order->ship_discount_amount = $request->ship_discount_amount;
        $order->payment_type = $request->payment_status;
        $order->created_at = now();
        $order->status = 'Processing';

        // Payment status logic
   if($request->payment_status == "cod"){
            $order->payment_status="unpaid";
         }else{
            $order->payment_status="unpaid";
         }

        // Save the order to the database
        $order->save();

        // $carts=CartTable::where('customer_id',$user_id)->where('product_qty','>',0)->where('status','active')->get();

         $carts=DB::table('cart_tables')->selectRaw('cart_tables.*')->Join('product_variants','product_variants.id','cart_tables.product_varient')
              ->where('product_variants.in_stock','>',0)
               ->where('customer_id',$user_id)->where('product_qty','>',0)->get();

        //order product
        for($i=0;$i<count($carts);$i++){
           $product=DB::table('products')->where('id',$carts[$i]->product_id)->first();
           $productvariant=ProductVariant::where('status','active')->where('product_id',$carts[$i]->product_id)->where('variants',$carts[$i]->arrtibute_name)->first();
           $calculated_value= $this->fetchSalePrice($productvariant->regular_price,$product->tax_id,$product->discount,$product->discount_type);

            $tempStockInsertData = [];
           $tempStockInsertData['customer_id'] = $carts[$i]->customer_id;
           $tempStockInsertData['product_varient'] = $productvariant->id;
           $tempStockInsertData['qty'] = $carts[$i]->product_qty;
           $stockLockCount=DB::table('stock_lock')->insert($tempStockInsertData);

           $orderproduct=new OrderProduct;
           $orderproduct->order_id=$order->id;
           $orderproduct->product_id=$carts[$i]->product_id;
           $orderproduct->quantity=$carts[$i]->product_qty;
           $orderproduct->amount=$carts[$i]->price;
           $orderproduct->option=$carts[$i]->arrtibute_name;
           $orderproduct->tax_rate=$calculated_value['tax_price'];
           $orderproduct->total_tax=$productvariant->regular_price;
           $orderproduct->save();
        //   ProductVariant::where('product_id',$carts[$i]->product_id)->where('variants',$carts[$i]->arrtibute_name)->update(['in_stock'=>$productvariant->in_stock - $carts[$i]->product_qty]);

        }
            $lastname='';
            if(isset($request->billing_address['last_name']) && !empty($request->billing_address['last_name'])){
                $lastname = $request->billing_address['last_name'];
            }

           //Billing Address
           $billing_address=new BillingAddress;
           $billing_address->order_id=$order->id;
           $billing_address->customer_id=$user_id;
           $billing_address->first_name=$request->billing_address['first_name'];
           $billing_address->last_name=$lastname;
           $billing_address->phone_number=$request->billing_address['phone_number'];
          // $billing_address->email=$request->billing_address['email'];
           $billing_address->address=$request->billing_address['street_1'] .",". $request->billing_address['street_2'];
           $billing_address->street_1=$request->billing_address['street_1'];
           $billing_address->street_2=$request->billing_address['street_2'];
           $billing_address->city=$request->billing_address['town'];
           $billing_address->state=$request->billing_address['state'];
           $billing_address->pincode=$request->billing_address['pincode'];
           $billing_address->save();

            $lastname1='';
            if(isset($request->shipping_address['last_name']) && !empty($request->shipping_address['last_name'])){
                $lastname1 = $request->shipping_address['last_name'];
            }

           //Shipping Address
           $shipping_address=new ShippingAddress;
           $shipping_address->order_id=$order->id;
           $shipping_address->customer_id=$user_id;
           $shipping_address->sfirst_name=$request->shipping_address['first_name'];
           $shipping_address->slast_name=$lastname1;
           $shipping_address->sphone_number=$request->shipping_address['phone_number'];
        //   $shipping_address->semail=$request->shipping_address['email'];
           $shipping_address->saddress=$request->shipping_address['street_1'] .",".  $request->shipping_address['street_2'];
           $shipping_address->sstreet_1=$request->shipping_address['street_1'];
           $shipping_address->sstreet_2=$request->billing_address['street_2'];
           $shipping_address->scity=$request->shipping_address['town'];
           $shipping_address->sstate=$request->shipping_address['state'];
           $shipping_address->spincode=$request->shipping_address['pincode'];
           $shipping_address->save();

           //cart update
            /*=Session::get('coupon',[]);

            if(count($couponcode) > 0){

                $coupon_table=Coupon::where('coupon_code',$couponcode['coupon_code'])->first();

            $coupontable=Usedcoupon::where('customer_id',$user_id)->where('coupon_code',$couponcode['id'])->first();
            if(!empty($coupontable)){
                Usedcoupon::where('customer_id',$user_id)->where('coupon_code',$couponcode['id'])->update(['coupon_usedcount'=>$coupontable->coupon_usedcount + 1]);
            }else{
                $coupon= new Usedcoupon();
                $coupon->order_id=$order->id;
                $coupon->coupon_code=$coupon_table->id;
                $coupon->customer_id=$user_id;
                $coupon->coupon_usedcount=1;
                $coupon->save();
            }

            }

            //$details['email'] =auth()->guard('users')->user()->email;
            //$details['admin_email'] ='raghul@oceansoftwares.in';
            $details['customer_name'] =$request->billing_address['first_name'];
            $details['order_id'] = $order->order_id;

            $baseUrl = url('/').'/order_pdf/'.$order->id;

            $text_message="Your Product order link : https://taslim.oceansoftwares.in/prrayasha/public/order_pdf/{$order->id}";

           //dispatch(new \App\Jobs\CustomerEmailJob($details));
           //dispatch(new \App\Jobs\AdminEmailJob($details));

           CartTable::where('customer_id',$user_id)->delete();

           Session::put('coupon',[]);
           Session::forget('coupon',[]);

            // $pdfUrl = $text_message;

            // print_r($text_message);die;
            //sms message

            $baseUrl = url('/').'/order_pdf/'.$order->id;
            $text_message="Your Product order link : https://taslim.oceansoftwares.in/prrayasha/public/order_pdf/{$order->id}";

            /*
            $new_url =   url('/').'/order_pdf/'.$order->id;
            $redirecturl="prrayasha/public/order_pdf/{$order->id}";
            $url1 = base_convert($redirecturl, 10, 36);
            $data = array(
                'original_url' => $new_url,
                'shortened_url' => $url1,
                );
            DB::table('url_shortener')->insert($data);
            $shorturl = "https://taslim.oceansoftwares.in/url.php?id=".$url1;

            $fullname = $request->billing_address['first_name'];
            $key = "8cnx5PVTXSCKxjZy";
            $mbl = $request->billing_address['phone_number'];
            $message_content = "Hi {#var#}, We are so glad that you placed an order with us! Here's your e-bill with order details Bill {#var#} We will share the tracking link once it's shipped.PRRCOL";
            $message_content = preg_replace('/\{#var#\}/', $fullname, $message_content, 1);
            $message_content = str_replace('{#var#}', $tracking_id, $message_content);
            $encoded_message_content = urlencode($message_content);
            $senderid = "PRRCOL";
            $route = "1";
            $templateid = "1707171887562080754";
            $url = "https://sms.textspeed.in/vb/apikey.php?apikey=$key&senderid=$senderid&templateid=$templateid&number=$mbl&message=$encoded_message_content";
            $output = file_get_contents($url);
            */

            /*$id=$order->id;
            $text_message="https://prrayashacollections.com/".$id;
            $key = "8cnx5PVTXSCKxjZy";
            $mbl = $request->billing_address['phone_number'];
            $firstname = $request->billing_address['first_name'];
            //$firstname="sabari";
           // $tracking_id="1032";
             $message_content = "Hi {#var#}, We are so glad that you placed an order with us! Here's your e-bill with order details Bill {#var#} We will share the tracking link once it's shipped.PRRCOL";
            $message_content = preg_replace('/\{#var#\}/', $firstname, $message_content, 1);
            $message_content = preg_replace('/\{#var#\}/',$text_message, $message_content, 1);

            $encoded_message_content = urlencode($message_content);
            $senderid = "PRRCOL";
            $route = "1";
            $templateid = "1707171887562080754";
            $url = "https://sms.textspeed.in/vb/apikey.php?apikey=$key&senderid=$senderid&templateid=$templateid&number=$mbl&message=$encoded_message_content";
            $output = file_get_contents($url);

           Session::put('coupon',[]);
           Session::forget('coupon',[]);

            Session::put('cart',[]);
           Session::forget('cart',[]);*/

            $data= new Payment;

            $data->order_id = $order->id;;
            $data->customer_id = $user_id;
            $data->amount = $totalAmount;
            $data->payment_method = 'RazorPay';
            $data->email = isset(auth()->guard('guest')->user()->email) ? auth()->guard('guest')->user()->email : '';
            $data->phone = $request->shipping_address['phone_number'];
            $data->payment_status = 1;
            $data->save();

           $response['success']=true;
           $tempreturnemail = isset(auth()->guard('users')->user()->email) ? auth()->guard('users')->user()->email : '';

           Session::forget('cart');
            DB::table('cart_tables')->where('customer_id',$user_id)->delete();
           return response()->json(['response'=>$response,'order_id'=>$order->id, 'totalAmount' => $totalAmount, 'email' => $tempreturnemail]);
   }

    public function complete($order){
        $order_id=$order;
        $unique_id=DB::table('orders')->where('id',$order_id)->first();
        $order=$unique_id->order_id;
        $banner=Banner::orderBy('id','DESC')->limit('1')->get();
        return view('frontend.pages.checkout.complete',compact('order','banner'));
    }
    public function edit_address(Request $request){
        $type=$request->type;
        $customer_id = null;

        if (auth()->guard('users')->check()) {
          $customer_id = auth()->guard('users')->user()->id;
        } elseif (auth()->guard('guest')->check()) {
          $customer_id = auth()->guard('guest')->user()->id;
        }
        if($customer_id){
       if($request->type=="billing"){
             $address=DB::table('billing_address')->where('customer_id',$customer_id)->orderBy('id','desc')->first();
        }else{
            $address=DB::table('shipping_address')->where('customer_id',$customer_id)->orderBy('id','desc')->first();
        }
        $states=DB::table('state_list')->get();
        return view('frontend.pages.checkout.edit_address',compact('address','states','type'));
        }
        else{
            return redirect('user/auth');
        }

    }
    // public function apply_coupon(Request $request){
    //     if(empty($request->products)) {
    //         Session::put('coupon',[]);
    //         return;
    //     }
    //     $current_date = date('Y-m-d');
    //     $minimum_order_amount=0;
    //     for($i=0;$i<count($request->products);$i++){
    //   // $product_variant=DB::table('product_variant')->where('product_id',$request->products[$i]['id'])
    //         $cart_table=DB::table('cart_tables')->where('product_id',$request->products[$i]['id'])->first();
    //         $product_variant=DB::table('product_variant')->where('product_id',$request->products[$i]['id'])->where('arrtibute_name',$cart_table->arrtibute_name)->first();
    //         $minimum_order_amount += ($cart_table->product_qty * $product_variant->regular_price);
    //     }
    //     //  var_dump($minimum_order_amount);
    //     //  exit;
    //     // DB::enableQueryLog();
    //     $validateCoupon=Coupon::where('coupon_code',$request->coupon_code)->where('Status','active')->where('minimum_order_amount','<',$minimum_order_amount)->where('end_date','>=',$current_date)->first();
    //     // dd(DB::getQueryLog());
    //     if($validateCoupon){
    //         $aCouponData = array(
    //             'discount_type' => $validateCoupon->discount_type,
    //             'discount_value' => $validateCoupon->value,
    //             'coupon_code' => $validateCoupon->coupon_code
    //         );
    //         Session::put('coupon',$aCouponData);
    //         $this->updatePage(auth()->guard('customer')->user()->id,$validateCoupon->value,$validateCoupon->discount_type);
    //         $success=true;
    //     }else{
    //         Session::put('coupon',[]);
    //         $success=false;
    //     }
    //     return response()->json(['validateCoupon'=>$validateCoupon,'success'=>$success]);
    // }
    /*CCavenue Payment Integration*/
    function encrypt($plainText,$key)
	{
		$key = $this->hextobin(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
		$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
		$encryptedText = bin2hex($openMode);
		return $encryptedText;
	}
	function decrypt($encryptedText,$key)
	{
		$key = $this->hextobin(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
		$encryptedText = $this->hextobin($encryptedText);
		$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
		return $decryptedText;
	}
	//*********** Padding Function *********************
	 function pkcs5_pad ($plainText, $blockSize)
	{
	    $pad = $blockSize - (strlen($plainText) % $blockSize);
	    return $plainText . str_repeat(chr($pad), $pad);
	}
	//********** Hexadecimal to Binary function for php 4.0 version ********
	function hextobin($hexString)
   	{
        $length = strlen($hexString);
        $binString="";
        $count=0;
        while($count<$length)
        {
            $subString =substr($hexString,$count,2);
            $packedString = pack("H*",$subString);
            if ($count==0)
            {
                $binString=$packedString;
            }
            else
            {
                $binString.=$packedString;
            }
            $count+=2;
        }
        return $binString;
    }
    public function ccavenueResponse(Request $request){
        $workingKey=env('CCAVENUE_WORKING_KEY');//Working Key should be provided here.
        $encResponse=$request->encResp;//This is the response sent by the CCAvenue Server
        $rcvdString=$this->decrypt($encResponse,$workingKey);//Crypto Decryption used as per the specified working key.
        $order_status="";
        $decryptValues=explode('&', $rcvdString);
        $dataSize=sizeof($decryptValues);
        // echo "<center>";
        //  echo '<pre>';
        //  var_dump(json_encode($decryptValues));
        //  exit;
        for($i = 0; $i < $dataSize; $i++)
        {
            $information=explode('=',$decryptValues[$i]);
            if($i==3)	$order_status=$information[1];
        }
        if($order_status==="Success")
        {
            //echo "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
            // echo '<pre>';
            // var_dump($decryptValues);
            // exit;
            $orderInfo=explode('=',$decryptValues[0]);
            $billingPhone=explode('=',$decryptValues[17]);
            $billingName=explode('=',$decryptValues[11]);
            $billingEmail=explode('=',$decryptValues[18]);
            $customerId = explode('=',$decryptValues[26]);

            // echo $orderInfo[1].'<br>';
            // echo $billingPhone[1].'<br>';
            // echo $billingName[1].'<br>';
            // echo $billingEmail[1].'<br>';
            // echo $customerId[1].'<br>';
            CartTable::where('customer_id',$customerId[1])->delete();
            //Session::put('cart',[]);
            $details['email'] =$billingEmail[1] == '' ? 'niresh@oceansoftwares.in' : $billingEmail[1];
            $details['admin_email'] ='raghul@oceansoftwares.in';
            $details['customer_name'] =$billingName[1];
            $details['order_id'] = $orderInfo[1];
            dispatch(new \App\Jobs\CustomerEmailJob($details));
            dispatch(new \App\Jobs\AdminEmailJob($details));
            //Send acknowledgement via text SMS to customer
            $message_content=urlencode("Thank you for your order. Your order number ".$orderInfo[1]." if you would like to view the status of your order on make changes please visit WWW.TULIACOSMETICS.COM");
            $this->sendSms($billingPhone[1], '1707166375428192963', $message_content);
            //Send acknowledgement via text SMS to Admin
            $message_content=urlencode("Hi, You have received an Order from Tulia website. Order Id is " .$orderInfo[1]. ". If you would like to view the status of the order please visit WWW.TULIACOSMETICS.COM");
            $this->sendSms('8148148487', '1707166375428192963', $message_content);
            $response['success']=true;
        }
        else if($order_status==="Aborted")
        {
            echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
            $response['success']=false;
        }
        else if($order_status==="Failure")
        {
            echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
            $response['success']=false;
        }
        else
        {
            echo "<br>Security Error. Illegal access detected";
            $response['success']=false;
            $order_status = 'Unknown Error';
        }
        // echo "<br><br>";
        // echo "<table cellspacing=4 cellpadding=4>";
        // for($i = 0; $i < $dataSize; $i++)
        // {
        //     $information=explode('=',$decryptValues[$i]);
        //         echo '<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
        // }
        // echo "</table><br>";
        // echo "</center>";
        $order_status= ($response['success'] == true) ? 'Confirmed' : 'Cancelled';
        $payment_status = ($response['success'] == true) ? 'paid' : 'unpaid';
        Order::where('order_id',$orderInfo[1])->first()->update(array('status' => $order_status, 'payment_status' => $payment_status));
        //return response()->json(['response'=>$response]);
        //return Redirect::to(url('customer/my_account'));

        return view('frontend.pages.checkout.payment_success',array('order_id' => $orderInfo[1]));
    }
    /*CCavenue Payment Integration*/
    public function payment_failure(){
        return view('frontend.pages.checkout.payment_failure');
    }
    public function payment_success($order_id){
        $order =DB::table('orders')->where('id',$order_id)->first();

        $order_id = $order->order_id;
        //$amount=$order->sub_total + $order->deliver_charge+ $order->gst - $order->discound_amount;

        $amount=$order->sub_total + $order->deliver_charge - $order->discound_amount- $order->ship_discount_amount;
        if($amount){
            $amount = number_format($amount,2);
        }

        return view('frontend.pages.checkout.payment_success',compact('order_id','amount'));
    }

    public function change_shippingprice(Request $request){
        $state=DB::table('state_list')->where('id',$request->state_id)->first();
        // $tamilnadu=DB::table('state_list')->where('state',"TAMIL NADU")->first();
        return response()->json(['state'=>$state->shipping_charge]);
    }

    public function testSes(){
        $details['email'] ='nireshkumar27@gmail.com';
        $details['admin_email'] ='order@tuliacosmetics.com';
        $details['customer_name'] ='Niresh';
        $details['order_id'] = '5';
        dispatch(new \App\Jobs\CustomerEmailJob($details));
    }

    public function checkout_store_payment(Request $request){

        if (Auth::guard('users')->check()) {
            $user_id = auth()->guard('users')->user()->id;
        } elseif (Auth::guard('guest')->check()) {
            $user_id = auth()->guard('guest')->user()->id;
        } else {
            $user_id ='';
        }

        $razorpayPaymentId = $request->razorpay_payment_id;

         $orderId = $request->order_id;
        $order=DB::table('orders')->where('id',$orderId)->first();

        $tempTotal = ($order->total) * 100;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/payments/'.$razorpayPaymentId.'/capture');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n  \"amount\": $tempTotal,\n  \"currency\": \"INR\"\n}");
        curl_setopt($ch, CURLOPT_USERPWD, 'rzp_live_DKjLx9KUdQM1i0' . ':' . 'nG9sGNlpBSB03Q4DrlhcZ85R');

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $responseData = json_decode($result);

        if(isset($responseData->error)){
             $response['success']=false;
            return response()->json(['response'=>$response,'order_id'=>$order->order_id]);
        }

        // $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));

        // $payment = $api->payment->fetch($razorpayPaymentId);
        // $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));

        // print_r($response);
        // exit();
        $tempOrderData = DB::table('orders')->where('id',$orderId)->first();
        if($tempOrderData->payment_status!='paid'){

            $ordersdetails = DB::table('order_number')->where('id', '=', '1')->first()->current;
            $newOrderNo = $ordersdetails+1;
             DB::table('order_number')->where('id', '=', '1')->update(['current' => $newOrderNo]);
            // $ordersdetails = str_replace('ORD-','',$ordersdetails);

            $order_id_temp = '00'.$newOrderNo;
            $order_id_temp = Str::upper('ORD-'.$order_id_temp);

            DB::table('orders')->where('id',$orderId)->update(['payment_status' => 'paid','order_id'=>$order_id_temp]);

        }

        $data=Payment::where('order_id',$order->id)->first();
        $data->payment_id = $request->razorpay_payment_id;
        $data->payment_status = 2;

        $data->update();

        $carts=CartTable::where('customer_id',$user_id)->where('status','active')->get();
        //order product
        for($i=0;$i<count($carts);$i++){
           $product=DB::table('products')->where('id',$carts[$i]->product_id)->first();
           $productvariant=ProductVariant::where('status','active')->where('product_id',$carts[$i]->product_id)->where('variants',$carts[$i]->arrtibute_name)->first();
        //   $calculated_value= $this->fetchSalePrice($productvariant->regular_price,$product->tax_id,$product->discount,$product->discount_type);
        //   $orderproduct=new OrderProduct;
        //   $orderproduct->order_id=$order->id;
        //   $orderproduct->product_id=$carts[$i]->product_id;
        //   $orderproduct->quantity=$carts[$i]->product_qty;
        //   $orderproduct->amount=$carts[$i]->price;
        //   $orderproduct->option=$carts[$i]->arrtibute_name;
        //   $orderproduct->tax_rate=$calculated_value['tax_price'];
        //   $orderproduct->total_tax=$productvariant->regular_price;
        //   $orderproduct->save();
           ProductVariant::where('product_id',$carts[$i]->product_id)->where('variants',$carts[$i]->arrtibute_name)->update(['in_stock'=>$productvariant->in_stock - $carts[$i]->product_qty]);
        }

          DB::table('stock_lock')->where('customer_id',$user_id)->delete();

        $billing_address = DB::table('billing_address')->where('order_id',$order->id)->first();

        //cart update
        $couponcode=Session::get('coupon',[]);

        if(count($couponcode) > 0){
            $coupon_table=Coupon::where('coupon_code',$couponcode['coupon_code'])->first();

            $coupontable=Usedcoupon::where('customer_id',$user_id)->where('coupon_code',$couponcode['id'])->first();
            if(!empty($coupontable)){
                Usedcoupon::where('customer_id',$user_id)->where('coupon_code',$couponcode['id'])->update(['coupon_usedcount'=>$coupontable->coupon_usedcount + 1]);
            }else{
                $coupon= new Usedcoupon();
                $coupon->order_id=$order->id;
                $coupon->coupon_code=$coupon_table->id;
                $coupon->customer_id=$user_id;
                $coupon->coupon_usedcount=1;
                $coupon->save();
            }
        }

        $details['customer_name'] =$billing_address->first_name;
        $details['order_id'] = $order->order_id;

        $baseUrl = url('/').'/order_pdf/'.$order->id;

        $text_message="Your Product order link : https://taslim.oceansoftwares.in/prrayasha/public/order_pdf/{$order->id}";

       CartTable::where('customer_id',$user_id)->delete();

       Session::put('coupon',[]);
       Session::forget('coupon',[]);

        //sms message

        $baseUrl = url('/').'/order_pdf/'.$order->id;
        $text_message="Your Product order link : https://taslim.oceansoftwares.in/prrayasha/public/order_pdf/{$order->id}";

        $id=$order->id;
        // $text_message="https://prrayashacollections.com/".$id;
        // $text_message = "t.ly/BTfxA?id=".$id; //New url
        // $text_message = "tinyurl.com/2wrmt8xn?id=".$id;
        $text_message = "rb.gy/uqo7g5?id=".$id;

        $key = "8cnx5PVTXSCKxjZy";

        $mbl = $billing_address->phone_number;
        $firstname = $billing_address->first_name;
        //$firstname="sabari";
       // $tracking_id="1032";
        $message_content = "Hi {#var#}, We are so glad that you placed an order with us! Here's your e-bill with order details Bill {#var#} We will share the tracking link once it's shipped.PRRCOL";
        $message_content = preg_replace('/\{#var#\}/', $firstname, $message_content, 1);
        $message_content = preg_replace('/\{#var#\}/',$text_message, $message_content, 1);

        $encoded_message_content = urlencode($message_content);
        $senderid = "PRRCOL";
        $route = "1";
        $templateid = "1707171887562080754";
        $url = "https://sms.textspeed.in/vb/apikey.php?apikey=$key&senderid=$senderid&templateid=$templateid&number=$mbl&message=$encoded_message_content";
        // $output = file_get_contents($url);

           try {
                 $context = stream_context_create(array(
                    'http' => array('ignore_errors' => true),
                ));
                $output = file_get_contents($url, false, $context);
            } catch(Exception $e) {

            }

       Session::put('coupon',[]);
       Session::forget('coupon',[]);

       Session::put('cart',[]);
       Session::forget('cart',[]);

       $response['success']=true;
       return response()->json(['response'=>$response,'order_id'=>$order->order_id]);
    }

    public function processphonepe($orderId){

        $order=DB::table('orders')->where('id',$orderId)->first();
        Log::info('Order:', ['order' => $order]);

        $merchantId = 'M22HOTYLY403R';
      //$merchantId = 'LlY4iPbAoAtcgN';

        // $apiKey = 'dfe4668a-e8ae-40a5-b456-3679b72014bc';
        $apiKey = 'dfe4668a-e8ae-40a5-b456-3679b72014bc';
        $redirectUrl = 'https://prrayashacollections.com/checkout_store_phonepe_payment';

        $order_id = $order->id;
        $amount = $order->total;

        $merchantTransactionId = 'pay_' . $order_id . '_' . uniqid();

        $transaction_data = array(
            'merchantId' => "$merchantId",
           'merchantTransactionId' => $merchantTransactionId,
           "merchantOrderId" => $order_id,
            "merchantUserId"=>$order_id,
            'amount' => $amount * 100,
            'redirectUrl'=>"$redirectUrl",
            'redirectMode'=>"POST",
            'callbackUrl'=>"$redirectUrl",
           "paymentInstrument"=> array(
            "type"=> "PAY_PAGE",
          )
        );

         Log::info('Transaction Date in processphonepay:', ['response' => $transaction_data,'merchantId'=>$merchantId,
         'apiKey'=>$apiKey,'order'=>$order
         ]);

                $encode = json_encode($transaction_data);
                Log::info('Encode Transaction Data:', ['response' => $transaction_data,'encode'=>$encode]);
                $payloadMain = base64_encode($encode);
                Log::info('Payload Main Data:', ['response' => $encode,'payloadMain'=>$payloadMain]);
                $salt_index = 1; //key index 1
                $payload = $payloadMain . "/pg/v1/pay" . $apiKey;
                Log::info('payload Data:', ['payloadMain' => $payloadMain,'apiKey'=>$apiKey,'payload'=>$payload]);
                $sha256 = hash("sha256", $payload);
                Log::info('SHA256 Data:', ['payload' => $payload,'sha256'=>$sha256]);
                $final_x_header = $sha256 . '###' . $salt_index;
                Log::info('Final-x-header Data:', ['sha256' => $sha256,'salt_index'=>$salt_index,'final_x_header'=>$final_x_header]);
                $request = json_encode(array('request'=>$payloadMain));
                Log::info('Payloadmain Request Data:', ['payloadMain' => $payloadMain,'request'=>$request]);

                $curl = curl_init();

                curl_setopt_array($curl, [
                  CURLOPT_URL => "https://api.phonepe.com/apis/hermes/pg/v1/pay",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                   CURLOPT_POSTFIELDS => $request,
                  CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                     "X-VERIFY: " . $final_x_header,
                     "accept: application/json"
                  ],
                ]);

                $response = curl_exec($curl);

                Log::info('Curl Data:', ['curl' => $curl,'response'=>$response]);
                $err = curl_error($curl);
                Log::info('Err Data:', ['$err' => $err]);
                curl_close($curl);
                 if ($err) {
                  echo "cURL Error #:" . $err;
                } else {
                // 	print_r($response);
                echo 'Redirecting...';
                   $res = json_decode($response);
                   Log::info('Decode Response:', ['Decode' => $res]);
                   if(isset($res->code) && ($res->code=='PAYMENT_INITIATED')){

                  $payUrl=$res->data->instrumentResponse->redirectInfo->url;
                 Log::info('Payurl:', ['PayUrl' => $payUrl]);
                //  echo $payUrl;
                 return redirect($payUrl);
                   }else{
                   //HANDLE YOUR ERROR MESSAGE HERE
                            print_r('ERROR : ' . $res);
                            Log::info('Error Msg:', ['Error' => json_encode($res, JSON_PRETTY_PRINT)]);
                   }
                }

    }

    public function checkout_store_phonepe_payment(Request $request){

        if (Auth::guard('users')->check()) {
            $user_id = auth()->guard('users')->user()->id;
        } elseif (Auth::guard('guest')->check()) {
            $user_id = auth()->guard('guest')->user()->id;
        } else {
            $user_id ='';
        }

        Log::error('All Request Data: ' . json_encode($request->all()));
        Log::error('usreId: ' . $user_id);

        $data = $request;
     $logFile = storage_path('logs/phonepe_callback_' . date('Y-m-d') . '.log');

if (!file_exists(dirname($logFile))) {
    mkdir(dirname($logFile), 0755, true);
}
//  $logEntry = "All Request Data: " . json_encode($request->all());
  $logEntry = date('Y-m-d H:i:s') . " PhonePe Callback Received:\n";
        $transactionId = $data['transactionId'];
        $logEntry .= "  Transaction ID        : $transactionId\n";
        $merchantId=$data['merchantId'];
        $logEntry .= "  Merchant ID           : $merchantId\n";
        $providerReferenceId=$data['providerReferenceId'];
        $logEntry .= "  Provider Reference ID : $providerReferenceId\n";
        $merchantOrderId=$data['merchantOrderId'];
        $logEntry .= "  Merchant Order ID     : $merchantOrderId\n";
        $checksum=$data['checksum'];
        $logEntry .= "  Checksum              : $checksum\n";
        $status=$data['code'];
        $logEntry .= "  Status Code           : $status\n";
        $parts = explode('_', $transactionId);
        $logEntry .= "  Parts              : " . implode(', ', $parts) . "\n";

        // Check if the array has at least two elements
        if (isset($parts[1])) {
            $orderId = $parts[1];
            $logEntry .= "  Trans Order ID      : $orderId\n";
        } else {
            // Handle the error or set a default value
            $logEntry .= "  Parts not formatted correctly\n";
            $orderId = null;  // or any default value you prefer
        }

$logEntry .= "--------------------------------------------------\n";
$logEntry .= "[" . now() . "] PhonePe callback hit\n";
// Write to file
        file_put_contents($logFile, $logEntry, FILE_APPEND);
        $razorpayPaymentId = $transactionId;

      //  $orderId = $merchantOrderId;
      if(!$orderId){
            echo '<script>alert("Oops! It looks like the order ID is missing. Please check your order and try again. Redirecting to the checkout page...")</script>';

             return redirect('https://prrayashacollections.com/view/checkout');
      }
        $order=DB::table('orders')->where('id',$orderId)->first();

        $logEntry .= "--------------------------------------------------\n";
        $logEntry .= " Order ID                : $orderId\n";
        $logEntry .= " Order Details           : " . json_encode($order) . "\n";

        $logEntry .= "--------------------------------------------------\n";
        $logEntry .= "[" . now() . "] PhonePe callback hit\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND);
        // Log::error('Order Details : ' . $order);
        if($user_id==''){
            $user_id = $order->customer_id;
              $user = User::find($user_id);
           if ($user) {
                Auth::guard('users')->login($user);
            } else {
                $user = Guest::find($user_id);
          if ($user) {
            Auth::guard('guest')->login($user);
         }
        }
        }

        $tempTotal = ($order->total) * 100;

        if($status!="PAYMENT_SUCCESS"){
            echo '<script>alert("Payment Failed")</script>';

             return redirect('https://prrayashacollections.com/view/checkout');
            //  $response['success']=false;
            // return response()->json(['response'=>$response,'order_id'=>$order->order_id]);
        }

        // $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));

        // $payment = $api->payment->fetch($razorpayPaymentId);
        // $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));

        // print_r($response);
        // exit();

        // $ordersdetails = DB::table('orders')->where('payment_status', '=', 'paid')->count();

        // $ordersdetails = DB::table('orders')->where('payment_status', '=', 'paid')->orderBy('id','desc')->first()->order_id;
        $logEntry .= "--------------------------------------------------\n";
        $logEntry .= " Order ID           : $orderId\n";
        $logEntry .= "--------------------------------------------------\n";
        $logEntry .= "[" . now() . "] PhonePe callback hit\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND);
        $tempOrderData = DB::table('orders')->where('id',$orderId)->first();
        Log::error('TempOrder Data: ' . json_encode($tempOrderData));
        if($tempOrderData->payment_status!='paid'){

            $ordersdetails = DB::table('order_number')->where('id', '=', '1')->first()->current;
            $newOrderNo = $ordersdetails+1;

             DB::table('order_number')->where('id', '=', '1')->update(['current' => $newOrderNo]);
            // $ordersdetails = str_replace('ORD-','',$ordersdetails);

            $order_id_temp = '00'.$newOrderNo;

            // $ordersdetails = str_replace('ORD-','',$ordersdetails);

            // $order_id_temp = '00'.$ordersdetails+1;
            $order_id_temp = Str::upper('ORD-'.$order_id_temp);

        $logEntry .= "--------------------------------------------------\n";
        $logEntry .= " Order Temp ID           : $order_id_temp\n";
        $logEntry .= "--------------------------------------------------\n";
            DB::table('orders')->where('id',$orderId)->update(['payment_status' => 'paid','order_id'=>$order_id_temp]);

        }

        $data=Payment::where('order_id',$order->id)->first();
        $data->payment_id = $transactionId;
        $data->payment_status = 2;

        $data->update();

        // $carts=CartTable::where('customer_id',$user_id)->where('status','active')->get();

         $carts=DB::table('cart_tables')->selectRaw('cart_tables.*')->Join('product_variants','product_variants.id','cart_tables.product_varient')
              ->where('product_variants.in_stock','>',0)
               ->where('customer_id',$user_id)->get();

        //order product
        for($i=0;$i<count($carts);$i++){
           $product=DB::table('products')->where('id',$carts[$i]->product_id)->first();
           $productvariant=ProductVariant::where('status','active')->where('product_id',$carts[$i]->product_id)->where('variants',$carts[$i]->arrtibute_name)->first();
        //   $calculated_value= $this->fetchSalePrice($productvariant->regular_price,$product->tax_id,$product->discount,$product->discount_type);
        //   $orderproduct=new OrderProduct;
        //   $orderproduct->order_id=$order->id;
        //   $orderproduct->product_id=$carts[$i]->product_id;
        //   $orderproduct->quantity=$carts[$i]->product_qty;
        //   $orderproduct->amount=$carts[$i]->price;
        //   $orderproduct->option=$carts[$i]->arrtibute_name;
        //   $orderproduct->tax_rate=$calculated_value['tax_price'];
        //   $orderproduct->total_tax=$productvariant->regular_price;
        //   $orderproduct->save();
           ProductVariant::where('product_id',$carts[$i]->product_id)->where('variants',$carts[$i]->arrtibute_name)->update(['in_stock'=>$productvariant->in_stock - $carts[$i]->product_qty]);

        //   Logs for Stocks
                $data = [];
                $data['product_id'] = $carts[$i]->product_id;
                $data['v_id'] = $carts[$i]->product_varient;
                $data['size'] = $carts[$i]->arrtibute_name;
                $data['opr'] = 'MINUS';
                $data['qty'] = $carts[$i]->product_qty;
                $data['closure_qty'] = $productvariant->in_stock - $carts[$i]->product_qty;
                $data['remarks'] = $order_id_temp;
                $data['created_at'] = date('Y-m-d H:i:s');
                DB::table('stock_log')->insert($data);
        }

        $billing_address = DB::table('billing_address')->where('order_id',$order->id)->first();

        //cart update
        $couponcode=Session::get('coupon',[]);

        if(count($couponcode) > 0){
            $coupon_table=Coupon::where('coupon_code',$couponcode['coupon_code'])->first();

            $coupontable=Usedcoupon::where('customer_id',$user_id)->where('coupon_code',$couponcode['id'])->first();
            if(!empty($coupontable)){
                Usedcoupon::where('customer_id',$user_id)->where('coupon_code',$couponcode['id'])->update(['coupon_usedcount'=>$coupontable->coupon_usedcount + 1]);
            }else{
                $coupon= new Usedcoupon();
                $coupon->order_id=$order->id;
                $coupon->coupon_code=$coupon_table->id;
                $coupon->customer_id=$user_id;
                $coupon->coupon_usedcount=1;
                $coupon->save();
            }
        }

        $details['customer_name'] =$billing_address->first_name;
        $details['order_id'] = $order->order_id;

        $baseUrl = url('/').'/order_pdf/'.$order->id;

        $text_message="Your Product order link : https://taslim.oceansoftwares.in/prrayasha/public/order_pdf/{$order->id}";

       CartTable::where('customer_id',$user_id)->delete();

       Session::put('coupon',[]);
       Session::forget('coupon',[]);

        //sms message

        $baseUrl = url('/').'/order_pdf/'.$order->id;
        $text_message="Your Product order link : https://taslim.oceansoftwares.in/prrayasha/public/order_pdf/{$order->id}";

        $id=$order->id;
        // $text_message="https://prrayashacollections.com/".$id;
        // $text_message = "t.ly/BTfxA?id=".$id; //New url
        // $text_message = "tinyurl.com/2wrmt8xn?id=".$id;
        $text_message = "rb.gy/uqo7g5?id=".$id;
        $key = "8cnx5PVTXSCKxjZy";
        $mbl = $billing_address->phone_number;
        $firstname = $billing_address->first_name;
        //$firstname="sabari";
       // $tracking_id="1032";
        $message_content = "Hi {#var#}, We are so glad that you placed an order with us! Here's your e-bill with order details Bill {#var#} We will share the tracking link once it's shipped.PRRCOL";
        $message_content = preg_replace('/\{#var#\}/', $firstname, $message_content, 1);
        $message_content = preg_replace('/\{#var#\}/',$text_message, $message_content, 1);

        $encoded_message_content = urlencode($message_content);
        $senderid = "PRRCOL";
        $route = "1";
        $templateid = "1707171887562080754";
        $url = "https://sms.textspeed.in/vb/apikey.php?apikey=$key&senderid=$senderid&templateid=$templateid&number=$mbl&message=$encoded_message_content";
        // $output = file_get_contents($url);

           try {
                 $context = stream_context_create(array(
                    'http' => array('ignore_errors' => true),
                ));
                $output = file_get_contents($url, false, $context);
            } catch(Exception $e) {

            }

       Session::put('coupon',[]);
       Session::forget('coupon',[]);

       Session::put('cart',[]);
       Session::forget('cart',[]);

      return redirect('https://prrayashacollections.com/payment_success/'.$order->id);
    //   $response['success']=true;
    //   return response()->json(['response'=>$response,'order_id'=>$order->order_id]);
    }
}

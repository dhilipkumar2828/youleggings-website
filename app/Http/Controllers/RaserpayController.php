<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Razorpay\Api\Api;

use Session;

use Cart;

use Exception;

use App\Models\Payment;

use App\Models\ProductVariant;

use App\Models\Product;

use App\Models\CartTable;

use App\Models\Transaction;

use Illuminate\Support\Facades\DB;

class RaserpayController extends Controller

{

    public function create()

    {

        return view('razorpayment');

    }

    public function add_payment(Request $request)

    {

        $data= new Payment;

        //$data->payment_id = $request->razorpay_payment_id;

        //]'user_id' => '1',

        $data->order_id = $request->order_id;

        $data->customer_id = $request->customer_id;

        $data->amount = $request->amount;

        $data->payment_method = $request->payment_method;

        $data->email = $request->email;

        $data->phone = $request->phone;

        $data->payment_status = 1;

        $data->save();

        return $data->id;

    }

    public function payment(Request $request)

    {

        $payy_id=str_replace("checkout.store","",$request->payy_id);

$oid=$request->oid;

        $input = $request->all();

        //print_r($input);

        //die();

        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));

        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if(count($input)  && !empty($input['razorpay_payment_id'])) {

            try {

                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));

$data=Payment::where($payy_id)->first();

$data->payment_id = $request->razorpay_payment_id;

$data->payment_status = 2;

$data->payment_method = $response->method;

$data->message = $response->description;

$data->update();

Transaction::where(["order_id"=>$oid])->update(['transaction_id'=>$request->razorpay_payment_id,"transaction_date"=> date('Y-m-d H:i:s'),"message"=>$response->description,"transaction_status"=>"Approved"]);

foreach(Cart::instance('shopping')->content() as $item){

  CartTable::where('product_id',$item->id)->delete();

  //stock decrease for online payment

  $arrtibute_value=(($item->options));

  $arrtibute_color=($arrtibute_value->color);

  $arrtibute_size=($arrtibute_value->size);

  $arrtiute_array=array();

  for($i=0;$i<count($arrtibute_value);$i++){

   if(!empty($arrtibute_size)){

   array_push($arrtiute_array,$arrtibute_color.",".$arrtibute_size);

   }else{

       array_push($arrtiute_array,$arrtibute_color);

   }

  }

  $product=Product::where('id',$item->id)->first();

  $variant=ProductVariant::where('product_id',$product->id)->where('arrtibute_name',$arrtiute_array[0])->first();

  $stock= $variant->stock;

  $stock -= $item->qty;

  $variant->update(['stock'=>$stock]);

 }

Cart::instance('shopping')->destroy();

Cart::instance('shopping_variant')->destroy();

Session::forget('coupon');

Session::forget('checkout');

return response()->json(['oid'=>$oid,'success' => 'Payment successful']);

            } catch (\Exception $e) {

                return  $e->getMessage();

                Session::put('error',$e->getMessage());

                return redirect()->back();

            }

        }

        //echo  $request->pay_id;

        //echo  $request->razorpay_payment_id;

        //echo  $request->pay_id;

       // $coustomer=Payment::where('id',$input['pay_id'])->Update(['payment_id'=>$input['razorpay_payment_id'],'payment_status'=>2]);

       // echo $request->phone;

        //Session::put('success', 'Payment successful');

        //return redirect()->back();

    }

}

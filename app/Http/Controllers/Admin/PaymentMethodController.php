<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\PaymentMethod;

use App\Models\Payment;

use App\Models\Transaction;

use App\Models\Order;

use App\Models\CustomerTable;

use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\DB;

use Auth;

class PaymentMethodController extends Controller

{

     function __construct()

    {

         $this->middleware('permission:Payment Method Create', ['only' => ['index']]);

         $this->middleware('permission:Payments List', ['only' => ['all_Payments']]);

         $this->middleware('permission:Pending Payments List', ['only' => ['payment_pending']]);

         $this->middleware('permission:Approved Payments List', ['only' => ['Approved_Payments']]);

         $this->middleware('permission:Transactions List', ['only' => ['transactions']]);

        $this->userid=@Auth::user()->id;

        $this->username=@Auth::user()->name;

    }

    public function index()

    {

        $user=(Auth::user()->roles[0]->id == 1) ?['1'] : ['1',$this->userid];

        $citem=PaymentMethod::where(['payment_type'=>'Cash_On_Delivery'])->whereIn('created_by',$user)->get();

        return view('backend.payment.index',compact('citem'));

    }

    public function Paymentstatus(Request $request)

    {

        //    dd($request->all());

        if($request->mode=='true'){

            DB::table('payment__method')->where('id',$request->id)->update(['status'=>'on']);

        }

        else{

            DB::table('payment__method')->where('id',$request->id)->update(['status'=>'off']);

        }

        return response()->json(['msg'=>'Successfully update status','status'=>true]);

        }

        public function CashOnDelivery(Request $request)

        {

           // return $request->all();

            $this->validate($request,[

                'status'=>'string|in:on,off',

                'title'=>'string|required',

                'image'=>'string|nullable',

            ]);

            $data = $request->all();

            if(@$data['status'] == "on")

            {

                $data['status']=$data['status'];

            }

            else

            {

                @$data['status']="off";

            }

            $data['created_by']=$this->userid;

            if(empty($data['payment_id'])){

                $function=PaymentMethod::create($data);

            }

            else{

                $payment=PaymentMethod::find($data['payment_id']);

                $function=$payment->fill($data)->save();

            }

        if($function){

            Session::put('success','payment successfully created');

            return redirect()->route('payment-method');

        }

        else{

            return back()->with('error','Something went wrong');

        }

        }

        public function Stripe(Request $request)

        {

           // return $request->all();

            $this->validate($request,[

                'status'=>'string|in:on,off',

                'title'=>'string|nullable',

                'Stripe_Key'=>'string|nullable',

                'Stripe_Secret'=>'string|nullable',

                'image'=>'string|nullable',

            ]);

            $data=$request->all();

            if(@$data['status'] == "on")

            {

                $data['status']=$data['status'];

            }

            else

            {

                @$data['status']="off";

            }

            if(empty($data['payment_id'])){

                $function=PaymentMethod::create($data);

            }

            else{

                $payment=PaymentMethod::find($data['payment_id']);

                $function=$payment->fill($data)->save();

            }

        if($function){

            Session::put('success','payment successfully created');

            return redirect()->route('payment-method');

        }

        else{

            return back()->with('error','Something went wrong');

        }

        }

        public function Paypal(Request $request)

        {

           // return $request->all();

            $this->validate($request,[

                'status'=>'string|in:on,off',

                'title'=>'string|required',

                'Paypal_Client_ID'=>'string|required',

                'Paypal_Client_Secret'=>'string|required',

                // 'customCheck1'=>'string|required',

                'image'=>'string|nullable',

            ]);

            $data=$request->all();

            if(@$data['status'] == "on")

            {

                $data['status']=$data['status'];

            }

            else

            {

                @$data['status']="off";

            }

            $data['created_by']=$this->userid;

            if(empty($data['payment_id'])){

                $function=PaymentMethod::create($data);

            }

            else{

                $payment=PaymentMethod::find($data['payment_id']);

                $function=$payment->fill($data)->save();

            }

        if($function){

            Session::put('success','payment successfully created');

            return redirect()->route('payment-method');

        }

        else{

            return back()->with('error','Something went wrong');

        }

        }

        public function RazorPay(Request $request)

        {

           // return $request->all();

            $this->validate($request,[

                'status'=>'string|in:on,off',

                'title'=>'string|required',

                'RazorPay_Key'=>'string|required',

                'RazorPay_Secret_Key'=>'string|required',

                'image'=>'string|nullable',

            ]);

            $data=$request->all();

            if(@$data['status'] == "on")

            {

                $data['status']=$data['status'];

            }

            else

            {

                @$data['status']="off";

            }

            $data['created_by']=$this->userid;

            if(empty($data['payment_id'])){

                $function=PaymentMethod::create($data);

            }

            else{

                $payment=PaymentMethod::find($data['payment_id']);

                $function=$payment->fill($data)->save();

            }

        if($function){

            Session::put('success','payment successfully created');

            return redirect()->route('payment-method');

        }

        else{

            return back()->with('error','Something went wrong');

        }

        }

        public function Display_Paytm(Request $request)

        {

           // return $request->all();

            $this->validate($request,[

                'status'=>'string|in:on,off',

                'title'=>'string|required',

                'Paytm_Mercent'=>'string|required',

                'Paytm_Website'=>'string|required',

                'Paytm_Industry'=>'string|required',

                'Paytm_Is_Paytm'=>'string|required',

                'Paytm_Paytm_Mode'=>'string|required',

                'image'=>'string|nullable',

            ]);

            $data=$request->all();

            if(@$data['status'] == "on")

            {

                $data['status']=$data['status'];

            }

            else

            {

                @$data['status']="off";

            }

            $data['created_by']=$this->userid;

            if(empty($data['payment_id'])){

                $function=PaymentMethod::create($data);

            }

            else{

                $payment=PaymentMethod::find($data['payment_id']);

                $function=$payment->fill($data)->save();

            }

        if($function){

            Session::put('success','payment successfully created');

            return redirect()->route('payment-method');

        }

        else{

            return back()->with('error','Something went wrong');

        }

        }

        public function SSL_Commerz(Request $request)

        {

           // return $request->all();

            $this->validate($request,[

                'status'=>'string|in:on,off',

                'title'=>'string|required',

                'SSLCommerz_Store_Id'=>'string|required',

                'SSLCommerz_Store_Password'=>'string|required',

                'SSLCommerz_Sandbox_Check'=>'string|required',

                'image'=>'string|nullable',

            ]);

            $data=$request->all();

            if(@$data['status'] == "on")

            {

                $data['status']=$data['status'];

            }

            else

            {

                @$data['status']="off";

            }

            $data['created_by']=$this->userid;

            if(empty($data['payment_id'])){

                $function=PaymentMethod::create($data);

            }

            else{

                $payment=PaymentMethod::find($data['payment_id']);

                $function=$payment->fill($data)->save();

            }

        if($function){

            Session::put('success','payment successfully created');

            return redirect()->route('payment-method');

        }

        else{

            return back()->with('error','Something went wrong');

        }

        }

        public function transactions()

        {

            $transctions=Transaction::get();

            //$data=Order::where('customer_id',$id)->get();

            return view('backend.payment.transactions',compact('transctions'));

        }

        public function transactionstatus(Request $request)

        {

            if($request->mode=='true'){

                DB::table('transaction')->where('id',$request->id)->update(['transaction_status'=>'Approved']);

            }

            else{

                DB::table('transaction')->where('id',$request->id)->update(['transaction_status'=>'Pending']);

            }

            return response()->json(['msg'=>'Successfully update status','status'=>true]);

            }

    public function all_Payments()

    {

        $transctions=Transaction::get();

        return view('backend.payment.allPayments',compact('transctions'));

    }

    public function payment_pending()

    {

        $transctions=Transaction::get();

        return view('backend.payment.paymentpending',compact('transctions'));

    }

    public function Approved_Payments()

    {

        $transctions=Transaction::where("transaction_status","Approved")->get();

        return view('backend.payment.ApprovedPayments',compact('transctions'));

    }

}

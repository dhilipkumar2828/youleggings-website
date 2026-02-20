<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model

{

    use HasFactory;

    protected $table = 'payment__method';

    protected $fillable=['image','title','status','Stripe_Key','Stripe_Secret','Paypal_Client_ID','Paypal_Client_Secret','RazorPay_Key','RazorPay_Secret_Key','Paytm_Mercent','Paytm_Website','Paytm_Industry','Paytm_Is_Paytm','Paytm_Paytm_Mode','SSLCommerz_Store_Id','SSLCommerz_Store_Password','SSLCommerz_Sandbox_Check','payment_type','created_by'];

}

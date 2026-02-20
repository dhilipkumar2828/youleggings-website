<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class BillingAddress extends Model

{

    use HasFactory;

    protected $table="billing_address";

    protected $fillable=['order_id','customer_id','first_name','last_name','phone_number','email','name_of_address','address','street_1','street_2','city','state','pincode','created_by','updated_at'];

}

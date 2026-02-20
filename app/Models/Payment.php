<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model

{

    use HasFactory;

    protected $fillable=['order_id','customer_id','payment_id','amount','payment_method','email','phone','payment_status'];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Usedcoupon extends Model

{

    use HasFactory;

    protected $table="used_coupon";

    protected $fillable=['customer_id','order_id','coupon_code','coupon_usedcount'];

}

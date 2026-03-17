<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Order extends Model

{

    use HasFactory;

    protected $table = 'orders';

    protected $fillable=['order_id','customer_id','product_id','sub_total','payment_id','payment_type','payment_status','deliver_charge','discound_amount','quantity','total','gst','tax_rate','status','cancle_request','cancel_request_date'];

    public function customer()

    {

        return $this->belongsTo(User::class,'customer_id','id');

    }

    public function items()

    {

        return $this->belongsToMany(Product::class,'order_products','order_id','product_id')->withPivot('quantity','amount');

    }

    public function customer_details()

    {

        return $this->belongsTo(User::class,'customer_id','id');

    }

    public function reasons()

    {

        return $this->belongsTo(Reason::class,'id','order_id');

    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model

{

    use HasFactory;

    protected $table="shipping_address";

    protected $fillable=['order_id','customer_id','sfirst_name','slast_name','sphone_number','semail','scompany_name','sname_of_address','saddress','sstreet_1','sstreet_2','scity','sstate','spincode','created_by','updated_at'];

}

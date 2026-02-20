<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model

{

    use HasFactory;

    protected $table = 'purchase_order';

    protected $fillable=['purchase_order_id','purchase_request_id','quotation_id','order_date','delivery_date','description','status'];

}

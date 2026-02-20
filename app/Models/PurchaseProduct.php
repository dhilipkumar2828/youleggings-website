<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class PurchaseProduct extends Model

{

    use HasFactory;

    protected $table = 'purchaseproduct';

    protected $fillable=['purchase_request_id','vendor_item_id','product_id','product_name','attribute_id','attribute_name','attribute_value','quantity','buying_price','tax_rate'];

}

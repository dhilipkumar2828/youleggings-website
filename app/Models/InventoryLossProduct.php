<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class InventoryLossProduct extends Model

{

    use HasFactory;

    protected $table = 'inventorylossproduct';

    protected $fillable=['inventory_id','vendor_item_id','product_id','product_name','attribute_id','attribute_name','attribute_value','quantity','buying_price','product_status'];

}

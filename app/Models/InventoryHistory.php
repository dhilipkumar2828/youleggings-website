<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class InventoryHistory extends Model

{

    use HasFactory;

    protected $table = 'inventoryhistroy';

    protected $fillable=['inventory_id','product_name','attribute_name','attribute_value','warehouse_code','warehouse_name','voucher_date','open_stock','quantity','expiry_date','product_price','buying_price'];

}

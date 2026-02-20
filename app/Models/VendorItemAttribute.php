<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class VendorItemAttribute extends Model

{

    use HasFactory;

    protected $table="vendoritem_attribute";

    protected $fillable=['vendor_item_id','product_id','attribute_id','attribute_name','attribute_value','quantity','status','buying_price'];

}

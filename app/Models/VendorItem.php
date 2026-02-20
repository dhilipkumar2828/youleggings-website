<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class VendorItem extends Model

{

    use HasFactory;

    protected $table="vendoritem";

    protected $fillable=['vendor_item_id','vendor_id','vendor_name','product_id','product_name','buying_price','quantity','tax_rate'];

}

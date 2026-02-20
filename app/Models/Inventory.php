<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model

{

    use HasFactory;

    protected $table = 'product_inventorys';

    protected $fillable=['prod_variant_id','total_stock','sold','in_stock','status'];

    public function productvariant(){

        return $this->hasMany('App\Models\ProductVariant');

    }

//  public function supplier()

//     {

//         return $this->belongsTo(Vendor::class,'vendor_id','id');

//     }

//      public function getbuyer()

//     {

//         return $this->belongsTo(User::class,'buyer','id');

//     }

//         public function purchase_order()

//     {

//         return $this->belongsTo(PurchaseOrder::class,'purchase_order_id','id');

//     }

}

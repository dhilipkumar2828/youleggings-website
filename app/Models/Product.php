<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model

{

    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable=['name','brand_name','category','youtube_link','header','slug','tax_id','delivery_days','hsn_code','size','subcategory_id','status','description','discount','discount_type','stock','tag','created_by','updated_by'];

    public function productvariant(){
        return $this->hasMany('App\Models\ProductVariant');
    }

    public function productattributes(){
        return $this->hasMany('App\Models\ProductAttribute');
    }

    public function reviews(){
        return $this->hasMany('App\Models\ProductReviews', 'product_id')->where('status', 'active');
    }

      public function cartItems()
    {
        return $this->hasMany(CartTable::class, 'product_id');
    }

public function categories()
{
    return $this->belongsTo(Category::class, 'category', 'id');
}

//     public function category()

// {

//     return $this->belongsTo(Category::class,'cat_id','id');

// }

// public function brand()

// {

//     return $this->belongsTo(Brand::class,'brand_id','id');

// }

// public function rel_prods()

// {

//     return $this->hasMany('App\Models\Product','cat_id','cat_id')->where('status','active')->limit('4');

// }

// public static function getProductByCart($id)

// {

//     return self::where('id',$id)->get()->toArray();

// }

}

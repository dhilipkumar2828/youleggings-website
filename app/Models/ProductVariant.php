<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model

{

    use HasFactory;

    protected $table="product_variants";

    protected $fillable=['product_id','variants','sku','photo','regular_price','in_stock','status'];

    public function product(){

        return $this->belongsTo('App\Models\Product');

    }

    public function productimages(){

        //param1 is Model, param2 is foriegn key of owner, param3 is primary key of itself

        return $this->hasMany('App\Models\ProductImages','prod_variant_id','id');

    }

    public function productspecifications(){

        return $this->hasMany('App\Models\ProductSpecifications', 'prod_variant_id', 'id');

    }

}

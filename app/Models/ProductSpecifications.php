<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ProductSpecifications extends Model

{

    use HasFactory;

    protected $fillable=['prod_variant_id','attribute_name','attribute_value','status'];

    public function productvariant(){

        return $this->belongsTo('App\Models\ProductVariant','prod_variant_id','id');

    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model

{

    use HasFactory;

    protected $fillable=['prod_variant_id','photo','is_thumbnail','status'];

    public function productvariant(){

        return $this->belongsTo('App\Models\ProductVariant','prod_variant_id','id');

    }

}

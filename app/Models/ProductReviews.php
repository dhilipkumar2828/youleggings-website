<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ProductReviews extends Model

{

    use HasFactory;

    protected $fillable=['customer_id','product_id','rate','review','phone_number','name','email','status'];

    public function productname()

    {

        return $this->belongsTo(Product::class,'product_id','id');

    }

    // public function customername()

    // {

    //     return $this->belongsTo(User::class,'customer_id','id');

    // }

}

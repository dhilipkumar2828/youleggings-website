<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model

{

    use HasFactory;

    protected $table ='wishlists';

    protected $fillable=['customer_id','product_id','arrtibute_name','rowId','status'];

    public function wishlist1()

{

    return $this->belongsTo(Product::class,'product_id','id');

}

}

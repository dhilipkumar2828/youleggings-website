<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class CartTable extends Model

{

    use HasFactory;

    protected $table ='cart_tables';

    protected $fillable=['customer_id','product_id','status','rowId','product_name','product_qty','price','options','arrtibute_name','product_varient'];

       public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model

{

    use HasFactory;

    protected $fillable=['product_id','arrtibute_name','arrtibute_value','status'];

}

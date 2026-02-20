<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Deals extends Model

{

    use HasFactory;

    protected $table="deals_of_day";

    protected $fillable=['description','days','photo','link','sale_price','product_name','status','created_by'];

}

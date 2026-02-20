<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Shippingcharges extends Model

{

    use HasFactory;

    protected $fillable=['from','to','amount','status','created_by','updated_at'];

}

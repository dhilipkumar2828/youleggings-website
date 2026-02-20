<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model

{

    use HasFactory;

    protected $fillable=['supplier_id','supplier_name','mobile_number','website','logo','address','pincode','description','email','status'];

}

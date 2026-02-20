<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Suborders extends Model

{

    use HasFactory;

    protected $table = 'suborders';

    protected $fillable=['order_id','vendor_id','customer_id','isactive','payment_status','status'];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Subordersitems extends Model

{

    use HasFactory;

    protected $table = 'suborders_items';

    protected $fillable=['suborders_id','order_id','products_id','quantity','isactive','cancellation_fee','status','option','amount'];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model

{

    use HasFactory;

    protected $table = 'quotation';

    protected $fillable=['purchase_request_id','estimate_id','estimate_date','status'];

}

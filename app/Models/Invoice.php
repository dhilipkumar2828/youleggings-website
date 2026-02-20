<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model

{

    use HasFactory;

    protected $table = 'invoice';

    protected $fillable=['purchase_order_id','invoice_id','invoice_date','note','payment','amount','invoice_link','status'];

}

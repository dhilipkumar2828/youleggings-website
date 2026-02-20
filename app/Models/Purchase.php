<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model

{

    use HasFactory;

    protected $table = 'purchase';

    protected $fillable=['purchase_request_id','purchase_request_name','requester','vendor_id','vendor_name','vendor_items_id','status'];

}

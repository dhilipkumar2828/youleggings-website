<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model

{

    use HasFactory;

    protected $table = 'warehouse';

    protected $fillable=['warehouse_code','warehouse_name','email_address','phone','business_days','open_time','close_time','warehouse_address','warehouse_city','warehouse_pincode','warehouse_note','created_by','status'];

}

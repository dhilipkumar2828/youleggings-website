<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model

{

    use HasFactory;

    protected $table="vendor";

    protected $fillable=['vendor_id','vendor_name','shop_name','date_of_birth','gender','description','email','mobile_number','website','logo','address','pincode','bankname','branch','account_holder_name','account_number','ifsc_code','tax_name','tax_number','pan_number','user_name','password','status'];

}

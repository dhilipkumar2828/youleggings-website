<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model

{

    use HasFactory;

    protected $fillable=['title','slug','url','email','phone_number','description','brand_logo','cover_photo','status','created_by'];

}

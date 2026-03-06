<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model

{

    use HasFactory;

  protected $fillable=['title','subtitle','photo','mobile_photo','link','status','created_by'];

}

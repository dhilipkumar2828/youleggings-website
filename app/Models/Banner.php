<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model

{

    use HasFactory;

  protected $fillable=['title','description','url','link','photo','mobile_photo','status','created_by'];

}

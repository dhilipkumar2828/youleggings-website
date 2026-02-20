<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Youtube extends Model

{

    use HasFactory;

    public $table ='youtube';

  protected $fillable=['id','url','photo','status','created_by','updated_by'];

}

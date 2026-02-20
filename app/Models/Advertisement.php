<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model

{

    use HasFactory;

    public $table ='advertisement';

  protected $fillable=['title','photo','status','position','created_by'];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model

{

    use HasFactory;

    protected $table="blog";

    protected $fillable=['title','slug','photo','description','publish_at','status','created_by'];

}

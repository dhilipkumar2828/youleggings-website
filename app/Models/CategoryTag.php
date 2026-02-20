<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTag extends Model
{
    use HasFactory;

    protected $table = 'categorytag';

    protected $fillable=['title','categories_id','url','link','photo','cate_tag','status','created_at','updated_at'];

}

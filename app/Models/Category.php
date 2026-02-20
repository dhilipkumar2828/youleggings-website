<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Category extends Model

{

    use HasFactory;

    protected $fillable=['title','slug','photo','subcat_photo_1','subcat_photo_2','logo','header','home','category','offers','status','description','is_parent','met_title','met_keyword','met_description','parent_id','created_by','sub_cate_id'];

    public static function shiftChild($cat_id){

        //return Category::whereIn('id',$cat_id)->update(['is_parent'=>1]);

    }

public static function getChildByParentID($id)

{

    return Category::pluck('title','id');

}

}

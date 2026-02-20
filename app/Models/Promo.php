<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model

{

    use HasFactory;

    protected $table = 'promos';

    protected $fillable=['Session_left_description1','Session_right_description1','Session_left_description2','Session_right_description2','Session_left_1','Session_right_1','Session_left_2','Session_right_2','created_by','status'];

}

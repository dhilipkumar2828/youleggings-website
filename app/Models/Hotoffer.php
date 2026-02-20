<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Hotoffer extends Model

{

    use HasFactory;

    protected $table="today_hotoffer";

    protected $fillable=['title','photo','description','start_date','status','created_by','updated_at'];

}

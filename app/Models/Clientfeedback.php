<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Clientfeedback extends Model

{

    use HasFactory;

    protected $table="client_feedback";

    protected $fillable=['name','phone_number','feedback','status','created_by','updated_at'];

}

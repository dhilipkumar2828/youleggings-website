<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class About extends Model

{

    use HasFactory;

    protected $table="about";

    protected $fillable=[
        'title',
        'sub_title',
        'slug',
        'photo',
        'description',
        'promise_title',
        'promise_desc',
        'why_choose_1_title', 'why_choose_1_desc',
        'why_choose_2_title', 'why_choose_2_desc',
        'why_choose_3_title', 'why_choose_3_desc',
        'why_choose_4_title', 'why_choose_4_desc',
        'why_choose_5_title', 'why_choose_5_desc'
    ];

}

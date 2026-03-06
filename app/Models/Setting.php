<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'logo',
        'top_bar_1',
        'top_bar_2',
        'top_bar_3',
        'top_bar_4',
        'footer_description',
        'facebook_link',
        'instagram_link',
        'twitter_link',
        'youtube_link',
        'email',
        'phone',
        'address',
        'google_map'
    ];
}

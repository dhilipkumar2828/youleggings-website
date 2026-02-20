<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashDeal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'button_text',
        'collection_link',
        'banner_image',
        'deal_title',
        'discount_value',
        'deal_end_date',
        'deal_image_1',
        'deal_image_2',
        'status',
    ];
}

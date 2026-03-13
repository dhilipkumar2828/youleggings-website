<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'product_inventorys';

    protected $fillable = [
        'prod_variant_id',
        'total_stock',
        'sold',
        'in_stock',
        'status'
    ];
}

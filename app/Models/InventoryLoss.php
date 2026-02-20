<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class InventoryLoss extends Model

{

    use HasFactory;

    protected $table = 'inventoryloss';

    protected $fillable=['loss_id','inventory_id','adjust_date','adjust_reason','warehouse','status'];

}

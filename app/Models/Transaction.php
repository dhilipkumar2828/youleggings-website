<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

use App\Models\CustomerTable;

class Transaction extends Model

{

    use HasFactory;

    protected $table="transaction";

    protected $fillable=['order_id','customer_id','transction_id','message','transction_date','transction_status'];

    public function payment()

    {

        return $this->belongsTo(Order::class,'order_id','id');

    }

    // public function carOwner()

    // {

    //     return $this->hasMany(CustomerTable::class,'name','id');

        // return $this->hasOneThrough(

        //     //Transctions::class,

        //     Order::class,

        //     'order_id', // Foreign key on the cars table...

        //     'customer_id', // Foreign key on the owners table...

        //    // 'id', // Local key on the mechanics table...

        //     'id' // Local key on the cars table...

        // );

    // }

    public function carOwner()

{

    return $this->belongsTo(CustomerTable::class,'customer_id','id');

}

}

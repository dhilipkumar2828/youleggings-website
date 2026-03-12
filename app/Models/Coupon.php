<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model

{

    use HasFactory;

    protected $table = 'coupon';

    protected $fillable=['coupon_name','coupon_code','start_date','end_date','max_coupon_limit','discount_type','value','Status','minimum_order_amount','offeramountabove','flatofferamount','offer_details','created_by','product_id'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
        'value'      => 'float',
    ];

    public static function findByCode($coupon_code)
    {
        return self::where('coupon_code', $coupon_code)->first();
    }

    public function discount($total)
    {
        if ($this->discount_type == "fixed") {
            return $this->value;
        } elseif ($this->discount_type == "percent" || $this->discount_type == "percentage") {
            return ($this->value / 100) * $total;
        } else {
            return 0;
        }
    }

}

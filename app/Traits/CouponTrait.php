<?php

namespace App\Traits;

use App\Models\Tax;

use DB, Session;

use App\Models\Product;

trait CouponTrait {

    //Setting the maximum total amount to send coupon price

    public function coupon_price(){

        $response['min_couponrate']=1000;

        return $response;

    }

}

<?php

use App\Traits\PriceTrait;

use Session as Session;

use App\Models\Tax;

class Helper{

    use PriceTrait;

    public static function userDefaultImage(){

        return asset('');

    }

    public static function cartWindow(){

        return PriceTrait::renderCartWindow();

    }

    public static function fetchSalePrice($regular_price, $tax, $discount_value, $discount_type) {

        // //Before discount

        // $base_price = $regular_price/((100+$tax_value->percentage)/100);//636.363636363

        // $tax_price = $regular_price-$base_price;//36.363636364

        // $aSesCouponData = Session::get('coupon',[]);

        // if(!empty($aSesCouponData)) {

        //     $discount_type = $aSesCouponData['discount_type'];

        //     $discount_value = $aSesCouponData['discount_value'];

        // }

        // $basePriceAfterDiscount = $base_price-$discount_value;//343.636363636

        // $sale_price = $basePriceAfterDiscount+($basePriceAfterDiscount*($tax_value->percentage/100));

                //Tax Amount

                $tax_value=Tax::where('id',$tax)->where('status','active')->first();

                $tax_price = $regular_price * $tax_value->percentage/100;

                //After discount

                    if($discount_type == 'percentage') {

                        $discount_value = $regular_price*($discount_value/100);

                    }else if($discount_type == 'fixed'){

                        $discount_value = $discount_value;//20

                    }else{

                        $discount_value =0;//20

                    }

                    $sale_price=($regular_price - $discount_value) + $tax_price;//562

                    //   $response['base_price']=$base_price;

                //       var_dump($sale_price);

                // exit;

                    $response['tax_price']=$tax_price;

                    $response['sale_price']=$sale_price;

                    $response['discount_price']=$discount_value;

                    return $response;

      //  echo json_encode(array('base_price' => $base_price, 'tax_price' => $tax_price, 'sale_price' => $sale_price, 'discount_price' => $discount_value));

    }

}

/**

 * Write code on Method

 *

 * @return response()

 */

// if (! function_exists('cartWindow')) {

//     function cartWindow($amount)

//     {

//         return '$' . number_format($amount, 2);

//     }

// }

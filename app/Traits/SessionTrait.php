<?php

namespace App\Traits;

use App\Models\Tax;

use DB, Session;

use App\Models\Product;

trait SessionTrait {

    /*

    This will calculate the sale price based on the below required params.

    $regular_price: A product's original/MRP

    $tax: value in percentage

    $discount_value: integer

    $discount_type: either it will be fixed(amount) or percentage

    $response: An array or json_encoded of sale_price, tax_price, base_price and discount_price.

    Formula: ($regular_price/(100+$tax)%)-$discount)+$tax%

    */

    public function fetchSalePrice() {

      if(!@auth()->guard('users')->user()){

                    $carts = Session::get('cart',[]);

                        foreach($carts as $key=>$cart){

                           $productvariant=Product::where('id',$carts[$key]['product_id'])->first();

                           if(isset($productvariant)){

                               if($productvariant->status=="inactive"){

                                   unset($carts[$key]);

                                   Session::put('cart',$carts);

                               }

                           }else{

                                   unset($carts[$key]);

                                   Session::put('cart',$carts);

                           }

                        }

                 }

    }

}

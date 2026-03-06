<?php

namespace App\Traits;
use App\Models\Tax;
use DB, Session;
use App\Models\Product;

trait PriceTrait {

    /*
    This will calculate the sale price based on the below required params.
    $regular_price: A product's original/MRP
    $tax: value in percentage
    $discount_value: integer
    $discount_type: either it will be fixed(amount) or percentage
    $response: An array or json_encoded of sale_price, tax_price, base_price and discount_price.
    Formula: ($regular_price/(100+$tax)%)-$discount)+$tax%
    */
    public function fetchSalePrice($regular_price, $tax, $discount_value, $discount_type) {
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
                $percentage = $tax_value->percentage ?? 0;

                $tax_price = $regular_price * $percentage/100;

                //After discount
                    if($discount_type == 'percentage') {
                        $discount_value = $regular_price*($discount_value/100);
                    }else if($discount_type == 'fixed'){
                        $discount_value = $discount_value;//20
                    }else{

                        $discount_value =0;//20
                    }

                    $sale_price=($regular_price - $discount_value) + $tax_price;
                  //   print_r($regular_price);die;

                    //   $response['base_price']=$base_price;
                //       var_dump($sale_price);
                // exit;
                    $response['tax_price']=$tax_price;
                    $response['sale_price']=$sale_price;
                    $response['discount_price']=$discount_value;
                    return $response;
                        //R.p - 550
                        //Tax - 3 %
                        //T.P- R.p * Tax/100
                        //Discount - 100 fixed
                        //(R.p - Discount)+T.P

      //  echo json_encode(array('base_price' => $base_price, 'tax_price' => $tax_price, 'sale_price' => $sale_price, 'discount_price' => $discount_value));
    }

    public function updatePage($customer_id, $discount_value = 0, $discount_type = '') {
        $minimum_amt=500;
        $shipping=2;

        $response['success'] =true;

        $rendered_headerwish=view('frontend.header_wishlist')->render();
        $response['rendered_headerwish']=$rendered_headerwish;

        $rendered_headercart=view('frontend.header_cartlist')->render();
        $response['rendered_headercart']=$rendered_headercart;

        $rendered_footercartlist=view('frontend.pages.cart.cart_table')->render();
        $response['rendered_footercartlist']=$rendered_footercartlist;

        //DB::enableQueryLog();
        $aCartData = DB::table('cart_tables')->select('cart_tables.*', 'product_variant.*', DB::Raw('(cart_tables.product_qty*cart_tables.price) as sub_amt'))->join('product_variant','product_variant.product_id','=','cart_tables.product_id')->whereColumn('product_variant.arrtibute_name','=','cart_tables.arrtibute_name')->where('cart_tables.customer_id',$customer_id)->get();

        $sub_amt = 0;
        // foreach($aCartData as $aData){
        //     $sub_amt += $aData->sub_amt;
        // }
        $sale_price=array();
        $total_amount=array();
        foreach($aCartData as $a){
            $product=Product::where('id',$a->product_id)->where('status','active')->first();
            //$product_variant=DB::table('product_variant')->where('product_id',$product->id)->first();
            // $aSesCouponData = Session::get('coupon',[]);
            // if($discount_type == '' || $discount_value == 0) {
            //     if(!empty($aSesCouponData)) {
            //         $discount_type = $aSesCouponData['discount_type'];
            //         $discount_value = $aSesCouponData['discount_value'];
            //     } else {
            //         $discount_type = $product->discount;
            //         $discount_value = $product->discount_type;
            //     }
            // }

            $saleprice= $this->fetchSalePrice($a->regular_price,$product->tax_id,$discount_value,$discount_type);
            array_push($sale_price,$saleprice['sale_price']);
            array_push($total_amount,$saleprice['sale_price'] * $a->product_qty);
            $sub_amt +=  $saleprice['sale_price'] * $a->product_qty;
        }

        $cart_ajax_index=view('frontend.pages.cart.ajax_update',array('total_amount'=>$total_amount,'sale_price'=>$sale_price,'aCartData' => $aCartData,'sub_amt' => $sub_amt,'shipping' => $shipping))->render();
        $response['cart_ajax_index']=$cart_ajax_index;

        //Checkout page auto updation
        $products=DB::table('cart_tables')->where('customer_id',$customer_id)->get();

        $sub_amt = 0;
        foreach($products as $product){
            $sub_amt += $product->product_qty * $product->price;
        }

        $shipping = 2;
        $tot_amt = $sub_amt+$shipping;

        $checkout_ajax_update = view('frontend.pages.checkout.payment_info',array('minimum_amt'=>$minimum_amt,'shipping'=>$shipping,'total_amount'=>$total_amount,'sale_price'=>$sale_price,'products' => $products,'sub_amt' => $sub_amt,'shipping' => $shipping,'tot_amt' => $tot_amt, 'shipping_type' => 'flat_rate'))->render();

        $response['checkout_ajax_update']=$checkout_ajax_update;

        return $response;
    }

        public function sessionremove() {
      if(!@auth()->guard('users')->user()){
           Session::forget('product_name');
                    $carts = Session::get('cart',[]);
                        foreach($carts as $key=>$cart){
                            if(!empty($carts[$key]['product_id'])){
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

}

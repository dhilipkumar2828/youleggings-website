

<aside class="aside-cart-wrapper offcanvas offcanvas-end canvas_static" tabindex="-1" id="AsideOffcanvasCart"

aria-labelledby="offcanvasRightLabel">

<div class="offcanvas-header cart_renders_wishlist">

    <h4 class="m-0 sidetitle" id="offcanvasRightLabel">My Cart</h4>

    <button class="btn-aside-cart-close close_canvas" data-bs-dismiss="offcanvas" aria-label="Close">
 <span  onclick="cartPopupClose();"><svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path></svg></span></button>
  </div>

  @php
    $A_productimg=array();
    $productVariantInStock = 0;
    @endphp

        @if(auth()->guard('users')->user() || auth()->guard('guest')->user())

                    @php

                                            if (Auth::guard('users')->check()) {
                                               $id=auth()->guard('users')->user()->id;
                                            } elseif (Auth::guard('guest')->check()) {
                                               $id=auth()->guard('guest')->user()->id;
                                            } else {
                                                $id ='';
                                            }
                    $coupon=Session::get('coupon',[]);
                    $cart=DB::table('cart_tables')->selectRaw('cart_tables.*,product_variants.in_stock')->Join('product_variants','product_variants.id','cart_tables.product_varient')->where('customer_id',$id)->get();

                   $sub_amt=0;
                    @endphp

                    @if(count($cart) > 0)

               <div class="offcanvas-body">

                   @foreach($cart as $c)

                    @php
                    $product_varient = $c->product_varient;
                    $product_variant = DB::table('product_variants')->where('id', $c->product_varient)->first();

                    if ($product_variant) {
                        $A_prodimg = explode(',', $product_variant->photo);
                        $aProductvariant_photo = $A_prodimg[0];
                        $productVariantInStock = $product_variant->in_stock;
                    } else {
                        $aProductvariant_photo = ''; // or some default value
                    }

                    $product = DB::table('products')->where('id', $c->product_id)->where('status', 'active')->first();

                    $price = '';
                    if ($c->price != 0) {
                        $price = $c->price;
                    }

                    $stockOutt = false;
                     $stockOutCss = '';
                     if($c->in_stock<$c->product_qty){
                         $stockOutt = true;
                         $stockOutCss = 'background:lightgrey;color:red;';
                     }

                    if($c->in_stock >= $c->product_qty){
                        $sub_amt += number_format($price, 2, '.', '') * (int)$c->product_qty;

                    }

                    if ($product_variant) {
                        $A_prodimg = explode(',', $product_variant->photo);
                        array_push($A_productimg, $A_prodimg[0]);
                        $product_variant->photo = $A_productimg[0];
                    }
                @endphp
            <?php
            if(!empty($product) && isset($product->id) && isset($product_variant->id)){
            ?>

                    <ul class="aside-cart-product-list" style="{{$stockOutCss}}">

                        <li class="aside-product-list-item">

                          <a class="remove cartremove" data-product_id="{{$product->id}}" data-product_varient_id="{{$product_variant->id}}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M6 7H5v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7H6zm4 12H8v-9h2v9zm6 0h-2v-9h2v9zm.618-15L15 2H9L7.382 4H3v2h18V4z"></path></svg> </a>

                          <div class="products-image">
                          <img src="{{url($aProductvariant_photo)}}" alt="{{$c->product_name}}">
                          </div>
                           <?php
                                if($stockOutt){
                                    echo 'Out of Stock';
                                }
                                ?>
                            <div class="product-cart">

                                <div class="d-flex flex-column">
                                    <span class="">{{$product->name}}</span>

                                    <input type="hidden" id="product_varient" name="product_varient" value="{{$product_variant->id}}">
                                    <span class="product-price">{{$c->product_qty}} × <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-rupee" viewBox="0 0 16 16">
<path d="M4 3.06h2.726c1.22 0 2.12.575 2.325 1.724H4v1.051h5.051C8.855 7.001 8 7.558 6.788 7.558H4v1.317L8.437 14h2.11L6.095 8.884h.855c2.316-.018 3.465-1.476 3.688-3.049H12V4.784h-1.345c-.08-.778-.357-1.335-.793-1.732H12V2H4v1.06Z"/>
</svg> @if(isset($price)) {{ number_format($price,2,'.','')  }} @else {{ '' }} @endif</span>

                                </div>
                                {{-- <div class="pro-qty">
                 <input type="hidden" id="count_prod_qty{{$product_variant->id}}" class="count_prod_qty"
                                    value="{{$c->product_qty}}"
                                    data-product_id="{{$product->id}}"
                                  >

              <input type="text" id="quantity{{$product_variant->id}}" title="Quantity"
                                    class="quantity count_prod_qty{{$product_variant->id}}"
                                    data-product_id="{{$product->id}}"

                                    value="{{$c->product_qty}}" disabled>
                                    <div class="dec qty-btn cart_rendercount" data-product_price="{{ number_format($price,2,'.','') }}" data-product_id="{{$product->id}}" data-type="dec" data-product_varient_id="{{$product_variant->id}}" data-quantity="{{$productVariantInStock}}">-</div>
                                    <div class="inc qty-btn cart_rendercount" data-product_price="{{ number_format($price,2,'.','') }}" data-product_id="{{$product->id}}" data-type="inc" data-product_varient_id="{{$product_variant->id}}" data-quantity="{{$productVariantInStock}}">+</div>
                                </div> --}}
                            </div>

         </li>

    </ul>
    <?php } ?>

    @endforeach

</div>
<div class="cart-bottom">
        <p class="cart-total"><span>Sub total:</span><span class="amount"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-rupee" viewBox="0 0 16 16">
<path d="M4 3.06h2.726c1.22 0 2.12.575 2.325 1.724H4v1.051h5.051C8.855 7.001 8 7.558 6.788 7.558H4v1.317L8.437 14h2.11L6.095 8.884h.855c2.316-.018 3.465-1.476 3.688-3.049H12V4.784h-1.345c-.08-.778-.357-1.335-.793-1.732H12V2H4v1.06Z"/>
</svg>

@if(count($coupon) >0)
<!----
{{ number_format($sub_amt,2,'.','') - number_format((($sub_amt) * $coupon['discount']/100), 2,'.','')  }}
   ---->
{{ number_format($sub_amt,2,'.','') }}
</span></p>
@else
{{ number_format($sub_amt,2,'.','') }}
@endif

        <!----
        <a class="default-btn w-100 mb-4" href="{{url('view/checkout')}}">Proceed to Checkout</a>
        ---->
        <a class="optional-btn  w-100 " href="{{url('cart')}}">View Shopping cart</a>
</div>

@else

<b style="text-align: center;height: 100vh;display: flex;align-items: center;justify-content: center;">Your Cart is empty</b>

@endif

@else

@php

$session_product= Session::get('cart',[]);

$session_sub_amt = 0;

@endphp

 @php
$productVariantInStock = 0;

                    if($session_product){
                    @endphp

  <div class="offcanvas-body">

                   @foreach($session_product as $key => $session)

                    @php

                    if(($session_product) != ""){

                         $product_variant=DB::table('product_variants')->where('id',$key)->first();
                        $productVariantInStock = $product_variant->in_stock;
                     $stockOutt = false;
                     $stockOutCss = '';
                     if($product_variant->in_stock<$session_product[$key]['product_qty']){
                         $stockOutt = true;
                         $stockOutCss = 'background:lightgrey;color:red;';
                     }

                    if(!empty($session_product[$key]['price'])){
                        if($product_variant->in_stock >= $session_product[$key]['product_qty']){
                        $session_sub_amt +=$session_product[$key]['price'] * $session_product[$key]['product_qty'];
                        }

                     }

                        $A_prodimg = '';
                        if(!empty($product_variant->photo)){
                          $A_prodimg = explode(',', $product_variant->photo);
                          array_push($A_productimg,$A_prodimg[0]);
                        $product_variant->photo=$A_productimg[0];
                          }else{

                            $product_id = $session_product[$key]['product_id'];
                            $product_variant=DB::table('product_variants')->where('product_id',$product_id)->first();
                             $A_prodimg = explode(',', $product_variant->photo);
                             array_push($A_productimg,$A_prodimg[0]);
                             $product_variant->photo=$A_productimg[0];
                          }

                    }

                    @endphp

<?php
 if(!empty($session_product[$key]['price'])){
?>

    <ul class="aside-cart-product-list" style="{{$stockOutCss}}">

        <li class="aside-product-list-item">

            <a class="remove cartremove" data-product_id="{{$session_product[$key]['product_id']}}" data-product_varient_id="{{$key}}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M6 7H5v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7H6zm4 12H8v-9h2v9zm6 0h-2v-9h2v9zm.618-15L15 2H9L7.382 4H3v2h18V4z"></path></svg> </a>

            <div class="products-image">
                <?php
                 if(!empty($product_variant->photo)){
                ?>
                <img src="{{url($A_prodimg[0])}}" alt="">
                <?php } ?>
                <?php
                                if($stockOutt){
                                    echo 'Out of Stock';
                                }
                                ?>
            </div>
            <div class="products-content">
                <span class="">{{$session_product[$key]['product_name']}}</span>

                <input type="hidden" id="product_varient" name="product_varient" value="{{ $key }}">

            <span class="product-price">{{$session_product[$key]['product_qty']}} × <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-rupee" viewBox="0 0 16 16">
<path d="M4 3.06h2.726c1.22 0 2.12.575 2.325 1.724H4v1.051h5.051C8.855 7.001 8 7.558 6.788 7.558H4v1.317L8.437 14h2.11L6.095 8.884h.855c2.316-.018 3.465-1.476 3.688-3.049H12V4.784h-1.345c-.08-.778-.357-1.335-.793-1.732H12V2H4v1.06Z"/>
</svg> <b>{{$session_product[$key]['price']}} </b></span>

                </div>

        </li>

    </ul>
    <?php } ?>
    @endforeach

    <p class="cart-total"><span class="text-uppercase">Sub total:</span><span class="amount"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-rupee" viewBox="0 0 16 16">
<path d="M4 3.06h2.726c1.22 0 2.12.575 2.325 1.724H4v1.051h5.051C8.855 7.001 8 7.558 6.788 7.558H4v1.317L8.437 14h2.11L6.095 8.884h.855c2.316-.018 3.465-1.476 3.688-3.049H12V4.784h-1.345c-.08-.778-.357-1.335-.793-1.732H12V2H4v1.06Z"/>
</svg> {{$session_sub_amt}}</span></p>
<!-----
    <a class="default-btn w-100 mb-4" href="{{url('view/checkout')}}">Proceed to Checkout</a>
    ---->
    <a class="optional-btn  w-100 " href="{{url('cart')}}">View Shopping cart</a>

</div>

<?php
} else {
?>
<b style="text-align: center;height: 100vh;display: flex;align-items: center;justify-content: center;">Your Cart is empty</b>
@php
}
                    @endphp
@endif

</aside>

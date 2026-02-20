<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\CartTable;
use DB;
use App\Models\Coupon;
use Cart;
use App\Traits\PriceTrait;
use Auth, Session;
use Carbon\Carbon;
class CartController extends Controller
{
    use PriceTrait;
    public function cart()
    {
              $this->sessionremove();
        $sub_amt =0;
        $productimage=array();
        if(@auth()->guard('users')->user() || @auth()->guard('guest')->user()){

             $customer_id = null;

if (auth()->guard('users')->check()) {
    $customer_id = auth()->guard('users')->user()->id;
} elseif (auth()->guard('guest')->check()) {
    $customer_id = auth()->guard('guest')->user()->id;
}
            //   $carts=DB::table('cart_tables')->where('status','active')->where('customer_id',$customer_id)->get();

              $carts=DB::table('cart_tables')->selectRaw('cart_tables.*,product_variants.in_stock')->Join('product_variants','product_variants.id','cart_tables.product_varient')
            //   ->where('product_variants.in_stock','>',0)
              ->Join('products','products.id','product_variants.product_id')
              ->where('customer_id',$customer_id)->where('products.status','active')
          //    ->whereDate('cart_tables.created_at',Carbon::today())
              ->get();

           // $carts = Session::get('cart', []);

           // $carts = (object) $carts;

               $coupon=Session::get('coupon',[]);

                   foreach($carts as $cart){
                       $productvariant=ProductVariant::where('status','active')->where('product_id',$cart->product_id)->where('variants',$cart->arrtibute_name)->first();

                       $rel_productimg = $productvariant->photo;
                       $A_related_prodimg = explode(',', $rel_productimg);
                       array_push($productimage,$A_related_prodimg[0]);
                       if($cart->in_stock >= $cart->product_qty){
                       $sub_amt +=($cart->product_qty * $cart->price);

                        // if(count($coupon) > 0 && isset($coupon['product_id']) && $coupon['product_id'] == $cart->product_id){
                                //   $tempdis=($tempsub_amt * $coupon['discount']/100);
                                    // $tempsub_amt=$tempsub_amt - $tempdis;

                    //   }

                    //   $sub_amt += $tempsub_amt;

                       }

                    }
             }
            else{
               /*$carts = Session::get('cart',[]);
               foreach($carts as $key=>$cart){
                   $productvariant=ProductVariant::where('status','active')->where('product_id',$cart['product_id'])->where('variants',$cart['variant'])->first();
                   $rel_productimg = $productvariant->photo;
                   $A_related_prodimg = explode(',', $rel_productimg);
                   $productimage[$key] = $A_related_prodimg[0];
                  // array_push($productimage,$A_related_prodimg[0]);
                   $sub_amt +=($carts[$key]['product_qty'] * $carts[$key]['price']);
                }
                */

                $carts = Session::get('cart', []);

                $productimage = [];
                $sub_amt = 0;

                $coupon=Session::get('coupon',[]);

                foreach ($carts as $key => $cart) {
                    $cart['in_stock'] = 0 ;
                    if (isset($cart['product_id']) && isset($cart['variant'])) {
                        $productvariant = ProductVariant::where('status', 'active')
                            ->where('product_id', $cart['product_id'])
                            ->where('variants', $cart['variant'])
                            ->first();
                        $carts[$key]['in_stock'] = $productvariant->in_stock;

                        if ($productvariant) {
                            $rel_productimg = $productvariant->photo;
                            $A_related_prodimg = explode(',', $rel_productimg);
                            $productimage[$key] = $A_related_prodimg[0];
                            if($productvariant->in_stock >= $cart['product_qty']){
                                $sub_amt += ($cart['product_qty'] * $cart['price']);

                                //  if(count($coupon) > 0 && isset($coupon['product_id']) && $coupon['product_id'] == $cart['product_id']){
                                //   $tempdis=($tempsub_amt * $coupon['discount']/100);
                                //     $tempsub_amt=$tempsub_amt - $tempdis;
                                //   }

                            // $sub_amt+=$tempsub_amt;

                            }

                        } else {
                            // Handle the case where no product variant is found
                            $productimage[$key] = 'default_image.jpg'; // or any default image
                        }
                    } else {
                        // Handle the case where product_id or variant is missing
                        $productimage[$key] = 'default_image.jpg'; // or any default image
                    }
                }
            }

            $tamilnadu_shiprate=DB::table('state_list')->where('state','TAMIL NADU')->first();
            $shipping ='';
            if(!empty($tamilnadu_shiprate->shipping_charge)){
                $shipping= $sub_amt/100*$tamilnadu_shiprate->shipping_charge;
            }

               $coupon=Session::get('coupon',[]);
               if(count($coupon) > 0 &&  isset($coupon['product_id']) && $coupon['product_id'] < 1){
                   $amt=(($shipping + $sub_amt) * $coupon['discount']/100);
                    $totalAmount=($shipping + $sub_amt) - $amt;

               }else{
                $totalAmount=$shipping + $sub_amt;
               }
            $states=DB::table('state_list')->pluck('state','id','shipping_charge');

           $deliverycharges='';
           $deliverydetails =  DB::table('shippingcharges')->where('from', '<=', $sub_amt)->where('to', '>=', $sub_amt)->first();
           if(!empty($deliverydetails)){
               $deliverycharges=   $deliverydetails->amount;
                $totalAmount=$shipping + $sub_amt+$deliverycharges;
           }

            $deliveryshippingcharges = DB::table('state_list')->where('state','TAMIL NADU')->first();

            $shipid=$tamilnadu_shiprate->id;

        return view('frontend.pages.cart.index',compact('carts','states','productimage','shipid','coupon','sub_amt','shipping','totalAmount','deliverycharges'));
}
    public function getTotalAmount(Request $request){
        if(@auth()->guard('customer')->user()){
            $id=auth()->guard('customer')->user()->id;
            DB::enableQueryLog();
            $aCartData = DB::table('cart_tables')->select(DB::Raw('(cart_tables.product_qty*cart_tables.price) as sub_amt'))->join('product_variant','product_variant.product_id','=','cart_tables.product_id')->whereColumn('product_variant.arrtibute_name','=','cart_tables.arrtibute_name')->where('cart_tables.customer_id',$id)->get();
            $sub_amt = 0;
            foreach($aCartData as $aData){
                $sub_amt += $aData->sub_amt;
            }
            $total_amount = ($request->flat_rate != '') ? $sub_amt+$request->flat_rate : $sub_amt;
            return json_encode(array('total_amount' => $total_amount));
        }else{
            return '';
        }
    }

    //singke cart
    public function singlecartstore(Request $request){
        if(!empty(Session::get('coupon',[])))
            Session::put('coupon',[]);
        $customer_id = @auth()->guard('customer')->user()->id;
        $product_id=$request->product_id;
        $product_variant=DB::table('product_variant')->where('product_id',$product_id)->orderBy('id','DESC')->first();
        $product=DB::table('products')->where('id',$product_id)->first();
        $duplicate_check=DB::table('cart_tables')->where('product_id',$product_id)->where('customer_id',$customer_id)->first();
        //get Sale Price
        $saleprice= $this->fetchSalePrice($product_variant->regular_price,$product->tax_id,$product->discount,$product->discount_type);
        // Session::forget('cart');
        $aNewCartData = array(
            'product_id' => $product_id,
            'product_qty' => 1,
            'product_name' => $product->title,
            'price' => $saleprice['sale_price'],
            'arrtibute_name' => $product_variant->arrtibute_name,
            'status' => 'active'
        );
        $aCartData = Session::get('cart',[]);
        if(!empty($aCartData[$product_id])){
            $aCartData[$product_id]['product_qty']++;
        } else {
            $aCartData[$product_id] = $aNewCartData;
        }
        Session::put('cart',$aCartData);
        $response['product_count']=( $aCartData[$product_id]['product_qty']);
        $response['success'] =true;
        // echo '<pre>';
        // var_dump(Session::get('cart'));
        // return 'hello';
        if(@auth()->guard('customer')->user()){
            if(empty($duplicate_check)){
                $data=new CartTable;
                $data->product_id = $product_id;
                $data->product_name = $product->title;
                $data->product_qty = 1;
                //  $data->rowId=$result->rowId;
                $data->price = $saleprice['sale_price'];
                //  $data->options = json_encode($product_option);
                $data->arrtibute_name=$product_variant->arrtibute_name;
                $data->status = 'active';
                $data->customer_id = $customer_id;
                $data->save();
                $response['success'] =true;
            } else{
                DB::table('cart_tables')->where('product_id',$product_id)->where('customer_id',$customer_id)->update(['product_qty'=>$duplicate_check->product_qty+1]);
                    $response['success'] =false;
            }
            $prod_count=CartTable::where('product_id', $request->product_qty)->where('customer_id',$customer_id)->first();
            if(!empty($prod_count))
                $response['product_count']=($prod_count->product_qty);
            else
                $response['product_count']=1;
        }
        $response['sale_price'] = $saleprice['sale_price'];
        $rendered_headerwish=view('frontend.header_wishlist')->render();
        $response['rendered_headerwish']=$rendered_headerwish;
        $rendered_headercart=view('frontend.header_cartlist')->render();
        $response['rendered_headercart']=$rendered_headercart;
        $rendered_footercartlist=view('frontend.pages.cart.cart_table')->render();
        $response['rendered_footercartlist']=$rendered_footercartlist;
        // else{
        //     $cart = session()->get('single_cart', []);
        //     if(isset($cart[$product_id])) {
        //         $cart[$product_id]['quantity']++;
        //     } else {
        //         $cart[$product_id] = [
        //             "product_id" => $request->product_id,
        //             "quantity" => 1,
        //         ];
        //     }
        //     dd($cart);
        // }
        return json_encode($response);
    }
    public function cartstore(Request $request){

        $response=array();

        if (Auth::guard('users')->check()) {
            $customer_id = auth()->guard('users')->user()->id;
        } elseif (Auth::guard('guest')->check()) {
            $customer_id = auth()->guard('guest')->user()->id;
        } else {
            $customer_id ='';
        }

        $product=Product::where('status','active')->where('id',$request->product_id)->first();

        if(!empty($request->product_varients_id)){
             $productvariant=ProductVariant::where('status','active')->orderBy('id','DESC')->where('id',$request->product_varients_id)->first();
        }else{
             $productvariant=ProductVariant::where('status','active')->orderBy('id','DESC')->where('product_id',$product->id)->first();
        }

        $productimg = $productvariant->photo;
        $A_related_prodimg = explode(',', $productimg);
        //$customer_id = @auth()->guard('users')->user()->id;
        $product_id=$request->product_id;
        $product_varients_id=$request->product_varients_id;

        if(!empty($request->product_varients_id)){
            $product_variant=ProductVariant::where('id',$request->product_varients_id)->orderBy('id','DESC')->where('status','active')->first();
        }else{
            $product_variant=ProductVariant::where('product_id',$product_id)->orderBy('id','DESC')->where('status','active')->first();
        }

        $duplicate_check=DB::table('cart_tables')->where('product_varient',$request->product_varients_id)->where('customer_id',$customer_id)->first();
        //get Sale Price
        $saleprice= $this->fetchSalePrice($product_variant->regular_price,$product->tax_id,$product->discount,$product->discount_type);

        $ADiscountpercent=0;
        $price ='';
        $discount='';
       if($product->discount_type=="fixed"){

            $ADiscountpercent=$product->discount;
            $price = $product_variant->regular_price - $product->discount;
            $discount = '';

        }else{
            if($product_variant->regular_price!=0){
                $ADiscountpercent=( $product_variant->regular_price/100)*$product->discount;
            }else{
                 $ADiscountpercent=0;
            }
            $price = $product_variant->regular_price - $ADiscountpercent;
             $discount = '%';

        }

         //Session::forget('cart');
        $aNewCartData = array(
            'product_id' => $product_id,
             'product_varients_id' => $product_varients_id,
            'product_qty' => $request->product_qty,
            'product_name' => $product->name,
            'product_color' => $request->product_color,
            'product_varient'=>$product_variant->id,
            'price' => $price,
            'variant' => $product_variant->variants,
            'status' => 'active'
        );

        $aCartData = Session::get('cart',[]);

       /*
        if(!empty($aCartData[$product_varients_id])){

             $aCartData[$product_varients_id]['product_qty']++;

          } else {
            $aCartData[$product_varients_id] = $aNewCartData;

        }
        */

        if (!empty($aCartData[$product_varients_id])) {
            // Check out of stock | Restrict to add to cart
            $allowCheck = self::beforeAddToCart($product_varients_id, $aCartData[$product_varients_id]['product_qty'], $request->product_qty);

            $aCartData[$product_varients_id]['product_qty'] += $request->product_qty;

            if (!empty($request->product_color)) {
                $aCartData[$product_varients_id]['colors'] = $aCartData[$product_varients_id]['colors'] ?? [];
                if (!in_array($request->product_color, $aCartData[$product_varients_id]['colors'])) {
                    array_push($aCartData[$product_varients_id]['colors'], $request->product_color);
                }
            }
        } else {
            $aNewCartData['colors'] = [$request->product_color];
            $aCartData[$product_varients_id] = $aNewCartData;
            // Check out of stock | Restrict to add to cart
            $allowCheck = self::beforeAddToCart($product_varients_id, $aCartData[$product_varients_id]['product_qty'], 0);
        }

        // Check out of stock | Restrict to add to cart
        if (!$allowCheck['allow_add_to_card'])
            return response()->json($allowCheck);

        Session::put('cart',$aCartData);

        $response['product_count']=( $aCartData[$product_varients_id]['product_qty']);
        $response['success'] =true;

        if(@auth()->guard('users')->user()){
            if(empty($duplicate_check)){

                $data=new CartTable;
                $data->product_id = $product_id;
                $data->product_name = $product->name;
                $data->product_qty = $request->product_qty;
                $data->product_color = $request->product_color;
                $data->product_varient = $product_variant->id;
                $data->price = $price;
                $data->arrtibute_name=$product_variant->variants;
                $data->status = 'active';
                $data->customer_id = $customer_id;

                $data->save();
                $response=true;
                 //$response['product_count']=1;
            } else{

                if(isset($request->product_varients_id)){

                   $cart_val=DB::table('cart_tables')->where('product_varient',$request->product_varients_id)->where('customer_id',$customer_id)->first();
                   if($request->product_color){
                       $colors = $cart_val->product_color.','.$request->product_color;
                   }
                   if(!empty($colors)){

                        DB::table('cart_tables')->where('product_varient',$request->product_varients_id)->where('customer_id',$customer_id)->update(['product_qty'=>$cart_val->product_qty + $request->product_qty,'product_color'=>$colors]);

                   }else{

                        DB::table('cart_tables')->where('product_varient',$request->product_varients_id)->where('customer_id',$customer_id)->update(['product_qty'=>$cart_val->product_qty + $request->product_qty,'product_color'=>'']);

                   }

                }else{

                    $cart_val=DB::table('cart_tables')->where('product_varient',$request->product_varients_id)->where('customer_id',$customer_id)->first();
                    DB::table('cart_tables')->where('product_varient',$request->product_varients_id)->where('customer_id',$customer_id)->update(['product_qty'=>$cart_val->product_qty + $request->product_qty]);
                }

                     $prod_count=CartTable::where('product_varient', $request->product_varients_id)->where('customer_id',$customer_id)->first();
                      $response['product_count']=($prod_count->product_qty);
            }
            $prod_count=CartTable::where('product_varient', $request->product_varients_id)->where('customer_id',$customer_id)->first();

         }

         if(@auth()->guard('guest')->user()){
            if(empty($duplicate_check)){

                $data=new CartTable;
                $data->product_id = $product_id;
                $data->product_name = $product->name;
                $data->product_qty = $request->product_qty;
                $data->product_color = $request->product_color;
                $data->product_varient = $product_variant->id;
                $data->price = $price;
                $data->arrtibute_name=$product_variant->variants;
                $data->status = 'active';
                $data->type = 2;
                $data->customer_id = $customer_id;

                $data->save();
                $response=true;
                 //$response['product_count']=1;
            } else{

                if(isset($request->product_varients_id)){

                   $cart_val=DB::table('cart_tables')->where('product_varient',$request->product_varients_id)->where('customer_id',$customer_id)->first();
                   if($request->product_color){
                       $colors = $cart_val->product_color.','.$request->product_color;
                   }
                   if(!empty($colors)){

                        DB::table('cart_tables')->where('product_varient',$request->product_varients_id)->where('customer_id',$customer_id)->update(['product_qty'=>$cart_val->product_qty + $request->product_qty,'product_color'=>$colors]);

                   }else{

                        DB::table('cart_tables')->where('product_varient',$request->product_varients_id)->where('customer_id',$customer_id)->update(['product_qty'=>$cart_val->product_qty + $request->product_qty,'product_color'=>'']);

                   }

                }else{

                    $cart_val=DB::table('cart_tables')->where('product_varient',$request->product_varients_id)->where('customer_id',$customer_id)->first();
                    DB::table('cart_tables')->where('product_varient',$request->product_varients_id)->where('customer_id',$customer_id)->update(['product_qty'=>$cart_val->product_qty + $request->product_qty]);
                }

                     $prod_count=CartTable::where('product_varient', $request->product_varients_id)->where('customer_id',$customer_id)->first();
                      $response['product_count']=($prod_count->product_qty);
            }
            $prod_count=CartTable::where('product_varient', $request->product_varients_id)->where('customer_id',$customer_id)->first();
            // if(!empty($prod_count))
                // $response['product_count']=($prod_count->product_qty);
             //else
               //  $response['product_count']=1;
         }

        if(auth()->guard('users')->user()){

            $carts=DB::table('cart_tables')->where('customer_id',auth()->guard('users')->user()->id)->where('status','active')->get();
            $cartcount=count($carts);
        }else if(auth()->guard('guest')->user()){
              $carts=DB::table('cart_tables')->where('customer_id',auth()->guard('guest')->user()->id)->where('status','active')->get();
             $cartcount=count($carts);
        }else{
            $carts =Session::get('cart',[]);
            $cartcount=count($carts);
        }

        $sub_amt=0;
        $productimage=array();
        foreach($carts as $key=>$cart){

            if(auth()->guard('users')->user()){
                    $productvariant=ProductVariant::where('status','active')->where('product_id',$cart->product_id)->where('variants',$cart->arrtibute_name)->first();
                    array_push($productimage,$productvariant->photo);
                    $sub_amt +=($cart->product_qty * $cart->price);
            }else if(auth()->guard('guest')->user()){
                     $productvariant=ProductVariant::where('status','active')->where('product_id',$cart->product_id)->where('variants',$cart->arrtibute_name)->first();
                    array_push($productimage,$productvariant->photo);
                    $sub_amt +=($cart->product_qty * $cart->price);
            }else{

                //  var_dump($cart['variant']);
                //  var_dump($cart['product_id']);
                $productvariant=ProductVariant::where('status','active')->where('product_id',$cart['product_id'])->where('variants',$cart['variant'])->first();
               //  var_dump($productvariant->photo);
                array_push($productimage,$productvariant->photo);
                $sub_amt +=($cart['product_qty'] * $cart['price']);
            }
        }
         //exit;
        // $response['sale_price'] = $saleprice['sale_price'];
        $cart_header_render=view('frontend.header_cartlist',['cartcount'=>$cartcount])->render();
        // $response['cart_header_render']=$cart_header_render;
        $cart_table_render=view('frontend.pages.cart.cart_table',['carts'=>$carts,'sub_amt'=>$sub_amt])->render();
        // $response['cart_table_render']=$cart_table_render;
       // Session::put('success','Added to cart');
       return response()->json(['A_related_prodimg'=>$A_related_prodimg[0],'cart_table_render'=>$cart_table_render,'cart_header_render'=>$cart_header_render,'response'=>$response,'productvariant'=>$productvariant,'product'=>$product,json_encode($response)]);
    }
    public function bynow(Request $request){
        @$customer_id = auth()->guard('customer')->user()->id;
       $product_qty = $request->input('product_qty');
       $product_id = $request->input('product_id');
       $product_option = $request->input('product_option');
       $arrtibute_value = $request->input('arrtibute_value');
       $price = $request->input('price');
       $product=Product::getProductByCart($product_id);
      // $price=($product[0]['offer_price']) ? $product[0]['offer_price'] : $product[0]['price'];
     //  dd($price);
     $title=$product[0]['title'];
     $tax_rate= $product[0]['tax_value'];
     $cart_array=[];
     foreach(Cart::instance('shopping')->content() as $item){
        $cart_array[]=$item->id;
     }
     $result=Cart::instance('shopping')->add($product_id,$product[0]['title'],$product_qty,$price,$product_option,$tax_rate)->associate('App\Models\Product');
     $result1=Cart::instance('shopping_variant')->add($product_id,$product[0]['title'],$product_qty,$price,$product_option,$tax_rate)->associate('App\Models\ProductVariant');
     if(@auth()->guard('customer')->user()){
     $cartt=CartTable::where(['product_id'=>$product_id,'customer_id'=>$customer_id])->get();
     if(!empty(@$cartt[0]['id'])){
    $data=CartTable::where(['product_id'=>$product_id,'customer_id'=>$customer_id])->update(['product_qty'=>($cartt[0]['product_qty']+$product_qty)]);
}
else{
     $data=new CartTable;
     $data->customer_id = $customer_id;
     $data->product_id = $product_id;
     $data->product_name = $title;
     $data->product_qty = $product_qty;
     $data->rowId=$result->rowId;
     $data->price = $price;
     $data->arrtibute_name = $arrtibute_value;
     $data->options = json_encode($product_option);
     $data->status = 'active';
     $data->save();
}
     }
     if($result){
         $response['status']=true;
         $response['product_id']=$product_id;
         $response['total']=Cart::subtotal();
         $response['cart_count']=Cart::instance('shopping')->count();
         $response['message']="Item was added to your cart";
     }
     if($request->ajax()){
         $header=view('frontend.layouts.header')->render();
         $response['header']=$header;
     }
     return json_encode($response);
    }

    public function updatePage($shipping_id) {
        Session::forget('coupon');

        if(auth()->guard('users')->user() || auth()->guard('guest')->user()){
            // $carts=DB::table('cart_tables')->where('customer_id',auth()->guard('users')->user()->id)->where('status','active')->get();
             $carts=DB::table('cart_tables')->selectRaw('cart_tables.*,product_variants.in_stock')->Join('product_variants','product_variants.id','cart_tables.product_varient')
            //   ->where('product_variants.in_stock','>',0)
               ->where('customer_id', auth()->guard('users')->user()->id ?? auth()->guard('guest')->user()->id)
->get();

            $cartcount=count($carts);
        }else{
            $carts =Session::get('cart',[]);
            $cartcount=count($carts);
        }

        $coupon=Session::get('coupon',[]);
        $productimage=array();
        $tamilnadu_shiprate=DB::table('state_list')->where('id',$shipping_id)->first();
        $sub_amt=0;
        $shipping=$tamilnadu_shiprate->shipping_charge;
        foreach($carts as $key=>$cart){
            if(auth()->guard('users')->user() || auth()->guard('guest')->user()){

                    $productvariant=ProductVariant::where('status','active')->where('product_id',$cart->product_id)->where('variants',$cart->arrtibute_name)->first();
                    $A_prodimg = explode(',', $productvariant->photo);
                    array_push($productimage,$A_prodimg[0]);
                    $sub_amt +=($cart->product_qty * $cart->price);
            }else{
              /*
                $productvariant=ProductVariant::where('status','active')->where('product_id',$cart['product_id'])->where('variants',$cart['variant'])->first();
                $rel_productimg = $productvariant->photo;
                $A_related_prodimg = explode(',', $rel_productimg);
                $productimage[$key] = $A_related_prodimg[0];
                $sub_amt +=($cart['product_qty'] * $cart['price']);
                */
                if (array_key_exists('product_id', $cart)) {
                        $productvariant = ProductVariant::where('status', 'active')
                                            ->where('product_id', $cart['product_id'])
                                            ->where('variants', $cart['variant'])
                                            ->first();

                        // Check if $productvariant is not null before accessing its properties
                        if ($productvariant) {
                            $rel_productimg = $productvariant->photo;
                            $A_related_prodimg = explode(',', $rel_productimg);
                            $productimage[$key] = $A_related_prodimg[0];
                            $sub_amt += ($cart['product_qty'] * $cart['price']);
                        } else {
                            // Handle case where no product variant is found
                            // You might want to log an error or handle this case appropriately
                        }
                    } else {
                        // Handle case where 'product_id' key is not found in $cart array
                        // You might want to log an error or handle this case appropriately
                    }
            }
        }
        if(count($coupon) > 0){
            $amt=(($sub_amt) * $coupon['discount']/100);
             $totalAmount=($shipping + $sub_amt) - $amt;
        }else{
       $totalAmount=$shipping + $sub_amt;
        }
        // echo '<pre>';
        //     var_dump($productimage);
        //     exit;
        if(auth()->guard('users')->user() || auth()->guard('guest')->user()){
        $wishlists=DB::table('wishlists')->where('customer_id', auth()->guard('users')->user()->id ?? auth()->guard('guest')->user()->id)->where('status','active')->get();
        $wishlistcount=count($wishlists);
        $products=DB::table('cart_tables')->where('customer_id', auth()->guard('users')->user()->id ?? auth()->guard('guest')->user()->id)->where('status','active')->get();
    }else{
            $wishlists=[];
            $wishlistcount=0;
            $products=Session::get('cart',[]);
        }

        $cart_header_render=view('frontend.header_cartlist',['cartcount'=>$cartcount])->render();
        $response['cart_header_render']=$cart_header_render;

        $cart_table_render=view('frontend.pages.cart.cart_table',['carts'=>$carts,'sub_amt'=>$sub_amt,'coupon'=>$coupon,'shipping'=>$shipping])->render();
        $response['cart_table_render']=$cart_table_render;

        $cart_productlist_render=view('frontend.pages.cart.main_cartlist',['carts'=>$carts,'productimage'=>$productimage,'sub_amt'=>$sub_amt])->render();
        $response['cart_productlist_render']=$cart_productlist_render;

        $ajaxupdate_render=view('frontend.pages.cart.ajax_update',['sub_amt'=>$sub_amt,'coupon'=>$coupon,'shipid'=>$shipping_id,'shipping'=>$shipping,'totalAmount'=>$totalAmount,'carts'=>$carts])->render();
        $response['ajaxupdate_render']=$ajaxupdate_render;

        $wishlist_header_render=view('frontend.header_wishlist',['wishlists'=>$wishlists,'wishlistcount'=>$wishlistcount])->render();
        $response['wishlist_header_render']=$wishlist_header_render;
      //  if(auth()->guard('users')->user()){
        $payment_info=view('frontend.pages.checkout.payment_info',['shipping'=>$shipping,'sub_amt'=>$sub_amt,'products'=>$products,'coupon'=>$coupon])->render();
        $response['payment_info']=$payment_info;
     //   }

        // if(auth()->guard('users')->user()){
        // $render_checkoutproduct_table=view('frontend.pages.checkout.checkoutproduct_table',['sub_amt'=>$sub_amt,'shipid'=>$shipping_id,'coupon'=>$coupon,'shipping'=>$shipping,'totalAmount'=>$totalAmount,'carts'=>$carts])->render();
        // $response['render_checkoutproduct_table']=$render_checkoutproduct_table;
        // }
        return $response;
}
public function cartDelete(Request $request)
{
    // Clear coupon session data
    Session::forget('coupon');

    // Retrieve cart data from session
    $cartData = Session::get('cart', []);
    if($request->product_varient){
        $product_varient = $request->product_varient;
    }

    // Determine customer ID based on authentication status
    if (Auth::guard('users')->check()) {
        $customer_id = Auth::guard('users')->user()->id;
        // Delete cart item from database for authenticated users

         if($request->product_varient){
            $product_varient = $request->product_varient;

            DB::table('cart_tables')
                ->where('product_varient', $request->product_varient)
                ->where('customer_id', $customer_id)
                ->delete();
        }else{

          DB::table('cart_tables')
            ->where('product_id', $request->product_id)
            ->where('customer_id', $customer_id)
            ->delete();
        }

    } elseif (Auth::guard('guest')->check()) {
        $customer_id = Auth::guard('guest')->user()->id;
        // Delete cart item from database for guests
        DB::table('cart_tables')
            ->where('product_id', $request->product_id)
            ->where('product_varient', $request->product_varient)
            ->where('customer_id', $customer_id)
            ->delete();
    }

    // Remove item from session cart
    unset($cartData[$request->product_varient]);
    Session::put('cart', $cartData);

    // Perform any additional logic or updates needed
    $response = $this->updatePage($request->shipping_id);

    // Return updated response
    return $response;
}
public function changeCartQuantity(Request $request){
    if(!empty(Session::get('coupon',[])))
        Session::put('coupon',[]);
    $customer_id = @auth()->guard('customer')->user()->id;
    if(@auth()->guard('customer')->user()){
        //DB Cart Data
        $oCartData = CartTable::select('product_qty')->where(
            array(
                'customer_id' => $customer_id,
                'product_id' => $request->product_id
            )
        )->first();
        //Session Cart Data
        $aSessionCartData = Session::get('cart',[]);
        // echo '<pre>';
        // // var_dump($oCartData);
        // var_dump($aSessionCartData);
        // exit;
        if($request->mode == 'inc') {
            $newQuantity = $oCartData->product_qty+1;
            $aSessionCartData[$request->product_id]['product_qty']++;
        } else {
            // Don't allow decrementing below zero
            if($oCartData->product_qty > 1) {
                $newQuantity = $oCartData->product_qty-1;
                if(isset($aSessionCartData[$request->product_id]))
                    $aSessionCartData[$request->product_id]['product_qty']--;
            } else {
                $newQuantity = 1;
                $aSessionCartData[$request->product_id]['product_qty'] = 1;
            }
        }
        CartTable::where(
            array(
                'customer_id' => $customer_id,
                'product_id' => $request->product_id
            )
        )->update(array('product_qty' => $newQuantity));
        Session::put('cart',$aSessionCartData);
        $response = $this->updatePage($customer_id);
    }
    return json_encode($response);
}
public function sessionDelete(Request $request)
{
    $customer_id = @auth()->guard('customer')->user()->id;
    // $product_variant=DB::table('product_variant')->where('product_id',$product_id)->orderBy('id','DESC')->first();
        // if(count($duplicate_check) <= 0){
            $aCartData = Session::get('cart',[]);
unset($aCartData[$request->product_id]);
Session::put('cart',$aCartData);
        $response['success'] =true;
        $rendered_headerwish=view('frontend.header_wishlist')->render();
        $response['rendered_headerwish']=$rendered_headerwish;
        $rendered_headercart=view('frontend.header_cartlist')->render();
        $response['rendered_headercart']=$rendered_headercart;
        $rendered_footercartlist=view('frontend.pages.cart.cart_table')->render();
        $response['rendered_footercartlist']=$rendered_footercartlist;
        // else{
        //     $cart = session()->get('single_cart', []);
        //     if(isset($cart[$product_id])) {
        //         $cart[$product_id]['quantity']++;
        //     } else {
        //         $cart[$product_id] = [
        //             "product_id" => $request->product_id,
        //             "quantity" => 1,
        //         ];
        //     }
        //     dd($cart);
        // }
        return json_encode($response);
   }
   public function cartUpdate(Request $request)
   {
    $customer_id = @auth()->guard('users')->user()->id;
    $aCartData = Session::get('cart',[]);
    if(@auth()->guard('users')->user()){
    CartTable::where('product_id',$request->product_id)->where('customer_id',$customer_id)->update(['product_qty'=>$request->product_qty]);
    }else{
        $aCartData[$request->product_id]['product_qty']=$request->product_qty;
    }
    Session::put('cart',$aCartData);
    $response = $this->updatePage($request->shipping_id);
    return $response;
   }
   public function couponAdd(Request $request)
   {
       $coupon=Coupon::where('coupon_code',$request->input('coupon_code'))->first();
      //return $coupon;
      if(!$coupon){
          return back()->with('error','Invalid coupan code,place enter valid coupon code');
      }
      if($coupon){
          $total_price=Cart::instance('shopping')->subtotal();
          session()->put('coupon',[
            'id'=>$coupon->id,
            'coupon_code'=>$coupon->coupon_code,
            'value'=>$coupon->discount($total_price)
        ]);
        request()->session()->flash('success','Coupon successfully applied');
        return redirect()->back();
      }
   }
   public function product_check(Request $request){
    $arrtibute_name=(implode(',',($request->arrtibute_name)));
    $product=DB::table('products')->where('id',$request->product_id)->first();
    $product_check=DB::table('product_variant')->where('product_id',$request->product_id)->where('arrtibute_name',$arrtibute_name)->first();
    $saleprice= $this->fetchSalePrice($product_check->regular_price,$product->tax_id,$product->discount,$product->discount_type);
    $salepriceval=number_format($saleprice['sale_price'], 2, '.', '');
    if(!empty($product_check)){
    $resval['success']=true;
   }else{
    $resval['success']=false;
   }
   return response()->json(['product_check'=>$product_check,'resval'=>$resval,'saleprice'=>$salepriceval]);
   }
   public function getSessionData(){
        $aData = Session::get('cart',[]);
        echo '<pre>';
        var_dump($aData);
        exit;
   }

   public function render_carttable(Request $request){
    $customer_id = @auth()->guard('users')->user()->id;
    $aCartData = Session::get('cart',[]);

    if(@auth()->guard('users')->user()){

      if($request->product_varient){
             if($request->product_qty == 0){
                 CartTable::where('product_varient',$request->product_varient)->where('customer_id',$customer_id)->delete();
             } else {
             CartTable::where('product_varient',$request->product_varient)->where('customer_id',$customer_id)->update(['product_qty'=>$request->product_qty]);
             }

      }else if ($request->product_id){
            if($request->product_qty == 0){
                            CartTable::where('product_id',$request->product_id)->where('customer_id',$customer_id)->delete();
            } else {
                CartTable::where('product_id',$request->product_id)->where('customer_id',$customer_id)->update(['product_qty'=>$request->product_qty]);
            }

      }

    }else{
        // $aCartData[$request->product_varient]['product_qty']=$request->product_qty;

        if($request->product_qty == 0){
            unset($aCartData[$request->product_varient]);

        } else {
            $aCartData[$request->product_varient]['product_qty']=$request->product_qty;
        }

        $tempProductData=DB::table('product_variants')->where('id',$request->product_varient)->first();
        foreach($aCartData as $key =>$each){
            $aCartData[$key]['in_stock'] = $tempProductData->in_stock;
        }
         Session::put('cart',$aCartData);

    }

    //  $aCartData[$request->product_varient]['in_stock'] = 1;

    $shipping=31;
    $response = $this->updatePage($shipping);
    return $response;
   }

   public static function beforeAddToCart($productVariantId, $addedCardCount, $requestToAddCount) {
      $productVariant = ProductVariant::where('id', $productVariantId)->first();

      $return['allow_add_to_card'] = true;
      $return['message'] = '';
      if ($productVariant) {
        if ($productVariant->in_stock < 1) {
            $return['allow_add_to_card'] = false;
            $return['message'] = 'Out of Stock';
        } else if ($productVariant->in_stock < ($addedCardCount + $requestToAddCount)) {
            $return['allow_add_to_card'] = false;
            $remainingCount = $productVariant->in_stock - $addedCardCount;
            if ($remainingCount < 1)
                $return['message'] = 'No more item can be added to Cart.';
            else
                $return['message'] = 'Only ' . ($productVariant->in_stock - $addedCardCount) . ' more item(s) can be added to Cart.';
        }
      }
      return $return;
   }
}

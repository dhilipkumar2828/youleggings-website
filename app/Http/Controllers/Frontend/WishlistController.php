<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Wishlist;

use App\Models\Product;

use DB;

use App\Traits\PriceTrait;

use App\Models\CartTable;

use App\Models\ProductVariant;

use App\Models\Visitors;

use Cart;

use Auth,Session;

class WishlistController extends Controller

{

    use PriceTrait;

    function __construct()

    {

        //  $this->userIp = \Request::ip();

        //  $this->locationData = \Location::get($this->userIp);

        //  \App\Http\Controllers\Frontend\WishlistController::visitors();

    }

    public function visitors(){

        //dd($this->locationData);

        if($this->locationData != false){

            $date=date('d-m-Y');

            $ip=$this->locationData->ip;

             $country=$this->locationData->countryCode;

            @$visitors =Visitors::where('ip_address',$ip)->orderBy('id','DESC')->get()[0];

        if(empty($visitors) or $visitors == null){

            $data['ip_address']=$ip;

            $data['country']=$country;

            $data['last_visits']=$date;

            $data['hits']=@$visitors->hits+1;

            $data['page_views']=@$visitors->page_views+1;

            Visitors::create($data);

        }

        else if($visitors->last_visits != $date){

            $visitors=Visitors::find($visitors->id);

            $data['last_visits']=$date;

            $data['hits']=$visitors->hits+1;

            $data['page_views']=$visitors->page_views+1;

            $User= $visitors->fill($data)->save();

        }

        else{

            $visitors=Visitors::find($visitors->id);

            $data['page_views']=$visitors->page_views+1;

            $User= $visitors->fill($data)->save();

           }

           }

           }

public function Wishlist()

{
          $this->sessionremove();

    if(Auth::guard('users')->check() || Auth::guard('guest')->check()){

  $id = auth()->guard('users')->check()
    ? auth()->guard('users')->user()->id
    : (auth()->guard('guest')->check()
        ? auth()->guard('guest')->user()->id
        : null);

    $wishlist=DB::table('wishlists')->where('status','active')->where('customer_id',$id)->get();

       //get Sale Price

       $sale_price=array();

       foreach($wishlist as $key => $wish){
            $product = DB::table('products')->where('id', $wish->product_id)->first();
            $variant = DB::table('product_variants')->where('id', $wish->rowId)->first();

            if ($product && $variant) {
                $saleprice = $this->fetchSalePrice($variant->regular_price, $product->tax_id, $product->discount, $product->discount_type);
                $wishlist[$key]->sale_price = $saleprice['sale_price'];
                array_push($sale_price, $saleprice['sale_price']);
            } else {
                // Handle the case when $variant or $product is null
                $wishlist[$key]->sale_price = 0; // or some default value
                array_push($sale_price, 0); // or some default value
            }
        }

    }else{

        $wishlist="";

        $sale_price=0;

    }

    return view('frontend.wishlist',compact('wishlist','sale_price'));

}

public function WishlistStore(Request $request)

{

if (Auth::guard('users')->check()) {
            $customer_id = auth()->guard('users')->user()->id;
        } elseif (Auth::guard('guest')->check()) {
            $customer_id = auth()->guard('guest')->user()->id;
        } else {
            $customer_id ='';
        }
    $product_id=$request->product_id;

    $product=Product::where('status','active')->where('id',$product_id)->first();

     if($request->product_varients_id!=''){
         $product_variant = DB::table('product_variants')->where('id',$request->product_varients_id)->first();
    }else{
        $product_variant = DB::table('product_variants')->where('product_id',$product_id)->where('in_stock','>','0')->first();

    }

    $rel_productimg = $product_variant->photo;

    $A_related_prodimg = explode(',', $rel_productimg);

    $duplicate_check=DB::table('wishlists')->where('product_id',$product_id)->where('customer_id',$customer_id)->get();

        if(@auth()->guard('users')->user() || @auth()->guard('guest')->user()){

                if(count($duplicate_check) <= 0){

                    $data=new Wishlist;

                    $data->customer_id = $customer_id;

                    $data->product_id = $product_id;

                    $data->arrtibute_name=$product_variant->variants;

                    $data->rowId=$product_variant->id;

                    $data->status = 'active';

                    $data->save();

                    $response['success'] =true;

                    $response['message']="Successfully added to your Wishlist";

                }else{

                DB::table('wishlists')->where('product_id',$product_id)->where('customer_id',$customer_id)->delete();

                    $response['success'] =false;

                    $response['message']="Successfully removed from your Wishlist";

                }
if(@auth()->guard('users')->user()){
                $wishlists=DB::table('wishlists')->where('customer_id',auth()->guard('users')->user()->id)->where('status','active')->get();
}
elseif (Auth::guard('guest')->check()) {
   $wishlists=DB::table('wishlists')->where('customer_id',auth()->guard('guest')->user()->id)->where('status','active')->get();
}

                $wishlistcount=count($wishlists);

             $response['product'] =$product;

             $response['product_variants'] =$product_variant;

             $wishlist_render=view('frontend.header_wishlist',['wishlists'=>$wishlists,'wishlistcount'=>$wishlistcount])->render();

             $response['wishlist_render']=$wishlist_render;

             $response['A_related_prodimg']=$A_related_prodimg[0];

            }

         else{

                $response['redirect'] =true;

                //return redirect('user/auth');

             }

             return $response;

}

public function wishlist_to_cart(Request $request){

    //$customer_id = @auth()->guard('users')->user()->id;
    if (Auth::guard('users')->check()) {
            $customer_id = auth()->guard('users')->user()->id;
        } elseif (Auth::guard('guest')->check()) {
            $customer_id = auth()->guard('guest')->user()->id;
        } else {
            $customer_id ='';
        }

    if(auth()->guard('users')->user() || auth()->guard('guest')->user()){

            //get Sale Price

        $cart_tables=CartTable::where('status','active')->where('product_id',$request->product_id)->where('customer_id',$customer_id)->first();
        $duplicate_check=DB::table('cart_tables')->where('product_varient',$request->product_varient_id)->where('customer_id',$customer_id)->first();

        if($duplicate_check==''){

                $product=Product::where('status','active')->where('id',$request->product_id)->first();

                $variant=ProductVariant::where('status','active')->orderBy('id','desc')->where('id',$request->product_varient_id)->first();

             $ADiscountpercent=0;
            $price ='';
            $discount='';
            if($product->discount_type=="fixed"){

                $ADiscountpercent=$product->discount;
                $price = $variant->regular_price - $product->discount;
                $discount = '';

            }else{
                if($variant->regular_price!=0){
                    $ADiscountpercent=( $variant->regular_price/100)*$product->discount;
                }else{
                     $ADiscountpercent=0;
                }
                $price = $variant->regular_price - $ADiscountpercent;
                 $discount = '%';

            }

            $saleprice= $this->fetchSalePrice($variant->regular_price,$product->tax_id,$product->discount,$product->discount_type);

            $cartsave=new CartTable();

            $cartsave->customer_id=$customer_id;

            $cartsave->product_id=$product->id;

            $cartsave->product_name=$product->name;

            $cartsave->arrtibute_name=$variant->variants;

            $cartsave->product_varient = $request->product_varient_id;

            $cartsave->product_qty=1;

            $cartsave->status="active";

            $cartsave->price= $price;

            $cartsave->save();

        }else{

             CartTable::where('status','active')->where('product_id',$request->product_id)->where('product_varient',$request->product_varient_id)
             ->update(['product_qty'=>$cart_tables->product_qty +1]);

        }

        Wishlist::where('product_id',$request->product_id)->delete();

        $wishlists=DB::table('wishlists')->where('customer_id',$customer_id)->where('status','active')->get();

        $wishlistcount=count($wishlists);

        $sale_price=array();

        $product_name=array();

        $productimage=array();

        foreach($wishlists as $key => $wish){

                $product=DB::table('products')->where('id',$wish->product_id)->first();

                $variant=DB::table('product_variants')->where('product_id',$wish->product_id)->where('variants',$wish->arrtibute_name)->first();

                $saleprice= $this->fetchSalePrice($variant->regular_price,$product->tax_id,$product->discount,$product->discount_type);

                $wishlists[$key]->sale_price = $saleprice['sale_price'];

                array_push($sale_price,$saleprice['sale_price']);

                array_push($product_name,$product->name);

                   $rel_productimg = $variant->photo;

                    $A_related_prodimg = explode(',', $rel_productimg);

                array_push($productimage,$A_related_prodimg[0]);

        }

    }

    $sub_amt=0;

    $carts=DB::table('cart_tables')->where('customer_id',$customer_id)->where('status','active')->get();

    $cartcount=count($carts);

    foreach($carts as $cart){

        $productvariant=ProductVariant::where('status','active')->where('product_id',$cart->product_id)->where('variants',$cart->arrtibute_name)->first();

        $rel_productimg = $productvariant->photo;

        $A_related_prodimg = explode(',', $rel_productimg);

        array_push($productimage,$A_related_prodimg[0]);

        $sub_amt +=($cart->product_qty * $cart->price);

    }

    $cart_header_render=view('frontend.header_cartlist',['cartcount'=>$cartcount])->render();

    $response['cart_header_render']=$cart_header_render;

    $wishlist_header_render=view('frontend.header_wishlist',['wishlists'=>$wishlists,'wishlistcount'=>$wishlistcount])->render();

    $response['wishlist_header_render']=$wishlist_header_render;

    $cart_table_render=view('frontend.pages.cart.cart_table',['carts'=>$carts,'sub_amt'=>$sub_amt])->render();

    $response['cart_table_render']=$cart_table_render;

     Wishlist::where('product_id',$request->product_id)->delete();

    $wishlisttable_render=view('frontend.wishlist_table',['wishlist'=>$wishlists,'sale_price'=>$sale_price,'product_name'=>$product_name,'productimage'=>$productimage])->render();

    $response['wishlisttable_render']=$wishlisttable_render;
    return $response;
}

// $product_qty = $request->input('product_qty');

// $product_id = $request->input('product_id');

// $arrtibute_option = $request->input('product_option');

// $arrtibute_name=$request->input('arrtibute_name');

// $product = Product::getProductByCart($product_id);

// $title = $product[0]['title'];

// $price = $product[0]['offer_price'];

// $wishlist_array=[];

// foreach(Cart::instance('wishlist')->content() as $item){

//     $wishlist_array[]=$item->id;

// }

// if(in_array($product_id,$wishlist_array)){

//     $response['present']=true;

//     Wishlist::where(['customer_id'=>auth()->guard('customer')->user()->id,'product_id'=>$item->id])->delete();

//     Cart::instance('wishlist')->remove($item->rowId);

// }

// else{

//     $result=Cart::instance('wishlist')->add($product_id,$product[0]['title'],$product_qty,$price)->associate('App\Models\Product');

//     if(@auth()->guard('customer')->user()){

//     $data=new Wishlist;

//     $data->customer_id = $customer_id;

//     $data->product_id = $product_id;

//     $data->rowId = $result->rowId;

//     $data->arrtibute_name=$arrtibute_name;

//     $data->arrtibute_option=json_encode($arrtibute_option);

//     $data->status = 'active';

//     $data->save();

//     }

// if($result){

//     $get_wishlist=DB::table('wishlists')->where('product_id',$product_id)->first();

// $response['status']=true;

// $response['message']="item has been saved in wishlist";

// $response['wishlist_count']=Cart::instance('wishlist')->count();

// $response['get_wishlist']=$get_wishlist;

// }

//}

// return json_encode($response);

public function movetoCart(Request $request)

{

    $id=explode('|',$request->input('rowId'));

    $customer_id = auth()->guard('customer')->user()->id;

    $wishlists_val=Wishlist::select('*')->where('product_id',$id[1])->first();

    $wishlist=Wishlist::where('product_id',$id[1])->delete();

    // $product_qty = $request->input('product_qty');

    $product_id = $id[1];

    //$productQuantity=$request->input('productQuantity');

    $item=Cart::instance('wishlist')->get($id[0]);

    $result=Cart::instance('shopping')->add($item->id,$item->name,1,$item->price)->associate('App\Models\Product');

$result12=Cart::instance('shopping_variant')->add($item->id,$item->name,1,$item->price)->associate('App\Models\ProductVariant');

    Cart::instance('wishlist')->remove($id[0]);

    if(auth()->guard('customer')->user()){

    $cartt=CartTable::where(['product_id'=>$product_id,'customer_id'=>$customer_id])->get();

    if(count($cartt) >0){

   $data=CartTable::where(['product_id'=>$product_id,'customer_id'=>$customer_id])->update(['product_qty'=>($cartt[0]['product_qty']+1)]);

}

else{

    $product = Product::getProductByCart($product_id);

    $get_product=Product::where('id',$product_id)->first();

$get_price=ProductVariant::where('product_id',$product_id)->where('arrtibute_name',$wishlists_val->arrtibute_name)->first();

$saleprice= $this->fetchSalePrice($get_price->regular_price,$get_product->tax_id,$get_product->discount,$get_product->discount_type);

    $data=new CartTable;

    $data->customer_id = $customer_id;

    $data->product_id = $product_id;

    $data->product_name = $product[0]['title'];

    $data->rowId=    $result->rowId;

    $data->product_qty = 1;

    $data->options=$wishlists_val->arrtibute_option;

    $data->arrtibute_name=$wishlists_val->arrtibute_name;

    $data->price= $saleprice['sale_price'];

    $data->status = 'active';

    $data->save();

}

    }

    //Cart::instance('shopping')->update($id,$request_quantity);

    if($result){

        $response['status']=true;

        $response['message']="item has been moved to cart";

        $response['cart_count']=Cart::instance('shopping')->count();

    }

    if($request->ajax()){

        $wishlist=view('frontend.layouts._wishlist')->render();

        $header=view('frontend.layouts.header')->render();

        $response['wishlist_list']=$wishlist;

        $response['header']=$header;

    }

    return $response;

 }

 public function wishlistDelete(Request $request)

 {

    if(auth()->guard('users')->user() || auth()->guard('guest')->user()){

        if (Auth::guard('users')->check()) {
            $customer_id = auth()->guard('users')->user()->id;
        } elseif (Auth::guard('guest')->check()) {
            $customer_id = auth()->guard('guest')->user()->id;
        } else {
            $customer_id ='';
        }
        $wishlist=Wishlist::where(['customer_id'=>$customer_id,'product_id'=>$request->product_id])->delete();

     //   $id=auth()->guard('users')->user()->id;

        //get Sale Price

        $sale_price=array();

        $product_name=array();

        $productimage=array();

        $wishlists=DB::table('wishlists')->where('customer_id',$customer_id)->where('status','active')->get();

        //get Sale Price

        $wishlistcount=count($wishlists);

        foreach($wishlists as $key => $wish){

                $product=DB::table('products')->where('id',$wish->product_id)->first();

                $variant=DB::table('product_variants')->where('product_id',$wish->product_id)->where('variants',$wish->arrtibute_name)->first();

                $saleprice= $this->fetchSalePrice($variant->regular_price,$product->tax_id,$product->discount,$product->discount_type);

                $wishlists[$key]->sale_price = $saleprice['sale_price'];

                array_push($sale_price,$saleprice['sale_price']);

                array_push($product_name,$product->name);

                array_push($productimage,$variant->photo);

        }

     }else{

        $wishlist="";

        $sale_price=0;

     }

     $wishlisttable_render=view('frontend.wishlist_table',['sale_price'=>$sale_price,'product_name'=>$product_name,'productimage'=>$productimage,'wishlist'=>$wishlists])->render();

     $response['wishlisttable_render']=$wishlisttable_render;

     $wishlist_header_render=view('frontend.header_wishlist',['wishlists'=>$wishlists,'wishlistcount'=>$wishlistcount])->render();

    $response['wishlist_header_render']=$wishlist_header_render;

     //$wishlistcount=Wishlist::count();

     $response['success'] =true;

    return $response;

 }

}

<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;

use App\Models\ProductAttribute;

use App\Models\ProductVariant;

use App\Models\ProductReviews;

use App\Models\CustomerTable;

use App\Traits\PriceTrait;

use Illuminate\Support\Facades\Hash;

use App\Models\Banner;

use App\Models\BillingAddress;

use App\Models\ShippingAddress;

use App\Models\Wishlist;

use App\Models\Visitors;

use App\Models\OrderProduct;

use App\Models\Category;

use App\Models\Brand;

use App\Models\Order;

use App\Models\User;

use App\Models\Guest;

use Customer;

use App\Models\CartTable;


use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Arabic;


class WhatisnewController extends Controller

{

    use PriceTrait;

    function __construct()

    {

         //$this->userIp = \Request::ip();

        //  $this->locationData = \Location::get($this->userIp);

         //\App\Http\Controllers\Frontend\WhatisnewController::visitors();

    }

    public function visitors(){

        //dd($this->locationData);

        // if($this->locationData != false){

            $date=date('d-m-Y');

            $ip = request()->ip();
            $country = 'IN'; // Default fallback
            @$visitors = Visitors::where('ip_address', $ip)->orderBy('id', 'DESC')->first();
            if (empty($visitors)) {
                $data['ip_address'] = $ip;
                $data['country'] = $country;

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

        // }

    }

    public function whatisnew(request $request)

    {

              $this->sessionremove();

            $aProductvariant_photo=array();

            $aProductSaleprice=array();

            $aDiscountpercent=array();

            $products=Product::where('status','active')->orderBy('id',"desc")->get();

            $categories=Category::where('is_parent',0)->where('status','active')->get();

            $a_Products=Product::where('status','active')->get();

            $n_Products=array();

            $n_Productvariant_photo=array();

            $n_ProductSaleprice=array();

            foreach($products as $key=>$product){

                // var_dump($key);

                $variant=ProductVariant::where('product_id',$product->id)->where('status','active')->first();

               $category=Category::where('is_parent',0)->where('status','active')->whereIn('id', explode(',',$product->category))->where('home','active')->first();

                $saleprice= $this->fetchSalePrice($variant->regular_price,$product['tax_id'],$product['discount'],$product['discount_type']);

                $A_prodimg = explode(',', $variant->photo);

                array_push($aProductvariant_photo,$A_prodimg[0]);

                array_push($aProductSaleprice,$saleprice['sale_price']);

                // Calculate discount percent
                if ($product->discount_type == "fixed") {
                    if ($variant && $variant->regular_price != 0) {
                        array_push($aDiscountpercent, ($product->discount / $variant->regular_price) * 100);
                    } else {
                        array_push($aDiscountpercent, 0);
                    }
                } else {
                    array_push($aDiscountpercent, $product->discount);
                }

             }

             foreach($a_Products as $product){

                $variant=ProductVariant::where('product_id',$product->id)->where('status','active')->first();

                $category=Category::where('is_parent',0)->where('status','active')->whereIn('id', explode(',',$product->category))->where('home','active')->first();

                if(isset($category) && isset($product)){

                    if (in_array($category->id, explode(',',$product->category))){

                        array_push($n_Products,$product);

                    }

                }

            }

        $iswishlist=array();

        $ahover_image_photo=array();

            //for new arrivals

            foreach($n_Products as $key=>$product){

                // var_dump($key);

                $variant=ProductVariant::where('product_id',$product->id)->where('status','active')->first();

               $category=Category::where('is_parent',0)->where('status','active')->whereIn('id', explode(',',$product->category))->where('home','active')->first();

                $saleprice= $this->fetchSalePrice($variant->regular_price,$product['tax_id'],$product['discount'],$product['discount_type']);

                $A_prodimg = explode(',', $variant->photo);

                array_push($n_Productvariant_photo,$A_prodimg[0]);

                if(count($A_prodimg) > 1){

                    array_push($ahover_image_photo,$A_prodimg[1]);

                }else{

                    array_push($ahover_image_photo,$A_prodimg[0]);

                }

                array_push($n_ProductSaleprice,$saleprice['sale_price']);

                if(auth()->guard('users')->user()){

                    $wishlist=Wishlist::where('product_id',$product->id)->where('customer_id',auth()->guard('users')->user()->id)->first();

                    if(isset($wishlist)){

                        array_push($iswishlist,'yes');

                    }else{

                        array_push($iswishlist,'no');

                    }

                }

             }

            $highest_rate = Product::where('status', 'active')->max('regular_price') ?? 0;

            $slug = null;

            return view('frontend.whatsnew',compact('products','ahover_image_photo','iswishlist','categories','n_Products','aProductSaleprice','aProductvariant_photo','n_ProductSaleprice','n_Productvariant_photo','aDiscountpercent','highest_rate','slug'));

    }

    public static function productreview($id){

        $productreview= ProductReviews::where('product_id',$id)->get();

        $review_reject =

//        $productreviewavg= ProductReviews::where('product_id',$id)->avg('rate');

        $avg = 0;

foreach($productreview as $rev){

 $avg += $rev->rate;

}

$reviewrate=($avg) ? round($avg/count($productreview)) : 0;

$review=count($productreview);

$reviews="";

$reviewrate1=($reviewrate != 0) ? $reviewrate : 5;

for($i=0; $i<$reviewrate1;$i++):

if($reviewrate != 0):

   $reviews .='<i class="fas fa-star"></i>';

elseif($reviewrate != 5 or $reviewrate == 0):

    $reviews .='<i class="far fa-star"></i>';

endif;

endfor;

$reviews .='<span>'.$review.' Rating(s)</span>';

return $reviews;

    }

    public function show($id)

    {

        $products= Product::with('rel_prods')->where('slug',$id)->first();

        $variant_value=ProductVariant::where('product_id',$products->id)->orderBy('id','desc')->first();

        //$product_orders=ProductAttribute::where('product_id',$products->id)->get();

        $product_orders=ProductAttribute::distinct('arrtibute_name')->where('product_id',$products->id)->get(['arrtibute_name']);

        // $data=array();

        // $data['Colour'] = DB::table('product_attributes')->select('arrtibute_name','id')

        // ->where('product_id',$products->id)->groupby('arrtibute_name')

        // ->get();

        // $data['size'] = DB::table('product_attributes')->select('arrtibute_value','id')

        // ->where('product_id',$products->id)->groupby('arrtibute_value')

        // ->get();

       // print_r($data);

        //echo count($product_orders);

        //print_r($product_orders[1]);

        $data=array();

        foreach($product_orders as $value){

            $data[$value->arrtibute_name] = DB::table('product_attributes')->select('arrtibute_name','arrtibute_value','id')

            ->where('product_id',$products->id)

            ->where('arrtibute_name',$value->arrtibute_name)

            ->get();

        }

        //print_r($data['Colour']);

        //print_r($product_orders);

        //distinct()->whereNotNull(‘meta_value’)->get([‘meta_value’]);

        // echo $products->id;

        // foreach($product_orders as $value){

        //  echo $value->arrtibute_name;

        // }

        //die();

        return view('frontend.pages.product.product_details',compact('products','data','variant_value'));

    }

    public function product_attri(request $request)

    {

        $attrib_colr=$request->attrib_colr;

       $product_orders = DB::table('product_attributes')->select('original_price','offer_price','stock')

        ->where('id',$attrib_colr)

        ->get();

        return view('frontend.pages.product.product_details',compact('products','data'));

    }

    public function category()

    {

        $category_list=Category::all();

        return view('frontend.index',['values'=>$category_list]);

    }

    public function searchsug(request $request)

    {

        //return $request['query'];

        $data=array();

        if(isset($request['query']) && $request['query'] != ""){

        // $_SESSION['searchTerm']=$request['searchTerm'];

        $query=$request['query'];

        $product= Product::where('title',"LIKE","%$query%")->get();

        //print_r($product);

        if(count($product) > 0){

            foreach($product as $value){

               $data[] = array("post_title"=>$value->title);

            }

        }

        $product= Category::where('title',"LIKE","%$query%")->get();

        //print_r($product);

        if(count($product) > 0){

            foreach($product as $value){

               $data[] = array("post_title"=>$value->title);

            }

        }

        $product= Brand::where('title',"LIKE","%$query%")->get();

        //print_r($product);

        if(count($product) > 0){

            foreach($product as $value){

               $data[] = array("post_title"=>$value->title);

            }

        }

        return $data;

        //return json_encode(array("post_title"=>"Test"));

        }

    }

  public function product(request $request,$id)

    {
    $categories = Category::where('slug', $id)->first();
    $childChate = Category::where('sub_cate_id', '>', '0')->pluck('id')->toArray();

    if ($categories) {
        if ($categories->sub_cate_id < 1 && $categories->parent_id > 0) {
            // Sub category
            $products = Product::where('status', 'active')
                ->where('subcategory_id', $categories->id)
                ->orderBy('id', 'desc')
                ->get();
        } elseif (empty($categories->parent_id)) {
            $products = Product::where('status', 'active')
                ->where('category', $categories->id)
                ->orderBy('id', 'desc')
                ->get();
        } elseif (in_array($categories->id, $childChate)) {
            // Child sub category
            $products = Product::where('status', 'active')
                ->where('childcategory_id', $categories->id)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $products = collect();
        }
    } else {
        $products = collect();
    }

    $prod_categories = Category::where('is_parent', 0)
        ->where('status', 'active')
        ->get();

    $aProductSaleprice = [];
    $aProductvariant_photo = [];
    $iswishlist = [];
    $aDiscountpercent = [];
    $ahover_image_photo = [];

    foreach ($products as $key => $product) {
        $variant = ProductVariant::where('product_id', $product->id)
            ->where('status', 'active')
            ->first();

        // Determine stock availability
        $product->current_stock = ProductVariant::where('product_id', $product->id)
            ->where('in_stock', '>', 0)
            ->where('status', 'active')
            ->count();

        // Calculate discount
        if ($product->discount_type == "fixed") {
            if ($variant && $variant->regular_price != 0) {
                $aDiscountpercent[] = ($product->discount / $variant->regular_price) * 100;
            } else {
                $aDiscountpercent[] = 0;
            }
        } else {
            $aDiscountpercent[] = $product->discount;
        }

        $saleprice = $this->fetchSalePrice(
            $variant ? $variant->regular_price : 0,
            $product['tax_id'],
            $product['discount'],
            $product['discount_type']
        );

        $A_prodimg = $variant ? explode(',', $variant->photo) : [];
        $productidtemp = $product->id;

        $aProductvariant_photo[$productidtemp] = $variant->photo ?? '';

        if (count($A_prodimg) > 1) {
            $ahover_image_photo[$productidtemp] = $A_prodimg[1];
        } else {
            $ahover_image_photo[$productidtemp] = $A_prodimg[0] ?? '';
        }

        $aProductSaleprice[] = $saleprice['sale_price'];

        $wishlistStatus = 'no';
        $currentUser = auth()->guard('users')->user() ?? auth()->guard('guest')->user();
        if ($currentUser) {
            $wishlist = Wishlist::where('product_id', $product->id)
                ->where('customer_id', $currentUser->id)
                ->first();
            if ($wishlist) {
                $wishlistStatus = 'yes';
            }
        }
        $iswishlist[] = $wishlistStatus;
    }

    $inStock = $products->filter(fn($p) => $p->current_stock > 0);
    $outOfStock = $products->filter(fn($p) => $p->current_stock == 0);
    $products = $inStock->merge($outOfStock);

    $highest_rate = Product::where('status', 'active')->max('regular_price');
    $slug = $id;

    return view('frontend.product', compact(
        'products',
        'aDiscountpercent',
        'slug',
        'ahover_image_photo',
        'categories',
        'iswishlist',
        'prod_categories',
        'aProductSaleprice',
        'aProductvariant_photo',
        'highest_rate'
    ));
}

  public function product_list_test(Request $request, $id)
{
    $categories = Category::where('slug', $id)->first();
    $childChate = Category::where('sub_cate_id', '>', '0')->pluck('id')->toArray();

    if ($categories) {
        if ($categories->sub_cate_id < 1 && $categories->parent_id > 0) {
            // Sub category
            $products = Product::where('status', 'active')
                ->where('subcategory_id', $categories->id)
                ->orderBy('id', 'desc')
                ->get();
        } elseif (empty($categories->parent_id)) {
            $products = Product::where('status', 'active')
                ->where('category', $categories->id)
                ->orderBy('id', 'desc')
                ->get();
        } elseif (in_array($categories->id, $childChate)) {
            // Child sub category
            $products = Product::where('status', 'active')
                ->where('childcategory_id', $categories->id)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $products = collect();
        }
    } else {
        $products = collect();
    }

    $prod_categories = Category::where('is_parent', 0)
        ->where('status', 'active')
        ->get();

    $aProductSaleprice = [];
    $aProductvariant_photo = [];
    $iswishlist = [];
    $aDiscountpercent = [];
    $ahover_image_photo = [];

    foreach ($products as $key => $product) {
        $variant = ProductVariant::where('product_id', $product->id)
            ->where('status', 'active')
            ->first();

        // Determine stock availability
        $product->current_stock = ProductVariant::where('product_id', $product->id)
            ->where('in_stock', '>', 0)
            ->where('status', 'active')
            ->count();

        // Calculate discount
        if ($product->discount_type == "fixed") {
            if ($variant && $variant->regular_price != 0) {
                $aDiscountpercent[] = ($product->discount / $variant->regular_price) * 100;
            } else {
                $aDiscountpercent[] = 0;
            }
        } else {
            $aDiscountpercent[] = $product->discount;
        }

        $saleprice = $this->fetchSalePrice(
            $variant ? $variant->regular_price : 0,
            $product['tax_id'],
            $product['discount'],
            $product['discount_type']
        );

        $A_prodimg = $variant ? explode(',', $variant->photo) : [];
        $productidtemp = $product->id;

        $aProductvariant_photo[$productidtemp] = $variant->photo ?? '';

        if (count($A_prodimg) > 1) {
            $ahover_image_photo[$productidtemp] = $A_prodimg[1];
        } else {
            $ahover_image_photo[$productidtemp] = $A_prodimg[0] ?? '';
        }

        $aProductSaleprice[] = $saleprice['sale_price'];

        $wishlistStatus = 'no';
        $currentUser = auth()->guard('users')->user() ?? auth()->guard('guest')->user();
        if ($currentUser) {
            $wishlist = Wishlist::where('product_id', $product->id)
                ->where('customer_id', $currentUser->id)
                ->first();
            if ($wishlist) {
                $wishlistStatus = 'yes';
            }
        }
        $iswishlist[] = $wishlistStatus;
    }

    // 🔹 SORT: In-stock first, out-of-stock last
    $inStock = $products->filter(fn($p) => $p->current_stock > 0);
    $outOfStock = $products->filter(fn($p) => $p->current_stock == 0);
    $products = $inStock->merge($outOfStock);

    $highest_rate = Product::where('status', 'active')->max('regular_price');
    $slug = $id;

    return view('frontend.product_test', compact(
        'products',
        'aDiscountpercent',
        'slug',
        'ahover_image_photo',
        'categories',
        'iswishlist',
        'prod_categories',
        'aProductSaleprice',
        'aProductvariant_photo',
        'highest_rate'
    ));
}

    public function view_product_details(request $request)

    {

        $data=array();

        $option=implode(',',$request->option);

        $product_id=$request->product_id;

       $product_orders=ProductVariant::where(['arrtibute_name'=>$option,'product_id'=>$product_id])->get();

      // $getSizevalue=ProductVariant::select('arrtibute_name')->where('product_id','=',$product_id)->get();

       $data['original_price']=@$product_orders[0]->regular_price;

       $data['offer_price']=@$product_orders[0]->sale_price;

       $data['image_values']=$product_orders;

      //product_attributes

      // $pro_attr=

      //$data=OrderProduct::where('order_id',$id)->get();

        return $data;

    }

    public function search_products(Request $request){

        $resval['success']=true;

       return response()->json(['resval'=>$resval]);

    }

    public function update_userdetails(Request $request){

        $user=User::where('id',auth()->guard('users')->user()->id)->first();

        $password=Hash::check($request->previous_password, $user->password);

        if($password){

            User::where('id',auth()->guard('users')->user()->id)->update(['name'=>$request->name,'email'=>$request->email,'password'=>Hash::make($request->new_password)]);

            return response(['success'=>true]);

        }else{

            return response(['success'=>false]);

        }

    }
    /*
    public function single_products($slug){

        $aProductvariant_photo=array();

        $aProductSaleprice=array();

        $product=Product::where('slug',$slug)->first();

        if(!empty($product)){

        if(auth()->guard('users')->user()){

            $cart_qty=CartTable::where('customer_id',auth()->guard('users')->user()->id)->where('product_id',$product->id)->first();

            $cart_qty=(!empty($cart_qty) ? $cart_qty->product_qty : 1);

        }else{

            $aCartData = Session::get('cart',[]);

            if(!empty($aCartData[$product->id])){

              $cart_qty=$aCartData[$product->id]['product_qty'];

            }else{

                $cart_qty=1;

            }

        }

        $variant=ProductVariant::where('product_id',$product->id)->where('status','active')->first();

        $saleprice= $this->fetchSalePrice($variant->regular_price,$product['tax_id'],$product['discount'],$product['discount_type']);

        $AP_prodimg = explode(',', $variant->photo);

        $product['photo']=$AP_prodimg[0];

        $product['multi_photo']=$AP_prodimg;

        $product['sale_price']=$saleprice['sale_price'];

        //Reviews

        $product_review=ProductReviews::where('product_id',$product->id)->where('status','accept')->get();

        //Related products

        $r_Productvariant_photo=array();

        $r_ProductSaleprice=array();

        $r_Products=array();

        $iswishlist=array();

        $ahover_image_photo=array();

        $aDiscountpercent=array();

        $related_products=Product::where('status','active')->get();

        foreach($related_products as $related){

            $variant=ProductVariant::where('product_id',$related->id)->where('status','active')->first();

            $category=Category::where('is_parent',0)->where('status','active')->whereIn('id', explode(',',$product->category))->first();

            $saleprice= $this->fetchSalePrice($variant->regular_price,$related['tax_id'],$related['discount'],$related['discount_type']);

            $A_prodimg = explode(',', $variant->photo);

            if($related->discount_type=="fixed"){

                if($variant->regular_price!=0){

                array_push($aDiscountpercent,($related->discount / $variant->regular_price)*100);

                }else{

                    array_push($aDiscountpercent,0);

                }

            }

            else{

            array_push($aDiscountpercent,$related->discount);

                }

            if(!empty($category)){

                array_push($r_Products,$related);

                array_push($r_Productvariant_photo,$A_prodimg[0]);

                if(count($A_prodimg) > 1){

                    array_push($ahover_image_photo,$A_prodimg[1]);

                }else{

                    array_push($ahover_image_photo,$A_prodimg[0]);

                }

                array_push($r_ProductSaleprice,$saleprice['sale_price']);

                if(auth()->guard('users')->user()){

                    $wishlist=Wishlist::where('product_id',$related->id)->where('customer_id',auth()->guard('users')->user()->id)->first();

                    if(isset($wishlist)){

                        array_push($iswishlist,'yes');

                    }else{

                        array_push($iswishlist,'no');

                    }

                }

            }

        }

        return view('frontend.single_product',compact('product','aDiscountpercent','cart_qty','ahover_image_photo','iswishlist','AP_prodimg','r_Products','aProductSaleprice','aProductvariant_photo','product_review','related_products','r_ProductSaleprice','r_Productvariant_photo'));

        }else{

            return redirect('/');

        }

    }

*/

public function single_products($slug)
{
    $aProductvariant_photo = array();
    $aProductSaleprice = array();
    $product = Product::where('slug', $slug)->first();

    if (!empty($product)) {
        if (auth()->guard('users')->user()) {
            $cart_qty = CartTable::where('customer_id', auth()->guard('users')->user()->id)->where('product_id', $product->id)->first();
            $cart_qty = (!empty($cart_qty) ? $cart_qty->product_qty : 1);
        } else {
            $aCartData = Session::get('cart', []);
            if (!empty($aCartData[$product->id])) {
                $cart_qty = $aCartData[$product->id]['product_qty'];
            } else {
                $cart_qty = 1;
            }
        }

        $variant = ProductVariant::where('product_id', $product->id)->where('status', 'active')->first();

        // Ensure $variant is not null
        if ($variant !== null) {
            $saleprice = $this->fetchSalePrice($variant->regular_price, $product['tax_id'], $product['discount'], $product['discount_type']);
            $AP_prodimg = explode(',', $variant->photo);
            $product['photo'] = $AP_prodimg[0];
            $product['multi_photo'] = $AP_prodimg;
            $product['sale_price'] = $saleprice['sale_price'];
        } else {
            // Handle case where there is no active variant for the product
            $saleprice = ['sale_price' => 0]; // Set a default value
            $AP_prodimg = []; // Set an empty array for photos
            $product['photo'] = null;
            $product['multi_photo'] = [];
            $product['sale_price'] = 0;
        }

        // Reviews
        $product_review = ProductReviews::where('product_id', $product->id)->where('status', 'accept')->get();

        // Related products
        $r_Productvariant_photo = array();
        $r_ProductSaleprice = array();
        $r_Products = array();
        $iswishlist = array();
        $ahover_image_photo = array();
        $aDiscountpercent = array();

        $tempProduct = $product->name;
        $catIds = [];
        $catIds[] = $product->category;
        $catIds[] = $product->subcategory_id;
        $catIds[] = $product->childcategory_id;

        $searchTerms = explode(' ', $tempProduct);
            $orderByClause = implode(' OR ', array_map(function ($term) {
                return 'name LIKE "%' . $term . '%"';
            }, $searchTerms));

        $related_products = Product::where('status', 'active')
        ->where('id','!=', $product->id)
        ->where(function ($query) use ($catIds,$tempProduct) {
                    $query->where('name','LIKE', '%' . $tempProduct . '%')
                          ->orWhereIn('category', $catIds)
                          ->orWhereIn('subcategory_id', $catIds)
                          ->orWhereIn('childcategory_id', $catIds);
                })

        ->orderByRaw('CASE WHEN ' . $orderByClause . ' THEN 1 ELSE 2 END, name ASC')

                // ->orderByRaw('FIELD(name, ?) ASC', [$tempProduct])

        ->get();

        foreach ($related_products as $related) {
            $variant = ProductVariant::where('product_id', $related->id)->where('status', 'active')->first();

            // Ensure $variant is not null
            if ($variant !== null) {
                $category = Category::where('is_parent', 0)->where('status', 'active')->whereIn('id', explode(',', $product->category))->first();
                $saleprice = $this->fetchSalePrice($variant->regular_price, $related['tax_id'], $related['discount'], $related['discount_type']);
                $A_prodimg = explode(',', $variant->photo);

                if ($related->discount_type == "fixed") {
                    if ($variant->regular_price != 0) {
                        array_push($aDiscountpercent, ($related->discount / $variant->regular_price) * 100);
                    } else {
                        array_push($aDiscountpercent, 0);
                    }
                } else {
                    array_push($aDiscountpercent, $related->discount);
                }

                if (!empty($category)) {
                    array_push($r_Products, $related);
                    array_push($r_Productvariant_photo, $A_prodimg[0]);

                    if (count($A_prodimg) > 1) {
                        array_push($ahover_image_photo, $A_prodimg[1]);
                    } else {
                        array_push($ahover_image_photo, $A_prodimg[0]);
                    }

                    array_push($r_ProductSaleprice, $saleprice['sale_price']);

                    if (auth()->guard('users')->user()) {
                        $wishlist = Wishlist::where('product_id', $related->id)->where('customer_id', auth()->guard('users')->user()->id)->first();
                        if (isset($wishlist)) {
                            array_push($iswishlist, 'yes');
                        } else {
                            array_push($iswishlist, 'no');
                        }
                    }
                }
            }
        }

        return view('frontend.single_product', compact('product', 'aDiscountpercent', 'cart_qty', 'ahover_image_photo', 'iswishlist', 'AP_prodimg', 'r_Products', 'aProductSaleprice', 'aProductvariant_photo', 'product_review', 'related_products', 'r_ProductSaleprice', 'r_Productvariant_photo'));
    } else {
        return redirect('/');
    }
}

public function product_filter(Request $request)
{

    /* -------------------------------------------------
     | BASE QUERY
     -------------------------------------------------*/
    $products = Product::join('product_variants', 'products.id', '=', 'product_variants.product_id')
        ->where('products.status', 'active')
        ->where('product_variants.status', 'active')
        ->where('product_variants.in_stock', '>', 0);

    /* -------------------------------------------------
     | CATEGORY FILTER (NO SLUG)
     -------------------------------------------------*/
    if ($request->filled('cats')) {
        $cats = $request->cats; // array of category IDs

        $products->where(function ($q) use ($cats) {
            $q->whereIn('products.category', $cats)
              ->orWhereIn('products.subcategory_id', $cats)
              ->orWhereIn('products.childcategory_id', $cats);
        });
    }

    /* -------------------------------------------------
     | PRICE FILTER
     -------------------------------------------------*/
    if ($request->filled('min') && $request->filled('max')) {
        $products->whereBetween(
            'product_variants.regular_price',
            [(float)$request->min, (float)$request->max]
        );
    }

    /* -------------------------------------------------
     | SIZE FILTER
     -------------------------------------------------*/
    if (!empty($request->size) && is_array($request->size)) {
        $products->whereIn('product_variants.variants', $request->size);
    }

    /* -------------------------------------------------
     | DISCOUNT FILTER
     -------------------------------------------------*/
    $discount = filter_var($request->discount, FILTER_VALIDATE_BOOLEAN);
    if ($discount) {
        $products->whereNotNull('products.discount')
                 ->where('products.discount', '>', 0);
    }

    /* -------------------------------------------------
     | STOCK FILTER
     -------------------------------------------------*/
    if ($request->in_stock == 1) {
        $products->where('products.stock', '>', 0);
    } elseif ($request->in_stock == 2) {
        $products->where('products.stock', '=', 0);
    }

    /* -------------------------------------------------
     | PRICE SORT
     -------------------------------------------------*/
    if ($request->price_sort === 'low-to-high') {
        $products->orderBy('product_variants.regular_price', 'ASC');
    } elseif ($request->price_sort === 'high-to-low') {
        $products->orderBy('product_variants.regular_price', 'DESC');
    }

    // Default stock priority
    $products->orderBy('products.stock', 'DESC');

    /* -------------------------------------------------
     | GROUP & FETCH
     -------------------------------------------------*/
    $aFilteredProducts = $products
        ->groupBy('product_variants.product_id')
        ->get(['products.*', 'product_variants.*', 'products.id as id']);

    /* -------------------------------------------------
     | EXTRA DATA FOR VIEW
     -------------------------------------------------*/
    $sale_price = [];
    $aDiscountpercent = [];
    $aProductvariant_photo = [];
    $ahover_image_photo = [];
    $iswishlist = [];

    foreach ($aFilteredProducts as $p) {

        $variant = ProductVariant::where('product_id', $p->id)
            ->where('in_stock', '>', 0)
            ->where('status', 'active')
            ->orderBy('id', 'desc')
            ->first();

        if (!$variant) continue;

        // Sale price
        $sale = $this->fetchSalePrice(
            $variant->regular_price,
            $p->tax_id,
            $p->discount,
            $p->discount_type
        );

        $sale_price[] = $sale['sale_price'];

        // Images
        $imgs = explode(',', $variant->photo);
        $aProductvariant_photo[$p->id] = $imgs[0];
        $ahover_image_photo[$p->id] = $imgs[1] ?? $imgs[0];

        // Discount %
        if ($p->discount_type === 'fixed' && $variant->regular_price > 0) {
            $aDiscountpercent[] = ($p->discount / $variant->regular_price) * 100;
        } else {
            $aDiscountpercent[] = $p->discount;
        }

        // Wishlist
        if (auth()->guard('users')->check()) {
            $iswishlist[] = Wishlist::where('product_id', $p->id)
                ->where('customer_id', auth()->guard('users')->id())
                ->exists() ? 'yes' : 'no';
        }

        // Stock count
        $p->current_stock = ProductVariant::where('product_id', $p->id)
            ->where('in_stock', '>', 0)
            ->where('status', 'active')
            ->count();
    }

    /* -------------------------------------------------
     | RENDER VIEW
     -------------------------------------------------*/
    $rendered_products = view('frontend.product_list', [
        'products' => $aFilteredProducts,
        'aProductSaleprice' => $sale_price,
        'aDiscountpercent' => $aDiscountpercent,
        'iswishlist' => $iswishlist,
        'ahover_image_photo' => $ahover_image_photo,
        'aProductvariant_photo' => $aProductvariant_photo,
        'selectedSizes' => $request->size ?? [],
        'min' => $request->min,
        'max' => $request->max
    ])->render();

    /* -------------------------------------------------
     | RESPONSE
     -------------------------------------------------*/
    return response()->json([
        'resval' => [
            'success' => true,
            'rendered_products' => $rendered_products
        ]
    ]);
}

public function newarrival_product_filter(Request $request)
{
    $slug = $request->category_slug;
    $size = $request->size;
    $aDiscountpercent = array();
    if(auth()->guard('users')->user()){

    $customer_id=auth()->guard('users')->user()->id;

    }else if(auth()->guard('guest')->user()){

     $customer_id=auth()->guard('guest')->user()->id;
    }else{

        return redirect('user/auth');

    }

    if($request->discount==="true"){
        $discount = 1;
    }else{
        $discount = 0;
    }

    $category = Category::where('slug', $slug)->get();
    $categories = $category;
$tempChildIdArray = array("155", "165", "177", "181");
foreach($category as $key=>$cat){
    if($cat->sub_cate_id < 1 && $cat->parent_id > 0){
        //sub category

           $products = Product::join('product_variants', 'products.id', '=', 'product_variants.product_id')
           ->where('products.status', 'active')
           ->where('product_variants.status','active')
           ->where('product_variants.in_stock','>','0')
           ->where('subcategory_id', $cat->id)
           ->groupBy('product_variants.product_id');

    } else if(empty($cat->parent_id)){
          $products = Product::join('product_variants', 'products.id', '=', 'product_variants.product_id')
          ->where('products.status', 'active')
          ->where('product_variants.status','active')
          ->where('product_variants.in_stock','>','0')
          ->where('category', $cat->id)
          ->groupBy('product_variants.product_id');
    }
    //else if (in_array($categories->id, $tempChildIdArray)){
        // 155,165,177,178,179,180,181
        // This need to fix and its updated for temp - only for child sub cate
        else if($cat->is_parent == 1 && $cat->parent_id > 0 && $cat->sub_cate_id > 0){
        $products = Product::join('product_variants', 'products.id', '=', 'product_variants.product_id')
        ->where('products.status', 'active')
        ->where('product_variants.status','active')
        ->where('product_variants.in_stock','>','0')
        ->where('childcategory_id', $cat->id)
        ->groupBy('product_variants.product_id');
    } else {
        $products = [];
    }

    $filteredProducts = $products;

    $min = $request->input('min');
    $max = $request->input('max');

    if ($min !== null && $max !== null) {
                    $products->whereBetween('product_variants.regular_price', [(float) $min, (float) $max]);

    }
    if (!empty($size) && is_array($size)) {
        $products->whereIn('product_variants.variants', $size);
    }
    if ($request->price_sort != '' && $request->price_sort != 'undefined' && $request->price_sort != 'true') {
        $products->orderBy('product_variants.regular_price', 'DESC');
    }

    if (!empty($slug)) {
        if($cat->is_parent == 0){ //main category
            $products->whereRaw("find_in_set($cat->id,category)");
        }
        elseif($cat->is_parent == 1 && $cat->sub_cate_id < 0){ //sub category
            $products->whereRaw("find_in_set($cat->id,subcategory_id)");
        }
        elseif($cat->is_parent == 1 && $cat->parent_id > 0 && $categories->sub_cate_id > 0){ //child category
            $products->whereRaw("find_in_set($category->id,childcategory_id)");
        }
    }
    if ($discount==1) {
        $products->whereNotNull('discount')->where('discount', '!=', 0);
    }
    if($request->in_stock==1){
        $products->where('products.stock','>', '0');
    }
     if($request->in_stock==2){
        $products->where('products.stock','=', '0');
    }
    $products->orderBy('products.stock', 'DESC');
    $aFilteredProducts = $products->get(['products.*', 'product_variants.*', 'products.id as id']);
    $sale_price = $ahover_image_photo = $iswishlist = $aProductvariant_photo = [];
}
    foreach ($aFilteredProducts as $p) {
        $variant_val = ProductVariant::where('product_id', $p->id)
        ->where('in_stock', '>', '0')
        ->orderBy('id', 'desc')->first();
        $saleprice = $this->fetchSalePrice($variant_val->regular_price, $p->tax_id, $p->discount, $p->discount_type);
        array_push($sale_price, $saleprice['sale_price']);

 $productidtemp = $p->id;

$aProductvariant_photo[$productidtemp] = $variant_val->photo;

        $A_prodimg = explode(',', $variant_val->photo);
        // array_push($aProductvariant_photo, $A_prodimg[0]);
        if (count($A_prodimg) > 1) {
             $ahover_image_photo[$productidtemp] = $A_prodimg[1];
            // array_push($ahover_image_photo, $A_prodimg[1]);
        } else {
            $ahover_image_photo[$productidtemp] = $A_prodimg[0];
            // array_push($ahover_image_photo, $A_prodimg[0]);
        }

        if ($p->discount_type == "fixed") {
            if ($variant_val->regular_price != 0) {
                array_push($aDiscountpercent, ($p->discount / $variant_val->regular_price) * 100);
            } else {
                array_push($aDiscountpercent, 0);
            }
        } else {
            array_push($aDiscountpercent, $p->discount);
        }

        if (auth()->guard('users')->user() || auth()->guard('guard')->user()) {
            $wishlist = Wishlist::where('product_id', $p->id)
                ->where('customer_id', $customer_id)
                ->first();
            array_push($iswishlist, $wishlist ? 'yes' : 'no');
        }

         $p->current_stock = ProductVariant::where('product_id',$p->id)->where('in_stock','>',0)->where('status','active')->count();
    }

    // $aFilteredProducts = $aFilteredProducts->sortByDesc('current_stock')->values();
// foreach ($aFilteredProducts as $product) {
//         echo $product->name . " (Size: " . $product->variants . ")<br>";
//     }
//     exit();
    $rendered_products = view('frontend.product_list', [
        'products' => $aFilteredProducts,
        'aProductSaleprice' => $sale_price,
        'aDiscountpercent' => $aDiscountpercent,
        'slug' => $slug,
        'iswishlist' => $iswishlist,
        'ahover_image_photo' => $ahover_image_photo,
        'aProductvariant_photo' => $aProductvariant_photo,
        'selectedSizes' => $size ?? '',
        'min' => $min,'max' => $max
    ])->render();

    $resval['success'] = true;
    $resval['rendered_products'] = $rendered_products;

    return response()->json([
        'products' => $aFilteredProducts,
        'resval' => $resval,
        'rendered_products' => $rendered_products
    ]);
}

public function product_filter423(Request $request)
{
    // Fetch the category by its slug
    $slug = $request->category_slug;
    $size = $request->size;
    $aDiscountpercent = array();

    // Check if the discount filter is applied
    $discount = ($request->discount === "true") ? 1 : 0;

    $category = Category::where('slug', $slug)->first();
    $categories = $category;
    $tempChildIdArray = array("155", "165", "177", "181");

    // Determine the appropriate products based on category/subcategory/childcategory
    if($categories->sub_cate_id < 1 && $categories->parent_id > 0) {
        // Subcategory Filter
        $products = Product::join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->where('products.status', 'active')
            ->where('subcategory_id', $categories->id)
            ->groupBy('product_variants.product_id');
    } elseif(empty($categories->parent_id)) {
        // Category Filter (Parent Category)
        $products = Product::join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->where('products.status', 'active')
            ->where('category', $categories->id)
            ->groupBy('product_variants.product_id');
    } elseif (in_array($categories->id, $tempChildIdArray)) {
        // Childcategory Filter
        $products = Product::join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->where('products.status', 'active')
            ->where('childcategory_id', $categories->id)
            ->groupBy('product_variants.product_id');
    } else {
        // Default if no specific category/subcategory is matched
        $products = [];
    }

    // Apply subcategory and childcategory filters if provided in the request
    if ($request->has('subcategory_id')) {
        $products->where('products.subcategory_id', $request->subcategory_id);
    }

    if ($request->has('childcategory_id')) {
        $products->where('products.childcategory_id', $request->childcategory_id);
    }

    // Apply size filter
    if (!empty($request->size)) {
        $products->where(function ($query) use ($request) {
            foreach ($request->size as $size) {
                $query->orWhere('product_variants.variants', 'LIKE', '%' . $size . '%');
            }
        });
    }

    // Apply price range filter
    $min = $request->input('min');
    $max = $request->input('max');
    if ($min !== null && $max !== null) {
        $products->whereBetween('products.regular_price', [$min, $max]);
    }

    // Apply price sorting
    if ($request->price_sort != '' && $request->price_sort != 'undefined' && $request->price_sort != 'true') {
        $products->orderBy('product_variants.regular_price', 'DESC');
    }

    // Apply stock filtering (in stock or out of stock)
    if ($request->in_stock == 1) {
        $products->where('products.stock', '!=', '0');
    }
    if ($request->in_stock == 2) {
        $products->where('products.stock', '=', '0');
    }

    // Apply discount filter
    if ($discount == 1) {
        $products->whereNotNull('discount')->where('discount', '!=', 0);
    }

    // Fetch filtered products
    $aFilteredProducts = $products->get(['products.*', 'product_variants.*', 'products.id as id']);

    $sale_price = $ahover_image_photo = $iswishlist = $aProductvariant_photo = [];

    // Loop through filtered products and collect necessary data
    foreach ($aFilteredProducts as $p) {
        $variant_val = ProductVariant::where('product_id', $p->id)->orderBy('id', 'desc')->first();
        $saleprice = $this->fetchSalePrice($variant_val->regular_price, $p->tax_id, $p->discount, $p->discount_type);
        array_push($sale_price, $saleprice['sale_price']);

        $productidtemp = $p->id;

        // Collect variant photo
        $aProductvariant_photo[$productidtemp] = $variant_val->photo;

        // Collect hover image photo (either the second image or the first image)
        $A_prodimg = explode(',', $variant_val->photo);
        if (count($A_prodimg) > 1) {
            $ahover_image_photo[$productidtemp] = $A_prodimg[1];
        } else {
            $ahover_image_photo[$productidtemp] = $A_prodimg[0];
        }

        // Calculate discount percentage
        if ($p->discount_type == "fixed") {
            if ($variant_val->regular_price != 0) {
                array_push($aDiscountpercent, ($p->discount / $variant_val->regular_price) * 100);
            } else {
                array_push($aDiscountpercent, 0);
            }
        } else {
            array_push($aDiscountpercent, $p->discount);
        }

        // Check if the product is in the user's wishlist
        if (auth()->guard('users')->user()) {
            $wishlist = Wishlist::where('product_id', $p->id)
                ->where('customer_id', auth()->guard('users')->user()->id)
                ->first();
            array_push($iswishlist, $wishlist ? 'yes' : 'no');
        }

        // Calculate current stock for the product
        $p->current_stock = ProductVariant::where('product_id', $p->id)
            ->where('in_stock', '>', 0)
            ->where('status', 'active')
            ->count();
    }

    // Sort the products by current stock in descending order
    $aFilteredProducts = $aFilteredProducts->sortByDesc('current_stock')->values();

    // Render the filtered product list view
    $rendered_products = view('frontend.product_list', [
        'aProductSaleprice' => $sale_price,
        'aDiscountpercent' => $aDiscountpercent,
        'slug' => $slug,
        'iswishlist' => $iswishlist,
        'ahover_image_photo' => $ahover_image_photo,
        'aProductvariant_photo' => $aProductvariant_photo,
        'products' => $aFilteredProducts
    ])->render();

    // Return the filtered products as a JSON response
    $resval['success'] = true;
    $resval['rendered_products'] = $rendered_products;

    return response()->json([
        'products' => $aFilteredProducts,
        'resval' => $resval,
        'rendered_products' => $rendered_products
    ]);
}

public function product_filter_bk(Request $request)
{
    $slug = $request->category_slug;
    $size = $request->size;
    $aDiscountpercent = array();

    if($request->discount==="true"){
        $discount = 1;
    }else{
        $discount = 0;
    }

    $category = Category::where('slug', $slug)->first();

    $childcategory_id = $subcategory_id = null;
    if (!empty($category->sub_cate_id)) {
        $childcategory_id = $category->id;
        $subcategory_id = $category->sub_cate_id;
    }

    $filteredProducts = Product::join('product_variants', 'products.id', '=', 'product_variants.product_id')
        ->where('products.status', 'active')
       /* ->when($childcategory_id && $subcategory_id, function ($query) use ($childcategory_id, $subcategory_id) {
            return $query->where('childcategory_id', $childcategory_id)
                         ->where('subcategory_id', $subcategory_id);
        })*/
        ->groupBy('product_variants.product_id');

    if (!empty($request->size)) {
        $filteredProducts->where(function ($query) use ($request) {
            foreach ($request->size as $size) {
                $query->orWhere('product_variants.variants', 'LIKE', '%' . $size . '%');
            }
        });
    }

    $min = $request->input('min');
    $max = $request->input('max');

    if ($min !== null && $max !== null) {
        $filteredProducts->whereBetween('products.regular_price', [$min, $max]);
    }

 /*

    if (!empty($request->cats)) {
        foreach ($request->cats as $i => $cat_id) {
            if ($i == 0) {
                $filteredProducts->whereRaw("find_in_set($cat_id,products.category)");
            } else {
                $filteredProducts->orWhereRaw("find_in_set($cat_id,products.category)");
            }
        }
    }

    */

    if ($request->price_sort != '' && $request->price_sort != 'undefined' && $request->price_sort != 'true') {
        $filteredProducts->orderBy('product_variants.regular_price', 'DESC');
    }

    $filteredProducts->orderBy('products.stock', 'DESC');

    if (!empty($slug)) {
        $filteredProducts->whereRaw("find_in_set($category->id,category)");
    }

    if ($discount==1) {
        $filteredProducts->whereNotNull('discount')->where('discount', '!=', 0);
    }

    if($request->in_stock==1){
        $filteredProducts->where('products.stock','!=', '0');
    }
     if($request->in_stock==2){
        $filteredProducts->where('products.stock','=', '0');
    }

   // echo  $filteredProducts->toSql();

    $aFilteredProducts = $filteredProducts->get(['products.*', 'product_variants.*', 'products.id as id']);

    $sale_price = $ahover_image_photo = $iswishlist = $aProductvariant_photo = [];

    foreach ($aFilteredProducts as $p) {
        $variant_val = ProductVariant::where('product_id', $p->id)->orderBy('id', 'desc')->first();
        $saleprice = $this->fetchSalePrice($variant_val->regular_price, $p->tax_id, $p->discount, $p->discount_type);
        array_push($sale_price, $saleprice['sale_price']);

        $A_prodimg = explode(',', $variant_val->photo);
        array_push($aProductvariant_photo, $A_prodimg[0]);
        if (count($A_prodimg) > 1) {
            array_push($ahover_image_photo, $A_prodimg[1]);
        } else {
            array_push($ahover_image_photo, $A_prodimg[0]);
        }

        if ($p->discount_type == "fixed") {
            if ($variant_val->regular_price != 0) {
                array_push($aDiscountpercent, ($p->discount / $variant_val->regular_price) * 100);
            } else {
                array_push($aDiscountpercent, 0);
            }
        } else {
            array_push($aDiscountpercent, $p->discount);
        }

        if (auth()->guard('users')->user()) {
            $wishlist = Wishlist::where('product_id', $p->id)
                ->where('customer_id', auth()->guard('users')->user()->id)
                ->first();
            array_push($iswishlist, $wishlist ? 'yes' : 'no');
        }
    }

    $rendered_products = view('frontend.product_list', [
        'aProductSaleprice' => $sale_price,
        'aDiscountpercent' => $aDiscountpercent,
        'slug' => $slug,
        'iswishlist' => $iswishlist,
        'ahover_image_photo' => $ahover_image_photo,
        'aProductvariant_photo' => $aProductvariant_photo,
        'products' => $aFilteredProducts
    ])->render();

    $resval['success'] = true;
    $resval['rendered_products'] = $rendered_products;

    return response()->json([
        'products' => $aFilteredProducts,
        'resval' => $resval,
        'rendered_products' => $rendered_products
    ]);
}
public function search(Request $request){

     Session::forget('product_name');
    if($request->product_name!=''){
        session(['product_name' => $request->product_name]);
    }else{
    session(['product_name' => $request->product_name]);
    }

    $products = [];

    if ($request->filled('product_name')){
        $catIds = DB::table('categories')->where('status','active')->where('title','LIKE', '%' . $request->product_name . '%')->pluck('id');

        if(count($catIds) > 0){
            $tempProduct = $request->product_name;
             $products=DB::table('products')->where('status','active')
            ->where(function ($query) use ($catIds,$tempProduct) {
                    $query->where('name','LIKE', '%' . $tempProduct . '%')
                          ->orWhereIn('category', $catIds)
                          ->orWhereIn('subcategory_id', $catIds)
                          ->orWhereIn('childcategory_id', $catIds);
                })

        ->orderBy('products.stock', 'DESC')->get();

        } else {
             $products=DB::table('products')->where('status','active')->where('name','LIKE', '%' . $request->product_name . '%')->orderBy('products.stock', 'DESC')->get();
        }

    }

    $sale_price=array();

    $ahover_image_photo=array();

    $iswishlist=array();

    $regular_price = '';

    $aProductvariant_photo=array();

    $aDiscountpercent=array();

    foreach($products as $p){

        $product_variant=DB::table('product_variants')->where('product_id',$p->id)->first();

        $relsaleprice= $this->fetchSalePrice($product_variant->regular_price,$p->tax_id,$p->discount,$p->discount_type);

        $regular_price ='';
        if($p->discount_type="fixed"){

            $regular_price = number_format($product_variant->regular_price - $p->discount,2);
        }else{

            $discount = $product_variant->regular_price/100*$p->discount;
           $regular_price = number_format($product_variant->regular_price - $discount,2);
        }

        array_push($sale_price,$relsaleprice['sale_price']);

        if($p->discount_type=="fixed"){

            if($product_variant->regular_price!=0){

            array_push($aDiscountpercent,($p->discount / $product_variant->regular_price)*100);

            }else{

               array_push($aDiscountpercent,0);

            }

            }else{

           array_push($aDiscountpercent,$p->discount);

            }

        $A_prodimg = explode(',', $product_variant->photo);

        array_push($aProductvariant_photo,$A_prodimg[0]);

        if(count($A_prodimg) > 1){

            array_push($ahover_image_photo,$A_prodimg[1]);

        } else{

            array_push($ahover_image_photo,$A_prodimg[0]);

        }

        if(auth()->guard('users')->user()){

            $wishlist=Wishlist::where('product_id',$p->id)->where('customer_id',auth()->guard('users')->user()->id)->first();

            if(isset($wishlist)){

                array_push($iswishlist,'yes');

            }else{

                array_push($iswishlist,'no');

            }

        }

        $p->current_stock = ProductVariant::where('product_id',$p->id)->where('in_stock','>',0)->where('status','active')->count();

    }

    if(count($products)>0){
        $products = $products->sortByDesc('current_stock')->values();
    }

    return view('frontend.search',compact('products','sale_price','aDiscountpercent','iswishlist','aProductvariant_photo','ahover_image_photo','regular_price'));

}

public function my_account(){

    if(auth()->guard('users')->user()){

    $customer_id=auth()->guard('users')->user()->id;

    }else if(auth()->guard('guest')->user()){

     $customer_id=auth()->guard('guest')->user()->id;
    }else{

        return redirect('user/auth');

    }

    // $orders=Order::join('order_products','orders.id','=','order_products.order_id')->where('orders.customer_id',$customer_id)

    // ->get(['orders.*', 'order_products.*','orders.status as order_status','order_products.created_at as order_created','orders.order_id as productorder_id']);

    $orders=Order::where('customer_id',$customer_id)->orderBy('orders.created_at','desc')->get();

     $ordersrecently = Order::where('customer_id',$customer_id)->orderBy('orders.created_at','desc')->first();

 //   $orders=DB::table('orders')->where(['customer_id'=>auth()->guard('users')->user()->id])->get();

        if (Auth::guard('users')->check()) {
            $user_obj = User::find(auth()->guard('users')->user()->id);
            $customer_name = $user_obj->name ?: $user_obj->phone;
        } elseif (Auth::guard('guest')->check()) {
            $customer_name = auth()->guard('guest')->user()->mobile;
        } else {
            $customer_name = '';
        }

        $billing_address = BillingAddress::where('customer_id', $customer_id)->orderBy('id', 'desc')->first();
        $shipping_address = ShippingAddress::where('customer_id', $customer_id)->orderBy('id', 'desc')->first();

        if (isset($billing_address) && $billing_address->state) {
            $state = DB::table('state_list')->where('id', $billing_address->state)->first();
        } else {
            $state = '';
        }

        $account = DB::table('users')->where('id', $customer_id)->first();
        $settings = \App\Models\Setting::first();

        return view('frontend.my_account', compact('orders', 'customer_name', 'billing_address', 'state', 'shipping_address', 'account', 'ordersrecently', 'settings'));
    }

public function order_pdf($id) {
    // Initialize necessary arrays
    $data = OrderProduct::where('order_id', $id)->get();
    $discount_amt = array();
    $product_name = array();
    $deleted_products = array(); // To track deleted products
    $deactivated_products = array();

   foreach ($data as $key => $d) {
    // Fetch product with trashed items included
    $product = Product::withTrashed()->find($d->product_id);

    // Check if product is found before accessing its properties
    if (!$product) {
        // If no product is found, continue with the next iteration
        continue;
    }

    // Check if 'hsn_code' exists before using it
    $hsn_code = isset($product->hsn_code) ? $product->hsn_code : 'N/A';  // Provide a fallback value if not set

    // Handle soft-deleted and deactivated products
    if ($product->trashed()) {
        $deleted_products[] = [
            'product_id' => $d->product_id,
            'message' => 'This product has been deleted.'
        ];
        // Append 'Deleted' tag
        $product_name[] = $product->name . ' (Deleted)';
    } elseif ($product->status == 'inactive') {
        $deactivated_products[] = [
            'product_id' => $d->product_id,
            'message' => 'This product has been deactivated.'
        ];
        // Append 'Deactivated' tag
        $product_name[] = $product->name . ' (Deactivated)';
    } else {
        // Normal active product
        $product_name[] = $product->name;

        // Handle product variants and discount calculations
        $product_variant = DB::table('product_variants')->where('product_id', $d->product_id)->where('variants', $d->option)->first();

        // Calculate the discount value
        if ($product->discount_type == "fixed") {
            $data[$key]['discount_value'] = $product->discount;
        } else {
            $discount = $this->fetchSalePrice($product_variant->regular_price, $product->tax_id, $product->discount, $product->discount_type);
            $data[$key]['discount_value'] = $discount['discount_price'];
        }

        // Add the discount value to the array
        array_push($discount_amt, $data[$key]['discount_value']);
    }
}

    // Fetch order details
    $order = Order::find($id);

    // Get billing and shipping addresses
    $billing_address = BillingAddress::where('order_id', $id)->first();
    $shipping_address = ShippingAddress::where('order_id', $id)->first();

    // Get the state for the billing address if available
    if (isset($billing_address)) {
        $state = DB::table('state_list')->where('id', $billing_address->state)->first();
    } else {
        $state = '';
    }

    // Default delivery charge if not provided
    $delivery_charge = ($order && $order->deliver_charge != '' && $order->deliver_charge != 'NULL')
    ? $order->deliver_charge
    : 0.00;

    // Determine the previous and next orders based on payment status
    if (isset($_REQUEST['status']) && $_REQUEST['status'] == "paid") {
        $previousOrder = Order::where('id', '<', $id)->where('payment_status', 'paid')->max('id');
        $nextOrder = Order::where('id', '>', $id)->where('payment_status', 'paid')->min('id');
    } else if (isset($_REQUEST['status']) && $_REQUEST['status'] == "unpaid") {
        $previousOrder = Order::where('id', '<', $id)->where('payment_status', 'unpaid')->max('id');
        $nextOrder = Order::where('id', '>', $id)->where('payment_status', 'unpaid')->min('id');
    } else {
        $previousOrder = Order::where('id', '<', $id)->max('id');
        $nextOrder = Order::where('id', '>', $id)->min('id');
    }

    // Return the view with necessary data
    return view('frontend.orderpdf', compact('discount_amt', 'product_name', 'delivery_charge', 'state', 'order', 'data', 'billing_address', 'shipping_address', 'deleted_products', 'deactivated_products'));
}

public function order_pdf342342($id){

    $id=$id;
        $data=OrderProduct::where('order_id',$id)->get();

        $discount_amt=array();
        $product_name=array();
        $deleted_products = array(); // To track deleted products
        $deactivated_products = array();

        foreach($data as $key=>$d){
            // $product=DB::table('products')->where('id',$d->product_id)->first();

            $product=DB::table('products')->where('id',$d->product_id)->first();

            $product = Product::withTrashed()->find($d->product_id);
            // print_r($product);exit();

            // If the product is soft-deleted, set the alert and proceed
            if ($product->trashed()) {
                $deleted_products[] = [
                    'product_id' => $d->product_id,
                    'message' => 'This product has been deleted.'
                ];
                $product_name[] = $product->name . ' (Deleted)';
            } elseif ($product->status == 'inactive') {
                // If the product is deactivated, show the deactivation alert
                $deactivated_products[] = [
                    'product_id' => $d->product_id,
                    'message' => 'This product has been deactivated.'
                ];
                $product_name[] = $product->name . ' (Deactivated)';
            } else {
                // If product is not deleted or deactivated, process it normally
                $product_name[] = $product->name;

            $product_variant=DB::table('product_variants')->where('product_id',$d->product_id)->where('variants',$d->option)->first();
            array_push($product_name,$product->name);
            if($product->discount_type == "fixed"){
                $data[$key]['discount_value']=$product->discount;
            }else{
                $discount= $this->fetchSalePrice($product_variant->regular_price,$product->tax_id,$product->discount,$product->discount_type);
                $data[$key]['discount_value']=$discount['discount_price'];
            }
            array_push($discount_amt,$data[$key]['discount_value']);
        }

        $order=Order::find($id);

      $billing_address=BillingAddress::where('order_id',$id)->first();
        $shipping_address=ShippingAddress::where('order_id',$id)->first();

        if(isset($billing_address)){
        $state=DB::table('state_list')->where('id',$billing_address->state)->first();
        }else{
            $state='';
        }

        $delivery_charge = ($order && $order->deliver_charge != '' && $order->deliver_charge != 'NULL')
    ? $order->deliver_charge
    : 0.00;

        if($order){

               if(isset($_REQUEST['status']) && $_REQUEST['status']=="paid"){

                  $previousOrder = Order::where('id', '<', $id)->where('payment_status','paid')->max('id');
            $nextOrder = Order::where('id', '>', $id)->where('payment_status','paid')->min('id');

    } else if(isset($_REQUEST['status']) && $_REQUEST['status']=="unpaid"){
          $previousOrder = Order::where('id', '<', $id)->where('payment_status','unpaid')->max('id');
            $nextOrder = Order::where('id', '>', $id)->where('payment_status','unpaid')->min('id');

    } else {
               $previousOrder = Order::where('id', '<', $id)->max('id');
            $nextOrder = Order::where('id', '>', $id)->min('id');
    }

   return view('frontend.orderpdf',compact('discount_amt','product_name','delivery_charge','state','order','data','billing_address','shipping_address','deleted_products','deactivated_products'));

    }

}
}

public function ordernew_pdf(request $request){

$id = $request->id;

    $data=OrderProduct::where('order_id',$id)->get();

    $discount_amt=array();

    $product_name=array();

    $deleted_products = array();

    $deactivated_products = array();

    foreach($data as $key=>$d){

        $product=DB::table('products')->where('id',$d->product_id)->first();
        $product = Product::withTrashed()->find($d->product_id);
         // If the product is soft-deleted, set the alert and proceed
            if ($product->trashed()) {
                $deleted_products[] = [
                    'product_id' => $d->product_id,
                    'message' => 'This product has been deleted.'
                ];
                $product_name[] = $product->name . ' (Deleted)';
            } elseif ($product->status == 'inactive') {
                // If the product is deactivated, show the deactivation alert
                $deactivated_products[] = [
                    'product_id' => $d->product_id,
                    'message' => 'This product has been deactivated.'
                ];
                $product_name[] = $product->name . ' (Deactivated)';
            }
            else{

        $product_variant=DB::table('product_variants')->where('product_id',$d->product_id)->where('variants',$d->option)->first();

        array_push($product_name,$product->name);

        if($product->discount_type == "fixed"){

            $data[$key]['discount_value']=$product->discount;

        }else{

            $discount= $this->fetchSalePrice($product_variant->regular_price,$product->tax_id,$product->discount,$product->discount_type);

            $data[$key]['discount_value']=$discount['discount_price'];

        }

        array_push($discount_amt,$data[$key]['discount_value']);
            }

    }

    $order=Order::find($id);

    $billing_address=BillingAddress::where('order_id',$id)->first();

    $shipping_address=ShippingAddress::where('order_id',$id)->first();

    if(isset($billing_address)){

    $state=DB::table('state_list')->where('id',$billing_address->state)->first();

    }else{

        $state='';

    }

    if(!empty($order->deliver_charge)){

        $delivery_charge = ($order && $order->deliver_charge != '' && $order->deliver_charge != 'NULL')
    ? $order->deliver_charge
    : 0.00;
    }else{
        $delivery_charge = '0.00';
    }

    if($order){

   return view('frontend.orderpdf',compact('discount_amt','product_name','delivery_charge','state','order','data','billing_address','shipping_address','deleted_products', 'deactivated_products'));

    }

}

public function update_address(Request $request){

    $data= request()->except(['_token','type']);

    $customer_id = null;

        if (auth()->guard('users')->check()) {
          $customer_id = auth()->guard('users')->user()->id;
        } elseif (auth()->guard('guest')->check()) {
          $customer_id = auth()->guard('guest')->user()->id;
        }
        if($customer_id){

    if($request->type=="billing"){

    $billing=BillingAddress::where('customer_id',$customer_id);

    $billing->update($data);

    }else{

    $billing=ShippingAddress::where('customer_id',$customer_id);

    $billing->update($data);

    }

    return redirect('customer/my_account');
        }
         else{
            return redirect('user/auth');
        }

}
public function getproductvarientssize(Request $request){

    if(!empty($request->product_id)){
        $product_id = $request->product_id;
        //$product_size = $request->size.',';

       $product_size = $request->size;

        //$newsizevariant=\App\Models\ProductVariant::where('product_id',$product_id)->where('variants',$product_size)->where('status','active')->first();

        $newsizevariant = \App\Models\ProductVariant::where('product_id', $product_id)
        ->where('variants', $product_size)
        ->where('status', 'active')
        ->first();

        $product=Product::where('status','active')->where('id',$newsizevariant->product_id)->first();

        $ADiscountpercent=0;
        $price ='';
        $discount='';

        if($product->discount_type=="fixed"){

            $ADiscountpercent=$product->discount;
            $price = $newsizevariant->regular_price - $product->discount;
            $discount = '';

        }else{
            if($newsizevariant->regular_price!=0){
                $ADiscountpercent=( $newsizevariant->regular_price/100)*$product->discount;
            }else{
                 $ADiscountpercent=0;
            }
            $price = $newsizevariant->regular_price - $ADiscountpercent;
             $discount = '%';

        }

        if(!empty($newsizevariant->regular_price)){
            $newsizevariant->regular_price = number_format($newsizevariant->regular_price,2);
        }
         if(!empty($price)){
            $price = number_format($price,2);
        }

        $data = array(
            'product_varients_id'=> $newsizevariant->id,
            'variants'=> $newsizevariant->variants,
            'regular_price'=> $price,
             'original_price'=> $newsizevariant->regular_price,
             'in_stock'=> $newsizevariant->in_stock,
            );

        $colors='';
        if(!empty($newsizevariant->colors)) {
          $colors123 = explode(',',$newsizevariant->colors);

            if(!empty($colors123[0])){
                $default_color = $colors123[0];
            }else{
                $default_color = '';
            }

            $colors.='<p><strong>Product Choose Color : </strong><span id="yourcolors">'.$default_color.'</span></p><input type="hidden" name="product_color" id="product_color" value="'.$default_color.'"><ul class="colors">';
            foreach($colors123 as $vals){
                 $colors .= '<a class="' . $vals . '" onclick="productcolorchange(\'' . $vals . '\')"><li style="margin-left: 2px;background: ' . $vals . ';"></li></a>';
            }
            $colors.='</ul>';

        }

        return response()->json(['data'=>$data,'colors'=>$colors]);
    }else{
        return false;
    }
}

    public function getproductgst(Request $request){

        if(!empty($request->state)){

            $state = $request->state;
            $sub_amt = $request->amount;
             $deliver_charge = $request->deliver_charge;
            $discountvalus = $request->discountvalus;
            $gsttax=DB::table('taxes')->where('id',1)->first();

             if($state==31){

                  $shipping = $sub_amt/100*$gsttax->percentage;

            }else{
               $shipping = $sub_amt/100*$gsttax->percentage1;
            }

            $deliverycharges='0';
            $shipping_charges ='0';
            $deliver_charge ='';
            $shipping_dis_amount = 0;
            $deliverydetails =  DB::table('shippingcharges')->where('from', '<=', $sub_amt)->where('to', '>=', $sub_amt)->first();
            if(!empty($deliverydetails)){

                if($state==31 || $state==28){
                     $deliver_charge=   $deliverydetails->amount;
                      $shipping_dis_amount =   $deliverydetails->dis_amount;
                }else{
                     $deliver_charge=   $deliverydetails->amount1;
                     $shipping_dis_amount =   $deliverydetails->dis_amount1;
                }

            }

           if(!empty($shipping)){
               $shipping = number_format($shipping,2);
           }
          // $totalamount = ($sub_amt+$shipping+$deliver_charge)-($discountvalus);

             $sub_amt = (float)$sub_amt;
            $deliver_charge = (float)$deliver_charge;
            $discountvalus = (float)$discountvalus;

            $totalamount = ($sub_amt + $deliver_charge) - $discountvalus-$shipping_dis_amount;

           if(!empty($totalamount)){
               $totalamount = number_format($totalamount,2);
           }

           $gst_vals = "( Includes ₹".$shipping." GST )";
           $datas=array(
               'gst_amount'=>$shipping,
                'state'=>$state,
                 'totalamount'=>$totalamount,
                 'gst_amount1'=>$gst_vals,
                 'deliver_charge'=>number_format($deliver_charge,2),
                 'shipping_dis_amount'=>number_format($shipping_dis_amount,2)
               );

            return response()->json(['data'=>$datas]);
        }else{
            return false;
        }
    }
     public function getcancelrequest(Request $request){

        if(!empty($request->order_id)){

            $id = $request->order_id;
            $cancel = $request->cancel;

            $datas=array(
                'status'=>"Cancelled",
                'cancle_request'=>$cancel,
                 'cancel_request_date'=>date('Y-m-d H:s')
                );

            $data =   DB::table('orders')->where('id',$id)->update($datas);
             return response()->json(['data'=>$data]);
        }
     }
      public function getreturnrequest(Request $request){

        if(!empty($request->order_id)){

            $id = $request->order_id;
            $cancel = $request->cancel;

            $datas=array(
                'status'=>"Returned",
                'cancle_request'=>$cancel,
                 'cancel_request_date'=>date('Y-m-d H:s')
                );

            $data =   DB::table('orders')->where('id',$id)->update($datas);
             return response()->json(['data'=>$data]);
        }
     }

     public function productnew(request $request,$id)

    {

        $categories=Category::where('slug',$id)->first();

        $childChate = Category::where('sub_cate_id', '>' ,'0')->pluck('id')->toArray();

       if($categories!=''){
            if($categories->sub_cate_id < 1 && $categories->parent_id > 0){
            //sub category

               $products = Product::where('status', 'active')->where('subcategory_id', $categories->id)
                  ->orderBy('stock', 'desc')
                  ->get();

        } else if(empty($categories->parent_id)){
              $products = Product::where('status', 'active')->where('category', $categories->id)
                  ->orderBy('stock', 'desc')
                  ->get();
        } else if (in_array($categories->id, $childChate)){
            // This need to fix and its updated for temp - only for child sub cate

            $products = Product::where('status', 'active')->where('childcategory_id', $categories->id)
                  ->orderBy('stock', 'desc')
                  ->get();

        } else {
            $products = [];
        }
       } else {
            $products = [];
       }

        $prod_categories=Category::where('is_parent',0)->where('status','active')->get();

        $aProductSaleprice=array();

        $aProductvariant_photo=array();

        $iswishlist=array();

        $aDiscountpercent=array();

        $ahover_image_photo=array();

        foreach($products as $key=>$product){

            // var_dump($key);

            $variant=ProductVariant::where('product_id',$product->id)->where('status','active')->first();

            $product->current_stock = ProductVariant::where('product_id',$product->id)->where('in_stock','>',0)->where('status','active')->count();

            if($product->discount_type=="fixed"){

                if($variant->regular_price!=0){

                array_push($aDiscountpercent,($product->discount / $variant->regular_price)*100);

                }else{

                   array_push($aDiscountpercent,0);

                }

                }else{

               array_push($aDiscountpercent,$product->discount);

                }

           $category=Category::where('is_parent',0)->where('status','active')->whereIn('id', explode(',',$product->category))->where('home','active')->first();

            $saleprice= $this->fetchSalePrice($variant->regular_price,$product['tax_id'],$product['discount'],$product['discount_type']);

            $A_prodimg = explode(',', $variant->photo);

            // array_push($aProductvariant_photo,$A_prodimg[0]);
            $productidtemp = $product->id;

            $aProductvariant_photo[$productidtemp] = $variant->photo;

            if(count($A_prodimg) > 1){
                $ahover_image_photo[$productidtemp] = $A_prodimg[1];

                // array_push($ahover_image_photo,$A_prodimg[1];);

            }else{
                $ahover_image_photo[$productidtemp] = $A_prodimg[0];
                // array_push($ahover_image_photo,$A_prodimg[0]);

            }

            array_push($aProductSaleprice,$saleprice['sale_price']);

            if(auth()->guard('users')->user()){

                $wishlist=Wishlist::where('product_id',$product->id)->where('customer_id',auth()->guard('users')->user()->id)->first();

                if(isset($wishlist)){

                    array_push($iswishlist,'yes');

                }else{

                    array_push($iswishlist,'no');

                }

            }

         }
    if(count($products)>0){
$products = $products->sortByDesc('current_stock')->values();
    }

         $highest_rate=Product::where('status','active')->max('regular_price');

         $slug=$id;
       return view('frontend.productnew',compact('products','aDiscountpercent','slug','ahover_image_photo','categories','iswishlist','prod_categories','aProductSaleprice','aProductvariant_photo','highest_rate'));

    }

     public function all_products(Request $request){

        $products=Product::where('status','active')->orderBy('id','desc')->get();

        $prod_categories=Category::where('is_parent',0)->where('status','active')->get();

        $aProductSaleprice=array();

        $aProductvariant_photo=array();

        $iswishlist=array();

        $aDiscountpercent=array();

        $ahover_image_photo=array();

        foreach($products as $key=>$product){

            // var_dump($key);

            $variant=ProductVariant::where('product_id',$product->id)->where('status','active')->first();

            if($product->discount_type=="fixed"){

                if($variant->regular_price!=0){

                array_push($aDiscountpercent,($product->discount / $variant->regular_price)*100);

                }else{

                   array_push($aDiscountpercent,0);

                }

                }else{

               array_push($aDiscountpercent,$product->discount);

                }

            $category=Category::where('is_parent',0)->where('status','active')->whereIn('id', explode(',',$product->category))->where('home','active')->first();

            $saleprice= $this->fetchSalePrice($variant->regular_price,$product['tax_id'],$product['discount'],$product['discount_type']);

            $A_prodimg = explode(',', $variant->photo);

            array_push($aProductvariant_photo,$A_prodimg[0]);

            if(count($A_prodimg) > 1){

                array_push($ahover_image_photo,$A_prodimg[1]);

            }else{

                array_push($ahover_image_photo,$A_prodimg[0]);

            }

            array_push($aProductSaleprice,$saleprice['sale_price']);

            if(auth()->guard('users')->user()){

                $wishlist=Wishlist::where('product_id',$product->id)->where('customer_id',auth()->guard('users')->user()->id)->first();

                if(isset($wishlist)){

                    array_push($iswishlist,'yes');

                }else{

                    array_push($iswishlist,'no');

                }

            }

         }

         $highest_rate=Product::where('status','active')->max('regular_price');

       return view('frontend.product',compact('products','aDiscountpercent','ahover_image_photo','iswishlist','prod_categories','aProductSaleprice','aProductvariant_photo','highest_rate'));

    }

    // new arraival
public function newarrival(request $request)
{
    $products=Product::where('status','active')->orderBy('id','desc')->get();

        $prod_categories=Category::where('is_parent',0)->where('status','active')->get();

        $aProductSaleprice=array();

        $aProductvariant_photo=array();

        $iswishlist=array();

        $aDiscountpercent=array();

        $ahover_image_photo=array();

        foreach($products as $key=>$product){

            // var_dump($key);

            $variant=ProductVariant::where('product_id',$product->id)->where('status','active')->first();

            if($product->discount_type=="fixed"){

                if($variant->regular_price!=0){

                array_push($aDiscountpercent,($product->discount / $variant->regular_price)*100);

                }else{

                   array_push($aDiscountpercent,0);

                }

                }else{

               array_push($aDiscountpercent,$product->discount);

                }

            $category=Category::where('is_parent',0)->where('status','active')->whereIn('id', explode(',',$product->category))->where('home','active')->first();

            $saleprice= $this->fetchSalePrice($variant->regular_price,$product['tax_id'],$product['discount'],$product['discount_type']);

            $A_prodimg = explode(',', $variant->photo);

            array_push($aProductvariant_photo,$A_prodimg[0]);

            if(count($A_prodimg) > 1){

                array_push($ahover_image_photo,$A_prodimg[1]);

            }else{

                array_push($ahover_image_photo,$A_prodimg[0]);

            }

            array_push($aProductSaleprice,$saleprice['sale_price']);

            if(auth()->guard('users')->user()){

                $wishlist=Wishlist::where('product_id',$product->id)->where('customer_id',auth()->guard('users')->user()->id)->first();

                if(isset($wishlist)){

                    array_push($iswishlist,'yes');

                }else{

                    array_push($iswishlist,'no');

                }

            }

         }

         $highest_rate=Product::where('status','active')->max('regular_price');

    return view('frontend.whatsnew',compact('products','aDiscountpercent','ahover_image_photo','iswishlist','prod_categories','aProductSaleprice','aProductvariant_photo','highest_rate'));
}

}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;

use App\Models\Category;

use App\Models\Brand;

use App\Models\Attribute;

use App\Exports\UsersExport;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

use App\Imports\UsersImport;

use App\Models\ProductAttribute;

use App\Models\Tax;

use App\Models\Inventory;

use App\Models\ProductVariant;

use App\Models\ProductSpecifications;

use App\Models\ProductReviews;

use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Session;

use Auth;

use App\Models\ProductImages;

use App\Models\CartTable;
use App\Models\Wishlist;
use App\Models\Clientfeedback;

class ProductController extends Controller

{

      function __construct()

    {
         $this->middleware('permission:products-view|products-add|products-edit|products-delete', ['only' => ['index','store']]);

         $this->middleware('permission:products-add', ['only' => ['create','store']]);

         $this->middleware('permission:products-edit', ['only' => ['edit','update']]);

         $this->middleware('permission:products-delete', ['only' => ['destroy']]);

         $this->middleware('permission:product_review-view', ['only' => ['productriviewes']]);

         $this->middleware('permission:products-add', ['only' => ['add_product_attribute']]);

         $this->middleware('permission:inventory-view', ['only' => ['listproduct']]);

        //  $this->userid=@Auth::user()->id;

        //  $this->username=@Auth::user()->name;

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
    /*
    public function index()

    {

        // $user=(Auth::user()->roles[0]->id == 1) ?['1',$this->userid] : [$this->userid];

        $product=Product::orderBy('id','DESC')->get();

        $Aproductimg_variant=array();

        $Acategory=array();

        foreach($product as $key=>$prod){

            $value=DB::table('product_variants')->where('product_id',$prod->id)->orderBy('id','desc')->where('status','active')->first();

            $A_prodimg = explode(',', $value->photo);

            array_push($Aproductimg_variant,$A_prodimg[0]);

        }

        $heading=DB::table('headings')->where('type','products')->where('status','active')->first();

            return view('backend.product.index',compact('product','heading','Aproductimg_variant'));

    }
    */

    public function index(Request $request)
{
    $searchTerm = $request->get('search');
    $perPage = $request->get('per_page', 10);

    $productQuery = Product::query()
    ->leftJoin('categories as main_category', 'products.category', '=', 'main_category.id') // Main category
    ->leftJoin('categories as sub_category', 'products.subcategory_id', '=', 'sub_category.id') // Subcategory
    ->leftJoin('categories as child_category', 'products.childcategory_id', '=', 'child_category.id') // Childcategory
    ->select(
        'products.*',
        'main_category.title as category_title',
        'sub_category.title as subcategory_title',
        'child_category.title as childcategory_title'
    );

// Add search condition if there's a search term
if ($searchTerm) {
    $productQuery->where(function ($query) use ($searchTerm) {
        $query->where('products.name', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('products.regular_price', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('products.stock', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('products.hsn_code', 'LIKE', '%' . $searchTerm . '%')

              ->orWhere('main_category.title', 'LIKE', '%' . $searchTerm . '%') // Search in main category title
              ->orWhere('sub_category.title', 'LIKE', '%' . $searchTerm . '%') // Search in subcategory title
              ->orWhere('child_category.title', 'LIKE', '%' . $searchTerm . '%'); // Search in childcategory title
    });
}

    // Apply ordering and pagination
    $product = $productQuery->orderBy('products.id', 'DESC')->paginate($perPage)->withQueryString();

    // Get the total count of products
    $totalProducts = Product::count();

    // Prepare images for product variants
    $Aproductimg_variant = array();
    foreach ($product as $prod) {
        $value = DB::table('product_variants')->where('product_id', $prod->id)
                ->orderBy('id', 'desc')
                ->where('status', 'active')
                ->first();
        if ($value !== null) {
            $A_prodimg = explode(',', $value->photo);
            array_push($Aproductimg_variant, $A_prodimg[0]);
        } else {
            array_push($Aproductimg_variant, ''); // Or a default image
        }
    }

    // Get heading for the page
    $heading = DB::table('headings')->where('type', 'products')->where('status', 'active')->first();

    // Return the view with the necessary data
    return view('backend.product.index', compact('product', 'heading', 'Aproductimg_variant', 'totalProducts'));
}

    public function listproduct()

    {

        // $user=(Auth::user()->roles[0]->id == 1) ?['1',$this->userid] : [$this->userid];
        /*
        $product=ProductVariant::orderBy('id','DESC')->get();

        foreach($product as $key=>$p){
            if($p->in_stock <= 0){
                $product[$key]['in_stock']=0;
            }else{
                $product[$key]['in_stock']=$p->in_stock;
            }
        }
        */
          $product = Product::leftJoin('order_products', 'products.id', '=', 'order_products.product_id')
        ->leftJoin('orders', function ($join) {
            $join->on('order_products.order_id', '=', 'orders.id');
        })
        ->select('products.id', 'products.name')
        ->selectRaw('COALESCE(SUM(order_products.quantity), 0) AS total_sold')
        ->where('orders.payment_status', '=', 'paid')
        ->groupBy('products.id', 'products.name')
        ->orderBy('products.id', 'DESC')
        ->get();

            // $product = Product::orderBy('id', 'DESC')->get();

            return view('backend.inventory.product',compact('product'));

    }

     public function stockoutproduct()
    {
        $outproductIds = ProductVariant::select('product_id')
            ->where('status', 'active')
            ->groupBy('product_id')
            ->havingRaw('SUM(CASE WHEN in_stock = 0 THEN 1 ELSE 0 END) = COUNT(*)')
            ->pluck('product_id');

        $product = Product::where(function ($query) use ($outproductIds) {
            $query->where('stock', 0)
                  ->orWhereIn('id', $outproductIds);
        })
        ->orderBy('id', 'DESC')
        ->get();

        // Return the stockout view with filtered products
        return view('backend.inventory.stockoutproduct', compact('product'));
    }

    public function inactiveproduct(){

        $product = Product::leftJoin('order_products', 'products.id', '=', 'order_products.product_id')
        ->leftJoin('orders', function ($join) {
            $join->on('order_products.order_id', '=', 'orders.id');
        })
        ->select('products.id', 'products.name')
        ->selectRaw('COALESCE(SUM(order_products.quantity), 0) AS total_sold')
        ->where('products.status', '=', 'inactive')
        ->groupBy('products.id', 'products.name')
        ->orderBy('products.id', 'DESC')
        ->get();

            // $product = Product::orderBy('id', 'DESC')->get();

            return view('backend.inventory.inactiveproduct',compact('product'));

    }

    public function productStatus(Request $request)

    {

        $aCartData = Session::get('cart',[]);

    //    dd($request->all());

    if($request->mode=='true'){

        DB::table('products')->where('id',$request->id)->update(['status'=>'active']);

        DB::table('cart_tables')->where('product_id',$request->id)->update(['status'=>'active']);

        DB::table('wishlists')->where('product_id',$request->id)->update(['status'=>'active']);

           // $aCartData[$request->id]['status']="inactive";

    }

    else{

        DB::table('cart_tables')->where('product_id',$request->id)->update(['status'=>'inactive']);

        DB::table('wishlists')->where('product_id',$request->id)->update(['status'=>'inactive']);

        DB::table('products')->where('id',$request->id)->update(['status'=>'inactive']);
        DB::table('cart_tables')->where('product_id',$request->id)->delete();

        //$aCartData[$request->id]['status']="active";

    }

   // Session::put('cart',$aCartData);

    return response()->json(['msg'=>'Successfully update status','status'=>true]);

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        $Product=Product::first();

      //  $productattribute=ProductAttribute::orderBy('id','ASC')->get();

         $tax=Tax::where('status','active')->get();

         //$category=Category::where('status','active')->get();
          $category = Category::where('parent_id', null)->where('status','active')->orderBy('id', 'DESC')->get();

        return view('backend.product.add',compact('tax','category','Product'));

    }

    public function get_subproducts(Request $request){

        if(isset($request->id)){

               $categories=Category::where('status','active')->where('parent_id',$request->id)->get();

         }

          else{

                $categories=[];

            }

      return response()->json(['categories'=>$categories]);

    }
    public function get_childproducts(Request $request){

        if(isset($request->id)){

               $sub_cate_id =  $request->id;

               $categories=Category::where('status','active')->where('sub_cate_id',$sub_cate_id)->get();

         }

          else{

                $categories=[];

            }

      return response()->json(['categories'=>$categories]);

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

       $data=$request->all();

        $stock='';
        if(isset($data['stock']) && is_array($data['stock']) && count($data['stock'])>0){
          $stock = array_sum($data['stock']);
        } elseif(isset($data['prod_stock'])) {
            $stock = $data['prod_stock'];
        }

        $regular_price='';
        if(isset($data['regular_price']) && is_array($data['regular_price']) && isset($data['regular_price'][0])){
          $regular_price = $data['regular_price'][0];
        } elseif(isset($data['prod_regular_price'])) {
            $regular_price = $data['prod_regular_price'];
        }

       $sku = random_int(100000, 9999999);

       $slug=Str::slug($request->input('name'));

       $slug_count=Product::where('slug',$slug)->count();

       if($slug_count>0){

           $slug .=time().'-'.$slug;

       }

       $product=new Product;
      $product->tag = $request->input('tag');

       $product->name=$data['name'];

       $product->description=$data['description'];

       $product->slug=$slug;

       //$product->category=implode(',',$data['category']);

       $product->category=$data['category'];

       if(isset($data['subcategory_id'])){

             $product->subcategory_id=$data['subcategory_id'];

       }
        if(isset($data['childcategory_id'])){

             $product->childcategory_id=$data['childcategory_id'];

       }

       $product->brand_name=0;
       $product->youtube_link=$data['youtube_link'];

       $product->regular_price=$regular_price;

        $product->stock=$stock;

       $product->tax_id=$data['tax_id'];
        $product->delivery_days=$data['delivery_days'];

        $product->hsn_code=$data['hsn_code'];

        // $product->size=$data['size'];

       $product->discount=$data['discount'];

       $product->discount_type=$data['discount_type'];

    //   $product->header=$data['header'];

    //    $product->top_rated_products=$data['top_rated_products'];

       //$product->benefits=$data['benefits'];

       $product->usage=$data['usage'];

        $product->status="inactive";
       //$product->ingrediants=$data['ingrediants'];

    //    var_dump($product);

    //    exit;

       $product->save();

       if(isset($data['attribute_name']) && (!isset($data['is_variant']) || $data['is_variant'] == 'yes')){

        foreach($data['attribute_name'] as $key=>$val){

            if(!empty($val)){

                $attribute=new ProductAttribute;

                $attribute['attribute_value']=implode(',',$data['attribute_value']);

                $attribute['product_id']=$product->id;

                $attribute['attribute_name']=$data['attribute_name'][$key];

                $attribute->save();

            }

        }

        if(isset($data['attribute_value'] )){

        for($i=0;$i<count($data['attribute_value']);$i++){

             $variant_id = $data['variant_id'][$i];
            $new_colors = '';
            if(!empty($variant_id)){

                if(isset($data['colors_'.$variant_id]) && !empty($data['colors_'.$variant_id])){
                    $colors = $data['colors_'.$variant_id];
                    $new_colors = implode(',',$colors);
                }

            }

            $attribute=new ProductVariant;

            $attribute['product_id']=$product->id;

            $attribute['sku']=$data['sku'][$i];

            $attribute['colors']= $new_colors;
            if(!empty($data['photo'][$i])){

                $attribute['photo']=$data['photo'][$i];

            }

            $attribute['regular_price']=$data['regular_price'][$i];

            $attribute['in_stock']=$data['stock'][$i];

            //$attribute['variants']=$data['attribute_value'][$i];
            if($data['attribute_value'][$i]){
              $attribute_value = str_replace(",", "", $data['attribute_value'][$i]);
              $attribute['variants']= $attribute_value;
            }

            $attribute->save();

                  //   Logs for Stocks
                $dataa = [];
                $dataa['product_id'] = $product->id;;
                $dataa['v_id'] = $attribute->id;
                $dataa['size'] = $attribute['variants'];
                $dataa['opr'] = 'ADD';
                $dataa['qty'] = $data['stock'][$i];
                $dataa['closure_qty'] = $data['stock'][$i];
                $dataa['remarks'] = 'Initial Product Stock';
                $dataa['created_at'] = date('Y-m-d H:i:s');
                DB::table('stock_log')->insert($dataa);

           //specifications

           $ProductSpecifications=new ProductSpecifications;

           $ProductSpecifications->prod_variant_id=$attribute->id;

           //    $ProductSpecifications->attribute_name=$data['attribute_name'][$i];

           $ProductSpecifications->attribute_value=$attribute->variants;

           $ProductSpecifications->save();

           //inventory

           $Productinventory=new Inventory;

           $Productinventory->prod_variant_id=$attribute->id;

           $Productinventory->total_stock=$data['stock'][$i];

           $Productinventory->sold=0;

           $Productinventory->in_stock=$data['stock'][$i];

           $Productinventory->save();

        }

    }

        }else{

            $product_variant=new ProductVariant;

            $product_variant->product_id=$product->id;

            $product_variant->sku=$sku;

            $product_variant->variants="default";

            $product_variant->regular_price=(isset($data['prod_regular_price'])) ? $data['prod_regular_price'] : 0;

            $product_variant->in_stock=(isset($data['prod_stock'])) ? $data['prod_stock'] : 0;

            $product_variant->photo=$data['product_photo'];

            $product_variant->save();

            $Productinventory=new Inventory;

            $Productinventory->prod_variant_id=$product_variant->id;

            $Productinventory->total_stock=(isset($data['prod_stock'])) ? $data['prod_stock'] : 0;

            $Productinventory->sold=0;

            $Productinventory->in_stock=(isset($data['prod_stock'])) ? $data['prod_stock'] : 0;

            $Productinventory->save();

                //   Logs for Stocks
                $dataa = [];
                $dataa['product_id'] = $product->id;;
                $dataa['v_id'] = $product_variant->id;
                $dataa['size'] = 'default';
                $dataa['opr'] = 'ADD';
                $dataa['qty'] = $data['prod_stock'];
                $dataa['closure_qty'] = $data['prod_stock'];
                $dataa['remarks'] = 'Initial Product Stock Part';
                $dataa['created_at'] = date('Y-m-d H:i:s');
                DB::table('stock_log')->insert($dataa);

        }

        if($product){

            Session::put('success','Product successfully added');
            return redirect()->route('product.index');

        }

        else{

            return back()->with('error','something went wrong!');

        }

    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        $Product=Product::find($id);

        $productattribute=ProductAttribute::where('product_id',$id)->orderBy('id','ASC')->get();

        $productvariant=ProductVariant::where('product_id',$id)->orderBy('id','ASC')->get();

        // $check_variant=DB::table('product_variant')->where('product_id',$id)->where('arrtibute_name',"")->where('variant_id',0)->first();

        // if($check_variant->arrtibute_name == ""){

        // DB::table('product_variant')->where('product_id',$id)->where('variant_id',0)->where('arrtibute_name',"")->delete();

        // }

        if($Product){

            return view('backend.product.product_attribute',compact(['Product','productattribute','productvariant']));

        }

        else{

            return back()->with('error','Product not  found');

        }

    }

    public function getVariant(Request $request){

        $data = $request->all();

        $id=$data['id'];

        $Product=Product::find($id);

        $productattribute=ProductAttribute::where('product_id',$id)->orderBy('id','ASC')->get();

        $productvariant=ProductVariant::where('product_id',$id)->orderBy('id','ASC')->get();

        if($Product){

            return response()->json(['Product'=>$Product,'productattribute'=>$productattribute,'productvariant'=>$productvariant]);

          //  return view('backend.product.product_attribute',compact(['Product','productattribute','productvariant']));

        }

        else{

            return back()->with('error','Product not found');

            return response()->json(['status'=>false,'data'=>null,'msg'=>'Attribute not found']);

        }

    }

public function add_product_attribute(Request $request,$id)

{

  $data = $request->all();

  //dd($data);

  //ProductVariant

  if(isset($data['attribute_name'] )){

  foreach($data['attribute_name'] as $key=>$val){

      if(!empty($val)){

          $attribute=new ProductAttribute;

          $attribute['arrtibute_value']=implode(',',$data['attribute_value_'.$val]);

          $attribute['product_id']=$id;

          $attribute['arrtibute_name']=$data['attribute_name'][$key];

          $attribute->save();

      }

  }

  DB::table('product_variants')->where('product_id',$id)->where('variant_id',0)->where('arrtibute_name',"default")->delete();

  for($i=0;$i<count($data['attribute_value']);$i++){

    $attribute=new ProductVariant;

    $attribute['product_id']=$id;

    $attribute['sku']=$data['sku'][$i];

    $attribute['variant_id']=$data['variant_id'][$i];

    $attribute['photo']=$data['photo'][$i];

    $attribute['regular_price']=$data['regular_price'][$i];

    $attribute['sale_price']=$data['sale_price'][$i];

    $attribute['stock']=$data['stock'][$i];

    $attribute['arrtibute_name']=$data['attribute_value'][$i];

    $attribute->save();

}

  }

 Session::put('success','Product Attribute Successfully Added');

  return redirect()->back();

}

public function add_product_attribute_delete($id)

{

    $ProductAttribute=ProductAttribute::find($id);

        if($ProductAttribute){

            $status=$ProductAttribute->delete();

            if($status){

                 Session::put('error','ProductAttribute successfully deleted');

                return redirect()->back();

            }

            else{

                return back()->with('error','Data not found');

            }

        }

}

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {
        $clone=false;
        if(isset($_REQUEST['clone']) && $_REQUEST['clone']){
             $clone=true;

        }

        $product_id=$id;

        $Product=Product::find($id);

        if(!$Product){
            return back()->with('error','Product not found');
        }

        $Acategory=array();

        $productattributes=ProductAttribute::where('product_id',$id)->orderBy('id','desc')->get();

        $tax=Tax::where('status','active')->get();

       // $category=Category::where('status','active')->get();
         $category = Category::where('parent_id', null)->where('status','active')->orderBy('id', 'DESC')->get();

        $sub_category=Category::where('status','active')->where('parent_id','=',$Product->category ?? null)->get();

        $child_category=Category::where('status','active')->where('parent_id','=',$Product->subcategory_id ?? null)->get();

        $product_attributename=array();

        $product_variant=DB::table('product_variants')->where('product_id',$id)->orderBY('id','desc')->first();
        $productVariants=DB::table('product_variants')->where('product_id',$id)->get();
        $in_stock = $productVariants->count() ? $productVariants->sum('in_stock') : 0;

        foreach($productattributes as $productattribute){

            $product_attributename=$productattribute->attribute_name;

        }

            //array_push($Acategory,$Product->category);

            $Acategory = explode(',',$Product->category ?? '');

            // foreach($category as $cate){

            //     if(in_array($cate->id, $Acategory))

            //         echo 'if';

            //     else{

            //         var_dump($Acategory);

            //     }

            //     }

            //     exit;

            // var_dump($Acategory);

            // exit;

        if($Product){

            $prevProduct = Product::where('id', '<', $id)->max('id');
             $nextProduct = Product::where('id', '>', $id)->min('id');

            return view('backend.product.edit',compact(['Product','Acategory','sub_category','child_category','product_variant','product_attributename','category','productattributes', 'tax','product_id', 'in_stock','clone','nextProduct','prevProduct']));

        }

        else{

            return back()->with('error','Product not  found');

        }

    }

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)

    {

        $product=Product::find($id);

        if($product){

            $this->validate($request,[

                'title'=>'string|required',

                'summary'=>'string|required',

                'description'=>'string|nullable',

                'additional_info'=>'nullable',

                'return_cancellation'=>'nullable',

                'brand_name'=>'required',

                'mpn'=>'required|numeric',

                'gtin'=>'required',

                'gtin_type'=>'required',

                'brand_id'=>'required',

                'cat_id'=>'required|exists:categories,id',

                'photo'=>'required',

                'size_guide'=>'required',

                'discount'=>'nullable|numeric',

             //    'size'=>'nullable',

                'conditions'=>'nullable',

             //    'vendor_id '=>'nullable',

                'status'=>'nullable|in:active,inactive',

                'meta_keyworg'=>'nullable',

                'meta_description'=>'nullable',

            ]);

          $data=$request->all();

          $data['offer_price']=($request->price-(($request->price*$request->discount)/100));

          // return $data;

          $status=$product->fill($data)->save();

          if($status){

              Session::put('success','product Successfully update');

               return redirect()->route('product.index');

          }else{

              return back()->with('error','something went worng!');

          }

        }else{

            return back()->with('error','Category not fround');

        }

    }

public function AttributeUpdate(Request $request, $id){

$data=$request->all();

// print_r($data);exit();

$stock='';
if(isset($data['stock']) && is_array($data['stock']) && count($data['stock'])>0){
  $stock = array_sum($data['stock']);
} elseif(isset($data['prod_stock'])) {
  $stock = $data['prod_stock'];
}

$regular_price='';
if(isset($data['regular_price']) && is_array($data['regular_price']) && isset($data['regular_price'][0])){
  $regular_price = $data['regular_price'][0];
} elseif(isset($data['prod_regular_price'])) {
  $regular_price = $data['prod_regular_price'];
}

$attribute_delete=ProductAttribute::where('product_id',$id);

$attribute_delete->delete();

// $variant_delete=ProductVariant::where('product_id',$id);

// $variant_delete->delete();

  if(isset($data['warehouse_id'])){

    $prod=new Product;

    $prod['warehouse_id']=$data['warehouse_id'];

    $prod['supplier_id']=$data['supplier_id'];

    $prod->update();

  }

  $sku = random_int(100000, 9999999);

  $slug=Str::slug($request->input('name'));

  $slug_count=Product::where('slug',$slug)->count();

  if($slug_count>0){

      $slug .=time().'-'.$slug;

  }

  if(isset($data['attribute_name'])){

  foreach(@$data['attribute_name'] as $key=>$val){

        if(!empty($val)){

            $attribute=new ProductAttribute;

            $attribute['attribute_value']=implode(',',$data['attribute_value_'.$val]);

            $attribute['product_id']=$id;

            $attribute['attribute_name']=$data['attribute_name'][$key];

            $attribute->save();

        }

    }

    $tempVarientSku = [];

    for($i=0;$i<count(@$data['attribute_value']);$i++){

    $variant_id = $data['variant_id'][$i];
    $new_colors = '';
    if(!empty($variant_id)){
        if(!empty($data['colors_'.$variant_id])){
            $colors = $data['colors_'.$variant_id];
            $new_colors = implode(',',$colors);
        }

    }

$tempVarientSku[]=$data['sku'][$i];

        // Match variant by combination (e.g., "BlueS") instead of SKU
        $currentVariantValue = '';
        if(isset($data['attribute_value'][$i])){
            $currentVariantValue = str_replace(",", "", $data['attribute_value'][$i]);
        }

        $variantAvail = ProductVariant::where('product_id',$id)
                                      ->where('variants',$currentVariantValue)
                                      ->first();
        if($variantAvail!=''){

            $variantAvail->colors = $new_colors;

            $variantAvail->photo = $data['photo'][$i];

            // Update SKU if provided
            if(isset($data['sku'][$i]) && !empty($data['sku'][$i])){
                $variantAvail->sku = $data['sku'][$i];
            }

            $variantAvail->regular_price = $data['regular_price'][$i];

            $variantAvail->in_stock = $data['stock'][$i];

            if($data['attribute_value'][$i]){
                  $attribute_value = str_replace(",", "", $data['attribute_value'][$i]);
                  $variantAvail->variants = $attribute_value;
              }

             $variantAvail->save();

        } else {

              $attribute=new ProductVariant;

      $attribute['product_id']=$id;

      $attribute['sku']=$data['sku'][$i];

      $attribute['colors']= $new_colors;

  //    $attribute['variant_id']=$data['variant_id'][$i];

      $attribute['photo']=$data['photo'][$i];

      $attribute['regular_price']=$data['regular_price'][$i];

      //$attribute['sale_price']=$data['sale_price'][$i];

      $attribute['in_stock']=$data['stock'][$i];

      if($data['attribute_value'][$i]){
          $attribute_value = str_replace(",", "", $data['attribute_value'][$i]);
          $attribute['variants']= $attribute_value;
      }
      //$attribute['variants']=$data['attribute_value'][$i];

      $attribute->save();

        }

           //specifications

           $ProductSpecifications=new ProductSpecifications;

           $ProductSpecifications->prod_variant_id=$attribute->id;

           //    $ProductSpecifications->attribute_name=$data['attribute_name'][$i];

           $ProductSpecifications->attribute_value=$attribute->variants;

           $ProductSpecifications->save();

           //inventory

           $Productinventory=new Inventory;

           $Productinventory->prod_variant_id=$attribute->id;

           $Productinventory->total_stock=$data['stock'][$i];

           $Productinventory->sold=0;

           $Productinventory->in_stock=$data['stock'][$i];

           $Productinventory->save();

    }

    // Collect all variant combinations that should be kept
    $tempVariantCombinations = [];
    for($i=0; $i<count(@$data['attribute_value']); $i++){
        if(isset($data['attribute_value'][$i])){
            $attribute_value = str_replace(",", "", $data['attribute_value'][$i]);
            $tempVariantCombinations[] = $attribute_value;
        }
    }

    // Delete only variants that are NOT in the current attribute value list
    // This preserves existing variants like "BlueS" when adding new ones like "BlueM"
    ProductVariant::where('product_id',$id)->whereNotIn('variants',$tempVariantCombinations)->delete();

}else{

    // Try to find default variant, or fallback to the first variant if it's a simple product migration
    $product_variant = ProductVariant::where('product_id', $id)->where('variants', 'default')->first();
    if (!$product_variant) {
        $product_variant = ProductVariant::where('product_id', $id)->first();
    }
    // If absolutely no variant exists, create a new one
    if (!$product_variant) {
        $product_variant = new ProductVariant;
        $product_variant->product_id = $id;
        $product_variant->sku = $sku;
        $product_variant->variants = "default";
    }

    $product_variant->regular_price = (isset($data['prod_regular_price'])) ? $data['prod_regular_price'] : 0;
    $product_variant->in_stock = (isset($data['prod_stock'])) ? $data['prod_stock'] : 0;
    if (isset($data['product_photo'])) {
        $product_variant->photo = $data['product_photo'];
    }

    $product_variant->save();

    // Update Inventory
    $Productinventory = Inventory::where('prod_variant_id', $product_variant->id)->first();
    if (!$Productinventory) {
        $Productinventory = new Inventory;
        $Productinventory->prod_variant_id = $product_variant->id;
        $Productinventory->sold = 0;
    }

    $Productinventory->total_stock = (isset($data['prod_stock'])) ? $data['prod_stock'] : 0;
    $Productinventory->in_stock = (isset($data['prod_stock'])) ? $data['prod_stock'] : 0;
    $Productinventory->save();

}

  $product=Product::find($id);

  $product->name=$data['name'];

  $product->description=$data['description'];

  $product->slug=$slug;

 // $product->category=implode(',',$data['category']);

 $product->category=$data['category'];

  $product->brand_name=$data['brand_name'];

  $product->tax_id=$data['tax_id'];
 $product->delivery_days=$data['delivery_days'];
  $product->hsn_code=$data['hsn_code'];

  $product->discount=$data['discount'];
  $product->youtube_link=$data['youtube_link'];
  $product->discount_type=$data['discount_type'];
    $product->tag=$data['tag'];

  $product->regular_price=$regular_price;

  $product->stock=$stock;

  if(isset($data['subcategory_id'])){

    $product->subcategory_id=$data['subcategory_id'];

}
 if(isset($data['childcategory_id'])){

    $product->childcategory_id=$data['childcategory_id'];

}

//   $product->header=$data['header'];

//   $product->top_rated_products=$data['top_rated_products'];

  //$product->benefits=$data['benefits'];

  $product->usage=$data['usage'];

 // $product->ingrediants=$data['ingrediants'];

  $product->update();

/*
 if (isset($data['product_photo']) && !empty($data['product_photo']) && $data['product_photo']!='') {
   $iews = DB::table('product_variants')
        ->where('product_id', $request->id)
        ->update(['photo' => $data['product_photo']]);

}
*/

  Session::put('success','Product Successfully Updated');

  return  redirect()->route('product.index');

}

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        $Product=Product::find($id);

        if($Product){

            $status=$Product->delete();
            $carts=CartTable::where('product_id',$id)->delete();
            $wishlist=Wishlist::where('product_id',$id)->delete();
            if($status){

               Session::put('error','product successfully deleted');

                return redirect()->route('product.index');

            }

            else{

                return back()->with('error','Data not found');

            }

        }

        else{

            return back()->with('error','Data not  found');

        }

    }

    public function getChildByParentID(Request $request,$id)

    {

        $categories=Category::find($request->id);

        if($categories){

            $child_id=Category::getChildByParentID($request->id);

        if(count($child_id)<=0){

            return response()->json(['status'=>false,'data'=>null,'msg'=>'']);

        }

        return response()->json(['status'=>true,'data'=>$child_id,'msg'=>'']);

        }

        else{

            return response()->json(['status'=>false,'data'=>null,'msg'=>'Category not found']);

        }

    }

    public function export(Request $request)

    {

       return Excel::download(new UsersExport,'Product-list.xlsx');

    }

public function importform()

{

    return view('backend.product.index');

}

    public function import(Request $request)

    {

       return Excel::import(new UsersImport,$request->file('file')->store('temp'));

       return back();

    }

    public function getAttributeByID(Request $request)

    {

        $attribute_id=Attribute::where('attribute_type',$request->get('id'))->get('value');

        if(count($attribute_id)<=0){

            return response()->json(['status'=>false,'data'=>null,'msg'=>'']);

        }

        $sizesArray = [];
        $d = $attribute_id[0]->value ?? '';

        // If value is already an array, use it directly
        if (is_array($d)) {
            $sizesArray = $d;
        } elseif (is_object($d)) {
            $sizesArray = (array) $d;
        } elseif (is_string($d) && $d !== '') {
            // Try JSON decode first
            $decoded = json_decode($d, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $sizesArray = $decoded;
            } else {
                // Fallback to comma-separated string
                if (strpos($d, ',') !== false) {
                    $sizesArray = array_map('trim', explode(',', $d));
                } else {
                    $sizesArray = [trim($d)];
                }
            }
        }

        return response()->json(['status'=>true,'data'=>$sizesArray,'msg'=>'']);

    }

    public function product_show(request $request)

    {

       $id=$request->id;

        $product=Product::find($id);

        //print_r($product);

        //echo $coupon->coupon_code;

        //$product=Category::where('id',$product->cat_id)->first();

        $categories=Category::find($product->cat_id);

        $sub_cat="";

        if($product->child_cat_id != "" && $product->child_cat_id != NULL){

             $scategories=Category::find($product->child_cat_id);

             if(!empty($scategories->id)){

                 $sub_cat=$scategories->title;

            }

         }

        $brand=Brand::find($product->brand_id);

        $title=html_entity_decode($product->title);

        $brand_name=html_entity_decode($product->brand_name);

        $summary=html_entity_decode($product->summary);

        $description=html_entity_decode($product->description);

        $mpn=$product->mpn;

        $gtin=$product->gtin;

        $gtin_type=$product->gtin_type;

        $discount=number_format($product->discount)."%";

        $image="<img src='$product->photo' alt=''style='max-height: 350px;max-width:350px' id='image'>";

        $photo=explode(',',$product->photo);

        $photo=$photo[0];

        //return response()->json(['title'=> $title,'summary'=> $summary,'photo'=> explode(',',$product->photo)[0],'description'=>$description,'price'=> $price,'offer_price'=> $offer_price,'discount'=>$discount,'stock'=> $product->stock,'category'=> $categories->title,'sub_category'=> $sub_cat,'brand'=> $brand->title,'size'=> $product->size,'conditions'=> $product->conditions,'status'=> $product->status]);

        return response()->json(['title'=> $title,'brand_name'=>$brand_name,'mpn'=>$mpn,'gtin'=>$gtin,'gtin_type'=>$gtin_type,'summary'=> $summary,'photo'=> $photo,'description'=>$description,'discount'=>$discount,'stock'=> $product->stock,'category'=> $categories->title,'sub_category'=> $sub_cat,'brand'=> $brand->title,'tax_value'=> $product->tax_value,'conditions'=> $product->conditions,'status'=> $product->status]);

    }

    public function productriviewes()
    {
        $productreviews = ProductReviews::orderBy('id', 'DESC')->get();
        $products = [];

        foreach ($productreviews as $review) {
            $product = Product::where('id', $review->product_id)->first();

            if ($product) {
                array_push($products, $product->name);
            } else {
                // Handle case where product is not found (optional)
                array_push($products, 'Product Not Found'); // Placeholder or alternative handling
            }
        }

        return view('backend.product.product_reviewes', compact('productreviews', 'products'));
    }

    public function productriviewesStatus(Request $request)

    {

        if($request->mode=='true'){

            DB::table('product_reviews')->where('id',$request->id)->update(['status'=>'accept']);

        }

        else{

            DB::table('product_reviews')->where('id',$request->id)->update(['status'=>'reject']);

        }

        return response()->json(['msg'=>'Successfully update status','status'=>true]);

    }

    public function clientriviewesStatus(Request $request)

    {

        if($request->mode=='true'){

            DB::table('client_feedback')->where('id',$request->id)->update(['status'=>'accept']);

        }

        else{

            DB::table('client_feedback')->where('id',$request->id)->update(['status'=>'reject']);

        }

        return response()->json(['msg'=>'Successfully update status','status'=>true]);

    }

    public function clientreviewes()
    {
        $productreviews = Clientfeedback::orderBy('id', 'DESC')->get();
        $products = [];

        foreach ($productreviews as $review) {
            $product = Product::where('id', $review->product_id)->first();

            if ($product) {
                array_push($products, $product->name);
            } else {
                // Handle case where product is not found (optional)
                array_push($products, 'Product Not Found'); // Placeholder or alternative handling
            }
        }

        return view('backend.product.client_feedback', compact('productreviews', 'products'));
    }

    public function add_stock(Request $request,$id){

        $user=(Auth::user()->roles[0]->id == 1) ?['1',$this->userid] : [$this->userid];

        $Product=Product::find($id);

        $productattribute=ProductAttribute::where('product_id',$id)->orderBy('id','ASC')->get();

        $productvariant=ProductVariant::where('product_id',$id)->orderBy('id','ASC')->get();

        if($Product){

            return view('backend.inventory.addstock',compact(['Product','productattribute','productvariant']));

        }

        else{

            return back()->with('error','Product not  found');

        }

        $Product=DB::table('products')->where('id','=',$id)->get();

    }

    public function product_heading(Request $request){

        $headings=DB::table('headings')->where('type',$request->type)->where('status','active')->update(['value'=>$request->value]);

        $resval['success']=true;

        Session::put('success','Saved Successfully');

        return response()->json(['resval'=>$resval]);

    }
    public function bulkDeletebk(Request $request)
    {
        $ids = $request->ids;
        Product::whereIn('id', $ids)->delete();

        return response()->json(['success' => 'Products deleted successfully.']);
    }

     public function bulkDelete(Request $request)
{
    // Validate that 'ids' is provided and is an array
    $request->validate([
        'ids' => 'required|array',
    ]);

    $ids = $request->ids;

    // Delete products and their related cart items using relationships
    Product::whereIn('id', $ids)->each(function ($product) {
        $product->cartItems()->delete(); // Delete related cart items
        $product->delete(); // Delete the product itself
    });

    return response()->json(['success' => 'Products deleted successfully.']);
}

    public function bulkactive(Request $request)
    {
        $ids = $request->ids;

        Product::whereIn('id', $ids)->update(['status'=>'active']);

        return response()->json(['success' => 'Products active successfully.']);
    }
    // public function bulkdeactive(Request $request)
    // {
    //     $ids = $request->ids;

    //     Product::whereIn('id', $ids)->update(['status'=>'inactive']);

    //     return response()->json(['success' => 'Products deactive successfully.']);
    // }

    public function bulkdeactive(Request $request)
{
    $ids = $request->ids;

    // Get the products that are going to be deactivated
    $products = Product::whereIn('id', $ids)->get();

    // Loop through the products and update status to 'inactive' and add alerts
    $deactivated_products = [];
    foreach ($products as $product) {
        $product->status = 'inactive';
        $product->save();  // Save the changes

        // Add alert for deactivated product
        $deactivated_products[] = [
            'product_id' => $product->id,
            'message' => 'This product has been deactivated.',
        ];
    }

    // Return response with success and deactivated products information
    return response()->json([
        'success' => 'Products deactivated successfully.',
        'deactivated_products' => $deactivated_products
    ]);
}

    public function updatestockmanually(Request $request,$id){

        $Product=Product::find($id);

        $productvariant=ProductVariant::where('product_id',$id)->orderBy('id','ASC')->get();
          return view('backend.inventory.stockupdate',compact(['Product','productvariant']));

    }
    public function updatestockstore(Request $request){

        $productId = $request->id;
        $v_id = $request->v_id;
        $opr = $request->opr;
        $stockvalue = $request->stockvalue;

        $productvariant=ProductVariant::find($v_id);
        if($opr=="add"){
           $productvariant->in_stock =   $productvariant->in_stock + $stockvalue;
           $productvariant->save();
        }
        if($opr=="minus"){
            if($stockvalue > $productvariant->in_stock){
                echo 'Reduce value is more than current stock';
                exit();
            }
           $productvariant->in_stock =   $productvariant->in_stock - $stockvalue;
           $productvariant->save();
        }

        $overallStock=ProductVariant::where('product_id',$productId)->sum('in_stock');
        $Product=Product::find($productId);
        $Product->stock = $overallStock;
        $Product->save();

        $data = [];
        $data['product_id'] = $productId;
        $data['v_id'] = $v_id;
        $data['size'] = $productvariant->variants;
        $data['opr'] = strtoupper($opr);
        $data['qty'] = $stockvalue;
        $data['closure_qty'] = $productvariant->in_stock;
        $data['remarks'] = 'Manually by Admin';
        $data['created_at'] = date('Y-m-d H:i:s');
        DB::table('stock_log')->insert($data);

  Session::put('success','Stoke Successfully Updated');

  return  redirect()->route('updatestockmanually', ['id' => $productId]);

    }

     public function viewstocklogs(Request $request,$id){

        $data = DB::table('stock_log')->where('v_id',$id)->orderBy('id','DESC')->get();

          return view('backend.inventory.viewstockslog',compact(['data']));

    }

}

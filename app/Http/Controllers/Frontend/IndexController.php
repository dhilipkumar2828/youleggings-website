<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\User;
use App\Models\CustomerTable;
use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\CartTable;
use Cart;
use App\Models\Usedcoupon;
use App\Models\Coupon;
use App\Models\Advertisement;
use App\Traits\PriceTrait;
use App\Models\Order;
use App\Models\Reason;
use App\Models\OrderProduct;
use PDF;
use App\Models\ProductReviews;
use App\Models\About;
use App\Models\Contact;
use App\Models\Contactform;
use App\Models\BillingAddress;
use App\Models\ShippingAddress;
use App\Models\Blog;
use App\Models\Faqs;
use App\Models\Promo;
use App\Models\Terms;
use App\Models\Privacy;
use App\Models\Delivery;
use App\Models\Visitors;
use Illuminate\Support\Facades\Mail;
use App\Mail\AuthenMail;
use App\Models\Deals;
use App\Models\ProductVariant;
use App\Models\Otp;
use App\Models\Guest;
use App\Models\Clientfeedback;
use DB;
use URL;
use Auth;
use Validator;
use Illuminate\Support\Facades\Session;
use Redirect;
use App\Traits\SMSTrait;
use Illuminate\Support\Facades\Hash;
class IndexController extends Controller
{
    use PriceTrait;
    use SMSTrait;
    function __construct()
    {
        //  $this->middleware('permission:Customer View', ['only' => ['customerlist']]);
        //  $this->middleware('permission:Customer View', ['only' => ['customerview']]);
        //  $this->userIp = \Request::ip();
        //  $this->locationData = \Location::get($this->userIp);
        //  \App\Http\Controllers\Frontend\IndexController::visitors();
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

     public function getSubcategories($categoryId)
{
    // Fetch subcategories based on the category ID
  //  $subcategories = Subcategory::where('category_id', $categoryId)->get();
$subcategories=Product::where('status','active')->where('category',$categoryId)->get();
    return response()->json([
        'subcategories' => $subcategories,
    ]);
}

    public function index()
{
    // var_dump(Auth::guard('users')->user()->id);
    // exit;
    $this->sessionremove();
    $banners = Banner::where('status', 'active')->orderBy('id', 'DESC')->get();
    $products = Product::where('status', 'active')->orderBy('id', 'desc')->get();
    $categories = Category::where('is_parent', 0)->where('status', 'active')->orderBy('homeorder', 'asc')->where('home', 'active')->get();
   // $advertisement = Advertisement::where('status', 'active')->orderBy('id', 'desc')->first();
    $advertisement = Advertisement::where('status', 'active')->where('position','=','1')->first();
    $advertisement2 = Advertisement::where('status', 'active')->where('position','=','2')->first();

    $allreviews=Clientfeedback::where('status','accept')->orderBy('id','desc')->get();
    $abouts=About::first();
    $abouts_banner=Banner::orderBy('id','DESC')->first();
    $aProductvariant_photo = array();
    $aProductSaleprice = array();
    $aDiscountpercent = array();
    $iswishlist = array();
    $ahover_image_photo = array();

    for ($i = 0; $i < count($categories); $i++) {
        $category_id = $categories[$i]['id'];
        $A_products = DB::table('products')->where('status', 'active')->whereRaw("FIND_IN_SET('$category_id',category)")->orderBy('id', 'desc')->limit(8)->get();

        foreach ($A_products as $key => $product) {
            $variant = ProductVariant::where('product_id', $product->id)->where('status', 'active')->first();

            // Ensure $variant is not null
            if ($variant !== null) {
                $category = Category::where('is_parent', 0)->where('status', 'active')->whereIn('id', explode(',', $product->category))->where('home', 'active')->first();
                if ($product->discount_type == "fixed") {
                    if ($variant->regular_price != 0) {
                        array_push($aDiscountpercent, ($product->discount / $variant->regular_price) * 100);
                    } else {
                        array_push($aDiscountpercent, 0);
                    }
                } else {
                    array_push($aDiscountpercent, $product->discount);
                }

                $saleprice = $this->fetchSalePrice($variant->regular_price, $product->tax_id, $product->discount, $product->discount_type);
                $A_prodimg = explode(',', $variant->photo);
                array_push($aProductvariant_photo, $A_prodimg[0]);

                if (count($A_prodimg) > 1) {
                    array_push($ahover_image_photo, $A_prodimg[1]);
                } else {
                    array_push($ahover_image_photo, $A_prodimg[0]);
                }
                array_push($aProductSaleprice, $saleprice['sale_price']);

                if (auth()->guard('users')->user()) {
                    $wishlist = Wishlist::where('product_id', $product->id)->where('customer_id', auth()->guard('users')->user()->id)->first();
                    if (isset($wishlist)) {
                        array_push($iswishlist, 'yes');
                    } else {
                        array_push($iswishlist, 'no');
                    }
                }
            }
        }
    }

        $settings = \App\Models\Setting::first();
        $blogs = \App\Models\Blog::where('status', 'active')->orderBy('id', 'desc')->get();
        $default_contact = \App\Models\Contact::first();
        
        return view('frontend.index', compact('abouts','abouts_banner','allreviews','banners', 'ahover_image_photo', 'aDiscountpercent', 'advertisement', 'iswishlist', 'categories', 'products', 'aProductvariant_photo', 'aProductSaleprice','advertisement2', 'settings', 'blogs', 'default_contact'));
    }

    public function guestlogin()
    {
             $this->sessionremove();
        $abouts_banner=Banner::orderBy('id','DESC')->limit('1')->get();
        $abouts=About::first();
       // $abouts=About::all();
        return view('frontend.auth.guest',compact('abouts','abouts_banner'));
    }

    public static function envUpdate($key, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $key . '=' . env($key), $key . '=' . $value, file_get_contents($path)
            ));
        }
    }
    public function about()
    {
             $this->sessionremove();
        $abouts_banner=Banner::orderBy('id','DESC')->limit('1')->get();
        $abouts=About::first();
        $settings = \App\Models\Setting::first();
       // $abouts=About::all();
        return view('frontend.about',compact('abouts','abouts_banner', 'settings'));
    }

      public function reviews()
    {
             $this->sessionremove();
        $abouts_banner=Banner::orderBy('id','DESC')->limit('1')->get();
        $abouts=About::first();
       // $abouts=About::all();
        return view('frontend.reviews',compact('abouts','abouts_banner'));
    }

     public function help()
    {
             $this->sessionremove();
        $abouts_banner=Banner::orderBy('id','DESC')->limit('1')->get();
        $abouts=About::first();
       // $abouts=About::all();
        return view('frontend.help',compact('abouts','abouts_banner'));
    }
    public function blogs()
    {
        $blogs_banner=Banner::where('status', 'active')->orderBy('id','DESC')->limit('1')->get();
        $blogs = Blog::where('status', 'active')->orderBy('publish_at', 'DESC')->paginate(9);
        return view('frontend.blog',compact('blogs','blogs_banner'));
    }

    public function blog_detail($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $blogs_banner = Banner::where('status', 'active')->orderBy('id','DESC')->limit('1')->get();
        $recent_blogs = Blog::where('status', 'active')->where('id', '!=', $blog->id)->orderBy('publish_at', 'DESC')->limit(3)->get();
        return view('frontend.blog_detail', compact('blog', 'blogs_banner', 'recent_blogs'));
    }
    public function contactus()
    {
        $settings = \App\Models\Setting::first();
        return view('frontend.contact', compact('settings'));
    }
    public function contactform(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        $details['name'] = $request->name;
        $details['mobile'] = $request->mobile ?? $request->phone;
        $details['email'] = $request->email;
        $details['message'] = $request->message;

        // Save to database
        Contactform::create([
            'name' => $details['name'],
            'email' => $details['email'],
            'phone' => $details['mobile'],
            'message' => $details['message'],
        ]);

        dispatch(new \App\Jobs\ContactEmailJob($details));

        return response()->json([
            'success' => true,
            'message' => 'Successfully created Contact'
        ]);
    }

    public function contact_form(Request $request)
    {
        $details['name'] = $request->name;
        $details['mobile'] = $request->phone;
        $details['email'] = $request->email;
        $details['message'] = $request->message;

        // Save to database
        Contactform::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ]);

        dispatch(new \App\Jobs\ContactEmailJob($details));

        return response()->json([
            'success' => true,
            'message' => 'Thank you for contacting us! We will get back to you soon.'
        ]);
    }
    public function faq()
    {
        $faqs_banner=Banner::orderBy('id','DESC')->limit('1')->get();
        $faqss=Faqs::first();
       // $abouts=About::all();
        return view('frontend.faqs',compact('faqss','faqs_banner'));
    }
       public function deliveryr()
    {
        $delivery_banner=Banner::orderBy('id','DESC')->limit('1')->get();
        $delivery_ret=Delivery::first();
       // $abouts=About::all();
        return view('frontend.deliveryreturns',compact('delivery_ret','delivery_banner'));
    }
     public function privacyp()
    {
        $privacy_banner=Banner::orderBy('id','DESC')->limit('1')->get();
        $privacy_pol=Privacy::first();
       // $abouts=About::all();
        return view('frontend.privacypolicy',compact('privacy_pol','privacy_banner'));
    }
    // public function faq()
    // {
    //     $faqss=Faqs::first();
    //    // $abouts=About::all();
    //     return view('frontend.faqs',compact('faqss'));
    // }
    public function termsc()
    {
        $terms_banner=Banner::orderBy('id','DESC')->limit('1')->get();
        $terms_con=Terms::first();
       // $abouts=About::all();
        return view('frontend.termsconditions',compact('terms_con','terms_banner'));
    }

    public function shippingpolicy()
    {
        //$terms_banner=Banner::orderBy('id','DESC')->limit('1')->get();
        //$terms_con=Terms::first();
        //$abouts=About::all();
        return view('frontend.shipping_policy',array());
    }

    public function cancellationpolicy()
    {
        return view('frontend.cancellation_policy',array());
    }
////user auth
    public function userAuth()
    {
        $this->sessionremove();

        $customer = Auth::guard('users')->user() ?? Auth::guard('guest')->user();
        $customer_id = $customer ? $customer->id : null;

          if ($customer_id) {
                $this->syncCart($customer);
            }
         if (Auth::guard('users')->check()) {
           $user=Auth::guard('users')->user();
        } elseif (Auth::guard('guest')->check()) {
           $user=Auth::guard('guest')->user();
        } else {
            $user ='';
        }

        if($user){
             return redirect()->route('checkout1');
        }else{
            Session::put('coustomer.intended',URL::previous());
            return view('frontend.Auth.auth');
        }

    }
     public function user1Auth()
    {
        $this->sessionremove();

         if (Auth::guard('users')->check()) {
           $user=Auth::guard('users')->user();
        } elseif (Auth::guard('guest')->check()) {
           $user=Auth::guard('guest')->user();
        } else {
            $user ='';
        }

        if($user){
             return redirect()->route('checkout1');
        }else{
            Session::put('coustomer.intended',URL::previous());
            return view('frontend.Auth.auth_new');
        }

    }
    public function guestAuth()
    {
        $this->sessionremove();

         if (Auth::guard('users')->check()) {
           $user=Auth::guard('users')->user();
        } elseif (Auth::guard('guest')->check()) {
           $user=Auth::guard('guest')->user();
        } else {
            $user ='';
        }

        if($user){
            return redirect()->route('checkout1');
        }else{
            Session::put('coustomer.intended',URL::previous());
            return view('frontend.Auth.guest');
        }

    }
    public function loginsumbit(Request $request)
{
    // Retrieve session data
    $aCartData = Session::get('cart', []);
    $swishlistData = Session::get('wishlist', []);
    $sreviewData = Session::get('product_review', []);

    // Check if the user exists with the provided mobile number
    $login_check = User::where('role', 'customer')->where('phone', $request->mobile)->first();

    // If user exists, proceed to check the password
    if (!empty($login_check)) {

        if (\Hash::check($request->password, $login_check->password)) {

            // Attempt to authenticate the user
            if (Auth::guard('users')->attempt(['phone' => $request->mobile, 'password' => $request->password])) {
                Session::put('users', $request->mobile);
                Session::put('success', 'Login Successfully');
                // Handle intended URL redirection
                if (Session::get('url.intended')) {
                    if($aCartData){
                        return redirect()->route('checkout1');
                    }else{
                        return redirect()->route('index');
                    }
                    //return redirect()->route('index');
                    // return redirect()->route('checkout1');
                }

                // Process session data for reviews
                if (!empty($sreviewData)) {
                    foreach ($sreviewData as $key => $session) {
                        $slug = Product::where('id', $session['product_id'])->first();
                        $duplicate_check = DB::table('product_reviews')
                            ->where('product_id', $session['product_id'])
                            ->where('customer_id', auth()->guard('users')->user()->id)
                            ->first();
                        if (empty($duplicate_check)) {
                            $session_reviews = new ProductReviews;
                            $session_reviews->customer_id = auth()->guard('users')->user()->id;
                            $session_reviews->product_id = $session['product_id'];
                            $session_reviews->rate = $session['rate'];
                            $session_reviews->review = $session['review'];
                            $session_reviews->name = $session['name'];
                            $session_reviews->phone_number = $session['phone'];
                            $session_reviews->email = $session['email'];
                            $session_reviews->save();
                        } else {
                            ProductReviews::where('status', 'accept')
                                ->where('customer_id', auth()->guard('users')->user()->id)
                                ->where('product_id', $session['product_id'])
                                ->update([
                                    'name' => $session['name'],
                                    'review' => $session['review'],
                                    'email' => $session['email'],
                                    'phone_number' => $session['phone'],
                                    'rate' => $session['rate']
                                ]);
                        }
                    }
                }

                // Process session data for wishlist
                if (!empty($swishlistData)) {
                    foreach ($swishlistData as $key => $session) {
                        $duplicate_check = DB::table('wishlists')
                            ->where('product_id', $session['product_id'])
                            ->where('customer_id', auth()->guard('users')->user()->id)
                            ->first();
                        if (empty($duplicate_check)) {
                            $session_wishlists = new Wishlist;
                            $session_wishlists->customer_id = auth()->guard('users')->user()->id;
                            $session_wishlists->arrtibute_name = $session['arrtibute_name'];
                            $session_wishlists->product_id = $session['product_id'];
                            $session_wishlists->status = "active";
                            $session_wishlists->save();
                        } else {
                            if(!empty($session['product_id'])){
                            DB::table('wishlists')
                                ->where('product_id', $session['product_id'])
                                ->where('customer_id', auth()->guard('users')->user()->id)
                                ->delete();
                            }
                        }
                    }
                }

                // Process session data for cart
                if (!empty($aCartData)) {
                    foreach ($aCartData as $key => $session) {

                        if(!empty($session['product_id'])){
                             $product = Product::where('id', $session['product_id'])->first();

                                $duplicate_check = DB::table('cart_tables')
                            ->where('product_varient', $session['product_varients_id'])
                            ->where('customer_id', auth()->guard('users')->user()->id)
                            ->first();
                            if (empty($duplicate_check)) {
                                $cart_tables = new CartTable;
                                $cart_tables->product_id = $session['product_id'];
                                $cart_tables->product_name = $session['product_name'];
                                $cart_tables->product_qty = $session['product_qty'];
                                $cart_tables->price = $session['price'];
                                $cart_tables->product_varient = $session['product_varients_id'];
                                $cart_tables->arrtibute_name = $session['variant'];
                                $cart_tables->status = 'active';
                                $cart_tables->customer_id = auth()->guard('users')->user()->id;
                                $cart_tables->save();
                            } else {
                                DB::table('cart_tables')
                                    ->where('product_id', $session['product_id'])
                                    ->where('customer_id', auth()->guard('users')->user()->id)
                                    ->update(['product_qty' => $session['product_qty']]);
                            }
                        }
                    }
                }

                // Clear session data and set success message
                Session::forget('product_review');
                Session::put('success', 'Successfully login');
                //return redirect()->route('index');
                // return redirect()->route('checkout1');
                if($aCartData){
                    return redirect()->route('checkout1');
                }else{
                    return redirect()->route('index');
                }
            } else {
                Session::put('error', 'Authentication failed');
                return redirect()->route('user.auth');
            }
        } else {
            // If password is incorrect
            Session::put('error', 'Incorrect password');
            return redirect()->route('user.auth');
        }
    } else {
        // If user does not exist
        Session::put('error', 'Invalid Mobile Number');
        return redirect()->route('user.auth');
    }
}
    /*
    public function loginsumbit(Request $request)
    {

        $aCartData = Session::get('cart',[]);
        $swishlistData=Session::get('wishlist',[]);
        $sreviewData=Session::get('product_review',[]);
        $login_check=User::where('role','customer')->where('phone',$request->mobile)->first();

        if(!empty($login_check)){
            if(\Hash::check($request->password,$login_check->password)){

            }else{

                 Session::put('error','Incorrect password');
                return redirect()->route('user.auth');

            }
            if(Auth::guard('users')->attempt(['phone'=>$request->mobile,'password'=>$request->password])){

                Session::put('users',$request->mobile);

                if(Session::get('url.intended')){
                    return redirect()->route('index');

                }
                   else{
                    if(@auth()->guard('users')->user()){
                    }

                    if(!empty($sreviewData)){

                        foreach($sreviewData as $key => $session){
                            $slug=Product::where('id',$sreviewData['product_id'])->first();
                            $duplicate_check=DB::table('product_reviews')->where('product_id',$sreviewData['product_id'])->where('customer_id', auth()->guard('users')->user()->id)->first();
                            if(empty($duplicate_check)){
                             $session_reviews=new ProductReviews;
                             $session_reviews->customer_id=auth()->guard('users')->user()->id;
                             $session_reviews->product_id=$sreviewData['product_id'];
                             $session_reviews->rate=$sreviewData['rate'];
                             $session_reviews->review=$sreviewData['review'];
                             $session_reviews->name=$sreviewData['name'];
                             $session_reviews->phone_number=$sreviewData['phone'];
                             $session_reviews->email=$sreviewData['email'];
                             $session_reviews->save();
                            }else{
                                ProductReviews::where('status','accept')->where('customer_id',auth()->guard('users')->user()->id)->where('product_id',$sreviewData['product_id'])->update(['name'=>$sreviewData['name'],'review'=>$sreviewData['review'],'email'=>$sreviewData['email'],'phone_number'=>$sreviewData['phone'],'rate'=>$sreviewData['rate']]);
                            }
                        }

                    }

                    if(!empty($swishlistData)){
                        foreach($swishlistData as $key => $session){
                            $duplicate_check=DB::table('wishlists')->where('product_id',$aCartData[$key]['product_id'])->where('customer_id', auth()->guard('users')->user()->id)->first();
                            if(empty($duplicate_check)){
                             $session_wishlists=new Wishlist;
                             $session_wishlists->customer_id=auth()->guard('users')->user()->id;
                             $session_wishlists->arrtibute_name=$aCartData[$key]['arrtibute_name'];
                             $session_wishlists->product_id=$aCartData[$key]['product_id'];
                             $session_wishlists->status="active";
                            }else{
                                DB::table('wishlists')->where('product_id',$aCartData[$key]['product_id'])->where('customer_id', auth()->guard('users')->user()->id)->delete();
                            }
                        }
                    }
                    if(!empty($aCartData)){
                        foreach($aCartData as $key => $session){

                            $product=Product::where('id',$aCartData[$key]['product_id'])->first();
                            $duplicate_check=DB::table('cart_tables')->where('product_id',$aCartData[$key]['product_id'])->where('customer_id', auth()->guard('users')->user()->id)->first();
                            if(empty($duplicate_check)){
                         $cart_tables = new CartTable;

                         $cart_tables->product_id = $aCartData[$key]['product_id'];
                         $cart_tables->product_name =  $aCartData[$key]['product_name'];
                         $cart_tables->product_qty =$aCartData[$key]['product_qty'];
                         $cart_tables->price =  $aCartData[$key]['price'];
                         $cart_tables->arrtibute_name= $aCartData[$key]['variant'];
                         $cart_tables->status = 'active';
                         $cart_tables->customer_id = auth()->guard('users')->user()->id;
                         $cart_tables->save();
                            }else{
                             DB::table('cart_tables')->where('product_id',$aCartData[$key]['product_id'])->where('customer_id', auth()->guard('users')->user()->id)->update(['product_qty'=>$aCartData[$key]['product_qty']]);
                            }
                        }

                    }
                    Session::forget('product_review');
                    Session::put('success','Successfully login');
                    return redirect()->route('index');

                   }
               }

        }else{

            Session::put('error','Invalid Mobile Number');
            return redirect()->route('user.auth');

        }
    }
    */
    /*
    public function Registersumbit(Request $request)
    {
        $duplicate_check=User::where('phone',$request->phone_number)->where('role','customer')->first();
         if(isset($duplicate_check)){
           return response()->json(['success'=>false]);
         }
          $data=$request->all();
          //dd($data);
         //$data['password']= Hash::make($request->password);
        // $data['role'] = "customer";
          $check=$this->create($data);
         Session::put('users',$data['name']);
         Auth::guard('users')->login($check);
         $aCartData = Session::get('cart',[]);
         if(!empty($aCartData)){
             foreach($aCartData as $key => $session){
                 $duplicate_check=DB::table('cart_tables')->where('product_id',$aCartData[$key]['product_id'])->where('customer_id', auth()->guard('users')->user()->id)->first();
                 if(empty($duplicate_check)){
              $cart_tables = new CartTable;
              $cart_tables->product_id = $aCartData[$key]['product_id'];
              $cart_tables->product_name =  $aCartData[$key]['product_name'];
              $cart_tables->product_qty =$aCartData[$key]['product_qty'];
              //  $data->rowId=$result->rowId;
              $cart_tables->price =  $aCartData[$key]['price'];
              //  $data->options = json_encode($product_option);
              $cart_tables->arrtibute_name= $aCartData[$key]['variant'];
              $cart_tables->status = 'active';
              $cart_tables->customer_id = auth()->guard('users')->user()->id;
              $cart_tables->save();
                 }else{
             DB::table('cart_tables')->where('product_id',$aCartData[$key]['product_id'])->where('customer_id', auth()->guard('users')->user()->id)->update(['product_qty'=>$aCartData[$key]['product_qty']]);
                 }
             }
         }
        // Session::forget('cart');
          if($check){
              Session::put('success','Successfully Create User');
              return response()->json(['success'=>"Successfully Register"]);
          }else{
              return back()->with('error','something went worng!');
          }
      }
      */
      public function Registersumbit(Request $request)
    {

        // Check for duplicate phone number
        $duplicate_check = User::where('phone', $request->phone_number)->where('role', 'customer')->first();
        if (isset($duplicate_check)) {
           // Session::put('error', 'Phone number already exists');
            return response()->json(['error' => false, 'message' => 'Phone number already exists']);
        }

        // Prepare data for creating the user
        $data = $request->all();
        $data['phone'] = $request->phone_number;
        $data['password'] = '';
        $data['role'] = 'customer';

        // Create the user
        $check = $this->create($data);

        // Debugging: Dump the user object and die
       // dd($check);

        // Log the user in
        Auth::guard('users')->login($check);

        // Check if the user is authenticated
        if (Auth::guard('users')->check()) {
           // Log::info('User logged in successfully', ['user' => $check]);

            $aCartData = Session::get('cart', []);
            if (!empty($aCartData)) {
                foreach ($aCartData as $key => $session) {
                    $duplicate_check = DB::table('cart_tables')
                        ->where('product_id', $aCartData[$key]['product_id'])
                        ->where('customer_id', auth()->guard('users')->user()->id)
                        ->where('product_varient', $key)
                        ->first();
                    if (empty($duplicate_check)) {
                        $cart_tables = new CartTable;
                        $cart_tables->product_id = $aCartData[$key]['product_id'];
                        $cart_tables->product_name = $aCartData[$key]['product_name'];
                        $cart_tables->product_qty = $aCartData[$key]['product_qty'];
                        $cart_tables->price = $aCartData[$key]['price'];
                        $cart_tables->arrtibute_name = $aCartData[$key]['variant'];
                        $cart_tables->status = 'active';
                        $cart_tables->customer_id = auth()->guard('users')->user()->id;
                        $cart_tables->product_varient = $key;
                        $cart_tables->save();
                    } else {
                        DB::table('cart_tables')
                            ->where('product_id', $aCartData[$key]['product_id'])
                            ->where('customer_id', auth()->guard('users')->user()->id)
                            ->update(['product_qty' => $aCartData[$key]['product_qty']]);
                    }
                }
            }

            //sms message
            if($request->phone_number){
                $key = "8cnx5PVTXSCKxjZy";
                $mbl = $request->phone_number;
                $message_content = "Welcome aboard! Thank you for creating an account with us. You can access it here at any time www.prrayashacollections.com -PRRCOL";
                $encoded_message_content = urlencode($message_content);
                $senderid = "PRRCOL";
                $route = "1";
                $templateid = "1707171888161440185";

                $url = "https://sms.textspeed.in/vb/apikey.php?apikey=$key&senderid=$senderid&templateid=$templateid&number=$mbl&message=$encoded_message_content";

                $output = file_get_contents($url);
            }
            Session::put('success', 'Successfully Created User');
            return response()->json(['success' => "Successfully Registered", 'cartData' => $aCartData ? 1 : 0]);
        } else {
            Log::error('User login failed', ['user' => $check]);
            return back()->with('error', 'Login failed!');
        }
    }
    public function create(array $data)
    {
        return User::create([
            'name'=>$data['name'],
            'phone'=>$data['phone_number'],
            'email'=>$data['email'],
            'password'=>Hash::make('12345'),
            'role'=>'customer',
        ]);
    }
    public function userlogout()
    {

        //  if (Auth::guard('guest')->check()) {

        //         $customer_id = Auth::guard('guest')->user()->id;
        //         // Delete cart item from database for guests
        //         DB::table('cart_tables')
        //             ->where('customer_id', $customer_id)
        //             ->delete();

        // }
        $customer = Auth::guard('users')->user() ?? Auth::guard('guest')->user();
        $customer_id = $customer ? $customer->id : null;

          if ($customer_id) {
             $this->syncCart($customer);
         }
      //  return;
        Session::forget('cart');
        Session::put('cart',[]);
        Auth::guard('users')->logout();
        Auth::guard('guest')->logout();

        Session::put('error','Successfully Logout');
        return redirect('index');
    }
    protected function syncCart($user)
{
       if (!$user) return;

    $cart = session()->get('cart', []);
//print_r($cart);
    // Normalize old cart format
    foreach ($cart as $key => $value) {
        if (is_numeric($key) && is_array($value)) {
            $cart['items'][$key] = $value;
            unset($cart[$key]);
        }
    }

    // Set or update the cart date
    $cart['date'] = now()->toDateString();

    // Save the fixed structure back to session
    session()->put('cart', $cart);

    // Re-fetch normalized cart
    $cart = session()->get('cart', []);

    // Check if cart is from today
    if ($cart['date'] !== now()->toDateString()) {
        return;
    }

    $sessionCart = $cart['items'] ?? [];
    // echo "test";
    // echo "<br>";
// print_r($sessionCart);
// exit;
    if (!empty($sessionCart)) {
        // Clear old cart records
        CartTable::where('customer_id', $user->id)->delete();

        // Save each item
        foreach ($sessionCart as $item) {
            if (!is_array($item) || !isset($item['product_id'])) continue;

            CartTable::create([
                'customer_id'     => $user->id,
                'product_id'      => $item['product_id'] ?? null,
                'product_varient' => $item['product_varient'] ?? null,
                'arrtibute_name'  => $item['variant'] ?? null,
                'product_qty'     => $item['product_qty'] ?? 1,
                'product_name'    => $item['product_name'] ?? '',
                'product_color'   => $item['product_color'] ?? '',
                'price'           => $item['price'] ?? 0,
                'status'          => $item['status'] ?? 1,
            ]);
        }

        // Clear session cart
        session()->forget('cart');
    } else {
        // Clear DB cart if no session items
        CartTable::where('customer_id', $user->id)->delete();
    }

}
    public function userAccount()
   {
    $user=Auth::guard('customer')->user();
    //$order=Order::with('orderproduct')->with('product')->get();
    $order = DB::table('orders')->select('orders.*')//,'products.title','products.photo'
     //->join('order_products', 'orders.id', '=', 'order_products.order_id')
    // ->join('products', 'products.id', '=', 'order_products.product_id')
     ->join('customer', 'customer.id', '=', 'orders.customer_id')
     ->where('orders.customer_id',$user->id)
     ->orderBy('orders.id','desc')
     ->get();
  return view('frontend.costomer.user_account',compact('user','order'));
   }
   public function view_details($id)
   {
      $user=Auth::guard('customer')->user();
      $order=Order::find($id);
      $data=OrderProduct::where('order_id',$id)->get();
$id=$id;
$check_cancel=array();
 foreach($data as $d){
array_push($check_cancel,$d->status);
 }
 in_array('Cancellation Requested',$check_cancel)?$status = "cancelled" : $status="no";
       return view('frontend.costomer.view_details',compact('order','data','id','status'));
     //return view('frontend.costomer.view_details');
   }
   public function tracking($id)
   {
        $user=Auth::guard('customer')->user();
        $orders=Order::find($id);
        return view('frontend.track',compact('orders'));
   }
   public function cancel($id)
   {
        $user=Auth::guard('customer')->user();
        $order=Order::find($id);
        $data=OrderProduct::where('order_id',$id)->get();
       // $c_reason=Reason::where('order_id',$id)->first();
        $cc_reason=DB::table('reasons')->select('reason')
        ->where('order_id',$id)->orderby('id',"DESC")->limit(1)
        ->get();
        if(count($cc_reason) > 0){
           $c_reason['reason']=$cc_reason[0]->reason;
        }else{
            $c_reason=array('reason'=>'none');
        }
        //print_r($c_reason);
       // die();
        if($order){
        return view('frontend.costomer.reason',compact('order','data','c_reason'));
        }
   }
   public function reason_status(Request $request)
   {
    // $this->validate($request,[
    //     'reason'=>'string|required',
    //     'order_id'=>'string|nullable',
    // ]);
       // echo $request->order_id;
        //echo $request->reason;
       $order=Order::where($request->order_id);
        $data= new Reason;
        $data->reason=$request->reason;
        $data->order_id=$request->id;
        $data->description=$request->description;
        $data->save();
        for($i=0;$i<count($request->checkbox);$i++){
            OrderProduct::where('order_id',$request->id)->where('product_id',$request->checkbox[$i])->update(['status'=>'Cancellation Requested']);
            DB::table('suborders_items')->where('order_id',$request->id)->where('products_id',$request->checkbox[$i])->update(['status'=>'Cancellation Requested']);
        }
       if($order){
            return redirect("/customer/cancle/$request->order_id")->with('status', 'Order Has Been canceled');
        }else{
            return redirect("/customer/cancle/$request->order_id")->with('status', 'Failled Please try again');
        }
   }
   public function downloadPdf($id)
   {
    $user=Auth::guard('customer')->user();
    $order=Order::find($id);
    $data=OrderProduct::where('order_id',$id)->get();
     //$pdf = PDF::loadView('frontend.costomer.view_details','order','data');
    //echo $pdf = PDF::loadView('frontend.costomer.view_details',compact('order','data'));
    //$pdf = PDF::loadView('frontend.costomer.view_details',compact('order','data'));
    //return view('frontend.costomer.test',compact('order','data'));
    $pdf = PDF::loadView('frontend.costomer.invoice',compact('order','data'));
    $order_id=$order->order_id;
    return $pdf->download('invoice-'.$order_id.'.pdf');
   }
   public function billingAddress(Request $request,$id)
   {
    //return $request->all();
    $coustomer=CustomerTable::where('id',$id)->Update(['country'=>$request->country,'city'=>$request->city,'postcode'=>$request->postcode,'state'=>$request->state,'address'=>$request->address]);
    if($coustomer){
      Session::put('success','Address Successfuly Update');
        return back();
    }
    else{
        return back()->with('error','something went worng!');
    }
   }
   public function customerlist()
   {
    $customer=User::where('role','customer')->get();
    return view('backend.user.customer-list',compact('customer'));
   }
   public function customerview($id)
   {
    $customer=CustomerTable::find($id);
    return view('backend.user.customer-view',compact('customer'));
   }
   public function shippingAddress(Request $request,$id)
   {
    //return $request->all();
    $coustomer=CustomerTable::where('id',$id)->Update(['scountry'=>$request->scountry,'scity'=>$request->scity,'spostcode'=>$request->spostcode,'sstate'=>$request->sstate,'saddress'=>$request->saddress]);
    if($coustomer){
        Session::put('success','ShippingAddress Successfuly Update');
         return back();
    }
    else{
        return back()->with('error','something went worng!');
    }
   }
   public function accountUpdate(Request $request,$id)
   {
    $this->validate($request,[
        'name'=>'required|string',
        'user_name'=>'string|nullable',
        'phone'=>'nullable|min:10'
    ]);
       $hashpassword=Auth::guard('customer')->user()->password;
if($request->oldpassword==null && $request->newpassword==null){
    $coustomer=CustomerTable::where('id',$id)->Update(['name'=>$request->name,'user_name'=>$request->user_name,'phone'=>$request->phone]);
}else{
    if(\Hash::check($request->oldpassword,$hashpassword)){
        if(!\Hash::check($request->newpassword,$hashpassword)){
            $coustomer=CustomerTable::where('id',$id)->Update(['name'=>$request->name,'user_name'=>$request->user_name,'phone'=>$request->phone,'password'=>Hash::make($request->newpassword)]);
            Session::put('success','Account successfully update');
            return back();
        }
        else{
             Session::put('error','new password can not be same with old password');
              return back();
        }
    }
    else{
        return back()->with('error','old password dose not macth');
    }
}
    if($coustomer){
       Session::put('success','Address Successfuly Update');
        return back();
    }
    else{
        return back()->with('error','something went worng!');
    }
   }
public function offers(Request $request){
    return view('frontend.offers');
}

public function lost_password(){
    return view('frontend.lost_password');
}

public function  create_lostpassword(Request $request){
    $length = 8;
    $password= substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
    if($request->type=="email"){

     $data['password']=$password;
     $data['email']=$request->email;
     $result= CustomerTable::where('email',$request->email)->update(['password'=>Hash::make($password)]);

      dispatch(new \App\Jobs\LostpasswordEmailJob($data));

    }else{
        $message_content=urlencode("Your newly generated password is ".$password." ");
        $this->sendSms($request->phone, '1707166375428192963', $message_content);
    }
    Session::put('success','Password Sent Successfully');
    return back();

}

    public function order_pdf($id){

        $data=OrderProduct::where('order_id',$id)->get();

        $discount_amt=array();

        foreach($data as $key=>$d){
            $product=DB::table('products')->where('id',$d->product_id)->first();
            $product_variant=DB::table('product_variant')->where('product_id',$d->product_id)->where('arrtibute_name',$d->option)->first();
            if($product->discount_type == "fixed"){
                $data[$key]['discount_value']=$product->discount;
            }else{
                $discount= $this->fetchSalePrice($product_variant->regular_price,$product->tax_id,$product->discount,$product->discount_type);
                $data[$key]['discount_value']=$discount['discount_price'];
            }
            array_push($discount_amt,$data[$key]['discount_value']);
        }

        $order=Order::find($id);

        $reason=Reason::orderBy('order_id','desc')->get();
        $billing_address=BillingAddress::where('order_id',$id)->first();
        $shipping_address=ShippingAddress::where('order_id',$id)->first();
        if(isset($billing_address)){
        $state=DB::table('state_list')->where('id',$billing_address->state)->first();
        }else{
            $state='';
        }

        // if($order->sub_total > 500){
        //     $delivery_charge=0.00;
        // }else{
        //     $delivery_charge=40.00;
        // }
        $delivery_charge = ($order->deliver_charge == '' || $order->deliver_charge == 'NULL') ? 0.00 : $order->deliver_charge;

        if($order){

       return view('frontend.order_pdf',compact('discount_amt','delivery_charge','state','order','data','reason','billing_address','shipping_address'));
        }
    }

    public function get_modalDetails(Request $request){
        $product=Product::where('status','active')->where('id',$request->product_id)->first();
        $subcategory=Product::where('status','active')->where('subcategory_id',$product->subcategory_id)->get();
        $productreviews=ProductReviews::where('status','accept')->where('product_id',$request->product_id)->get();
        $review=0;
        foreach($productreviews as $productreview){
            $review += $productreview->rate;
        }
        if($review != 0){
           $reviewvalue=$review/count($productreviews);
        }else{
            $reviewvalue=0;
        }
        $rating= ($reviewvalue);
        $saleprice= $this->fetchSalePrice($product->regular_price,$product->tax_id,$product->discount,$product->discount_type);
        $productvariant=ProductVariant::where('status','active')->orderBy('id','DESC')->where('product_id',$product->id)->first();
        $A_prodimg = explode(',', $productvariant->photo);
        $product_img=$A_prodimg[0];

        //reviews
        $rela_val=0;
        $relatedreviewval=DB::table('product_reviews')->where('product_id',$product->id)->get();
        foreach($relatedreviewval as $r){
        $rela_val += $r->rate;
        }
        $relatedreview=($rela_val!=0) ? (($rela_val)/count($relatedreviewval)) : 0;

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
        return response()->json(['product_img'=>$product_img,'subcategory'=>$subcategory,'productreviews'=>count($productreviews),'rating'=>$rating,'product'=>$product,'saleprice'=>$saleprice,'productvariant'=>$productvariant,'relatedreviewval'=>count($relatedreviewval),'relatedreview'=>$relatedreview,'cart_qty'=>$cart_qty]);
     }

     public function order_tracking(Request $request,$id){
        $order=Order::where('order_id',$id)->first();
        return view('frontend.order_tracking',compact('order'));
     }
     public function forget_password(){
        return view('frontend.forget_password');
    }

    public function reset_password(Request $request){
        $n = 4;
        $result = bin2hex(random_bytes($n));
        $details['customer_email'] =$request->email;
        $details['password'] =$result;
        //update user password
        $verifyresult = User::where('phone',$request->email)->update(['password'=>Hash::make($result)]);
       if($verifyresult){
            $key = "8cnx5PVTXSCKxjZy";
            $mbl = $request->email;
            $message_content = "Dear customer, the OTP to reset your password at PRRAYASHA COLLECTIONS is {#var#}. This OTP will expire in 5 minutes. Thank you.";
            $message_content = str_replace("{#var#}", $result, $message_content);
            $encoded_message_content = urlencode($message_content);
            $senderid = "PRRCOL";
            $route = "1";
            $templateid = "1707171895502287116";
            $url = "https://sms.textspeed.in/vb/apikey.php?apikey=$key&senderid=$senderid&templateid=$templateid&number=$mbl&message=$encoded_message_content";
            $output = file_get_contents($url);

        //dispatch(new \App\Jobs\ForgetEmailJob($details));
        return response()->json(['success'=>true]);
       }else{
        return response()->json(['success'=>false]);
       }
    }

    public function apply_coupon(Request $request) {
        date_default_timezone_set('Asia/Kolkata');
        $currTime = date('Y-m-d H:i:s'); // Get the current date and time

        // Ensure user is logged in
        if (!auth()->guard('users')->check()) {
            return response()->json(['msg' => "Kindly login and try", 'resval' => false]);
        }

        // Retrieve the coupon from the database
        $coupon = Coupon::where('coupon_code', $request->coupon_code)
                        ->where('status', 'active')
                        ->first();

        if (!empty($coupon)) {
            // Dynamically retrieve the required minimum amount for this coupon
            $min_amount_required = $coupon->offeramountabove;
            $total_Amt = $request->amount; // Total amount from the request (before discount)

            // Check if the total amount is above the minimum amount required
            if ($total_Amt < $min_amount_required) {
                return response()->json([
                    'msg' => "Total amount must be above ₹" . $min_amount_required . " to apply this coupon",
                    'resval' => false
                ]);
            }

            // Handle Date-based Coupon Validation for Percentage Coupons
            if ($coupon->offer_details != 1) {
                // Check if the coupon's start date is before or equal to the current time
                if ($coupon->start_date > $currTime) {
                    return response()->json(['msg' => "Coupon has not started yet", 'resval' => false]);
                }

                // Check if the coupon's end date is after or equal to the current time
                if ($coupon->end_date && $coupon->end_date < $currTime) {
                    return response()->json(['msg' => "Coupon has expired", 'resval' => false]);
                }
            }

            // Check if the user has already used the coupon
            $user = auth()->guard('users')->user();
            $usedcoupon = Usedcoupon::where('coupon_code', $coupon->id)
                                    ->where('customer_id', $user ? $user->id : null)
                                    ->first();

            if ($usedcoupon) {
                return response()->json(['msg' => "Coupon already used", 'resval' => false]);
            }

            // If the coupon is percentage-based
            if ($coupon->offer_details != 1) {
                // Process percentage-based coupon
                $productIds = explode(',', $coupon->product_id); // Assuming product_ids are stored as comma-separated values in the DB

                if (!empty($productIds)) {
                    // Get cart products matching the coupon's product_ids
                    $cartProducts = DB::table('cart_tables')
                                      ->whereIn('product_id', $productIds)
                                      ->where('customer_id', $user->id)
                                      ->get();

                    // If no valid cart products, return invalid message
                    if ($cartProducts->isEmpty()) {
                        return response()->json(['msg' => "Coupon Invalid for Cart Products", 'resval' => false]);
                    }

                    // Calculate the subtotal and total discount
                    $subtotal = 0;
                    $totalDiscount = 0;

                    foreach ($cartProducts as $product) {
                        if (in_array($product->product_id, $productIds)) {
                            // Calculate the percentage discount
                             $productDiscount = ($product->price * $product->product_qty *  $coupon->value / 100);
                            $totalDiscount += $productDiscount;
                        }
                        $subtotal += $product->price; // Add product price to subtotal
                    }

                    // Ensure the discount doesn't exceed the subtotal
                    $finalSubtotal = max(0, $subtotal - $totalDiscount);
                // Store the coupon data in the session
                    $S_coupon = [
                        'coupon_code' => $request->coupon_code,
                        'discount' =>   $totalDiscount,
                        'product_id' => $coupon->product_id,
                        'final_subtotal' => $finalSubtotal,
                        'id' => $coupon->id,
                    ];

                    Session::put('coupon', $S_coupon);

                    return response()->json([
                        'msg' => "Coupon applied successfully",
                        'resval' => true,
                        'coupon' => $S_coupon,
                        'final_subtotal' => $finalSubtotal,  // Include the final subtotal after discount
                    ]);
                }

            } else {
                // If the coupon is a flat discount
                $flatcoupon = Coupon::where('coupon_code', $request->coupon_code)
                                    ->where('status', 'active')
                                    ->where('offeramountabove', '<=', $request->amount)
                                    ->first();

                if ($flatcoupon) {
                    $S_coupon = [
                        'coupon_code' => $request->coupon_code,
                        'discount' => $flatcoupon->flatofferamount,
                        'product_id' => $coupon->product_id, // Store multiple product ids
                        'id' => $flatcoupon->id,
                    ];

                    // Store the coupon data in the session
                    Session::put('coupon', $S_coupon);

                    return response()->json([
                        'msg' => "Coupon applied successfully",
                        'resval' => true,
                        'coupon' => $S_coupon,
                    ]);
                } else {
                    return response()->json([
                        'msg' => "Coupon Invalid",
                        'resval' => false,
                    ]);
                }
            }
        } else {
            return response()->json(['msg' => "Coupon Invalid", 'resval' => false]);
        }
    }

    public function apply_coupon21(Request $request) {
        date_default_timezone_set('Asia/Kolkata');
        $currTime = date('Y-m-d H:i:s'); // Get the current date and time

        // Check if user is logged in
        if (!auth()->guard('users')->check()) {
            return response()->json(['msg' => "Kindly login and try", 'resval' => false]);
        }

        // Retrieve the coupon from the database
        $coupon = Coupon::where('coupon_code', $request->coupon_code)
                        ->where('status', 'active')
                        ->first();

        if (!empty($coupon)) {

                        if ($coupon->offer_details != 1) {

            // Check if the coupon's start date is before or equal to the current time
            if ($coupon->start_date > $currTime) {
                return response()->json(['msg' => "Coupon has not started yet", 'resval' => false]);
            }

            // Check if the coupon's end date is after or equal to the current time
            if ($coupon->end_date && $coupon->end_date < $currTime) {
                return response()->json(['msg' => "Coupon has expired", 'resval' => false]);
            }
                        }
            // Check if the user has already used the coupon
            $user = auth()->guard('users')->user();
            $usedcoupon = Usedcoupon::where('coupon_code', $coupon->id)
                                    ->where('customer_id', $user ? $user->id : null)
                                    ->first();

            if ($usedcoupon) {
                return response()->json(['msg' => "Coupon already used", 'resval' => false]);
            }

            // Proceed with the coupon application logic
            $productIds = explode(',', $coupon->product_id); // Assuming product_ids are stored as comma-separated values in the DB
            if (!empty($productIds)) {
                // Get the authenticated user
                $user = auth()->guard('users')->user();

                // Check if there are products in the cart that match the coupon's product_ids
                $cartProducts = DB::table('cart_tables')
                                    ->whereIn('product_id', $productIds)
                                    ->where('customer_id', $user->id)
                                    ->get();

                if ($cartProducts->isEmpty()) {
                    return response()->json(['msg' => "Coupon Invalid for Cart Products", 'resval' => false]);
                }

                // Calculate the subtotal and total discount
                $subtotal = 0;
                $totalDiscount = 0;

                foreach ($cartProducts as $product) {
                    // If the coupon is not a percentage discount
                    if ($coupon->offer_details != 1) {
                        if (in_array($product->product_id, $productIds)) {
                            // Calculate the percentage discount
                            $productDiscount = ($product->price * $product->product_qty *  $coupon->value / 100);
                            // Add this product's discount to the total discount
                            $totalDiscount += $productDiscount;
                        }
                    } else {
                        $order_amont = $coupon->offeramountabove;
                        if($subtotal >= $order_amont){
                        $totalDiscount += $coupon->flatofferamount ;
                        }

                        // Flat discount logic (if applicable, though it doesn't apply for these products)
                        // if (in_array($product->product_id, $productIds)) {
                        //     $totalDiscount += $coupon->flatofferamount ;
                        // }
                    }
                    $subtotal += $product->price; // Add each product's price to the subtotal
                }

                // Ensure the discount does not exceed the subtotal
                $finalSubtotal = max(0, $subtotal - $totalDiscount);

                // Prepare the coupon data to store in the session
                $S_coupon = [
                    'coupon_code' => $request->coupon_code,
                    'discount'    => $totalDiscount,
                    'product_id'  => $coupon->product_id,
                    'final_subtotal' => $finalSubtotal,
                    'id'          => $coupon->id,
                ];

                // Store the coupon data in the session
                Session::put('coupon', $S_coupon);

                return response()->json([
                    'msg'        => "Coupon applied successfully",
                    'resval'     => true,
                    'coupon'     => $S_coupon,
                    'final_subtotal' => $finalSubtotal,  // Include the final subtotal after discount
                ]);
            }

            // Logic for flat discount coupon applied to entire cart (not tied to specific products)
            if ($coupon->offer_details == 1) {
                $flatcoupan = Coupon::where('coupon_code', $request->coupon_code)
                                    ->where('status', 'active')
                                    ->where('offeramountabove', '<=', $request->amount)
                                    ->first();

                if ($flatcoupan) {
                    $S_coupon = [
                        'coupon_code' => $request->coupon_code,
                        'discount'    => $flatcoupan->flatofferamount,
                        'product_id'  => $flatcoupan->product_id, // Store multiple product ids
                        'id'          => $flatcoupan->id,
                    ];

                    Session::put('coupon', $S_coupon);

                    return response()->json([
                        'msg'     => "Coupon applied successfully",
                        'resval'  => true,
                        'coupon'  => $S_coupon,
                    ]);
                } else {
                    return response()->json([
                        'msg'     => "Coupon Invalid",
                        'resval'  => false,
                    ]);
                }
            }
        } else {
            return response()->json(['msg' => "Coupon Invalid", 'resval' => false]);
        }
    }

     public function apply_coupon324(Request $request) {
        date_default_timezone_set('Asia/Kolkata');
        $currTime = date('Y-m-d H:i:s');

        // Check if user is logged in
        if (!auth()->guard('users')->check()) {
            return response()->json(['msg' => "Kindly login and try", 'resval' => false]);
        }

        // Retrieve the coupon from the database
        $coupon = Coupon::where('coupon_code', $request->coupon_code)
            ->where('status', 'active')
            ->first();

        if (!empty($coupon)) {
            $productIds = explode(',', $coupon->product_id); // Assuming product_ids are stored as comma-separated values in the DB
            if (!empty($productIds)) {
                // Get the authenticated user
                $user = auth()->guard('users')->user();

                // Check if there are products in the cart that match the coupon's product_ids
                $cartProducts = DB::table('cart_tables')
                    ->whereIn('product_id', $productIds)
                    ->where('customer_id', $user->id)
                    ->get();

                if ($cartProducts->isEmpty()) {
                    return response()->json(['msg' => "Coupon Invalid for Cart Products", 'resval' => false]);
                }

                // Calculate the subtotal and total discount
                $subtotal = 0;
                $totalDiscount = 0;

                foreach ($cartProducts as $product) {
                    // If the coupon is not a percentage discount (assuming offer_details != 1 means percentage)
                    if ($coupon->offer_details != 1) {
                        if (in_array($product->product_id, $productIds)) {
                            // Calculate the percentage discount (e.g., 2% of ₹270)
                            $productDiscount = ($product->price * $coupon->value / 100);
                            // Add this product's discount to the total discount
                            $totalDiscount += $productDiscount;
                        }
                    }
                else {
                        // Flat discount logic (if applicable, though it doesn't apply for these products)
                        if (in_array($product->product_id, $productIds)) {
                            $totalDiscount += $coupon->flatofferamount;
                        }
                    }
                    $subtotal += $product->price; // Add each product's price to the subtotal
                }

                // Ensure the discount does not exceed the subtotal
                $finalSubtotal = max(0, $subtotal - $totalDiscount);

                // Prepare the coupon data to store in the session
                $S_coupon = [
                    'coupon_code' => $request->coupon_code,
                    'discount'    => $totalDiscount,
                    'product_id'  => $coupon->product_id,
                    'final_subtotal' => $finalSubtotal,
                    'id'          => $coupon->id,
                ];

                // Store the coupon data in the session
                Session::put('coupon', $S_coupon);

                return response()->json([
                    'msg'        => "Coupon applied successfully",
                    'resval'     => true,
                    'coupon'     => $S_coupon,
                    'final_subtotal' => $finalSubtotal,  // Include the final subtotal after discount
                ]);
            }

            // Logic for flat discount coupon applied to entire cart (not tied to specific products)
            if ($coupon->offer_details == 1) {
                $flatcoupan = Coupon::where('coupon_code', $request->coupon_code)
                    ->where('status', 'active')
                    ->where('offeramountabove', '<=', $request->amount)
                    ->first();

                if ($flatcoupan) {
                    $S_coupon = [
                        'coupon_code' => $request->coupon_code,
                        'discount'    => $flatcoupan->flatofferamount,
                        'product_id'  => $flatcoupan->product_id, // Store multiple product ids
                        'id'          => $flatcoupan->id,
                    ];

                    Session::put('coupon', $S_coupon);

                    return response()->json([
                        'msg'     => "Coupon applied successfully",
                        'resval'  => true,
                        'coupon'  => $S_coupon,
                    ]);
                } else {
                    return response()->json([
                        'msg'     => "Coupon Invalid",
                        'resval'  => false,
                    ]);
                }
            }
        } else {
            return response()->json(['msg' => "Coupon Invalid", 'resval' => false]);
        }
    }

    public function remove_coupon(){
        Session::forget('coupon');
        return response()->json(["success"=>"Coupon applied successfully","resval"=>true]);
    }
    public function generateOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10'
        ]);

        // $otp = rand(100000, 999999);
        // Otp::updateOrCreate(['mobile' => $request->mobile], ['otp' => $otp]);

        //sms message
        // if($request->mobile){
        //     $key = "8cnx5PVTXSCKxjZy";
        //     $mbl = $request->mobile;
        //     $message_content = "Dear customer, use this One Time Password {#var#} to log in to your Prrayasha Collections account. This OTP will be valid for the next 5 mins -PRRCOL";
        //     $message_content = str_replace("{#var#}", $otp, $message_content);
        //     $encoded_message_content = urlencode($message_content);
        //     $senderid = "PRRCOL";
        //     $route = "1";
        //     $templateid = "1707171895464544536";

        //     $url = "https://sms.textspeed.in/vb/apikey.php?apikey=$key&senderid=$senderid&templateid=$templateid&number=$mbl&message=$encoded_message_content";

        //     $output = file_get_contents($url);
        // }
       // print_r($output);die;
        // Implement SMS sending functionality here

        return response()->json(['message' => 'OTP sent successfully.']);
    }

    public function verifyOtp(Request $request)
    {
        // Retrieve session data
        $aCartData = Session::get('cart', []);
        $swishlistData = Session::get('wishlist', []);
        $sreviewData = Session::get('product_review', []);

        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10',
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 200);
        }

        $otpRecord = Otp::where('mobile', $request->mobile)->where('otp', "123456")->first();

        // if ($otpRecord != 123456) {
        //     return response()->json(['error' => ['otp' => 'Invalid OTP']], 200);
        // }

        // Log the user in
        $user = User::firstOrCreate(['phone' => $request->mobile]);

        Session::put('users',$user['email']);
	    Auth::guard('users')->login($user);
        // Optionally, delete the OTP after verification
        // $otpRecord->delete();

        // Process session data for reviews
        if (!empty($sreviewData)) {
            foreach ($sreviewData as $key => $session) {
                $slug = Product::where('id', $session['product_id'])->first();
                $duplicate_check = DB::table('product_reviews')
                    ->where('product_id', $session['product_id'])
                    ->where('customer_id', auth()->guard('users')->user()->id)
                    ->first();
                if (empty($duplicate_check)) {
                    $session_reviews = new ProductReviews;
                    $session_reviews->customer_id = auth()->guard('users')->user()->id;
                    $session_reviews->product_id = $session['product_id'];
                    $session_reviews->rate = $session['rate'];
                    $session_reviews->review = $session['review'];
                    $session_reviews->name = $session['name'];
                    $session_reviews->phone_number = $session['phone'];
                    $session_reviews->email = $session['email'];
                    $session_reviews->save();
                } else {
                    ProductReviews::where('status', 'accept')
                        ->where('customer_id', auth()->guard('users')->user()->id)
                        ->where('product_id', $session['product_id'])
                        ->update([
                            'name' => $session['name'],
                            'review' => $session['review'],
                            'email' => $session['email'],
                            'phone_number' => $session['phone'],
                            'rate' => $session['rate']
                        ]);
                }
            }
        }

        // Process session data for wishlist
        if (!empty($swishlistData)) {
            foreach ($swishlistData as $key => $session) {
                $duplicate_check = DB::table('wishlists')
                    ->where('product_id', $session['product_id'])
                    ->where('customer_id', auth()->guard('users')->user()->id)
                    ->first();
                if (empty($duplicate_check)) {
                    $session_wishlists = new Wishlist;
                    $session_wishlists->customer_id = auth()->guard('users')->user()->id;
                    $session_wishlists->arrtibute_name = $session['arrtibute_name'];
                    $session_wishlists->product_id = $session['product_id'];
                    $session_wishlists->status = "active";
                    $session_wishlists->save();
                } else {
                    if(!empty($session['product_id'])){
                    DB::table('wishlists')
                        ->where('product_id', $session['product_id'])
                        ->where('customer_id', auth()->guard('users')->user()->id)
                        ->delete();
                    }
                }
            }
        }

        // Process session data for cart
        if (!empty($aCartData)) {
            foreach ($aCartData as $key => $session) {
                if(!empty($session['product_id'])){
                     $product = Product::where('id', $session['product_id'])->first();
                        $duplicate_check = DB::table('cart_tables')
                    ->where('product_id', $session['product_id'])
                    ->where('customer_id', auth()->guard('users')->user()->id)
                    ->where('product_varient', $key)
                    ->first();
                    if (empty($duplicate_check)) {
                        $cart_tables = new CartTable;
                        $cart_tables->product_id = $session['product_id'];
                        $cart_tables->product_name = $session['product_name'];
                        $cart_tables->product_qty = $session['product_qty'];
                        $cart_tables->price = $session['price'];
                        $cart_tables->arrtibute_name = $session['variant'];
                        $cart_tables->status = 'active';
                        $cart_tables->customer_id = auth()->guard('users')->user()->id;
                        $cart_tables->product_varient = $key;
                        $cart_tables->save();
                    } else {
                        DB::table('cart_tables')
                            ->where('product_id', $session['product_id'])
                            ->where('customer_id', auth()->guard('users')->user()->id)
                            ->update(['product_qty' => $session['product_qty']]);
                    }
                }
            }
        }

        // Clear session data and set success message
        Session::forget('product_review');
        Session::put('success', 'Successfully login');
        //return redirect()->route('index');
        // return redirect()->route('checkout1');
        /*if($aCartData){
            return redirect()->route('checkout1');
        }else{
            return redirect()->route('index');
        }*/
        return response()->json(['cartData' => $aCartData ? 1 : 0], 200);
    }

    public function guestgenerateotp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10'
        ]);

        $otp = rand(100000, 999999);
        Otp::updateOrCreate(['mobile' => $request->mobile], ['otp' => $otp]);

        //sms message
        if($request->mobile){
            $key = "8cnx5PVTXSCKxjZy";
            $mbl = $request->mobile;
            $message_content = "Dear customer, use this One Time Password {#var#} to log in to your Prrayasha Collections account. This OTP will be valid for the next 5 mins -PRRCOL";
            $message_content = str_replace("{#var#}", $otp, $message_content);
            $encoded_message_content = urlencode($message_content);
            $senderid = "PRRCOL";
            $route = "1";
            $templateid = "1707171895464544536";

            $url = "https://sms.textspeed.in/vb/apikey.php?apikey=$key&senderid=$senderid&templateid=$templateid&number=$mbl&message=$encoded_message_content";

            $output = file_get_contents($url);
        }

        // Implement SMS sending functionality here

        return response()->json(['message' => 'OTP sent successfully.']);
    }

    public function guestverifyOtp(Request $request)
    {

        // Validate request
        $validator = Validator::make($request->all(), [
            'guest_mobile' => 'required|digits:10',
            'guest_otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 200);
        }

        // Check OTP
        $otpRecord = Otp::where('mobile', $request->guest_mobile)->where('otp', $request->guest_otp)->first();

        if (!$otpRecord) {
            return response()->json(['error' => ['guest_otp' => 'Invalid OTP']], 200);
        }

        // Log the user in
        $guest = Guest::firstOrCreate(['mobile' => $request->guest_mobile]);

        Auth::guard('guest')->login($guest);

        // Optionally, delete the OTP after verification
        //$otpRecord->delete();

        // Set success message
        Session::put('success', 'Successfully logged in');
         $aCartData = Session::get('cart', []);
        // Redirect to the desired route after login
        /*if($aCartData){
            return redirect()->route('checkout1');
        }else{
            return redirect()->route('index');
        }*/
       // return redirect()->route('checkout1');
       return response()->json(['cartData' => $aCartData ? 1 : 0], 200);
    }
    public function updatereviews(Request $request)
    {

        if($request->review_customername){
            $data  = array(
                'feedback'=>$request->review_comment,
                'name'=>$request->review_customername,
                'rate'=>$request->product_rating,
                'phone_number'=>$request->phone_number,
                );
                DB::table('client_feedback')->insert($data);

        }
        Session::put('success', ' Reviews Successfully');
        return redirect()->route('reviews');

    }

    public function authregister(){
        return view('frontend.Auth.register');
    }

     public function indexnew()
{
    // var_dump(Auth::guard('users')->user()->id);
    // exit;
    $this->sessionremove();
    $banners = Banner::where('status', 'active')->orderBy('id', 'DESC')->get();
    $products = Product::where('status', 'active')->orderBy('id', 'desc')->get();
    $categories = Category::where('is_parent', 0)->where('status', 'active')->orderBy('homeorder', 'asc')->where('home', 'active')->get();
    $advertisement = Advertisement::where('status', 'active')->where('position','=','1')->first();
    $advertisement2 = Advertisement::where('status', 'active')->where('position','=','2')->first();

    $allreviews=Clientfeedback::where('status','accept')->orderBy('id','desc')->get();

    $aProductvariant_photo = array();
    $aProductSaleprice = array();
    $aDiscountpercent = array();
    $iswishlist = array();
    $ahover_image_photo = array();

    for ($i = 0; $i < count($categories); $i++) {
        $category_id = $categories[$i]['id'];
        $A_products = DB::table('products')->where('status', 'active')->whereRaw("FIND_IN_SET('$category_id',category)")->orderBy('id', 'desc')->limit(8)->get();

        foreach ($A_products as $key => $product) {
            $variant = ProductVariant::where('product_id', $product->id)->where('status', 'active')->first();

            // Ensure $variant is not null
            if ($variant !== null) {
                $category = Category::where('is_parent', 0)->where('status', 'active')->whereIn('id', explode(',', $product->category))->where('home', 'active')->first();
                if ($product->discount_type == "fixed") {
                    if ($variant->regular_price != 0) {
                        array_push($aDiscountpercent, ($product->discount / $variant->regular_price) * 100);
                    } else {
                        array_push($aDiscountpercent, 0);
                    }
                } else {
                    array_push($aDiscountpercent, $product->discount);
                }

                $saleprice = $this->fetchSalePrice($variant->regular_price, $product->tax_id, $product->discount, $product->discount_type);
                $A_prodimg = explode(',', $variant->photo);
                array_push($aProductvariant_photo, $A_prodimg[0]);

                if (count($A_prodimg) > 1) {
                    array_push($ahover_image_photo, $A_prodimg[1]);
                } else {
                    array_push($ahover_image_photo, $A_prodimg[0]);
                }
                array_push($aProductSaleprice, $saleprice['sale_price']);

                if (auth()->guard('users')->user()) {
                    $wishlist = Wishlist::where('product_id', $product->id)->where('customer_id', auth()->guard('users')->user()->id)->first();
                    if (isset($wishlist)) {
                        array_push($iswishlist, 'yes');
                    } else {
                        array_push($iswishlist, 'no');
                    }
                }
            }
        }
    }

    return view('frontend.indexnew', compact('allreviews','banners', 'ahover_image_photo', 'aDiscountpercent', 'advertisement','advertisement2', 'iswishlist', 'categories', 'products', 'aProductvariant_photo', 'aProductSaleprice'));
}
   public function fetchSubcategories(Request $request,$id)

{
    $category_name = DB::table('categories')
    ->select('title')
            ->where('id', $id)
            ->first();
            $subcategories = DB::table('categories')
            ->where('is_parent', 1)
            ->where('parent_id', $id)
            ->where('header', 'active')
            ->where('status', 'active')
            ->get();

        return response()->json(['category'=>$category_name,'sub_category'=>$subcategories]);
    }
}

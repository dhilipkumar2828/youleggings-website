<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Clientfeedback;
use App\Models\ProductReviews;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
    public function index()
    {
        $banners = Banner::where('status', 'active')->get();
        $categories = Category::where('status', 'active')->whereNull('parent_id')->get();
        $featured_products = Product::with('productvariant')->where('status', 'active')->take(8)->get();
        
        // Fetch only active testimonials
        $testimonials = Clientfeedback::where('status', 'accept')->orderBy('id', 'desc')->get();
        
        return view('frontend.index', compact('banners', 'categories', 'featured_products', 'testimonials'));
    }

    public function wishlist()
    {
        if(!Auth::check()) {
            return redirect()->route('login_user')->with('error', 'Please login to view your wishlist');
        }
        $wishlist = Wishlist::where('customer_id', Auth::id())->with('wishlist1')->get();
        return view('frontend.wishlist', compact('wishlist'));
    }

    public function wishlist_add(Request $request)
    {
        if(!Auth::check()) {
            return response()->json(['status' => 'error', 'msg' => 'Please login first']);
        }
        
        $exists = Wishlist::where('customer_id', Auth::id())->where('product_id', $request->product_id)->first();
        if($exists) {
            return response()->json(['status' => 'info', 'msg' => 'Already in wishlist']);
        }

        Wishlist::create([
            'customer_id' => Auth::id(),
            'product_id' => $request->product_id,
        ]);

        return response()->json(['status' => 'success', 'msg' => 'Added to wishlist']);
    }

    public function wishlist_remove(Request $request)
    {
        Wishlist::where('customer_id', Auth::id())->where('product_id', $request->product_id)->delete();
        return back()->with('success', 'Removed from wishlist');
    }

    public function shop(Request $request)
    {
        $query = Product::with('productvariant')->where('status', 'active');

        if ($request->has('category')) {
            $query->whereIn('category', (array)$request->category);
        }

        if ($request->has('max_price')) {
            $query->where('regular_price', '<=', $request->max_price);
        }
        
        if ($request->has('availability')) {
            $avail = (array)$request->availability;
            if (in_array('in_stock', $avail) && !in_array('out_of_stock', $avail)) {
                $query->where('stock', '>', 0);
            } elseif (in_array('out_of_stock', $avail) && !in_array('in_stock', $avail)) {
                $query->where('stock', '<=', 0);
            }
            // If both are checked, no additional filter needed (shows all)
        }

        if ($request->has('size')) {
            $sizes = (array)$request->size;
            $query->whereHas('productvariant', function($q) use ($sizes) {
                $q->where(function($sq) use ($sizes) {
                    foreach ($sizes as $size) {
                        $sq->orWhere('variants', 'LIKE', $size . '%');
                    }
                });
            });
        }

        if ($request->has('sort')) {
            if ($request->sort === 'price') {
                $query->orderBy('regular_price', 'asc');
            } elseif ($request->sort === 'discount') {
                $query->orderByRaw('CAST(discount AS UNSIGNED) DESC');
            }
        }

        if ($request->has('new-arrivals')) {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);
        $categories = Category::where('status', 'active')->whereNull('parent_id')->get();
        $all_sizes = \App\Models\Attribute::where('attribute_type', 'Size')->first()->value ?? [];

        return view('frontend.shop', compact('products', 'categories', 'all_sizes'));
    }

    public function product_detail($slug)
    {
        $product = Product::with(['productvariant', 'categories', 'reviews'])->where('slug', $slug)->firstOrFail();
        
        $related_products = Product::with('productvariant')
            ->where('status', 'active')
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        // Fetch all possible sizes and colors to aid parsing
        $all_sizes = \App\Models\Attribute::where('attribute_type', 'Size')->first()->value ?? [];
        $all_colors = \App\Models\Attribute::where('attribute_type', 'Color')->first()->value ?? [];

        $grouped_variants = [];
        foreach ($product->productvariant as $variant) {
            $foundSize = '';
            $foundColor = '';
            
            // Try to separate size and color from $variant->variants e.g. "SRed"
            foreach ($all_sizes as $size) {
                if (str_starts_with($variant->variants, $size)) {
                    $foundSize = $size;
                    $colorPart = substr($variant->variants, strlen($size));
                    // Check if the color part matches any color in our list
                    foreach($all_colors as $color) {
                        if (strtolower($colorPart) == strtolower($color)) {
                            $foundColor = $color;
                            break;
                        }
                    }
                    if ($foundColor) break;
                }
            }

            // Fallback if parsing failed
            if (!$foundSize || !$foundColor) {
               // If combined string fails, check if we can find color from the end
               foreach($all_colors as $color) {
                   if (str_ends_with($variant->variants, $color)) {
                       $foundColor = $color;
                       $foundSize = substr($variant->variants, 0, -strlen($color));
                       break;
                   }
               }
            }

            if ($foundSize && $foundColor) {
                $grouped_variants[$foundSize][$foundColor] = [
                    'id' => $variant->id,
                    'price' => $variant->regular_price,
                    'sku' => $variant->sku,
                    'photos' => array_filter(explode(',', $variant->photo))
                ];
            }
        }

        return view('frontend.product_detail', compact('product', 'related_products', 'grouped_variants'));
    }

    public function about()
    {
        $about = \App\Models\About::first();
        return view('frontend.about', compact('about'));
    }

    public function contact()
    {
        $contact = \App\Models\Contact::first();
        return view('frontend.contact', compact('contact'));
    }

    public function contact_submit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        \App\Models\Contactform::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone ?? '',
            'message' => $request->message . ($request->subject ? "\nSubject: " . $request->subject : ""),
        ]);

        return back()->with('success', 'Thanks for contacting us! We will get back to you soon.');
    }

    public function blog()
    {
        $blogs = Blog::where('status', 1)->orderBy('publish_at', 'desc')->paginate(6);
        $featured_blog = Blog::where('status', 1)->orderBy('publish_at', 'desc')->first();
        $most_read = Blog::where('status', 1)->orderBy('publish_at', 'desc')->take(6)->get();
        $heading = DB::table('headings')->where('type', 'blogs')->where('status', 'active')->first();
        return view('frontend.blog', compact('blogs', 'featured_blog', 'most_read', 'heading'));
    }

    public function blog_detail($slug)
    {
        $blog = Blog::where('slug', $slug)->where('status', 1)->firstOrFail();
        $recent_blogs = Blog::where('status', 1)->where('id', '!=', $blog->id)->orderBy('id', 'desc')->take(3)->get();
        return view('frontend.blog_detail', compact('blog', 'recent_blogs'));
    }

    public function cart()
    {
        return view('frontend.cart');
    }

    public function checkout()
    {
        return view('frontend.checkout');
    }

    public function checkout_store(Request $request)
    {
        $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'email'          => 'required|email',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string',
            'city'           => 'required|string',
            'state'          => 'required|string',
            'pincode'        => 'required|string',
            'payment_method' => 'required|in:cod,razorpay,online',
            'cart_items'     => 'required|string', // JSON from JS
            'coupon_code'    => 'nullable|string',
            'discount_amount'=> 'nullable|numeric',
        ]);

        $cartItems = json_decode($request->cart_items, true);
        if (empty($cartItems)) {
            return back()->with('error', 'Your cart is empty!');
        }

        // Calculate totals
        $subTotal = 0;
        foreach ($cartItems as $item) {
            $subTotal += ($item['price'] * $item['qty']);
        }
        $shipping = $subTotal > 1499 ? 0 : 99;
        $discount = $request->discount_amount ?? 0;
        $total    = ($subTotal + $shipping) - $discount;

        // Build shipping address string
        $shippingAddress = $request->address . ', ' . $request->city . ', ' . $request->state . ' - ' . $request->pincode . ', ' . ($request->country ?? 'India');

        // Generate unique order ID
        $orderId = 'YL' . strtoupper(substr(uniqid(), -8)) . rand(10, 99);

        // Save to orders table
        $order = \App\Models\Order::create([
            'order_id'       => $orderId,
            'customer_id'    => \Auth::id() ?? null,
            'sub_total'      => $subTotal,
            'deliver_charge' => $shipping,
            'total'          => $total,
            'discound_amount'=> $discount,
            'tax_rate'       => 0,
            'gst'            => 0,
            'payment_type'   => $request->payment_method,
            'payment_status' => ($request->payment_method === 'cod') ? 'pending' : 'pending',
            'status'         => 'Pending',
        ]);

        // Save customer info to users table address fields if logged in
        if (\Auth::check()) {
            \Auth::user()->update([
                'address'  => $request->address,
                'city'     => $request->city,
                'state'    => $request->state,
                'postcode' => $request->pincode,
                'phone'    => $request->phone,
            ]);
        }

        // Save order_products
        foreach ($cartItems as $item) {
            \App\Models\OrderProduct::create([
                'order_id'   => $order->id,
                'product_id' => $item['product_id'] ?? 0,
                'quantity'   => $item['qty'],
                'amount'     => $item['price'],
                'option'     => json_encode([
                    'name'    => $item['name']    ?? '',
                    'variant' => $item['variant'] ?? '',
                    'image'   => $item['image']   ?? '',
                ]),
                'status'     => 'active',
                'tax_rate'   => 0,
                'total_tax'  => 0,
            ]);

            // Reduce stock
            if (!empty($item['product_id'])) {
                \App\Models\Product::where('id', $item['product_id'])->decrement('stock', $item['qty']);
            }
        }

        // Store order details in session for thank you page
        \Session::put('last_order', [
            'order_id'   => $orderId,
            'total'      => $total,
            'name'       => $request->first_name . ' ' . $request->last_name,
            'email'      => $request->email,
            'address'    => $shippingAddress,
            'payment'    => $request->payment_method,
            'items_count'=> count($cartItems),
        ]);

        return redirect()->route('thank_you');
    }


    public function thank_you()
    {
        return view('frontend.thank_you');
    }

    public function my_orders()
    {
        if (!Auth::check()) {
            return redirect()->route('login_user')->with('error', 'Please login to view your orders.');
        }

        $orders = \App\Models\Order::where('customer_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.my_orders', compact('orders'));
    }

    public function my_account()
    {
        if (!Auth::check()) {
            return redirect()->route('login_user')->with('error', 'Please login to view your account.');
        }

        $user = Auth::user();
        $orders = \App\Models\Order::where('customer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $wishlist_count = \App\Models\Wishlist::where('customer_id', $user->id)->count();
        
        return view('frontend.my_account', compact('orders', 'wishlist_count'));
    }

    public function order_invoice($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login_user');
        }

        $order = \App\Models\Order::where('id', $id)->where('customer_id', Auth::id())->firstOrFail();
        $data = \App\Models\OrderProduct::where('order_id', $id)->get();
        
        $product_name = [];
        foreach($data as $item) {
            $option = json_decode($item->option, true);
            $product_name[] = $option['name'] ?? 'Product';
        }
        
        $user = Auth::user();
        $delivery_charge = ($order->deliver_charge == '' || $order->deliver_charge == 'NULL') ? 0.00 : $order->deliver_charge;

        return view('frontend.order_invoice', compact('order', 'data', 'product_name', 'user', 'delivery_charge'));
    }

    public function account_update(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login_user');
        }

        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string',
            'city'     => 'nullable|string',
            'state'    => 'nullable|string',
            'postcode' => 'nullable|string',
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name'     => $request->name,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'city'     => $request->city,
            'state'    => $request->state,
            'postcode' => $request->postcode,
        ];

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        \App\Models\User::where('id', $user->id)->update($data);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function apply_coupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
            'subtotal'    => 'required|numeric',
        ]);

        $coupon = \App\Models\Coupon::where('coupon_code', $request->coupon_code)
            ->where('Status', 'active')
            ->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid or inactive coupon code.']);
        }

        // Check dates
        $now = \Carbon\Carbon::now();
        if (($coupon->start_date && $now->lt($coupon->start_date)) || ($coupon->end_date && $now->gt($coupon->end_date))) {
            return response()->json(['success' => false, 'message' => 'This coupon is not valid at this time.']);
        }

        // Check minimum order amount
        if ($request->subtotal < $coupon->minimum_order_amount) {
            return response()->json(['success' => false, 'message' => 'Minimum order amount for this coupon is ₹' . $coupon->minimum_order_amount]);
        }

        $discount = $coupon->discount($request->subtotal);

        return response()->json([
            'success' => true,
            'message'  => 'Coupon applied successfully!',
            'discount' => round($discount, 2),
            'coupon_code' => $coupon->coupon_code
        ]);
    }



    public function login_user()
    {
        return view('frontend.login');
    }

    public function customer_login(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (\Illuminate\Support\Facades\Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('index')->with('success', 'Logged in successfully!');
        }

        return back()->with('error', 'Invalid email or password.')->withInput();
    }

    public function customer_register(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'nullable|string',
            'password' => 'required|string|min:6',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'customer'
        ]);

        \Illuminate\Support\Facades\Auth::login($user);

        return redirect()->route('index')->with('success', 'Account created successfully!');
    }

    public function privacy_policy()
    {
        $content = \App\Models\Privacy::first();
        return view('frontend.privacy_policy', compact('content'));
    }

    public function terms_conditions()
    {
        $content = \App\Models\Terms::first();
        return view('frontend.terms_conditions', compact('content'));
    }

    public function shipping_policy()
    {
        $content = \App\Models\Delivery::first();
        return view('frontend.shipping_policy', compact('content'));
    }

    public function review_submit(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name'       => 'required|string|max:100',
            'email'      => 'required|email|max:100',
            'rate'       => 'required|integer|min:1|max:5',
            'review'     => 'required|string|max:1000',
        ]);

        \App\Models\ProductReviews::create([
            'product_id'  => $request->product_id,
            'customer_id' => Auth::id() ?? null,
            'name'        => $request->name,
            'email'       => $request->email,
            'rate'        => $request->rate,
            'review'      => $request->review,
            'status'      => 'inactive', // Moderation needed
        ]);

        return back()->with('success', 'Thank you for your review! It will be visible after approval.');
    }
}

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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

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
        $wishlist = Wishlist::where('customer_id', Auth::id())
            ->with('wishlist1')
            ->get()
            ->filter(function($item) {
                return $item->wishlist1 !== null;
            });
            
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
        if(!Auth::check()) {
            return response()->json(['status' => 'error', 'msg' => 'Please login first']);
        }
        Wishlist::where('customer_id', Auth::id())->where('product_id', $request->product_id)->delete();
        
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 'success', 'msg' => 'Removed from wishlist']);
        }
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

        if ($request->has('q') && !empty($request->q)) {
            $query->where('name', 'LIKE', '%' . $request->q . '%');
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

        // Fetch all possible sizes and colors from ALL attribute rows
        $all_sizes = \App\Models\Attribute::where('attribute_type', 'Size')->get()->pluck('value')->flatten()->filter()->unique()->toArray();
        $all_colors = \App\Models\Attribute::where('attribute_type', 'Color')->get()->pluck('value')->flatten()->filter()->unique()->toArray();

        $grouped_variants = [];
        $colorHexMap = []; 

        // Pre-parse colors to build a hex map
        foreach ($all_colors as $c) {
            $c = trim($c);
            if (strpos($c, ':') !== false) {
                $parts = explode(':', $c);
                $colorHexMap[trim($parts[0])] = trim($parts[1]);
            }
        }

        // Sort sizes by length descending
        usort($all_sizes, function($a, $b) {
            return strlen($b) - strlen($a);
        });

        foreach ($product->productvariant as $variant) {
            $rawVariant = trim($variant->variants);
            if (empty($rawVariant)) continue;

            $foundSize = '';
            $foundColor = '';
            
            // 1. Find Size
            foreach ($all_sizes as $size) {
                // Check if starts with size (case insensitive, ignoring spaces/commas)
                $pattern = '/^' . preg_quote($size, '/') . '[\s,_\-\/]*/i';
                if (preg_match($pattern, $rawVariant)) {
                    $foundSize = $size;
                    $remaining = trim(preg_replace($pattern, '', $rawVariant));
                    
                    if ($remaining) {
                        // 2. Identify Color from known list if it exists inside the remaining string
                        foreach($all_colors as $color) {
                            $cleanColorName = strpos($color, ':') !== false ? explode(':', $color)[0] : $color;
                            $cleanColorName = trim($cleanColorName);
                            if (stripos($remaining, $cleanColorName) !== false) {
                                $foundColor = $cleanColorName;
                                break;
                            }
                        }
                        // If no known color, use the whole remaining part
                        if (!$foundColor) $foundColor = $remaining;
                    }
                    break;
                }
            }

            // 2. Fallback: Identify color from the known list anywhere in the string
            if (!$foundColor) {
                foreach($all_colors as $color) {
                    $cleanColorName = strpos($color, ':') !== false ? explode(':', $color)[0] : $color;
                    $cleanColorName = trim($cleanColorName);
                    if (stripos($rawVariant, $cleanColorName) !== false) {
                        $foundColor = $cleanColorName;
                        // Best guess for size is what's left
                        if (!$foundSize) {
                            $foundSize = trim(str_ireplace($cleanColorName, '', $rawVariant));
                            $foundSize = trim(str_replace([',', '/', '-', '_', '(', ')'], ' ', $foundSize));
                        }
                        break;
                    }
                }
            }

            // 3. Last resort fallbacks
            if (!$foundSize) $foundSize = 'Standard';
            if (!$foundColor) $foundColor = $rawVariant;

            // Clean up the names for display
            $foundColor = trim(str_replace(['(', ')', '_', '-'], ' ', $foundColor));
            $foundColor = ucwords(strtolower($foundColor));

            $regularPrice = $variant->regular_price;
            $salePrice = $regularPrice;

            if ($product->discount > 0) {
                if ($product->discount_type == 'fixed') {
                    $salePrice = max(0, $regularPrice - $product->discount);
                } elseif ($product->discount_type == 'percentage') {
                    $salePrice = max(0, $regularPrice - ($regularPrice * ($product->discount / 100)));
                }
            }

            $photos = !empty($variant->photo) ? array_filter(preg_split('/[\s,;]+/', $variant->photo)) : [];
            $firstPhoto = !empty($photos) ? image_url($photos[0]) : null;

            $grouped_variants[$foundSize][$foundColor] = [
                'id' => $variant->id,
                'price' => $regularPrice,
                'sale_price' => $salePrice,
                'sku' => $variant->sku,
                'photos' => $photos,
                'first_photo' => $firstPhoto
            ];
        }

        return view('frontend.product_detail', compact('product', 'related_products', 'grouped_variants', 'colorHexMap'));
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
        $addresses = [];
        if (\Auth::check()) {
            $addresses = \DB::table('shipping_address')
                ->where('customer_id', \Auth::id())
                ->select('sfirst_name', 'slast_name', 'semail', 'sphone_number', 'saddress', 'scity', 'sstate', 'spincode')
                ->distinct()
                ->get();
        }
        return view('frontend.checkout', compact('addresses'));
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
        // Calculate shipping dynamically
        $shipping = 0;
        $state = strtolower($request->state);
        $shipping_data = DB::table('shippingcharges')
            ->where('from', '<=', $subTotal)
            ->where('to', '>=', $subTotal)
            ->first();

        if ($shipping_data) {
            $tn_states = ['tamil nadu', 'tamilnadu', 'tn', 'pondicherry', 'puducherry', 'puducheri', 'py'];
            if (in_array($state, $tn_states)) {
                $shipping = $shipping_data->amount - $shipping_data->dis_amount;
            } else {
                $shipping = $shipping_data->amount1 - $shipping_data->dis_amount1;
            }
        }
        $shipping = max(0, $shipping);

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
            'payment_type'   => $request->payment_method ?? 'cod',
            'payment_status' => (strtolower($request->payment_method) == 'cod') ? 'Unpaid' : 'Pending',
            'status'         => 'Pending',
        ]);

        // Save customer info to users table address fields if logged in
        if (Auth::check()) {
            Auth::user()->update([
                'address'  => $request->address,
                'city'     => $request->city,
                'state'    => $request->state,
                'postcode' => $request->pincode,
                'phone'    => $request->phone,
            ]);

            // Save to shipping_address table as well
            DB::table('shipping_address')->insert([
                'customer_id'   => Auth::id(),
                'order_id'      => $orderId,
                'sfirst_name'   => $request->first_name,
                'slast_name'    => $request->last_name,
                'semail'        => $request->email,
                'sphone_number' => $request->phone,
                'saddress'      => $request->address,
                'scity'         => $request->city,
                'sstate'        => $request->state,
                'spincode'      => $request->pincode,
                'created_at'    => now(),
                'updated_at'    => now(),
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

        \Session::flash('order_success', true);

        return redirect()->route('my_orders')->with('success', 'Order placed successfully!');
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

    public function my_addresses()
    {
        if (!Auth::check()) {
            return redirect()->route('login_user');
        }

        $addresses = DB::table('shipping_address')
            ->where('customer_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return view('frontend.my_addresses', compact('addresses'));
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

    public function get_shipping_charge(Request $request)
    {
        $state = strtolower($request->state);
        $subtotal = $request->subtotal;

        $shipping_data = DB::table('shippingcharges')
            ->where('from', '<=', $subtotal)
            ->where('to', '>=', $subtotal)
            ->first();

        if (!$shipping_data) {
            return response()->json(['shipping' => 0]);
        }

        $tn_states = ['tamil nadu', 'tamilnadu', 'tn', 'pondicherry', 'puducherry', 'puducheri', 'py'];
        
        if (in_array($state, $tn_states)) {
            $shipping = $shipping_data->amount - $shipping_data->dis_amount;
        } else {
            $shipping = $shipping_data->amount1 - $shipping_data->dis_amount1;
        }

        return response()->json(['shipping' => max(0, $shipping)]);
    }

    public function address_set_default($id)
    {
        if (!Auth::check()) return redirect()->route('login_user');

        // Reset all defaults for this user
        \DB::table('shipping_address')
            ->where('customer_id', Auth::id())
            ->update(['is_default' => 0]);

        // Set new default
        \DB::table('shipping_address')
            ->where('customer_id', Auth::id())
            ->where('id', $id)
            ->update(['is_default' => 1]);

        return back()->with('success', 'Default address updated!');
    }

    public function address_delete($id)
    {
        if (!Auth::check()) return redirect()->route('login_user');

        \DB::table('shipping_address')
            ->where('customer_id', Auth::id())
            ->where('id', $id)
            ->delete();

        return back()->with('success', 'Address deleted successfully!');
    }

    public function address_store(Request $request)
    {
        if (!Auth::check()) return redirect()->route('login_user');

        $request->validate([
            'sfirst_name'   => 'required|string|max:255',
            'slast_name'    => 'required|string|max:255',
            'semail'        => 'required|email|max:255',
            'sphone_number' => 'required|string|max:20',
            'saddress'      => 'required|string',
            'scity'         => 'required|string|max:100',
            'sstate'        => 'required|string|max:100',
            'spincode'      => 'required|string|max:10',
        ]);

        // Unset old defaults
        \DB::table('shipping_address')
            ->where('customer_id', Auth::id())
            ->update(['is_default' => 0]);

        \DB::table('shipping_address')->insert([
            'customer_id'   => Auth::id(),
            'sfirst_name'   => $request->sfirst_name,
            'slast_name'    => $request->slast_name,
            'semail'        => $request->semail,
            'sphone_number' => $request->sphone_number,
            'saddress'      => $request->saddress,
            'scity'         => $request->scity,
            'sstate'        => $request->sstate,
            'spincode'      => $request->spincode,
            'is_default'    => 1,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return back()->with('success', 'New address added successfully!');
    }

    public function address_update(Request $request)
    {
        if (!Auth::check()) return redirect()->route('login_user');

        $request->validate([
            'address_id'    => 'required|exists:shipping_address,id',
            'sfirst_name'   => 'required|string|max:255',
            'slast_name'    => 'required|string|max:255',
            'semail'        => 'required|email|max:255',
            'sphone_number' => 'required|string|max:20',
            'saddress'      => 'required|string',
            'scity'         => 'required|string|max:100',
            'sstate'        => 'required|string|max:100',
            'spincode'      => 'required|string|max:10',
        ]);

        \DB::table('shipping_address')
            ->where('customer_id', Auth::id())
            ->where('id', $request->address_id)
            ->update([
                'sfirst_name'   => $request->sfirst_name,
                'slast_name'    => $request->slast_name,
                'semail'        => $request->semail,
                'sphone_number' => $request->sphone_number,
                'saddress'      => $request->saddress,
                'scity'         => $request->scity,
                'sstate'        => $request->sstate,
                'spincode'      => $request->spincode,
                'updated_at'    => now(),
            ]);

        return back()->with('success', 'Address updated successfully!');
    }
}

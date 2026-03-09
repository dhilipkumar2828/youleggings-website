<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Clientfeedback;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $banners = Banner::where('status', 'active')->get();
        $categories = Category::where('status', 'active')->whereNull('parent_id')->get();
        $featured_products = Product::with('productvariant')->where('status', 'active')->take(8)->get();
        $testimonials = Clientfeedback::where('status', 'active')->get();
        
        return view('frontend.index', compact('banners', 'categories', 'featured_products', 'testimonials'));
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
        $blogs = Blog::where('status', 1)->orderBy('id', 'desc')->paginate(6);
        return view('frontend.blog', compact('blogs'));
    }

    public function cart()
    {
        return view('frontend.cart');
    }

    public function login_user()
    {
        return view('frontend.login');
    }
}

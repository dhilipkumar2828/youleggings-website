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
        $banners = Banner::where('status', 1)->get();
        $categories = Category::where('status', 1)->take(4)->get();
        $featured_products = Product::with('productvariant')->where('status', 'active')->take(4)->get();
        $testimonials = Clientfeedback::where('status', 'active')->get();
        
        return view('frontend.index', compact('banners', 'categories', 'featured_products', 'testimonials'));
    }

    public function shop(Request $request)
    {
        $query = Product::with('productvariant')->where('status', 'active');

        if ($request->has('category')) {
            $query->whereIn('category', (array)$request->category);
        }

        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('regular_price', [$request->min_price, $request->max_price]);
        }

        $products = $query->paginate(12);
        $categories = Category::where('status', 'active')->get();

        return view('frontend.shop', compact('products', 'categories'));
    }

    public function product_detail($slug)
    {
        $product = Product::with(['productvariant', 'categories'])->where('slug', $slug)->firstOrFail();
        $related_products = Product::with('productvariant')
            ->where('status', 'active')
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('frontend.product_detail', compact('product', 'related_products'));
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

    public function blog()
    {
        $blogs = Blog::where('status', 1)->orderBy('id', 'desc')->paginate(6);
        return view('frontend.blog', compact('blogs'));
    }
}

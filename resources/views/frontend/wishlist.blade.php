@extends('frontend.layouts.app')

@section('title', 'My Wishlist | You Leggings')

@section('styles')
<style>
    .wishlist-page { padding: 80px 0; background: #fffafc; min-height: 600px; }
    .wishlist-header { margin-bottom: 50px; text-align: center; }
    .wishlist-title { font-family: serif; font-size: 2.5rem; color: #333; margin-bottom: 10px; }
    
    .wishlist-table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    .wishlist-table th { background: #fdeef2; padding: 20px; text-align: left; color: #ec407a; font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: 1px; }
    .wishlist-table td { padding: 20px; border-bottom: 1px solid #f9f9f9; vertical-align: middle; }
    
    .wishlist-item-img { width: 80px; height: 100px; object-fit: cover; border-radius: 8px; }
    .wishlist-item-name { font-weight: 600; color: #333; text-decoration: none; font-size: 16px; transition: 0.3s; }
    .wishlist-item-name:hover { color: #ec407a; }
    
    .price-tag { font-weight: 700; color: #ec407a; font-size: 18px; }
    
    .remove-btn { color: #ff4d4d; border: none; background: none; cursor: pointer; display: flex; align-items: center; gap: 5px; font-size: 13px; font-weight: 600; transition: 0.3s; }
    .remove-btn:hover { color: #cc0000; transform: scale(1.05); }
    
    .add-to-cart-btn { background: #222; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-size: 13px; font-weight: 600; text-transform: uppercase; transition: 0.3s; display: inline-block; }
    .add-to-cart-btn:hover { background: #ec407a; box-shadow: 0 5px 15px rgba(236, 64, 122, 0.3); }
    
    .empty-wishlist { text-align: center; padding: 60px; }
    .empty-wishlist i { font-size: 60px; color: #fdeef2; margin-bottom: 20px; display: block; }
    .empty-wishlist h3 { font-size: 24px; color: #555; margin-bottom: 20px; }
</style>
@endsection

@section('content')
<div class="wishlist-page">
    <div class="container">
        <div class="wishlist-header">
            <h1 class="wishlist-title">My Wishlist</h1>
            <p style="color: #888;">Your curated collection of premium comfort</p>
        </div>

        @if($wishlist->isNotEmpty())
            <table class="wishlist-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Stock Status</th>
                        <th>Action</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($wishlist as $item)
                        @php
                            $product = $item->wishlist1;
                            $photo = $product->productvariant->first()->photo ?? '';
                            $photos = $photo ? explode(',', $photo) : [asset('frontend/images/Products/_DSC8742-Edit.jpg')];
                        @endphp
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 20px;">
                                    <img src="{{ image_url($photos[0]) }}" alt="{{ $product->name }}" class="wishlist-item-img">
                                    <a href="{{ route('product_detail', $product->slug) }}" class="wishlist-item-name">{{ $product->name }}</a>
                                </div>
                            </td>
                            <td>
                                <span class="price-tag">₹{{ number_format($product->selling_price ?? $product->regular_price) }}</span>
                            </td>
                            <td>
                                <span style="color: #28a745; font-weight: 600; font-size: 13px;">In Stock</span>
                            </td>
                            <td>
                                <a href="{{ route('product_detail', $product->slug) }}" class="add-to-cart-btn">Select Options</a>
                            </td>
                            <td>
                                <form action="{{ route('wishlist.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="remove-btn">
                                        <i data-lucide="trash-2" style="width: 16px;"></i> Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-wishlist">
                <i data-lucide="heart"></i>
                <h3>Your wishlist is empty</h3>
                <p style="color: #888; margin-bottom: 30px;">Save your favorite pieces here to easily find them later.</p>
                <a href="{{ route('shop') }}" class="btn" style="background: #ec407a; color: #fff; padding: 15px 40px; border-radius: 5px; text-transform: uppercase; font-weight: 700;">Continue Shopping</a>
            </div>
        @endif
    </div>
</div>
@endsection

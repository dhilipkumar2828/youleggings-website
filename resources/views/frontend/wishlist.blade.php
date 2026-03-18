@extends('frontend.layouts.app')

@section('title', 'My Wishlist | You Leggings')

@section('styles')
<style>
    * {
        box-sizing: border-box;
    }

    :root {
        --primary-color: #ec407a;
        --primary-dark: #d81b60;
        --text-dark: #333;
        --text-muted: #888;
        --border-light: #f9f9f9;
        --bg-soft: #fffafc;
        --shadow-light: 0 2px 8px rgba(0,0,0,0.06);
        --shadow-medium: 0 10px 30px rgba(0,0,0,0.05);
        --transition: all 0.3s ease;
    }

    .wishlist-page { 
        padding: 60px 15px; 
        background: var(--bg-soft); 
        min-height: 600px; 
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        width: 100%;
    }

    .wishlist-header { 
        margin-bottom: 40px; 
        text-align: center; 
    }

    .wishlist-title { 
        font-family: serif; 
        font-size: 1.8rem; 
        color: var(--text-dark); 
        margin-bottom: 10px; 
    }

    .wishlist-header p {
        color: var(--text-muted);
        font-size: 14px;
    }

    /* ========== DESKTOP TABLE VIEW (980px+) ========== */
    .wishlist-table { 
        display: table;
        width: 100%; 
        border-collapse: collapse; 
        background: #fff; 
        border-radius: 15px; 
        overflow: hidden; 
        box-shadow: var(--shadow-medium);
    }

    .wishlist-table th { 
        background: #fdeef2; 
        padding: 20px; 
        text-align: left; 
        color: var(--primary-color); 
        font-weight: 700; 
        text-transform: uppercase; 
        font-size: 13px; 
        letter-spacing: 1px; 
    }

    .wishlist-table td { 
        padding: 20px; 
        border-bottom: 1px solid var(--border-light); 
        vertical-align: middle; 
    }

    .wishlist-table tbody tr:hover {
        background: #fafafa;
        transition: var(--transition);
    }

    .wishlist-item-img { 
        width: 80px; 
        height: 100px; 
        object-fit: cover; 
        border-radius: 8px; 
    }

    .wishlist-item-info {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .wishlist-item-name { 
        font-weight: 600; 
        color: var(--text-dark); 
        text-decoration: none; 
        font-size: 16px; 
        transition: var(--transition);
        display: block;
    }

    .wishlist-item-name:hover { 
        color: var(--primary-color); 
    }

    .price-tag { 
        font-weight: 700; 
        color: var(--primary-color); 
        font-size: 18px; 
    }

    .remove-btn { 
        color: #ff4d4d; 
        border: none; 
        background: none; 
        cursor: pointer; 
        display: flex; 
        align-items: center; 
        gap: 5px; 
        font-size: 13px; 
        font-weight: 600; 
        transition: var(--transition);
        padding: 0;
    }

    .remove-btn:hover { 
        color: #cc0000; 
        transform: scale(1.05); 
    }

    .add-to-cart-btn { 
        background: #222; 
        color: #fff; 
        padding: 10px 20px; 
        border-radius: 5px; 
        text-decoration: none; 
        font-size: 13px; 
        font-weight: 600; 
        text-transform: uppercase; 
        transition: var(--transition); 
        display: inline-block; 
        border: none;
        cursor: pointer;
    }

    .add-to-cart-btn:hover { 
        background: var(--primary-color); 
        box-shadow: 0 5px 15px rgba(236, 64, 122, 0.3); 
    }

    .empty-wishlist { 
        text-align: center; 
        padding: 60px 20px; 
    }

    .empty-wishlist svg { 
        margin-bottom: 20px; 
    }

    .empty-wishlist h3 { 
        font-size: 24px; 
        color: #555; 
        margin-bottom: 20px; 
    }

    .empty-wishlist p {
        color: var(--text-muted);
        margin-bottom: 30px;
    }

    /* ========== MOBILE CARD VIEW (Below 980px) ========== */
    .wishlist-cards-container {
        display: none;
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .wishlist-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: var(--shadow-light);
        transition: var(--transition);
    }

    .wishlist-card:hover {
        box-shadow: var(--shadow-medium);
        transform: translateY(-2px);
    }

    .card-header {
        display: flex;
        gap: 15px;
        padding: 15px;
        border-bottom: 1px solid var(--border-light);
    }

    .card-image {
        width: 70px;
        height: 90px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .card-title {
        flex: 1;
    }

    .card-title a {
        font-weight: 600;
        color: var(--text-dark);
        text-decoration: none;
        display: block;
        font-size: 15px;
        line-height: 1.4;
        margin-bottom: 8px;
        transition: var(--transition);
    }

    .card-title a:hover {
        color: var(--primary-color);
    }

    .card-price {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 16px;
    }

    .card-status {
        color: #28a745;
        font-weight: 600;
        font-size: 12px;
    }

    .card-body {
        padding: 15px;
    }

    .card-actions {
        display: flex;
        gap: 10px;
    }

    .card-action-btn {
        flex: 1;
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-add-to-cart {
        background: #222;
        color: #fff;
    }

    .btn-add-to-cart:hover {
        background: var(--primary-color);
    }

    .btn-remove {
        background: #ffe6e6;
        color: #ff4d4d;
    }

    .btn-remove:hover {
        background: #ffcccc;
        color: #cc0000;
    }

    /* ========== BREAKPOINTS ========== */

    /* Tablet Portrait (600px - 979px) */
    @media (max-width: 979px) {
        .wishlist-title {
            font-size: 1.6rem;
        }

        .wishlist-page {
            padding: 50px 15px;
        }

        .wishlist-header {
            margin-bottom: 30px;
        }

        /* Hide table, show cards */
        .wishlist-table {
            display: none;
        }

        .wishlist-cards-container {
            display: grid;
        }

        @media (min-width: 600px) {
            .wishlist-cards-container {
                grid-template-columns: repeat(2, 1fr);
                gap: 18px;
            }
        }
    }

    /* Tablet Landscape & Large Tablet (768px - 979px) */
    @media (min-width: 600px) and (max-width: 979px) {
        .container {
            padding-left: 10px;
            padding-right: 10px;
        }
    }

    /* Mobile Landscape (480px - 599px) */
    @media (max-width: 599px) {
        .wishlist-title {
            font-size: 1.5rem;
        }

        .wishlist-page {
            padding: 40px 12px;
        }

        .card-header {
            padding: 12px;
            gap: 12px;
        }

        .card-image {
            width: 65px;
            height: 85px;
        }

        .card-title a {
            font-size: 14px;
        }

        .card-price {
            font-size: 15px;
        }

        .card-body {
            padding: 12px;
        }

        .card-action-btn {
            padding: 10px;
            font-size: 11px;
        }
    }

    /* Mobile Portrait (350px - 479px) */
    @media (max-width: 479px) {
        .wishlist-title {
            font-size: 1.3rem;
        }

        .wishlist-header p {
            font-size: 13px;
        }

        .wishlist-page {
            padding: 30px 10px;
        }

        .wishlist-header {
            margin-bottom: 25px;
        }

        .wishlist-cards-container {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .card-header {
            padding: 12px;
            gap: 10px;
        }

        .card-image {
            width: 60px;
            height: 80px;
        }

        .card-title a {
            font-size: 13px;
            line-height: 1.3;
        }

        .card-price {
            font-size: 14px;
        }

        .card-status {
            font-size: 11px;
        }

        .card-body {
            padding: 10px;
        }

        .card-actions {
            gap: 8px;
        }

        .card-action-btn {
            padding: 10px 8px;
            font-size: 10px;
        }

        .empty-wishlist {
            padding: 40px 15px;
        }

        .empty-wishlist h3 {
            font-size: 20px;
        }

        .empty-wishlist p {
            font-size: 13px;
        }
    }

    /* Extra Small (320px - 349px) */
    @media (max-width: 349px) {
        .wishlist-title {
            font-size: 1.2rem;
        }

        .card-header {
            padding: 10px;
            gap: 8px;
        }

        .card-image {
            width: 55px;
            height: 75px;
        }

        .card-body {
            padding: 8px;
        }
    }

    /* ========== ACCESSIBILITY ========== */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }

</style>
@endsection

@section('content')
<div class="wishlist-page">
    <div class="container">
        <div class="wishlist-header">
            <h1 class="wishlist-title">My Wishlist</h1>
            <p>Your curated collection of premium comfort</p>
        </div>

        @if($wishlist->isNotEmpty())
            <!-- Desktop Table View (980px+) -->
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
                            if (!$product) continue;
                            
                            $photo = $product->productvariant->first()->photo ?? '';
                            $photos = $photo ? explode(',', $photo) : [asset('frontend/images/Products/_DSC8742-Edit.jpg')];
                        @endphp
                        <tr>
                            <td>
                                <div class="wishlist-item-info">
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
                                <form action="{{ route('wishlist.remove') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="remove-btn">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Mobile Card View (Below 980px) -->
            <div class="wishlist-cards-container">
                @foreach($wishlist as $item)
                    @php
                        $product = $item->wishlist1;
                        if (!$product) continue;
                        
                        $photo = $product->productvariant->first()->photo ?? '';
                        $photos = $photo ? explode(',', $photo) : [asset('frontend/images/Products/_DSC8742-Edit.jpg')];
                    @endphp
                    <div class="wishlist-card">
                        <div class="card-header">
                            <img src="{{ image_url($photos[0]) }}" alt="{{ $product->name }}" class="card-image">
                            <div class="card-title">
                                <a href="{{ route('product_detail', $product->slug) }}">{{ $product->name }}</a>
                                <div class="card-price">₹{{ number_format($product->selling_price ?? $product->regular_price) }}</div>
                                <div class="card-status">In Stock</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-actions">
                                <a href="{{ route('product_detail', $product->slug) }}" class="card-action-btn btn-add-to-cart">
                                    Select Options
                                </a>
                                <form action="{{ route('wishlist.remove') }}" method="POST" style="flex: 1;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="card-action-btn btn-remove" style="width: 100%;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <div class="empty-wishlist">
                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#fdeef2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 20px;"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                <h3>Your wishlist is empty</h3>
                <p>Save your favorite pieces here to easily find them later.</p>
                <a href="{{ route('shop') }}" class="add-to-cart-btn" style="background: var(--primary-color); padding: 15px 40px;">Continue Shopping</a>
            </div>
        @endif
    </div>
</div>
@endsection
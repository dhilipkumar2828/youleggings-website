{{-- resources/views/partials/product_card.blade.php --}}

<div class="product-item {{ $outOfStock ? 'out-of-stock' : '' }}">
    <div class="product-image">
        <img src="{{ $product->image_url ?? asset('images/no-image.png') }}" alt="{{ $product->name }}">
    </div>

    <div class="product-details">
        <h4 class="product-name">{{ $product->name }}</h4>
        <p class="product-price">₹{{ number_format($product->price, 2) }}</p>

        @if ($outOfStock)
            <span class="badge bg-danger">Out of Stock</span>
        @else
            <span class="badge bg-success">In Stock</span>
        @endif
    </div>
</div>

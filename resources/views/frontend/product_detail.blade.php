@extends('frontend.layouts.app')

@section('title', $product->name . ' | You Leggings')

@section('content')
  <!-- Product Detail Page -->
  <section class="section page-view product-page" id="product-page" style="display: block;">
    <div class="page-main product-main" style="background-color: #9f9f9f;">
      <div class="hero-overlay"></div>
      <div
        style="position: absolute; inset: 0; background-image: url('{{ asset('frontend/images/bg-less/_DSC8984-Photoroom.png') }}'); background-size: auto 110%; background-position: right 100% top 50%; background-repeat: no-repeat; transform: scaleX(-1); z-index: 2;">
      </div>
      <div class="container page-main-content">
        <span class="hero-subtitle">Product Details</span>
        <h1 class="hero-title">{!! nl2br(e($product->name)) !!}</h1>
      </div>
    </div>

    <div class="container page-body">
      @php
          $allSizes = array_keys($grouped_variants);
          $defaultSize = !empty($allSizes) ? $allSizes[0] : null;
          $availableColors = $defaultSize ? array_keys($grouped_variants[$defaultSize]) : [];
          $defaultColor = !empty($availableColors) ? $availableColors[0] : null;
          $defaultVariant = ($defaultSize && $defaultColor) ? $grouped_variants[$defaultSize][$defaultColor] : null;

          $photos = $defaultVariant['photos'] ?? [];
          $defaultImage = !empty($photos) ? image_url($photos[0]) : asset('frontend/images/Products/_DSC8742-Edit.jpg');

          $colorHexMap = [
              'Red' => '#c0392b',
              'Blue' => '#2980b9',
              'Green' => '#27ae60',
              'Black' => '#333333',
              'White' => '#ffffff',
              'Yellow' => '#f1c40f',
              'Pink' => '#e84393',
              'Brown' => '#634b3f',
              'Nude' => '#d3bfa9',
              'Beige' => '#f5f5dc',
              'Purple' => '#8e44ad',
              'Grey' => '#7f8c8d'
          ];
      @endphp

      <div class="product-detail-layout">
        <div class="product-detail-gallery">
          <div class="product-detail-image-wrap">
            <img id="productDetailImage" src="{{ $defaultImage }}" alt="{{ $product->name }}">
          </div>
          <div class="product-thumb-row" id="productThumbRow">
            @foreach($photos as $p)
                <button class="product-thumb {{ $loop->first ? 'is-active' : '' }}" type="button" onclick="changeMainImage('{{ image_url($p) }}', this)">
                    <img src="{{ image_url($p) }}" alt="{{ $product->name }}">
                </button>
            @endforeach
          </div>
        </div>

        <div class="product-detail-content">
          <p class="product-detail-category">{{ $product->categories->title ?? 'Legging' }}</p>
          <h2 class="product-detail-title">{{ $product->name }}</h2>
          <p class="product-detail-meta" style="color: #6b5a63;">Sizes {{ !empty($allSizes) ? $allSizes[0] . ' - ' . end($allSizes) : '' }}</p>
          <div class="product-detail-price" id="productDetailPrice" style="color: var(--primary-color);">INR {{ number_format($defaultVariant['price'] ?? 0) }}</div>
          <p class="product-tax-line" style="color: #27ae60; font-weight: 600;">Inclusive of all taxes</p>

          <div class="product-detail-block compact-block">
            <h3 style="font-weight: 700; letter-spacing: 1.5px; margin-bottom: 12px;">Select Size</h3>
            <div class="product-size-list compact-size-list" id="productSizeList">
                @foreach($allSizes as $size)
                    <button type="button" class="{{ $size == $defaultSize ? 'is-active' : '' }}" data-size="{{ $size }}" onclick="selectSize('{{ $size }}')">
                        {{ $size }}
                    </button>
                @endforeach
            </div>
          </div>

          <div class="product-detail-block compact-block" id="colorFilterSection" style="{{ empty($availableColors) ? 'display:none;' : '' }}">
            <h3 style="font-weight: 700; letter-spacing: 1.5px; margin-bottom: 12px;">Select Color</h3>
            <div class="product-color-list" id="productColorList">
                @foreach($availableColors as $color)
                    <div class="product-color {{ $color == $defaultColor ? 'is-active' : '' }}"
                         style="--swatch: {{ $colorHexMap[$color] ?? '#ccc' }};"
                         title="{{ $color }}"
                         data-color="{{ $color }}"
                         onclick="selectColor('{{ $color }}')">
                    </div>
                @endforeach
            </div>
          </div>

          <div class="product-detail-actions compact-actions" style="margin-top: 20px;">
            <button id="productAddToCartBtn" type="button" class="btn" style="background: #333; color: #fff; width: 100%; padding: 18px; font-weight: 700; letter-spacing: 2px;">ADD TO CART</button>
          </div>

          <div class="product-service-strip compact-service-strip" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 30px;">
             <div style="text-align: center; border: 1px solid #f0dbe4; border-radius: 12px; padding: 15px 5px;">
                <i data-lucide="truck" style="width: 20px; color: var(--primary-color); margin-bottom: 8px;"></i>
                <h4 style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">Free Shipping</h4>
             </div>
             <div style="text-align: center; border: 1px solid #f0dbe4; border-radius: 12px; padding: 15px 5px;">
                <i data-lucide="shield-check" style="width: 20px; color: var(--primary-color); margin-bottom: 8px;"></i>
                <h4 style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">Quality Mark</h4>
             </div>
             <div style="text-align: center; border: 1px solid #f0dbe4; border-radius: 12px; padding: 15px 5px;">
                <i data-lucide="lock" style="width: 20px; color: var(--primary-color); margin-bottom: 8px;"></i>
                <h4 style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">Secure Pay</h4>
             </div>
             <div style="text-align: center; border: 1px solid #f0dbe4; border-radius: 12px; padding: 15px 5px;">
                <i data-lucide="refresh-cw" style="width: 20px; color: var(--primary-color); margin-bottom: 8px;"></i>
                <h4 style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">Easy Return</h4>
             </div>
          </div>
        </div>
      </div>

      <div class="product-tab-section"
        style="margin-top: 60px; background: #fff; padding: 40px; border-radius: 16px; box-shadow: 0 10px 30px rgba(125, 84, 101, 0.08); border: 1px solid #f0dbe4;">
        <div class="product-tab-nav" role="tablist" style="border-bottom: 2px solid #f7f7f7; margin-bottom: 30px; display: flex; gap: 30px;">
          <button type="button" class="product-tab-btn is-active" data-tab-target="desc" style="padding: 10px 0; border: none; background: none; font-weight: 700; cursor: pointer; color: #5d3f4c; border-bottom: 2px solid transparent; transition: all 0.3s; font-size: 15px; letter-spacing: 1px;">DESCRIPTION</button>
          <button type="button" class="product-tab-btn" data-tab-target="reviews" style="padding: 10px 0; border: none; background: none; font-weight: 700; cursor: pointer; color: #5d3f4c; border-bottom: 2px solid transparent; transition: all 0.3s; font-size: 15px; letter-spacing: 1px;">REVIEWS</button>
        </div>
        <div class="product-tab-panels">
          <div class="product-tab-panel is-active" id="desc">
            <div class="dynamic-description" style="color: #6b5a63; line-height: 1.8; font-size: 15px;">
                {!! $product->description !!}
            </div>
          </div>
          <div class="product-tab-panel" id="reviews" style="display:none;">
            <div id="productDetailTabReviews">
                @forelse($product->reviews as $review)
                    <div style="margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid #f0dbe4;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                          <strong style="font-size: 15px; color: #5d3f4c;">{{ $review->name }}</strong>
                          <span style="color: #f59e0b; font-size: 14px;">{{ str_repeat('★', $review->stars) }}</span>
                        </div>
                        <p style="font-size: 14px; color: #6b5a63; margin-top: 5px;">{{ $review->review }}</p>
                    </div>
                @empty
                    <p>No reviews yet. Be the first to review!</p>
                @endforelse
            </div>
          </div>
        </div>
      </div>

      <div class="related-products">
        <div class="text-center" style="margin-top: 60px;">
          <span class="section-subtitle">You Might Like</span>
          <h2 class="section-title">Related Products</h2>
        </div>
        <div class="products-grid">
           @foreach($related_products as $rp)
                <a href="{{ route('product_detail', $rp->slug) }}" class="product-card">
                  <div class="product-image">
                    @php
                        $rPhoto = $rp->productvariant->first()->photo ?? '';
                        $rPhotos = explode(',', $rPhoto);
                    @endphp
                    <img src="{{ image_url($rPhotos[0]) }}" alt="{{ $rp->name }}">
                  </div>
                  <div class="product-details">
                    <h3 class="product-name">{{ $rp->name }}</h3>
                    <div class="product-price">INR {{ number_format($rp->regular_price) }}</div>
                  </div>
                </a>
           @endforeach
        </div>
      </div>
    </div>
  </section>
@endsection

@section('scripts')
<script>
    const groupedVariants = @json($grouped_variants);
    const colorHexMap = @json($colorHexMap);
    let currentSize = '{{ $defaultSize }}';
    let currentColor = '{{ $defaultColor }}';

    function selectSize(size) {
        currentSize = size;

        // Update Size UI
        document.querySelectorAll('#productSizeList button').forEach(btn => {
            btn.classList.toggle('is-active', btn.getAttribute('data-size') === size);
        });

        // Update Colors for this size
        const colors = Object.keys(groupedVariants[size]);
        const colorList = document.getElementById('productColorList');
        colorList.innerHTML = '';

        colors.forEach(color => {
            const colorDiv = document.createElement('div');
            colorDiv.className = 'product-color' + (color === colors[0] ? ' is-active' : '');
            colorDiv.style.cssText = `--swatch: ${colorHexMap[color] || '#ccc'}`;
            colorDiv.title = color;
            colorDiv.setAttribute('data-color', color);
            colorDiv.onclick = () => selectColor(color);
            colorList.appendChild(colorDiv);
        });

        // Auto select first color
        if (colors.length > 0) {
            selectColor(colors[0]);
        }
    }

    function selectColor(color) {
        currentColor = color;

        // Update Color UI
        document.querySelectorAll('#productColorList .product-color').forEach(div => {
            div.classList.toggle('is-active', div.getAttribute('data-color') === color);
        });

        const variant = groupedVariants[currentSize][color];

        // Update Price
        document.getElementById('productDetailPrice').innerText = 'INR ' + Number(variant.price).toLocaleString();

        // Update Gallery
        updateGallery(variant.photos);
    }

    function updateGallery(photos) {
        const thumbRow = document.getElementById('productThumbRow');
        const mainImage = document.getElementById('productDetailImage');

        thumbRow.innerHTML = '';
        if (photos.length > 0) {
            // Set main image to first photo
            const firstPhotoUrl = getImageUrl(photos[0]);
            mainImage.src = firstPhotoUrl;

            photos.forEach((photo, index) => {
                const photoUrl = getImageUrl(photo);
                const btn = document.createElement('button');
                btn.className = 'product-thumb' + (index === 0 ? ' is-active' : '');
                btn.type = 'button';
                btn.onclick = () => changeMainImage(photoUrl, btn);
                btn.innerHTML = `<img src="${photoUrl}" alt="Product image">`;
                thumbRow.appendChild(btn);
            });
        }
    }

    function changeMainImage(url, thumb) {
        document.getElementById('productDetailImage').src = url;
        document.querySelectorAll('.product-thumb').forEach(btn => btn.classList.remove('is-active'));
        thumb.classList.add('is-active');
    }

    function getImageUrl(path) {
        if (!path) return '';

        // Strip any hardcoded host:port/public/ prefix (same logic as PHP image_url helper)
        // Handles: http://127.0.0.1:ANY_PORT/public/ or http://localhost:ANY_PORT/public/
        path = path.replace(/^https?:\/\/(127\.0\.0\.1|localhost)(:\d+)?\/public\//, '');

        // Also strip leftover plain prefixes
        path = path.replace(/^public\/uploads\//, '')
                   .replace(/^public\/storage\//, '')
                   .replace(/^public\//, '')
                   .replace(/^storage\//, '')
                   .replace(/^uploads\//, '');

        path = path.replace(/^\/+/, '');

        // Now rebuild with current origin using same priority as PHP helper
        const base = window.location.origin;

        // Check uploads path (most common for product images)
        return base + '/uploads/' + path;
    }

    // Dynamic Tab Logic
    document.querySelectorAll('.product-tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.getAttribute('data-tab-target');
            document.querySelectorAll('.product-tab-panel').forEach(p => p.style.display = 'none');
            document.getElementById(target).style.display = 'block';
            document.querySelectorAll('.product-tab-btn').forEach(b => {
                b.classList.remove('is-active');
                b.style.borderBottomColor = 'transparent';
            });
            btn.classList.add('is-active');
            btn.style.borderBottomColor = 'var(--primary-color)';
        });
    });

    // Initialize first tab
    if (document.querySelector('.product-tab-btn.is-active')) {
        document.querySelector('.product-tab-btn.is-active').style.borderBottomColor = 'var(--primary-color)';
    }
</script>
<style>
    .product-color.is-active {
        border-color: var(--primary-color) !important;
        transform: scale(1.1);
    }
    .product-tab-btn.is-active {
        color: var(--primary-color) !important;
    }
</style>
@endsection

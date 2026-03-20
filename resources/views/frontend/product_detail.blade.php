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
          $price = $defaultVariant['price'] ?? 0;
          $salePrice = $defaultVariant['sale_price'] ?? $price;

          $photos = $defaultVariant['photos'] ?? [];
          $defaultImage = !empty($photos) ? image_url($photos[0]) : asset('frontend/images/Products/_DSC8742-Edit.jpg');

          $colorHexMap = array_merge([
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
              'Grey' => '#7f8c8d',
              'Skyblue' => '#87CEEB',
              'Sky Blue' => '#87CEEB',
              'Maroon' => '#800000',
              'Navy' => '#000080',
              'Salmon' => '#FA8072',
              'Peach' => '#FFDAB9',
              'Mauve' => '#E0B0FF',
              'Dusty Rose' => '#DCAE96',
              'Olive' => '#808000',
              'Navy Blue' => '#000080'
          ], $colorHexMap ?? []); // Merge with colors from controller (inline Type:Hex)

          // Dynamic Colors from Admin (Attribute type: Color Mapping) - Secondary source
          $dynamicColors = \App\Models\Attribute::where('attribute_type', 'Color Mapping')->first();
          if ($dynamicColors && is_array($dynamicColors->value)) {
              foreach($dynamicColors->value as $cv) {
                  if (strpos($cv, ':') !== false) {
                      $parts = explode(':', $cv);
                      $colorHexMap[trim($parts[0])] = trim($parts[1]);
                  }
              }
          }

          // Function to check if color is very light (to add a border)
          $isLightColor = function($color) use ($colorHexMap) {
              $hex = $colorHexMap[$color] ?? $color;
              if (str_starts_with($hex, '#')) {
                  $hex = str_replace('#', '', $hex);
                  if(strlen($hex) == 3) $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
                  if(strlen($hex) != 6) return false;
                  $r = hexdec(substr($hex, 0, 2));
                  $g = hexdec(substr($hex, 2, 2));
                  $b = hexdec(substr($hex, 4, 2));
                  $brightness = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
                  return $brightness > 220;
              }
              return in_array(strtolower($hex), ['white', 'beige', 'nude', 'ivory', 'off-white']);
          };
      @endphp

      <div class="product-detail-layout">
        <div class="product-detail-gallery">
          <div class="product-detail-image-wrap" style="position: relative;">
            <img id="productDetailImage" src="{{ $defaultImage }}" alt="{{ $product->name }}">
            
            @php
                $isInWishlist = Auth::check() && \App\Models\Wishlist::where('customer_id', Auth::id())->where('product_id', $product->id)->exists();
            @endphp
            <button type="button" class="wishlist-toggle-btn" onclick="toggleWishlist(event, {{ $product->id }})" style="position: absolute; top: 15px; right: 15px; background: rgba(255,255,255,0.9); border: none; width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: {{ $isInWishlist ? '#ec407a' : '#888' }}; transition: 0.3s; box-shadow: 0 4px 10px rgba(0,0,0,0.1); z-index: 10;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="{{ $isInWishlist ? '#ec407a' : 'none' }}" stroke="{{ $isInWishlist ? '#ec407a' : '#888' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
            </button>
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
          <p class="product-detail-meta" style="color: #6b5a63;">Sizes 
            @php 
                $filteredSizes = array_values(array_filter($allSizes, function($s) { return strtolower($s) !== 'standard'; }));
            @endphp
            {{ !empty($filteredSizes) ? $filteredSizes[0] . ' - ' . end($filteredSizes) : '' }}
          </p>
          <div class="product-detail-price" id="productDetailPrice" style="color: var(--primary-color);">
              @if($salePrice < $price)
                  <span class="original-price" style="text-decoration: line-through; color: #888; font-size: 0.8em; margin-right: 10px;">₹{{ number_format($price) }}</span>
                  <span class="discounted-price">₹{{ number_format($salePrice) }}</span>
              @else
                  ₹{{ number_format($price) }}
              @endif
          </div>
          <p class="product-tax-line" style="color: #27ae60; font-weight: 600;">Inclusive of all taxes</p>

          <div class="product-detail-block compact-block">
            <h3 style="font-weight: 700; letter-spacing: 1.5px; margin-bottom: 12px;">Select Size</h3>
            <div class="product-size-list compact-size-list" id="productSizeList">
                @foreach($allSizes as $size)
                    @if(strtolower($size) !== 'standard')
                    <button type="button" class="{{ $size == $defaultSize ? 'is-active' : '' }}" data-size="{{ $size }}" onclick="selectSize('{{ $size }}')">
                        {{ $size }}
                    </button>
                    @endif
                @endforeach
            </div>
          </div>

          <div class="product-detail-block compact-block" id="colorFilterSection" style="{{ empty($availableColors) ? 'display:none;' : '' }}">
            <h3 style="font-weight: 700; letter-spacing: 1.5px; margin-bottom: 12px;">Select Color</h3>
            <div class="product-color-list" id="productColorList">
                @foreach($availableColors as $color)
                    @php
                        $vData = $grouped_variants[$defaultSize][$color] ?? [];
                        $imgUrl = $vData['first_photo'] ?? '';
                        // Priority: Admin hex > colorHexMap > fallback grey
                        $swatchHex = $vData['color_hex'] ?? null;

                        // Extract display name from key (strip "||#hex" suffix if present)
                        $rawDisplay = strpos($color, '||') !== false ? explode('||', $color)[0] : $color;

                        // If the extracted part looks like a size label (S, M, L, XL, XXL, Standard etc.)
                        // use the hex code as title instead, since the key is "Size||#hex"
                        $knownSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', '2XL', '3XL', 'Standard', 'standard'];
                        $isSizeLabel = in_array(trim($rawDisplay), $knownSizes);

                        if ($swatchHex) {
                            $displayColor = $isSizeLabel ? $swatchHex : $rawDisplay;
                        } else {
                            $displayColor = $isSizeLabel ? '' : $rawDisplay;
                            $swatchHex = $colorHexMap[$rawDisplay] ?? null;
                        }
                    @endphp
                    <div class="product-color {{ $color == $defaultColor ? 'is-active' : '' }}"
                         style="--swatch: {{ $swatchHex ?? '#f3f3f3' }};"
                         title="{{ $displayColor }}"
                         data-color="{{ $color }}"
                         data-image="{{ $imgUrl }}"
                         data-color-hex="{{ $swatchHex ?? '' }}"
                         onclick="selectColor('{{ $color }}')">
                    </div>
                @endforeach
            </div>
          </div>

          <div class="product-detail-actions compact-actions" style="margin-top: 20px; display: flex; gap: 15px;">
            <button id="productAddToCartBtn" type="button" class="btn" 
                    data-product-id="{{ $product->id }}" 
                    data-variant-id="{{ $defaultVariant['id'] ?? '' }}"
                    style="background: #333; color: #fff; flex: 1; padding: 18px; font-weight: 700; letter-spacing: 2px;">ADD TO CART</button>
          </div>

          <div class="product-service-strip compact-service-strip" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 30px;">
             <div style="text-align: center; border: 1px solid #f0dbe4; border-radius: 12px; padding: 15px 5px;">
                <i data-lucide="truck" style="width: 20px; color: var(--primary-color); margin-bottom: 8px;"></i>
                <h4 style="font-size: 14px; text-transform: uppercase; letter-spacing: 1px;">Free Shipping</h4>
             </div>
             <div style="text-align: center; border: 1px solid #f0dbe4; border-radius: 12px; padding: 15px 5px;">
                <i data-lucide="shield-check" style="width: 20px; color: var(--primary-color); margin-bottom: 8px;"></i>
                <h4 style="font-size: 14px; text-transform: uppercase; letter-spacing: 1px;">Quality Mark</h4>
             </div>
             <div style="text-align: center; border: 1px solid #f0dbe4; border-radius: 12px; padding: 15px 5px;">
                <i data-lucide="lock" style="width: 20px; color: var(--primary-color); margin-bottom: 8px;"></i>
                <h4 style="font-size: 14px; text-transform: uppercase; letter-spacing: 1px;">Secure Pay</h4>
             </div>
             <div style="text-align: center; border: 1px solid #f0dbe4; border-radius: 12px; padding: 15px 5px;">
                <i data-lucide="refresh-cw" style="width: 20px; color: var(--primary-color); margin-bottom: 8px;"></i>
                <h4 style="font-size: 14px; text-transform: uppercase; letter-spacing: 1px;">Easy Return</h4>
             </div>
          </div>
        </div>
      </div>

      <div class="product-tab-section" style="margin-top: 60px;">
        <div class="product-tab-nav" role="tablist" style="margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap;">
          <button type="button" class="product-tab-btn is-active" data-tab-target="desc">DESCRIPTION</button>
          <button type="button" class="product-tab-btn" data-tab-target="specs">SPECIFICATIONS</button>
          <button type="button" class="product-tab-btn" data-tab-target="fab">FABRICATION</button>
          <button type="button" class="product-tab-btn" data-tab-target="reviews">REVIEWS</button>
        </div>
        <div class="product-tab-panels" style="background: #fff; padding: 40px; border-radius: 12px; border: 1px solid #f0dbe4; box-shadow: 0 10px 30px rgba(125, 84, 101, 0.04);">
          <div class="product-tab-panel is-active" id="desc">
            <div class="dynamic-description" style="color: #6b5a63; line-height: 1.8; font-size: 15px;">
                {!! $product->description !!}
            </div>
          </div>
          <div class="product-tab-panel" id="specs" style="display:none;">
            <div style="color: #6b5a63; line-height: 1.8; font-size: 15px;">
                <p><strong>Material:</strong> Premium Cotton-Elastane Blend</p>
                <p><strong>Fit:</strong> High-Waisted, 4-Way Stretch</p>
                <p><strong>Pattern:</strong> Solid / Comfort Grip</p>
                <p><strong>Occasion:</strong> Workwear, Yoga, Casual</p>
            </div>
          </div>
          <div class="product-tab-panel" id="fab" style="display:none;">
            <div style="color: #6b5a63; line-height: 1.8; font-size: 15px;">
                <p>Crafted with our signature TANTEX™ technology. The fabric undergoes a special bio-wash process for extra softness and long-lasting color retention. Breathable and moisture-wicking to keep you fresh all day.</p>
            </div>
          </div>
          <div class="product-tab-panel" id="reviews" style="display:none;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <h3 style="font-size: 20px; color: #5d3f4c; font-weight: 700;">Customer Reviews</h3>
                <button type="button" class="btn btn-dark" onclick="toggleReviewForm()" style="background: #333; color: #fff; padding: 10px 25px; font-weight: 700; border: none; letter-spacing: 1px;">ADD A REVIEW</button>
            </div>

            <!-- Review Form -->
            <div id="reviewForm" style="display: none; background: #fffafc; padding: 30px; border-radius: 12px; border: 1px solid #f0dbe4; margin-bottom: 40px;">
                <form action="{{ route('review.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #5d3f4c;">Your Name</label>
                            <input type="text" name="name" required style="width: 100%; padding: 12px; border: 1px solid #f0dbe4; border-radius: 8px;" value="{{ Auth::user()->name ?? '' }}">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #5d3f4c;">Your Email</label>
                            <input type="email" name="email" required style="width: 100%; padding: 12px; border: 1px solid #f0dbe4; border-radius: 8px;" value="{{ Auth::user()->email ?? '' }}">
                        </div>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #5d3f4c;">Rating</label>
                        <div class="rating-input" style="display: flex; gap: 10px; font-size: 24px; flex-direction: row-reverse; justify-content: flex-end;">
                            @for($i=5; $i>=1; $i--)
                                <input type="radio" name="rate" value="{{ $i }}" id="rate-{{ $i }}" style="display: none;" {{ $i==5 ? 'checked' : '' }}>
                                <label for="rate-{{ $i }}" style="cursor: pointer; color: #cbd5e1;" class="star-label">★</label>
                            @endfor
                        </div>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #5d3f4c;">Your Review</label>
                        <textarea name="review" required style="width: 100%; padding: 12px; border: 1px solid #f0dbe4; border-radius: 8px; height: 120px;" placeholder="What did you like or dislike?"></textarea>
                    </div>
                    <button type="submit" class="btn" style="background: var(--primary-color); color: #fff; padding: 12px 30px; border: none; font-weight: 700; border-radius: 8px;">SUBMIT REVIEW</button>
                </form>
            </div>

            <div id="productDetailTabReviews">
                @forelse($product->reviews as $review)
                    <div style="margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid #f0dbe4;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                          <strong style="font-size: 15px; color: #5d3f4c;">{{ $review->name }}</strong>
                          <span style="color: #f59e0b; font-size: 14px;">{{ str_repeat('★', $review->rate) }}</span>
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
                    <div class="product-price">₹{{ number_format($rp->regular_price) }}</div>
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

    function isLight(hex) {
        if (!hex || !hex.startsWith('#')) return ['white', 'beige', 'nude', 'ivory', 'off-white'].includes(hex?.toLowerCase());
        hex = hex.replace('#', '');
        if (hex.length === 3) hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
        if (hex.length !== 6) return false;
        const r = parseInt(hex.substring(0, 2), 16);
        const g = parseInt(hex.substring(2, 4), 16);
        const b = parseInt(hex.substring(4, 6), 16);
        const brightness = ((r * 299) + (g * 587) + (b * 114)) / 1000;
        return brightness > 220;
    }

    function parseColorImages(str) {
        var map = {};
        if (!str) return map;
        str.split(';').forEach(function(pair) {
            var parts = pair.split('=');
            if (parts.length === 2 && parts[0] && parts[1]) {
                // Normalize key to lowercase and remove spaces
                var key = parts[0].trim().toLowerCase();
                map[key] = parts[1].trim();
            }
        });
        return map;
    }

    function extractDominantColor(imgUrl, element) {
        if (!imgUrl) return;
        const img = new Image();
        img.crossOrigin = "Anonymous";
        img.onload = function() {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            // Sample a 50x50 region from the vertical center of the image
            // This is where the legging fabric is most visible (not top which may be waistband/background)
            const sW = 50, sH = 50;
            canvas.width = sW;
            canvas.height = sH;
            const srcX = Math.max(0, (img.width - sW) / 2);   // horizontal center
            const srcY = Math.max(0, img.height * 0.75);       // ~75% from top (legs/leggings area)
            ctx.drawImage(img, srcX, srcY, sW, sH, 0, 0, sW, sH);
            const data = ctx.getImageData(0, 0, sW, sH).data;
            let r=0, g=0, b=0, count=0;
            for(let i=0; i<data.length; i+=4) {
                const pr=data[i], pg=data[i+1], pb=data[i+2], pa=data[i+3];
                // Skip near-white/transparent pixels (background)
                if (pa < 30) continue;              // transparent
                if (pr > 232 && pg > 232 && pb > 232) continue;  // near-white
                r += pr; g += pg; b += pb; count++;
            }
            if (count === 0) return; // all background, skip
            r = Math.floor(r/count);
            g = Math.floor(g/count);
            b = Math.floor(b/count);
            const hex = "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
            element.style.setProperty('--swatch', hex);
            if (isLight(hex)) element.style.border = '1px solid #ccc';
            else element.style.border = 'none';
        };
        img.src = imgUrl;
    }

    function selectSize(size) {
        currentSize = size;

        // Update Size UI
        document.querySelectorAll('#productSizeList button').forEach(btn => {
            btn.classList.toggle('is-active', btn.getAttribute('data-size') === size);
        });

        // Update Colors for this size
        const colors = Object.keys(groupedVariants[size]);
        const colorList = document.getElementById('productColorList');
        if (colorList) {
            colorList.innerHTML = '';
            colors.forEach(color => {
                const variantData = groupedVariants[size][color];
                const colorDiv = document.createElement('div');
                const isActive = (color === currentColor);
                colorDiv.className = 'product-color' + (isActive ? ' is-active' : '');

                // Display name: strip "||#hex" suffix if present
                const rawDisplay = color.includes('||') ? color.split('||')[0] : color;
                // If rawDisplay is a size label (like 'S', 'M', 'L'), use hex as the display name
                const knownSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', '2XL', '3XL', 'Standard', 'standard'];
                const isSizeLabel = knownSizes.includes(rawDisplay.trim());

                // Priority 1: Admin-saved hex code
                const adminHex = variantData.color_hex || null;
                // Priority 2: colorHexMap predefined (use clean display name as key)
                const mapHex = colorHexMap[rawDisplay] || null;
                // Final swatch color
                const swatchHex = adminHex || mapHex || '#f3f3f3';
                // Display title: use hex if the rawDisplay is a size label
                const displayName = isSizeLabel ? (swatchHex || rawDisplay) : rawDisplay;

                colorDiv.style.cssText = `--swatch: ${swatchHex};`;
                if (isLight(swatchHex)) colorDiv.style.border = '1px solid #ccc';
                colorDiv.title = displayName;
                colorDiv.setAttribute('data-color', color);
                colorDiv.setAttribute('data-image', variantData.first_photo || '');
                colorDiv.setAttribute('data-color-hex', swatchHex);

                // Only extract from image if NO admin color and NO map color
                if (!adminHex && !mapHex) {
                    extractDominantColor(variantData.first_photo, colorDiv);
                }

                colorDiv.onclick = () => selectColor(color);
                colorList.appendChild(colorDiv);
            });
        }

        // Retain current color if available in the new size, otherwise fallback to first available color
        const targetColor = colors.includes(currentColor) ? currentColor : (colors.length > 0 ? colors[0] : null);
        if (targetColor) selectColor(targetColor);

        // --- Parallel Background Pre-Recoloring ---
        // Process ALL variants in this size in parallel (No async/await loop)
        colors.forEach((c) => {
            const vData = (groupedVariants[size] || {})[c];
            if (vData && vData.color_hex && vData.first_photo) {
                const targetHex = vData.color_hex;
                const url = vData.first_photo;
                getDominantRGB(url).then(sourceRGB => {
                    if (sourceRGB) {
                        const targetRGB = hexToRGB(targetHex);
                        if (targetRGB) canvasRecolorImage(url, targetHex, sourceRGB, targetRGB);
                    }
                });
            }
        });
    }

    // --- Color-to-Image Smart Matching ---
    // Cache for recolored images: url + targetHex -> dataUrl
    const recolorCache = {};
    const photoColorCache = {};

    /**
     * Extract dominant RGB from an image URL (canvas, leggings area ~75% down).
     * Returns a Promise resolving to {r, g, b} or null on failure.
     */
    function getDominantRGB(imgUrl) {
        return new Promise((resolve) => {
            if (!imgUrl) return resolve(null);
            const normalized = getImageUrl(imgUrl);
            if (photoColorCache[normalized]) return resolve(photoColorCache[normalized]);

            const img = new Image();
            img.crossOrigin = "anonymous";
            img.onload = function () {
                try {
                    const canvas = document.createElement('canvas');
                    const sW = 150, sH = 150; // Larger sample for better accuracy
                    canvas.width = sW; canvas.height = sH;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, sW, sH);
                    const data = ctx.getImageData(0, 0, sW, sH).data;
                    
                    let bestRGB = null;
                    let maxSat = -1;
                    
                    // Sample the image to find the MOST VIBRANT color (the leggings)
                    // We skip neutrals/skin to find the actual fabric
                    for (let i = 0; i < data.length; i += 20) { // Step to save perf
                        const r = data[i], g = data[i+1], b = data[i+2], a = data[i+3];
                        if (a < 150) continue; 
                        
                        const max = Math.max(r, g, b), min = Math.min(r, g, b);
                        const delta = max - min;
                        if (delta < 25) continue; // skip neutrals/whites/greys

                        const L = (max + min) / 2;
                        const S = (delta / (1 - Math.abs(2 * L / 255 - 1))) * 100 / 255;
                        
                        // Ignore Skin tones during base detection
                        let H;
                        if (max === r) H = (g - b) / delta + (g < b ? 6 : 0);
                        else if (max === g) H = (b - r) / delta + 2;
                        else H = (r - g) / delta + 4;
                        H *= 60;
                        if (H >= 4 && H <= 48 && S < 60) continue; // skip skin

                        if (S > maxSat) {
                            maxSat = S;
                            bestRGB = { r, g, b };
                        }
                    }

                    // Fallback to a central sample if no vibrant color found
                    if (!bestRGB) {
                        let r=0, g=0, b=0, c=0;
                        for(let i=0; i<data.length; i+=16) {
                            if (data[i+3] > 150) { r+=data[i]; g+=data[i+1]; b+=data[i+2]; c++; }
                        }
                        bestRGB = c > 0 ? { r:Math.round(r/c), g:Math.round(g/c), b:Math.round(b/c) } : {r:128, g:128, b:128};
                    }

                    photoColorCache[normalized] = bestRGB;
                    resolve(bestRGB);
                } catch(e) { resolve(null); }
            };
            img.onerror = () => resolve(null);
            img.src = normalized;
        });
    }

    /** Euclidean RGB distance between two {r,g,b} objects */
    function colorDistance(c1, c2) {
        return Math.sqrt(
            Math.pow(c1.r - c2.r, 2) +
            Math.pow(c1.g - c2.g, 2) +
            Math.pow(c1.b - c2.b, 2)
        );
    }

    /** Convert hex string like "#e60000" to {r,g,b} */
    function hexToRGB(hex) {
        if (!hex || !hex.startsWith('#')) return null;
        hex = hex.replace('#', '');
        if (hex.length === 3) hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
        if (hex.length !== 6) return null;
        return {
            r: parseInt(hex.substring(0,2), 16),
            g: parseInt(hex.substring(2,4), 16),
            b: parseInt(hex.substring(4,6), 16)
        };
    }

    /** Convert RGB to HSL for color shifting */
    function rgbToHsl(r, g, b) {
        r /= 255; g /= 255; b /= 255;
        const max = Math.max(r, g, b), min = Math.min(r, g, b);
        let h, s, l = (max + min) / 2;
        if (max === min) { h = s = 0; }
        else {
            const d = max - min;
            s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
            switch (max) {
                case r: h = (g - b) / d + (g < b ? 6 : 0); break;
                case g: h = (b - r) / d + 2; break;
                case b: h = (r - g) / d + 4; break;
            }
            h /= 6;
        }
        return { h: h * 360, s: s * 100, l: l * 100 };
    }

    /** Calculate the CSS filter string to shift from baseRGB to targetRGB */
    function calculateColorShiftFilter(baseRGB, targetRGB) {
        if (!baseRGB || !targetRGB) return '';
        const baseHsl = rgbToHsl(baseRGB.r, baseRGB.g, baseRGB.b);
        const targetHsl = rgbToHsl(targetRGB.r, targetRGB.g, targetRGB.b);

        const hueShift = Math.round(targetHsl.h - baseHsl.h);
        const satRatio = (targetHsl.s + 10) / (baseHsl.s + 10);
        const brightnessRatio = targetHsl.l / baseHsl.l;
        const s = Math.min(Math.max(satRatio, 0.4), 2.5);
        const b = Math.min(Math.max(brightnessRatio, 0.5), 1.5);
        return `hue-rotate(${hueShift}deg) saturate(${s}) brightness(${b})`;
    }

    /**
     * Canvas pixel recoloring — HSL Hue-based with EXPLICIT SKIN DETECTION.
     *
     * Steps per pixel:
     *  1. Skip transparent, near-white, near-black.
     *  2. Get pixel HSL.
     *  3. Skip very low saturation (greys/neutrals).
     *  4. ** Skip skin-tone pixels explicitly (warm hue 5–40°, mid sat, mid lightness).
     *  5. Check hue proximity to base legging color.
     *  6. Recolor matching pixels to target hue+sat, preserving lightness.
     *
     * @param {string} imgUrl    - Source image URL
     * @param {object} baseRGB   - {r,g,b} dominant legging color of the photo
     * @param {object} targetRGB - {r,g,b} desired output color
     * @param {number} [hueRange=40] - Max hue angle diff to match (degrees)
     */
    function canvasRecolorImage(imgUrl, targetHex, baseRGB, targetRGB, hueRange = 40, scale = 1.0) {
        const cacheKey = imgUrl + '_' + (targetHex || targetRGB.r + ',' + targetRGB.g + ',' + targetRGB.b) + (scale < 1 ? '_low' : '');
        if (recolorCache[cacheKey]) return Promise.resolve(recolorCache[cacheKey]);

        return new Promise((resolve) => {
            if (!imgUrl || !baseRGB || !targetRGB) return resolve(null);

            const img = new Image();
            img.crossOrigin = "anonymous";
            img.onload = function () {
                try {
                    const W = Math.floor(img.width * scale), H = Math.floor(img.height * scale);
                    const canvas = document.createElement('canvas');
                    canvas.width = W; canvas.height = H;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, W, H);

                    const imageData = ctx.getImageData(0, 0, W, H);
                    const data      = imageData.data;
                    const len       = data.length;

                    const bHsl = rgbToHsl(baseRGB.r, baseRGB.g, baseRGB.b);
                    const tHsl = rgbToHsl(targetRGB.r, targetRGB.g, targetRGB.b);
                    const isRed = (tHsl.h < 22 || tHsl.h > 338);

                    const targetHue = tHsl.h, targetSat = tHsl.s;
                    const tSum = targetRGB.r + targetRGB.g + targetRGB.b;
                    const bSum = baseRGB.r + baseRGB.g + baseRGB.b;

                    for (let i = 0; i < len; i += 4) {
                        const r = data[i], g = data[i+1], b = data[i+2];
                        if (data[i+3] < 30 || (r > 248 && g > 248 && b > 248) || (r < 8 && g < 8 && b < 8)) continue;
                        
                        // Spatial context: Y coordinate
                        const pixelIdx = i / 4;
                        const pY = Math.floor(pixelIdx / W);
                        const isUpperBody = (pY < H * 0.45); // Arms/Face protection zone

                        const max = r > g ? (r > b ? r : b) : (g > b ? g : b);
                        const min = r < g ? (r < b ? r : b) : (g < b ? g : b);
                        const delta = max - min;
                        if (delta < 12) continue; 

                        const lum = (max + min) / 2;
                        let hue;
                        if (max === r) hue = (g - b) / delta + (g < b ? 6 : 0);
                        else if (max === g) hue = (b - r) / delta + 2;
                        else hue = (r - g) / delta + 4;
                        hue *= 60;

                        const sat = (delta / (1 - Math.abs(2 * lum / 255 - 1))) * 100 / 255;
                        
                        // ** SPATIAL-AWARE ADAPTIVE PROTECTION **
                        const isShadow = (lum < 115); 
                        const isHighlight = (lum > 190);
                        
                        // Strict skin/neutral check for Upper Body (Arms/Face)
                        if (isUpperBody) {
                           if (sat < 22) continue; 
                           if ((hue >= 2 && hue <= 56) && (sat >= 5 && sat <= 80)) continue; 
                        } else if (!isShadow && !isHighlight) {
                           if (sat < 15) continue; 
                           if ((hue >= 2 && hue <= 52) && (sat >= 6 && sat <= 68)) continue; 
                        } else {
                           if (sat < 4) continue; 
                        }

                        let hDiff = Math.abs(hue - bHsl.h);
                        if (hDiff > 180) hDiff = 360 - hDiff;
                        
                        // Lower body (Leggings zone) gets extreme tolerance for edge leaks/highlights
                        // Dynamic range: highlights/shadows get even more coverage
                        const dynamicRange = isUpperBody ? 45 : (isShadow || isHighlight ? 85 : 75); 
                        if (hDiff > dynamicRange) continue;

                        let fS = targetSat;
                        let fL = lum * tSum / bSum;
                        
                        if (isRed) {
                            fS = Math.min(100, targetSat * 1.25);
                            if (fL > 110) fL = 110 + (fL - 110) * 0.6; 
                        }

                        const h_in = targetHue / 360, s_in = fS / 100, l_in = fL / 255;
                        let r_o, g_o, b_o;
                        if (s_in === 0) { r_o = g_o = b_o = l_in; } else {
                            const q = l_in < 0.5 ? l_in * (1 + s_in) : l_in + s_in - l_in * s_in;
                            const p = 2 * l_in - q;
                            const h2r = (p, q, t) => {
                                if (t < 0) t += 1; if (t > 1) t -= 1;
                                if (t < 1/6) return p + (q - p) * 6 * t;
                                if (t < 1/2) return q;
                                if (t < 2/3) return p + (q - p) * (2/3 - t) * 6;
                                return p;
                            };
                            r_o = h2r(p, q, h_in + 1/3); g_o = h2r(p, q, h_in); b_o = h2r(p, q, h_in - 1/3);
                        }
                        data[i] = r_o * 255; data[i+1] = g_o * 255; data[i+2] = b_o * 255;
                    }
                    ctx.putImageData(imageData, 0, 0);
                    const res = canvas.toDataURL('image/png');
                    recolorCache[cacheKey] = res;
                    resolve(res);
                } catch (e) { resolve(null); }
            };
            img.onerror = () => resolve(null);
            img.src = getImageUrl(imgUrl);
        });
    }




    /** HSL to RGB conversion (h: 0-360, s: 0-100, l: 0-100) */
    function hslToRgb(h, s, l) {
        h /= 360; s /= 100; l /= 100;
        let r, g, b;
        if (s === 0) { r = g = b = l; }
        else {
            const hue2rgb = (p, q, t) => {
                if (t < 0) t += 1; if (t > 1) t -= 1;
                if (t < 1/6) return p + (q - p) * 6 * t;
                if (t < 1/2) return q;
                if (t < 2/3) return p + (q - p) * (2/3 - t) * 6;
                return p;
            };
            const q = l < 0.5 ? l * (1 + s) : l + s - l * s;
            const p = 2 * l - q;
            r = hue2rgb(p, q, h + 1/3);
            g = hue2rgb(p, q, h);
            b = hue2rgb(p, q, h - 1/3);
        }
        return { r: Math.round(r * 255), g: Math.round(g * 255), b: Math.round(b * 255) };
    }

    /**
     * Given a list of photo URLs and a target hex color,
     * find the photo whose dominant color is closest to the target.
     * Returns { url, distance, sourceRGB } so the caller can decide
     * whether to apply a CSS color-shift filter.
     */
    async function findBestPhotoForColor(photos, targetHex) {
        const fallback = { url: photos.length ? getImageUrl(photos[0]) : null, distance: Infinity, sourceRGB: null };
        if (!photos || photos.length === 0) return fallback;
        const targetRGB = hexToRGB(targetHex);
        if (!targetRGB) return fallback;

        // Extract dominant colors for all photos in parallel
        const rgbList = await Promise.all(photos.map(p => getDominantRGB(p)));

        let bestIdx = 0;
        let bestDist = Infinity;
        rgbList.forEach((rgb, idx) => {
            if (!rgb) return;
            const dist = colorDistance(rgb, targetRGB);
            if (dist < bestDist) {
                bestDist = dist;
                bestIdx = idx;
            }
        });

        return {
            url: getImageUrl(photos[bestIdx]),
            distance: bestDist,
            sourceRGB: rgbList[bestIdx] || null,
        };
    }

    let currentHueShift = '';
    let currentColorData = null; // { sourceRGB, targetRGB, targetHex, needsRecolor }

    function selectColor(color) {
        currentColor = color;

        // 1. Get Selected Hex from Swatch UI (Admin Priority)
        const swatches = document.querySelectorAll('#productColorList .product-color');
        let selectedHex = "";
        swatches.forEach(div => {
            const isActive = div.getAttribute('data-color') === color;
            div.classList.toggle('is-active', isActive);
            if (isActive) selectedHex = (div.getAttribute('data-color-hex') || "").toUpperCase();
        });

        const variant = (groupedVariants[currentSize] || {})[color];
        if (!variant) return;

        // Fallback hex if not found on swatch
        if (!selectedHex) selectedHex = (variant.color_hex || "").toUpperCase();

        // 2. Update Price
        const priceEl = document.getElementById('productDetailPrice');
        if (priceEl) {
            const price = variant.price || 0;
            const salePrice = variant.sale_price || price;
            if (salePrice < price) {
                priceEl.innerHTML = `<span class="original-price" style="text-decoration:line-through;color:#888;font-size:0.8em;margin-right:10px;">₹${price.toLocaleString('en-IN')}</span><span class="discounted-price">₹${salePrice.toLocaleString('en-IN')}</span>`;
            } else {
                priceEl.innerHTML = `₹${price.toLocaleString('en-IN')}`;
            }
        }

        let currentPhotos = variant.photos ? [...variant.photos] : [];

        if (variant.color_images) {
            const mapping = parseColorImages(variant.color_images);
            const matchedImgs = mapping[selectedHex.toLowerCase()] || mapping[selectedHex.replace('#','').toLowerCase()] || "";
            if (matchedImgs) {
                // Split multi-images (the user can now upload many for one color)
                const specificPhotos = matchedImgs.split(',').map(img => img.trim()).filter(Boolean);
                if (specificPhotos.length > 0) {
                    currentPhotos = specificPhotos;
                }
            }
        }
        
        // Update gallery thumbnails
        updateGallery(currentPhotos);

        const cartBtn = document.getElementById('productAddToCartBtn');
        if (cartBtn) cartBtn.setAttribute('data-variant-id', variant.id);
    }

    /** Color Conversion & Filter Math Helpers */
    function rgbToHsl(r, g, b) {
        r /= 255; g /= 255; b /= 255;
        const max = Math.max(r, g, b), min = Math.min(r, g, b);
        let h, s, l = (max + min) / 2;
        if (max === min) { h = s = 0; } else {
            const d = max - min;
            // Adjust saturation calculation for better red handling
            s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
            switch (max) {
                case r: h = (g - b) / d + (g < b ? 6 : 0); break;
                case g: h = (b - r) / d + 2; break;
                case b: h = (r - g) / d + 4; break;
            }
            h /= 6;
        }
        return { h: h * 360, s: s * 100, l: l * 100 };
    }

    function calculateColorShiftFilter(sourceRGB, targetRGB) {
        if (!sourceRGB || !targetRGB) return '';
        const s = rgbToHsl(sourceRGB.r, sourceRGB.g, sourceRGB.b);
        const t = rgbToHsl(targetRGB.r, targetRGB.g, targetRGB.b);
        
        const hShift = Math.round((t.h - s.h + 360) % 360);
        
        // Strict Clamping to prevent "Ghosting" (Extreme brightness/saturation)
        const sRatio = Math.min(Math.max((t.s + 10) / (s.s + 10), 0.5), 1.8);
        const lRatio = Math.min(Math.max((t.l + 10) / (s.l + 10), 0.6), 1.5);
        
        return `hue-rotate(${hShift}deg) saturate(${Math.round(sRatio * 100)}%) brightness(${Math.round(lRatio * 100)}%)`;
    }

    // Predictive Pre-loader for Initial Size
    window.addEventListener('load', () => {
        if (typeof currentSize !== 'undefined' && currentSize) {
            const colors = Object.keys(groupedVariants[currentSize] || {});
            colors.forEach(c => {
                 const v = (groupedVariants[currentSize] || {})[c];
                 if (v && v.first_photo && v.color_hex) {
                     getDominantRGB(v.first_photo).then(rgb => {
                         const target = hexToRGB(v.color_hex);
                         if (rgb && target) canvasRecolorImage(v.first_photo, v.color_hex, rgb, target);
                     });
                 }
            });
        }
    });

    // Initialize swatch colors on page load
    // Priority: admin hex > image extraction fallback
    window.addEventListener('load', () => {
        document.querySelectorAll('.product-color').forEach(div => {
            const adminHex = div.getAttribute('data-color-hex');
            if (!adminHex || adminHex === '#f3f3f3' || adminHex === '') {
                // No admin color set — try extracting from image
                extractDominantColor(div.getAttribute('data-image'), div);
            }
            // else: admin hex already set via style in PHP — no action needed
        });
    });

    function updateGallery(photos) {
        galleryPhotos = photos;
        const row = document.getElementById('productThumbRow');
        const mainImage = document.getElementById('productDetailImage');
        if (!row) return;

        row.innerHTML = '';
        if (photos.length > 0) {
            const firstPhotoUrl = getImageUrl(photos[0]);
            mainImage.src = firstPhotoUrl;
            mainImage.style.filter = '';
            mainImage.style.opacity = '1';

            photos.forEach((p, idx) => {
                const btn = document.createElement('button');
                const url = getImageUrl(p);
                btn.className = 'product-thumb' + (idx === 0 ? ' is-active' : '');
                btn.type = 'button';
                btn.onclick = () => changeMainImage(url, btn);
                
                const img = document.createElement('img');
                img.src = url;
                img.alt = 'Thumbnail';
                img.style.filter = ''; 
                
                btn.appendChild(img);
                row.appendChild(btn);
            });
        }
    }

    function changeMainImage(url, thumb) {
        const mainImg = document.getElementById('productDetailImage');
        if (!mainImg) return;

        mainImg.src = url;
        mainImg.style.filter = '';
        mainImg.style.opacity = '1';

        document.querySelectorAll('.product-thumb').forEach(btn => btn.classList.remove('is-active'));
        thumb.classList.add('is-active');
    }

    function getImageUrl(path) {
        if (!path) return '';

        // 1. Handle nested / absolute URLs
        if (path.includes('http', 8)) {
            path = path.substring(path.lastIndexOf('http'));
        }

        // 2. Remove ANY full URL prefixes for our known local/demo domains
        path = path.replace(/^https?:\/\/(you\.oceansoftwares\.in|127\.0\.0\.1|localhost|youleggings\.com)(:\d+)?(\/demo)?(\/public)?\//, '');

        // 3. Remove common relative prefixes to get just the filename
        path = path.replace(/^(public\/|uploads\/|photos\/|storage\/)+/g, '');

        // 4. If it's still a full URL, it's external
        if (path.startsWith('http')) return path;

        // 5. Build relative to origin. 
        // Try to guess if it's in Products/ or photos/
        let prefix = '/uploads/photos/';
        if (path.startsWith('Products/')) prefix = '/uploads/';
        
        // Handle potential demo/public prefixes if present in current URL
        let baseUrl = window.location.origin;
        if (window.location.pathname.includes('/demo/public/')) {
            baseUrl += '/demo/public';
        }
        
        return baseUrl + prefix + path;
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
        // No need to set border bottom color anymore, using pills
    }

    function toggleReviewForm() {
        const form = document.getElementById('reviewForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
        if (form.style.display === 'block') {
            form.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    // Star Rating Interaction
    document.querySelectorAll('.star-label').forEach((star, index, stars) => {
        star.addEventListener('mouseover', () => {
            stars.forEach((s, idx) => {
                if (idx >= index) s.style.color = '#f59e0b';
                else s.style.color = '#cbd5e1';
            });
        });
        star.addEventListener('mouseout', () => {
            const checkedId = document.querySelector('input[name="rate"]:checked')?.id;
            const checkedIndex = checkedId ? Array.from(stars).reverse().findIndex(s => s.getAttribute('for') === checkedId) : -1;
            stars.forEach((s, idx) => {
                if (checkedIndex !== -1 && idx >= (4 - checkedIndex)) s.style.color = '#f59e0b';
                else s.style.color = '#cbd5e1';
            });
        });
        star.addEventListener('click', () => {
            // Handled by radio input, but update colors
            stars.forEach((s, idx) => {
                if (idx >= index) s.style.color = '#f59e0b';
                else s.style.color = '#cbd5e1';
            });
        });
    });

    // Initialize stars color based on default checked (5)
    window.addEventListener('load', () => {
        document.querySelectorAll('.star-label').forEach(s => s.style.color = '#f59e0b');
    });
</script>
<style>
    .product-tab-btn {
        padding: 10px 25px; 
        border: 1px solid #f0dbe4; 
        background: #fff; 
        font-weight: 700; 
        cursor: pointer; 
        color: #777; 
        border-radius: 30px; 
        transition: all 0.3s; 
        font-size: 13px; 
        letter-spacing: 1px;
    }
    .product-tab-btn.is-active {
        background: #cf2e6d !important;
        color: #fff !important;
        border-color: #cf2e6d !important;
        box-shadow: 0 4px 15px rgba(207, 46, 109, 0.3);
    }
    .product-color.is-active {
        border-color: var(--primary-color) !important;
        transform: scale(1.1);
    }
    .rating-input .star-label:hover ~ .star-label {
        color: #f59e0b !important;
    }
    .rating-input input:checked ~ label {
        color: #f59e0b !important;
    }
</style>
<script>
  // -- Wishlist Logic --
  function toggleWishlist(event, productId) {
      event.preventDefault();
      const btn = event.currentTarget;
      const svg = btn.querySelector('svg');
      const isCurrentlyWishlisted = svg && (svg.getAttribute('fill') === '#ec407a' || svg.getAttribute('fill') === 'rgb(236, 64, 122)' || svg.getAttribute('fill') === 'currentColor');
      
      const endpoint = isCurrentlyWishlisted ? "{{ route('wishlist.remove') }}" : "{{ route('wishlist.add') }}";
      
      fetch(endpoint, {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ product_id: productId })
      })
      .then(response => {
          if(response.redirected) {
              window.location.href = response.url;
              return null;
          }
          return response.json().catch(() => ({ status: 'success' })); // fallback if remove returns back()
      })
      .then(data => {
          if (!data) return; // redirected
          
          if(data.status === 'success' || data.status === 'info' || !data.status) {
              // Update button UI
              if(isCurrentlyWishlisted) {
                  btn.style.color = '#888';
                  if (svg) {
                      svg.setAttribute('fill', 'none');
                      svg.setAttribute('stroke', '#888');
                  }
                  window.showToast?.('Removed from wishlist', 'info');
              } else {
                  btn.style.color = '#ec407a';
                  if (svg) {
                      svg.setAttribute('fill', '#ec407a');
                      svg.setAttribute('stroke', '#ec407a');
                  }
                  window.showToast?.('Added to wishlist', 'success');
              }
              
              // Try to update badge counter in header
              const badge = document.getElementById('wishlistCountBadge');
              if (badge) {
                  let count = parseInt(badge.innerText) || 0;
                  count = isCurrentlyWishlisted ? Math.max(0, count - 1) : count + 1;
                  badge.innerText = count;
                  if (count > 0) {
                      badge.classList.add('has-items');
                  } else {
                      badge.classList.remove('has-items');
                  }
              }
          } else {
              alert(data.msg);
              if(data.msg && data.msg.includes('login')) {
                  window.location.href = "{{ route('login_user') }}";
              }
          }
      })
      .catch(error => console.error('Error:', error));
  }
</script>
@endsection

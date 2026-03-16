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
          <p class="product-detail-meta" style="color: #6b5a63;">Sizes {{ !empty($allSizes) ? $allSizes[0] . ' - ' . end($allSizes) : '' }}</p>
          <div class="product-detail-price" id="productDetailPrice" style="color: var(--primary-color);">₹{{ number_format($defaultVariant['price'] ?? 0) }}</div>
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

          <div class="product-detail-actions compact-actions" style="margin-top: 20px; display: flex; gap: 15px;">
            <button id="productAddToCartBtn" type="button" class="btn" style="background: #333; color: #fff; flex: 1; padding: 18px; font-weight: 700; letter-spacing: 2px;">ADD TO CART</button>
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
        document.getElementById('productDetailPrice').innerText = '₹' + Number(variant.price).toLocaleString();

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

        // 1. Handle nested URLs
        if (path.includes('http', 8)) {
            path = path.substring(path.indexOf('http', 8));
        }

        // 2. Remove ANY full URL prefixes for our known local/demo domains
        path = path.replace(/^https?:\/\/(you\.oceansoftwares\.in|127\.0\.0\.1|localhost)(:\d+)?(\/demo)?(\/public)?\//, '');

        // 3. Remove common relative prefixes to get just the filename
        path = path.replace(/^(public\/|uploads\/|photos\/|storage\/)+/g, '');

        // 4. If it's still a full URL, it's external
        if (path.startsWith('http')) return path;

        // 5. Rebuild with origin. Try to guess the folder.
        // We'll use a relative path from the domain root or try to preserve context.
        // Most reliable for this project's structure:
        return window.location.origin + '/demo/public/uploads/photos/' + path;
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

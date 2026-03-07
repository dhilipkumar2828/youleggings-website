  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-col">
          <a href="{{ route('index') }}" class="logo">
            <img src="{{ asset('storage/' . ($settings->logo ?? '')) }}" 
                 onerror="this.src='{{ asset('frontend/images/logo-new.png') }}'" 
                 alt="{{ $settings->title ?? 'You Leggings Logo' }}">
          </a>
          <p style="line-height: 1.8; margin-bottom: 20px; color: #999;">
            {{ $settings->footer_description ?? 'Premium quality leggings designed for the modern woman. Experience the perfect fit that moves with you every day.' }}
          </p>
          <div class="social-icons">
            <a href="{{ $settings->facebook_link ?? '#' }}" class="social-icon"><i data-lucide="facebook"></i></a>
            <a href="{{ $settings->instagram_link ?? '#' }}" class="social-icon"><i data-lucide="instagram"></i></a>
            <a href="{{ $settings->twitter_link ?? '#' }}" class="social-icon"><i data-lucide="twitter"></i></a>
            <a href="{{ $settings->youtube_link ?? '#' }}" class="social-icon"><i data-lucide="youtube"></i></a>
          </div>
        </div>

        <div class="footer-col">
          <h4>Explore</h4>
          <ul>
            <li><a href="{{ route('index') }}">Home</a></li>
            <li><a href="{{ route('about') }}">About Us</a></li>
            <li><a href="{{ route('shop') }}">Shop Collection</a></li>
            <li><a href="{{ route('shop') }}">New Arrivals</a></li>
            <li><a href="{{ route('blog') }}">Style Journal</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4>Support</h4>
          <ul>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Terms & Conditions</a></li>
            <li><a href="#">Shipping Policy</a></li>
            <li><a href="#">Help Center</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4>Contact Us</h4>
          <p style="color: #999; margin-bottom: 15px; display: flex; gap: 10px; align-items: flex-start;">
            <i data-lucide="map-pin" style="width: 20px; height: 20px; flex-shrink: 0; color: var(--primary-color);"></i>
            <span>{!! nl2br(e($settings->address ?? "5/4, Surya Nagar, 2nd Street, Bridgeway Colony Extn,\nTirupur - 641607")) !!}</span>
          </p>
          <p style="color: #999; margin-bottom: 10px; display: flex; gap: 10px; align-items: center;">
            <i data-lucide="phone" style="width: 18px; height: 18px; color: var(--primary-color);"></i>
            <span>{{ $settings->phone ?? '+91 740143 24967' }}</span>
          </p>
          <p style="color: #999; display: flex; gap: 10px; align-items: center;">
            <i data-lucide="mail" style="width: 18px; height: 18px; color: var(--primary-color);"></i>
            <span>{{ $settings->email ?? 'youleggings@gmail.com' }}</span>
          </p>
        </div>
      </div>

      <div class="copyright" style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #333; padding-top: 20px;">
        <div>&copy; {{ date('Y') }} You Leggings. All rights reserved.</div>
        <div style="display: flex; align-items: center; gap: 10px;">
          <span>Designed with Love</span>
          <i data-lucide="credit-card" style="width: 24px;"></i>
        </div>
      </div>
    </div>
  </footer>

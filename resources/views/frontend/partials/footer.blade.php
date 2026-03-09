  <footer class="main-footer">
    <div class="container">
      <div class="footer-grid">
        <!-- Brand / About -->
        <div class="footer-col">
          <a href="{{ route('index') }}" class="footer-logo">
            <img src="{{ image_url($settings->logo ?? '') }}" alt="You Leggings">
          </a>
          <p class="footer-desc">
            Premium quality leggings designed for the modern woman. Experience the perfect fit that moves with you every day.
          </p>
          <div class="footer-socials">
            <a href="{{ $settings->facebook ?? '#' }}" aria-label="Facebook"><i data-lucide="facebook"></i></a>
            <a href="{{ $settings->instagram ?? '#' }}" aria-label="Instagram"><i data-lucide="instagram"></i></a>
            <a href="{{ $settings->twitter ?? '#' }}" aria-label="Twitter"><i data-lucide="twitter"></i></a>
            <a href="{{ $settings->youtube ?? '#' }}" aria-label="YouTube"><i data-lucide="youtube"></i></a>
          </div>
        </div>

        <!-- Explore -->
        <div class="footer-col">
          <h4 class="footer-title">Explore</h4>
          <ul class="footer-links">
            <li><a href="{{ route('index') }}">Home</a></li>
            <li><a href="{{ route('about') }}">About Us</a></li>
            <li><a href="{{ route('shop') }}">Shop Selection</a></li>
            <li><a href="{{ route('shop', ['new-arrivals' => 1]) }}">New Arrivals</a></li>
            <li><a href="{{ route('blog') }}">Style Journal</a></li>
          </ul>
        </div>

        <!-- Support -->
        <div class="footer-col">
          <h4 class="footer-title">Support</h4>
          <ul class="footer-links">
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Terms & Conditions</a></li>
            <li><a href="#">Shipping Policy</a></li>
            <li><a href="#">Help Center</a></li>
          </ul>
        </div>

        <!-- Contact Us -->
        <div class="footer-col">
          <h4 class="footer-title">Contact Us</h4>
          <div class="footer-contact">
            <div class="contact-item">
              <i data-lucide="map-pin"></i>
              <span>{{ $settings->address ?? '5/4, Surya Nagar, 2nd Street, Bridgeway Colony Extn, Tirupur - 641607' }}</span>
            </div>
            <div class="contact-item">
              <i data-lucide="phone"></i>
              <span>+91 {{ $settings->phone ?? '740143 2496' }}</span>
            </div>
            <div class="contact-item">
              <i data-lucide="mail"></i>
              <span>{{ $settings->email ?? 'youleggings@gmail.com' }}</span>
            </div>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <div class="copyright">
          &copy; {{ date('Y') }} You Leggings. All rights reserved.
        </div>
        <div class="footer-bottom-right">
          <span class="designed-by">Designed with Love</span>
          <div class="payment-icons">
             <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal" style="height: 18px;">
             <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa" style="height: 14px;">
             <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard" style="height: 18px;">
          </div>
        </div>
      </div>
    </div>
  </footer>

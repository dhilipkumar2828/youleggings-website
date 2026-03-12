@extends('frontend.layouts.app')

@section('title', 'Sign In | You Leggings')

@section('styles')
<style>
  .login-auth-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    background: #fdfbfb;
    position: relative;
    overflow: hidden;
    padding-top: 120px; /* Clear fixed header */
    padding-bottom: 60px;
  }
  .login-bg-decor {
    position: absolute;
    right: -5%;
    bottom: -10%;
    height: 90%;
    opacity: 0.2;
    z-index: 1;
    pointer-events: none;
    transform: scaleX(-1);
  }
  .login-container {
    max-width: 480px;
    width: 90%;
    margin: 0 auto;
    position: relative;
    z-index: 2;
  }
  .auth-card {
    background: #fff;
    padding: 40px;
    border-radius: 24px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.06);
    border: 1px solid #f0f0f0;
    text-align: center;
  }
  .auth-logo { width: 160px; margin-bottom: 35px; }
  .auth-title { font-family: var(--font-serif, serif); font-size: 32px; color: #333; margin-bottom: 10px; }
  .auth-subtitle { color: #888; font-size: 14px; margin-bottom: 40px; }

  .auth-form-group { margin-bottom: 25px; text-align: left; }
  .auth-label { display: block; font-size: 12px; font-weight: 700; text-transform: uppercase; color: #555; margin-bottom: 8px; letter-spacing: 0.5px; }
  .auth-input {
    width: 100%;
    padding: 15px 20px;
    border: 1px solid #eee;
    border-radius: 12px;
    font-size: 16px;
    background: #fafafa;
    transition: 0.3s;
  }
  .auth-input:focus { border-color: #ec407a; background: #fff; outline: none; box-shadow: 0 5px 15px rgba(236, 64, 122, 0.05); }

  .auth-btn {
    width: 100%;
    background: #333;
    color: #fff;
    border: none;
    padding: 18px;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
    transition: 0.3s;
  }
  .auth-btn:hover { background: #ec407a; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(236, 64, 122, 0.2); }

  .otp-inputs { display: flex; gap: 10px; justify-content: center; margin-bottom: 25px; }
  .otp-digit { width: 50px; height: 60px; text-align: center; font-size: 24px; font-weight: 700; border: 1px solid #eee; border-radius: 12px; background: #fafafa; }
  .otp-digit:focus { border-color: #ec407a; background: #fff; outline: none; }
</style>
@endsection

@section('content')
  <section class="login-auth-page">
    <img src="{{ asset('frontend/images/bg-less/_DSC8659-Photoroom.png') }}" class="login-bg-decor">
    
    <div class="login-container">
      <div class="auth-card" style="padding: 35px 30px;">
        <a href="{{ route('index') }}">
          <img src="{{ asset('frontend/images/logo-new.png') }}" alt="Logo" class="auth-logo" style="margin-bottom: 25px;">
        </a>

        @if(session('error'))
            <div style="background: #ffebee; color: #c62828; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 13px;">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div style="background: #ffebee; color: #c62828; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; text-align: left;">
                <ul style="margin:0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="auth-switch-top">
          <button class="auth-tab is-active" data-target="login">Sign In</button>
          <button class="auth-tab" data-target="register">Register</button>
        </div>

        <!-- Login Panel -->
        <div id="login-panel" class="auth-panel is-active">
            <h2 class="auth-title" style="font-size: 26px;">Welcome Back</h2>
            <p class="auth-subtitle" style="margin-bottom: 20px;">Access your account and orders.</p>
            
            <form action="{{ route('customer.login') }}" method="POST" class="login-form">
                @csrf
                <div class="auth-form-group">
                    <label class="auth-label">Email Address</label>
                    <input type="email" name="email" class="auth-input" placeholder="john@example.com" value="{{ old('email') }}" required>
                </div>
                <div class="auth-form-group">
                    <label class="auth-label">Password</label>
                    <input type="password" name="password" class="auth-input" placeholder="••••••••" required>
                </div>
                <button type="submit" class="auth-btn">Sign In</button>
            </form>
        </div>

        <!-- Register Panel -->
        <div id="register-panel" class="auth-panel">
            <h2 class="auth-title" style="font-size: 26px;">Create Account</h2>
            <p class="auth-subtitle" style="margin-bottom: 20px;">Join us to enjoy premium leggings.</p>

            <form action="{{ route('customer.register') }}" method="POST" class="login-form">
                @csrf
                <div class="auth-form-group">
                    <label class="auth-label">Full Name</label>
                    <input type="text" name="name" class="auth-input" placeholder="John Doe" value="{{ old('name') }}" required>
                </div>
                <div class="auth-form-group">
                    <label class="auth-label">Email Address</label>
                    <input type="email" name="email" class="auth-input" placeholder="john@example.com" value="{{ old('email') }}" required>
                </div>
                <div class="auth-form-group">
                    <label class="auth-label">Phone Number</label>
                    <input type="text" name="phone_number" class="auth-input" placeholder="+91 000 000 0000" value="{{ old('phone_number') }}">
                </div>
                <div class="auth-form-group">
                    <label class="auth-label">Password</label>
                    <input type="password" name="password" class="auth-input" placeholder="••••••••" required>
                </div>
                <button type="submit" class="auth-btn">Register</button>
            </form>
        </div>

        <p style="margin-top: 30px; font-size: 11px; color: #ccc; text-transform: uppercase; letter-spacing: 1px;">
          Premium Leggings Since 2024
        </p>
      </div>
    </div>
  </section>
@endsection

@section('scripts')
<script>
  const authTabs = document.querySelectorAll('.auth-tab');
  const authPanels = document.querySelectorAll('.auth-panel');
  
  authTabs.forEach(tab => {
    tab.addEventListener('click', () => {
      // If we are showing validation errors, standard tab logic is fine, 
      // but you could add backend persistence for which tab was active if needed.
      authTabs.forEach(t => t.classList.remove('is-active'));
      tab.classList.add('is-active');
      
      authPanels.forEach(p => p.classList.remove('is-active'));
      document.getElementById(`${tab.dataset.target}-panel`).classList.add('is-active');
    });
  });

  // Check if URL hash is #register to open register tab directly
  if (window.location.hash === '#register') {
      document.querySelector('[data-target="register"]').click();
  }
</script>
@endsection


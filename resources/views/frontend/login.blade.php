@extends('frontend.layouts.app')

@section('title', 'Sign In | You Leggings')

@section('content')
  <section class="section page-view login-page" style="display: block;">
    <div class="container page-body" style="padding-top: 100px; padding-bottom: 100px;">
      <div class="login-wrap">
        <div class="login-card" style="max-width: 400px; margin: 0 auto; background: #fff; padding: 40px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #f0dbe4; text-align: center;">
          <a href="{{ route('index') }}" class="login-logo">
            <img src="{{ asset('frontend/images/logo-new.png') }}" alt="You Leggings Logo" style="width: 140px; margin-bottom: 20px;">
          </a>
          <h2 style="font-size: 24px; color: #5d3f4c; margin-bottom: 30px;">Sign In</h2>
          
          <form id="loginForm">
            <div id="phoneInputGroup">
              <label style="display: block; text-align: left; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Mobile Number</label>
              <input type="tel" id="login-mobile" placeholder="+91 98765 43210" maxlength="10" style="width: 100%; padding: 12px; border: 1px solid #eee; border-radius: 8px; margin-bottom: 20px;">
              <button class="btn" type="button" id="sendOtpBtn" style="width: 100%;">Send OTP</button>
            </div>
            
            <div id="otpInputGroup" style="display: none; margin-top: 20px;">
               <label style="display: block; text-align: left; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Enter OTP</label>
               <input type="text" id="login-otp" placeholder="123456" maxlength="6" style="width: 100%; padding: 12px; border: 1px solid #eee; border-radius: 8px; margin-bottom: 20px;">
               <button class="btn" type="submit" style="width: 100%;">Verify & Login</button>
            </div>
          </form>
          
          <p style="margin-top: 20px; font-size: 12px; color: #999;">By continuing, you agree to our Terms & Conditions.</p>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('scripts')
<script>
    const sendOtpBtn = document.getElementById('sendOtpBtn');
    const otpGroup = document.getElementById('otpInputGroup');
    const phoneGroup = document.getElementById('phoneInputGroup');
    const loginForm = document.getElementById('loginForm');
    
    sendOtpBtn.addEventListener('click', () => {
        const phone = document.getElementById('login-mobile').value;
        if(phone.length === 10) {
            phoneGroup.style.display = 'none';
            otpGroup.style.display = 'block';
            window.showToast('OTP sent! (Use 123456 for demo)', 'info');
        } else {
            window.showToast('Please enter a 10-digit mobile number.', 'error');
        }
    });
    
    loginForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const otp = document.getElementById('login-otp').value;
        if(otp === '123456') {
            window.showToast('Login successful!', 'success');
            setTimeout(() => {
                window.location.href = "{{ route('index') }}";
            }, 1000);
        } else {
            window.showToast('Invalid OTP. Use 123456.', 'error');
        }
    });
</script>
@endsection

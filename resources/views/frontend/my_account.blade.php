@extends('frontend.layouts.app')

@section('title', 'My Account | You Leggings')

@section('styles')
<style>
<style>
  .account-container { padding-top: 160px; padding-bottom: 100px; background: #fdfbfb; }
  .account-card { background: #fff; border-radius: 20px; box-shadow: 0 10px 50px rgba(0,0,0,0.03); border: 1px solid #f0f0f0; overflow: hidden; display: flex; min-height: 600px; }
  @media (max-width: 991px) { .account-card { flex-direction: column; } }

  .account-main { flex: 1; padding: 50px; }
  @media (max-width: 575px) { .account-main { padding: 25px; } }

  .panel-title { font-family: var(--font-serif, serif); font-size: 28px; margin-bottom: 30px; border-bottom: 1px solid #f8f8f8; padding-bottom: 20px; }
  .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px; }
  .stat-box { background: #fffafb; border: 1px solid #fdeef2; padding: 25px; border-radius: 16px; text-align: center; }
  .stat-val { display: block; font-size: 24px; font-weight: 800; color: #ec407a; margin-bottom: 5px; }
  .stat-label { font-size: 12px; font-weight: 700; color: #a18a91; text-transform: uppercase; letter-spacing: 1px; }

  /* Table Style */
  .custom-table { width: 100%; border-collapse: collapse; }
  .custom-table th { text-align: left; padding: 15px; font-size: 13px; color: #999; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #f0f0f0; }
  .custom-table td { padding: 20px 15px; font-size: 14px; border-bottom: 1px solid #f8f8f8; }
  .status-badge { padding: 4px 12px; border-radius: 50px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
  .status-pending { background: #fff8e1; color: #f57f17; }
  .status-shipped { background: #e8f5e9; color: #2e7d32; }

  .address-card { border: 1px solid #eee; padding: 25px; border-radius: 16px; position: relative; }
  .address-card h4 { font-size: 16px; margin-bottom: 15px; }
  .address-card p { font-size: 14px; color: #777; line-height: 1.6; margin: 0; }
  .edit-btn { position: absolute; top: 20px; right: 20px; color: #ec407a; font-size: 12px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 5px; }
</style>
@endsection

@section('content')
  <section class="account-container">
    <div class="container">
      @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show mb-4 rounded-4 border-0 shadow-sm" style="background:#e8f5e9; color:#2e7d32; padding:15px 20px;">
              <strong>Success!</strong> {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      @endif
      @if($errors->any())
          <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-4 border-0 shadow-sm" style="background:#ffebee; color:#c62828; padding:15px 20px;">
              <ul class="mb-0">
                  @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      @endif
      <div class="account-card">
        
        @include('frontend.partials.account_sidebar')

        <main class="account-main">
          
          <!-- Dashboard -->
          <div id="dashboard-panel" class="tab-panel active">
            <h2 class="panel-title">Welcome back, {{ explode(' ', Auth::user()->name ?? 'Friend')[0] }}!</h2>
            <div class="stats-grid">
              <div class="stat-box" st>
                <span class="stat-val">{{ count($orders) }}</span>
                <span class="stat-label">Total Orders</span>
              </div>
              <div class="stat-box">
                <span class="stat-val">{{ $wishlist_count ?? 0 }}</span>
                <span class="stat-label">Wishlist</span>
              </div>
             
            </div>
            
            <div style="background: #fafafa; padding: 30px; border-radius: 16px;">
                <h4 style="margin-bottom: 10px;">Account Summary</h4>
                <p style="color: #666; font-size: 14px; line-height: 1.6;">From your account dashboard you can easily check & view your <a href="#" style="color:#ec407a">recent orders</a>, manage your shipping and billing addresses and edit your password and account details.</p>
            </div>
          </div>



          <div id="settings-panel" class="tab-panel" style="display:none;">
            <h2 class="panel-title">Profile Settings</h2>
            <form action="{{ route('account_update') }}" method="POST" class="validate">
              @csrf
              <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                  <label style="display:block; font-size:12px; font-weight:700; color:#999; margin-bottom:8px; text-transform:uppercase;">Full Name</label>
                  <input type="text" name="name" class="form-control" style="width:100%; padding:12px; border:1px solid #eee; border-radius:8px;" value="{{ Auth::user()->name ?? '' }}" required alphabetsOnly>
                </div>
                <div class="form-group">
                  <label style="display:block; font-size:12px; font-weight:700; color:#999; margin-bottom:8px; text-transform:uppercase;">Email Address</label>
                  <input type="email" class="form-control" style="width:100%; padding:12px; border:1px solid #eee; border-radius:8px; background: #f8f8f8;" value="{{ Auth::user()->email ?? '' }}" readonly>
                </div>
                <div class="form-group">
                  <label style="display:block; font-size:12px; font-weight:700; color:#999; margin-bottom:8px; text-transform:uppercase;">Phone Number</label>
                  <input type="text" name="phone" class="form-control" style="width:100%; padding:12px; border:1px solid #eee; border-radius:8px;" value="{{ Auth::user()->phone ?? '' }}" phoneIndia maxlength="10">
                </div>
              </div>

              <div style="margin-top: 40px; border-top: 1px dashed #eee; padding-top: 40px;">
                <h4 style="font-family: var(--font-serif, serif); font-size: 20px; margin-bottom: 20px;">Change Password</h4>
                <p style="color: #888; font-size: 13px; margin-bottom: 20px;">Leave these fields blank if you don't want to change your password.</p>
                
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                  <div class="form-group">
                    <label style="display:block; font-size:12px; font-weight:700; color:#999; margin-bottom:8px; text-transform:uppercase;">New Password</label>
                    <input type="password" name="password" class="form-control" style="width:100%; padding:12px; border:1px solid #eee; border-radius:8px;" placeholder="Leave blank to keep current">
                  </div>
                  <div class="form-group">
                    <label style="display:block; font-size:12px; font-weight:700; color:#999; margin-bottom:8px; text-transform:uppercase;">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" style="width:100%; padding:12px; border:1px solid #eee; border-radius:8px;" placeholder="Confirm your new password">
                  </div>
                </div>
              </div>

              <button type="submit" class="btn" style="margin-top:30px; background:#ec407a; color:#fff; padding: 12px 40px; border-radius:50px; border:none; font-weight:700;">Save Changes</button>
            </form>
          </div>

        </main>

      </div>
    </div>
  </section>
@endsection

@section('scripts')
<script>
    const navItems = document.querySelectorAll('.nav-item');
    const panels = document.querySelectorAll('.tab-panel');

    function switchTab(tab) {
        if(!tab) return;
        
        navItems.forEach(i => {
            if(i.getAttribute('data-tab') === tab) {
                i.classList.add('active');
            } else if (i.getAttribute('data-tab')) {
                i.classList.remove('active');
            }
        });

        panels.forEach(p => {
            p.style.display = 'none';
            if(p.id === `${tab}-panel`) p.style.display = 'block';
        });
    }

    navItems.forEach(item => {
        item.addEventListener('click', () => {
            const tab = item.getAttribute('data-tab');
            switchTab(tab);
        });
    });

    // Handle session storage for opening settings
    window.addEventListener('load', () => {
        if(sessionStorage.getItem('openSettingsTab')) {
            sessionStorage.removeItem('openSettingsTab');
            switchTab('settings');
        }
    });
</script>
@endsection

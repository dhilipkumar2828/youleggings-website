<style>
  .account-container { padding-top: 160px; padding-bottom: 100px; background: #fdfbfb; }
  .account-card { background: #fff; border-radius: 20px; box-shadow: 0 10px 50px rgba(0,0,0,0.03); border: 1px solid #f0f0f0; overflow: hidden; display: flex; min-height: 600px; }
  @media (max-width: 991px) { .account-card { flex-direction: column; }
 .account-container { padding-top: 70px; padding-bottom: 100px; background: #fdfbfb; } }

  .account-sidebar { width: 280px; background: #fafafa; padding: 40px 20px; border-right: 1px solid #f0f0f0; }
  @media (max-width: 991px) { .account-sidebar { width: 100%; border-right: none; border-bottom: 1px solid #f0f0f0; padding: 20px; } }

  .profile_brief { text-align: center; margin-bottom: 40px; }
  .profile_avatar { width: 80px; height: 80px; background: #ec407a; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 700; margin: 0 auto 15px; box-shadow: 0 10px 20px rgba(236, 64, 122, 0.2); }
  .profile_name { font-family: var(--font-serif, serif); font-size: 20px; margin: 0; }
  .profile_email { font-size: 13px; color: #999; }

  .account-nav { display: grid; gap: 8px; }
  .nav-item { padding: 14px 20px; border-radius: 12px; display: flex; align-items: center; gap: 12px; color: #666; font-weight: 600; font-size: 14px; cursor: pointer; transition: 0.3s; }
  .nav-item:hover { background: #fff; color: #ec407a; }
  .nav-item.active { background: #fff; color: #ec407a; box-shadow: 0 5px 15px rgba(0,0,0,0.02); }
  .nav-item i { width: 18px; }

  .account-main { flex: 1; padding: 50px; }
  @media (max-width: 575px) { .account-main { padding: 25px; } }
</style>

<aside class="account-sidebar">
  <div class="profile_brief">
    <div class="profile_avatar">
      {{ substr(Auth::user()->name ?? 'G', 0, 1) }}
    </div>
    <h4 class="profile_name">{{ Auth::user()->name ?? 'Guest User' }}</h4>
    <p class="profile_email">{{ Auth::user()->email ?? '' }}</p>
  </div>

  <nav class="account-nav">
    @if(request()->routeIs('my_account'))
        <div class="nav-item active" data-tab="dashboard"><i data-lucide="layout-dashboard"></i> Dashboard</div>
    @else
        <a href="{{ route('my_account') }}" style="text-decoration:none;">
            <div class="nav-item"><i data-lucide="layout-dashboard"></i> Dashboard</div>
        </a>
    @endif
    
    <a href="{{ route('my_orders') }}" style="text-decoration:none;">
      <div class="nav-item {{ request()->routeIs('my_orders') ? 'active' : '' }}"><i data-lucide="shopping-bag"></i> My Orders</div>
    </a>
    
    <a href="{{ route('my_addresses') }}" style="text-decoration:none;">
      <div class="nav-item {{ request()->routeIs('my_addresses') ? 'active' : '' }}"><i data-lucide="map-pin"></i> Addresses</div>
    </a>
    
    @if(request()->routeIs('my_account'))
        <div class="nav-item" data-tab="settings"><i data-lucide="settings"></i> Profile Settings</div>
    @else
        <a href="{{ route('my_account') }}" style="text-decoration:none;" id="settingsLink">
          <div class="nav-item"><i data-lucide="settings"></i> Profile Settings</div>
        </a>
        <script>
            document.getElementById('settingsLink').addEventListener('click', function(e) {
                e.preventDefault();
                sessionStorage.setItem('openSettingsTab', 'true');
                window.location.href = this.href;
            });
        </script>
    @endif
    
    <form action="{{ route('logout') }}" method="POST" style="margin-top: 20px;">
      @csrf
      <button type="submit" style="background:none; border:none; width:100%; text-align:left; padding:0;">
        <div class="nav-item" style="color: #ff5e5e;"><i data-lucide="log-out"></i> Logout</div>
      </button>
    </form>
  </nav>
</aside>

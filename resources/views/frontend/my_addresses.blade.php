@extends('frontend.layouts.app')

@section('title', 'My Addresses | You Leggings')

@section('styles')
<style>
  .addresses-wrapper { padding: 160px 0 100px; background: #fdfbfb; min-height: 100vh; }
  .page-header { margin-bottom: 40px; }
  .page-header h1 { font-family: var(--font-serif, serif); font-size: 36px; color: #222; }
  .page-header p { color: #888; }
  .address-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 25px; }
  .address-card { background: #fff; border-radius: 16px; border: 1px solid #f0f0f0; padding: 30px; position: relative; box-shadow: 0 5px 20px rgba(0,0,0,0.03); transition: 0.3s; }
  .address-card:hover { box-shadow: 0 10px 35px rgba(0,0,0,0.07); transform: translateY(-2px); }
  .address-card h4 { font-family: var(--font-serif, serif); font-size: 20px; margin-bottom: 15px; color: #222; }
  .address-card p { font-size: 14px; color: #666; line-height: 1.8; margin-bottom: 20px; }
  .address-card .meta { font-size: 13px; color: #999; display: flex; align-items: center; gap: 8px; }
  .btn-add { background: #ec407a; color: #fff; padding: 12px 30px; border-radius: 50px; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 30px; border: none; transition: 0.3s; }
  .btn-add:hover { background: #d81b60; color: #fff; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(236, 64, 122, 0.3); }
  .empty-state { text-align: center; padding: 80px 20px; background: #fff; border-radius: 16px; border: 1px solid #f0f0f0; }

  /* New Styles */
  .default-badge { position: absolute; top: 20px; right: 20px; background: #e8f5e9; color: #2e7d32; font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 50px; text-transform: uppercase; letter-spacing: 0.5px; }
  .address-actions { display: flex; gap: 10px; margin-top: 25px; border-top: 1px solid #f8f8f8; padding-top: 20px; }
  .action-btn { font-size: 12px; font-weight: 700; color: #999; cursor: pointer; display: flex; align-items: center; gap: 5px; text-decoration: none; transition: 0.2s; background: none; border: none; padding: 0; }
  .action-btn:hover { color: #ec407a; }
  .action-btn.delete:hover { color: #ff5e5e; }
  .action-btn.default-btn:hover { color: #4caf50; }

  /* Modal */
  .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 9999; backdrop-filter: blur(5px); }
  .modal-content { background: #fff; width: 700px; max-width: 95%; border-radius: 20px; padding: 35px; position: relative; max-height: 90vh; overflow-y: auto; box-shadow: 0 25px 50px rgba(0,0,0,0.1); }
  
  /* Force side-by-side layout */
  .modal-content .row { display: flex; flex-wrap: wrap; margin-right: -10px; margin-left: -10px; }
  .modal-content .col-6 { width: 50%; padding: 0 10px; flex: 0 0 auto; }
  .modal-content .col-4 { width: 33.3333%; padding: 0 10px; flex: 0 0 auto; }
  .modal-content .col-12 { width: 100%; padding: 0 10px; flex: 0 0 auto; }
  .modal-content .g-3 { gap: 0; } /* We handle gap with padding above */
  .modal-content .form-group { margin-bottom: 15px; }

  /* Form Inputs Compact Style */
  .modal-content .form-label { margin-bottom: 6px; font-size: 10px; letter-spacing: 0.5px; color: #a18a91; display: block; font-weight: 700; text-transform: uppercase; }
  .modal-content .form-control { border: 1px solid #f0f0f0; padding: 10px 15px; height: auto; font-size: 14px; color: #222; background: #fafafa; border-radius: 10px !important; transition: all 0.2s; box-shadow: none; font-weight: 500; width: 100%; }
  .modal-content .form-control:focus { background: #fff; border-color: #ec407a; box-shadow: 0 0 0 3px rgba(236, 64, 122, 0.1); outline: none; }
  .modal-content textarea.form-control { min-height: 70px; resize: vertical; }
</style>
@endsection

@section('content')
<section class="addresses-wrapper">
  <div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 rounded-4 border-0 shadow-sm" style="background:#e8f5e9; color:#2e7d32; padding:15px 20px;">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">
      <div>
        <h1>My Addresses</h1>
        <p>Manage your saved shipping addresses for faster checkout</p>
      </div>
      <a href="{{ route('checkout') }}" class="btn-add">
        <i class="fas fa-plus"></i> Use at Checkout
      </a>
    </div>

    @if(count($addresses) > 0)
      <div class="address-grid">
        @foreach($addresses as $addr)
          <div class="address-card">
            @if($addr->is_default)
              <span class="default-badge">DEFAULT</span>
            @endif
            <h4>{{ $addr->sfirst_name }} {{ $addr->slast_name }}</h4>
            <p>
              {{ $addr->saddress }}<br>
              {{ $addr->scity }}, {{ $addr->sstate }} - {{ $addr->spincode }}<br>
              India
            </p>
            <div class="meta">
              <i class="fas fa-phone-alt" style="color:#ec407a;"></i> {{ $addr->sphone_number }}
            </div>
            
            <div class="address-actions">
              <button class="action-btn" onclick="openEditModal({{ json_encode($addr) }})">
                <i class="fas fa-edit"></i> EDIT
              </button>
              @if(!$addr->is_default)
                <a href="{{ route('address.set_default', $addr->id) }}" class="action-btn default-btn">
                  <i class="fas fa-check-circle"></i> SET AS DEFAULT
                </a>
              @endif
              <a href="{{ route('address.delete', $addr->id) }}" class="action-btn delete" onclick="return confirm('Are you sure you want to delete this address?')">
                <i class="fas fa-trash"></i> DELETE
              </a>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="empty-state">
        <div style="font-size: 60px; margin-bottom: 20px;">🏠</div>
        <h3 style="font-family: var(--font-serif, serif); font-size: 28px; margin-bottom: 10px;">No Addresses Saved</h3>
        <p style="color: #888; margin-bottom: 30px;">You haven't saved any addresses yet. They will be saved automatically when you place an order.</p>
        <a href="{{ route('shop') }}" style="background: #ec407a; color: #fff; padding: 15px 40px; border-radius: 50px; text-decoration: none; font-weight: 700; display: inline-block;">
          Start Shopping
        </a>
      </div>
    @endif
  </div>
</section>

<!-- Edit Modal -->
<div class="modal-overlay" id="editModal">
    <div class="modal-content">
        <h2 style="font-family: var(--font-serif, serif); margin-bottom: 30px;">Edit Address</h2>
        <form action="{{ route('address.update') }}" method="POST" class="validate">
            @csrf
            <input type="hidden" name="address_id" id="edit_id">
            <div class="row g-3">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">First Name</label>
                        <input type="text" name="sfirst_name" id="edit_first" class="form-control" required alphabetsOnly>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="slast_name" id="edit_last" class="form-control" required alphabetsOnly>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="semail" id="edit_email" class="form-control" required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="sphone_number" id="edit_phone" class="form-control" required phoneIndia maxlength="10">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">Complete Address</label>
                        <textarea name="saddress" id="edit_address" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label class="form-label">City</label>
                        <input type="text" name="scity" id="edit_city" class="form-control" required alphabetsOnly>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label class="form-label">State</label>
                        <input type="text" name="sstate" id="edit_state" class="form-control" required alphabetsOnly>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label class="form-label">Pincode</label>
                        <input type="text" name="spincode" id="edit_pincode" class="form-control" required pincodeIndia maxlength="6">
                    </div>
                </div>
            </div>
            <div class="mt-5 d-flex gap-3">
                <button type="submit" class="btn" style="background:#ec407a; color:#fff; padding: 14px 45px; border-radius:50px; border:none; font-weight:700; font-size:14px; transition:0.3s;">Save Changes</button>
                <button type="button" onclick="closeEditModal()" class="btn" style="background:#f5f5f5; color:#666; padding: 14px 35px; border-radius:50px; border:none; font-weight:700; font-size:14px; transition:0.3s;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(addr) {
    document.getElementById('edit_id').value = addr.id;
    document.getElementById('edit_first').value = addr.sfirst_name;
    document.getElementById('edit_last').value = addr.slast_name;
    document.getElementById('edit_email').value = addr.semail;
    document.getElementById('edit_phone').value = addr.sphone_number;
    document.getElementById('edit_address').value = addr.saddress;
    document.getElementById('edit_city').value = addr.scity;
    document.getElementById('edit_state').value = addr.sstate;
    document.getElementById('edit_pincode').value = addr.spincode;
    document.getElementById('editModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

// Close on click outside
window.onclick = function(event) {
    const modal = document.getElementById('editModal');
    if (event.target == modal) {
        closeEditModal();
    }
}
</script>
@endsection

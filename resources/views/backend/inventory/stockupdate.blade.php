@extends('backend.layouts.master')

@section('content')
    <style>
        .premium-card { border: none; border-radius: 12px; box-shadow: 0 4px 25px rgba(0,0,0,0.06); background: #fff; overflow: hidden; margin-bottom: 25px; }
        .card-header-premium { background: #f8f9fa; border-bottom: 1px solid #eee; padding: 20px 25px; }
        .card-header-premium h4 { margin: 0; font-weight: 700; color: #333; font-size: 1.1rem; }
        .variant-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .variant-table th { background: #fdfdfd; padding: 15px; font-weight: 600; color: #666; font-size: 13px; text-transform: uppercase; border-bottom: 2px solid #f1f1f1; }
        .variant-table td { padding: 15px; vertical-align: middle; border-bottom: 1px solid #f8f8f8; }
        .stock-badge { padding: 6px 12px; border-radius: 6px; font-weight: 700; display: inline-block; min-width: 45px; text-align: center; }
        .stock-low { background: #fff5f5; color: #e53e3e; border: 1px solid #feb2b2; }
        .stock-good { background: #f0fff4; color: #38a169; border: 1px solid #9ae6b4; }
        .log-link { color: #508aeb; font-weight: 600; text-decoration: none; transition: 0.3s; }
        .log-link:hover { color: #2b6cb0; text-decoration: underline; }
        .form-section { background: #fcfcfc; border-radius: 12px; padding: 25px; border: 1px dashed #ddd; }
        .control-label { font-weight: 600; color: #444; margin-bottom: 8px; display: block; }
        .premium-input { border-radius: 8px; border: 1px solid #e2e8f0; padding: 12px 15px; height: auto !important; transition: 0.3s; }
        .premium-input:focus { border-color: #508aeb; box-shadow: 0 0 0 3px rgba(80, 138, 235, 0.1); }
        .btn-save { background: #ed0b80; color: white; padding: 12px 30px; border-radius: 8px; font-weight: 700; border: none; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 15px rgba(237, 11, 128, 0.3); }
        .btn-save:hover { background: #c20968; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(237, 11, 128, 0.4); }
        .product-strip { background: linear-gradient(135deg, #ed0b80 0%, #ff52af 100%); color: white; padding: 30px; border-radius: 12px; margin-bottom: 30px; position: relative; overflow: hidden; }
        .product-strip::after { content: '\f0d1'; font-family: 'FontAwesome'; position: absolute; right: -20px; bottom: -20px; font-size: 150px; opacity: 0.1; }
        .ripple { position: relative; overflow: hidden; }
    </style>

    <div class="page-content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs -->
            <div class="row align-items-center mb-4">
                <div class="col-sm-6">
                    <h5 class="page-title m-0">Inventory Management</h5>
                    <ol class="breadcrumb mt-1 bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">Update Stock</li>
                    </ol>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('product.index') }}" class="btn btn-light px-4 border">
                        <i class="fa fa-chevron-left mr-2"></i> Back to Catalog
                    </a>
                </div>
            </div>

            <!-- Product Header Strip -->
            <div class="product-strip">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <span class="badge badge-light mb-2 px-3 py-2" style="color: #ed0b80; font-weight: 800;">PRODUCT SKU: {{ $productvariant[0]->sku ?? 'N/A' }}</span>
                        <h2 class="m-0" style="font-weight: 800; color: white;">{{ $Product->name }}</h2>
                        <p class="mb-0 mt-2 opacity-80" style="font-size: 1.1rem; color: white;">Manage warehouse levels and stock movement for all variants.</p>
                    </div>
                    <div class="col-md-4 text-md-right mt-3 mt-md-0">
                        <div style="background: rgba(255,255,255,0.2); display: inline-block; padding: 15px 25px; border-radius: 10px; backdrop-filter: blur(5px);">
                            <div style="font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: white;">Overall Stock</div>
                            <div style="font-size: 32px; font-weight: 800; color: white;">{{ $Product->stock }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Variant List -->
                <div class="col-lg-7">
                    <div class="premium-card">
                        <div class="card-header-premium d-flex justify-content-between align-items-center">
                            <h4>Stock Levels per Variant</h4>
                            <span class="text-muted small">Total Variants: {{ count($productvariant) }}</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="variant-table">
                                    <thead>
                                        <tr>
                                            <th>Variant Details</th>
                                            <th class="text-center">Current Stock</th>
                                            <th class="text-right">History</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($productvariant as $v)
                                            <tr>
                                                <td>
                                                    <div style="font-weight: 700; color: #333;">{{ $v->variants }}</div>
                                                    <div class="text-muted small">{{ $v->sku }}</div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="stock-badge {{ $v->in_stock < 10 ? 'stock-low' : 'stock-good' }}">
                                                        {{ $v->in_stock }}
                                                    </span>
                                                </td>
                                                <td class="text-right">
                                                    <a href="{{ route('viewstocklogs', $v->id) }}" target="_blank" class="log-link">
                                                        <i class="fa fa-history mr-1"></i> Logs
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stock Action Form -->
                <div class="col-lg-5">
                    <div class="premium-card">
                        <div class="card-header-premium">
                            <h4>Adjust Stock Levels</h4>
                        </div>
                        <div class="card-body">
                            @include('backend.layouts.notification')
                            
                            <form action="{{ route('updatestockstore') }}" method="POST" id="stockUpdateForm">
                                @csrf
                                <input type="hidden" name="id" value="{{ $Product->id }}">
                                
                                <div class="form-section">
                                    <div class="form-group mb-4">
                                        <label class="control-label">1. Select Target Variant</label>
                                        <select class="form-control premium-input select2" name="v_id" id="v_id">
                                            <option value="">Choose a variant...</option>
                                            @foreach($productvariant as $v)
                                                <option value="{{ $v->id }}" data-stock="{{ $v->in_stock }}">
                                                    {{ $v->variants }} (Current: {{ $v->in_stock }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="control-label">2. Select Operation Type</label>
                                        <div class="row no-gutters">
                                            <div class="col-6 pr-2">
                                                <div class="custom-control custom-radio mb-2">
                                                    <input type="radio" id="opr_add" name="opr" value="add" class="custom-control-input" checked onchange="document.getElementById('opr_value').value='add'">
                                                    <label class="custom-control-label p-2 border rounded w-100 text-center" style="cursor:pointer;" for="opr_add">
                                                        <i class="fa fa-plus-circle text-success mr-1"></i> Add Stock
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6 pl-2">
                                                <div class="custom-control custom-radio mb-2">
                                                    <input type="radio" id="opr_minus" name="opr" value="minus" class="custom-control-input" onchange="document.getElementById('opr_value').value='minus'">
                                                    <label class="custom-control-label p-2 border rounded w-100 text-center" style="cursor:pointer;" for="opr_minus">
                                                        <i class="fa fa-minus-circle text-danger mr-1"></i> Reduce Stock
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="opr" value="add">
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="control-label">3. Transaction Quantity</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white border-right-0" style="border-radius: 8px 0 0 8px;"><i class="fa fa-cubes text-muted"></i></span>
                                            </div>
                                            <input type="number" min="1" class="form-control premium-input" name="stockvalue" id="stockvalue" placeholder="Enter amount..." style="border-left:0;">
                                        </div>
                                    </div>

                                    <button type="button" id="checkstockupdate" class="btn btn-save btn-block mt-2">
                                        <i class="fa fa-save mr-2"></i> Update Inventory
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery.multifield.min.js') }}"></script>
    <script src="{{ asset('public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Sync radio with hidden opr for existing JS logic
        $('input[name="opr"]').change(function() {
            $('#opr').val($(this).val());
        });

        $('#checkstockupdate').click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            var selectedOption = $('#v_id').find(":selected");
            var currentStock = +(selectedOption.attr('data-stock'));
            var stockOpr = $('#opr').val();
            var stockval = +$('#stockvalue').val();

            if ($('#v_id').val() == "") {
                swal("Please select a variant first.");
                return false;
            }

            if (stockval < 1) {
                swal("Please enter a valid quantity greater than 0.");
                return false;
            }

            if (stockOpr == "minus" && stockval > currentStock) {
                swal("Insufficient Stock", "Current stock is " + currentStock + ", but you are trying to reduce " + stockval, "error");
                return false;
            }

            var newstock = (stockOpr == "add") ? (currentStock + stockval) : (currentStock - stockval);

            swal({
                title: "Confirm " + (stockOpr == 'add' ? 'Increase' : 'Decrease'),
                text: "Current: " + currentStock + " | Adjustment: " + (stockOpr == 'add' ? '+' : '-') + stockval + " | Result: " + newstock,
                icon: "info",
                buttons: ["Cancel", "Confirm Update"],
                dangerMode: stockOpr == "minus",
            }).then((confirmed) => {
                if (confirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endsection

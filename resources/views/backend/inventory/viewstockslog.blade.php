@extends('backend.layouts.master')

@section('content')

    <?php
    if (!function_exists('convertUtcToIst')) {
        function convertUtcToIst($utcTime)
        {
            if (!$utcTime) return 'N/A';
            try {
                $utcDateTime = new DateTime($utcTime, new DateTimeZone('UTC'));
                $istDateTime = $utcDateTime->setTimezone(new DateTimeZone('Asia/Kolkata'));
                return $istDateTime->format('d M Y, h:i A');
            } catch (Exception $e) {
                return $utcTime;
            }
        }
    }
    ?>

    <style>
        .premium-card { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden; }
        .stat-card { background: #fff; border-radius: 12px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); text-align: center; height: 100%; transition: transform 0.3s; border: 1px solid #f0f0f0; }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        .stat-icon { font-size: 24px; margin-bottom: 10px; width: 50px; height: 50px; line-height: 50px; border-radius: 50%; margin: 0 auto 15px; }
        .icon-add { background: #e8f5e9; color: #2e7d32; }
        .icon-minus { background: #ffebee; color: #c62828; }
        .icon-stock { background: #e3f2fd; color: #1565c0; }
        .stat-value { font-size: 28px; font-weight: 700; color: #333; }
        .stat-label { font-size: 13px; color: #888; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }
        .badge-add { background: #2e7d32; color: #fff; padding: 6px 12px; border-radius: 6px; font-weight: 600; }
        .badge-minus { background: #c62828; color: #fff; padding: 6px 12px; border-radius: 6px; font-weight: 600; }
        .product-strip { background: linear-gradient(135deg, #ed0b80 0%, #ff52af 100%); color: white; padding: 30px; border-radius: 12px; margin-bottom: 30px; position: relative; overflow: hidden; display: flex; align-items: center; gap: 20px; }
        .product-strip::after { content: '\f0d1'; font-family: 'FontAwesome'; position: absolute; right: -20px; bottom: -20px; font-size: 120px; opacity: 0.1; }
        .product-img { width: 90px; height: 90px; object-fit: cover; border-radius: 12px; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 4px 15px rgba(0,0,0,0.2); z-index: 1; }
        .product-strip-content { z-index: 1; }
    </style>

    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row align-items-center mb-4">
                <div class="col-md-6">
                    <h5 class="page-title m-0">Inventory Control</h5>
                    <ol class="breadcrumb mt-1 bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">Stock Movement Logs</li>
                    </ol>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('updatestockmanually', $Product->id) }}" class="btn btn-light px-4 border">
                        <i class="fa fa-arrow-left mr-2"></i> Back to Inventory
                    </a>
                </div>
            </div>

            <div class="product-strip">
                @php 
                    $photo = explode(',', $productvariant->photo)[0] ?? '';
                    // Use a more robust check for image
                    $imgUrl = image_url($photo);
                    if ($photo && !filter_var($photo, FILTER_VALIDATE_URL) && !file_exists(public_path(ltrim(str_replace('public/', '', $photo), '/')))) {
                        // If it's a relative path but not found, check if it's just a placeholder or needs 'storage/'
                        if (strpos($photo, 'storage/') === false && strpos($photo, 'photos/') === false && strpos($photo, 'uploads/') === false) {
                             $imgUrl = asset('frontend/images/logo-new.png'); // Default fallback
                        }
                    }

                    // Robust stats calculation
                    $totalIn = $data->filter(function($q){ 
                        $op = strtoupper(trim($q->opr));
                        return in_array($op, ['ADD', 'ADDED', 'IN', 'PLUS']); 
                    })->sum('qty');
                    
                    $totalOut = $data->filter(function($q){ 
                        $op = strtoupper(trim($q->opr));
                        return in_array($op, ['MINUS', 'REDUCED', 'OUT', 'SUBTRACT']); 
                    })->sum('qty');
                @endphp
                <img src="{{ $imgUrl }}" class="product-img" onerror="this.src='{{ asset('frontend/images/logo-new.png') }}'" alt="">
                <div class="product-strip-content">
                    <span class="badge badge-light mb-2 px-3 py-1" style="font-weight: 800; color: #ed0b80 !important;">SKU: {{ $productvariant->sku }}</span>
                    <h2 class="m-0" style="font-weight: 800; color: white;">{{ $Product->name }}</h2>
                    <p class="mb-0 mt-1 opacity-90" style="color: white;">Tracking history for variant: <span class="bg-white px-2 py-0 rounded text-dark small font-weight-bold">{{ $productvariant->variants }}</span></p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon icon-add"><i class="fa fa-plus"></i></div>
                        <div class="stat-value text-success">{{ $totalIn }}</div>
                        <div class="stat-label">Total Stock In</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon icon-minus"><i class="fa fa-minus"></i></div>
                        <div class="stat-value text-danger">{{ $data->where('opr', 'MINUS')->sum('qty') }}</div>
                        <div class="stat-label">Total Stock Out</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card">
                        <div class="stat-icon icon-stock"><i class="fa fa-cube"></i></div>
                        <div class="stat-value" style="color: #1565c0;">{{ $productvariant->in_stock }}</div>
                        <div class="stat-label">Current Available Stock</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="premium-card card">
                        <div class="card-body">
                            <table id="datatable" class="table table-hover dt-responsive nowrap" style="width: 100%;">
                                <thead style="background: #f8f9fa;">
                                    <tr>
                                        <th style="border-top: none;">#</th>
                                        <th style="border-top: none;">Operation</th>
                                        <th style="border-top: none;">Quantity</th>
                                        <th style="border-top: none;">Remarks</th>
                                        <th style="border-top: none;">Balance After</th>
                                        <th style="border-top: none;">Date & Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                            @forelse ($data as $key => $value)
                                @php
                                    $op = strtoupper(trim($value->opr));
                                    $isIn = in_array($op, ['ADD', 'ADDED', 'IN', 'PLUS']);
                                @endphp
                                <tr>
                                    <td>{{ count($data) - $key }}</td>
                                    <td>
                                        @if ($isIn)
                                            <span class="badge-add"><i class="fa fa-plus-circle"></i> ADDED</span>
                                        @else
                                            <span class="badge-minus"><i class="fa fa-minus-circle"></i> REDUCED</span>
                                        @endif
                                    </td>
                                    <td class="font-weight-bold text-dark">
                                        {{ $isIn ? '+' : '-' }} {{ $value->qty }}
                                    </td>
                                    <td><span class="text-muted">{{ $value->remarks }}</span></td>
                                    <td class="font-weight-bold">{{ $value->closure_qty }}</td>
                                    <td style="color: #888;">{{ convertUtcToIst($value->created_at) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted mb-2"><i class="fa fa-info-circle fa-2x"></i></div>
                                        <div class="h5 text-muted">No stock movements recorded yet.</div>
                                        <div class="small text-muted">Stocks added before the logging system was implemented will not appear here. Try updating inventory to see them tracked.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Fix: Check if DataTable already exists and destroy it if it does
            if ($.fn.DataTable.isDataTable('#datatable')) {
               $('#datatable').DataTable().destroy();
            }
            
            $('#datatable').DataTable({
                "pageLength": 25,
                "ordering": false,
                "language": {
                    "search": "_INPUT_",
                    "searchPlaceholder": "Search logs..."
                }
            });
        });
    </script>
@endsection

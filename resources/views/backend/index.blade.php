@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper dashboard-premium">
        <div class="container-fluid">
            <!-- Hero Section -->
            <div class="row align-items-center mb-2">
                <div class="col-md-8">
                    <div class="welcome-card p-4">
                        <h2 class="display-5 font-weight-700 text-dark mb-1">
                            Hello, {{ Auth::user()->name }}!
                            <span class="wave">👋</span>
                        </h2>
                        <p class="lead text-muted mb-0">Here's what's happening with your store today.</p>
                    </div>
                </div>
                <div class="col-md-4 text-md-right d-none d-md-block">
                    <div class="breadcrumb-premium">
                        <span class="text-muted">Ecommerce</span>
                        <i class="fa fa-chevron-right mx-2"></i>
                        <span class="font-weight-700 text-pink">Dashboard</span>
                    </div>
                </div>
            </div>

            <!-- Stats Row -->
            <div class="row">
                <!-- Total Sales -->
                <div class="col-xl-3 col-md-6">
                    <div class="card mini-stat-card shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <h6 class="text-uppercase text-muted font-weight-700 mb-3 spacing-1">Total Sales</h6>
                                    <h3 class="mb-2 font-weight-700">₹
                                        {{ number_format(\App\Models\Order::where('status', 'Delivered')->sum('total'), 2) }}
                                    </h3>
                                    <div class="stat-growth success">
                                        <i class="fa fa-arrow-up"></i>
                                        <span>+12.5%</span>
                                        <small class="text-muted ml-1">last 30 days</small>
                                    </div>
                                </div>
                                <div class="stat-icon-box pink">
                                    <i class="fa fa-inr h3 mb-0"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Orders -->
                <div class="col-xl-3 col-md-6">
                    <div class="card mini-stat-card shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <h6 class="text-uppercase text-muted font-weight-700 mb-3 spacing-1">Paid Orders</h6>
                                    <h3 class="mb-2 font-weight-700">
                                        {{ \App\Models\Order::where('payment_status', 'paid')->count() }}</h3>
                                    <div class="stat-growth primary">
                                        <i class="fa fa-archive"></i>
                                        <span>{{ \App\Models\Order::where('created_at', '>=', date('Y-m-d'))->count() }}</span>
                                        <small class="text-muted ml-1">new orders today</small>
                                    </div>
                                </div>
                                <div class="stat-icon-box blue">
                                    <i class="fa fa-shopping-cart h3 mb-0"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customers -->
                <div class="col-xl-3 col-md-6">
                    <div class="card mini-stat-card shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <h6 class="text-uppercase text-muted font-weight-700 mb-3 spacing-1">Customers</h6>
                                    <h3 class="mb-2 font-weight-700">
                                        {{ \App\Models\User::where('role', 'customer')->count() }}</h3>
                                    <div class="stat-growth warning">
                                        <i class="fa fa-star"></i>
                                        <span>Active</span>
                                        <small class="text-muted ml-1">Verified users</small>
                                    </div>
                                </div>
                                <div class="stat-icon-box orange">
                                    <i class="fa fa-users h3 mb-0"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inventory -->
                <div class="col-xl-3 col-md-6">
                    <div class="card mini-stat-card shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <h6 class="text-uppercase text-muted font-weight-700 mb-3 spacing-1">Live Products</h6>
                                    <h3 class="mb-2 font-weight-700">{{ \App\Models\Product::count() }}</h3>
                                    <div class="stat-growth danger">
                                        <i class="fa fa-exclamation-circle"></i>
                                        <span>{{ \App\Models\Product::where('stock', '<=', 5)->count() }}</span>
                                        <small class="text-muted ml-1">low stock items</small>
                                    </div>
                                </div>
                                <div class="stat-icon-box teal">
                                    <i class="fa fa-tags h3 mb-0"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row mt-4">
                <div class="col-xl-8">
                    <div class="card chart-card shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h4 class="card-title mb-0">Sales Analytics</h4>
                                <div class="chart-legend">
                                    <span class="badge badge-soft-pink">Monthly Revenue</span>
                                </div>
                            </div>
                            <div id="morris-area-sales" style="height: 350px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card chart-card shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="card-title mb-4">Order Distribution</h4>
                            <div id="morris-donut-status" style="height: 300px;"></div>
                            <div class="mt-3 text-center">
                                <ul class="list-inline mb-0">
                                    @if (isset($status_counts))
                                        @foreach ($status_counts as $status)
                                            <li class="list-inline-item mx-2">
                                                <p class="text-muted mb-0 font-size-12">
                                                    <i class="fa fa-circle mr-1"
                                                        style="color: {{ ['#ff3f6c', '#508aeb', '#fcc24c', '#54cc96', '#6c757d', '#ff1744'][$loop->index % 6] }}"></i>
                                                    {{ $status['label'] }}
                                                </p>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions & Quick Links -->
            <div class="row mt-4">
                <div class="col-xl-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h4 class="card-title mb-0">Recent Transactions</h4>
                                <a href="{{ route('order.index') }}" class="btn btn-sm btn-pink-outline">View All
                                    Transactions</a>
                            </div>
                            <div class="table-responsive border-0 shadow-none">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light-pink text-pink">
                                        <tr>
                                            <th class="border-0">Order ID</th>
                                            <th class="border-0">Customer</th>
                                            <th class="border-0">Payment</th>
                                            <th class="border-0">Amount</th>
                                            <th class="border-0">Status</th>
                                            <th class="border-0 text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $data)
                                            @php
                                                $billing = DB::table('billing_address')
                                                    ->where('order_id', $data->id)
                                                    ->first();
                                                $name = $billing
                                                    ? $billing->first_name . ' ' . $billing->last_name
                                                    : 'Guest';
                                            @endphp
                                            <tr>
                                                <td class="font-weight-700 text-dark">#{{ $data->order_id }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-xs mr-2">
                                                            <span
                                                                class="avatar-title rounded-circle bg-soft-pink text-pink">
                                                                {{ strtoupper(substr($name, 0, 1)) }}
                                                            </span>
                                                        </div>
                                                        {{ $name }}
                                                    </div>
                                                </td>
                                                <td><span
                                                        class="badge badge-pill bg-soft-blue text-blue px-3">{{ strtoupper($data->payment_type) }}</span>
                                                </td>
                                                <td class="font-weight-700 text-dark">
                                                    ₹{{ number_format($data->total, 2) }}</td>
                                                <td>
                                                    @php
                                                        $statusClass =
                                                            [
                                                                'Delivered' => 'success',
                                                                'Processing' => 'warning',
                                                                'Pending' => 'secondary',
                                                                'Cancelled' => 'danger',
                                                            ][$data->status] ?? 'info';
                                                    @endphp
                                                    <span
                                                        class="badge badge-{{ $statusClass }} py-1 px-3">{{ $data->status }}</span>
                                                </td>
                                                <td class="text-right">
                                                    <a href="{{ route('view_detail', $data->id) }}"
                                                        class="action-icon btn-view-icon">
                                                        <i class="fa fa-eye font-size-18"></i>
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

                <div class="col-xl-4">
                    <div class="card bg-pink-gradient text-white overflow-hidden shadow-lg border-0 rounded-16">
                        <div class="card-body p-4 position-relative">
                            <div class="position-relative z-index-1">
                                <h4 class="text-white mb-4">Quick Actions</h4>
                                <div class="row g-3">
                                    <div class="col-6 mb-3">
                                        <a href="{{ route('product.create') }}" class="quick-action-btn h-100">
                                            <i class="fa fa-plus-circle h2 mb-2"></i>
                                            <span>Add Product</span>
                                        </a>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <a href="{{ route('coupon.create') }}" class="quick-action-btn h-100">
                                            <i class="fa fa-ticket h2 mb-2"></i>
                                            <span>Create Coupon</span>
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('category.create') }}" class="quick-action-btn h-100">
                                            <i class="fa fa-list h2 mb-2"></i>
                                            <span>Add Category</span>
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('banner.create') }}" class="quick-action-btn h-100">
                                            <i class="fa fa-image h2 mb-2"></i>
                                            <span>Upload Banner</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- Background Decoration -->
                            <div class="bg-decoration">
                                <i class="fa fa-rocket position-absolute"
                                    style="bottom: -20px; right: -20px; font-size: 150px; opacity: 0.1;"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        /* Dashboard Specific Styles */
        .text-pink {
            color: #ff3f6c !important;
        }

        .text-blue {
            color: #3b82f6 !important;
        }

        .bg-soft-pink {
            background-color: rgba(255, 63, 108, 0.1) !important;
        }

        .bg-soft-blue {
            background-color: rgba(59, 130, 246, 0.1) !important;
        }

        .bg-light-pink {
            background-color: #fff9fa !important;
        }

        .bg-pink-gradient {
            background: linear-gradient(135deg, #ff3f6c 0%, #e91e63 100%) !important;
        }

        .bg-pink {
            background-color: #ff3f6c !important;
        }

        .btn-pink-outline {
            border: 1px solid #ff3f6c;
            color: #ff3f6c;
            background: transparent;
            border-radius: 50px;
            padding: 5px 15px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-pink-outline:hover {
            background: #ff3f6c;
            color: #fff;
            box-shadow: 0 4px 10px rgba(255, 63, 108, 0.2);
        }

        .spacing-1 {
            letter-spacing: 1px;
        }

        .font-weight-700 {
            font-weight: 700;
        }

        .rounded-16 {
            border-radius: 16px !important;
        }

        /* Action Icons Styling */
        .action-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none !important;
        }

        .action-icon:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-view-icon {
            background-color: rgba(59, 130, 246, 0.1);
            color: #3b82f6 !important;
        }

        .btn-view-icon:hover {
            background-color: #3b82f6;
            color: #fff !important;
        }

        .font-size-18 {
            font-size: 18px !important;
        }

        /* Mini Stat Cards */
        .mini-stat-card {
            border: none;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .mini-stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
        }

        /* Stats Icon Boxes */
        .stat-icon-box {
            width: 54px;
            height: 54px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon-box.pink {
            background: rgba(255, 63, 108, 0.1);
            color: #ff3f6c;
        }

        .stat-icon-box.blue {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .stat-icon-box.orange {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .stat-icon-box.teal {
            background: rgba(20, 184, 166, 0.1);
            color: #14b8a6;
        }

        /* Growth Badges */
        .stat-growth {
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .stat-growth.success {
            color: #10b981;
        }

        .stat-growth.primary {
            color: #3b82f6;
        }

        .stat-growth.warning {
            color: #f59e0b;
        }

        .stat-growth.danger {
            color: #ef4444;
        }

        /* Quick Actions */
        .quick-action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px 10px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            color: white !important;
            text-decoration: none !important;
            transition: all 0.3s;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .quick-action-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Progress Bars */
        .progress-sm {
            height: 6px;
        }

        /* Avatar */
        .avatar-xs {
            height: 35px;
            width: 35px;
        }

        .avatar-title {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            font-weight: 700;
            font-size: 14px;
        }

        /* Chart Cards */
        .chart-card {
            border-radius: 20px;
        }

        /* Animation */
        .wave {
            display: inline-block;
            animation: wave-animation 2.5s infinite;
            transform-origin: 70% 70%;
        }

        @keyframes wave-animation {
            0% {
                transform: rotate(0.0deg)
            }

            10% {
                transform: rotate(14.0deg)
            }

            20% {
                transform: rotate(-8.0deg)
            }

            30% {
                transform: rotate(14.0deg)
            }

            40% {
                transform: rotate(-4.0deg)
            }

            50% {
                transform: rotate(10.0deg)
            }

            60% {
                transform: rotate(0.0deg)
            }

            100% {
                transform: rotate(0.0deg)
            }
        }

        .breadcrumb-premium {
            padding: 10px 20px;
            background: #fff;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
        }
    </style>
@endsection

@section('scripts')
    <script>
        $(function() {
            "use strict";

            // Sales Chart (Morris Line)
            var $salesData = [
                @if (isset($monthly_sales) && count($monthly_sales) > 0)
                    @foreach ($monthly_sales as $sale)
                        {
                            y: '{{ $sale['month'] }}',
                            a: {{ $sale['total'] }}
                        },
                    @endforeach
                @else
                    {
                        y: '{{ date('Y-m') }}',
                        a: 0
                    },
                @endif
            ];

            if ($salesData.length > 0) {
                Morris.Line({
                    element: 'morris-area-sales',
                    data: $salesData,
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['Revenue'],
                    gridLineColor: '#f1f1f1',
                    gridTextColor: '#999',
                    hideHover: 'auto',
                    lineColors: ['#ff3f6c'],
                    resize: true,
                    pointSize: 4,
                    pointStrokeColors: ['#ff3f6c'],
                    smooth: true,
                    xLabelAngle: 35,
                });
            }

            // Status Donut Chart
            var $donutData = [
                @if (isset($status_counts))
                    @foreach ($status_counts as $status)
                        {
                            label: "{{ $status['label'] }}",
                            value: {{ $status['value'] }}
                        },
                    @endforeach
                @endif
            ];

            if ($donutData.length > 0) {
                Morris.Donut({
                    element: 'morris-donut-status',
                    data: $donutData,
                    resize: true,
                    colors: ['#ff3f6c', '#3b82f6', '#f59e0b', '#10b981', '#6c757d', '#ef4444'],
                    labelColor: '#444',
                    formatter: function(x) {
                        return x + " Orders"
                    }
                });
            }
        });
    </script>
@endsection

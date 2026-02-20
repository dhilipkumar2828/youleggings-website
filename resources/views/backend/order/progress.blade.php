@extends('backend.layouts.master')

@section('content')
    @include('backend.layouts.notification')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="float-right page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a>Orders</a></li>
                            <li class="breadcrumb-item active">Unfullied Orders</li>
                        </ol>
                    </div>
                    <h5 class="page-title">Orders</h5>

                </div>
            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title font-20 mt-0">Unfulfilled Orders</h4>
                                <div class="d-flex align-items-center">
                                    <div class="search-box mr-2">
                                        <div class="input-group">
                                            <input type="text" id="search-input" class="form-control"
                                                placeholder="Search orders..." value="{{ request('search') }}"
                                                style="width: 250px; border-radius: 25px 0 0 25px !important;">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button" id="btn-search"
                                                    style="border-radius: 0 25px 25px 0 !important; padding: 0 20px;">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="example" class="table table-hover dt-responsive nowrap" cellspacing="0"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th style="display:none;">Id</th>
                                            <th>Tracking Id</th>
                                            <th>Order Date</th>
                                            <th>Customer</th>
                                            <th>Customer Phone</th>
                                            <th>Order ID</th>
                                            <th>Payment Via</th>
                                            <th>Payment Status</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            @if (auth()->user()->can('processing_orders-edit'))
                                                <th class="text-center">Actions</th>
                                            @endif
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($order as $item)
                                            <?php
                                            $billing_address = DB::table('billing_address')->where('order_id', $item->id)->first();
                                            $fullname = $billing_address ? $billing_address->first_name . ' ' . $billing_address->last_name : 'N/A';
                                            $phone = $billing_address ? $billing_address->phone_number : 'N/A';
                                            ?>
                                            <tr>
                                                <td style="display:none;">{{ $item->id }}</td>
                                                <td><span
                                                        class="font-weight-bold text-primary">{{ $item->tracking_id }}</span>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</td>
                                                <td>{{ $fullname }}</td>
                                                <td>{{ $phone }}</td>
                                                <td>{{ $item->order_id }}</td>
                                                <td>{{ $item->payment_type }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $item->payment_status == 'paid' ? 'success' : ($item->payment_status == 'unpaid' ? 'danger' : 'warning') }}">
                                                        {{ strtoupper($item->payment_status) }}
                                                    </span>
                                                </td>
                                                <td class="font-weight-600 text-dark">₹
                                                    {{ number_format(floatval($item->sub_total) + floatval($item->deliver_charge) - floatval($item->discound_amount) - floatval($item->ship_discount_amount), 2) }}
                                                </td>
                                                <td>
                                                    <?php
                                                    $status_label = $item->status;
                                                    $badge_class = 'warning';
                                                    if ($item->status == 'Processing') {
                                                        $status_label = 'Unfulfilled';
                                                        $badge_class = 'warning';
                                                    } elseif ($item->status == 'deliver') {
                                                        $status_label = 'Dispatched';
                                                        $badge_class = 'info';
                                                    }
                                                    ?>
                                                    <span
                                                        class="badge badge-pill badge-{{ $badge_class }}">{{ $status_label }}</span>
                                                </td>
                                                @if (auth()->user()->can('processing_orders-edit'))
                                                    <td class="text-center">
                                                        @can('processing_orders-view')
                                                            <a href="{{ route('view_detail', $item->id) }}"
                                                                class="action-icon btn-view-icon" data-toggle="tooltip"
                                                                title="View Order Details">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        @endcan
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 d-flex justify-content-center">
                                {{ $order->appends(request()->input())->links() }}
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div><!-- container fluid -->
    </div> <!-- Page content Wrapper -->
    </div> <!-- content -->
    </div>
    <!-- End Right content here -->
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.8/css/jquery.dataTables.min.css">

    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "order": [
                    [1, 'desc']
                ],
                "paging": false,
                "info": false,
                "searching": false, // Disable DataTables search since we have server-side
                dom: 'Brt',
                buttons: [{
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i> Excel Export',
                    className: 'btn btn-primary ripple mb-3',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }
                }]
            });

            // Tooltip activation
            $('[data-toggle="tooltip"]').tooltip();

            // Search functionality
            $('#btn-search').click(function() {
                var inputValue = $('#search-input').val();
                location.href = '/progress?search=' + encodeURIComponent(inputValue);
            });

            $("#search-input").keypress(function(event) {
                if (event.which == 13) {
                    $('#btn-search').click();
                }
            });
        });
    </script>
    <!-- END wrapper -->
@endsection

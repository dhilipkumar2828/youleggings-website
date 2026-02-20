@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="float-right page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a>Orders</a></li>
                            <li class="breadcrumb-item active">All Orders</li>
                        </ol>
                    </div>
                    <h5 class="page-title">Orders</h5>

                </div>
            </div>
            <!-- end row -->
            <div class="card card-body d-none">
                <h4 class="card-title font-20 mt-0">
                    <?php
                    if (isset($status) && $status == 'paid') {
                        echo 'Paid Orders';
                    } elseif (isset($status) && $status == 'unpaid') {
                        echo 'Unpaid Orders';
                    } else {
                        echo 'All Orders';
                    }
                    ?>
                </h4>
                <!-- <a href="#" id="add-btn" style="color: #ffffff;"> + ADD</a> -->

            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body d-none">

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="row d-flex align-items-center">
                                <!-- Search Input -->
                                <!--  <div class="d-flex align-items-center justify-content-end" style="flex: 0 0 auto;">-->
                                <!--    <label for="items-per-page" class="mr-2">Show</label>-->
                                <!--    <select id="items-per-page" class="form-control small-select" -->
                                <!--        onchange="changeItemsPerPage(this.value)" style="width: auto; padding: 5px 10px; font-size: 14px; height: 35px;">-->
                                <!--        <option value="25" {{ request()->get('per_page', 10) == 25 ? 'selected' : '' }}>25</option>-->
                                <!--        <option value="50" {{ request()->get('per_page', 10) == 50 ? 'selected' : '' }}>50</option>-->
                                <!--        <option value="100" {{ request()->get('per_page', 10) == 100 ? 'selected' : '' }}>100</option>-->
                                <!--        <option value="250" {{ request()->get('per_page', 10) == 250 ? 'selected' : '' }}>250</option>-->
                                <!--        <option value="500" {{ request()->get('per_page', 10) == 500 ? 'selected' : '' }}>500</option>-->
                                <!--    </select>-->
                                <!--    <label for="items-per-page" class="ml-2">Entries</label>-->
                                <!--</div>-->
                                <!--   <div class="d-flex align-items-center inputField" style="flex: 1;">-->
                                <!--       <input type="text" id="search-input" class="form-control" placeholder="Search..." style="width: 100%;">-->
                                <!--   </div>-->
                                <!--<style>-->
                                <!--       .inputField{-->
                                <!--           position: absolute;-->
                                <!--           top: 72px !important;-->
                                <!--           right: 12%;-->
                                <!--       }-->
                                <!--   </style>-->
                                <!-- Go Back Button -->
                                <!--    <div class="d-flex justify-content-center align-items-center backBtn" style="flex: 0 0 auto;">-->
                                <!--<button class="btn btn-primary">-->
                                <!--    Go Back-->
                                <!--</button>-->

                                <!--    </div>-->
                                <!--     <style>-->
                                <!--        .backBtn{-->
                                <!--            position: absolute;-->
                                <!--            top: 72px !important;-->
                                <!--            right: 5%;-->

                                <!--        }-->

                                <!--    </style>-->

                                <!-- Items Per Page Dropdown -->

                            </div>
                        </div>
                        <!--<input type="text" id="search-input" class="form-control" placeholder="Search...">-->
                        <div class="py-0 p-3">
                            <form id="deleteOrdersForm" style="overflow-x:auto;" method="POST"
                                action="{{ route('delete_orders') }}">
                                @csrf
                                @method('DELETE')

                                <table id="example" class="table table-bordered dt-responsive nowrap mt-3" cellspacing="0"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <!--<th style="display:none;">Order ID</th>-->
                                            <th><input type="checkbox" id="selectAll"></th>

                                            <th>View Link</th>
                                            <!--<th>Tracking Id</th>-->
                                            <th>Order Date</th>
                                            <th>Customer</th>
                                            <th>Customer Phone</th>
                                            <!--<th>Order ID</th>-->
                                            <th>Payment Via</th>
                                            <th>Payment Status</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Qty</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            // Total number of orders
                                            $totalOrders = $order->total();
                                        @endphp

                                        @foreach ($order as $k => $item)
                                            @php
                                                // Calculate the reverse serial number
                                                $serialNumber =
                                                    $totalOrders -
                                                    (($order->currentPage() - 1) * $order->perPage() + $k);

                                                $billing_address = DB::table('billing_address')
                                                    ->where('order_id', $item->id)
                                                    ->first();
                                                $fullname = $billing_address
                                                    ? $billing_address->first_name . ' ' . $billing_address->last_name
                                                    : '';
                                                $phone = $billing_address ? $billing_address->phone_number : '';
                                            @endphp
                                            <tr>
                                                <!--<td style="display:none;">{{ $item->id }}</td>-->
                                                <td><input type="checkbox" name="order_ids[]" value="{{ $item->id }}">
                                                </td>

                                                <td>
                                                    @can('all_orders-edit')
                                                        <a class="under-id"
                                                            href="{{ route('view_detail', $item->id) }}">{{ $item->id }}</a>
                                                    @endcan
                                                </td>
                                                <!--<td>{{ $item->tracking_id }}</td>-->
                                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('M,d,Y g:i A') }}
                                                </td>
                                                <td>{{ $fullname }}</td>
                                                <td>{{ $phone }}</td>
                                                <!--<td>{{ $item->payment_status == 'paid' ? $item->order_id : '' }}</td>-->
                                                <td>{{ $item->payment_type }} {{ $item->payment_id }}</td>
                                                <td>
                                                    <div class="btn-group m-b-10">
                                                        <span
                                                            class="badge badge-{{ $item->payment_status != 'unpaid' ? ($item->payment_status == 'paid' ? 'success' : '') : 'default' }}">{{ $item->payment_status }}</span>
                                                    </div>
                                                </td>
                                                <td>₹ {{ $item->total }}</td>
                                                <td>
                                                    <div class="btn-group m-b-10">
                                                        <span
                                                            class="badge badge-{{ $item->status == 'Processing' ? 'warning' : ($item->status == 'Delivered' ? 'success' : '') }}">
                                                            {{ $item->status == 'Processing' ? 'Unfullied' : ($item->status == 'Delivered' ? 'Dispatched' : $item->status) }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ isset($orderDetails[$item->id]) ? $orderDetails[$item->id]->cnt : '-' }}
                                                </td>
                                                <td>
                                                    @can('all_orders-edit')
                                                        <a
                                                            href="{{ route('view_detail', $item->id) }}?status={{ $status }}"><i
                                                                class="fa fa-eye" aria-hidden="true"></i> View</a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-danger">Delete Selected</button>
                    </form>
                </div>
                <!------

                                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                        <tr>
                                                            <th>Order Date</th>
                                                            <th>Customer</th>

                                                            <th>Customer Email</th>
                                                            <th>Order ID</th>
                                                            <th>Payment Via</th>
                                                            <th>Payment Status</th>
                                                            <th> Amount</th>
                                                            <th> Status</th>

                                                            <th>Actions</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        @foreach ($order as $item)
    <tr>

                                                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('M,d,Y') }}</td>
                                                                <td></td>

                                                                <td>{{ $item->order_id }}</td>
                                                                <td>{{ $item->payment_type }}</td>
                                                                <td>
                                                                    <div class="btn-group m-b-10">

                                                                   <span class="badge badge-{{ $item->payment_status != 'unpaid' ? ($item->payment_status != 'paid' ? '' : 'success') : 'default' }}">{{ $item->payment_status }}</span>
                                                                    </div>
                                                                </td>

                                                                <td>₹ {{ number_format($item->total, 2, '.', '') + number_format($item->deliver_charge, 2, '.', '') }}</td>
                                                                <td>
                                                                    <div class="btn-group m-b-10">

                                                                   <span class="badge badge-{{ $item->status != 'Received' ? ($item->status != 'Confirmed' ? ($item->status != 'Processing' ? ($item->status != 'Delivered' ? ($item->status != 'Returned' ? ($item->status != 'Cancelled' ? ($item->status != 'COD' ? '' : 'danger') : 'info') : 'default') : 'warning') : 'success') : 'warning') : 'primary' }}">{{ $item->status }}</span>

                                                                    </div>
                                                                </td>

                                                                <td>
                                                                    <div class="btn-group m-b-10">
                                                                        <button type="button" class="btn btn-action dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">Actions</button>
                                                                        <div class="dropdown-menu">

                                                                        @can('all_orders-edit')
        <a class="dropdown-item" href="{{ route('view_detail', $item->id) }}">View</a>
    @endcan

                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
    @endforeach

                                                        </tbody>

                                                    </table>
                                                    ------>
                <div class="col-sm-6 col-md-3 m-t-30">
                    <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
                        aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title mt-0">Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>You are going to delete this category. All contents related with this category will
                                        be lost. Do you want to delete it?</p>
                                </div>

                                <div class="modal-button">
                                    <div class="button-items">
                                        <button type="button" class="btn btn-secondary waves-effect"
                                            data-dismiss="modal">Cancel</button>
                                        <input class="btn btn-danger" type="reset" value="Delete">
                                    </div>
                                </div>

                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
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

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">

    <!-- Buttons Extension CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

    <!-- Buttons Extension JavaScript -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.8/css/jquery.dataTables.min.css">

    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "order": [
                    [1, 'desc']
                ], // Order by the second column
                "paging": false, // Disable pagination
                "searching": true, // Disable the search box
                "ordering": false,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excelHtml5', // Enable Excel export
                    text: 'Excel Export', // Button text
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
                            11
                        ] // Specify zero-based column indexes to export
                    }
                }]
            });

            // Select All Checkbox
            $('#selectAll').on('click', function() {
                $('input[name="order_ids[]"]').prop('checked', this.checked);
            });
        });

        $(document).ready(function() {
            $("#search-input").keypress(function(event) {
                if (event.which == 13) {
                    var inputValue = $('#search-input').val();
                    var url = new URL(window.location.href);
                    url.searchParams.delete('page');

                    url.searchParams.set('search', inputValue); // This will set the 'search' parameter
                    window.location.href = url.toString(); // Redirect with updated URL
                }
            });
        });
    </script>
    <script>
        document.getElementById('selectAll').addEventListener('click', function(e) {
            const checkboxes = document.querySelectorAll('input[name="order_ids[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = e.target.checked;
            });
        });

        $('td').click(function(event) {
            if (event.target.type !== 'checkbox') {
                $(':checkbox', this).trigger('click');
            }
        });
    </script>
    <script>
        function changeItemsPerPage(value) {
            const url = new URL(window.location.href);
            url.searchParams.delete('search');
            url.searchParams.set('per_page', value);
            window.location.href = url.toString();
        }
    </script>
    <!-- END wrapper -->
@endsection

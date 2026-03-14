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
           

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">

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
                            </div>
                        </div>
                        <div class="py-0 p-3">
                            <form id="deleteOrdersForm" style="overflow-x:auto;" method="POST"
                                action="{{ route('delete_orders') }}">
                                @csrf
                                @method('DELETE')

                                <table id="example" class="table table-bordered dt-responsive nowrap mt-3" cellspacing="0"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAll"></th>
                                            <th>View Link</th>
                                            <th>Order Date</th>
                                            <th>Customer</th>
                                            <th>Customer Phone</th>
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
                                            $totalOrders = $order->total();
                                        @endphp

                                        @foreach ($order as $k => $item)
                                            @php
                                                $serialNumber = $totalOrders - (($order->currentPage() - 1) * $order->perPage() + $k);
                                                $billing_address = DB::table('billing_address')->where('order_id', $item->id)->first();
                                                $fullname = $billing_address ? $billing_address->first_name . ' ' . $billing_address->last_name : '';
                                                $phone = $billing_address ? $billing_address->phone_number : '';
                                            @endphp
                                            <tr>
                                                <td><input type="checkbox" name="order_ids[]" value="{{ $item->id }}"></td>
                                                <td>
                                                    @can('all_orders-edit')
                                                        <a class="under-id" href="{{ route('view_detail', $item->id) }}">{{ $item->id }}</a>
                                                    @endcan
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('M,d,Y g:i A') }}</td>
                                                <td>{{ $fullname }}</td>
                                                <td>{{ $phone }}</td>
                                                <td>{{ $item->payment_type }} {{ $item->payment_id }}</td>
                                                <td>
                                                    <div class="btn-group m-b-10">
                                                        <span class="badge badge-{{ $item->payment_status != 'unpaid' ? ($item->payment_status == 'paid' ? 'success' : '') : 'default' }}">{{ $item->payment_status }}</span>
                                                    </div>
                                                </td>
                                                <td>₹ {{ $item->total }}</td>
                                                <td>
                                                    <div class="btn-group m-b-10">
                                                        <span class="badge badge-{{ $item->status == 'Processing' ? 'warning' : ($item->status == 'Delivered' ? 'success' : '') }}">
                                                            {{ $item->status == 'Processing' ? 'Unfullied' : ($item->status == 'Delivered' ? 'Dispatched' : $item->status) }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ isset($orderDetails[$item->id]) ? $orderDetails[$item->id]->cnt : '-' }}
                                                </td>
                                                <td>
                                                    @can('all_orders-edit')
                                                        <a href="{{ route('view_detail', $item->id) }}?status={{ $status }}"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
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
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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

    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "order": [[1, 'desc']],
                "paging": false,
                "searching": true,
                "ordering": false,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    text: 'Excel Export',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                    }
                }]
            });

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
                    url.searchParams.set('search', inputValue);
                    window.location.href = url.toString();
                }
            });
        });
    </script>
@endsection

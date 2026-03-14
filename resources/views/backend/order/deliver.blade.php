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
                            <li class="breadcrumb-item active">Dispatched Orders</li>
                        </ol>
                    </div>
                    <h5 class="page-title">Orders</h5>

                </div>
            </div>
            <!-- end row -->
            {{-- <div class="card m-b-30 card-body">
                <h4 class="card-title font-20 mt-0">Dispatched Orders</h4>
                <!-- <a href="#" id="add-btn" style="color: #ffffff;"> + ADD</a> -->

            </div> --}}

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">

                            <table id="example" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Tracking Id</th>
                                        <th>Order Date</th>
                                        <th>Customer</th>
                                        <th>Customer Phone</th>
                                        <th>Order ID</th>
                                        <th>Payment Via</th>
                                        <th>Payment Status</th>
                                        <th> Amount</th>
                                        <th> Status</th>
                                        @if (auth()->user()->can('delivered_orders-edit'))
                                            <th>Actions</th>
                                        @endif
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($order as $item)
                                        <?php
                                        $billing_address = DB::table('billing_address')->where('order_id', $item->id)->first();
                                        $fullname = '';
                                        if (!empty($billing_address)) {
                                            $fullname = $billing_address->first_name . ' ' . $billing_address->last_name;
                                        }
                                        $phone = '';
                                        if (!empty($billing_address)) {
                                            $phone = $billing_address->phone_number;
                                        }
                                        
                                        ?>
                                        <tr>
                                            <td>{{ $item->tracking_id }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('M,d,Y') }}</td>
                                            <td>{{ $fullname }}</td>
                                            <td>{{ $phone }}</td>
                                            <td>{{ $item->order_id }}</td>
                                            <td>{{ $item->payment_type }}</td>
                                            <td>
                                                <div class="btn-group m-b-10">

                                                    <span
                                                        class="badge badge-{{ $item->payment_status != 'unpaid' ? ($item->payment_status != 'paid' ? '' : 'success') : 'default' }}">{{ $item->payment_status }}</span>
                                                </div>
                                            </td>

                                            <td>₹
                                                {{ number_format($item->sub_total, 2, '.', '') + number_format($item->deliver_charge, 2, '.', '') + number_format($item->gst, 2, '.', '') - $item->discound_amount - $item->ship_discount_amount }}
                                            </td>
                                            <td>
                                                <div class="btn-group m-b-10">
                                                    <?php
                                                    if ($item->status == 'Processing') {
                                                        $item->status = 'Unfullied';
                                                    } elseif ($item->status == 'Delivered') {
                                                        $item->status = 'Dispatched';
                                                    } else {
                                                        $item->status = $item->status;
                                                    }
                                                    ?>
                                                    <span>{{ $item->status }}</span>
                                                </div>
                                            </td>
                                            @if (auth()->user()->can('delivered_orders-edit'))
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @can('delivered_orders-view')
                                                            <a href="{{ route('view_detail', $item->id) }}"
                                                                class="action-icon btn-view-icon" data-toggle="tooltip"
                                                                title="View">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        @endcan
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach

                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="{{ auth()->user()->can('delivered_orders-edit') ? 10 : 9 }}">
                                            {{ $order->links() }} <!-- This will generate pagination links -->
                                        </td>
                                    </tr>
                                </tfoot>

                            </table>

                            <div class="col-sm-6 col-md-3 m-t-30">
                                <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
                                    aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title mt-0">Delete</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>You are going to delete this category. All contents related with this
                                                    category will be lost. Do you want to delete it?</p>
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
    <!-- END wrapper -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.8/css/jquery.dataTables.min.css">

    <script>
        $(document).ready(function() {
            var table = $('#example').dataTable({
                "order": [
                    [1, 'desc']
                ],
                "paging": false, // Disable pagination
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                    text: 'Excel Export',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7,
                            8
                        ] // Specify columns to export (zero-based index)
                    }
                }]
            });
        });
    </script>
@endsection

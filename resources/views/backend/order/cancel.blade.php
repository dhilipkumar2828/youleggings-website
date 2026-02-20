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

                            <li class="breadcrumb-item active">Cancelled Orders</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Orders</h5>

                </div>

            </div>

            <!-- end row -->

            <div id="success_message" class="alert alert-success"
                style="display:none;color: black;font-size: 18px;font-family: sans-serif;">Updated Successfully</div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Cancelled Orders</h4>

                <!-- <a href="#" id="add-btn" style="color: #ffffff;"> + ADD</a> -->

            </div>

            <div class="row">

                <div class="col-12">

                    <div class="card m-b-30">

                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

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

                                        <th>Actions</th>

                                        <!----

                                                            <th>Approve</th>

                                                            ---->

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($order as $item)
                                        @php

                                            $order_products = DB::table('order_products')
                                                ->where('order_id', $item->id)
                                                ->where('status', 'Active')
                                                ->first();

                                            $get_customer = DB::table('customer')
                                                ->where('id', $item->customer_id)
                                                ->first();

                                        @endphp

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

                                        <input type="hidden" name="order_productsid" value="{{ $item->id }}">

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
                                                {{ number_format(number_format($item->sub_total, 2, '.', '') + number_format($item->deliver_charge, 2, '.', '') - $item->discound_amount - $item->ship_discount_amount, 2) }}
                                            </td>

                                            <td>

                                                <div class="btn-group m-b-10">

                                                    <span
                                                        class="badge badge-{{ $item->status != 'Pending' ? ($item->status != 'Confirmed' ? ($item->status != 'Processing' ? ($item->status != 'Delivered' ? ($item->status != 'Returned' ? ($item->status != 'Cancelled' ? '' : 'danger') : 'info') : 'default') : 'warning') : 'success') : 'warning' }}">{{ $item->status }}</span>

                                                </div>

                                            </td>

                                            <td>

                                                <div class="btn-group m-b-10">

                                                    <button type="button" class="btn btn-action dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">Actions</button>

                                                    <div class="dropdown-menu">

                                                        @can('Cancel View')
                                                            <a class="dropdown-item"
                                                                href="{{ route('view_detail', $item->id) }}">View</a>
                                                        @endcan

                                                        <!--<a class="btn waves-effect waves-light" data-toggle="modal"-->

                                                        <!--    data-target=".bs-example-modal-center">Delete</a>-->

                                                    </div>

                                                </div><!-- /btn-group -->

                                            </td>

                                            <!---

                                                                <td>

                                                                <button type="button" onclick="approve({{ $item->id }},{{ $item->id }})" class="btn btn-action"

                                                                           >Approve</button>

                                                                </td>

                                                                ---->

                                        </tr>
                                    @endforeach

                                </tbody>

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

    <div class="col-sm-6 col-md-12 m-t-30">

        <div class="modal fade bs-example-modal-center1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
            aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title text-center "><b class="text-center"
                                style="font-size: 18px;font-family: -webkit-body;">Cancel Order</b></h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-12">

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-4 col-form-label">Order Cancellation Fee
                                    </label>

                                    <div class="col-sm-8">

                                        <input class="form-control" name="cancellation_fee" id="cancellation_fee"
                                            type="text" autocomplete="off" value="0.00"
                                            placeholder="Enter Cancellation Fee" required />

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="modal-button text-center">

                        <div class="button-items ">

                            <button type="button" class="btn btn-primary waves-effect" id="cancellation_btn">Cancel
                                Order</button>

                            <!-- <button type="button" class="btn btn-secondary waves-effect ml-3" data-dismiss="modal">Cancel</button> -->

                        </div>

                    </div>

                    </form>

                </div><!-- /.modal-content -->

            </div><!-- /.modal-dialog -->

        </div><!-- /.modal -->

    </div>

    <!-- END wrapper -->

    <script>
        $(function() {

            $("input[name='cancellation_fee']").on('input', function(e) {

                $(this).val($(this).val().replace(/[^0-9]/g, ''));

            });

        });

        function approve(order_productsid, suborders_id) {

            $('.bs-example-modal-center1').modal('show');

            $('#cancellation_btn').click(function() {

                var cancellation_fee = $('#cancellation_fee').val();

                if ($('#cancellation_fee').val() != "") {

                    $.ajax({

                        url: "{{ url('approve_request') }}",

                        method: 'post',

                        data: {

                            order_productsid: order_productsid,

                            suborders_id: suborders_id,

                            cancellation_fee: cancellation_fee,

                            _token: '{{ csrf_token() }}'

                        },

                        success: function(result) {

                            $('.bs-example-modal-center1').modal('hide');

                            $("html, body").animate({
                                scrollTop: 0
                            }, "slow");

                            $('#success_message').css('display', 'block');

                            setTimeout(function() {

                                window.location.reload();

                            }, 1000);

                        }

                    });

                }

            });

        }
    </script>
@endsection

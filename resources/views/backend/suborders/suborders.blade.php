@extends('backend.layouts.master')

@section('content')
    @include('backend.layouts.notification')

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="#">Home</a></li>

                            <li class="breadcrumb-item active">Sub Orders</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Sub Orders</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Sub Orders</h4>

                <!-- <a href="products-create.html" id="add-btn" style="color: #ffffff;"> + ADD</a> -->

            </div>

            <div class="row">

                <div class="col-12">

                    <div class="card m-b-30">

                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>

                                    <tr>

                                        <th>Id</th>

                                        <th>Order Id</th>

                                        <th>Vendor Name </th>

                                        <th>Customer Name</th>

                                        <th>Payment Status</th>

                                        <th>Total Amount</th>

                                        <th>Status</th>

                                        <th> Actions</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @php $row_cnt=1 @endphp

                                    @php $i=0 @endphp

                                    @foreach ($suborders as $item)
                                        @php

                                            $get_vendor = DB::table('vendor')->where('id', $item->vendor_id)->first();

                                            $get_customer = DB::table('customer')
                                                ->where('id', $item->customer_id)
                                                ->first();

                                        @endphp

                                        <tr>

                                            <td>{{ $row_cnt }} </td>

                                            <td>{{ $item->orders_id }} </td>

                                            <td>{{ $get_vendor->vendor_name }}</td>

                                            <td>{{ $get_customer->name }} </td>

                                            <td>

                                                <div class="btn-group m-b-10">

                                                    <span
                                                        class="badge badge-{{ $item->payment_status != 'unpaid' ? ($item->payment_status != 'paid' ? '' : 'success') : 'default' }}">{{ $item->payment_status }}</span>

                                                </div>

                                            </td>

                                            <td>₹ {{ $sum_arr[$i] }}</td>

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

                                                        <!-- <a class="dropdown-item" href="products-create.html">Edit</a>

                                                    <a class="btn waves-effect waves-light" data-toggle="modal" data-dismiss="modal"

                                                        data-target=".bs-example-modal-center">Delete</a><br> -->

                                                        <a href="{{ url('suborders_items/' . $item->id) }}"
                                                            class="btn waves-effect waves-light">View</a><br>

                                                        <a class="btn waves-effect waves-light"
                                                            onclick=edit("{{ $item->id }}") data-toggle="modal"
                                                            data-dismiss="modal"
                                                            data-target=".bs-example-modal-center1">Edit</a>

                                                    </div>

                                                </div><!-- /btn-group -->

                                            </td>

                                        </tr>

                                        @php $i++ @endphp

                                        @php $row_cnt++ @endphp
                                    @endforeach

                                </tbody>

                            </table>

                            <div class="col-sm-6 col-md-12 m-t-30">

                                <div class="modal fade bs-example-modal-center1" tabindex="-1" role="dialog"
                                    aria-labelledby="mySmallModalLabel" aria-hidden="true">

                                    <div class="modal-dialog modal-dialog-centered">

                                        <div class="modal-content">

                                            <div class="modal-header">

                                                <h5 class="modal-title mt-0">Edit</h5>

                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">

                                                    <span aria-hidden="true">&times;</span>

                                                </button>

                                            </div>

                                            <div class="modal-body">

                                                <form action="{{ route('update_suborders.update_suborders') }}"
                                                    method="post" enctype="multipart/form-data">

                                                    @csrf

                                                    <div class="row">

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Order ID</label>

                                                                <div class="col-sm-10">

                                                                    <input type="hidden" id="hidden_id" name="id">

                                                                    <input class="form-control" id="order_id"
                                                                        type="text" value=""
                                                                        placeholder="Enter Name" disabled
                                                                        id="example-text-input">

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Vendor Name</label>

                                                                <div class="col-sm-10">

                                                                    <input class="form-control" id="vendor_name"
                                                                        type="text" value="" disabled
                                                                        placeholder="Enter Name" id="example-text-input">

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Customer Name</label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control" id="customer_name"
                                                                        type="text" value="" disabled
                                                                        placeholder="Enter Name" id="example-text-input">

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Payment Status</label>

                                                                <div class="col-sm-10">

                                                                    <select name="payment_status" id="payment_status"
                                                                        class="form-control">

                                                                        <option value='paid'>Paid

                                                                        </option>

                                                                        <option value='unpaid'>Unpaid

                                                                        </option>

                                                                    </select>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Status</label>

                                                                <div class="col-sm-8">

                                                                    <select name="status" class="form-control"
                                                                        id="condition">

                                                                        <option value='Pending'>Pending

                                                                        </option>

                                                                        <option value='Confirmed'>Confirmed

                                                                        </option>

                                                                        <option value='Processing'>Processing

                                                                        </option>

                                                                        <option value='Delivered'>Delivered

                                                                        </option>

                                                                        <option value='COD'>COD

                                                                        </option>

                                                                        <option value='Returned'>Returned

                                                                        </option>

                                                                        <option value='Cancelled'>Cancelled </option>

                                                                    </select>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                            </div>

                                            <div class="modal-button">

                                                <div class="button-items ">

                                                    <button type="submit"
                                                        class="btn btn-primary waves-effect">Submit</button>

                                                    <button type="button" class="btn btn-secondary waves-effect"
                                                        data-dismiss="modal">Cancel</button>

                                                </div>

                                            </div>

                                            </form>

                                        </div><!-- /.modal-content -->

                                    </div><!-- /.modal-dialog -->

                                </div><!-- /.modal -->

                            </div>

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
@endsection

@section('scripts')
    <script type="text/javascript">
        function edit(id) {

            $.ajax({

                url: "{{ route('suborders.suborders') }}",

                type: "GET",

                data: {

                    _token: '{{ csrf_token() }}',

                    type: "edit",

                    id: id,

                },

                success: function(response) {

                    //  console.log(response.edit_suborders);

                    $(response.edit_suborders).each(function(index, value) {

                        $('#payment_status').val(value.payment_status);

                        $('#hidden_id').val(value.id);

                        $('#order_id').val(value.orders_id);

                        $('#condition').val(value.status);

                    });

                    $(response.get_customer).each(function(index, value) {

                        $('#customer_name').val(value.name);

                    });

                    $(response.get_vendor).each(function(index, value) {

                        $('#vendor_name').val(value.vendor_name);

                    });

                }

            })

        }
    </script>
@endsection

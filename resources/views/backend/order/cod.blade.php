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

                            <li class="breadcrumb-item active">COD Orders</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Orders</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">COD Orders</h4>

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

                                        <th>Order Date</th>

                                        <th>Customer</th>

                                        <th>Order ID</th>

                                        <th>Amount</th>

                                        <th>Status</th>

                                        <th>Actions</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($order as $item)
                                        <tr>

                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('M,d,Y') }}</td>

                                            <td>{{ $item->customer->name }}</td>

                                            <td>{{ $item->order_id }}</td>

                                            <td>₹{{ $item->total }}</td>

                                            <td>

                                                <div class="btn-group m-b-10">

                                                    <span
                                                        class="badge badge-{{ $item->status != 'Pending' ? ($item->status != 'Confirmed' ? ($item->status != 'Processing' ? ($item->status != 'Delivered' ? ($item->status != 'Returned' ? ($item->status != 'Canceled' ? '' : 'danger') : 'info') : 'default') : 'warning') : 'success') : 'warning' }}">{{ $item->status }}</span>

                                                    <!-- dropdown-toggle -->

                                                    <!-- <button type="button" class="btn badge badge-success" data-toggle="dropdown" aria-haspopup="true"

                                                                            aria-expanded="false" id="drp">{{ $item->status }}</button> -->

                                                    <!-- <div class="dropdown-menu">

                                                                            <a class="dropdown-item" href="#">Pending</a>

                                                                            <a class="dropdown-item" href="#">Inprogress</a>

                                                                            <a class="dropdown-item" href="#">Delivered</a>

                                                                            <a class="dropdown-item" href="#">Canceled</a>

                                                                            <a class="dropdown-item" href="#">Canceled</a>

                                                                        </div> -->

                                                </div><!-- /btn-group -->

                                            </td>

                                            <td>

                                                <div class="btn-group m-b-10">

                                                    <button type="button" class="btn btn-action dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">Actions</button>

                                                    <div class="dropdown-menu">

                                                        @can('COD View')
                                                            <a class="dropdown-item"
                                                                href="{{ route('view_detail', $item->id) }}">View</a>
                                                        @endcan

                                                        <!--<a class="btn waves-effect waves-light" data-toggle="modal"-->

                                                        <!--    data-target=".bs-example-modal-center">Delete</a>-->

                                                    </div>

                                                </div><!-- /btn-group -->

                                            </td>

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

    <!-- END wrapper -->
@endsection

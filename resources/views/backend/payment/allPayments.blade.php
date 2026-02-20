@extends('backend.layouts.master')

@section('content')
    @include('backend.layouts.notification')

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="#"> Payment</a></li>

                            <li class="breadcrumb-item active">All Payments</li>

                        </ol>

                    </div>

                    <h5 class="page-title">All Payments</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">All Payments</h4>

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

                                        <th>Date</th>

                                        <th>Payment Method</th>

                                        <th>Transaction Number</th>

                                        <th>User</th>

                                        <th>Amount</th>

                                        <th>Status</th>

                                        <th> Actions</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <tr>

                                        <td><img src="" class="" atl=""> </td>

                                        <td>solid </td>

                                        <td>ebay </td>

                                        <td>12,000 </td>

                                        <td>1 </td>

                                        <td>

                                            <div class="btn-group m-b-10">

                                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false"
                                                    id="drp">Pending</button>

                                                <div class="dropdown-menu">

                                                    <a class="dropdown-item" href="#">Pending</a>

                                                    <a class="dropdown-item" href="#">Inprogress</a>

                                                    <a class="dropdown-item" href="#">Delivered</a>

                                                    <a class="dropdown-item" href="#">Canceled</a>

                                                </div>

                                            </div><!-- /btn-group -->

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

                                                    <a class="btn waves-effect waves-light" data-toggle="modal"
                                                        data-dismiss="modal"
                                                        data-target=".bs-example-modal-center1">View</a>

                                                </div>

                                            </div><!-- /btn-group -->

                                        </td>

                                    </tr>

                                    <tr>

                                        <td><img src="" class="" atl=""> </td>

                                        <td>solid </td>

                                        <td>ebay </td>

                                        <td>12,000 </td>

                                        <td>1 </td>

                                        <td>

                                            <div class="btn-group m-b-10">

                                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false"
                                                    id="drp">Pending</button>

                                                <div class="dropdown-menu">

                                                    <a class="dropdown-item" href="#">Pending</a>

                                                    <a class="dropdown-item" href="#">Inprogress</a>

                                                    <a class="dropdown-item" href="#">Delivered</a>

                                                    <a class="dropdown-item" href="#">Canceled</a>

                                                </div>

                                            </div><!-- /btn-group -->

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

                                                    <a class="btn waves-effect waves-light" data-toggle="modal"
                                                        data-dismiss="modal"
                                                        data-target=".bs-example-modal-center1">View</a>

                                                </div>

                                            </div><!-- /btn-group -->

                                        </td>

                                    </tr>

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

                            <div class="col-sm-6 col-md-12 m-t-30">

                                <div class="modal fade bs-example-modal-center1" tabindex="-1" role="dialog"
                                    aria-labelledby="mySmallModalLabel" aria-hidden="true">

                                    <div class="modal-dialog modal-dialog-centered">

                                        <div class="modal-content">

                                            <div class="modal-header">

                                                <h5 class="modal-title mt-0">View</h5>

                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">

                                                    <span aria-hidden="true">&times;</span>

                                                </button>

                                            </div>

                                            <div class="modal-body">

                                                <form>

                                                    <div class="row">

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Date</label>

                                                                <div class="col-sm-10">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter Name" disabled
                                                                        id="example-text-input">

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Payment Method</label>

                                                                <div class="col-sm-10">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter Name" disabled
                                                                        id="example-text-input">

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Transaction
                                                                    Number</label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter Name" disabled
                                                                        id="example-text-input">

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">User</label>

                                                                <div class="col-sm-10">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter Name" disabled
                                                                        id="example-text-input">

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Amount</label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter Name" disabled
                                                                        id="example-text-input">

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Status</label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="" disabled id="example-text-input">

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </form>

                                            </div>

                                            <div class="modal-button">

                                                <div class="button-items">

                                                    <button type="button" class="btn btn-secondary waves-effect"
                                                        data-dismiss="modal">Cancel</button>

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
    <script>
        $('input[name=toogle]').change(function() {

            // var mode = $(this).prop('checked');

            var id = $(this).val();

            // alert(id);

            $.ajax({

                url: "{{ route('payment_status') }}",

                type: "POST",

                data: {

                    _token: '{{ csrf_token() }}',

                    mode: mode,

                    id: id,

                },

                success: function(response) {

                    console.log(response.status);

                }

            })

        });
    </script>

    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
@endsection

@extends('backend.layouts.master')

@section('content')
    @include('backend.layouts.notification')

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="#"> Purchase</a></li>

                            <li class="breadcrumb-item active">Invoice</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Invoice</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Invoice</h4>

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

                                        <th>Invoice Number</th>

                                        <th>Vendor</th>

                                        <th>Purchase Order</th>

                                        <th>Invoice Date</th>

                                        <!-- <th>Tax Value</th> -->

                                        <th>Total Amount</th>

                                        <th>Payment Status </th>

                                        <th>Invoice PDF</th>

                                        <th> Actions</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($invoice as $item)
                                        @if (!empty($item->invoice_id))
                                            <tr>

                                                <td>{{ $item->invoice_id }}</td>

                                                <td>{{ $item->vendor_name }} </td>

                                                <td>{{ $item->purchase_id }} </td>

                                                <td>{{ $item->invoice_date }}</td>

                                                <td>{{ $item->total_amount }} </td>

                                                <td>{{ $item->payment }}</td>

                                                <td><a data-url="{{ asset('uploads/invoices/' . $item->invoice_link) }}"
                                                        class="btn waves-effect waves-light invoicepdf" style="color:red;"
                                                        data-toggle="modal" data-dismiss="modal"
                                                        data-target=".bs-example-modal-center1">{{ $item->invoice_id . '.pdf' }}</a>
                                                </td>

                                                <td>

                                                    <div class="btn-group m-b-10">

                                                        <button type="button" class="btn btn-action dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">Actions</button>

                                                        <div class="dropdown-menu">

                                                            @can('Invoice Edit')
                                                                <a class="dropdown-item"
                                                                    href="{{ route('invoice.edit', $item->id) }}">Edit</a>
                                                            @endcan

                                                            <!-- <a class="btn waves-effect waves-light" href="/admin/invoice/{{ $item->id }}/pdf-invoice" >Save Invoice</a>  -->

                                                        </div>

                                                    </div><!-- /btn-group -->

                                                </td>

                                            </tr>
                                        @endif
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

                            <div class="col-sm-10 col-md-12 m-t-30">

                                <div class="modal fade bs-example-modal-center1" tabindex="-1" role="dialog"
                                    aria-labelledby="mySmallModalLabel" aria-hidden="true">

                                    <div class="modal-dialog modal-dialog-centered" style="max-width: 70%;">

                                        <div class="modal-content">

                                            <div class="modal-header">

                                                <h5 class="modal-title mt-0">Invoice View</h5>

                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">

                                                    <span aria-hidden="true">&times;</span>

                                                </button>

                                            </div>

                                            <div class="modal-body">

                                                <iframe id="invoicepdf" style="width:100%;height:500px;">

                                                </iframe>

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

    </div> <!-- content -->

    </div>

    <!-- End Right content here -->

    </div>

    <!-- END wrapper -->
@endsection

@section('scripts')
    <script>
        $('.invoicepdf').click(function() {

            let url = $(this).data('url');

            $('#invoicepdf').attr('src', url);

        })
    </script>
@endsection

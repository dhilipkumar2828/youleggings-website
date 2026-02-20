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

                            <li class="breadcrumb-item active">Purchase Order</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Purchase Order</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Purchase Order</h4>

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

                                        <th>PO Number</th>

                                        <th>Order Date</th>

                                        <th>Delivery Date</th>

                                        <th>Vendor Name</th>

                                        <!-- <th>Tax Value </th> -->

                                        <th>PO Description</th>

                                        <th>Total Amount </th>

                                        <th>Status</th>

                                        <th> Actions</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($purchaseorder as $item)
                                        <tr>

                                            <td>{{ $item->purchase_order_id }}</td>

                                            <td>{{ \Carbon\Carbon::parse($item->order_date)->format('d-m-Y') }}</td>

                                            <td>{{ $item->delivery_date }}</td>

                                            <td>{{ $item->vendor_name }}</td>

                                            <td>{{ $item->description }}</td>

                                            <td>{{ $item->total_amount }}</td>

                                            <td>

                                                <select class="form-control status" name="status"
                                                    data-id="{{ $item->id }}">

                                                    <option value="">Status</option>

                                                    <option value="Ordered"
                                                        {{ $item->status == 'Ordered' ? 'selected' : '' }}>Ordered
                                                    </option>

                                                    <option value="Partially received"
                                                        {{ $item->status == 'Partially received' ? 'selected' : '' }}>
                                                        Partially received</option>

                                                    <option value="Products received"
                                                        {{ $item->status == 'Products received' ? 'selected' : '' }}>
                                                        Products received</option>

                                                    <option value="Canceled"
                                                        {{ $item->status == 'Canceled' ? 'selected' : '' }}>Canceled
                                                    </option>

                                                    <option value="Refused"
                                                        {{ $item->status == 'Refused' ? 'selected' : '' }}>Refused
                                                    </option>

                                                </select>

                                            </td>

                                            <td>

                                                <div class="btn-group m-b-10">

                                                    <button type="button" class="btn btn-action dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        style="margin-top: 14px;" aria-expanded="false">Actions</button>

                                                    <div class="dropdown-menu">

                                                        <a class="dropdown-item"
                                                            href="{{ route('purchaseorder.show', $item->id) }}">Edit</a>

                                                        @if (\App\Models\Invoice::where(['purchase_order_id' => $item->id])->count() != 1)
                                                            <form action="{{ route('purchaseorder.edit', $item->id) }}">

                                                                @csrf

                                                                <button class="btn waves-effect waves-light order"
                                                                    type="submit">Create Invoice</button>

                                                            </form>
                                                        @endif

                                                        <!-- <a class="btn waves-effect waves-light" data-toggle="modal" data-dismiss="modal"

                                                                                data-target=".bs-example-modal-center">Delete</a><br> -->

                                                        <!-- <a class="btn waves-effect waves-light" data-toggle="modal" data-dismiss="modal"

                                                                                data-target=".bs-example-modal-center1">View</a> -->

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
                                                                    class="col-sm-12 col-form-label">Purchase
                                                                    Request</label>

                                                                <div class="col-sm-10">

                                                                    <select name="" id=""
                                                                        class="form-control" disabled>

                                                                        <option value=""> </option>

                                                                        <option value=""> </option>

                                                                        <option value=""> </option>

                                                                    </select>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">PO Number</label>

                                                                <div class="col-sm-10">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " id="example-text-input"
                                                                        disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">PO Description</label>

                                                                <div class="col-sm-10">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " id="example-text-input"
                                                                        disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Order Date</label>

                                                                <div class="col-sm-10">

                                                                    <input class="form-control" type="date"
                                                                        placeholder="Enter " id="example-text-input"
                                                                        disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Delivery Date</label>

                                                                <div class="col-sm-10">

                                                                    <input class="form-control" type="date"
                                                                        placeholder="Enter " id="example-text-input"
                                                                        disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Product Name</label>

                                                                <div class="col-sm-10">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " id="example-text-input"
                                                                        disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Category</label>

                                                                <div class="col-sm-10">

                                                                    <select name="" id=""
                                                                        class="form-control" disabled>

                                                                        <option value=""> </option>

                                                                        <option value=""> </option>

                                                                        <option value=""> </option>

                                                                    </select>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Brand</label>

                                                                <div class="col-sm-10">

                                                                    <select name="" id=""
                                                                        class="form-control" disabled>

                                                                        <option value=""> </option>

                                                                        <option value=""> </option>

                                                                        <option value=""> </option>

                                                                    </select>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Unit</label>

                                                                <div class="col-sm-10">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " id="example-text-input"
                                                                        disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">PO Amount</label>

                                                                <div class="col-sm-10">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " id="example-text-input"
                                                                        disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Quantity</label>

                                                                <div class="col-sm-10">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " id="example-text-input"
                                                                        disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Tax</label>

                                                                <div class="col-sm-10">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " id="example-text-input"
                                                                        disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Tax Value</label>

                                                                <div class="col-sm-10">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " id="example-text-input"
                                                                        disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Total Amount</label>

                                                                <div class="col-sm-10">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " id="example-text-input"
                                                                        disabled>

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

    </div> <!-- content -->

    </div>

    <!-- End Right content here -->

    </div>

    <!-- END wrapper -->
@endsection

@section('scripts')
    <script>
        $('.status').change(function() {

            var id = $(this).data('id');

            var val = $(this).val();

            $.ajax({

                url: "{{ route('purchaseorder.store') }}",

                type: "POST",

                data: {

                    _token: '{{ csrf_token() }}',

                    id: id,

                    val: val

                },

                success: function(response) {

                    // console.log(response);

                    if (response == "success") {

                        window.location.reload();

                    }

                }

            })

        });
    </script>
@endsection

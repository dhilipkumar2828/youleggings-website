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

                            <li class="breadcrumb-item active">Quotations</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Quotations</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Quotations</h4>

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

                                        <th>Estimate ID</th>

                                        <th>Purchase Request Code</th>

                                        <th>Purchase Request Name</th>

                                        <th>Estimate Date</th>

                                        <th>Vendor Name</th>

                                        <th>Status </th>

                                        <th> Actions</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($quotation as $item)
                                        <tr>

                                            <td> {{ $item->estimate_id }}</td>

                                            <td> {{ $item->purchase_request_id }}</td>

                                            <td>{{ $item->purchase_request_name }} </td>

                                            <td>{{ $item->estimate_date }} </td>

                                            <td> {{ $item->vendor_name }}</td>

                                            <!-- <td>

                                                               <input type="checkbox" name="toogle"  value="{{ $item->id }}" class="status1" data-toggle="switchbutton" {{ $item->status == 'active' ? 'checked' : '' }} data-onlabel="active" data-offlabel="inactive" data-size="sm" data-onstyle="success" data-offstyle="danger">

                                                               </td> -->

                                            <td>

                                                @if (\App\Models\Quotation::where(['purchase_request_id' => $item->id, 'status' => 'Approved'])->count() != 1)
                                                    <span class="badge badge-danger">Not Approved</span>
                                                @else
                                                    <span class="badge badge-success">Approved</span>
                                                @endif

                                            </td>

                                            <td>

                                                <div class="btn-group m-b-10">

                                                    <button type="button" class="btn btn-action dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">Actions</button>

                                                    <div class="dropdown-menu">

                                                        @can('Quotation View')
                                                            <a class="dropdown-item"
                                                                href="{{ route('quotation.show', $item->qid) }}">View</a>
                                                        @endcan

                                                        @if (\App\Models\Quotation::where(['purchase_request_id' => $item->id, 'status' => 'Approved'])->count() == 1)
                                                            <form action="{{ route('quotation.store') }}" method="post">

                                                                @csrf

                                                                <input type="hidden" name="purchase_request_id"
                                                                    value="{{ $item->id }}">

                                                                <input type="hidden" name="quotation_id"
                                                                    value="{{ $item->qid }}">

                                                                @if (count(\App\Models\PurchaseOrder::orderBy('id', 'DESC')->limit('1')->get('id')) > 0)
                                                                    @foreach (\App\Models\PurchaseOrder::orderBy('id', 'DESC')->limit('1')->get('purchase_order_id') as $item)
                                                                        <input type="hidden" name="purchase_order_id"
                                                                            value="PO-0000{{ explode('-', $item->purchase_order_id)[1] + 1 }}"
                                                                            readonly>
                                                                    @endforeach
                                                                @else
                                                                    <input type="hidden" name="purchase_order_id"
                                                                        value="PO-00001" readonly>
                                                                @endif

                                                                <button class="btn waves-effect waves-light order"
                                                                    type="submit"
                                                                    data-id="{{ $item->id . '|' . $item->qid }}">Create
                                                                    Order</button>

                                                            </form>
                                                        @endif

                                                        <!-- <form action="" id="form-{{ $item->id }}" method="post">

                                                            @csrf

                                                            @method('delete')

                                                            <a class="dltBtn btn waves-effect waves-light " title="delete" data-id="{{ $item->id }}" data-toggle="modal" data-dismiss="modal" data-target=".bs-example-modal-center">Delete</a>

                                                        </form> -->

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

                                                    <input class="btn btn-danger delete" type="reset" value="Delete">

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
                                                                    class="col-sm-12 col-form-label">Purchase Request Code
                                                                </label>

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
                                                                    class="col-sm-12 col-form-label">Purchase Request
                                                                    Name</label>

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
                                                                    class="col-sm-4 col-form-label">Unit Price</label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " id="example-text-input"
                                                                        disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Quantity</label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " id="example-text-input"
                                                                        disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Status</label>

                                                                <div class="col-sm-8">

                                                                    <select name="" id=""
                                                                        class="form-control" disabled>

                                                                        <option value=""> </option>

                                                                        <option value=""> </option>

                                                                        <option value=""> </option>

                                                                    </select>

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
        $('.order').click(function() {

            var id = $(this).data('id').split('|')[0];

            var qid = $(this).data('id').split('|')[1];

            // alert(id);

            $.ajax({

                url: "{{ route('createorder') }}",

                type: "POST",

                data: {

                    _token: '{{ csrf_token() }}',

                    id: id,

                    qid: qid

                },

                success: function(response) {

                    //   console.log(response);

                    window.location.reload();

                }

            })

        });
    </script>
@endsection

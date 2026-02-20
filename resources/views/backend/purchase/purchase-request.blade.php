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

                            <li class="breadcrumb-item active">Purchase Request</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Purchase Request</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Purchase Request</h4>

                @can('Purchase Create')
                    <a href="{{ route('purchase.create') }}" id="add-btn" style="color: #ffffff;"> + ADD</a>
                @endcan

            </div>

            <div class="row">

                <div class="col-12">

                    <div class="card m-b-30">

                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>

                                    <tr>

                                        <th>Purchase Request Code</th>

                                        <th>Purchase Request Name</th>

                                        <th>Vendor Name</th>

                                        <!-- <th>Category</th>

                                                            <th>Unit Price</th>

                                                           <th>Quantity </th> -->

                                        <th>Status </th>

                                        <th>Quotation</th>

                                        <th> Actions</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($purchase as $item)
                                        <tr>

                                            <td> {{ $item->purchase_request_id }}</td>

                                            <td>{{ $item->purchase_request_name }} </td>

                                            <td> {{ $item->vendor_name }}</td>

                                            <td>

                                                <input type="checkbox" name="toogle" value="{{ $item->id }}"
                                                    class="status1" data-toggle="switchbutton"
                                                    {{ $item->status == 'active' ? 'checked' : '' }} data-onlabel="active"
                                                    data-offlabel="inactive" data-size="sm" data-onstyle="success"
                                                    data-offstyle="danger">

                                            </td>

                                            <td>

                                                @if (\App\Models\Quotation::where(['purchase_request_id' => $item->id])->count() != 1)
                                                    <span class="badge badge-warning">Pending</span>
                                                @else
                                                    <span class="badge badge-info">Created</span>
                                                @endif

                                            </td>

                                            <td>

                                                <div class="btn-group m-b-10">

                                                    <button type="button" class="btn btn-action dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">Actions</button>

                                                    <div class="dropdown-menu">

                                                        @can('Purchase Edit')
                                                            <a class="dropdown-item"
                                                                href="{{ route('purchase.edit', $item->id) }}">Edit</a>
                                                        @endcan

                                                        <form action="{{ route('purchase.destroy', $item->id) }}"
                                                            id="form-{{ $item->id }}" method="post">

                                                            @csrf

                                                            @method('delete')

                                                            @can('Purchase Delete')
                                                                <a class="dltBtn btn waves-effect waves-light " title="delete"
                                                                    data-id="{{ $item->id }}" data-toggle="modal"
                                                                    data-dismiss="modal"
                                                                    data-target=".bs-example-modal-center">Delete</a>
                                                            @endcan

                                                        </form>

                                                        @if (\App\Models\Quotation::where(['purchase_request_id' => $item->id])->count() != 1)
                                                            <a class="btn waves-effect waves-light quotation"
                                                                data-id="{{ $item->id }}">Create Quotation</a>
                                                        @endif

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
        $('.dltBtn').click(function() {

            var val = $(this).data('id');

            $('.delete').attr('data-id', val);

        });

        $('.delete').click(function() {

            var id = $(this).data('id');

            var form = $('#form-' + id);

            form.submit();

        });

        $('.status1').change(function() {

            var mode = $(this).prop('checked');

            var id = $(this).val();

            // alert(id);

            $.ajax({

                url: "{{ route('purchasestatus') }}",

                type: "POST",

                data: {

                    _token: '{{ csrf_token() }}',

                    mode: mode,

                    id: id,

                },

                success: function(response) {

                    //  console.log(response.status);

                }

            })

        });

        $('.quotation').click(function() {

            var id = $(this).data('id');

            // alert(id);

            $.ajax({

                url: "{{ route('quotationstatus') }}",

                type: "POST",

                data: {

                    _token: '{{ csrf_token() }}',

                    id: id,

                },

                success: function(response) {

                    //   console.log(response);

                    window.location.reload();

                }

            })

        });
    </script>
@endsection

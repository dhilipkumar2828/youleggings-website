@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="#"> Vendor</a></li>

                            <li class="breadcrumb-item active">Merchants</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Merchants</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Merchants</h4>

            </div>

            <div class="col-lg-12">

                @include('backend.layouts.notification')

            </div>

            <div class="row">

                <div class="col-12">

                    <div class="card m-b-30">

                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>

                                    <tr>

                                        <th>Full name</th>

                                        <th>Shop Name</th>

                                        <th>Status</th>

                                        <th> Actions</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($vendor as $item)
                                        <tr>

                                            <td>{{ $item->vendor_name }}</td>

                                            <td><img src="{{ $item->logo }}" class="img img-responsive"
                                                    style="width:25%;">{{ $item->shop_name }}</td>

                                            <td>

                                                <input type="checkbox" name="toogle" value="{{ $item->id }}"
                                                    class="status1" data-toggle="switchbutton"
                                                    {{ $item->status == 'active' ? 'checked' : '' }} data-onlabel="active"
                                                    data-offlabel="inactive" data-size="sm" data-onstyle="success"
                                                    data-offstyle="danger">

                                            </td>

                                            <td>

                                                <div class="btn-group m-b-10">

                                                    <button type="button" class="btn btn-action dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">Actions</button>

                                                    <div class="dropdown-menu">

                                                        <a class="dropdown-item"
                                                            href="{{ route('merchants_edit', $item->id) }}">Edit</a>

                                                        @can('Merchants Edit')
                                                        @endcan

                                                        <form action="{{ route('vendors.destroy', $item->id) }}"
                                                            id="form-{{ $item->id }}" method="post">

                                                            @csrf

                                                            @method('delete')

                                                            @can('Vendor Delete')
                                                                <a class="dltBtn btn waves-effect waves-light " title="delete"
                                                                    data-id="{{ $item->id }}" data-toggle="modal"
                                                                    data-dismiss="modal"
                                                                    data-target=".bs-example-modal-center">Delete</a>
                                                            @endcan

                                                        </form>

                                                        <a class="btn waves-effect waves-light view" data-toggle="modal"
                                                            data-dismiss="modal" data-target=".bs-example-modal-center1"
                                                            data-id="{{ $item }}">View</a>

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

                                                    <button type="button" class="btn btn-secondary waves-effect "
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
                                                                    class="col-sm-4 col-form-label">Full Name</label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " id="vendor_name" disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Shop Name</label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " id="shop_name" disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Gender</label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " id="gender" disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Date of Birth</label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " id="date_of_birth" disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Email</label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control" type="email"
                                                                        placeholder="Enter " id="email" disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Mobile Number</label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " id="mobile_number" disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Address </label>

                                                                <div class="col-sm-8">

                                                                    <textarea class="form-control" type="text" placeholder="Enter " id="address" disabled></textarea>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Pincode</label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " id="pincode" disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-12">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Description</label>

                                                                <div class="col-sm-12">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " id="description" disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-6 col-form-label">Status</label>

                                                                <div class="col-sm-8">

                                                                    <span class="status badge"></span>

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

        $('.view').click(function() {

            var item = $(this).data('id');

            $('#vendor_name').val(item.vendor_name);

            $('#gender').val(item.gender);

            $('#date_of_birth').val(item.date_of_birth);

            $('#email').val(item.email);

            $('#mobile_number').val(item.mobile_number);

            $('#address').html(item.address);

            $('#pincode').val(item.pincode);

            $('#description').val($(item.description).text());

            $('.status').html(item.status);

            $('.status').addClass('badge-success');

        });

        $('.status1').change(function() {

            var mode = $(this).prop('checked');

            var id = $(this).val();

            // alert(id);

            $.ajax({

                url: "{{ route('vendor_status') }}",

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
    </script>
@endsection

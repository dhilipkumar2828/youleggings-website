@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a>Catalogs</a></li>

                            <li class="breadcrumb-item active"><a href="#"> Tax</a></li>

                        </ol>

                    </div>

                    <h5 class="page-title">Catalogs</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Tax</h4>

                @can('tax-add')
                    <a href="{{ route('tax.create') }}" id="add-btn" style="color: #ffffff;"> + ADD</a>
                @endcan

            </div>

            @include('backend.layouts.notification')

            <div class="row">

                <div class="col-12">

                    <div class="card m-b-30">

                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>

                                    <tr>

                                        <th>S.No</th>

                                        <th> Name</th>

                                        <th>Percentage</th>

                                        @if (auth()->user()->can('tax-edit'))
                                            <th>Status</th>
                                        @endif

                                        @if (auth()->user()->can('tax-edit') or auth()->user()->can('tax-delete'))
                                            <th>Actions</th>
                                        @endif

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($tax as $item)
                                        <tr>

                                            <td>{{ $loop->iteration }}</td>

                                            <td> {{ $item->tax_name }}</td>

                                            <td> {{ $item->percentage }} </td>

                                            @if (auth()->user()->can('tax-edit'))
                                                <td><input type="checkbox" name="toogle" class="status"
                                                        value="{{ $item->id }}" data-toggle="toggle"
                                                        {{ $item->status == 'active' ? 'checked' : '' }}
                                                        data-onlabel="active" data-offlabel="inactive" data-size="sm"
                                                        data-onstyle="success" data-offstyle="danger"></td>
                                            @endif

                                            @if (auth()->user()->can('tax-edit') or auth()->user()->can('tax-delete'))
                                                <td>

                                                    <div class="btn-group">

                                                        <button type="button" class="btn btn-action dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">Actions</button>

                                                        <div class="dropdown-menu">

                                                            @can('tax-edit')
                                                                <a class="dropdown-item"
                                                                    href="{{ route('tax.edit', $item->id) }}">Edit</a>
                                                            @endcan

                                                            <form action="{{ route('tax.destroy', $item->id) }}"
                                                                method="post" id="form{{ $item->id }}">

                                                                @csrf

                                                                @method('delete')

                                                                @can('tax-delete')
                                                                    <a class="dltBtn btn waves-effect waves-light"
                                                                        title="delete" data-id="{{ $item->id }}"
                                                                        data-toggle="modal" data-dismiss="modal"
                                                                        data-target=".bs-example-modal-center">Delete</a><br>
                                                                @endcan

                                                            </form>

                                                        </div>

                                                    </div><!-- /btn-group -->

                                                </td>
                                            @endif

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

                                                <p>You are going to delete this Tax. All contents related with this Tax will
                                                    be lost. Do you want to delete it?</p>

                                            </div>

                                            <div class="modal-button">

                                                <div class="button-items">

                                                    <button type="button" class="btn btn-secondary waves-effect"
                                                        data-dismiss="modal">Cancel</button>

                                                    <input class="btn btn-danger delete " type="reset" value="Delete">

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

                                                        <div class="col-md-12">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label"> Name :</label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="" id="example-text-input" disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-12">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label"> Percentage :</label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="" id="example-text-input" disabled>

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

            var form = $('#form' + id);

            form.submit();

        });

        $('.view').click(function() {

            var item = $(this).data('id');

            $('#logo').attr('src', '/uploads/' + item.logo);

            $('#vendor_id').val(item.vendor_id);

            $('#vendor_name').val(item.vendor_name);

            $('#email').val(item.email);

            $('#mobile_number').val(item.mobile_number);

            $('#website').val(item.website);

            $('#address').html(item.address);

            $('#pincode').val(item.pincode);

            $('#bank_name').html(item.bankname);

            $('#branch').val(item.branch);

            $('#account_name').html(item.account_holder_name);

            $('#account_number').val(item.account_number);

            $('#ifsc_code').html(item.ifsc_code);

            $('#tax_name').val(item.tax_name);

            $('#tax_number').val(item.tax_number);

            $('#pan_number').val(item.pan_number);

            $('.status').html(item.status);

            $('.status').addClass('badge-success');

        });

        $('.status').change(function() {

            var mode = $(this).prop('checked');

            var id = $(this).val();

            // alert(id);

            $.ajax({

                url: "{{ route('tax.status') }}",

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

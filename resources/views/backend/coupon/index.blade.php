@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row card" style="width: 100%;margin-left:0px">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb mt-2">

                       <a href="{{ route('coupon.create') }}" class="btn btn-primary px-4 ripple">
                            <i class="fa fa-plus"></i> ADD COUPON
                        </a>

                    </div>

                    <h5 class="page-title">Coupon</h5>

                </div>

            </div>

            <!-- end row -->

            

            <div class="row">

                <div class="col-12">

                    @if ($errors->any())

                        <div class="alert alert-danger">

                            <ul>

                                @foreach ($errors->all() as $error)
                                    <li>

                                        {{ $error }}

                                    </li>
                                @endforeach

                            </ul>

                        </div>

                    @endif

                    <div class="col-lg-12">

                        @include('backend.layouts.notification')

                    </div>

                    <div class="card m-b-30">

                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>

                                    <tr>

                                        <th>S.No</th>

                                        <th>Coupon Name</th>

                                        <th>Coupon Code</th>

                                        <th>Start Date</th>

                                        <th>End Date</th>

                                        <th>Discount Value</th>

                                        <th>Discount Type</th>

                                        @if (auth()->user()->can('coupon-edit'))

                                            <th>Status </th>

                                        @endif

                                        @if (auth()->user()->can('coupon-edit') or auth()->user()->can('coupon-delete') or auth()->user()->can('coupon-view'))

                                            <th> Actions</th>

                                        @endcan

                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($product as $value)
                                    <?php
                                    
                                    if ($value->offer_details == 1) {
                                        $type = 'Flat Offers';
                                    } else {
                                        $type = 'Other Offers';
                                    }
                                    
                                    ?>

                                    <tr>

                                        <td>{{ $loop->iteration }} </td>

                                        <td>{{ $value->coupon_name }}<br><span
                                                class="badge badge-success">{{ $type }}</span></td>

                                        <td>{{ $value->coupon_code }}</td>

                                        <td>{{ $value->start_date }}</td>

                                        <td>{{ $value->end_date }}</td>

                                        <td>{{ $value->value }}</td>

                                        <!-- <td>{{ $value->type }}</td> -->

                                        <td>

                                            @if ($value->discount_type == 'fixed')
                                                <span class="badge badge-success">{{ $value->discount_type }}</span>
                                            @else
                                                <span class="badge badge-primary">{{ $value->discount_type }}</span>
                                            @endif

                                        </td>

                                        <!-- <td>

                                        @if ($value->discount_type == 'promo')
<span class="badge badge-danger">{{ $value->discount_type }}</span>
@else
<span class="badge badge-primary">{{ $value->discount_type }}</span>
@endif

                                    </td> -->

                                        @if (auth()->user()->can('coupon-edit'))
                                            <td>

                                                <input type="checkbox" name="toggle" class="coupon-status-toggle" value="{{ $value->id }}"
                                                    data-toggle="switchbutton"
                                                    {{ $value->Status == 'active' ? 'checked' : '' }}
                                                    data-onlabel="Active" data-offlabel="Inactive" data-size="sm"
                                                    data-onstyle="success" data-offstyle="danger">

                                            </td>
                                        @endif

                                        @if (auth()->user()->can('coupon-edit') or auth()->user()->can('coupon-delete') or auth()->user()->can('coupon-edit'))
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @can('coupon-edit')
                                                        <a href="{{ route('coupon.edit', $value->id) }}"
                                                            class="action-icon btn-edit-icon" data-toggle="tooltip"
                                                            title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan

                                                    @can('coupon-delete')
                                                        <form action="{{ route('coupon.destroy', $value->id) }}"
                                                            id="form-{{ $value->id }}" method="post"
                                                            style="display:inline;">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit"
                                                                class="action-icon btn-delete-icon dltBtn"
                                                                data-id="{{ $value->id }}" data-toggle="tooltip"
                                                                title="Delete">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
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

                                            <p>You are going to delete this category. All contents related with this
                                                category will be lost. Do you want to delete it?</p>

                                        </div>

                                        <div class="modal-button">

                                            <div class="button-items">

                                                <button type="button" class="btn btn-secondary waves-effect"
                                                    data-dismiss="modal">Cancel</button>

                                                <input class="btn btn-danger delete" type="button" value="Delete">

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
                                                                class="col-sm-12 col-form-label">Coupon Name</label>

                                                            <div class="col-sm-10">

                                                                <input class="form-control" type="text"
                                                                    id="coupon_name" placeholder="Enter Name" disabled
                                                                    id="example-text-input">

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="form-group row">

                                                            <label for="example-text-input"
                                                                class="col-sm-12 col-form-label">Coupon Code</label>

                                                            <div class="col-sm-10">

                                                                <input class="form-control" type="text"
                                                                    id="coupon_code" placeholder="Enter Code" disabled
                                                                    id="example-text-input">

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="form-group row">

                                                            <label for="example-text-input"
                                                                class="col-sm-4 col-form-label">Start Date</label>

                                                            <div class="col-sm-8">

                                                                <input class="form-control" type="text"
                                                                    id="start_date" placeholder="Enter Name" disabled
                                                                    id="example-text-input">

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="form-group row">

                                                            <label for="example-text-input"
                                                                class="col-sm-12 col-form-label">End Date</label>

                                                            <div class="col-sm-10">

                                                                <input class="form-control" type="text"
                                                                    id="end_date" placeholder="Enter Name" disabled
                                                                    id="example-text-input">

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="form-group row">

                                                            <label for="example-text-input"
                                                                class="col-sm-4 col-form-label">Discount Values</label>

                                                            <div class="col-sm-8">

                                                                <input class="form-control" type="text"
                                                                    id="value" placeholder="Enter value" disabled
                                                                    id="example-text-input">

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="form-group row">

                                                            <label for="example-text-input"
                                                                class="col-sm-4 col-form-label">Discount Type</label>

                                                            <div class="col-sm-8">

                                                                <input class="form-control" type="text"
                                                                    id="type" placeholder="Enter type" disabled
                                                                    id="example-text-input">

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="form-group row">

                                                            <label for="example-text-input"
                                                                class="col-sm-4 col-form-label">Minimum Order
                                                                Amount</label>

                                                            <div class="col-sm-8">

                                                                <input class="form-control" type="text"
                                                                    id="minimum_order_amount"
                                                                    placeholder="Enter Minimum order amount" disabled
                                                                    id="example-text-input">

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="form-group row">

                                                            <label for="example-text-input"
                                                                class="col-sm-4 col-form-label">Status</label>

                                                            <div class="col-sm-8">

                                                                <span class="badge badge-success status"></span>

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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        // Delete Confirmation
        $(document).on('click', '.dltBtn', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var form = $('#form-' + id);
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        });

        // View Coupon Modal
        $(document).on('click', '.view', function() {
            var item = $(this).data('id');
            $.ajax({
                url: "{{ route('coupon_show') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: item
                },
                success: function(response) {
                    $('#coupon_name').val(response.coupon_name);
                    $('#coupon_code').val(response.coupon_code);
                    $('#value').val(response.value);
                    $('#start_date').val(response.start_date);
                    $('#end_date').val(response.end_date);
                    $('#type').val(response.discount_type);
                    $('#minimum_order_amount').val(response.minimum_order_amount);
                    $('.status').html(response.status);
                }
            })
        });

        // Status Toggle
        $(document).on('change', '.coupon-status-toggle', function() {
            var mode = $(this).prop('checked') ? 'true' : 'false';
            var id = $(this).val();
            $.ajax({
                url: "{{ route('coupon.status') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    mode: mode,
                    id: id,
                },
                success: function(response) {
                    if(response.status) {
                        // success
                    }
                }
            })
        });
    });
</script>
@endsection

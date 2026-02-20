@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="#"> Inventory</a></li>

                            <li class="breadcrumb-item active">Inventory History</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Inventory History</h5>

                </div>

            </div>

            <div class="col-lg-12">

                @include('backend.layouts.notification')

            </div>

            <div class="row">

                <div class="col-sm-12 col-md-6">

                    <div id="datatable-buttons_filter" class="dataTables_filter">

                    </div>

                </div>

                <div class="col-sm-12">

                    <div class="dt-buttons btn-group">

                    </div>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Inventory History</h4>

                <!-- <a href="" id="add-btn" style="color: #ffffff;"> + ADD</a> -->

            </div>

            <div class="row">

                <div class="col-12">

                    <div class="card m-b-30">

                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>

                                    <tr>

                                        <th>Form Code </th>

                                        <th>Product Name</th>

                                        <th>Attribute Name </th>

                                        <th>Attribute Value </th>

                                        <th>Warehouse Code</th>

                                        <th>Warehouse Name</th>

                                        <th>Voucher Date </th>

                                        <th>Opening Stock</th>

                                        <th> Closing Stock</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($inventory as $value)
                                        <tr>

                                            <td>{{ $value->delivery_number }}</td>

                                            <td>{{ $value->product_name }}</td>

                                            <td>{{ $value->attribute_name }}</td>

                                            <td>{{ $value->attribute_value }}</td>

                                            <td>{{ $value->warehouse_code }}</td>

                                            <td>{{ $value->warehouse_name }}</td>

                                            <td>{{ $value->voucher_date }}</td>

                                            <td>{{ $value->open_stock }}</td>

                                            <td>{{ $value->quantity }}</td>

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
                                                                    class="col-sm-12 col-form-label">Form Code </label>

                                                                <div class="col-sm-10">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " disabled
                                                                        id="example-text-input">

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Warehouse Code</label>

                                                                <div class="col-sm-10">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " disabled
                                                                        id="example-text-input">

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Warehouse Name</label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " disabled
                                                                        id="example-text-input">

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Voucher Date</label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="" disabled id="example-text-input">

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Opening Stock</label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="" disabled id="example-text-input">

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Closing Stock</label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="" disabled id="example-text-input">

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Quantity Sold</label>

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

    </div> <!-- content -->
@endsection

@section('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });

        $('.dltBtn').click(function(e) {

            var form = $(this).closest('form');

            var dataID = $(this).data('id');

            e.preventDefault();

            swal({

                    title: "Are you sure?",

                    text: "Once deleted, you will not be able to recover",

                    icon: "warning",

                    buttons: true,

                    dangerMode: true,

                })

                .then((willDelete) => {

                    if (willDelete) {

                        form.submit();

                        swal("Poof! Your imaginary file has been deleted!", {

                            icon: "success",

                        });

                    } else {

                        swal("Your imaginary file is safe!");

                    }

                });

        });
    </script>

    <script>
        $('input[name=toogle]').change(function() {

            var mode = $(this).prop('checked');

            var id = $(this).val();

            // alert(id);

            $.ajax({

                url: "{{ route('product.status') }}",

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
@endsection

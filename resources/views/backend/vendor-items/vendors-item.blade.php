@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="#"> Purchase</a></li>

                            <li class="breadcrumb-item active">Vendor - Items</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Vendor - Items</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Vendor - Items</h4>

                @can('Vendor Item Create')
                    <a href="{{ route('vendoritem.create') }}" id="add-btn" style="color: #ffffff;"> + ADD</a>
                @endcan

            </div>

            <div class="row">

                <div class="col-12">

                    @include('backend.layouts.notification')

                    <div class="card m-b-30">

                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>

                                    <tr>

                                        <th>Vendor Item Code</th>

                                        <th>Vendor Name</th>

                                        <th>Product Name </th>

                                        <th>Category</th>

                                        <th>Brand</th>

                                        <!-- <th>Price</th>

                                                            <th>Unit</th>

                                                            <th>Quantity</th> -->

                                        <th>Image </th>

                                        <th> Actions</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($vendor as $items)
                                        <tr>

                                            <td>{{ $items->vendor_item_id }}</td>

                                            <td>{{ $items->vendor_name }}</td>

                                            <td> {{ $items->title }}</td>

                                            <td> {{ $items->cattitle }}</td>

                                            <td> {{ $items->brandtitle }}</td>

                                            <!-- <td> {{ $items->buying_price }}</td>

                                                                <td></td>

                                                                <td>{{ $items->quantity }}</td> -->

                                            <td><img src="{{ $items->size_guide }}" style="width: 30%;"></td>

                                            <td>

                                                <div class="btn-group m-b-10">

                                                    <button type="button" class="btn btn-action dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">Actions</button>

                                                    <div class="dropdown-menu">

                                                        @can('Vendor Item Edit')
                                                            <a class="dropdown-item"
                                                                href="{{ route('vendoritem.edit', $items->id) }}">Edit</a>
                                                        @endcan

                                                        <!-- <a class="btn waves-effect waves-light delete" data-toggle="modal" data-dismiss="modal"

                                                                                data-target=".bs-example-modal-center">Delete</a><br> -->

                                                        <a class="btn waves-effect waves-light view" data-toggle="modal"
                                                            data-id="{{ $items->id }}|{{ route('vendoritem.show', $items->id) }}"
                                                            data-dismiss="modal"
                                                            data-target=".bs-example-modal-center1">View</a>

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

                                                        <!-- <div class="col-md-12">

                                                                                    <div class="form-group row">

                                                                                        <label for="example-text-input" class="col-sm-4 col-form-label">Logo</label>

                                                                                        <div class="col-sm-8">

                                                                                            <img src=""   id="logo" style="width:100%;">

                                                                                        </div>

                                                                                    </div>

                                                                                </div> -->

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Vendor Code</label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " id="vendor_item_id" disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Vendor Name</label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " id="vendor_name" disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Product Name</label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control" type="text"
                                                                        placeholder="Enter " id="productname" disabled>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-12">

                                                            <div class="form-group row">

                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Product Attribute
                                                                    Details</label>

                                                                <div class="col-sm-12">

                                                                    <table
                                                                        class="table table-bordered dt-responsive nowrap"
                                                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                                                        <thead>

                                                                            <tr>

                                                                                <td>S.No</td>

                                                                                <th>Attribute Type</th>

                                                                                <th>Attribute Value </th>

                                                                                <th>Quantity</th>

                                                                                <th>Buying Price</th>

                                                                                <th>Status</th>

                                                                            </tr>

                                                                        </thead>

                                                                        <tbody id="attributes">

                                                                        </tbody>

                                                                    </table>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <!-- <div class="col-md-6">

                                                                                    <div class="form-group row">

                                                                                        <label for="example-text-input" class="col-sm-6 col-form-label"  >Status</label>

                                                                                        <div class="col-sm-8">

                                                                                          <span class="status badge" ></span>

                                                                                        </div>

                                                                                    </div>

                                                                                </div> -->

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

        $('.view').click(function() {

            var id = $(this).data('id').split('|')[0];

            var url = $(this).data('id').split('|')[1];

            $.ajax({

                url: url,

                type: "GET",

                data: {

                    _token: '{{ csrf_token() }}',

                    id: id,

                },

                success: function(response) {

                    var attributedata = response.attributedata;

                    var vendordata = response.vendordata[0];

                    var productdata = response.product[0];

                    //     $('#logo').attr('src','/uploads/'+item.logo);

                    $('#vendor_item_id').val(vendordata.vendor_item_id);

                    $('#vendor_name').val(vendordata.vendor_name);

                    $('#productname').val(productdata.title);

                    var details = '';

                    $.each(attributedata, function(index, value) {

                        let sta = (value.status == 'active') ? 'badge-success' : 'badge-danger';

                        details += '<tr><td>' + (index + 1) + '</td><td>' + value
                            .attribute_name + '</td><td>' + value.attribute_value +
                            '</td><td>' + value.quantity + '</td><td>' + value.buying_price +
                            '</td><td><span class="status badge ' + sta + '">' + value.status +
                            '</span></td></tr>';

                    });

                    $('#attributes').html(details);

                    //    $('.status').html(item.status);

                    //    $('.status').addClass('badge-success');

                }

            })

        });

        $('.status1').change(function() {

            var mode = $(this).prop('checked');

            var id = $(this).val();

            // alert(id);

            $.ajax({

                url: "{{ route('status') }}",

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

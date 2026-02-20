@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="float-right page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Inventory</a></li>
                            <li class="breadcrumb-item active">Product List</li>
                        </ol>
                    </div>
                    <h5 class="page-title">Inventory</h5>

                </div>
            </div>
            {{-- <!-- end row --}}
            <div class="card m-b-30 card-body">
                <h4 class="card-title font-20 mt-0">Inventory</h4>
                {{-- @can('product create')
                <a href="{{route('product.create')}}" id="add-btn" style="color: #ffffff;"> + ADD</a>
            @endcan --}}
            </div>

            <div class="row">

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
                    <div class="dt-buttons btn-group" style="display:none;">

                        <form action="{{ route('import_file') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file"name="file" id="file">
                            <button class="btn btn-secondary buttons-excel buttons-html5" tabindex="0"
                                aria-controls="datatable-buttons"><span>Import</span></button>
                            {{-- <a class="btn btn-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="datatable-buttons" href="#"><span>Excel</span></a>
                    <a class="btn btn-secondary buttons-pdf buttons-html5" tabindex="0" aria-controls="datatable-buttons" href="#"><span>PDF</span></a> --}}
                            <!-- <input tclass="btn btn-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="datatable-buttons"><span>Import</span>> -->
                            <button ype="submit"class="btn btn-secondary buttons-excel buttons-html5" tabindex="0"
                                aria-controls="datatable-buttons"><span>Import</span></button>
                            <!-- {{-- <a class="btn btn-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="datatable-buttons" href="#"><span>Excel</span></a>
                    <a class="btn btn-secondary buttons-pdf buttons-html5" tabindex="0" aria-controls="datatable-buttons" href="#"><span>PDF</span></a> --}} -->
                            <a class="btn btn-secondary buttons-pdf buttons-html5"tabindex="0"
                                aria-controls="datatable-buttons" href="{{ route('export_file') }}">Export</a>
                        </form>

                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-12">
                    <div>
                        <h4> Total Stockout: {{ count($product) }}</h4>
                    </div>

                    <div class="card m-b-30">
                        <div class="card-body">
                            <table id="example" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Product Size / Stock </th>
                                        @if (auth()->user()->can('products-edit'))
                                            <th> Status</th>
                                        @endif

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product as $pro)
                                        @php

                                            $product1 = DB::table('product_variants')
                                                ->where('product_id', $pro->id)
                                                ->first();
                                            $photo = '';
                                            if (!empty($product1)) {
                                                $photo = $product1->photo;
                                            }
                                        @endphp

                                        <tr>
                                            <td><img src="{{ $photo }}"alt="banner image"
                                                    style="max-height: 90px;max-width:120px"></td>
                                            <td>{{ $pro->name }} </td>
                                            <td>
                                                <?php
                                    $product23=DB::table('product_variants')->where('product_id',$pro->id)->orderBy('id','DESC')->get();
                                    foreach($product23 as $key=>$p){
                                        if($p->in_stock <= 0){
                                            $in_stock = 0;
                                        }else{
                                            $in_stock = $p->in_stock;
                                        }
                                        ?>
                                                <p>{{ str_replace(',', '', $p->variants) }} - {{ $in_stock }}</p>
                                                <?php
                                    }
                                    ?>

                                            </td>

                                            </td>

                                            @if (auth()->user()->can('products-edit'))
                                                <td><input type="checkbox" name="toogle" value="{{ $pro->id }}"
                                                        data-toggle="switchbutton"
                                                        {{ $pro->status == 'active' ? 'checked' : '' }}
                                                        data-onlabel="active" data-offlabel="inactive" data-size="sm"
                                                        data-onstyle="success" data-offstyle="danger"></td>
                                            @endif

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                            <div class="col-sm-6 col-md-12 m-t-30">
                                <div class="modal fade bs-example-modal-center1" tabindex="-1" role="dialog"
                                    aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <img src='#' alt=''style='max-height: 250px;max-width:250px'
                                                    id='photo'>

                                                <h5 class="modal-title mt-0" id="title" style="padding-left: 25px;">
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label"style="font-size: 20px"><b>Summary:</b></label>
                                                                <div class="col-sm-10" id="summary"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label"style="font-size: 20px"><b>Description:</b></label>
                                                                <div class="col-sm-10" id="description"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Price</label>
                                                                <div class="col-sm-10" id="price"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Stock</label>
                                                                <div class="col-sm-10" id="stock"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Offer Price</label>
                                                                <div class="col-sm-10" id="offer_price"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Discount</label>
                                                                <div class="col-sm-10" id="discount"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Category</label>
                                                                <div class="col-sm-10" id="category"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Sub Category</label>
                                                                <div class="col-sm-10" id="sub_category"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Brands</label>
                                                                <div class="col-sm-10" id="brand"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label for="example-text-input"
                                                                    class="col-sm-12 col-form-label">Tax</label>
                                                                <div class="col-sm-10" id="tax"></div>
                                                            </div>
                                                        </div>

                                                        <!-- <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label for="example-text-input" class="col-sm-4 col-form-label">Size</label>
                                                                <div class="col-sm-8">
                                                                <span  class="badge badge-success" id="size"></span>

                                                                </div>
                                                            </div>
                                                        </div>  -->
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Status</label>
                                                                <div class="col-sm-8" id="pstatus">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label for="example-text-input"
                                                                    class="col-sm-4 col-form-label">Conditions</label>
                                                                <div class="col-sm-8">
                                                                    <span class="badge badge-primary"
                                                                        id="conditions"></span>
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

                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
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

            $('.view').click(function() {
                var item = $(this).data('id');
                // alert(item);
                $.ajax({
                    url: "{{ route('product_show') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: item
                    },
                    success: function(response) {
                        //alert(response);
                        // $('#image').src(response.image);
                        document.getElementById("photo").src = response.photo;
                        $('#title').html(response.title);
                        $('#summary').html(response.summary);
                        $('#stock').html(response.stock);
                        $('#description').html(response.description);
                        $('#price').html(response.price);
                        $('#offer_price').html(response.offer_price);
                        $('#discount').html(response.discount);
                        $('#category').html(response.category);
                        $('#sub_category').html(response.sub_category);
                        $('#brand').html(response.brand);
                        $('#tax').html(response.tax_value);
                        $('#conditions').html(response.conditions);
                        if (response.status == 'active') {
                            $('#pstatus').html('<span  class="badge badge-success">' + response.status +
                                '</span>');
                        } else {
                            $('#pstatus').html('<span  class="badge badge-danger">' + response.status +
                                '</span>');

                        }

                    }
                })

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
                        //  console.log(response.status);
                    }
                })
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#example').DataTable({
                    dom: 'Bfrtip', // Ensures buttons are added to the table controls
                    buttons: [{
                        extend: 'excelHtml5', // Correct export type for Excel
                        text: 'Excel Export', // Button text
                        exportOptions: {
                            columns: ':visible' // Specify columns to be exported. Use ':visible' to export visible columns
                        }
                    }],
                    order: [
                        [0, 'desc']
                    ], // Initial sorting of the table
                    iDisplayLength: 25 // Number of rows displayed by default
                });
            });
        </script>
    @endsection

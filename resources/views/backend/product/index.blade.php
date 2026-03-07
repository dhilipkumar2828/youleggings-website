@extends('backend.layouts.master')

@section('content')
    {{-- title modal --}}

    <!-- Modal -->
    <style>
        .dataTables_wrapper .dt-buttons {
            margin-right: 10px;
            /* Add spacing between search and button */
        }

        .dataTables_wrapper .dataTables_filter {
            margin-left: 10px;
            /* Optional: Adjust spacing */
        }

        button.dt-button.btn {
            margin: 0 5px;
            /* Ensure buttons have consistent spacing */
        }
    </style>

    <style>
        @media (max-width: 767px) {
            .buttons-excel {
                margin-top: 40px;
            }
        }
    </style>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Product Heading</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-4 col-form-label">Description <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <textarea class="summernote" required name="description" id="description">{{ strip_tags($heading?->value ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div id="err_head" style="color: red;font-family: 'FontAwesome';display:none">This field is
                            required</div>
                    </div>

                </div>

                {{-- <div id="success_msg" class="alert alert-success">Saved successfully</div> --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="product_heading" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

    {{-- end modal --}}
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="float-right page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a>Catalogs</a></li>
                            <li class="breadcrumb-item"><a href="#"> Product</a></li>
                            <li class="breadcrumb-item active">Add Product</li>
                        </ol>
                    </div>
                    <h5 class="page-title">Catalogs</h5>

                </div>
            </div>

            <div class="card m-b-30 card-body">
                <h4 class="card-title font-20 mt-0">Products</h4>
                {{-- @can('products-add') --}}
                    <!--<button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary" style="margin-top: -63px;border: 1px solid #508aeb;width: 50px;align-items: right;background-color: #508aeb;padding: 3px;border-radius: 0.2rem;align-self: flex-end; margin-right: 10px;">+ Title </button>-->
                    <a href="{{ route('product.create') }}" id="add-btn" style="color: #ffffff;"> + ADD</a>
                {{-- @endcan --}}
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
                            {{-- <a class="btn btn-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="datatable-buttons" href="#" style="display:none"><span>Excel</span></a>
                    <a class="btn btn-secondary buttons-pdf buttons-html5" tabindex="0" aria-controls="datatable-buttons" href="#"><span>PDF</span></a> --}}
                            <!-- <input tclass="btn btn-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="datatable-buttons"><span>Import</span>> -->
                            <button ype="submit"class="btn btn-secondary buttons-excel buttons-html5" tabindex="0"
                                aria-controls="datatable-buttons"><span>Import</span></button>
                            <!-- {{-- <a class="btn btn-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="datatable-buttons" href="#"><span>Excel</span></a>
                    <a class="btn btn-secondary buttons-pdf buttons-html5" tabindex="0" aria-controls="datatable-buttons" href="#"><span>PDF</span></a> --}} -->
                            <a class="btn btn-secondary buttons-pdf buttons-html5"tabindex="0"
                                aria-controls="datatable-buttons" href="{{ route('export_file') }}">Export</a>
                        </form>
                        <!-- <input type="text" id="search-input" class="form-control" placeholder="Search..."> -->

                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-12">
                    <div>
                        <h4>Total Products: {{ $totalProducts }}</h4>
                    </div>

                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row mb-3 d-flex align-items-center" style="gap: 0;">

                                <div class="d-flex align-items-center justify-content-end" style="flex: 0 0 auto;">
                                    <label for="items-per-page" class="mr-2">Show</label>
                                    <select id="items-per-page" class="form-control small-select"
                                        onchange="changeItemsPerPage(this.value)"
                                        style="width: auto; padding: 5px 10px; font-size: 14px; height: 35px;">
                                        <option value="25"
                                            {{ request()->get('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50"
                                            {{ request()->get('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100"
                                            {{ request()->get('per_page', 10) == 100 ? 'selected' : '' }}>100</option>
                                        <option value="250"
                                            {{ request()->get('per_page', 10) == 250 ? 'selected' : '' }}>250</option>
                                        <option value="500"
                                            {{ request()->get('per_page', 10) == 500 ? 'selected' : '' }}>500</option>
                                    </select>
                                    <label for="items-per-page" class="ml-2">Entries</label>
                                </div>
                                <!-- Search Input -->

                                <style>
                                    /* === Desktop layout === */
                                    .inputField {
                                        position: absolute;
                                        top: 88px;
                                        right: 12%;
                                        z-index: 10;
                                    }

                                    .backBtn {
                                        position: absolute;
                                        top: 88px;
                                        right: 5%;
                                        z-index: 10;
                                    }

                                    /* === Mobile fix === */
                                    @media (max-width: 768px) {

                                        .inputField,
                                        .backBtn {
                                            position: static;
                                            /* remove absolute */
                                            width: 100%;
                                            text-align: center;
                                            margin-top: 10px;
                                            z-index: auto;
                                        }

                                        #search-input {
                                            width: 90%;
                                            margin: 0 auto;
                                            display: block;
                                            position: relative;
                                            z-index: 9999;
                                            /* make sure input is above other layers */
                                        }

                                        .backBtn button {
                                            width: 90%;
                                            margin: 10px auto;
                                            display: block;
                                        }
                                    }
                                </style>
                                <!-- Items Per Page Dropdown -->

                            </div>
                        </div>
                        <!--<input type="text" id="search-input" class="form-control" placeholder="Search...">-->
                        <table id="example" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th> <input type="checkbox" id="select-all" style="margin-right: 25px;">
                                    </th>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Category</th>

                                    <th>Sub category</th>
                                    <th>Child category</th>

                                    <th>Regular Price</th>
                                    <th>Stock</th>
                                    <th>Stocks Sold</th>
                                    {{-- @if (auth()->user()->can('products-edit')) --}}
                                        <th> Status</th>
                                    {{-- @endif --}}
                                    {{-- @if (auth()->user()->can('products-edit') or auth()->user()->can('products-delete')) --}}
                                        <th>Actions</th>
                                    {{-- @endif --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product as $key => $pro)
                                    @php
                                        $photo = explode(',', $pro->photo);
                                        $cat = explode(',', $pro->category);

                                        $subcategoryname = '';
                                        if ($pro->subcategory_id) {
                                            $subcategory = DB::table('categories')
                                                ->where('id', $pro->subcategory_id)
                                                ->first();
                                            if (!empty($subcategory)) {
                                                $subcategoryname = $subcategory->title;
                                            }
                                        }
                                        $childcategoryname = '';
                                        if ($pro->childcategory_id) {
                                            $childcategory = DB::table('categories')
                                                ->where('id', $pro->childcategory_id)
                                                ->first();
                                            if (!empty($childcategory)) {
                                                $childcategoryname = $childcategory->title;
                                            }
                                        }

                                        $catstr = [];
                                        $subcatstr = [];
                                        $soldStock = DB::table('order_products')
                                            ->join('orders', 'orders.id', 'order_products.order_id')
                                            ->where('orders.payment_status', 'paid')
                                            ->where('product_id', $pro->id)
                                            ->sum('order_products.quantity');
                                    @endphp
                                    <tr>
                                        <td><input type="checkbox" class="product-checkbox" value="{{ $pro->id }}">
                                        </td>

                                        <td><img src="{{ url($Aproductimg_variant[$key]) }}"alt="product image"
                                                style="max-height: 90px;max-width:120px"></td>
                                        <td>{{ $pro->name }}</td>
                                        <td>

                                            @for ($i = 0; $i < count($cat); $i++)
                                                @php
                                                    $category = DB::table('categories')
                                                        ->where('is_parent', 0)
                                                        ->where('id', $cat[$i])
                                                        ->first();
                                                    $subcategory = DB::table('categories')
                                                        ->where('is_parent', '!=', 0)
                                                        ->where('id', $cat[$i])
                                                        ->first();
                                                    if (!empty($category)) {
                                                        $catstr[] = $category->title;
                                                    }

                                                    if (!empty($subcategory)) {
                                                        $subcatstr[] = $subcategory->title;
                                                    }
                                                @endphp
                                            @endfor
                                            {{ implode(',', $catstr) }}

                                        </td>

                                        <td>
                                            {{ $subcategoryname }}

                                        </td>
                                        <td>
                                            {{ $childcategoryname }}

                                        </td>

                                        <td>{{ $pro->regular_price }} </td>
                                        <td>{{ $pro->stock }} </td>
                                        <td>{{ $soldStock }}</td>
                                        <!-- <td>{{ $pro->size }} </td> -->
                                        {{-- @if (auth()->user()->can('products-edit')) --}}
                                            <td>
                                                <input type="checkbox" name="toogle" value="{{ $pro->id }}"
                                                    data-toggle="switchbutton"
                                                    {{ $pro->status == 'active' ? 'checked' : '' }} data-onlabel="Active"
                                                    data-offlabel="Inactive" data-size="sm" data-onstyle="success"
                                                    data-offstyle="danger">
                                            </td>
                                        {{-- @endif --}}
                                        {{-- @if (auth()->user()->can('products-edit') or auth()->user()->can('products-delete')) --}}
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    {{-- @can('products-edit') --}}
                                                        <!-- Clone -->
                                                        <a href="{{ route('product.edit', $pro->id) }}?clone=true"
                                                            class="action-icon btn-view-icon" data-toggle="tooltip"
                                                            title="Clone">
                                                            <i class="fa fa-copy"></i>
                                                        </a>

                                                        <!-- Edit -->
                                                        <a href="{{ route('product.edit', $pro->id) }}"
                                                            class="action-icon btn-edit-icon" data-toggle="tooltip"
                                                            title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>

                                                        <!-- Update Stocks -->
                                                        <a href="{{ route('updatestockmanually', $pro->id) }}"
                                                            class="action-icon btn-info-icon" data-toggle="tooltip"
                                                            title="Update Stocks">
                                                            <i class="fa fa-tasks"></i>
                                                        </a>
                                                    {{-- @endcan --}}
                                                    <!-- Delete (if separate, add here or if it was in dropdown) -->
                                                </div>

                                                <!--<form action="{{ route('product.destroy', $pro->id) }}" method="post">-->
                                                <!--          @csrf-->
                                                <!--          @method('delete')-->
                                                <!--           @can('products-delete')
        -->
                                                    <!--          <a class="dltBtn btn waves-effect waves-light dropdown-item"title="delete" data-id="{{ $pro->id }}" data-toggle="modal" data-dismiss="modal" data-target=".bs-example-modal-center"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a><br>-->
                                                    <!--
    @endcan-->
                                                <!--      </form>-->

                                            </td>
                                        {{-- @endif --}}

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                        <div class="pagination-wrapper">
                            {{ $product->links() }}
                        </div>
                    </div>
                </div>
                <button id="delete-selected" class="btn btn-danger">Delete Selected</button>

                <button id="active-selected" class="btn btn-success">Active</button>

                <button id="deactive-selected" class="btn btn-danger">Deactive</button>

                <div class="col-sm-6 col-md-12 m-t-30">
                    <div class="modal fade bs-example-modal-center1" tabindex="-1" role="dialog"
                        aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <img src='#' alt=''style='max-height: 250px;max-width:250px'
                                        id='photo'>

                                    <h5 class="modal-title mt-0" id="title" style="padding-left: 25px;"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                                    <label for="example-text-input" class="col-sm-12 col-form-label">Brand
                                                        Name</label>
                                                    <div class="col-sm-10" id="brand_name"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="example-text-input"
                                                        class="col-sm-12 col-form-label">MPN</label>
                                                    <div class="col-sm-10" id="mpn"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="example-text-input"
                                                        class="col-sm-12 col-form-label">GTIN</label>
                                                    <div class="col-sm-10" id="gtin"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="example-text-input" class="col-sm-12 col-form-label">GTIN
                                                        Type</label>
                                                    <div class="col-sm-10" id="gtin_type"></div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label for="example-text-input" class="col-sm-12 col-form-label">Offer Price</label>
                                                                <div class="col-sm-10" id="offer_price"></div>
                                                            </div>
                                                        </div>  -->
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
                                                        class="col-sm-12 col-form-label">Manufactured</label>
                                                    <div class="col-sm-10" id="manufactured"></div>
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
                                                        <span class="badge badge-primary" id="conditions"></span>
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
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js">
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>

    <script>
        jQuery(document).ready(function() {
            $('.summernote').summernote({
                height: 270,
                width: 500, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null // set maximum height of editor

            });
        });
    </script>
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
                    $('#brand_name').html(response.brand_name);
                    $('#description').html(response.description);
                    $('#mpn').html(response.mpn);
                    $('#gtin').html(response.gtin);
                    $('#gtin_type').html(response.gtin_type);
                    // $('#offer_price').html(response.offer_price);
                    $('#discount').html(response.discount);
                    $('#category').html(response.category);
                    // $('#sub_category').html(response.sub_category);
                    $('#manufactured').html(response.brand);
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
                    //console.log(response.status);
                }
            })
        });
    </script>

    <script>
        $('#product_heading').click(function() {

            if ($('textarea#description').val() != "") {
                $('#err_head').css('display', 'none');
                $.ajax({
                    url: "{{ url('product_heading') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        type: 'products',
                        value: $('textarea#description').val(),
                    },
                    success: function(response) {
                        // console.log(response.resval.success);
                        if (response.resval.success) {
                            window.location.reload();
                        }
                    }
                })
            } else {
                $('#err_head').css('display', 'block');
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Handle Select All
            $('#select-all').click(function() {
                if ($(this).is(':checked')) {
                    $('.product-checkbox').prop('checked', true);
                } else {
                    $('.product-checkbox').prop('checked', false);
                }
            });

            // Handle Delete Selected
            $('#delete-selected').click(function() {
                var selectedIds = [];
                $('.product-checkbox:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                if (selectedIds.length > 0) {
                    swal({
                            title: "Are you sure?",
                            text: "Once deleted, you will not be able to recover",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                $.ajax({
                                    url: '{{ route('product.bulk-delete') }}',
                                    type: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        ids: selectedIds
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            window.location.reload();
                                        }
                                    }
                                });
                            } else {
                                swal("Your products are safe!");
                            }
                        });
                } else {
                    swal("Please select at least one product.");
                }
            });

            $('#active-selected').click(function() {
                var selectedIds = [];
                $('.product-checkbox:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                if (selectedIds.length > 0) {
                    swal({
                            title: "Are you sure?",

                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                $.ajax({
                                    url: '{{ route('product.bulkactive') }}',
                                    type: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        ids: selectedIds
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            window.location.reload();
                                        }
                                    }
                                });
                            } else {
                                swal("Your products are safe!");
                            }
                        });
                } else {
                    swal("Please select at least one product.");
                }
            });
            $('#deactive-selected').click(function() {
                var selectedIds = [];
                $('.product-checkbox:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                if (selectedIds.length > 0) {
                    swal({
                            title: "Are you sure?",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                $.ajax({
                                    url: '{{ route('product.bulkdeactive') }}',
                                    type: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        ids: selectedIds
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            window.location.reload();
                                        }
                                    }
                                });
                            } else {
                                swal("Your products are safe!");
                            }
                        });
                } else {
                    swal("Please select at least one product.");
                }
            });
        });

        //      $('tr').click(function(event) {
        //     if (event.target.type !== 'checkbox') {
        //       $('.product-checkbox:checkbox', this).trigger('click');
        //     }
        //   });
    </script>

    <script>
        function changeItemsPerPage(value) {
            const url = new URL(window.location.href);
            url.searchParams.delete('search');
            url.searchParams.set('per_page', value);
            window.location.href = url.toString();
        }
    </script>

    <script>
        $(document).ready(function() {
            var table = $('#example').dataTable({
                "order": [
                    [1, 'desc']
                ],
                "paging": false, // Disable pagination
                "searching": false, // Disable the search box

                dom: '<"d-flex justify-content-between mb-3"Bf>rtip', // Use flexbox for layout
                buttons: [{
                    extend: 'excel',
                    text: 'Excel Export',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7,
                            8
                        ] // Specify columns to export (zero-based index)
                    },
                    className: 'btn btn-secondary' // Optional: Add Bootstrap styling

                }]
            });
        });

        $(document).ready(function() {
            $("#search-input").keypress(function(event) {
                if (event.which == 13) {
                    var inputValue = $('#search-input').val();
                    var url = new URL(window.location.href);
                    url.searchParams.delete('page');

                    url.searchParams.set('search', inputValue); // This will set the 'search' parameter
                    window.location.href = url.toString(); // Redirect with updated URL
                }
            });
        });
    </script>
@endsection

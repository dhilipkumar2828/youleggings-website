@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-left page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="#">Deals of the Day</a></li>

                        </ol>

                    </div>

                    <!-- <h5 class="page-title">Deals of the Day</h5> -->

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Deals of the Day</h4>

                <div class="col-6">

                    <a href="{{ url('deals/event') }}" id="evt-det" style="color: #ffffff;"> + Event Details</a>

                </div>

                <div class="col-12">

                    <a href="{{ route('deals.create') }}" id="add-btn" style="color: #ffffff;"> + ADD</a>

                </div>

            </div>

            <div class="row">

                <div class="col-lg-12">

                    @include('backend.layouts.notification')

                </div>

                <div class="col-12">

                    <div>

                        <h4> Total Deals : {{ \App\Models\Deals::count() }}</h4>

                    </div>

                    <div class="card m-b-30">

                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>

                                    <tr>

                                        <th>S.No</th>

                                        <th>Product Name</th>

                                        <th>Description</th>

                                        <th>Image</th>

                                        <th>Status</th>

                                        <th>Sale Price</th>

                                        <th>Action</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($deals as $item)
                                        @php

                                            $products = DB::table('products')
                                                ->where('status', 'active')
                                                ->where('id', $item->product_name)
                                                ->first();

                                        @endphp

                                        <tr>

                                            <td>{{ $loop->iteration }}</td>

                                            <td> {{ $products->title }}</td>

                                            <td>{!! substr(html_entity_decode($item->description), 0, 200) !!}</td>

                                            <td> <img src="{{ $item->photo }}" alt="banner image"
                                                    style="max-height: 90px;max-width:120px"></td>

                                            <td><input type="checkbox" name="toogle" value="{{ $item->id }}"
                                                    data-toggle="switchbutton"
                                                    {{ $item->status == 'active' ? 'checked' : '' }} data-onlabel="active"
                                                    data-offlabel="inactive" data-size="sm" data-onstyle="success"
                                                    data-offstyle="danger"></td>

                                            <td>

                                                ₹ {{ $item->sale_price }}

                                            </td>

                                            <td>

                                                <div class="btn-group m-b-10">

                                                    <button type="button" class="btn btn-action dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">Actions</button>

                                                    <div class="dropdown-menu">

                                                        <a class="dropdown-item"
                                                            href="{{ route('deals.edit', $item->id) }}">Edit</a>

                                                        <form action="{{ route('deals.destroy', $item->id) }}"
                                                            method="post">

                                                            @csrf

                                                            @method('delete')

                                                            <a class="dltBtn btn waves-effect waves-light"title="delete"
                                                                data-id="{{ $item->id }}" data-toggle="modal"
                                                                data-dismiss="modal"
                                                                data-target=".bs-example-modal-center">Delete</a><br>

                                                        </form>

                                                        <!-- <a class="dropdown-item" href="">Export</a> -->

                                                    </div>

                                                </div> <!--/btn-group -->

                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

                                {{-- <tr>

                                            <td> </td>

                                            <td> </td>

                                            <td><img src="assets/images/cate/img-1.jpg"></td>

                                            <td> </td>

                                            <td>

                                                <div class="btn-group m-b-10">

                                                    <button type="button" class="btn btn-action dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"

                                                        aria-expanded="false">Actions</button>

                                                    <div class="dropdown-menu">

                                                        <a class="dropdown-item" href="create-banner.html">Edit</a>

                                                        <a class="btn waves-effect waves-light" data-toggle="modal" data-dismiss="modal"

                                                            data-target=".bs-example-modal-center">Delete</a><br>

                                                            <a class="btn waves-effect waves-light" data-toggle="modal" data-dismiss="modal"

                                                            data-target=".bs-example-modal-center1">View</a>

                                                    </div>

                                                </div><!-- /btn-group -->

                                            </td>

                                        </tr> --}}

                                {{--

                                </table>

                                <div class="col-sm-6 col-md-3 m-t-30">

                                    <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">

                                        <div class="modal-dialog modal-dialog-centered">

                                            <div class="modal-content">

                                                <div class="modal-header">

                                                    <h5 class="modal-title mt-0">Delete</h5>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                                        <span aria-hidden="true">&times;</span>

                                                    </button>

                                                </div>

                                                <div class="modal-body">

                                                    <p>You are going to delete this category. All contents related with this category will be lost. Do you want to delete it?</p>

                                                </div>

                                                <div class="modal-button">

                                                    <div class="button-items">

                                                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>

                                                        <input class="btn btn-danger" type="reset" value="Delete">

                                                    </div>

                                                </div> --}}

                                {{-- </div><!-- /.modal-content --> --}}

                                {{-- </div><!-- /.modal-dialog -->

                                    </div><!-- /.modal -->

                                </div> --}}

                                {{-- <div class="col-sm-6 col-md-12 m-t-30">

                                    <div class="modal fade bs-example-modal-center1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">

                                        <div class="modal-dialog modal-dialog-centered">

                                            <div class="modal-content">

                                                <div class="modal-header">

                                                    <h5 class="modal-title mt-0">View</h5>

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                                        <span aria-hidden="true">&times;</span>

                                                    </button>

                                                </div>

                                                <div class="modal-body">

                                                    <form>

                                                        <div class="form-group row">

                                                            <label for="example-text-input" class="col-sm-2 col-md-6 col-form-label">Id</label>

                                                            <div class="col-sm-10">

                                                                <input class="form-control" type="text" placeholder="" id="example-text-input" disabled>

                                                            </div>

                                                        </div>

                                                        <div class="form-group row">

                                                            <label for="example-text-input" class="col-sm-2 col-md-6 col-form-label">Title</label>

                                                            <div class="col-sm-10">

                                                                <input class="form-control" type="text" placeholder="Enter Category" id="example-text-input" disabled>

                                                            </div>

                                                        </div>

                                                        <div class="form-group row">

                                                            <label for="example-search-input" class="col-sm-2  col-md-6 col-form-label">Image</label>

                                                            <div class="col-sm-10">

                                                                <input class="form-control" type="file" Placeholder="Enter Child Category" id="example-search-input"

                                                                    disabled>

                                                            </div>

                                                        </div>

                                                        <div class="form-group row">

                                                            <label for="example-text-input" class="col-sm-2 col-md-6 col-form-label">Status</label>

                                                            <!-- <img src="assets/images/image.png" class="admin-image"> -->

                                                            <div class="col-sm-10">

                                                                <input type="text" id="myFile" name="filename" disabled class="form-control">

                                                            </div>

                                                        </div>

                                                    </form>

                                                </div>

                                                <div class="modal-button">

                                                    <div class="button-items">

                                                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>

                                                    </div>

                                                </div>

                                            </div><!-- /.modal-content -->

                                        </div><!-- /.modal-dialog -->

                                    </div><!-- /.modal -->

                                </div> --}}

                        </div>

                    </div>

                </div> <!-- end col -->

            </div> <!-- end row -->

        </div><!-- container fluid -->

    </div> <!-- Page content Wrapper -->

    </div> <!-- content -->

    {{--

     --}}

    </div>
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

                    text: "Once deleted, you will not be able to recover this imaginary file!",

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

            $.ajax({

                url: "{{ route('deals_status') }}",

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

    <style>
        #evt-det {

            color: #ffffff;

            border: 1px solid #508aeb;

            width: 105px;

            float: right;

            align-items: right;

            margin-top: -34px;

            background-color: #508aeb;

            padding: 2px;

            border-radius: 0.2rem;

            align-self: flex-end;

            margin-right: -246px;

        }
    </style>
@endsection

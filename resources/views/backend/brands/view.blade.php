@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="#">Manufacturers</a></li>

                        </ol>

                    </div>

                    <h5 class="page-title">Manufacturers</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Manufacturers</h4>

                @can('Brand Create')
                    <a href="{{ route('brand.create') }}" id="add-btn" style="color: #ffffff;"> + ADD</a>
                @endcan

            </div>

            <div class="row">

                <div class="col-lg-12">

                    @include('backend.layouts.notification')

                </div>

                <div class="col-12">

                    <div>

                        <h4> Total Brands : {{ count($Brands) }}</h4>

                    </div>

                    <div class="card m-b-30">

                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>

                                    <tr>

                                        <th>S.No</th>

                                        <th>Title</th>

                                        <th>Phone</th>

                                        <th>Email</th>

                                        <th>Image</th>

                                        <!--<th>Products</th>-->

                                        <th>Status</th>

                                        <th>Actions</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($Brands as $item)
                                        <tr>

                                            <td>{{ $loop->iteration }} </td>

                                            <td> {{ $item->title }}</td>

                                            <td> {{ $item->phone_number }}</td>

                                            <td> {{ $item->email }}</td>

                                            <td> <img src="{{ $item->brand_logo }}" alt="Manufacturers image"
                                                    style="max-height: 90px;max-width:120px"></td>

                                            <!--<td><span class="badge badge-primary">{{ \App\Models\Product::where('brand_id', $item->id)->count() }}</span></td>-->

                                            <td>

                                                <input type="checkbox" name="toogle" value="{{ $item->id }}"
                                                    data-toggle="switchbutton"
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

                                                        @can('Brand Edit')
                                                            <a class="dropdown-item"
                                                                href="{{ route('brand.edit', $item->id) }}">Edit</a>
                                                        @endcan

                                                        <form action="{{ route('brand.destroy', $item->id) }}"
                                                            method="post">

                                                            @csrf

                                                            @method('delete')

                                                            @can('Brand Delete')
                                                                <a class="dltBtn btn waves-effect waves-light"title="delete"
                                                                    data-id="{{ $item->id }}" data-toggle="modal"
                                                                    data-dismiss="modal"
                                                                    data-target=".bs-example-modal-center">Delete</a><br>
                                                            @endcan

                                                        </form>

                                                        <a class="btn waves-effect waves-light view" data-toggle="modal"
                                                            data-id="{{ $item->id }}" data-dismiss="modal"
                                                            data-target=".bs-example-modal-center1">View</a>

                                                    </div>

                                                </div><!-- /btn-group -->

                                            </td>

                                        </tr>
                                    @endforeach

                            </table>

                        </div>

                    </div> <!-- end col -->

                </div> <!-- end row -->

            </div><!-- container fluid -->

        </div> <!-- Page content Wrapper -->

    </div> <!-- content -->

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
        $('.view').click(function() {

            var item = $(this).data('id');

            // alert(item);

            $.ajax({

                url: "{{ route('brand_show') }}",

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

                    $('#rstatus').html(response.status);

                }

            })

        });

        $('input[name=toogle]').change(function() {

            var mode = $(this).prop('checked');

            var id = $(this).val();

            // alert(id);

            $.ajax({

                url: "{{ route('brandStatus') }}",

                type: "POST",

                data: {

                    _token: '{{ csrf_token() }}',

                    mode: mode,

                    id: id,

                },

                success: function(response) {

                    //   console.log(response.status);

                }

            })

        });
    </script>
@endsection

@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="#">Privacy & Policy</a></li>

                        </ol>

                    </div>

                    <h5 class="page-title">Privacy & Policy</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Privacy & Policy</h4>

                {{-- @can('Privacy Create') --}}
                    <a href="{{ route('privacy.create') }}" id="add-btn" style="color: #ffffff;"> + ADD</a>
                {{-- @endcan --}}

            </div>

            <div class="row">

                <div class="col-lg-12">

                    @include('backend.layouts.notification')

                </div>

                <div class="col-12">

                    <div>

                        <h4> Total Privacy & Policy: {{ \App\Models\Privacy::count() }}</h4>

                    </div>

                    <div class="card m-b-30">

                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>

                                    <tr>

                                        <th>S.No</th>

                                        <th>Title</th>

                                        <th>Description</th>

                                        <th>Actions</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($privacy_pol as $item)
                                        <tr>

                                            <td>{{ $loop->iteration }} </td>

                                            <td> {{ $item->title }}</td>

                                            <td> {!! html_entity_decode($item->description) !!}</td>

                                            <!-- <td> <img src="{{ $item->photo }}" alt="banner image" style="max-height: 90px;max-width:120px"></td> -->

                                            <td>

                                                <div class="btn-group m-b-10">

                                                    <button type="button" class="btn btn-action dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">Actions</button>

                                                    <div class="dropdown-menu">

                                                        {{-- @can('Privacy Edit') --}}
                                                            <a class="dropdown-item"
                                                                href="{{ route('privacy.edit', $item->id) }}">Edit</a>
                                                        {{-- @endcan --}}

                                                        <form action="{{ route('privacy.destroy', $item->id) }}"
                                                            method="post">

                                                            @csrf

                                                            @method('delete')

                                                            {{-- @can('Privacy Delete') --}}
                                                                <a class="dltBtn btn waves-effect waves-light"title="delete"
                                                                    data-id="{{ $item->id }}" data-toggle="modal"
                                                                    data-dismiss="modal"
                                                                    data-target=".bs-example-modal-center">Delete</a><br>
                                                            {{-- @endcan --}}

                                                        </form>

                                                        {{-- <a class="btn waves-effect waves-light" data-toggle="modal" data-dismiss="modal"

                                                            data-target=".bs-example-modal-center1">View</a> --}}

                                                    </div>

                                                </div><!-- /btn-group -->

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
@endsection

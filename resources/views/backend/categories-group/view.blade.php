@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="#">Catelogs</a></li>

                            <li class="breadcrumb-item active">Groups</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Groups</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Groups</h4>

                @can('Category Group Create')
                    <a href="{{ route('category-group.create') }}" id="add-btn" style="color: #ffffff;"> + ADD</a>
                @endcan

            </div>

            <div class="row">

                <div class="col-lg-12">

                    @include('backend.layouts.notification')

                </div>

                <div class="col-12">

                    <div>

                        <h4> Total Category : {{ count($categories) }}</h4>

                    </div>

                    <div class="card m-b-30">

                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>

                                    <tr>

                                        <th>S.No</th>

                                        <th>Category</th>

                                        <th>Image</th>

                                        <th>Sub Group</th>

                                        <th>Status</th>

                                        <th>Actions</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($categories as $item)
                                        <tr>

                                            <td>{{ $loop->iteration }}</td>

                                            <td> {{ $item->title }}</td>

                                            <td><img src="{{ $item->photo }}"alt="banner image"
                                                    style="max-height: 90px;max-width:120px"></td>

                                            <td>{{ \App\Models\Category::where('parent_id', $item->id)->count() }}</td>

                                            <td><input type="checkbox" name="toogle" value="{{ $item->id }}"
                                                    data-toggle="switchbutton"
                                                    {{ $item->status == 'active' ? 'checked' : '' }} data-onlabel="active"
                                                    data-offlabel="inactive" data-size="sm" data-onstyle="success"
                                                    data-offstyle="danger"></td>

                                            <td>

                                                <div class="btn-group m-b-10">

                                                    <button type="button" class="btn btn-action dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">Actions</button>

                                                    <div class="dropdown-menu">

                                                        @can('Category Group Edit')
                                                            <a class="dropdown-item"
                                                                href="{{ route('category-group.edit', $item->id) }}">Edit</a>
                                                        @endcan

                                                        <form action="{{ route('category.destroy', $item->id) }}"
                                                            method="post">

                                                            @csrf

                                                            @method('delete')

                                                            @can('Category Group Delete')
                                                                <a class="dltBtn btn waves-effect waves-light"title="delete"
                                                                    data-id="{{ $item->id }}" data-toggle="modal"
                                                                    data-dismiss="modal"
                                                                    data-target=".bs-example-modal-center">Delete</a><br>
                                                            @endcan

                                                        </form>

                                                        {{-- <a class="btn waves-effect waves-light" data-toggle="modal" data-dismiss="modal"

                                                    data-target=".bs-example-modal-center1">View</a> --}}

                                                    </div>

                                                </div>

                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                            {{-- <div class="col-sm-6 col-md-3 m-t-30">

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

                                                <input class="btn btn-danger" id="reset" type="reset" value="Delete">

                                            </div>

                                        </div>

                                    </div><!-- /.modal-content -->

                                </div><!-- /.modal-dialog -->

                            </div><!-- /.modal -->

                        </div>

                        <div class="col-sm-6 col-md-12 m-t-30">

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

                                                    <label for="example-text-input" class="col-sm-2 col-md-6 col-form-label">Name *</label>

                                                    <div class="col-sm-10">

                                                        <input class="form-control" type="text" placeholder="" id="example-text-input" disabled>

                                                    </div>

                                                </div>

                                                <div class="form-group row">

                                                    <label for="example-text-input" class="col-sm-2 col-md-6 col-form-label">Category</label>

                                                    <div class="col-sm-10">

                                                        <input class="form-control" type="text" placeholder="Enter Category" id="example-text-input" disabled>

                                                    </div>

                                                </div>

                                                <div class="form-group row">

                                                    <label for="example-search-input" class="col-sm-2  col-md-6 col-form-label">Child Category</label>

                                                    <div class="col-sm-10">

                                                        <input class="form-control" type="search" Placeholder="Enter Child Category" id="example-search-input" disabled>

                                                    </div>

                                                </div>

                                                <div class="form-group row">

                                                    <label for="example-text-input" class="col-sm-2 col-md-6 col-form-label">Icon</label>

                                                    <!-- <img src="assets/images/image.png" class="admin-image"> -->

                                                    <div class="col-sm-10">

                                                    <input type="file" id="myFile" name="filename" disabled>

                                                </div>

                                                </div>

                                                <div class="form-group row">

                                                    <label for="example-text-input" class="col-sm-2 col-md-6 col-form-label"> Image</label>

                                                    <!-- <img src="assets/images/image.png" class="admin-image"> -->

                                                    <div class="col-sm-10">

                                                    <input type="file" id="myFile" name="filename" disabled>

                                                </div>

                                                </div>

                                                <div class="form-group row">

                                                    <label for="example-text-input" class="col-sm-2 col-md-6 col-form-label"> Image</label>

                                                    <!-- <img src="assets/images/image.png" class="admin-image"> -->

                                                    <div class="col-sm-10">

                                                    <select class="form-control" disabled>

                                                        <option> </option>

                                                        <option> </option>

                                                        <option> </option>

                                                        </select>

                                                </div>

                                                </div>

                                                <div class="form-group row">

                                                    <label for="example-search-input" class="col-sm-2 col-md-6 col-form-label">Meta Keywords</label>

                                                    <div class="col-sm-10">

                                                        <input class="form-control" type="search" Placeholder="Enter Meta Keywords" id="example-search-input" disabled>

                                                    </div>

                                                </div>

                                                <div class="form-group row">

                                                    <label for="example-search-input" class="col-sm-2col-md-6  col-form-label">Meta Description</label>

                                                    <div class="col-sm-10">

                                                        <textarea class="form-control" type="search" Placeholder="Short Description" id="example-search-input" disabled></textarea>

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
        $('input[name=toogle]').change(function() {

            var mode = $(this).prop('checked');

            var id = $(this).val();

            // alert(id);

            $.ajax({

                url: "{{ route('categorygroup.status') }}",

                type: "POST",

                data: {

                    _token: '{{ csrf_token() }}',

                    mode: mode,

                    id: id,

                },

                success: function(response) {

                    // console.log(response.status);

                }

            })

        });
    </script>
@endsection

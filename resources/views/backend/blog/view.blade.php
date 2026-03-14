@extends('backend.layouts.master')

@section('content')
    {{-- title modal --}}

    <!-- Modal -->

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

                                        <textarea class="summernote" required name="description" id="description" value="{{ old('description') }}">{{ $heading->value ?? '' }}</textarea>

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

            <div class="row card" style="width: 100%;margin-left:0px">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb mt-1">

                                                    <a href="{{ route('blog.create') }}" id="add-btn" style="color: #ffffff;"> + ADD</a>


                    </div>

                    <h5 class="page-title">Blogs</h5>

                </div>

            </div>

            <!-- end row -->

         

            <div class="row">

                <div class="col-lg-12">

                    @include('backend.layouts.notification')

                </div>

                <div class="col-12">

                    <div class="card m-b-30">

                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>

                                    <tr>

                                        <th>S.No</th>

                                        <th>Title</th>

                                        <th>Description</th>

                                        <th>Image</th>

                                        <th>Author</th>

                                        <th>Date</th>

                                        <th>Actions</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($blogs as $item)
                                        <tr>

                                            <td>{{ $loop->iteration }} </td>

                                            <td> {{ $item->title }}</td>

                                            <td>{!! substr(html_entity_decode($item->description), 0, 200) !!}</td>

                                            <td> <img src="{{ image_url($item->photo) }}" alt="banner image"
                                                    style="max-height: 90px;max-width:120px"></td>

                                            <td>

                                                {{ @\App\Models\User::where('id', $item->created_by)->get('name')[0]->name }}
                                            </td>

                                            <td>Published at {{ date('M d,Y', strtotime($item->publish_at)) }}</td>

                                            <td>

                                                <div class="btn-group m-b-10">

                                                    <button type="button" class="btn btn-action dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">Actions</button>

                                                    <div class="dropdown-menu">

                                                        @can('Blog Edit')
                                                            <a class="dropdown-item"
                                                                href="{{ route('blog.edit', $item->id) }}">Edit</a>
                                                        @endcan

                                                        <form action="{{ route('blog.destroy', $item->id) }}"
                                                            method="post">

                                                            @csrf

                                                            @method('delete')

                                                            @can('Blog Delete')
                                                                <a class="dltBtn btn waves-effect waves-light"title="delete"
                                                                    data-id="{{ $item->id }}" data-toggle="modal"
                                                                    data-dismiss="modal"
                                                                    data-target=".bs-example-modal-center">Delete</a><br>
                                                            @endcan

                                                        </form>

                                                        {{-- <a class="btn waves-effect waves-light" data-toggle="modal" data-dismiss="modal"

                                                            data-target=".bs-example-modal-center1">View</a> --}}

                                                    </div>

                                                </div><!-- /btn-group -->

                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

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

                                                        <input class="btn btn-danger" id="reset" type="reset" value="Delete">

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

@endsection

@section('scripts')
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
    </script>

    <script>
        $('#product_heading').click(function() {

            if ($('textarea#description').val() != "") {

                $('#err_head').css('display', 'none');

                $.ajax({

                    url: "{{ url('product_heading') }}",

                    type: "POST",

                    data: {

                        type: 'blogs',

                        _token: '{{ csrf_token() }}',

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
@endsection

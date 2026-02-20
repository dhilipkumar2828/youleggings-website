@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="{{ route('permission.index') }}">Permission</a></li>

                        </ol>

                    </div>

                    <h5 class="page-title">Permission</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Permission</h4>

                @can('Permission Create')
                    <a href="{{ route('permission.create') }}" id="add-btn" style="color: #ffffff;"> + ADD</a>
                @endcan

            </div>

            <div class="row">

                {{--  <div>

                        <h4> Total User : {{\App\Models\User::count()}}</h4>

                    </div>  --}}

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

                                        <th>Permissiongroup Name</th>

                                        <th>Actions</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($permission as $item)
                                        <tr>

                                            <td>{{ $loop->iteration }} </td>

                                            <td> {{ $item->name }}</td>

                                            <td>

                                                <div class="btn-group m-b-10">

                                                    <button type="button" class="btn btn-action dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">Actions</button>

                                                    <div class="dropdown-menu">

                                                        @can('Permission Edit')
                                                            <a class="dropdown-item"
                                                                href="{{ route('permission.edit', $item->id) }}">Edit</a>
                                                        @endcan

                                                        <form action="{{ route('permission.destroy', $item->id) }}"
                                                            method="post">

                                                            @csrf

                                                            @method('delete')

                                                            @can('Permission Delete')
                                                                <a class="dltBtn btn waves-effect waves-light"title="delete"
                                                                    data-id="{{ $item->id }}" data-toggle="modal"
                                                                    data-dismiss="modal"
                                                                    data-target=".bs-example-modal-center">Delete</a><br>
                                                            @endcan

                                                        </form>

                                                        <!-- {{-- <a class="btn waves-effect waves-light" data-toggle="modal" data-dismiss="modal"

                                                            data-target=".bs-example-modal-center1">View</a> --}} -->

                                                    </div>

                                                </div><!-- /btn-group -->

                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

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

    <script>
        $('input[name=toogle]').change(function() {

            var mode = $(this).prop('checked');

            var id = $(this).val();

            // alert(id);

            $.ajax({

                url: "{{ route('user.status') }}",

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

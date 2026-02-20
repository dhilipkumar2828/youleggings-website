@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>

                        </ol>

                    </div>

                    <h5 class="page-title">Role & Permission</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Role & Permission</h4>

                <a href="{{ route('role.create') }}" id="add-btn" style="color: #ffffff;"> + ADD</a>

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

                                        <th>Role Name</th>

                                        <!-- <th>Permission</th> -->

                                        <th>Actions</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($roles as $item)
                                        <tr>

                                            <td>{{ $loop->iteration }} </td>

                                            <td> {{ $item->name }}</td>

                                            <!-- <td>{{ implode(',', $item->permissions->pluck('name')->toArray()) }}</td> -->

                                            <td>

                                                <div class="d-flex align-items-center">
                                                    @can('Role Edit')
                                                        <a href="{{ route('role.edit', $item->id) }}"
                                                            class="action-icon btn-edit-icon" data-toggle="tooltip"
                                                            title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan

                                                    <form action="{{ route('role.destroy', $item->id) }}" method="post"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('delete')
                                                        @can('Role Delete')
                                                            <button type="submit" class="action-icon btn-delete-icon dltBtn"
                                                                data-id="{{ $item->id }}" data-toggle="tooltip"
                                                                title="Delete">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        @endcan
                                                    </form>
                                                </div>

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

@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="#">User Role</a></li>

                            <li class="breadcrumb-item active">User List</li>

                        </ol>

                    </div>

                    <h5 class="page-title">User Role</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">User Role</h4>

                @can('role-add')
                    <a href="{{ 'roleadd' }}" id="add-btn" style="color: #ffffff;"> + ADD</a>
                @endcan

            </div>

            <div class="row">

                <div class="col-12">

                    <div class="card m-b-30">

                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>

                                    <tr>

                                        <th>S.No</th>

                                        {{-- <th>Name</th> --}}

                                        <th>Role</th>

                                        @if (auth()->user()->can('role-edit') or auth()->user()->can('role-delete'))
                                            <th>Actions</th>
                                        @endif

                                    </tr>

                                </thead>

                                <tbody>
                                    @foreach ($roles as $key => $user)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            @if (auth()->user()->can('role-edit') or auth()->user()->can('role-delete'))
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @can('role-edit')
                                                            <!-- Edit -->
                                                            <a href="{{ url('roleedit', $user->id) }}"
                                                                class="action-icon btn-edit-icon" data-toggle="tooltip"
                                                                title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        @endcan

                                                        @can('role-delete')
                                                            <!-- Delete -->
                                                            <form action="{{ url('roledelete', $user->id) }}" method="post"
                                                                style="display:inline;">
                                                                @csrf
                                                                @method('post')
                                                                <button type="button"
                                                                    class="action-icon btn-delete-icon dltBtn"
                                                                    data-id="{{ $user->id }}" data-toggle="tooltip"
                                                                    title="Delete">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div> <!-- end col -->

                </div> <!-- end row -->

            </div><!-- container fluid -->

        </div> <!-- Page content Wrapper -->

    </div> <!-- content -->

    <footer class="footer">

        © 2018 - 2020<b> BMS<b>

    </footer>

    </div>

    <!-- End Right content here -->
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

                url: "",

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

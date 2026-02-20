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

                    <h5 class="page-title">System User </h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">System User </h4>

                @can('user-add')
                    <a href="{{ route('user.create') }}" id="add-btn" style="color: #ffffff;"> + ADD</a>
                @endcan

            </div>

            <div class="row">

                <div class="col-lg-12">

                    @include('backend.layouts.notification')

                </div>

                <div class="col-12">

                    <div>

                        <h4> Total User : {{ \App\Models\User::where('role', '!=', 'customer')->count() }}</h4>

                    </div>

                    <div class="card m-b-30">

                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>

                                    <tr>

                                        <th>S.No</th>

                                        <th>Name</th>

                                        <th>Email</th>

                                        <th>Phone</th>

                                        <th>Role</th>

                                        @if (auth()->user()->can('user-edit') or auth()->user()->can('user-delete'))
                                            <th>Actions</th>
                                        @endif

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($Users as $key => $user)
                                        <tr>

                                            <td>{{ $key + 1 }}</td>

                                            <td>{{ $user->name }}</td>

                                            <td>{{ $user->email }}</td>

                                            <td>{{ $user->phone }}</td>

                                            <td>{{ $user->role }}</td>

                                            @if (auth()->user()->can('user-edit') or auth()->user()->can('user-delete'))
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @can('user-edit')
                                                            <a href="{{ url('user_edit', $user->id) }}"
                                                                class="action-icon btn-edit-icon" data-toggle="tooltip"
                                                                title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        @endcan

                                                        @can('user-delete')
                                                            <form action="{{ url('user_delete', $user->id) }}" method="post"
                                                                style="display:inline;">
                                                                @csrf
                                                                @method('post')
                                                                <button type="submit"
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
    <script>
        $(document).ready(function() {

            // $('#datatable').DataTable({

            //     drawCallback: function(){

            //             alert('check');

            //             switchbtn = new SwitchBtn($('.switch-button'),{});

            //             switchbtn.render();

            //     }

            // });

            //Buttons examples

            var table = $('#datatable-buttons').DataTable({

                lengthChange: false,

                buttons: ['copy', 'excel', 'pdf', 'colvis']

            });

            table.buttons().container()

                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

        });
    </script>

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
        $(document).on('change', 'input[name=toogle]', function(e) {

            //$('input[name=toogle]').change(function () {

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

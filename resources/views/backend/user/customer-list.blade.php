@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <!-- <li class="breadcrumb-item"><a href="#">Drixo</a></li> -->

                            <li class="breadcrumb-item"><a href="#">Admin</a></li>

                            <li class="breadcrumb-item active">Customer List</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Admin</h5>

                </div>

            </div>

            <!-- modal -->

            <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
                aria-labelledby="mySmallModalLabel" aria-hidden="true">

                <div class="modal-dialog modal-dialog-centered">

                    <div class="modal-content">

                        <div class="modal-header">

                            <h5 class="modal-title mt-0">Are you sure?</h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                <span aria-hidden="true">&times;</span>

                            </button>

                        </div>

                        <div class="modal-body">

                            <p>Do you want to continue?</p>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-primary">Yes</button>

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                            </div>

                        </div>

                    </div><!-- /.modal-content -->

                </div><!-- /.modal-dialog -->

            </div><!-- /.modal -->

            <!-- end row -->

            <div class="row">

                <div class="col-12">

                    <div class="card m-b-30">

                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>

                                    <tr>

                                        <th>Name</th>

                                        <th>Mobile</th>

                                        <th>Email</th>

                                        <th>Status</th>

                                        <!-- <th>Actions</th> -->

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($customer as $value)
                                        <tr>

                                            <td>{{ $value->name }}</td>

                                            <td>{{ $value->phone }}</td>

                                            <td>{{ $value->email }}</td>

                                            <td><span
                                                    class="badge badge-{{ $value->status == 'active' ? 'success' : 'danger' }}">{{ $value->status }}</span>
                                            </td>

                                            <!-- <td>    <div class="dropdown mo-mb-2">

                                                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                                                    Action

                                                                </button>

                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                                    @can('Customer View')
        <a class="dropdown-item" href="{{ route('customer.view', $value->id) }}">View</a>
    @endcan

                                                                </div>

                                                            </div></td> -->

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

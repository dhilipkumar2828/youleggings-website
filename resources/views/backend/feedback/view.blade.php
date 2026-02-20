@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a>Appearence</a></li>

                            <li class="breadcrumb-item active">Feedbacks</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Appearence</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Feedbacks</h4>

            </div>

            <div class="row">

                <div class="col-lg-12">

                    @include('backend.layouts.notification')

                </div>

                <div class="col-12">

                    <div>

                        <h4> Total Feedbacks : {{ count($feedbacks) }}</h4>

                    </div>

                    <div class="card m-b-30">

                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>

                                    <tr>

                                        <th>S.No</th>

                                        <th>Name</th>

                                        <th>Phone Number</th>

                                        <th>Status</th>

                                        @if (auth()->user()->can('Client Feedback Delete'))
                                            <th>Actions</th>
                                        @endif

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($feedbacks as $key => $feedback)
                                        <tr>

                                            <td>{{ $key + 1 }}</td>

                                            <td> {{ $feedback->name }}</td>

                                            <td>{{ $feedback->phone_number }}</td>

                                            <td><input type="checkbox" name="toogle" value="{{ $feedback->id }}"
                                                    data-toggle="switchbutton"
                                                    {{ $feedback->status == 'active' ? 'checked' : '' }}
                                                    data-onlabel="active" data-offlabel="inactive" data-size="sm"
                                                    data-onstyle="success" data-offstyle="danger"></td>

                                            @if (auth()->user()->can('Client Feedback Delete'))
                                                <td>

                                                    <div class="btn-group ">

                                                        <button type="button" class="btn btn-action dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">Actions</button>

                                                        <div class="dropdown-menu">

                                                            <form
                                                                action="{{ url('delete_feedback') . '/' . $feedback->id }}"
                                                                method="post">

                                                                @csrf

                                                                <a class="dltBtn btn waves-effect waves-light"
                                                                    title="delete" data-id="{{ $feedback->id }}"
                                                                    data-toggle="modal" data-dismiss="modal"
                                                                    data-target=".bs-example-modal-center">Delete</a><br>

                                                            </form>

                                                        </div>

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

                url: "{{ route('category.status') }}",

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

    <script>
        $('input[name=toogle]').change(function() {

            var mode = $(this).prop('checked');

            var id = $(this).val();

            if (mode == true) {

                mode = "active";

            } else {

                mode = "inactive";

            }

            $.ajax({

                url: "{{ url('update_feedback') }}",

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

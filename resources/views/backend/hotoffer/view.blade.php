@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a>Appearence</a></li>

                            <li class="breadcrumb-item active">Hotoffer</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Appearence</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Hotoffer</h4>

                @can('Hot Offer Create')
                    <a href="{{ url('add_hotoffer') }}" id="add-btn" style="color: #ffffff;"> + ADD</a>
                @endcan

            </div>

            <div class="row">

                <div class="col-lg-12">

                    @include('backend.layouts.notification')

                </div>

                <div class="col-12">

                    <div>

                        <h4> Total Hotoffer : {{ count($offers) }}</h4>

                    </div>

                    <div class="card m-b-30">

                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>

                                    <tr>

                                        <th>S.No</th>

                                        <th>Image</th>

                                        <th>Title</th>

                                        <!-- <th>Start date</th>             -->

                                        <th>Status</th>

                                        @if (auth()->user()->can('Hot Offer Edit') or auth()->user()->can('Hot Offer Delete'))
                                            <th>Actions</th>
                                        @endif

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($offers as $key => $offer)
                                        <tr>

                                            <td>{{ $key + 1 }}</td>

                                            <td><img src="{{ $productimg[$key] }}"
                                                    style="max-height: 90px;max-width:120px" /></td>

                                            <td> {{ $offer->title }}</td>

                                            <!-- <td> {{ $offer->start_date }}</td> -->

                                            <td><input type="checkbox" name="toogle" value="{{ $offer->id }}"
                                                    data-toggle="switchbutton"
                                                    {{ $offer->status == 'active' ? 'checked' : '' }} data-onlabel="active"
                                                    data-offlabel="inactive" data-size="sm" data-onstyle="success"
                                                    data-offstyle="danger"></td>

                                            @if (auth()->user()->can('Hot Offer Edit') or auth()->user()->can('Hot Offer Delete'))
                                                <td>

                                                    <div class="btn-group">

                                                        <button type="button" class="btn btn-action dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">Actions</button>

                                                        <div class="dropdown-menu">

                                                            @can('Hot Offer Create')
                                                                <a class="dropdown-item"
                                                                    href="{{ url('edit_hotoffer') . '/' . $offer->id }}">Edit</a>
                                                            @endcan

                                                            @can('Hot Offer Create')
                                                                <form action="{{ url('delete_hotoffer') . '/' . $offer->id }}"
                                                                    method="post">

                                                                    @csrf

                                                                    <a class="dltBtn btn waves-effect waves-light"
                                                                        title="delete" data-id="{{ $offer->id }}"
                                                                        data-toggle="modal" data-dismiss="modal"
                                                                        data-target=".bs-example-modal-center">Delete</a><br>

                                                                </form>
                                                            @endcan

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

            if (mode == true) {

                mode = "active";

            } else {

                mode = "inactive";

            }

            // alert(id);

            $.ajax({

                url: "{{ url('updatestatus_hotoffer') }}",

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

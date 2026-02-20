@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a>Appearence</a></li>

                            <li class="breadcrumb-item"><a href="#">Offer Banner</a></li>

                        </ol>

                    </div>

                    <h5 class="page-title">Appearence</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Offer Banner</h4>

                @can('Offer Banner Create')
                    <a href="{{ url('offer_bannercreate') }}" id="add-btn" style="color: #ffffff;"> + ADD</a>
                @endcan

            </div>

            <div class="row">

                <div class="col-lg-12">

                    @include('backend.layouts.notification')

                </div>

                <div class="col-12">

                    <div>

                        <h4> Total Offer Banner : {{ \App\Models\Deals::count() }}</h4>

                    </div>

                    <div class="card m-b-30">

                        <div class="card-body">

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>

                                    <tr>

                                        <th>S.No</th>

                                        <!-- <th>Title</th> -->

                                        <th>Image</th>

                                        <!--<th>Details</th>-->

                                        <th>Status</th>

                                        <!-- <th>Condition</th>

                                            <th>Type</th> -->

                                        @if (auth()->user()->can('Offer Banner Edit') or auth()->user()->can('Offer Banner Delete'))
                                            <th>Actions</th>
                                        @endif

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($deals as $key => $d)
                                        <tr>

                                            <td>{{ $key + 1 }}</td>

                                            <td> <img src="{{ $d->photo }}" alt="banner image"
                                                    style="max-height: 90px;max-width:120px;"></td>

                                            <td><input type="checkbox" name="toogle" value="{{ $d->id }}"
                                                    data-toggle="switchbutton" {{ $d->status == 'active' ? 'checked' : '' }}
                                                    data-onlabel="active" data-offlabel="inactive" data-size="sm"
                                                    data-onstyle="success" data-offstyle="danger"></td>

                                            @if (auth()->user()->can('Offer Banner Edit') or auth()->user()->can('Offer Banner Delete'))
                                                <td>

                                                    <div class="btn-group">

                                                        <button type="button" class="btn btn-action dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">Actions</button>

                                                        <div class="dropdown-menu">

                                                            @can('Offer Banner Edit')
                                                                <a class="dropdown-item"
                                                                    href="{{ url('offer_banner_edit') . '/' . $d->id }}">Edit</a>
                                                            @endcan

                                                            @can('Offer Banner Delete')
                                                                <form action="{{ url('offer_banner_delete') . '/' . $d->id }}"
                                                                    method="post">

                                                                    @csrf

                                                                    <a class="dltBtn btn waves-effect waves-light"
                                                                        title="delete" data-id="{{ $d->id }}"
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

    </div> <!-- Page content Wrapper -->

    </div> <!-- content -->

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

                url: "{{ url('total_offerbanner_status') }}",

                type: "POST",

                data: {

                    _token: '{{ csrf_token() }}',

                    mode: mode,

                    id: id,

                },

                success: function(response) {

                    //  console.log(response.status);

                }

            })

        });
    </script>
@endsection

@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a>Appearence</a></li>

                            <li class="breadcrumb-item"><a href="{{ route('advertisement.index') }}">Advertisement</a></li>

                        </ol>

                    </div>

                    <h5 class="page-title">Appearence</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Advertisement</h4>

                @can('advertisement-add')
                    <a href="{{ route('advertisement.create') }}" id="add-btn" style="color: #ffffff;"> + ADD</a>
                @endcan

            </div>

            <div class="row">

                <div class="col-lg-12">

                    @include('backend.layouts.notification')

                </div>

                <div class="col-12">

                    <div>

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

                                        @if (auth()->user()->can('advertisement-edit'))
                                            <th>Status</th>
                                        @endif

                                        <!-- <th>Condition</th>

                                            <th>Type</th> -->

                                        @if (auth()->user()->can('advertisement-edit') or auth()->user()->can('advertisement-delete'))
                                            <th>Actions</th>
                                        @endif

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($advertisements as $item)
                                        <tr>

                                            <td>{{ $loop->iteration }} </td>

                                            <!-- <td> {{ $item->title }}</td> -->

                                            <td> <img src="{{ $item->photo }}" alt="banner image"
                                                    style="max-height: 90px;max-width:120px"></td>

                                            <!--<td> {!! $item->description !!}</td>-->

                                            @if (auth()->user()->can('advertisement-edit'))
                                                <td><input type="checkbox" name="toogle" value="{{ $item->id }}"
                                                        data-toggle="switchbutton"
                                                        {{ $item->status == 'active' ? 'checked' : '' }}
                                                        data-onlabel="active" data-offlabel="inactive" data-size="sm"
                                                        data-onstyle="success" data-offstyle="danger"></td>
                                            @endif

                                            <!-- <td>
                                                @if ($item->condition == 'banner')
    <span class="badge badge-success">{{ $item->condition }}</span>
@else
    <span class="badge badge-primary">{{ $item->condition }}</span>
    @endif
                                            </td>
                                            <td>
                                                @if ($item->type == 'promo')
    <span class="badge badge-success">{{ $item->type }}</span>
@else
    <span class="badge badge-primary">{{ $item->type }}</span>
    @endif
                                            </td> -->
                                            @if (auth()->user()->can('advertisement-edit') or auth()->user()->can('advertisement-delete'))
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @can('advertisement-edit')
                                                            <a href="{{ route('advertisement.edit', $item->id) }}"
                                                                class="action-icon btn-edit-icon" data-toggle="tooltip"
                                                                title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        @endcan

                                                        <form action="{{ route('advertisement.destroy', $item->id) }}"
                                                            method="post" style="display:inline;">
                                                            @csrf
                                                            @method('delete')
                                                            @can('advertisement-delete')
                                                                <button type="submit"
                                                                    class="action-icon btn-delete-icon dltBtn"
                                                                    data-id="{{ $item->id }}" data-toggle="tooltip"
                                                                    title="Delete">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            @endcan
                                                        </form>
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

                url: "{{ url('advertisementStatus') }}",

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

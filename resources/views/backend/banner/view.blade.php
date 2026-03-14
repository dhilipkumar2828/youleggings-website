@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row card m-b-30" style="width: 100%;margin-left:0px">
                <div class="col-md-12">
                    <div class="float-right mt-3">
                        <a href="{{ route('banner.create') }}" class="btn btn-primary ripple px-4">
                            <i class="fa fa-plus"></i> Add Banner
                        </a>
                    </div>
                        <h5 class="page-title m-0">Home Banners</h5>
                </div>
            </div>


            <div class="row">

                <div class="col-lg-12">
                    @include('backend.layouts.notification')
                </div>

                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Image / Video</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($banners as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }} </td>
                                                <td>
                                                    <div class="table-thumb-wrapper">
                                                        @if ($item->photo && preg_match('/\.(mp4|mov|ogg|qt)$/i', $item->photo))
                                                            <video src="{{ $item->photo }}" class="table-thumbnail-video"
                                                                controls></video>
                                                        @else
                                                            <img src="{{ $item->photo }}" alt="banner image"
                                                                class="table-thumbnail">
                                                        @endif
                                                    </div>
                                                </td>


                                                <td>
                                                    <input type="checkbox" name="toogle" value="{{ $item->id }}"
                                                        data-toggle="switchbutton"
                                                        {{ $item->status == 'active' ? 'checked' : '' }}
                                                        data-onlabel="Active" data-offlabel="Inactive" data-size="sm"
                                                        data-onstyle="success" data-offstyle="danger">
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <a href="{{ route('banner.edit', $item->id) }}"
                                                            class="action-icon btn-edit-icon" data-toggle="tooltip"
                                                            title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>

                                                        <form action="{{ route('banner.destroy', $item->id) }}"
                                                            method="post" style="display:inline;">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit"
                                                                class="action-icon btn-delete-icon dltBtn"
                                                                data-id="{{ $item->id }}" data-toggle="tooltip"
                                                                title="Delete">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div><!-- container fluid -->
    </div> <!-- Page content Wrapper -->
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
        $(document).on('change', 'input[name=toogle]', function() {
            var mode = $(this).prop('checked') ? 'true' : 'false';
            var id = $(this).val();
            $.ajax({
                url: "{{ route('banner_status') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    mode: mode,
                    id: id,
                },
                success: function(response) {
                    // Success handling
                }
            })
        });
    </script>
@endsection

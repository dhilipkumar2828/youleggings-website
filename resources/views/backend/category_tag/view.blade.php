@extends('backend.layouts.master')

@section('content')
    <style>
        .cat {
            width: 250px;
        }
    </style>
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="float-right page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a>Appearance</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('categorytag.index') }}">Category Tag</a></li>
                        </ol>
                    </div>
                    <h5 class="page-title">Appearance</h5>
                </div>
            </div>

            <!-- Category Tag Card -->
            <div class="card m-b-30 card-body">
                <h4 class="card-title font-20 mt-0">Category Tag</h4>
                @can('banner-add')
                    <a href="{{ route('categorytag.create') }}" id="add-btn" class="btn btn-primary">+ ADD</a>
                @endcan
            </div>

            <div class="row">
                <div class="col-lg-12">
                    @include('backend.layouts.notification')
                </div>
                <div class="col-12">
                    <h4>Total Category Tags: {{ \App\Models\CategoryTag::count() }}</h4>
                    <div class="card m-b-30">
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th class="catee" style="width:70px;">S.No</th>
                                        <th class="cat">Image</th>
                                        <th class="cat">Category Tag</th>
                                        <th class="cat">Category</th>

                                        @can('banner-edit')
                                            <th class="cat">Status</th>
                                        @endcan
                                        @canany(['banner-edit', 'banner-delete'])
                                            <th class="cat">Actions</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tags as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><img src="{{ $item->photo }}" alt="banner image"
                                                    style="max-height: 90px; max-width:120px"></td>
                                            <td>{{ $item->cate_tag }} </td>
                                            <td>{{ $item->link }} </td>

                                            @can('banner-edit')
                                                <td>
                                                    <input type="checkbox" name="toogle" value="{{ $item->id }}"
                                                        data-toggle="switchbutton"
                                                        {{ $item->status == 'active' ? 'checked' : '' }} data-onlabel="active"
                                                        data-offlabel="inactive" data-size="sm" data-onstyle="success"
                                                        data-offstyle="danger">
                                                </td>
                                            @endcan
                                            @canany(['banner-edit', 'banner-delete'])
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-action dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">Actions</button>
                                                        <div class="dropdown-menu">
                                                            @can('banner-edit')
                                                                <a class="dropdown-item"
                                                                    href="{{ route('categorytag.edit', $item->id) }}">Edit</a>
                                                            @endcan

                                                            @can('banner-delete')
                                                                <form action="{{ route('categorytag.destroy', $item->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <a class="dltBtn btn waves-effect waves-light" title="delete"
                                                                        data-id="{{ $item->id }}" data-toggle="modal"
                                                                        data-dismiss="modal"
                                                                        data-target=".bs-example-modal-center">Delete</a><br>
                                                                </form>
                                                            @endcan
                                                        </div>

                                                    </div>
                                                </td>

                                            @endcan
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
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

        $('input[name="toogle"]').change(function() {
            var mode = $(this).prop('checked');
            var id = $(this).val();

            $.ajax({
                url: "{{ route('categorytag_status') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    mode: mode,
                    id: id,
                },
                success: function(response) {
                    // Handle success (optional)
                }
            });
        });
    </script>

    <script>
        $('.dltBtn').click(function(e) {
            var form = $(this).closest('form');
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
@endsection

@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="float-right page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a>Appearence</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('banner.index') }}">Banner</a></li>
                        </ol>
                    </div>
                    <h5 class="page-title">Appearence</h5>

                </div>

            </div>
            <!-- end row -->
            <div class="card m-b-30 card-body">
                <h4 class="card-title font-20 mt-0">Banner</h4>
                {{-- @can('banner-add') --}}
                    <a href="{{ route('banner.create') }}" id="add-btn"> + Add</a>
                {{-- @endcan --}}
            </div>

            <div class="row">

                <div class="col-lg-12">
                    @include('backend.layouts.notification')
                </div>
                <div class="col-12">
                    <div>
                        <h4> Total Banner : {{ \App\Models\Banner::count() }}</h4>
                    </div>

                    <div class="card m-b-30">
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <!-- <th>Title</th> -->
                                        <th>Image</th>
                                        <!--<th>Mobile Image</th>-->

                                        <!--<th>Details</th>-->
                                        {{-- @if (auth()->user()->can('banner-edit')) --}}
                                            <th>Status</th>
                                        {{-- @endif --}}
                                        <!-- <th>Condition</th>
                                            <th>Type</th> -->
                                        {{-- @if (auth()->user()->can('banner-edit') or auth()->user()->can('banner-delete')) --}}
                                            <th>Actions</th>
                                        {{-- @endif --}}
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($banners as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }} </td>
                                            <!-- <td> {{ $item->title }}</td> -->
                                            <td> 
                                                @if($item->photo && preg_match('/\.(mp4|mov|ogg|qt)$/i', $item->photo))
                                                    <video src="{{ $item->photo }}" style="max-height: 90px;max-width:120px" controls></video>
                                                @else
                                                    <img src="{{ $item->photo }}" alt="banner image" style="max-height: 90px;max-width:120px">
                                                @endif
                                            </td>

                                            <!-- <td> <img src="{{ $item->mobile_photo }}"-->
                                            <!--style="max-height: 90px;max-width:120px"></td>-->

                                            <!--<td> {!! $item->description !!}</td>-->
                                            {{-- @if (auth()->user()->can('Banner Edit')) --}}
                                            {{-- @if (auth()->user()->can('banner-edit')) --}}
                                                <td><input type="checkbox" name="toogle" value="{{ $item->id }}"
                                                        data-toggle="switchbutton"
                                                        {{ $item->status == 'active' ? 'checked' : '' }}
                                                        data-onlabel="Active" data-offlabel="Inactive" data-size="sm"
                                                        data-onstyle="success" data-offstyle="danger"></td>
                                            {{-- @endif --}}
                                            {{-- @endif --}}
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
                                            {{-- @if (auth()->user()->can('Banner Edit') or auth()->user()->can('Banner Delete')) --}}
                                            {{-- @if (auth()->user()->can('banner-edit') or auth()->user()->can('banner-delete')) --}}
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        {{-- @can('banner-edit') --}}
                                                            <a href="{{ route('banner.edit', $item->id) }}"
                                                                class="action-icon btn-edit-icon" data-toggle="tooltip"
                                                                title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        {{-- @endcan --}}

                                                        {{-- @can('banner-delete') --}}
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
                                                        {{-- @endcan --}}
                                                    </div>
                                                </td>
                                            {{-- @endif --}}
                                            {{-- @endif --}}
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

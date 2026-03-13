@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="float-right page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                            <li class="breadcrumb-item active">Product Reviews</li>
                        </ol>
                    </div>
                    <h5 class="page-title">Product Reviews</h5>
                </div>
            </div>

            <div class="card m-b-30 card-body">
                <h4 class="card-title font-20 mt-0">Manage Product Reviews</h4>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    @include('backend.layouts.notification')
                </div>
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Product</th>
                                        <th>Customer</th>
                                        <th>Rate</th>
                                        <th>Review</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reviews as $key => $review)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $review->productname->name ?? 'N/A' }}</td>
                                            <td>{{ $review->name }} ({{ $review->email }})</td>
                                            <td>
                                                <span style="color: #f59e0b;">{{ str_repeat('★', $review->rate ?? $review->stars) }}</span>
                                            </td>
                                            <td>{{ \Illuminate\Support\Str::limit($review->review, 50) }}</td>
                                            <td>
                                                <input type="checkbox" name="toggle" class="review-status-toggle" value="{{ $review->id }}"
                                                    data-toggle="switchbutton"
                                                    {{ $review->status == 'active' ? 'checked' : '' }}
                                                    data-onlabel="active" data-offlabel="inactive" data-size="sm"
                                                    data-onstyle="success" data-offstyle="danger">
                                            </td>
                                            <td>
                                                <form action="{{ route('product_review.destroy', $review->id) }}" method="post"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger btn-sm dltBtn"
                                                        data-id="{{ $review->id }}" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
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

        $(document).on('click', '.dltBtn', function(e) {
            var form = $(this).closest('form');
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        });

        $(document).on('change', '.review-status-toggle', function() {
            var mode = $(this).prop('checked') ? 'true' : 'false';
            var id = $(this).val();
            $.ajax({
                url: "{{ route('product_review.status') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    mode: mode,
                    id: id,
                },
                success: function(response) {
                    if(response.status) {
                        // success
                    }
                }
            })
        });
    </script>
@endsection

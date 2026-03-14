@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb & Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="float-right page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Catalog</a></li>
                            <li class="breadcrumb-item active">Categories</li>
                        </ol>
                    </div>
                    <h5 class="page-title">Category Management</h5>
                    <p class="text-muted">Organize your products into logical collections.</p>
                </div>
            </div>

            <!-- Header Card -->
            <div class="card mb-4">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div class="d-flex align-items-center">
                        <div class="stats-item mr-4">
                            <h4 class="mb-0">{{ count($categories) }}</h4>
                            <p class="text-muted mb-0 font-size-12">Total Categories</p>
                        </div>
                    </div>
                    <div>
                        {{-- @can('category-add') --}}
                            <a href="{{ route('category.create') }}" class="btn btn-primary px-4">
                                <i class="dripicons-plus mr-2"></i> Add New Category
                            </a>
                        {{-- @endcan --}}
                    </div>
                </div>
            </div>

            <!-- Notifications -->
            <div class="row">
                <div class="col-12">
                    @include('backend.layouts.notification')
                </div>
            </div>

            <!-- Main Table Card -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="deleteCategoriesForm" method="POST" action="{{ route('category.bulkDelete') }}">
                                @csrf
                                @method('DELETE')

                                <div class="table-responsive">
                                    <table id="datatable" class="table table-hover table-centered mb-0">
                                        <thead>
                                            <tr>
                                                <th style="width: 20px;">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="selectAll">
                                                        <label class="custom-control-label" for="selectAll"></label>
                                                    </div>
                                                </th>
                                                <th>S.No</th>
                                                <th>Category Name</th>
                                                {{-- @if (auth()->user()->can('category-edit')) --}}
                                                    <th>Status</th>
                                                {{-- @endif --}}
                                                {{-- @if (auth()->user()->can('category-edit') ||
                                                        auth()->user()->can('category-delete') ||
                                                        auth()->user()->can('category-view')) --}}
                                                    <th class="text-right">Actions</th>
                                                {{-- @endif --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($categories as $key => $item)
                                                @php
                                                    $subcat = DB::table('categories')
                                                        ->where('parent_id', $item->id)
                                                        ->first();
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                name="category_ids[]" value="{{ $item->id }}"
                                                                id="cat{{ $item->id }}">
                                                            <label class="custom-control-label"
                                                                for="cat{{ $item->id }}"></label>
                                                        </div>
                                                    </td>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td class="font-weight-600">{{ $item->title }}</td>
                                                    {{-- @if (auth()->user()->can('category-edit')) --}}
                                                        <td>
                                                            <input type="checkbox" name="toogle"
                                                                value="{{ $item->id }}" data-toggle="switchbutton"
                                                                {{ $item->status == 'active' ? 'checked' : '' }}
                                                                data-onlabel="Active" data-offlabel="Inactive"
                                                                data-size="sm" data-onstyle="success"
                                                                data-offstyle="danger">
                                                        </td>
                                                    {{-- @endif --}}
                                                    {{-- @if (auth()->user()->can('category-edit') ||
                                                            auth()->user()->can('category-delete') ||
                                                            auth()->user()->can('category-view')) --}}
                                                        <td class="text-right">
                                                            <div class="d-flex align-items-center justify-content-end">

                                                                {{-- @can('category-edit') --}}
                                                                    <!-- Edit -->
                                                                    <a href="{{ route('category.edit', $item->id) }}"
                                                                        class="action-icon btn-edit-icon" data-toggle="tooltip"
                                                                        title="Edit">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                {{-- @endcan --}}

                                                                {{-- @if ($subcat)
                                                                    <!-- View Subcategories -->
                                                                    <a href="{{ url('subcategory_view/' . $item->id) }}"
                                                                        class="action-icon btn-info-icon"
                                                                        data-toggle="tooltip" title="View Subcategories">
                                                                        <i class="fa fa-list"></i>
                                                                    </a>
                                                                @endif --}}

                                                                <!-- Add SubCategory -->
                                                                {{-- <a href="{{ url('subcategory_add/' . $item->id) }}"
                                                                    class="action-icon btn-success-icon"
                                                                    data-toggle="tooltip" title="Add Subcategory">
                                                                    <i class="fa fa-plus-square"></i>
                                                                </a> --}}

                                                                {{-- @can('category-delete') --}}
                                                                    <!-- Delete -->
                                                                    <button type="button"
                                                                        class="action-icon btn-delete-icon dltBtn"
                                                                        data-id="{{ $item->id }}" data-toggle="tooltip"
                                                                        title="Delete">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                {{-- @endcan --}}

                                                            </div>
                                                        </td>
                                                    {{-- @endif --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-4 pt-4 border-top">
                                    <button type="submit" class="btn btn-danger btn-sm" id="bulkDeleteBtn" disabled>
                                        <i class="mdi mdi-trash-can-outline mr-2"></i> Delete Selected
                                    </button>
                                </div>
                            </form>
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
        $(document).ready(function() {
            // Toggle Select All
            $('#selectAll').on('change', function() {
                $('input[name="category_ids[]"]').prop('checked', this.checked);
                toggleBulkDeleteBtn();
            });

            $('input[name="category_ids[]"]').on('change', toggleBulkDeleteBtn);

            function toggleBulkDeleteBtn() {
                const count = $('input[name="category_ids[]"]:checked').length;
                $('#bulkDeleteBtn').prop('disabled', count === 0);
            }

            // Delete Confirmation
            $('.dltBtn').on('click', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                swal({
                    title: "Are you sure?",
                    text: "This category and its associations will be removed.",
                    icon: "warning",
                    buttons: ["Cancel", "Yes, Delete It"],
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        // Create a dynamic form to submit delete request
                        const form = $('<form>', {
                            method: 'POST',
                            action: `{{ route('category.index') }}/${id}`
                        });
                        form.append($('<input>', {
                            type: 'hidden',
                            name: '_token',
                            value: '{{ csrf_token() }}'
                        }));
                        form.append($('<input>', {
                            type: 'hidden',
                            name: '_method',
                            value: 'DELETE'
                        }));
                        form.appendTo('body').submit();
                    }
                });
            });

            // Status Toggle
            $(document).on('change', 'input[name=toogle]', function() {
                const mode = $(this).prop('checked') ? 'true' : 'false';
                const id = $(this).val();
                $.ajax({
                    url: "{{ route('category.status') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        mode: mode,
                        id: id,
                    },
                    success: function(response) {
                        if (response.status) {
                            // swal("Success", response.msg, "success");
                        }
                    }
                });
            });
        });
    </script>
@endsection

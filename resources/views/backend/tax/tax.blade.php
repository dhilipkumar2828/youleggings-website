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
                            <li class="breadcrumb-item active">Tax Settings</li>
                        </ol>
                    </div>
                    <h5 class="page-title">Tax Management</h5>
                    <p class="text-muted">Configure your tax rules and percentages.</p>
                </div>
            </div>

            <!-- Header Card -->
            <div class="card mb-4">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div class="d-flex align-items-center">
                        <div class="stats-item mr-4">
                            <h4 class="mb-0">{{ count($tax) }}</h4>
                            <p class="text-muted mb-0 font-size-12">Total Taxes</p>
                        </div>
                    </div>
                    <div>
                        @can('tax-create')
                            <a href="{{ route('tax.create') }}" class="btn btn-primary px-4">
                                <i class="dripicons-plus mr-2"></i> Add New Tax
                            </a>
                        @endcan
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
                            <div class="table-responsive">
                                <table id="datatable" class="table table-hover table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>Percentage (%)</th>
                                            @if (auth()->user()->can('tax-edit'))
                                                <th>Status</th>
                                            @endif
                                            @if (auth()->user()->can('tax-edit') || auth()->user()->can('tax-delete'))
                                                <th class="text-right">Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tax as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="font-weight-600">{{ $item->tax_name }}</td>
                                                <td>
                                                    <span class="badge badge-light-info px-2 py-1">
                                                        {{ $item->percentage }}%
                                                    </span>
                                                </td>

                                                @if (auth()->user()->can('tax-edit'))
                                                    <td>
                                                        <input type="checkbox" name="toogle" class="status-toggle"
                                                            value="{{ $item->id }}" data-toggle="switchbutton"
                                                            {{ $item->status == 'active' ? 'checked' : '' }}
                                                            data-onlabel="Active" data-offlabel="Inactive"
                                                            data-size="sm" data-onstyle="success"
                                                            data-offstyle="danger">
                                                    </td>
                                                @endif

                                                @if (auth()->user()->can('tax-edit') || auth()->user()->can('tax-delete'))
                                                    <td class="text-right">
                                                        <div class="d-flex align-items-center justify-content-end">
                                                            @can('tax-edit')
                                                                <a href="{{ route('tax.edit', $item->id) }}"
                                                                    class="action-icon btn-edit-icon" data-toggle="tooltip"
                                                                    title="Edit">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                            @endcan

                                                            @if ($item->tax_name != 'Gst')
                                                                @can('tax-delete')
                                                                    <button type="button"
                                                                        class="action-icon btn-delete-icon dltBtn"
                                                                        data-id="{{ $item->id }}" data-toggle="tooltip"
                                                                        title="Delete">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                @endcan
                                                            @endif
                                                        </div>
                                                    </td>
                                                @endif
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
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            // Delete Confirmation
            $('.dltBtn').on('click', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this tax entry!",
                    icon: "warning",
                    buttons: ["Cancel", "Yes, Delete It"],
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        const form = $('<form>', {
                            method: 'POST',
                            action: `{{ route('tax.index') }}/${id}`
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
                    url: "{{ route('tax.status') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        mode: mode,
                        id: id,
                    },
                    success: function(response) {
                        // Handle success if needed
                    }
                });
            });
        });
    </script>
@endsection

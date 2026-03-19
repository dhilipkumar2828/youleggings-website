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
                            <li class="breadcrumb-item active">Attributes</li>
                        </ol>
                    </div>
                    <h5 class="page-title">Attribute Management</h5>
                    <p class="text-muted">Manage product attributes like Size, Color, etc.</p>
                </div>
            </div>

            <!-- Header Card -->
            <div class="card mb-4">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div class="d-flex align-items-center">
                        <div class="stats-item mr-4">
                            <h4 class="mb-0">{{ count($Attribute) }}</h4>
                            <p class="text-muted mb-0 font-size-12">Total Attributes</p>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('attribute.create') }}" class="btn btn-primary px-4">
                            <i class="dripicons-plus mr-2"></i> Add New Attribute
                        </a>
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
                                <table id="datatable" class="table table-hover table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Attribute Type</th>
                                            <th>Attribute Value</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Attribute as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }} </td>
                                                <td> {{ $item->attribute_type }}</td>
                                                <td>
                                                    @php
                                                        $displayValues = $item->value;
                                                        if (is_array($displayValues)) {
                                                            // Clean internal quotes if double encoded strings persist
                                                            $displayValues = array_map(function($v) {
                                                                return is_string($v) ? trim($v, '"') : $v;
                                                            }, $displayValues);
                                                            echo implode(', ', $displayValues);
                                                        } else {
                                                            echo trim($displayValues, '"');
                                                        }
                                                    @endphp
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!-- Edit -->
                                                        <a href="{{ route('attribute.edit', $item->id) }}"
                                                            class="action-icon btn-edit-icon" data-toggle="tooltip"
                                                            title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>

                                                        <!-- Delete -->
                                                        <form action="{{ route('attribute.destroy', $item->id) }}"
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

        // Delete Confirmation
        $('.dltBtn').click(function(e) {
            var form = $(this).closest('form');
            var dataID = $(this).data('id');
            e.preventDefault();
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this attribute!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    </script>
@endsection

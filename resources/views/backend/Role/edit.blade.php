@extends('backend.layouts.master')

@section('content')

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>

                            <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Role</a></li>

                            <li class="breadcrumb-item active">Role</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Role</h5>

                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0"> Role </h4>

                <a href="{{ route('role.index') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
                        aria-hidden="true"></i> Back</a>

            </div>

            <div class="row">

                <div class="col-md-12">

                    @if ($errors->any())
                        <div class="alert alert-danger">

                            <ul>

                                @foreach ($errors->all() as $error)
                                    <li>

                                        {{ $error }}

                                    </li>
                                @endforeach

                            </ul>

                        </div>
                    @endif

                </div>

                <div class="col-12">

                    <div class="card m-b-30">

                        <div class="card-body">

                            <form action="{{ route('role.update', $roles->id) }}" method="post">

                                @csrf

                                @method('PUT')

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Full Name</label>

                                    <div class="col-sm-10">

                                        <input class="form-control" type="text" placeholder="Enter Name"
                                            id="example-text-input" name="name" value="{{ $roles->name }}">

                                    </div>

                                </div>

                                <div>

                                    <input type="checkbox" id="select-all">

                                    <label for="">Select All</label>

                                </div>

                                @if ($permissionGroups->count())
                                    <div class="row">

                                        @foreach ($permissionGroups as $permissionGroup)
                                            <div class="col-md-4">

                                                <div class="form-check">

                                                    <div class="form-check">

                                                        <input type="checkbox" data-id="{{ $permissionGroup->id }}"
                                                            id="gp{{ $permissionGroup->id }}" class="groupcheck">

                                                        <label for="">
                                                            <h4>{{ $permissionGroup->name }}</h4>
                                                        </label>

                                                    </div>

                                                    @if ($permissionGroup->permissions->count())
                                                        @php $i=0; @endphp

                                                        @foreach ($permissionGroup->permissions as $permission)
                                                            <div class="col-sm-10">

                                                                <input
                                                                    @if (in_array($permission->id, $roles->permissions->pluck('id')->toArray())) checked

                                                      {{ $i++ }} @endif
                                                                    value="{{ $permission->id }}" name="permission_ids[]"
                                                                    class="form-check-input pgroup{{ $permissionGroup->id }}"
                                                                    type="checkbox">

                                                                <label class="form-check-label" for="defaultCheck1">

                                                                    {{ $permission->name }}

                                                                </label><br>

                                                            </div>
                                                        @endforeach

                                                        @if ($i == $permissionGroup->permissions->count())
                                                            <script>
                                                                document.getElementById('gp' + {{ $permissionGroup->id }}).checked = true;
                                                            </script>
                                                        @endif
                                                    @endif

                                                </div>

                                            </div>
                                        @endforeach

                                    </div>
                                @endif

                                <div class="d-flex">

                                    <button class="btn btn-primary" type="submit">Submit</button>&nbsp;

                                    <!-- <button class="btn btn-secondary" type="submit">Cancle</button> -->

                                </div>

                            </form>

                        </div>

                    </div>

                </div> <!-- end col -->

            </div> <!-- end row -->

        </div><!-- container fluid -->

    </div> <!-- Page content Wrapper -->

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $('#select-all').click(function() {

                var checked = this.checked;

                $('input[type="checkbox"]').each(function() {

                    this.checked = checked;

                });

            })

        });

        $('.groupcheck').click(function() {

            let id = $(this).data('id');

            if (this.checked == true) {

                $('.pgroup' + id).prop('checked', true);

            } else {

                $('.pgroup' + id).prop('checked', false);

            }

        });
    </script>
@endsection

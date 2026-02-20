@extends('backend.layouts.master')

@section('content')

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>

                            <li class="breadcrumb-item"><a href="{{ route('permission_group.index') }}">Permission Group</a>
                            </li>

                            <li class="breadcrumb-item active">Permission Group</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Permission Group</h5>

                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0"> Permission Group </h4>

                <a href="{{ route('permission_group.index') }}" id="add-btn" style="color: #ffffff;"><i
                        class="fa fa-angle-left" aria-hidden="true"></i> Back</a>

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

                            <form action="{{ route('permission_group.update', $permissiongroup->id) }}" method="post">

                                @csrf

                                @method('PUT')

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Full Name</label>

                                    <div class="col-sm-10">

                                        <input class="form-control" type="text" placeholder="Enter Name"
                                            id="example-text-input" name="name" value="{{ $permissiongroup->name }}">

                                    </div>

                                </div>

                                <div class="d-flex">

                                    <button class="btn btn-primary" type="submit">Submit</button>&nbsp;

                                    <button class="btn btn-secondary" type="submit">Cancel</button>

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
@endsection

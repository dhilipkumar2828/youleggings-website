@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a>Password</a></li>

                            <!--<li class="breadcrumb-item"><a href="{url('/admin')}">Change Password</a></li>-->

                            <li class="breadcrumb-item active">Update Password</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Password</h5>

                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Update Password</h4>

                <a href="{{ url('admin') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
                        aria-hidden="true"></i> Back</a>

            </div>

            <div class="row">

                <div class="col-12">

                    @include('backend.layouts.notification')

                    <div class="card m-b-30">

                        <div class="card-body">

                            <form action="{{ url('update_password') }}" method="post">

                                @csrf

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label" id="category_title">Old
                                        Password</label>

                                    <div class="col-sm-10">

                                        <input class="form-control" required type="text" placeholder="Enter Old password"
                                            id="old_password" name="old_password"value="{{ old('old_password') }}">

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="status" class="col-sm-2 col-form-label">New Password</label>

                                    <div class="col-sm-10">

                                        <input class="form-control" required type="text" placeholder="Enter New password"
                                            id="old_password" name="new_password" value="{{ old('new_password') }}">

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="status" class="col-sm-2 col-form-label">Confirm Password</label>

                                    <div class="col-sm-10">

                                        <input class="form-control" required type="text"
                                            placeholder="Confirm New password" id="confirm_password" name="confirm_password"
                                            value="{{ old('confirm_password') }}">

                                    </div>

                                    @if (Session::has('message'))
                                        <div class="alert alert-info">{{ Session::get('message') }}</div>
                                    @endif

                                </div>

                                <!-- <div class="form-group row">

                                    <label for="status" class="col-sm-2 col-form-label">Bg-color</label>

                                    <div class="col-sm-10">

                                    <input type="color" id="bg_color" name="bg_color">

                                    </div>

                                </div> -->

                                <div class="d-flex">

                                    <button class="btn btn-primary" type="submit">Update</button>&nbsp;

                                    <button class="btn btn-secondary" id="reset" type="Reset">Cancel</button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div> <!-- end col -->

            </div> <!-- end row -->

        </div><!-- container fluid -->

    </div>
@endsection

@section('scripts')
@endsection

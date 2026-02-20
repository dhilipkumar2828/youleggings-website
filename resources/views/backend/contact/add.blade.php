@extends('backend.layouts.master')

@section('content')

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>

                            <li class="breadcrumb-item"><a href="{{ route('contact.index') }}">Banner</a></li>

                            <li class="breadcrumb-item active">Create Contact</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Create Contact</h5>

                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Create Contact</h4>

                <a href="{{ route('contact.index') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
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

                            <!-- <h4 class="mt-0 header-title">Textual inputs</h4>

                                    <p class="text-muted m-b-30 font-14">Here are examples of <code

                                            class="highlighter-rouge">.form-control</code> applied to each

                                        textual HTML5 <code class="highlighter-rouge">&lt;input&gt;</code> <code

                                                class="highlighter-rouge">type</code>.</p> -->

                            <form action="{{ route('contact.store') }}" method="post">

                                @csrf

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Title <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <input class="form-control" required type="text" placeholder="Enter Title"
                                            id="example-text-input" name="title">

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Address <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <input class="form-control" required type="text" placeholder="Enter address"
                                            id="example-text-input" name="address">

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Email <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <input class="form-control" required type="text" placeholder="Enter Email"
                                            id="example-text-input" name="email">

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Mobile <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <input class="form-control" required type="text" placeholder="Enter Mobile"
                                            id="example-text-input" name="mobile">

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Image <span
                                            style="color:red">*</span></label>

                                    <!-- <img src="assets/images/image.png" class="admin-image"> -->

                                    <div class="col-sm-10">

                                        <div class="input-group d-flex align-items-center"
                                            style="border: 1px dashed #ced4da; border-radius: 8px; padding: 0 5px; background: #fff; height: 45px;">
                                            <span class="input-group-btn" style="margin-right:0;">
                                                <a id="lfm" data-input="thumbnail" data-preview="holder"
                                                    class="btn btn-primary ripple"
                                                    style="border-radius: 6px; padding: 6px 12px;">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="thumbnail" required class="form-control" type="text"
                                                value="" name="photo"
                                                style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;"
                                                placeholder="Select an image...">
                                        </div>

                                        <div id="holder" style="margin-top:15px;max-height:100px;"></div>

                                    </div>

                                </div>

                                <div class="d-flex">

                                    <button class="btn btn-primary" type="submit">Submit</button>&nbsp;

                                    <button class="btn btn-secondary" id="reset" type="Reset">Cancel</button>

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
    <script src="{{ asset('public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>

    <script>
        $('#lfm').filemanager('image');
    </script>
@endsection

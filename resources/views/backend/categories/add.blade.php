@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row card m-b-30">
                <div class="col-sm-12">
                    <div class="float-right page-breadcrumb">
                        <a href="{{ route('category.index') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
                        aria-hidden="true"></i> Back</a>
                    </div>
                    <h5 class="page-title">Catalogs</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-12">

                    <div class="card m-b-30">
                        <div class="card-body">

                            <!-- <h4 class="mt-0 header-title">Textual inputs</h4>
                                <p class="text-muted m-b-30 font-14">Here are examples of <code
                                        class="highlighter-rouge">.form-control</code> applied to each
                                    textual HTML5 <code class="highlighter-rouge">&lt;input&gt;</code> <code
                                            class="highlighter-rouge">type</code>.</p> -->

                            <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label for="title" class="col-sm-3 col-form-label">Category Name</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" required type="text" placeholder="Enter Category"
                                            id="title" name="title" value="{{ old('title') }}">
                                    </div>
                                </div>

                                <!-- image upload custom -->
                                <div class="form-group row">
                                    <label for="thumbnail" class="col-sm-3 col-form-label">Category Image <span
                                            style="color:red">*</span></label>
                                    <div class="col-sm-9">
                                        <div class="input-group d-flex align-items-center"
                                            style="border: 1px dashed #ced4da; border-radius: 25px; padding: 5px; background: #fff; height: 50px;">
                                            <span class="input-group-btn" style="margin-right:0;">
                                                <a id="lfm" data-input="thumbnail" data-preview="holder"
                                                    class="btn btn-primary ripple"
                                                    style="border-radius: 20px; padding: 8px 20px;">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="thumbnail" required class="form-control" type="text"
                                                value="" name="photo"
                                                style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;"
                                                placeholder="Select an image...">
                                        </div>
                                        <span class="error"></span>
                                        <div id="holder" class="category_img"
                                            style="margin-top:15px;max-height:100px; display:flex"></div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="header" class="col-sm-3 col-form-label">Show Header <span
                                            style="color:red">*</span></label>
                                    <div class="col-sm-9">
                                        <div class="custom-control custom-checkbox mt-2">
                                            <input type="checkbox" class="custom-control-input" id="header_check"
                                                value="active" name="header">
                                            <label class="custom-control-label" for="header_check">Show in navigation
                                                menu</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row" style="display:none">
                                    <label for="status" class="col-sm-3 col-form-label">Show Homepage</label>
                                    <div class="col-sm-9">
                                        <input type="checkbox" value="active" class="mt-3" name="home">
                                    </div>
                                </div>

                                <div class="form-group row" style="display:none">
                                    <label for="status" class="col-sm-3 col-form-label">Show Category</label>
                                    <div class="col-sm-9">
                                        <input type="checkbox" value="active" class="mt-3" name="category">
                                    </div>
                                </div>

                                <div class="form-group row" style="display:none">
                                    <label for="status" class="col-sm-3 col-form-label">Show Offer</label>
                                    <div class="col-sm-9">
                                        <input type="checkbox" value="active" class="mt-3" name="offers">
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12 text-center">
                                        <button class="btn btn-primary btn-lg" type="submit"
                                            style="padding: 10px 40px;">Create Category</button>
                                        
                                    </div>
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

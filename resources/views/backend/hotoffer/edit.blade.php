@extends('backend.layouts.master')

@section('content')
    <style>
        img {

            margin-left: 3%;

        }
    </style>

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a>Appearence</a></li>

                            <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Hotoffer</a></li>

                            <li class="breadcrumb-item active">Edit Hotoffer</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Appearence</h5>

                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Edit Hotoffer</h4>

                <a href="{{ url('view_hotoffer') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
                        aria-hidden="true"></i> Back</a>

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

                            <form action="{{ url('update_hotoffer') . '/' . $offer->id }}" method="post">

                                @csrf

                                <!-- <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Name *</label>

                                    <div class="col-sm-10">

                                        <input class="form-control" type="text" placeholder="Enter Name" id="example-text-input">

                                    </div>

                                </div> -->

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Title</label>

                                    <div class="col-sm-10">

                                        <input type="text" class="form-control" id="title" name="title"
                                            value="{{ $offer->title }}" required>

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-4 col-form-label">Image</label>

                                    <!-- <img src="assets/images/image.png" class="admin-image"> -->

                                    <div class="col-sm-8">

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
                                                value="{{ $offer->photo }}" name="photo"
                                                style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;"
                                                placeholder="Select an image...">
                                        </div>

                                    </div>

                                </div>

                        </div>

                        <!-- <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Start Date <span style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <input type="text" class="form-control" id="title" name="title" required>

                                    </div>

                                </div>  -->

                        <div class="form-group row">

                            <label for="example-text-input" class="col-sm-2 col-form-label">Link <span
                                    style="color:red">*</span></label>

                            <div class="col-sm-10">

                                <input type="text" value="{{ $offer->link }}" class="form-control" id="link"
                                    name="link" required>

                            </div>

                        </div>

                        <div class="form-group row">

                            <label for="example-text-input" class="col-sm-4 col-form-label">Description</label>

                            <div class="col-sm-8">

                                <textarea class="summernote required" name="description" required value="{{ old('description') }}">{!! html_entity_decode($offer->description) !!}</textarea>

                                <span class="error"></span>

                            </div>

                            </select>

                            <span class="error"></span>

                        </div>

                        <!-- <div class="form-group row">

                                    <label for="status" class="col-sm-2 col-form-label">Bg-color</label>

                                    <div class="col-sm-10">

                                    <input type="color" id="bg_color" name="bg_color">

                                    </div>

                                </div> -->

                        {{-- <div class="form-group row">

                            <label for="example-search-input" class="col-sm-2 col-form-label">Meta Keywords</label>

                            <div class="col-sm-10">

                                <textarea id="elm1"name="met_keyword" value="{{ old('met_keyword') }}"></textarea>

                            </div>

                        </div> --}}

                        <div class="d-flex">

                            <button class="btn btn-primary" type="submit">Submit</button>&nbsp;

                            <button class="btn btn-secondary" type="Reset">Cancel</button>

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

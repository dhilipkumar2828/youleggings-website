@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>

                            <li class="breadcrumb-item"><a href="{{ route('brand.index') }}">Manufacturers</a></li>

                            <li class="breadcrumb-item active">Edit Manufacturers</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Edit Manufacturers</h5>

                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Edit Manufacturers</h4>

                <a href="{{ route('brand.index') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
                        aria-hidden="true"></i> Back</a>

            </div>

            <div class="row">

                <div class="col-md-12">

                </div>

                <div class="col-12">

                    <div class="card m-b-30">

                        <div class="card-body">

                            <!-- <h4 class="mt-0 header-title">Textual inputs</h4>

                                    <p class="text-muted m-b-30 font-14">Here are examples of <code

                                            class="highlighter-rouge">.form-control</code> applied to each

                                        textual HTML5 <code class="highlighter-rouge">&lt;input&gt;</code> <code

                                                class="highlighter-rouge">type</code>.</p> -->

                            <form action="{{ route('brand.update', $Brand->id) }}" method="post">

                                @csrf

                                @method('patch')

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Title <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <input class="form-control" required type="text" placeholder="Enter Name"
                                            id="example-text-input" name="title" value="{{ $Brand->title }}">

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">URL <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <input class="form-control" required type="url" placeholder="Enter Url"
                                            id="example-text-input" name="url" value="{{ $Brand->url }}">

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Email Address <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <input class="form-control" required type="email" placeholder="Enter Email"
                                            id="example-text-input" name="email" value="{{ $Brand->email }}">

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Phone Number <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <input class="form-control" required type="text" placeholder="Enter Phone Number"
                                            id="example-text-input" name="phone_number" value="{{ $Brand->phone_number }}">

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label"><span
                                            class="text-danger"></span>Descripition</label>

                                    <!-- <img src="assets/images/image.png" class="admin-image"> -->

                                    <div class="col-sm-10">

                                        <textarea id="elm1"name="description" value="{{ $Brand->description }}">{{ $Brand->description }}</textarea>

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Brand Logo <span
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
                                                value="{{ $Brand->brand_logo }}" name="brand_logo"
                                                style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;"
                                                placeholder="Select an image...">
                                        </div>

                                        <div id="holder" style="margin-top:15px;max-height:100px;"><img
                                                src="{{ $Brand->brand_logo }}" style="height: 5rem;"></div>

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Cover Image <span
                                            style="color:red">*</span></label>

                                    <!-- <img src="assets/images/image.png" class="admin-image"> -->

                                    <div class="col-sm-10">

                                        <div class="input-group d-flex align-items-center"
                                            style="border: 1px dashed #ced4da; border-radius: 8px; padding: 0 5px; background: #fff; height: 45px;">
                                            <span class="input-group-btn" style="margin-right:0;">
                                                <a id="lfm1" data-input="thumbnail1" data-preview="holder1"
                                                    class="btn btn-primary ripple"
                                                    style="border-radius: 6px; padding: 6px 12px;">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="thumbnail1" required class="form-control" type="text"
                                                value="{{ $Brand->cover_photo }}" name="cover_photo"
                                                style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;"
                                                placeholder="Select an image...">
                                        </div>

                                        <div id="holder1" style="margin-top:15px;max-height:100px;"><img
                                                src="{{ $Brand->cover_photo }}" style="height: 5rem;"></div>

                                    </div>

                                </div>

                                <div class="d-flex">

                                    <button class="btn btn-primary" type="submit">Update</button>&nbsp;

                                    <!-- <button class="btn btn-secondary" type="Reset">Cancel</button> -->

                                </div>

                        </div>

                        {{-- <div class="form-group row">

                                <label for="example-search-input" class="col-sm-2 col-form-label">Status <span style="color:red">*</span></label>

                                <div class="col-sm-10">

                                    <input class="form-control" type="search" Placeholder="Enter Child Category" id="example-search-input">

                                </div>

                            </div> --}}

                        {{-- <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label"> Status</label>

                                    <div class="col-sm-10">

                                        <select class="form-control" required name='status'>

                                            <option value="">--Status--</option>

                                            <option value="active" {{ $banner->status  == 'active' ? 'selected' : '' }}>Active</option>

                                            <option value="inactive" {{ $banner->status  == 'inactive' ? 'selected' : '' }}>Inactive</option>

                                        </select>

                                    </div>

                                </div> --}}

                        {{-- <div class="form-group row">

                                    <label for="condition" class="col-sm-2 col-form-label"> Condition</label>

                                    <div class="col-sm-10">

                                        <select class="form-control" name='condition'>

                                            <option>--Condition--</option>

                                            <option value="banner" {{ $banner->condition == 'banner' ? 'selected' : '' }}>Banner</option>

                                            <option value="promo" {{ $banner->condition  == 'promo' ? 'selected' : '' }}>Promote </option>

                                        </select>

                                    </div>

                                </div> --}}

                        {{--

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label" <span class="text-danger">*</span>>Condition</label>

                                    <!-- <img src="assets/images/image.png" class="admin-image"> -->

                                    <div class="col-sm-10">

                                        <input type="text" id="myFile" name="filename">

                                    </div>

                                </div> --}}

                        {{-- <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label"><span class="text-danger"></span>Descripition</label>

                                    <!-- <img src="assets/images/image.png" class="admin-image"> -->

                                    <div class="col-sm-10">

                                        <textarea id="elm1" name="area" name="description"

                                            value="{{ $banner->description }}"></textarea>

                                    </div>

                                </div> --}}

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
        $('#lfm,#lfm1').filemanager('image');
    </script>

    <script>
        $(document).ready(function() {

            if ($("#elm1").length > 0) {

                tinymce.init({

                    selector: "textarea#elm1",

                    theme: "modern",

                    height: 300,

                    plugins: [

                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",

                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",

                        "save table contextmenu directionality emoticons template paste textcolor"

                    ],

                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

                    style_formats: [

                        {
                            title: 'Bold text',
                            inline: 'b'
                        },

                        {
                            title: 'Red text',
                            inline: 'span',
                            styles: {
                                color: '#ff0000'
                            }
                        },

                        {
                            title: 'Red header',
                            block: 'h1',
                            styles: {
                                color: '#ff0000'
                            }
                        },

                        {
                            title: 'Example 1',
                            inline: 'span',
                            classes: 'example1'
                        },

                        {
                            title: 'Example 2',
                            inline: 'span',
                            classes: 'example2'
                        },

                        {
                            title: 'Table styles'
                        },

                        {
                            title: 'Table row 1',
                            selector: 'tr',
                            classes: 'tablerow1'
                        }

                    ]

                });

            }

        });
    </script>
@endsection

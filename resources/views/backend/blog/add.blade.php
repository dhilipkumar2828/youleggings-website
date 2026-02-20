@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="float-right page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('about.index') }}">Blog</a></li>
                            <li class="breadcrumb-item active">Create Blog</li>
                        </ol>
                    </div>
                    <h5 class="page-title">Create Blog</h5>
                </div>
            </div>

            <div class="card m-b-30 card-body">
                <h4 class="card-title font-20 mt-0">Create Blog</h4>
                <a href="{{ route('blog.index') }}" id="add-btn" style="color: #ffffff;">
                    <i class="fa fa-angle-left" aria-hidden="true"></i> Back
                </a>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <form action="{{ route('blog.store') }}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label for="title" class="col-sm-2 col-form-label">Title <span
                                            style="color:red">*</span></label>
                                    <div class="col-sm-10">
                                        <input class="form-control" required type="text" placeholder="Enter Title"
                                            id="title" name="title">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="elm1" class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-10">
                                        <textarea id="elm1" required name="description"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="thumbnail" class="col-sm-2 col-form-label">Image <span
                                            style="color:red">*</span></label>
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

                                <div class="form-group row">
                                    <label for="publish_at" class="col-sm-2 col-form-label">Publish At <span
                                            style="color:red">*</span></label>
                                    <div class="col-sm-10">
                                        <input class="form-control" required type="date" placeholder="Publish At"
                                            id="publish_at" name="publish_at">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="created_by" class="col-sm-2 col-form-label">Created By <span
                                            style="color:red">*</span></label>
                                    <div class="col-sm-10">
                                        <input class="form-control" required type="text" placeholder="Enter Your Name"
                                            id="created_by" name="created_by">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="status" class="col-sm-2 col-form-label">Status <span
                                            style="color:red">*</span></label>
                                    <div class="col-sm-10">
                                        <select class="form-control" required id="status" name="status">
                                            <option value="">--Status--</option>
                                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Publish
                                            </option>
                                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Draft
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex mt-3">
                                    <button class="btn btn-primary" type="submit">Submit</button>&nbsp;
                                    <button class="btn btn-secondary" id="reset" type="reset">Cancel</button>
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
    <script src="{{ asset('public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        $('#lfm').filemanager('image');

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
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
                    style_formats: [{
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

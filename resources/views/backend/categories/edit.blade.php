@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
                    <div class="float-right page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a>Catalogs</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Category</a></li>
                            <li class="breadcrumb-item active">Edit Category</li>
                        </ol>
                    </div>
                    <h5 class="page-title">Catalogs</h5>
                </div>
            </div>
            <div class="card m-b-30 card-body">
                <h4 class="card-title font-20 mt-0">Edit Category

                    <?php
                    if($nextCategory > 0){?>
                    <a href="/category/{{ $nextCategory }}/edit" class="btn btn-success btn-sm"
                        title="Go to Next Product">Next Category <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                    <?php }
                    ?>
                </h4>
                <a href="{{ route('category.index') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
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

                            <form action="{{ route('category.update', $category->id) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <!-- <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Name *</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" placeholder="Enter Name" id="example-text-input">
                                    </div>
                                </div> -->
                                <!-- <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Parent Category</label>
                                    <div class="col-sm-10">
                                      <select class="form-control" id="parent_category" name="parent_category">
                                        <option value="">Select Category</option>
                                        @foreach ($parent_cate as $cate)
    <option value="{{ $cate->id }}">{{ $cate->title }}</option>
    @endforeach
                                      </select>
                                    </div>
                                </div>  -->
                                <div class="form-group row">
                                    <label for="title" class="col-sm-3 col-form-label">Category</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" required placeholder="Enter Category"
                                            id="title" name="title" value="{{ $category->title }}">
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
                                                value="{{ $category->photo }}" name="photo"
                                                style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;"
                                                placeholder="Select an image...">
                                        </div>
                                        <span class="error"></span>
                                        <div id="holder" class="category_img"
                                            style="margin-top:15px;max-height:100px; display:flex">
                                            @if ($category->photo)
                                                <img src="{{ $category->photo }}" alt="promo image"
                                                    style="max-height: 90px;max-width:120px">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="header" class="col-sm-3 col-form-label">Show Header</label>
                                    <div class="col-sm-9">
                                        <div class="custom-control custom-checkbox mt-2">
                                            <input type="checkbox" class="custom-control-input" id="header_check"
                                                value="active" name="header"
                                                {{ $category->header == 'active' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="header_check">Show in navigation
                                                menu</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row" style="display:none">
                                    <label for="status" class="col-sm-3 col-form-label">Show Homepage</label>
                                    <div class="col-sm-9">
                                        <input type="checkbox" value="active" class="mt-3" name="home"
                                            {{ $category->home == 'active' ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="form-group row" style="display:none">
                                    <label for="status" class="col-sm-3 col-form-label">Show Category</label>
                                    <div class="col-sm-9">
                                        <input type="checkbox" value="active" class="mt-3" name="category"
                                            {{ $category->category == 'active' ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="form-group row" style="display:none">
                                    <label for="status" class="col-sm-3 col-form-label">Show Offers</label>
                                    <div class="col-sm-9">
                                        <input type="checkbox" value="active" class="mt-3" name="offers"
                                            {{ $category->offers == 'active' ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12 text-center">
                                        <button class="btn btn-primary btn-lg px-5" type="submit">Update</button>
                                    </div>
                                </div>
                            </form>
                            </form>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div><!-- container fluid -->

    </div>
@endsection
@section('scripts')
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>

    <script>
        $('#lfm').filemanager('image');
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

    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>

    <script>
        jQuery(document).ready(function() {
            $('.summernote').summernote({
                height: 80, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: true // set focus to editable area after initializing summernote
            });
        });
    </script>
    <script>
        $('#is_parent').change(function(e) {
            //e.preventDefault();
            var is_checked = $('#is_parent').prop('checked');
            // swal("Attention", 'is_checked', "warning")
            if (is_checked) {
                $('#parent_cat_div').addClass('d-none');
                $('#parent_cat_div').val('');
            } else {
                $('#parent_cat_div').removeClass('d-none');
            }
        })
    </script>
@endsection

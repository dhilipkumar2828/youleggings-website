@extends('backend.layouts.master')

@section('content')

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-left page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>

                            <li class="breadcrumb-item"><a href="{{ route('deals.index') }}">Deals of day</a></li>

                            <li class="breadcrumb-item active">Create Deals</li>

                        </ol>

                    </div>

                    <!-- <h5 class="page-title">Create Deals</h5> -->

                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Create Deals</h4>

                <a href="{{ route('deals.index') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
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

                            <form action="{{ route('deals.store') }}" method="post">

                                @csrf

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Product Name <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <select class="form-control" name="product_name" id="product_name">

                                            <option value="">Select</option>

                                            @foreach ($products as $prod)
                                                <option value="{{ $prod->id }}">{{ $prod->title }}</option>
                                            @endforeach

                                        </select>

                                    </div>

                                </div>

                                <!-- <div class="form-group row">

                                        <label for="example-text-input" class="col-sm-2 col-form-label">Event Date and Time</label>

                                            <div class='input-group date col-sm-10' id='datetimepicker1'>

                                            <input type='text' class="form-control" name="days" />

                                            <span class="input-group-addon">

                                                <span class="glyphicon glyphicon-calendar"></span>

                                            </span>

                                            </div>

                                        </div> -->

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Sale Price</label>

                                    <div class="col-sm-10">

                                        <input class="form-control" type="text" placeholder="Enter Sale Price"
                                            id="example-text-input" required name="sale_price"
                                            value="{{ old('sale_price') }}">

                                    </div>

                                </div>

                                <!-- {{-- <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Image <span style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <input id="thumbnail" class="form-control" type="text" name="filepath">

                                    </div>

                                </div> --}} -->

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Image</label>

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

                                @if (count($errors) > 0)
                                    <div class = "alert alert-danger">

                                        <ul>

                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach

                                        </ul>

                                    </div>
                                @endif

                                <!-- {{-- <div class="form-group row">

                                <label for="example-search-input" class="col-sm-2 col-form-label">Status <span style="color:red">*</span></label>

                                <div class="col-sm-10">

                                    <input class="form-control" type="search" Placeholder="Enter Child Category" id="example-search-input">

                                </div>

                            </div> --}} -->

                                <!-- <div class="form-group row">

                                            <label for="condition" class="col-sm-2 col-form-label">Condition</label>

                                            <div class="col-sm-10">

                                                <select class="form-control" required name='condition'>

                                                    <option value="">--Condition--</option>

                                                    <option value="banner" {{ old('condition') == 'banner' ? 'selected' : '' }}>Banner</option>

                                                    <option value="promo" {{ old('condition') == 'promo1' ? 'selected' : '' }}>Promote</option>

                                                </select>

                                            </div>

                                        </div> -->

                                <!-- <div class="form-group row">

                                            <label for="condition" class="col-sm-2 col-form-label">Type <span style="color:red">*</span></label>

                                            <div class="col-sm-10">

                                                <select class="form-control" name='type'>

                                                    <option value="">--Type--</option>

                                                    <option value="right" {{ old('condition') == 'right' ? 'selected' : '' }}>Right</option>

                                                    <option value="left" {{ old('condition') == 'left' ? 'selected' : '' }}>Left</option>

                                                </select>

                                            </div>

                                        </div> -->

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label"><span
                                            class="text-danger"></span>Description</label>

                                    <div class="col-sm-10">

                                        <textarea class="summernote" required name="description" value="{{ old('description') }}" placeholder=""></textarea>

                                    </div>

                                </div>

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

    </div> <!-- Page content Wrapper -->

@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>

    <script src="{{ asset('public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js">
        </script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css"> -->

    <script>
        jQuery(document).ready(function() {

            $('.summernote').summernote({

                height: 80, // set editor height

                minHeight: null, // set minimum height of editor

                maxHeight: null // set maximum height of editor

            });

        });
    </script>

    <script>
        $('#lfm,#lfm1').filemanager('image');
    </script>

    <script>
        $(document).ready(function() {

            // $('#add_time').datetimepicker();

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

        $(function() {

            $('#datetimepicker1').datetimepicker();

        })
    </script>
@endsection

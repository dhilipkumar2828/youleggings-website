@extends('backend.layouts.master')

@section('content')

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-left page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="#">Home</a></li>

                            <li class="breadcrumb-item"><a href="#">Promo</a></li>

                            <li class="breadcrumb-item active">Edit Promo</li>

                        </ol>

                    </div>

                    <!-- <h5 class="page-title">Edit Promo</h5> -->

                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Edit Promo</h4>

                <a href="{{ route('promo.index') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
                        aria-hidden="true"></i> Back</a>

            </div>

            <div class="row">

                <div class="col-12">

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

                    <div class="card m-b-30">

                        <div class="card-body">

                            <!-- <h4 class="mt-0 header-title">Textual inputs</h4>

                                <p class="text-muted m-b-30 font-14">Here are examples of <code

                                        class="highlighter-rouge">.form-control</code> applied to each

                                    textual HTML5 <code class="highlighter-rouge">&lt;input&gt;</code> <code

                                            class="highlighter-rouge">type</code>.</p> -->

                            <form action="{{ route('promo.update', $promo->id) }}" method="POST">

                                @csrf

                                @method('patch')

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Session
                                                left-1(Image Size 750 * 413)</label>

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
                                                    <input id="thumbnail" class="form-control" type="text"
                                                        value="{{ $promo->Session_left_1 }}" name="Session_left_1"
                                                        style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;"
                                                        placeholder="Select an image...">
                                                </div>

                                                <div id="holder" style="margin-top:15px;max-height:100px;"><img
                                                        src="{{ $promo->Session_left_1 }}"
                                                        alt="promo image"style="max-height: 90px;max-width:120px"></div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input"
                                                class="col-sm-6 col-form-label">Session_left_description-1</label>

                                            <div class="col-sm-10">

                                                <textarea class="summernote" name="Session_left_description1"value="{{ old('Session_left_description1') }}">{{ $promo->Session_left_description1 }}</textarea>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Session
                                                right-1(Image Size 360 * 410)</label>

                                            <div class="col-sm-8">

                                                <div class="input-group d-flex align-items-center"
                                                    style="border: 1px dashed #ced4da; border-radius: 8px; padding: 0 5px; background: #fff; height: 45px;">
                                                    <span class="input-group-btn" style="margin-right:0;">
                                                        <a id="lfm1" data-input="thumbnail1" data-preview="holder1"
                                                            class="btn btn-primary ripple"
                                                            style="border-radius: 6px; padding: 6px 12px;">
                                                            <i class="fa fa-picture-o"></i> Choose
                                                        </a>
                                                    </span>
                                                    <input id="thumbnail1" class="form-control" type="text"
                                                        value="{{ $promo->Session_right_1 }}" name="Session_right_1"
                                                        style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;"
                                                        placeholder="Select an image...">
                                                </div>

                                                <div id="holder1" style="margin-top:15px;max-height:100px;"><img
                                                        src="{{ $promo->Session_right_1 }}"
                                                        alt="promo image"style="max-height: 90px;max-width:120px"></div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input"
                                                class="col-sm-4 col-form-label">Session_right_description-1</label>

                                            <div class="col-sm-8">

                                                <textarea class="summernote" name="Session_right_description1" value="{{ old('Session_right_description1') }}">{{ $promo->Session_right_description1 }}</textarea>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Session
                                                left-2(Image Size 360 * 410)</label>

                                            <div class="col-sm-8">

                                                <div class="input-group d-flex align-items-center"
                                                    style="border: 1px dashed #ced4da; border-radius: 8px; padding: 0 5px; background: #fff; height: 45px;">
                                                    <span class="input-group-btn" style="margin-right:0;">
                                                        <a id="lfm2" data-input="thumbnail2" data-preview="holder2"
                                                            class="btn btn-primary ripple"
                                                            style="border-radius: 6px; padding: 6px 12px;">
                                                            <i class="fa fa-picture-o"></i> Choose
                                                        </a>
                                                    </span>
                                                    <input id="thumbnail2" class="form-control" type="text"
                                                        value="{{ $promo->Session_left_2 }}" name="Session_left_2"
                                                        style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;"
                                                        placeholder="Select an image...">
                                                </div>

                                                <div id="holder2" style="margin-top:15px;max-height:100px;"><img
                                                        src="{{ $promo->Session_left_2 }}"
                                                        alt="promo image"style="max-height: 90px;max-width:120px"></div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input"
                                                class="col-sm-6 col-form-label">Session_left_description-2</label>

                                            <div class="col-sm-10">

                                                <textarea class="summernote" name="Session_left_description2"value="{{ old('Session_left_description2') }}">{{ $promo->Session_left_description2 }}</textarea>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Session
                                                right-2(Image Size 750 * 413)</label>

                                            <div class="col-sm-8">

                                                <div class="input-group d-flex align-items-center"
                                                    style="border: 1px dashed #ced4da; border-radius: 8px; padding: 0 5px; background: #fff; height: 45px;">
                                                    <span class="input-group-btn" style="margin-right:0;">
                                                        <a id="lfm3" data-input="thumbnail3" data-preview="holder3"
                                                            class="btn btn-primary ripple"
                                                            style="border-radius: 6px; padding: 6px 12px;">
                                                            <i class="fa fa-picture-o"></i> Choose
                                                        </a>
                                                    </span>
                                                    <input id="thumbnail3" class="form-control" type="text"
                                                        value="{{ $promo->Session_right_2 }}" name="Session_right_2"
                                                        style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;"
                                                        placeholder="Select an image...">
                                                </div>

                                                <div id="holder3" style="margin-top:15px;max-height:100px;"><img
                                                        src="{{ $promo->Session_right_2 }}"
                                                        alt="promo image"style="max-height: 90px;max-width:120px"></div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input"
                                                class="col-sm-4 col-form-label">Session_right_description-2</label>

                                            <div class="col-sm-8">

                                                <textarea class="summernote" name="Session_right_description2" value="{{ old('Session_right_description2') }}">{{ $promo->Session_right_description2 }}</textarea>

                                            </div>

                                        </div>

                                    </div>

                                    <div class=" col-md-12 d-flex" style="justify-content: center;">

                                        <button class="btn btn-primary" type="submit">Submit</button>&nbsp;

                                        <button class="btn btn-secondary" type="Reset">Cancel</button>

                                    </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div> <!-- end col -->

        </div> <!-- end row -->

    </div><!-- container fluid -->

    </div> <!-- Page content Wrapper -->

@endsection

@section('scripts')
    <script src="{{ asset('/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>

    <script>
        $('#lfm,#lfm1,#lfm2,#lfm3').filemanager('image');
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

                maxHeight: null // set maximum height of editor

            });

        });
    </script>
@endsection

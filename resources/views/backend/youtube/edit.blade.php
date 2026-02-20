@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a>Appearence</a></li>

                            <li class="breadcrumb-item"><a href="{{ route('youtube.index') }}">Youtube</a></li>

                            <li class="breadcrumb-item active">Edit Youtube</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Appearence</h5>

                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Edit Youtube</h4>

                <a href="{{ route('youtube.index') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
                        aria-hidden="true"></i> Back</a>

            </div>

            <div class="row">

                <div class="col-12">

                    <div class="card m-b-30">

                        <div class="card-body">

                            <form action="{{ route('youtube.update', $youtubes->id) }}" method="post">

                                @csrf

                                @method('patch')

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Image <span
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
                                                value="{{ $youtubes->photo }}" name="photo"
                                                style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;"
                                                placeholder="Select an image...">
                                        </div>

                                        <div id="holder" style="margin-top:15px;max-height:100px;"><img
                                                src="{{ $youtubes->photo }}"
                                                alt="promo image"style="max-height: 90px;max-width:120px">

                                        </div>

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="status" class="col-sm-2 col-form-label">Url <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <input id="url" class="form-control" type="text"
                                            value="{{ $youtubes->url }}" name="url" required>

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="status" class="col-sm-2 col-form-label">Status</label>

                                    <div class="col-sm-10">

                                        <select class="form-control" required name='status'
                                            value="{{ $youtubes->status }}">

                                            <option value="">--Status--</option>

                                            <option value="active" {{ $youtubes->status == 'active' ? 'selected' : '' }}>
                                                Active</option>

                                            <option value="inactive"
                                                {{ $youtubes->status == 'inactive' ? 'selected' : '' }}>Inactive</option>

                                        </select>

                                        @if ($errors)
                                            <span class="text-danger">{{ $errors->first('status') }}</span>
                                        @endif

                                    </div>

                                </div>

                                <div class="d-flex">

                                    <button class="btn btn-primary" type="submit">Update</button>&nbsp;

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

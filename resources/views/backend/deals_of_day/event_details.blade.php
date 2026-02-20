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

                            <li class="breadcrumb-item active">Create Events</li>

                        </ol>

                    </div>

                    <!-- <h5 class="page-title">Create Events</h5> -->

                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Create Events</h4>

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

                            <form action="{{ route('deals_update') }}" method="POST">

                                @csrf

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Event Date and
                                        Time</label>

                                    <div class='input-group date col-sm-10' id='datetimepicker1'>

                                        <input type='text' class="form-control" required value="{{ $deals->days }}"
                                            name="days" />

                                        <span class="input-group-addon">

                                            <span class="glyphicon glyphicon-calendar"></span>

                                        </span>

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label"><span
                                            class="text-danger"></span>Event Description</label>

                                    <div class="col-sm-10">

                                        <textarea class="summernote" required name="description" value="{{ old('description') }}">{{ $deals->description }}</textarea>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js">
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

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

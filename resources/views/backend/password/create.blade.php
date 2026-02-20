@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>

                            <li class="breadcrumb-item"><a href="{{ route('about.index') }}">Password</a></li>

                            <li class="breadcrumb-item active">Change Password</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Change Password</h5>

                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Update Password</h4>

                <a href="{{ url('/') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
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

                            <form action="{{ route('about.store') }}" method="post">

                                @csrf

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Email <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <input class="form-control" required type="text" placeholder="Enter Email"
                                            id="email" name="email" required>

                                        <span class="email_err text-danger"></span>

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Old Password <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <input class="form-control" required type="text" placeholder="Enter Old Password"
                                            id="old_password" name="old_password" required>

                                        <span class="oldpassword_err text-danger"></span>

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">New Password <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <input class="form-control" required type="text" placeholder="Enter Old Password"
                                            id="new_password" name="new_password" required>

                                        <span class="newpassword_err text-danger"></span>

                                    </div>

                                </div>

                                <!-- <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>

                                            <div class="col-sm-10">

                                                <input class="form-control" type="text" placeholder="Enter Name"

                                                    id="example-text-input" name="name">

                                            </div>

                                        </div> -->

                                {{--

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label" <span class="text-danger">*</span>>Condition</label>

                                    <!-- <img src="assets/images/image.png" class="admin-image"> -->

                                    <div class="col-sm-10">

                                        <input type="text" id="myFile" name="filename">

                                    </div>

                                </div> --}}

                                <div class="form-group row">

                                    <span class="pass_success text-success col-sm-12 text-center"></span>

                                    <span class="pass_failure text-danger  col-sm-12 text-center"></span>

                                </div>

                                <div class="d-flex">

                                    <button class="btn btn-primary" type="button"
                                        id="password_submit">Submit</button>&nbsp;

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
    <script src="{{ asset('public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>

    <script>
        $('#lfm').filemanager('image');
    </script>

    <script>
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });

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

        $(document).on("click", "#password_submit", function() {

            if ($('#email').val() != "" && $('#old_password').val() != "" && $('#new_password').val() != "") {

                $('.newpassword_err').html("");

                $('.email_err').html("");

                $('.oldpassword_err').html("");

                $('.pass_failure').text("");

                $.ajax({

                    url: "{{ url('update_password') }}",

                    type: "POST",

                    data: {

                        "_token": "{{ csrf_token() }}",

                        email: $('#email').val(),

                        old_password: $('#old_password').val(),

                        new_password: $('#new_password').val(),

                    },

                    success: function(response) {

                        4 $('input').val('');

                        if (response.success == "Successfully Updated") {

                            $('.pass_success').text(response.success);

                        } else {

                            $('.pass_failure').text(response.success);

                        }

                    }

                });

            } else if ($('#email').val() == "") {

                $('.email_err').html("This field is required");

            } else if ($('#old_password').val() == "") {

                $('.email_err').html("");

                $('.oldpassword_err').html("This field is required");

            } else if ($('#new_password').val() == "") {

                $('.oldpassword_err').html("");

                $('.newpassword_err').html("This field is required");

            }

        })
    </script>
@endsection

@extends('backend.layouts.master')

@section('content')

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row card">

                <div class="col-sm-12 ">

                    <div class="float-right page-breadcrumb mt-1">

                        <a href="{{ route('user.index') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
                        aria-hidden="true"></i> Back</a>

                    </div>

                    <h5 class="page-title">Add User </h5>

                </div>

            </div>

           
            <div class="row">

                <div class="col-md-12">

                    @if ($errors->all())
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

                            <form action="{{ route('user.store') }}" method="post">

                                @csrf

                                <div class="form-group row">

                                    <label for="name" class="col-sm-2 col-form-label">Name <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <input class="form-control" type="text" required placeholder="Enter User Name"
                                            id="name" name="name" value="{{ old('name') }}">

                                        <span class="text-danger name_err"></span>

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="email" class="col-sm-2 col-form-label">Email <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <input class="form-control" type="email" placeholder="Enter Email" id="email"
                                            name="email" required value="{{ old('email') }}">

                                        <span class="text-danger email_err"></span>

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="password" class="col-sm-2 col-form-label">Password <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <input class="form-control" type="password" placeholder="Enter Password" required
                                            name="password"value="{{ old('password') }}" id="password">

                                        <span class="text-danger password_err"></span>

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="phone" class="col-sm-2 col-form-label">Mobile Number <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <input class="form-control" type="number" required
                                            placeholder="Enter Mobile Number" id="phone" name="phone"
                                            value="{{ old('phone') }}">

                                        <span class="text-danger phone_err"></span>

                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="photo" class="col-sm-2 col-form-label">Photo</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfm" data-input="photo" data-preview="holder" class="btn btn-primary" style="color: white">
                                                    <i class="fa fa-picture-o"></i> Choose
                                                </a>
                                            </span>
                                            <input id="photo" class="form-control" type="text" name="photo" value="{{ old('photo') }}">
                                        </div>
                                        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="role" class="col-sm-2 col-form-label">Role <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <select class="form-control role" required name='role'>

                                            <option value="">Select Role</option>

                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                                            @endforeach

                                        </select>

                                        <span class="text-danger status_err"></span>

                                    </div>

                                </div>

                                <div class="d-flex">

                                    <button class="btn btn-primary" type="submit">Submit</button>&nbsp;

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

            $('#user_save').click(function() {
                $(this).closest('form').submit();
            });

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

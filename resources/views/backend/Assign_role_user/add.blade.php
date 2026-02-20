@extends('backend.layouts.master')

@section('content')

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>

                            <li class="breadcrumb-item"><a href="{{ route('Assign_role_user.index') }}"> Assign User Role </a>
                            </li>

                            <li class="breadcrumb-item active">Assign User Role</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Assign User Role</h5>

                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0"> Assign User Role </h4>

                <a href="{{ route('Assign_role_user.index') }}" id="add-btn" style="color: #ffffff;"><i
                        class="fa fa-angle-left" aria-hidden="true"></i> Back</a>

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

                            <form action="{{ route('Assign_role_user.store') }}" method="post">

                                @csrf

                                <select name="user_id" class="custom-select mt-3">

                                    <option value="">Select User</option>

                                    @if ($users->count() > 0)
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->email }}</option>
                                        @endforeach
                                    @endif

                                </select>

                                <select multiple name="role_name[]" class="custom-select mt-4">

                                    <option value="">Select Role</option>

                                    @if ($roles->count() > 0)
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    @endif

                                </select>

                                <div class="d-flex">

                                    <button class="btn btn-primary mt-3" type="submit">Submit</button>&nbsp;

                                    <button class="btn btn-secondary mt-3" id="reset" type="Reset">Cancel</button>

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

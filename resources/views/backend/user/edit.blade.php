@extends('backend.layouts.master')

@section('content')

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>

                            <li class="breadcrumb-item"><a href="{{ route('user.index') }}"> User </a></li>

                            <li class="breadcrumb-item active"> Edit System User </li>

                        </ol>

                    </div>

                    <h5 class="page-title">Edit System User </h5>

                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Edit System User </h4>

                <a href="{{ route('user.index') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
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

                            <form action="{{ url('user_update', $user->id) }}" method="post">

                                @csrf

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">User Name <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <input class="form-control" type="text" required placeholder="Enter User Name"
                                            id="example-text-input" name="name" value="{{ $user->name }}">

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Email <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <input class="form-control" type="email" required placeholder="Enter Email"
                                            id="example-text-input" name="email" value="{{ $user->email }}">

                                    </div>

                                </div>

                                {{-- <div class="form-group row">

                                    <label for="example-search-input" class="col-sm-2 col-form-label">Password <span style="color:red">*</span></label>

                                 <div class="col-sm-10">

                                     <input class="form-control" type="password" placeholder="Enter Password" required name="password"value="{{old('password')}}" id="password">

                                            <span class="text-danger password_err"></span>

                                    </div>

                             </div> --}}

                                {{-- <div class="form-group row">

                                    <label for="example-search-input" class="col-sm-2 col-form-label">Password <span style="color:red">*</span></label>

                                 <div class="col-sm-10">

                                     <input class="form-control" type="password"placeholder="Enter Password" minlength="6" maxlength="8" name="password"value="{{$user->password}}" id="example-search-input">

                                 </div>

                                </div> --}}

                                <div class="form-group row">

                                    <label for="example-text-input" class="col-sm-2 col-form-label">Mobile Number</label>

                                    <div class="col-sm-10">

                                        <input class="form-control" type="number" required
                                            placeholder="Enter Mobile Number" id="example-text-input" name="phone"
                                            value="{{ $user->phone }}">

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label for="status" class="col-sm-2 col-form-label">Role <span
                                            style="color:red">*</span></label>

                                    <div class="col-sm-10">

                                        <select class="form-control role" required name='role'>

                                            <option value="">Select Role</option>

                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}"
                                                    {{ $role->name == $user->role ? 'selected' : '' }}>{{ $role->name }}
                                                </option>
                                            @endforeach

                                        </select>

                                        <span class="text-danger status_err"></span>

                                    </div>

                                </div>

                                <!-- <div class="form-group row">

                                            <label for="status" class="col-sm-2 col-form-label">Status <span style="color:red">*</span></label>

                                            <div class="col-sm-10">

                                                <select class="form-control" required name='status'>

                                                    <option>--Status--</option>

                                                    <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>

                                                    <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>

                                                </select>

                                            </div>

                                        </div> -->

                                {{--  <div class="form-group row">

                                    <label for="condition" class="col-sm-2 col-form-label">Role</label>

                                    <div class="col-sm-10">

                                        <select class="form-control" name='role'>

                                            <option>--Role--</option>

                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>

                                            <option value="vendor" {{ $user->role == 'vendor' ? 'selected' : '' }}>Vendor </option>

                                            <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer </option>

                                        </select>

                                    </div>

                                </div>  --}}

                                <div class="d-flex">

                                    <button class="btn btn-primary" type="submit">Submit</button>&nbsp;

                                    <!-- <button class="btn btn-secondary" type="submit">Cancel</button> -->

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

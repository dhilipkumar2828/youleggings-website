@extends('backend.layouts.master')

@section('content')

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="#">Home</a></li>

                            <li class="breadcrumb-item"><a href="#">Vendors</a></li>

                            <li class="breadcrumb-item active">Edit Merchants</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Edit Merchants</h5>

                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Edit Merchants</h4>

                <a href="{{ route('vendors.index') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
                        aria-hidden="true"></i> Back</a>

            </div>

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

            <div class="row">

                <div class="col-12">

                    <div class="card m-b-30">

                        <div class="card-body">

                            <!-- <h4 class="mt-0 header-title">Textual inputs</h4>

                                                    <p class="text-muted m-b-30 font-14">Here are examples of <code

                                                            class="highlighter-rouge">.form-control</code> applied to each

                                                        textual HTML5 <code class="highlighter-rouge">&lt;input&gt;</code> <code

                                                                class="highlighter-rouge">type</code>.</p> -->

                            <form action="{{ route('merchants_update', $vendor->id) }}" method="post"
                                enctype="multipart/form-data">

                                @csrf

                                @method('patch')

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Full Name <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" required placeholder="Enter "
                                                    value="{{ $vendor->vendor_name }}" name="vendor_name"
                                                    id="example-text-input" data-parsley-alphabets-only>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Date of birth
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="date" required placeholder="Enter "
                                                    value="{{ $vendor->date_of_birth }}" name="date_of_birth"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Gender <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <select name="gender" id="" required class="form-control">

                                                    <option value="">--Select Gender --</option>

                                                    <option value="male"
                                                        {{ $vendor->gender == 'male' ? 'selected' : '' }}>Male</option>

                                                    <option value="female"
                                                        {{ $vendor->gender == 'female' ? 'selected' : '' }}>Female
                                                    </option>

                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Email <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="email" required placeholder="Enter "
                                                    name="email" value="{{ $vendor->email }}" id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Mobile Number
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" required placeholder="Enter "
                                                    name="mobile_number" value="{{ $vendor->mobile_number }}"
                                                    id="example-text-input" data-parsley-phoneindia data-parsley-maxlength="10" data-parsley-minlength="10">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Address <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <textarea class="form-control" type="text" required placeholder="Enter" name="address"
                                                    value="{{ $vendor->address }}" id="example-text-input">{{ $vendor->address }}</textarea>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Pincode <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" required placeholder="Enter "
                                                    name="pincode" value="{{ $vendor->pincode }}"
                                                    id="example-text-input" data-parsley-pincodeindia data-parsley-maxlength="6" data-parsley-minlength="6">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">User Name
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="email" required placeholder="Enter "
                                                    name="user_name" value="{{ $vendor->user_name }}"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Password <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="password" required placeholder="Enter "
                                                    name="password" value="{{ $vendor->password }}"
                                                    title="{{ $vendor->password }}" id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Status</label>

                                            <div class="col-sm-8">

                                                <select name="status" id="" value="{{ $vendor->status }}"
                                                    class="form-control">

                                                    <option value="">--Select Status --</option>

                                                    @if ($vendor->status == 'active')
                                                        <option value="active" selected>Active</option>

                                                        <option value="inactive">Inactive</option>
                                                    @else
                                                        <option value="active">Active</option>

                                                        <option value="inactive" selected>Inactive</option>
                                                    @endif

                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group row">

                                            <label for="example-search-input"
                                                class="col-sm-2 col-form-label">Description</label>

                                            <div class="col-sm-12">

                                                <textarea id="elm1"name="description" value="{{ $vendor->description }}">{{ $vendor->description }}</textarea>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-12 d-flex">

                                        <button class="btn btn-primary" type="submit">Submit</button>&nbsp;

                                        <!-- <button class="btn btn-secondary" type="reset"></a>Cancel</button> -->

                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>

                </div> <!-- end col -->

            </div> <!-- end row -->

        </div><!-- container fluid -->

    </div> <!-- Page content Wrapper -->

    </div> <!-- content -->

    </div>

    <!-- End Right content here -->

    </div>

    <!-- END wrapper -->

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

@extends('backend.layouts.master')





@section('content')



    <div class="page-content-wrapper ">



        <div class="container-fluid">



            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="#">Home</a></li>

                            <li class="breadcrumb-item"><a href="#">Purchase</a></li>

                            <li class="breadcrumb-item active">Edit Vendor</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Edit Vendor</h5>



                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Edit Vendor</h4>

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

                            <form action="{{ route('vendors.update', $vendor->id) }}" method="post"
                                enctype="multipart/form-data">

                                @csrf

                                @method('patch')





                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Vendor Code
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" name="vendor_id"
                                                    placeholder="Enter" value="{{ $vendor->vendor_id }}" readonly
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>



                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Shop
                                                Name</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" required placeholder="Enter "
                                                    value="{{ $vendor->shop_name }}" name="shop_name"
                                                    id="example-text-input">

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

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Vendor Name
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" required placeholder="Enter "
                                                    name="vendor_name" value="{{ $vendor->vendor_name }}"
                                                    id="example-text-input">

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
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Website <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" required placeholder="Enter "
                                                    name="website" value="{{ $vendor->website }}"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Logo <span
                                                    style="color:red">*</span></label>

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
                                                        value="{{ $vendor->logo }}" name="logo"
                                                        style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;"
                                                        placeholder="Select an image...">
                                                </div>

                                                <div id="holder" style="margin-top:15px;max-height:100px;"><img
                                                        src="{{ $vendor->logo }}"
                                                        alt="promo image"style="max-height: 90px;max-width:120px"></div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Address
                                            </label>

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
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Bank Name
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" required placeholder="Enter "
                                                    name="bankname" value="{{ $vendor->bankname }}"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Branch <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" required placeholder="Enter "
                                                    name="branch" value="{{ $vendor->branch }}"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Account Holder
                                                Name <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" required placeholder="Enter "
                                                    name="account_holder_name" value="{{ $vendor->account_holder_name }}"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Account Number
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" required placeholder="Enter "
                                                    name="account_number" value="{{ $vendor->account_number }}"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">IFSC Code
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" required placeholder="Enter "
                                                    name="ifsc_code" value="{{ $vendor->ifsc_code }}"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Tax Name <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" required placeholder="Enter "
                                                    name="tax_name" value="{{ $vendor->tax_name }}"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Tax Number
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" required placeholder="Enter "
                                                    name="tax_number" value="{{ $vendor->tax_number }}"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Pan Number
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" required placeholder="Enter "
                                                    name="pan_number" value="{{ $vendor->pan_number }}"
                                                    id="example-text-input">

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

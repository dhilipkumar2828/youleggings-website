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

                            <li class="breadcrumb-item active">Create Vendor</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Create Vendor</h5>



                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Create Vendor</h4>

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

                            <form action="{{ route('vendors.store') }}" id="vendor_submit" method="post"
                                enctype="multipart/form-data">

                                @csrf

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Vendor Code
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">



                                                @if (count(\App\Models\Vendor::orderBy('id', 'DESC')->limit('1')->get('vendor_id')) > 0)
                                                    @foreach (\App\Models\Vendor::orderBy('id', 'DESC')->limit('1')->get('vendor_id') as $item)
                                                        <input class="form-control vendor_id" type="text"
                                                            name="vendor_id" placeholder="Enter"
                                                            value="VC-0000{{ explode('-', $item->vendor_id)[1] + 1 }}"
                                                            readonly id="example-text-input">
                                                    @endforeach
                                                @else
                                                    <input class="form-control vendor_id" type="text" name="vendor_id"
                                                        placeholder="Enter" value="VC-00001" readonly
                                                        id="example-text-input">
                                                @endif



                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Vendor
                                                Name</label>

                                            <div class="col-sm-8">

                                                <input class="form-control vendor_name" type="text" required
                                                    placeholder="Enter " value="{{ old('vendor_name') }}" name="vendor_name"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Shop Name <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control shop_name" type="text" required
                                                    placeholder="Enter " value="{{ old('shop_name') }}" name="shop_name"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Date of birth
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control date_of_birth" type="date" required
                                                    placeholder="Enter " value="{{ old('date_of_birth') }}"
                                                    name="date_of_birth" id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Gender <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <select name="gender" id="" required class="form-control gender">

                                                    <option value="">--Select Gender --</option>

                                                    <option value="male">Male</option>

                                                    <option value="female">Female</option>



                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Email <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control email" type="email" required
                                                    placeholder="Enter " value="{{ old('email') }}" name="email"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Mobile Number
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control mobile_number" type="text"
                                                    onkeypress="return validate(event)" required placeholder="Enter "
                                                    value="{{ old('mobile_number') }}" name="mobile_number"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Website <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control website" type="text" required
                                                    placeholder="Enter " value="{{ old('website') }}" name="website"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>





                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">logo <span
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
                                                    <input id="thumbnail" required class="form-control" type="text"
                                                        value="" name="logo"
                                                        style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;"
                                                        placeholder="Select an image...">
                                                </div>

                                                <div id="holder" style="margin-top:15px;max-height:100px;"></div>

                                            </div>

                                        </div>

                                    </div>



                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Address <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <textarea class="form-control address" type="text" required placeholder="Enter" name="address"
                                                    value="{{ old('address') }}" id="example-text-input">{{ old('address') }}</textarea>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Pincode <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control pincode" type="text"
                                                    onkeypress="return validate(event)" required placeholder="Enter "
                                                    name="pincode" value="{{ old('pincode') }}" id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Bank Name
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control bankname" type="text" required
                                                    placeholder="Enter " name="bankname" value="{{ old('bankname') }}"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Branch <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control branch" type="text" required
                                                    placeholder="Enter " name="branch" value="{{ old('branch') }}"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Account Holder
                                                Name <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control account_holder_name" type="text" required
                                                    placeholder="Enter " name="account_holder_name"
                                                    value="{{ old('account_holder_name') }}" id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Account Number
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control account_number" type="text"
                                                    onkeypress="return validate(event)" required placeholder="Enter "
                                                    name="account_number" value="{{ old('account_number') }}"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">IFSC Code
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control ifsc_code" type="text" required
                                                    placeholder="Enter " name="ifsc_code" value="{{ old('ifsc_code') }}"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Tax Name <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control tax_name" type="text" required
                                                    placeholder="Enter " name="tax_name" value="{{ old('tax_name') }}"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Tax Number
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control tax_number" type="text"
                                                    onkeypress="return validate(event)" required placeholder="Enter "
                                                    name="tax_number" value="{{ old('tax_number') }}"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Pan Number
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control pan_number" type="text" required
                                                    placeholder="Enter " name="pan_number"
                                                    value="{{ old('pan_number') }}" id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">User Name
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control user_name" type="email" required
                                                    placeholder="Enter " name="user_name" value="{{ old('user_name') }}"
                                                    id="example-text-input">

                                                <div id="user_err" style="color:red;display:none">User name already
                                                    exists</div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Password <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input type="hidden" id="duplicate_check">

                                                <input class="form-control password" type="password" required
                                                    placeholder="Enter " name="password" value="{{ old('password') }}"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Status <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <select name="status" id="" required
                                                    class="form-control status">

                                                    <option value="">--Select Status --</option>

                                                    @if (old('status') == 'active')
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

                                    <div class="form-group row">

                                        <label for="example-search-input"
                                            class="col-sm-2 col-form-label">Description</label>

                                        <div class="col-sm-12">

                                            <textarea id="elm1" name="description" value="{{ old('description') }}"></textarea>



                                            {{-- <div class="summernote"></div> --}}

                                        </div>

                                    </div>

                                    <div class="col-md-12 d-flex">

                                        <button class="btn btn-primary" id="submit"
                                            type="submit">Submit</button>&nbsp;

                                        <button class="btn btn-secondary" type="submit">Cancel</button>

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

        function validate(evt) {

            evt = (evt) ? evt : window.event;

            var charCode = (evt.which) ? evt.which : evt.keyCode;

            if (charCode > 31 && (charCode < 48 || charCode > 57)) {

                return false;

            }

            return true;

        }



        $("form").submit(function(e) {

            var token = "{{ csrf_token() }}";

            $.ajax({

                url: "{{ url('duplicate_user') }}",

                type: "POST",

                dataType: "JSON",

                data: {

                    user_name: $('.user_name').val(),



                    _token: token,

                },



                success: function(data) {



                    $('#duplicate_check').val(data.validation);

                }

            });

            if ($('#duplicate_check').val() == "duplicate") {



                $('#user_err').css('display', 'block');

                return false;

                e.preventDefault();

            }





        });
    </script>
@endsection

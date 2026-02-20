@extends('backend.layouts.master')

@section('content')

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="#">Home</a></li>

                            <li class="breadcrumb-item"><a href="#">Inventroy</a></li>

                            <li class="breadcrumb-item active">Add Warehouse</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Create Warehouse</h5>

                </div>

            </div>

            <div class="col-lg-12">

                @include('backend.layouts.notification')

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Create Warehouse</h4>

                <a href="{{ route('warehouse.index') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
                        aria-hidden="true"></i> Back</a>

            </div>

            <div class="row">

                <div class="col-12">

                    <div class="card m-b-30">

                        <div class="card-body">

                            <!-- <h4 class="mt-0 header-title">Textual inputs</h4>

                                                    <p class="text-muted m-b-30 font-14">Here are examples of <code

                                                            class="highlighter-rouge">.form-control</code> applied to each

                                                        textual HTML5 <code class="highlighter-rouge">&lt;input&gt;</code> <code

                                                                class="highlighter-rouge">type</code>.</p> -->

                            <form method="post" action="{{ route('warehouse.store') }}">

                                @csrf

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-12 col-form-label">Warehouse Code

                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-10">

                                                @if (count(\App\Models\Warehouse::orderBy('id', 'DESC')->limit('1')->get('id')) > 0)
                                                    @foreach (\App\Models\Warehouse::orderBy('id', 'DESC')->limit('1')->get('warehouse_code') as $item)
                                                        <input class="form-control" type="text" name="warehouse_code"
                                                            placeholder="Enter"
                                                            value="Warehouse-0000{{ explode('-', $item->warehouse_code)[1] + 1 }}"
                                                            readonly id="example-text-input">
                                                    @endforeach
                                                @else
                                                    <input class="form-control" type="text" name="warehouse_code"
                                                        placeholder="Enter" value="Warehouse-00001" readonly
                                                        id="example-text-input">
                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-12 col-form-label">Warehouse

                                                Name</label>

                                            <div class="col-sm-10">

                                                <input class="form-control" type="text" name="warehouse_name"
                                                    placeholder="Enter " id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-12 col-form-label">Email

                                                Address</label>

                                            <div class="col-sm-10">

                                                <input class="form-control" type="text" name="email_address"
                                                    placeholder="Enter " id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-12 col-form-label">Phone</label>

                                            <div class="col-sm-10">

                                                <input class="form-control" type="text" name="phone"
                                                    placeholder="Enter Phone Number" id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-12 col-form-label">Warehouse

                                                Address</label>

                                            <div class="col-sm-10">

                                                <input class="form-control" type="text" name="warehouse_address"
                                                    placeholder="Enter " id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">City</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" name="warehouse_city"
                                                    placeholder="Enter " id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input"
                                                class="col-sm-4 col-form-label">Pincode</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" name="warehouse_pincode"
                                                    placeholder="Enter " id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Business

                                                Days</label>

                                            <div class="col-sm-8">

                                                <select class="js-example-basic-single" name="business_days[]"
                                                    id="business_days" required placeholder="Select" style="width:100%;"
                                                    multiple="multiple">

                                                    <option value="Sat">Saturday</option>

                                                    <option value="Sun">Sunday</option>

                                                    <option value="Mon">Monday</option>

                                                    <option value="Tues">Tuesday</option>

                                                    <option value="Wed">Wednesday</option>

                                                    <option value="Thurs">Thursday</option>

                                                    <option value="Fri">Friday</option>

                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Opening

                                                Time</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="time" name="open_time"
                                                    placeholder="Enter Opening time" id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Closing

                                                Time</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="time" name="close_time"
                                                    placeholder="Enter Opening time" id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Status</label>

                                            <div class="col-sm-8">

                                                <select name="status" id="" class="form-control">

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

                                    <div class="col-md-12">

                                        <div class="form-group row">

                                            <label for="example-text-input"
                                                class="col-sm-6 col-form-label">Description</label>

                                            <div class="col-sm-12">

                                                <textarea id="elm1" name="warehouse_note" value=""></textarea>

                                            </div>

                                        </div>

                                    </div>

                                    <div class=" col-md-12 d-flex">

                                        <button class="btn btn-primary" type="submit">Submit</button>&nbsp;

                                        <button class="btn btn-secondary" type="reset">Cancel</button>

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

@endsection

@section('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $(document).ready(function() {

            $('.js-example-basic-single').select2({

                // maximumSelectionLength: 4,

                placeholder: "Select",

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

        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });

        $('.dltBtn').click(function(e) {

            var form = $(this).closest('form');

            var dataID = $(this).data('id');

            e.preventDefault();

            swal({

                    title: "Are you sure?",

                    text: "Once deleted, you will not be able to recover",

                    icon: "warning",

                    buttons: true,

                    dangerMode: true,

                })

                .then((willDelete) => {

                    if (willDelete) {

                        form.submit();

                        swal("Poof! Your imaginary file has been deleted!", {

                            icon: "success",

                        });

                    } else {

                        swal("Your imaginary file is safe!");

                    }

                });

        });
    </script>
@endsection

@extends('backend.layouts.master')

@section('content')

    <style>
        /**.page-content-wrapper {
                    height: auto;
                    max-height: 80vh;
                    overflow-y: auto;
                } */
        @media (max-width: 767px) {
            .page-content-wrapper {
                height: auto;
                max-height: 90vh;
                overflow-y: auto;
            }
        }
    </style>

    <div class="page-content-wrapper">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="{{ route('coupon.index') }}">Coupon</a></li>

                            <li class="breadcrumb-item active">Create Coupon</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Coupon</h5>

                </div>

            </div>

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0">Create Coupon</h4>

                <a href="{{ route('coupon.index') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
                        aria-hidden="true"></i> Back</a>

            </div>

            <div class="row">

                <div class="col-12">

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

                    @include('backend.layouts.notification')

                    <div class="card m-b-30">

                        <div class="card-body">

                            <!-- <h4 class="mt-0 header-title">Textual inputs</h4>

                                <p class="text-muted m-b-30 font-14">Here are examples of <code

                                        class="highlighter-rouge">.form-control</code> applied to each

                                    textual HTML5 <code class="highlighter-rouge">&lt;input&gt;</code> <code

                                            class="highlighter-rouge">type</code>.</p> -->

                            <form action="{{ route('coupon.update', $coupon->id) }}" method="post">

                                @csrf

                                @method('PATCH')

                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Coupon Details
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <select class="form-control" name="offer_details" id="offer_details"
                                                    onchange="offerdetails()">
                                                    <option value="0" <?php if ($coupon->offer_details == 0) {
                                                        echo 'selected';
                                                    } ?>>Others</option>
                                                    <option value="1" <?php if ($coupon->offer_details == 1) {
                                                        echo 'selected';
                                                    } ?>>Flat Offers</option>
                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-4 col-form-label">Select
                                                Products</label>
                                            <div class="col-sm-8" id="others">
                                                <select name="product_id[]" class="form-control select2" multiple>
                                                    <!--<option value="0" -->
                                                    @if (in_array(0, explode(',', $coupon->product_id)))
                                                        selected
                                                    @endif>
                                                    <!--All Products-->
                                                    <!--</option>-->
                                                    @foreach ($product as $products)
                                                        <option value="{{ $products->id }}"
                                                            @if (in_array($products->id, explode(',', $coupon->product_id))) selected @endif>
                                                            {{ $products->name }} - {{ $products->hsn_code }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-sm-10" id="flat"style="display:none;">
                                                <select name="product_id[]" class="form-control select2" multiple
                                                    id="product_select">
                                                    <option value="0">All Products</option>

                                                </select>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Coupon
                                                Name</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" name="coupon_name"
                                                    value="{{ $coupon->coupon_name }}" type="text" required
                                                    placeholder="Enter Name" id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Coupon
                                                Code</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" name="coupon_code"
                                                    value="{{ $coupon->coupon_code }}" type="text" required
                                                    placeholder="Enter Name" id="example-text-input">

                                                <input class="form-control" name="id" value="{{ $coupon->id }}"
                                                    type="hidden" required>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6 flatoffers">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Amount Orders
                                                above</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" name="offeramountabove"
                                                    value="{{ $coupon->offeramountabove }}"
                                                    value="{{ old('offeramountabove') }}" type="text"
                                                    placeholder="Amount Orders above" id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6 flatoffers">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Flat Offer
                                                Amount</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" name="flatofferamount"
                                                    value="{{ $coupon->flatofferamount }}"
                                                    value="{{ old('flatofferamount') }}" type="text"
                                                    placeholder="Flat Offer Amount" id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6 otherscoupan">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Start
                                                Date</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" name="start_date"
                                                    value="{{ $coupon->start_date }}" type="datetime-local"
                                                    placeholder="Enter Name" id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6 otherscoupan">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">End
                                                Date</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" name="end_date" type="datetime-local"
                                                    value="{{ $coupon->end_date }}" placeholder="Enter Name"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Status</label>

                                            <div class="col-sm-8">

                                                <select id="" name="Status" value="{{ $coupon->Status }}"
                                                    class="form-control" required>

                                                    <option value="">-- Select Status --</option>

                                                    @if ($coupon->Status == 'active')
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

                                    <!--            <div class="col-md-6">-->

                                    <!--                <div class="form-group row">-->

                                    <!--                    <label for="example-text-input" class="col-sm-4 col-form-label">Discount Type</label>-->

                                    <!--                    <div class="col-sm-8">-->

                                    <!--                    <select class="form-control" name='discount_type'>-->

                                    <!--    <option>--Discount Type--</option>-->

                                    <!--    <option value="fixed" {{ $coupon->discount_type == 'fixed' ? 'selected' : '' }}>Fixed</option>-->

                                    <!--    <option value="percentage" {{ $coupon->discount_type == 'percentage' ? 'selected' : '' }}>Percentage</option>-->

                                    <!--</select>-->

                                    <!--                    </div>-->

                                    <!--                </div>-->

                                    <!--            </div>-->

                                    <div class="col-md-6 otherscoupan">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Maximum Coupon
                                                limit</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" name="max_coupon_limit" type="text"
                                                    value="{{ $coupon->max_coupon_limit }}"
                                                    placeholder="Enter Maximum limit" id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <!--                    <div class="col-md-6">-->

                                    <!--                    <div class="form-group row">-->

                                    <!--                    <label for="example-text-input" class="col-sm-4 col-form-label">Discount Type</label>-->

                                    <!-- <label for="condition" class="col-sm-2 col-form-label">Type</label> -->

                                    <!--    <div class="col-sm-8">-->

                                    <!--        <select class="form-control" required name='discount_type'>-->

                                    <!--            <option value="">--Select Discount Type--</option>-->

                                    <!--            <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed</option>-->

                                    <!--            <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage</option>-->

                                    <!--        </select>-->

                                    <!--    </div>-->

                                    <!--</div>-->

                                    <!--</div>         -->

                                    <div class="col-md-6 otherscoupan">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Discount
                                                %</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="number" min="0" max="100"
                                                    placeholder="Enter Coupon Percentage" name="value"
                                                    value="{{ $coupon->value }}" id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <!--<div class="col-md-6">-->

                                    <!--    <div class="form-group row">-->

                                    <!--        <label for="example-text-input" class="col-sm-4 col-form-label">Minimum Order Amount</label>-->

                                    <!--        <div class="col-sm-8">-->

                                    <!--            <input class="form-control" type="text" placeholder="Enter Minimum Order Amount" name="minimum_order_amount" value="{{ $coupon->minimum_order_amount }}" required id="example-text-input">-->

                                    <!--        </div>-->

                                    <!--    </div>-->

                                    <!--</div>    -->

                                    <div class=" col-md-12 d-flex">

                                        <button class="btn btn-primary" type="submit">Submit</button>&nbsp;

                                        <button class="btn btn-secondary" type="reset">Cancel</button>

                                    </div>

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
                $('.select2').select2({
                    placeholder: "Select Products",
                    allowClear: true,
                    width: '100%'
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

        <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>

        <script>
            jQuery(document).ready(function() {

                $('.summernote').summernote({

                    height: 80, // set editor height

                    minHeight: null, // set minimum height of editor

                    maxHeight: null, // set maximum height of editor

                    focus: true // set focus to editable area after initializing summernote

                });

            });
        </script>

        <script>
            $('#is_parent').change(function(e) {

                e.preventDefault();

                var is_checked = $('#is_parent').prop('checked');

                // swal("Attention", 'is_checked', "warning")

                if (is_checked) {

                    $('#parent_cat_div').addClass('d-none');

                    $('#parent_cat_div').val('');

                } else {

                    $('#parent_cat_div').removeClass('d-none');

                }

            })

            function offerdetails() {
                var per = $("#offer_details").val();
                if (per == 1) {
                    $("#flat").show();
                    $("#others").hide();
                    $(".otherscoupan").css('display', 'none');
                    $(".flatoffers").css('display', 'block');
                } else {

                    $("#others").show();
                    $("#flat").hide();
                    $(".otherscoupan").css('display', 'block');
                    $(".flatoffers").css('display', 'none');
                }

            }
            $(document).ready(function() {
                var per = $("#offer_details").val();
                if (per == 1) {
                    $("#flat").show();
                    $("#others").hide();
                    $(".otherscoupan").css('display', 'none');
                    $(".flatoffers").css('display', 'block');
                } else {
                    $("#others").show();
                    $("#flat").hide();
                    $(".otherscoupan").css('display', 'block');
                    $(".flatoffers").css('display', 'none');
                }
            });
        </script>
    @endsection

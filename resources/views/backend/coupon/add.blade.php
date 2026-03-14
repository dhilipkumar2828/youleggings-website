@extends('backend.layouts.master')

@section('content')

    <style>
        /***  .page-content-wrapper {
                    height: auto;
                    max-height: 80vh;
                    overflow-y: auto;
                    max-width: 100%; /* Ensure the container does not overflow horizontally

                }   */
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

            <div class="row ">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb ">

                       <a href="{{ route('coupon.index') }}" class="btn btn-primary ripple px-4">
                            <i class="fa fa-angle-left"></i> Back
                        </a>

                    </div>

                    <h5 class="page-title">Coupon</h5>

                </div>

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

                            <form action="{{ route('coupon.store') }}" method="post">

                                @csrf

                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group row">
                                            <label for="offer_details" class="col-sm-4 col-form-label">Coupon Details <span
                                                    style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="offer_details" id="offer_details"
                                                    onchange="offerdetails()">
                                                    <option value="0">Others</option>
                                                    <option value="1">Flat Offers</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="product_select" class="col-sm-4 col-form-label">Select
                                                Products</label>
                                            <div class="col-sm-8" id="others">
                                                <select name="product_id[]" class="form-control select2" multiple
                                                    id="product_select">
                                                    @foreach ($product as $products)
                                                        <option value="{{ $products->id }}">{{ $products->name }} -
                                                            {{ $products->hsn_code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-8" id="flat" style="display:none;">
                                                <select name="product_id[]" class="form-control select2" multiple>
                                                    <option value="0">All Products</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!--    <div class="col-md-6">-->
                                    <!--    <div class="form-group row">-->
                                    <!--        <label for="example-text-input" class="col-sm-4 col-form-label">Select Products</label>-->
                                    <!--        <div class="col-sm-8">-->
                                    <!--            <select name="product_id[]" class="form-control" multiple id="product_select">-->
                                    <!--                <option value="0" >All Products</option>-->
                                    <!--                @foreach ($product as $products)
    -->
                                    <!--                    <option value="{{ $products->id }}">{{ $products->name }} - {{ $products->hsn_code }}</option>-->
                                    <!--
    @endforeach-->
                                    <!--            </select>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->

                                    <!--                                                         <div class="col-md-6">-->
                                    <!--    <div class="form-group row">-->
                                    <!--        <label for="example-text-input" class="col-sm-4 col-form-label">Select Products</label>-->
                                    <!--        <div class="col-sm-8">-->
                                    <!--            <select name="product_id[]" class="form-control" multiple>-->
                                    <!--                <option value="0">All Products</option>-->
                                    <!--                @foreach ($product as $products)
    -->
                                    <!--                    <option value="{{ $products->id }}">{{ $products->name }} - {{ $products->hsn_code }}</option>-->
                                    <!--
    @endforeach-->
                                    <!--            </select>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->

                                    <div class="col-md-6">

                                        <div class="form-group row">
                                            <label for="coupon_name" class="col-sm-4 col-form-label">Coupon Name</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" name="coupon_name"
                                                    value="{{ old('coupon_name') }}" type="text" required
                                                    placeholder="Enter Name" id="coupon_name">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">
                                            <label for="coupon_code" class="col-sm-4 col-form-label">Coupon Code <span
                                                    style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <input class="form-control" name="coupon_code" id="coupon_code"
                                                    value="{{ old('coupon_code') }}" type="text" required
                                                    placeholder="Enter Code">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6 flatoffers">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Amount Orders
                                                above <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control" name="offeramountabove"
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
                                                    value="{{ old('start_date') }}" type="datetime-local"
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
                                                    value="{{ old('end_date') }}" placeholder="Enter Name"
                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <!-- <div class="col-md-6">

                                                                <div class="form-group row">

                                                                    <label for="example-text-input" name="discount_type" class="col-sm-4 col-form-label">Discount Type</label>

                                                                    <div class="col-sm-8">

                                                                    <input class="form-control" type="text" placeholder="" value="{{ old('discount_type') }}" name="discount_type" required id="example-text-input">

                                                                    </div>

                                                                </div>

                                                            </div> -->

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Status <span
                                                    style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <div class="premium-switch-group">
                                                    <input type="radio" name="Status" id="status_active" value="active" {{ old('Status') == 'active' || old('Status') === null ? 'checked' : '' }}>
                                                    <label for="status_active">
                                                        <i class="fa fa-check-circle"></i> Active
                                                    </label>
                                                    
                                                    <input type="radio" name="Status" id="status_inactive" value="inactive" {{ old('Status') == 'inactive' ? 'checked' : '' }}>
                                                    <label for="status_inactive">
                                                        <i class="fa fa-times-circle"></i> Inactive
                                                    </label>
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6 otherscoupan">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Maximum Coupon
                                                limit <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control" name="max_coupon_limit" type="text"
                                                    value="{{ old('max_coupon_limit') }}"
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

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Discount %
                                                <span style="color:red">*</span></label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="number" min="0" max="100"
                                                    placeholder="Enter Coupon Percentage" name="value"
                                                    value="{{ old('value') }}" id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <!--<div class="col-md-6">-->

                                    <!--    <div class="form-group row">-->

                                    <!--        <label for="example-text-input" class="col-sm-4 col-form-label">Minimum Order Amount</label>-->

                                    <!--        <div class="col-sm-8">-->

                                    <!--            <input class="form-control" type="text" placeholder="Enter Minimum Order Amount" name="minimum_order_amount" value="{{ old('minimum_order_amount') }}" required id="example-text-input">-->

                                    <!--        </div>-->

                                    <!--    </div>-->

                                    <!--</div>    -->

                                    <div class=" col-md-12 d-flex">

                                        <button class="btn btn-primary" type="submit"
                                            id="submitBtn">Submit</button>&nbsp;


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
                    $(".otherscoupan").css('display', 'none');
                    $(".flatoffers").css('display', 'block');
                } else {
                    $(".otherscoupan").css('display', 'block');
                    $(".flatoffers").css('display', 'none');
                }
            });
        </script>

        <script>
            document.getElementById('submitBtn').addEventListener('click', function(event) {
                var coupon_code = document.getElementById('coupon_code').value;

                // If pincode is empty, show an alert
                if (!coupon_code) {
                    swal("Attention", 'coupon_code is required!', "warning");
                    return;
                }

                // Send an AJAX request to check if the pincode exists
                fetch('{{ route('checkCouponcode') }}', { // Adjust this URL to your route
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Laravel CSRF token
                        },
                        body: JSON.stringify({
                            coupon_code: coupon_code
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            swal("Attention", 'This coupon code already exists!', "warning");
                        } else {}
                    })
                    .catch(error => {
                        console.error('Error checking coupon code:', error);
                        swal("Attention", 'There was an error checking the coupon code.', "warning");
                    });
            });
        </script>
    @endsection

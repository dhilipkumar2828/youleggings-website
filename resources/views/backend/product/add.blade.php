@extends('backend.layouts.master')

@section('content')
    <style>
        /* Wizard Styling */
        #msform {
            text-align: center;
            position: relative;
            margin-top: 20px;
        }

        #msform fieldset {
            background: white;
            border: 0 none;
            border-radius: 12px;
            box-shadow: 0 10px 30px 0 rgba(0, 0, 0, 0.05);
            padding: 40px;
            box-sizing: border-box;
            width: 100%;
            margin: 0;
            position: relative;
        }

        #msform fieldset:not(:first-of-type) {
            display: none;
        }

        #progressbar {
            margin-bottom: 40px;
            overflow: hidden;
            color: #ccd1d9;
            padding-left: 0;
            display: flex;
            justify-content: center;
        }

        #progressbar .active {
            color: var(--primary-color, #673AB7);
        }

        #progressbar li {
            list-style-type: none;
            font-size: 13px;
            width: 33.33%;
            float: left;
            position: relative;
            font-weight: 600;
            text-transform: uppercase;
        }

        #progressbar #product:before {
            content: "\f0d1";
            font-family: FontAwesome;
        }

        #progressbar #product_variant:before {
            content: "\f02c";
            font-family: FontAwesome;
        }

        #progressbar #confirm:before {
            content: "\f00c";
            font-family: FontAwesome;
        }

        #progressbar li:before {
            width: 50px;
            height: 50px;
            line-height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #ffffff;
            background: #ccd1d9;
            border-radius: 50%;
            margin: 0 auto 10px auto;
            transition: all 0.3s ease;
            z-index: 2;
            position: relative;
        }

        #progressbar li:after {
            content: '';
            width: 100%;
            height: 2px;
            background: #ccd1d9;
            position: absolute;
            left: -50%;
            top: 25px;
            z-index: 1;
        }

        #progressbar li:first-child:after {
            content: none;
        }

        #progressbar li.active:before,
        #progressbar li.active:after {
            background: var(--primary-color, #673AB7);
        }

        .fs-title {
            font-size: 24px;
            color: #2C3E50;
            margin-bottom: 20px;
            font-weight: 700;
            text-align: left;
        }

        .steps {
            font-size: 16px;
            color: #9E9E9E;
            margin-bottom: 20px;
            font-weight: 500;
            text-align: right;
        }

        .action-button {
            width: 130px;
            background: var(--primary-color, #673AB7);
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 8px;
            cursor: pointer;
            padding: 12px 5px;
            margin: 10px 5px;
            transition: all 0.3s ease;
        }

        .action-button:hover,
        .action-button:focus {
            box-shadow: 0 0 0 2px white, 0 0 0 3px var(--primary-color, #673AB7);
            transform: translateY(-2px);
        }

        .action-button-previous {
            width: 130px;
            background: #616161;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 8px;
            cursor: pointer;
            padding: 12px 5px;
            margin: 10px 5px;
            transition: all 0.3s ease;
        }

        .action-button-previous:hover,
        .action-button-previous:focus {
            box-shadow: 0 0 0 2px white, 0 0 0 3px #616161;
            transform: translateY(-2px);
        }

        .form-card {
            text-align: left;
        }

        .form-group label {
            font-weight: 600;
            color: #495057;
        }

        .error {
            color: #f44336;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .success-animation {
            margin: 50px auto;
        }

        .checkmark {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: block;
            margin: 0 auto;
            stroke-width: 2;
            stroke: #4bb543;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-dasharray: 1000;
            stroke-dashoffset: 1000;
            animation: dash 1.5s ease-in-out forwards;
        }

        @keyframes dash {
            to {
                stroke-dashoffset: 0;
            }
        }

        .select2-container--default .select2-selection--multiple {
            border: 1px solid #ced4da !important;
            border-radius: .25rem !important;
            min-height: 38px !important;
        }

        .note-editor.note-frame.card {
            width: 100% !important;
        }
    </style>

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row card">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <a href="{{ route('product.index') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
                        aria-hidden="true"></i> Back</a>

                    </div>

                    <h5 class="page-title">Create Product</h5>

                </div>

            </div>

          
            <div class="row">

                <div class="col-12">

                    @if ($errors->any())
                        <div class="alert alert-danger">

                            <ul>

                            </ul>

                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class=" m-b-30">

                        <div class="card-body">

                            <div class="container-fluid">

                                <div class="row justify-content-center">

                                    <div class="col-12 text-center p-0">

                                        <div class="card px-0 pt-4 pb-0 mt-3 mb-3">

                                            <!-- <h2 id="heading">Sign Up Your User </h2> -->

                                            <p>Fill all form field to go to next step</p>

                                            <form id="msform" action="{{ route('product.store') }}" method="POST">

                                                @csrf

                                                <!-- progressbar -->

                                                <ul id="progressbar">

                                                    <li class="active" id="product"><strong>Product</strong></li>
                                                    <!----
                                                        <li id="product_attribute"><strong>Product Details</strong></li>
                                                        ---->

                                                    <li id="product_variant"><strong>Product Variant</strong></li>

                                                    <!-- <li id="product_image"><strong>Product Image</strong></li> -->

                                                    <li id="confirm"><strong>Finish</strong></li>

                                                </ul>

                                                <!-- <div class="progress">

                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>

                                                    </div> <br>  -->

                                                <!-- product -->

                                                <fieldset>

                                                    <div class="form-card">

                                                        <div class="row">

                                                            <div class="col-7">

                                                                <h2 class="fs-title">Product Details:</h2>

                                                            </div>

                                                            <div class="col-5">

                                                                <h2 class="steps">Step 1 - 3</h2>

                                                            </div>

                                                        </div>

                                                        <div class="row">

                                                            <div class="col-md-6">

                                                                <div class="form-group row">

                                                                    <label for="example-text-input"
                                                                        class="col-sm-4 col-form-label">Name <span
                                                                            style="color:red">*</span></label>

                                                                    <div class="col-sm-8">

                                                                        <input class="form-control required"
                                                                            autofocus="true" type="text"
                                                                            placeholder="Enter Name" id="example-text-input"
                                                                            name="name" value="{{ old('name') }}"
                                                                            required>

                                                                        <span class="error"></span>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="col-md-6" style="display:none;">

                                                                <div class="form-group row">

                                                                    <label for="example-text-input"
                                                                        class="col-sm-4 col-form-label">Brand Name <span
                                                                            style="color:red">*</span></label>

                                                                    <div class="col-sm-8">

                                                                        <input class="form-control" autofocus="true"
                                                                            type="text" placeholder="Enter Brand Name"
                                                                            id="example-text-input" name="brand_name"
                                                                            value="{{ old('brand_name') }}">

                                                                        <span class="error"></span>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="col-md-6">

                                                                <div class="form-group row">

                                                                    <label for="example-text-input"
                                                                        class="col-sm-4 col-form-label">Image <span
                                                                            style="color:red">*</span></label>

                                                                    <!-- <img src="assets/images/image.png" class="admin-image"> -->

                                                                    <div class="col-sm-8">

                                                                        <div class="input-group d-flex align-items-center"
                                                                            style="border: 1px dashed #ced4da; border-radius: 8px; padding: 0 5px; background: #fff; height: 45px;">
                                                                            <span class="input-group-btn"
                                                                                style="margin-right:0;">
                                                                                <a id="lfm" data-input="thumbnail"
                                                                                    data-preview="holder"
                                                                                    class="btn btn-primary ripple"
                                                                                    style="border-radius: 6px; padding: 6px 12px;">
                                                                                    <i class="fa fa-picture-o"></i> Choose
                                                                                </a>
                                                                            </span>
                                                                            <input id="thumbnail" required
                                                                                class="form-control" type="text"
                                                                                value="{{ old('product_photo') }}"
                                                                                name="product_photo"
                                                                                style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;"
                                                                                placeholder="Select an image...">
                                                                        </div>
                                                                        <span class="error"></span>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="col-md-6">

                                                                <div class="form-group row">

                                                                    <label for="example-text-input"
                                                                        class="col-sm-4 col-form-label">Youtube link
                                                                    </label>

                                                                    <div class="col-sm-8">

                                                                        <input class="form-control" autofocus="true"
                                                                            type="text"
                                                                            placeholder="Enter Youtube Link"
                                                                            id="example-text-input" name="youtube_link"
                                                                            value="{{ old('youtube_link') }}">

                                                                        <span class="error"></span>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="col-md-6">

                                                                <div class="form-group row">

                                                                    <label for="example-text-input"
                                                                        class="col-sm-4 col-form-label">Category <span
                                                                            style="color:red">*</span></label>

                                                                    <div class="col-sm-8">

                                                                        <select class="form-control required category"
                                                                            name='category' id="cat_id" required>

                                                                            <option value="">Select Category</option>

                                                                            @foreach ($category as $cate)
                                                                                <option value="{{ $cate->id }}">
                                                                                    {{ $cate->title }}</option>
                                                                            @endforeach

                                                                        </select>

                                                                        <span class="error"></span>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="col-md-6" id="sub_cat" style="display:none;">

                                                                <div class="form-group row">

                                                                    <label for="example-text-input"
                                                                        class="col-sm-4 col-form-label">Sub Category <span
                                                                            style="color:red">*</span></label>

                                                                    <div class="col-sm-8">

                                                                        <select class="form-control" name='subcategory_id'
                                                                            id="subcat_id">

                                                                            <option value="">Select Category</option>

                                                                        </select>

                                                                        <span class="error"></span>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="col-md-6" id="child_cat" style="display:none;">

                                                                <div class="form-group row">

                                                                    <label for="example-text-input"
                                                                        class="col-sm-4 col-form-label">Child
                                                                        Category</label>

                                                                    <div class="col-sm-8">

                                                                        <select class="form-control"
                                                                            name='childcategory_id' id="childcat_id">

                                                                            <option value="">Select Category</option>

                                                                        </select>

                                                                        <span class="error"></span>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="col-md-6">

                                                                <div class="form-group row">

                                                                    <label for="example-text-input"
                                                                        class="col-sm-4 col-form-label">Discount
                                                                        Type</label>

                                                                    <div class="col-sm-8">

                                                                        <select class="form-control" name='discount_type'>

                                                                            <option value="">--Select Discount Type--
                                                                            </option>

                                                                            <option value="fixed"
                                                                                {{ old('type') == 'fixed' ? 'selected' : '' }}>
                                                                                Fixed</option>

                                                                            <option value="percentage"
                                                                                {{ old('type') == 'percentage' ? 'selected' : '' }}>
                                                                                Percentage</option>

                                                                        </select>

                                                                        <span class="error"></span>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="col-md-6">

                                                                <div class="form-group row">

                                                                    <label for="example-text-input"
                                                                        class="col-sm-4 col-form-label">Discount</label>

                                                                    <div class="col-sm-8">

                                                                        <input class="form-control" type="number"
                                                                            placeholder="" id="example-text-input"
                                                                            name="discount"
                                                                            value="{{ old('discount') }}">

                                                                        <span class="error"></span>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="col-md-6">

                                                                <div class="form-group row">

                                                                    <label for="example-text-input"
                                                                        class="col-sm-4 col-form-label">Tax Id </label>

                                                                    <div class="col-sm-8">

                                                                        <select class="form-control" name='tax_id'
                                                                            id="tax_id">

                                                                            <!--<option value="">Select Tax</option>-->

                                                                            @foreach ($tax as $t)
                                                                                <option value="{{ $t->id }}">
                                                                                    {{ $t->tax_name }}</option>
                                                                            @endforeach

                                                                        </select>

                                                                        <span class="error"></span>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="example-text-input"
                                                                        class="col-sm-4 col-form-label">No of Days Delivery
                                                                        <span style="color:red">*</span></label>
                                                                    <div class="col-sm-8">
                                                                        <input class="form-control required"
                                                                            autofocus="true" min="0"
                                                                            max="15" type="number"
                                                                            placeholder="No of Days Delivery"
                                                                            id="example-text-input" name="delivery_days"
                                                                            value="{{ old('delivery_days') }}">
                                                                        <span class="error"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="example-text-input"
                                                                        class="col-sm-4 col-form-label">HSN Code <span
                                                                            style="color:red">*</span></label>
                                                                    <div class="col-sm-8">
                                                                        <input class="form-control required"
                                                                            autofocus="true" type="text"
                                                                            placeholder="HSN Code" id="example-text-input"
                                                                            name="hsn_code"
                                                                            value="{{ old('hsn_code') }}">
                                                                        <span class="error"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="tag"
                                                                        class="col-sm-4 col-form-label">Tag <span
                                                                            style="color:red">*</span></label>
                                                                    <div class="col-sm-8">
                                                                        <select id="tag" name="tag"
                                                                            class="form-control">
                                                                            <option value="0">-- 0 --</option>
                                                                            <option value="LC" style="display:none;">
                                                                                LC</option>
                                                                            <option value="NA">NA</option>
                                                                            <!-- Add more options as needed -->
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group row">
                                                                    <label class="col-sm-4 col-form-label">Is variant
                                                                        Available?</label>
                                                                    <div class="col-sm-8">
                                                                        <div
                                                                            style="display: flex; gap: 20px; align-items: center; margin-top: 10px;">
                                                                            <div
                                                                                style="display: flex; align-items: center;">
                                                                                <input type="radio" name="is_variant"
                                                                                    id="variant_yes" value="yes"
                                                                                    checked
                                                                                    style="width: auto; height: auto; margin-right: 8px;">
                                                                                <label for="variant_yes"
                                                                                    style="margin-bottom: 0;">Yes</label>
                                                                            </div>
                                                                            <div
                                                                                style="display: flex; align-items: center;">
                                                                                <input type="radio" name="is_variant"
                                                                                    id="variant_no" value="no"
                                                                                    style="width: auto; height: auto; margin-right: 8px;">
                                                                                <label for="variant_no"
                                                                                    style="margin-bottom: 0;">No</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 no-variant-fields" style="display:none;">
                                                                <div class="form-group row">
                                                                    <label for="prod_regular_price"
                                                                        class="col-sm-4 col-form-label">Regular
                                                                        Price(MRP)</label>
                                                                    <div class="col-sm-8">
                                                                        <input class="form-control" step="any"
                                                                            type="text" placeholder="Enter Price"
                                                                            id="prod_regular_price"
                                                                            name="prod_regular_price"
                                                                            value="{{ old('prod_regular_price') }}">
                                                                        <span class="error"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 no-variant-fields" style="display:none;">
                                                                <div class="form-group row">
                                                                    <label for="prod_stock"
                                                                        class="col-sm-4 col-form-label">Stock</label>
                                                                    <div class="col-sm-8">
                                                                        <input class="form-control" type="number"
                                                                            placeholder="Enter Stock" id="prod_stock"
                                                                            name="prod_stock"
                                                                            value="{{ old('prod_stock') }}">
                                                                        <span class="error"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <?php
                                                            $description = '
                                                                                                                        <hr>
                                                                                                                        <p><b>Pattern :</b> A - Line Kurti&nbsp; + Pant&nbsp; ( Cord Set ) With Side Pocket</p><p><b>Fabric :</b> Jaipur Cotton&nbsp;</p><p><b>Kurti Height :</b> 45 inch</p><p><b>Pant Length : </b>35 inch</p>
                                                                                                                        ';
                                                            ?>

                                                            <div class="col-12">

                                                                <div class="form-group ">

                                                                    <label for="example-text-input"
                                                                        class="col-sm-6 col-form-label">Description</label>

                                                                    <div>

                                                                        <textarea class="summernote" name="description" value="{{ $description }}">{{ $description }}</textarea>

                                                                        <span class="error"></span>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <?php
                                                            $usage = '<p><b><span style="font-size: 18px;">Wash Care:</span></b></p><p>Hand Wash Or Machine wash cold with mild detergent, tumble dry low, iron if needed.</p><p><b>Note : </b>The color of the real product may slightly differ from the image displayed&nbsp; on the screen , owning to screen resolution and photography effects.</p>';
                                                            ?>
                                                            <div class="col-12" style="display:none;">

                                                                <div class="form-group ">

                                                                    <label for="example-text-input"
                                                                        class="col-sm-6 col-form-label">Usage</label>

                                                                    <div class="col-sm-10">

                                                                        <textarea class="summernote" name="usage" value="{{ $usage }}">{{ $usage }}</textarea>

                                                                        <span class="error"></span>

                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <!----
                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Size</label>

                                            <div class="col-sm-8">

                                                <select class="form-control required"  name='size' id="size" required>

                                                <option value="">Select Size</option>

                                                    <option value="1">S</option>
                                                    <option value="2">M</option>
                                                    <option value="3">L</option>
                                                    <option value="4">XL</option>
                                                    <option value="5">XXL</option>
                                                    <option value="6">XXXL</option>

                                                </select>

                                                <span class="error"></span>

                                            </div>

                                         </div>

                                    </div>

                                                        <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input" class="col-sm-4 col-form-label">Regular Price(MRP) <span style="color:red">*</span></label>

                                                                <div class="col-sm-8">

                                                                    <input class="form-control required" step="any" type="text" placeholder="" required id="example-text-input" name="prod_regular_price"value="{{ old('price') }}">

                                                                    <span class="error"></span>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">

                                                                <div class="form-group row">

                                                                    <label for="example-text-input" class="col-sm-4 col-form-label">Stock <span style="color:red">*</span></label>

                                                                    <div class="col-sm-8">

                                                                        <input class="form-control required" type="number"  placeholder="" required id="example-text-input" name="prod_stock"value="{{ old('stock') }}">

                                                                        <span class="error"></span>

                                                                    </div>

                                                                </div>

                                                        </div>

        ---->

                                                            <!-- <div class="col-md-6">

                                                            <div class="form-group row">

                                                                <label for="example-text-input" class="col-sm-4 col-form-label">Main Products <span style="color:red">*</span></label>

                                                                <div class="col-sm-8">

                                                                    <select class="form-control required"  name='main_products' id="main_products" required>

                                                                    <option value="">Select Status</option>

                                                                   <option value="active">Active</option>

                                                                   <option value="in active">In Active</option>

                                                                    </select>

                                                                    <span class="error"></span>

                                                                </div>

                                                            </div>

                                                        </div> -->

                                                            {{-- <div class="col-md-6">

                                                    <div class="form-group row">

                                                        <label for="example-text-input" class="col-sm-4 col-form-label">Header <span style="color:red">*</span></label>

                                                        <div class="col-sm-8">

                                                            <select class="form-control required"  name='header' id="header" required>

                                                            <option value="">Select Status</option>

                                                           <option value="active">Active</option>

                                                           <option value="in active">In Active</option>

                                                            </select>

                                                            <span class="error"></span>

                                                        </div>

                                                    </div>

                                                </div> --}}

                                                        </div>

                                                    </div>
                                                    <input type="button" name="next"
                                                        class="next1 action-button old_product1" value="Next" />
                                                    <input style="display:none;" type="submit" name="next"
                                                        class="next action-button newbutton2" value="Submit"
                                                        id="submit_btn" />

                                                    <input type="button" name="next"
                                                        class="next action-button product1" value="Next"
                                                        style="display:none;" />

                                                </fieldset>

                                                <!-- product variant -->

                                                <!-----
                                                    <fieldset style="display:none;">

                                                    <div class="row">

                                                                <div class="col-7">

                                                                    <h2 class="fs-title">Product Description:</h2>

                                                                </div>

                                                                <div class="col-5">

                                                                    <h2 class="steps">Step 2 - 3</h2>

                                                                </div>

                                                    </div>

                                                            <br><br>

                                                    <div id="product_attribute" class="content"

                                                        data-mfield-options='{"section": ".group","btnAdd":"#btnAdd-1","btnRemove":".btnRemove"}'>

                                                        <div class="col-md-12">

                                                            <div class="form-group pull-right">

                                                        </div>

                                                    </div>

                                            <div class=" container-fluid att-box">

                                                <div class="row">

                                                        <div class="col-md-12">

                                                        <div class="row">
                                                        <?php
                                                        $description = '
                                                                                                            <hr>
                                                                                                            <p><b>Pattern :</b> A - Line Kurti&nbsp; + Pant&nbsp; ( Cord Set ) With Side Pocket</p><p><b>Fabric :</b> Jaipur Cotton&nbsp;</p><p><b>Kurti Height :</b> 45 inch</p><p><b>Pant Length : </b>35 inch</p>
                                                                                                            ';
                                                        ?>

                                                                <div class="col-12">

                                                            <div class="form-group ">

                                                               <label for="example-text-input" class="col-sm-6 col-form-label">Description <span style="color:red">*</span></label>

                                                                    <div class="col-sm-10">

                                                                        <textarea class="summernote" name="description" value="{{ $description }}">{{ $description }}</textarea>

                                                                        <span class="error"></span>

                                                                    </div>

                                                                </select>

                                                                <span class="error"></span>

                                                             </div>

                                                             </div>

                                                                <?php
                                                                $usage = '<p><b><span style="font-size: 18px;">Wash Care:</span></b></p><p>Hand Wash Or Machine wash cold with mild detergent, tumble dry low, iron if needed.</p><p><b>Note : </b>The color of the real product may slightly differ from the image displayed&nbsp; on the screen , owning to screen resolution and photography effects.</p>';
                                                                ?>
                                                                <div class="col-12" style="display:none;">

                                                             <div class="form-group ">

                                                               <label for="example-text-input" class="col-sm-6 col-form-label">Usage</label>

                                                                    <div class="col-sm-10">

                                                                        <textarea class="summernote" name="usage" value="{{ $usage }}">{{ $usage }}</textarea>

                                                                        <span class="error"></span>

                                                                    </div>

                                                                </select>

                                                                <span class="error"></span>

                                                             </div>

                                                                </div>

                                                                <div class="col-6" style="display:none;">

                                                             <div class="form-group ">

                                                               <label for="example-text-input" class="col-sm-6 col-form-label">Benefits</label>

                                                                    <div class="col-sm-10">

                                                                        <textarea class="summernote" name="benefits" value="{{ old('benefits') }}"></textarea>

                                                                        <span class="error"></span>

                                                                    </div>

                                                                </select>

                                                                <span class="error"></span>

                                                             </div>

                                                                </div>

                                                                <div class="col-6" style="display:none;">

                                                             <div class="form-group ">

                                                               <label for="example-text-input" class="col-sm-6 col-form-label">Ingrediants</label>

                                                                    <div class="col-sm-10">

                                                                        <textarea class="summernote" name="ingrediants" value="{{ old('ingrediants') }}"></textarea>

                                                                        <span class="error"></span>

                                                                    </div>

                                                                </select>

                                                                <span class="error"></span>

                                                             </div>

                                                                </div>

                                                         </div>

                                                    </div>

                                                </div>

                                                </div>

                                                </div>

                                                         <input type="button" name="next" class="next action-button" value="Next" /> <input type="button" name="previous" class="previous action-button-previous" value="Previous" />

                                                    </fieldset>
                                                    ---->

                                                <fieldset>
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <h2 class="fs-title">Product Variants & Attributes:</h2>
                                                        </div>
                                                        <div class="col-5">
                                                            <h2 class="steps">Step 2 - 3</h2>
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                    <div id="product_attribute" class="content"
                                                        data-mfield-options='{"section": ".group","btnAdd":"#btnAdd-1","btnRemove":".btnRemove"}'>
                                                        <div class="col-md-12">
                                                            <div class="form-group pull-right">
                                                            </div>
                                                        </div>
                                                        <div class=" container-fluid att-box">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group ">

                                                                        <input type="hidden" id="att_value"
                                                                            value="{{ !empty($product_attributename) ? $product_attributename : '' }}">
                                                                        <input type="hidden" id="productpage_type"
                                                                            value="edit">
                                                                        <label for="example-text-input"
                                                                            class="col-form-label">Attribute
                                                                            Type</label>
                                                                        <select
                                                                            class="form-control box-dd form-control-sm attribute_type_select attribute_val required2"
                                                                            id="attr_type_select">
                                                                            <option value="">Attribute Type</option>
                                                                            <?php

                                                                if(!empty($productattributes) && count($productattributes)){
                                                                foreach (\App\Models\Attribute::where('attribute_type','!=','Color')->distinct()->get('attribute_type') as
                                                                $cate) { ?>
                                                                            <option value="{{ $cate->attribute_type }}"
                                                                                {{ $cate->attribute_type == $product_attributename ? 'selected' : '' }}
                                                                                )>{{ $cate->attribute_type }}
                                                                            </option>

                                                                            <?php } }else{
                                                                    foreach (\App\Models\Attribute::where('attribute_type','!=','Color')->distinct()->get('attribute_type') as
                                                                    $cate) { ?>
                                                                            <option value="{{ $cate->attribute_type }}">
                                                                                {{ $cate->attribute_type }}
                                                                            </option>
                                                                            <?php }}

                                                                        ?>
                                                                        </select>
                                                                        <span class="cat_error" style="color:red;"></span>
                                                                        <div class="err_addprod"
                                                                            style="color:red;display:none">Please Add
                                                                            Product</div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group ">
                                                                        <label for="example-text-input"
                                                                            class="col-md-12 col-form-label"></label>
                                                                        <button class="btn btn-primary addproduct"
                                                                            type="button" style="margin-top:.8em;">Add
                                                                            Product</button>
                                                                    </div>
                                                                </div>
                                                                <!----
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <button type="button"
                                                                    class="mt-4 btn btn-sm my-2 btn-danger btnRemove">Remove</button>
                                                            </div>
                                                        </div>
                                                        ---->
                                                                <div class=" col-md-12 product">
                                                                </div>
                                                                <div class="col-md-2 d-none variant1">
                                                                    <div class="form-group">
                                                                        <button class="btn btn-primary addvariant"
                                                                            type="button" style="margin-top:.8em;">Add
                                                                            Variant</button>
                                                                        <div class="err_addvar"
                                                                            style="color:red;display:none">Please Add
                                                                            variant</div>
                                                                    </div>
                                                                </div>
                                                                <span id="selectsize" style="color:red;"></span>
                                                                <div class=" col-md-12 variant">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!--<input type="submit" name="next" class="next2 action-button old_product2" value="Submit" /> -->
                                                    <input type="button" name="next"
                                                        class="next2 action-button old_product2" value="Next" />

                                                    <input style="display:none;" type="button" name="next"
                                                        class="next action-button product2" value="Next" />
                                                    <input style="display:none;" type="submit" name="next"
                                                        class="next action-button newbutton2" value="Submit" /> <input
                                                        type="button" name="previous"
                                                        class="previous action-button-previous" value="Previous" />
                                                </fieldset>

                                                <fieldset id="finish_fieldset">
                                                    <div class="form-card">
                                                        <div class="row">
                                                            <div class="col-7">
                                                                <h2 class="fs-title">Finish:</h2>
                                                            </div>
                                                            <div class="col-5">
                                                                <h2 class="steps">Step 3 - 3</h2>
                                                            </div>
                                                        </div>
                                                        <div class="text-center success-container">
                                                            <div class="success-animation">
                                                                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 52 52">
                                                                    <circle class="checkmark__circle" cx="26"
                                                                        cy="26" r="25" fill="none" />
                                                                    <path class="checkmark__check" fill="none"
                                                                        d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                                                                </svg>
                                                            </div>
                                                            <h2 class="purple-text text-center"><strong>Success!</strong>
                                                            </h2>
                                                            <p class="text-center mt-3">Product details and variants have
                                                                been configured. Click submit to save the product.</p>
                                                            <div class="row justify-content-center mt-4">
                                                                <div class="col-md-6">
                                                                    <button type="submit"
                                                                        class="btn btn-primary btn-lg btn-block action-button"
                                                                        style="width: 100%;">Submit Product</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="button" name="previous"
                                                        class="previous action-button-previous" value="Previous" />
                                                </fieldset>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div> <!-- end col -->

            </div> <!-- end row -->

        </div><!-- container fluid -->

    </div> <!-- Page content Wrapper -->
@endsection

@section('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- select2 JS already loaded globally in script.blade.php -->

    <script type="text/javascript">
        // ============================================================
        // Category / Subcategory Logic
        // ============================================================
        $('.category').attr('placeholder', 'Select Category');
        $('#subcat_id').change(function() {
            var token = $('meta[name="csrf-token"]').attr('content');
            var path = $('meta[name="base_url"]').attr('content') + '/get_childproducts';
            $.ajax({
                url: path,
                type: "GET",
                data: {
                    _token: token,
                    id: $('#subcat_id').val(),
                },
                success: function(response) {
                    $("#childcat_id").empty();
                    var appenddata1 = "";
                    var childcategory = response.categories;
                    if (response.categories != "") {
                        $('#child_cat').css('display', 'block');
                        $("#childcat_id").addClass("required");
                        appenddata1 += "<option value = ''>Select Child Category</option>";
                        $("#childcat_id").empty();
                        for (var i = 0; i < childcategory.length; i++) {
                            appenddata1 += "<option value = '" + childcategory[i].id + "'>" +
                                childcategory[i].title + "</option>";
                        }
                        $("#childcat_id").html(appenddata1);
                    } else {
                        $('#child_cat').css('display', 'none');
                        $("#childcat_id").removeClass("required");
                        appenddata1 += "<option value = ''>Select Child Category</option>";
                        $("#childcat_id").empty();
                        $("#childcat_id").html(appenddata1);
                    }
                }
            });
        });

        // ============================================================
        // Variant Toggle (Yes/No)
        // ============================================================
        $('input[name="is_variant"]').change(function() {
            if ($(this).val() === 'yes') {
                $('.next1').show();
                $('#submit_btn').hide();
                $('.no-variant-fields').hide();
                $('#prod_regular_price').prop('required', false).removeClass('required');
                $('#prod_stock').prop('required', false).removeClass('required');
            } else {
                $('.next1').hide();
                $('#submit_btn').show();
                $('.no-variant-fields').show();
                $('#prod_regular_price').prop('required', true).addClass('required');
                $('#prod_stock').prop('required', true).addClass('required');
            }
        });

        // ============================================================
        // Validation Logic
        // ============================================================
        $(document).ready(function() {
            // Parsley is already initialized globally in script.blade.php
            // Do NOT initialize it again here to avoid infinite change-event loop

            function selectvalidation() {
                let flag = true;
                $('.form-control.required:visible').each(function() {
                    if ($(this).val() === '') {
                        flag = false;
                        if ($(this).closest('.input-group').length > 0) {
                            $(this).closest('.input-group').next('.error').text('This field is required.')
                                .show();
                        } else {
                            $(this).next('.error').text('This field is required.').show();
                        }
                        $(this).addClass('is-invalid');
                    } else {
                        if ($(this).closest('.input-group').length > 0) {
                            $(this).closest('.input-group').next('.error').text('').hide();
                        } else {
                            $(this).next('.error').text('').hide();
                        }
                        $(this).removeClass('is-invalid');
                    }
                });

                if (flag) {
                    $('.next1').hide();
                    $('.product1').show();
                    $('.product1').click();
                }
            }

            function selectvalidation1() {
                let flag = true;

                if ($("#attr_type_select").val() == '') {
                    flag = false;
                    $(".cat_error").html("This field is required.");
                } else {
                    $(".cat_error").html("");
                }

                if ($('input[name="is_variant"]:checked').val() === 'yes' && $('.variant .card').length == 0) {
                    flag = false;
                    $("#selectsize").html("Please add at least one variant.");
                } else {
                    $("#selectsize").html("");
                }

                $('.required2:visible').each(function() {
                    if ($(this).val() === null || $(this).val() === "" || (Array.isArray($(this).val()) &&
                            $(this).val().length === 0)) {
                        flag = false;
                        $(this).next('.err_emptyval').show();
                    } else {
                        $(this).next('.err_emptyval').hide();
                    }
                });

                if (flag) {
                    $('.product2').click();
                } else {
                    swal("Attention",
                        'Please check the required fields or add variants before proceeding to Finish.',
                        "warning");
                }
            }

            $('.next1').off('click').on('click', selectvalidation);
            $('.next2').off('click').on('click', selectvalidation1);

            // ============================================================
            // Wizard Navigation Script
            // ============================================================
            $(document).on('click', '.action-button', function() {
                var current_fs = $(this).closest('fieldset');
                var next_fs = current_fs.next();
                if (next_fs.length === 0) return;

                // Add active class to progress bar
                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
                
                next_fs.show();
                current_fs.animate({opacity: 0}, {
                    step: function(now) {
                        var opacity = 1 - now;
                        current_fs.css({'display': 'none', 'position': 'relative'});
                        next_fs.css({'opacity': opacity});
                    },
                    duration: 500
                });
            });

            $(document).on('click', '.action-button-previous', function() {
                var current_fs = $(this).closest('fieldset');
                var previous_fs = current_fs.prev();
                if (previous_fs.length === 0) return;

                $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
                previous_fs.show();
                current_fs.animate({opacity: 0}, {
                    step: function(now) {
                        var opacity = 1 - now;
                        current_fs.css({'display': 'none', 'position': 'relative'});
                        previous_fs.css({'opacity': opacity});
                    },
                    duration: 500
                });
            });
        });

        // ============================================================
        // Product Attribute Logic (Injected)
        // ============================================================
        var attr = [];
        var variant = [];
        var i = 1;
        var lfm_route = "{{ url('laravel-filemanager') }}";

        $('.attribute_type_select').change(function() {
            var token = $('meta[name="csrf-token"]').attr('content');
            var path = $('meta[name="base_url"]').attr('content') + '/get_attribute';
            $.ajax({
                url: path,
                type: "GET",
                data: {
                    _token: token,
                    id: $(this).val(),
                },
                success: function(response) {
                    $(".product").empty();
                    var appenddata1 = "";
                    var productattribute = response.productattribute;
                    if (response.productattribute != "") {
                        appenddata1 += '<div class="row group"><div class="col-md-3"><div class="form-group"><label for="example-text-input" class="col-form-label">Attribute Type :</label><input type="text" class="form-control box-dd form-control-sm" value="' + productattribute.attribute_type + '" readonly name="attribute_name[]" id="chil_cat_id2"></div></div>';
                        appenddata1 += '<div class="col-md-4"><div class="form-group"><label for="example-text-input" class="col-form-label">Attribute Value :</label><select class="form-control box-dd form-control-sm select2 attribute_val required2" multiple name="attribute_value_' + productattribute.attribute_type + '[]" id="chil_cat_id3">';
                        var attribute_value = JSON.parse(productattribute.value);
                        for (var j = 0; j < attribute_value.length; j++) {
                            appenddata1 += '<option value="' + attribute_value[j] + '">' + attribute_value[j] + '</option>';
                        }
                        appenddata1 += '</select><span class="err_emptyval" style="color:red;display:none;">This field is required.</span></div></div>';
                        appenddata1 += '<div class="col-md-2 mt-4"><div class="form-group"><button type="button" class="btn btn-sm my-2 btn-danger btnRemove" id="' + i + '|' + productattribute.attribute_type + '" onclick="removeproduct(this)">Remove</button></div></div></div>';
                        $(".product").append(appenddata1);
                        $('.select2').select2({ placeholder: "Select Value" });
                        $('.variant1').removeClass('d-none');
                    }
                }
            });
        });

        $('.addvariant').click(function() {
            if ($('#chil_cat_id2').val() != undefined && $('#chil_cat_id3').val() != "") {
                for (let k1 = 0; k1 < ($('#chil_cat_id2').val().length); k1++) {
                    for (let k2 = 0; k2 < ($('#chil_cat_id3').val().length); k2++) {
                        let rand = 1 + Math.floor(Math.random() * 10000);
                        let vid = rand;
                        if (variant.indexOf(vid) == -1) {
                            variant.push(vid);
                            var tempsku = Math.floor(100000 + Math.random() * 900000);
                            let details = '<div class="card border1" id="vchild' + vid + '"><div class="row"><div class="col-md-3"><div class="form-group"><label class="col-sm-12 col-form-label">#' + vid + ' ' + $('#chil_cat_id3').val()[k1] + '</label></div></div>';
                            details += '<div class="col-md-9"><button type="button" class="btn btn-sm btn-danger pull-right mr-1" onclick="removevariant(this)" id="' + vid + '"><i class="fa fa-trash-o"></i></button></div>';
                            details += '<div class="col-md-12" id="vo' + vid + '"><div class="row">';
                            details += '<div class="col-md-3 ml-3"><div class="form-group"><label class="col-form-label">SKU:</label><input type="text" class="form-control" name="sku[]" required placeholder="SKU" value="' + tempsku + '"><input type="hidden" name="variant_id[]" value="'+vid+'"><input type="hidden" name="attribute_value[]" value="'+$('#chil_cat_id3').val()[k1]+'"></div></div>';
                            
                            // Color Mapping Field
                            details += '<div class="col-md-3 ml-3"><div class="form-group"><label class="col-form-label">Colors:</label>';
                            details += buildColorSection(vid, "");
                            details += '</div></div>';

                            details += '<div class="col-md-3"><label class="col-form-label">Images <small class="text-muted">(Upload 4 images; 3rd is auto-color)</small></label><div class="input-group"><span class="input-group-btn"><a id="lfm' + vid + '" data-input="thumbnail' + vid + '" data-preview="holder' + vid + '" data-multiple="true" class="btn btn-primary lfm-v"><i class="fa fa-picture-o"></i> Choose</a></span><input id="thumbnail' + vid + '" required class="form-control" type="text" name="photo[]" value=""></div><div id="holder' + vid + '" class="mt-2 d-flex flex-wrap" style="max-height:100px;"></div><input type="hidden" id="color_images_'+vid+'" name="color_images[]" value=""></div>';
                            details += '<div class="col-md-3 ml-3"><div class="form-group"><label class="col-form-label">Regular Price:</label><input type="text" class="form-control" name="regular_price[]" required placeholder="Regular Price"></div></div>';
                            details += '<div class="col-md-3 ml-3"><div class="form-group"><label class="col-form-label">Stock:</label><input type="text" class="form-control" name="stock[]" placeholder="Stock"></div></div>';
                            details += '</div></div></div></div>';
                            $('.variant').append(details);
                            $(`#lfm${vid}`).filemanager('image', {prefix: lfm_route, multiple: true});
                        }
                    }
                }
            }
        });

        function removevariant(d) {
            let id = d.id;
            variant.splice(variant.indexOf(id), 1);
            $('#vchild' + id).remove();
        }


        // Update thumbnails when variant images change
        $(document).on('change', 'input[name="photo[]"], #thumbnail', function() {
            var isMain = $(this).attr('id') === 'thumbnail';
            var vid = isMain ? '' : $(this).attr('id').replace('thumbnail', '');
            var val = $(this).val();
            var holder = $('#holder' + vid);
            holder.empty();
            if (val) {
                var imgList = val.split(',').map(function(p) { return p.trim(); }).filter(Boolean);
                imgList.forEach(function(imgPath, idx) {
                    var borderColor = '#eee';
                    var label = '';
                    if (vid && idx === 2) {
                        borderColor = '#E91E63';
                        label = '<div style="font-size:10px;color:#E91E63;text-align:center;margin-bottom:2px;">🎨 Color Image</div>';
                    }
                    holder.append(`${label}<img src="${adminImageUrl(imgPath)}" data-index="${idx}" data-vid="${vid}" style="max-height: 80px; margin: 0 10px 10px 0; border-radius: 8px; border: 2px solid ${borderColor}; padding: 4px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">`);
                });
            }
        });

        function adminImageUrl(url) {
            if (!url) return '';
            if (url.startsWith('http')) return url;
            return "{{ asset('/') }}" + url.replace(/^\/+/, '');
        }

        // When a color hex value changes in a variant, update the color_images mapping
        $(document).on('change input', '.color-hex-input', function() {
            var vid = $(this).data('vid');
            if (!vid) return;
            updateColorImagesField(vid);
        });

        // When a color image picker button is clicked
        $(document).on('click', '.btn-pick-color-images', function() {
            var btn = $(this);
            var vid = btn.data('vid');
            var entryId = btn.data('entryId');
            var colorHex = btn.closest('.color-entry').find('.color-hex-input').val();
            var previewSpan = btn.closest('.color-entry').find('.color-img-preview');
            
            var lfm_route = (typeof route_prefix !== 'undefined') ? route_prefix : ($('meta[name="route_prefix"]').attr('content') || '/laravel-filemanager');
            
            window.open(lfm_route + '?type=image&multiple=true', 'FileManager', 'width=900,height=600');
            
            window.SetUrl = function (items) {
                if (!Array.isArray(items)) items = [items];
                var file_paths = items.map(function (item) {
                    return item.url.replace(window.location.origin, '');
                }).join(',');

                $('#color_images_' + vid).val(function(i, oldVal) {
                    var mapping = parseColorImages(oldVal);
                    mapping[colorHex] = file_paths;
                    return serializeColorImages(mapping);
                });

                var previewHtml = '';
                items.forEach(function(item) {
                     previewHtml += `<img src="${adminImageUrl(item.url)}" style="max-height:30px; border-radius:3px; margin-right:4px; margin-bottom:4px; border: 1px solid #ddd;">`;
                });
                previewSpan.html(previewHtml).show();
            };
        });

        // Deprecated single-image picker
        $(document).on('click', '.btn-pick-color-image', function() {
            var vid = $(this).data('vid');
            var entryId = $(this).data('entry');
            var colorHex = $(this).closest('.color-entry').find('.color-hex-input').val();

            // Store which color entry we are picking for
            window._pickingColorImageFor = { vid: vid, entryId: entryId };

            // Get current 3rd image from photo input
            var photoVal = $('#thumbnail' + vid).val();
            if (photoVal) {
                var imgs = photoVal.split(',').map(function(p){ return p.trim(); }).filter(Boolean);
                var img3 = imgs[2] || imgs[0] || '';
                if (img3) {
                    // Store the 3rd image as this color's image
                    $('#color_images_' + vid).val(function(i, oldVal) {
                        var mapping = parseColorImages(oldVal);
                        mapping[colorHex] = img3;
                        return serializeColorImages(mapping);
                    });
                    $(this).closest('.color-entry').find('.color-img-preview').html(
                        `<img src="${adminImageUrl(img3)}" style="max-height:30px;border-radius:4px;">`
                    ).show();
                }
            }
        });

        function parseColorImages(str) {
            var map = {};
            if (!str) return map;
            str.split(';').forEach(function(pair) {
                var parts = pair.split('=');
                if (parts.length === 2 && parts[0] && parts[1]) {
                    map[parts[0].trim()] = parts[1].trim();
                }
            });
            return map;
        }

        function serializeColorImages(map) {
            return Object.keys(map).map(function(k) { return k + '=' + map[k]; }).join(';');
        }

        function updateColorImagesField(vid) {
            // Auto-assign 3rd image to each color if not already set
            var photoVal = $('#thumbnail' + vid).val();
            if (!photoVal) return;
            var imgs = photoVal.split(',').map(function(p){ return p.trim(); }).filter(Boolean);
            var img3 = imgs[2] || '';
            if (!img3) return;

            var mapping = parseColorImages($('#color_images_' + vid).val());
            $('#color_container_' + vid + ' .color-hex-input').each(function() {
                var hex = $(this).val();
                if (hex && !mapping[hex]) {
                    mapping[hex] = img3;
                }
            });
            $('#color_images_' + vid).val(serializeColorImages(mapping));
        }

        function addColorEntry(containerId, fieldName, vid) {
            let entryId = Math.floor(Math.random() * 1000000);
            let html = `
                <div class="color-entry d-flex flex-column mb-3" id="color_entry_${entryId}" style="background: #fdfdfd; padding: 10px; border-radius: 8px; border: 1px solid #eee;">
                    <div class="d-flex align-items-center mb-2">
                        <div class="input-group" style="flex: 1;">
                            <input type="color" class="form-control" style="width: 38px; padding: 2px; height: 36px; flex: 0 0 38px; border-radius: 4px 0 0 4px;" 
                                oninput="this.nextElementSibling.value = this.value; $(this.nextElementSibling).trigger('change')" 
                                value="#000000">
                            <input type="text" class="form-control color-hex-input" name="${fieldName}" value="" 
                                data-vid="${vid}" placeholder="#0000FF" oninput="this.previousElementSibling.value = this.value" style="max-width:90px;">
                            <div class="input-group-append" style="display:flex;align-items:center;gap:3px;padding:0 4px;">
                                <button type="button" class="btn btn-sm btn-outline-info btn-pick-color-images" title="Choose multiple images for this color" data-vid="${vid}" data-entry="${entryId}" style="padding:2px 8px;font-size:12px;">
                                    <i class="fa fa-picture-o"></i> Choose Images
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="$('#color_entry_${entryId}').remove()" style="padding:2px 6px;">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="color-img-preview-container d-flex flex-wrap gap-1" style="min-height: 20px;">
                        <span class="color-img-preview" style="display:none;"></span>
                    </div>
                </div>`;
            $(`#${containerId}`).append(html);
        }

        function buildColorSection(vid, colors = "", colorImages = "") {
            let containerId = `color_container_${vid}`;
            let fieldName = `colors_${vid}[]`;
            let html = `<div id="${containerId}" class="color-multi-container">`;
            let mapping = typeof parseColorImages === 'function' ? parseColorImages(colorImages) : {};
            
            if (colors) {
                let colorList = colors.split(',');
                colorList.forEach(color => {
                    let c = color.trim();
                    if (!c) return;
                    let hex = c.startsWith('#') ? c : '#' + c;
                    let entryId = Math.floor(Math.random() * 1000000);
                    let assignedImgs = mapping[hex] || mapping[c] || '';
                    let previewHtml = '';
                    if (assignedImgs) {
                        assignedImgs.split(',').forEach(img => {
                            if (img.trim()) {
                                previewHtml += `<img src="${adminImageUrl(img.trim())}" style="max-height:30px; border-radius:3px; margin-right:4px; margin-bottom:4px; border: 1px solid #ddd;">`;
                            }
                        });
                    }
                    html += `
                        <div class="color-entry d-flex flex-column mb-3" id="color_entry_${entryId}" style="background: #fdfdfd; padding: 10px; border-radius: 8px; border: 1px solid #eee;">
                            <div class="d-flex align-items-center mb-2">
                                <div class="input-group" style="flex: 1;">
                                    <input type="color" class="form-control" style="width: 38px; padding: 2px; height: 36px; flex: 0 0 38px; border-radius: 4px 0 0 4px;" 
                                        oninput="this.nextElementSibling.value = this.value; $(this.nextElementSibling).trigger('change')" 
                                        value="${hex}">
                                    <input type="text" class="form-control color-hex-input" name="${fieldName}" value="${c}" 
                                        data-vid="${vid}" placeholder="#0000FF" oninput="this.previousElementSibling.value = this.value" style="max-width:90px;">
                                    <div class="input-group-append" style="display:flex;align-items:center;gap:3px;padding:0 4px;">
                                        <button type="button" class="btn btn-sm btn-outline-info btn-pick-color-images" title="Choose multiple images for this color" data-vid="${vid}" data-entry="${entryId}" style="padding:2px 8px;font-size:12px;">
                                            <i class="fa fa-picture-o"></i> Choose Images
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="$('#color_entry_${entryId}').remove()" style="padding:2px 6px;">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="color-img-preview-container d-flex flex-wrap gap-1">
                                <span class="color-img-preview" style="${assignedImgs ? '' : 'display:none;'}">${previewHtml}</span>
                            </div>
                        </div>`;
                });
            }
            
            html += `</div>
                <button type="button" class="btn btn-sm btn-outline-success mt-1" onclick="addColorEntry('${containerId}', '${fieldName}', '${vid}')">
                    <i class="fa fa-plus"></i> Add Color
                </button>
                <div class="mt-2" style="font-size:11px;color:#cf2e6d;font-weight:600;"><i class="fa fa-info-circle"></i> Tip: You can now upload multiple images for each color! These will replace the main variant gallery when this color is selected.</div>`;
            return html;
        }
    </script>
@endsection

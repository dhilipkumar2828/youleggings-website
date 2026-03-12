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
            color: var(--primary-color, #E91E63);
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
            background: var(--primary-color, #E91E63);
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
            background: var(--primary-gradient, #E91E63);
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 50px;
            cursor: pointer;
            padding: 12px 5px;
            margin: 10px 5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(233, 30, 99, 0.3);
        }

        .action-button:hover,
        .action-button:focus {
            box-shadow: 0 6px 20px rgba(233, 30, 99, 0.4) !important;
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

        .select2-container--default .select2-selection--multiple,
        .select2-container--default .select2-selection--single {
            border: 1px solid #e0e0e0 !important;
            border-radius: 10px !important;
            min-height: 45px !important;
            padding: 5px 10px !important;
            background: #f9f9f9 !important;
            transition: all 0.3s ease !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 35px !important;
            color: #495057 !important;
            padding-left: 0 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 43px !important;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple,
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #F8BBD0 !important;
            background: #fff !important;
            box-shadow: 0 0 0 4px rgba(233, 30, 99, 0.1) !important;
        }

        .note-editor.note-frame.card {
            width: 100% !important;
            border-radius: 12px !important;
            overflow: hidden !important;
        }

        /* Navigation Breadcrumb */
        .page-title-box {
            padding: 20px 0;
        }

        .breadcrumb-item a {
            color: #E91E63;
        }
    </style>

    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="float-right page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Product</a></li>
                            <li class="breadcrumb-item active">{{ $clone ? 'Clone' : 'Edit' }} Product</li>
                        </ol>
                    </div>
                    <h5 class="page-title">Catalogs</h5>
                </div>
            </div>

            <div class="card m-b-30 card-body">
                <h4 class="card-title font-20 mt-0">{{ $clone ? 'Clone Product' : 'Edit Product' }}</h4>
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('product.index') }}" id="add-btn" style="color: #ffffff;"><i
                            class="fa fa-angle-left" aria-hidden="true"></i> Back</a>
                    <div class="btn-group">
                        @if ($prevProduct > 0)
                            <a href="/product/{{ $prevProduct }}/edit"
                                class="btn btn-outline-primary btn-sm rounded-circle mr-1" title="Previous Product">
                                <i class="fa fa-angle-left"></i>
                            </a>
                        @endif
                        <span class="px-2 align-self-center text-muted font-weight-bold">ID: #{{ $product_id }}</span>
                        @if ($nextProduct > 0)
                            <a href="/product/{{ $nextProduct }}/edit"
                                class="btn btn-outline-primary btn-sm rounded-circle ml-1" title="Next Product">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card m-b-30">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-12 text-center p-0 mt-3 mb-2">
                                <div class="card px-0 pt-4 pb-0 mt-3 mb-3 border-0">
                                    <p>Fill all form field to go to next step</p>

                                    @if ($clone)
                                        <form id="msform" action="{{ route('product.store') }}" method="POST">
                                            <input id="screen_page" type="hidden" value="1">
                                        @else
                                            <form id="msform"
                                                action="{{ route('product.updateattribute', $Product->id) }}"
                                                method="POST">
                                                <input id="screen_page" type="hidden" value="0">
                                    @endif

                                    @csrf
                                    <!-- progressbar -->
                                    <ul id="progressbar">
                                        <li class="active" id="product"><strong>Product</strong></li>
                                        <li id="product_variant"><strong>Product Variant</strong></li>
                                        <li id="confirm"><strong>Finish</strong></li>
                                    </ul>

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
                                                        <label for="name" class="col-sm-4 col-form-label">Name <span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control required" autofocus="true"
                                                                type="text" placeholder="Enter Name" id="name"
                                                                name="name" value="{{ $Product->name }}" required>
                                                            <span class="error"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6" style="display:none;">
                                                    <div class="form-group row">
                                                        <label for="brand_name" class="col-sm-4 col-form-label">Brand Name
                                                            <span style="color:red">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control required" type="text"
                                                                placeholder="Enter Brand Name" id="brand_name"
                                                                name="brand_name" value="{{ $Product->brand_name }}">
                                                            <span class="error"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="thumbnail" class="col-sm-4 col-form-label">Image <span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-8">
                                                            <div class="input-group d-flex align-items-center"
                                                                style="border: 1px dashed #ced4da; border-radius: 8px; padding: 0 5px; background: #fff; height: 45px;">
                                                                <span class="input-group-btn" style="margin-right:0;">
                                                                    <a id="lfm" data-input="thumbnail"
                                                                        data-preview="holder"
                                                                        class="btn btn-primary ripple"
                                                                        style="border-radius: 6px; padding: 6px 12px;">
                                                                        <i class="fa fa-picture-o"></i> Choose
                                                                    </a>
                                                                </span>
                                                                @php
                                                                    $photos = explode(
                                                                        ',',
                                                                        $product_variant->photo ??
                                                                            ($Product->photo ?? ''),
                                                                    );
                                                                    $firstImage = trim($photos[0]);
                                                                @endphp
                                                                <input id="thumbnail" class="form-control required"
                                                                    type="text" value="{{ $firstImage }}"
                                                                    name="product_photo"
                                                                    style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;"
                                                                    placeholder="Select an image..." required>
                                                            </div>
                                                            <span class="error"></span>
                                                            <div id="holder" class="mt-2">
                                                                @if ($firstImage)
                                                                    <img src="{{ image_url($firstImage) }}"
                                                                        class="thumb_image_temp" alt="product image"
                                                                        style="max-height: 90px; max-width:120px">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="youtube_link" class="col-sm-4 col-form-label">Youtube
                                                            link</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="text"
                                                                placeholder="Enter Youtube Link" id="youtube_link"
                                                                name="youtube_link"
                                                                value="{{ old('youtube_link', $Product->youtube_link) }}">
                                                            <span class="error"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="cat_id" class="col-sm-4 col-form-label">Category
                                                            <span style="color:red">*</span></label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control required category" name='category'
                                                                id="cat_id" required>
                                                                <option value="">Select Category</option>
                                                                @foreach ($category as $cate)
                                                                    <option value="{{ $cate->id }}"
                                                                        {{ $Product->category == $cate->id ? 'selected' : '' }}>
                                                                        {{ $cate->title }}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="error"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6" id="sub_cat"
                                                    style="{{ $Product->subcategory_id == 0 ? 'display:none;' : '' }}">
                                                    <div class="form-group row">
                                                        <label for="subcat_id" class="col-sm-4 col-form-label">Sub
                                                            Category <span style="color:red">*</span></label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" name='subcategory_id'
                                                                id="subcat_id">
                                                                <option value="">Select Subcategory</option>
                                                                @foreach ($sub_category as $cate)
                                                                    <option value="{{ $cate->id }}"
                                                                        {{ $Product->subcategory_id == $cate->id ? 'selected' : '' }}>
                                                                        {{ $cate->title }}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="error"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6" id="child_cat"
                                                    style="{{ $Product->childcategory_id == 0 ? 'display:none;' : '' }}">
                                                    <div class="form-group row">
                                                        <label for="childcat_id" class="col-sm-4 col-form-label">Child
                                                            Category</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" name='childcategory_id'
                                                                id="childcat_id">
                                                                <option value="">Select Child Category</option>
                                                                @foreach ($child_category as $cate)
                                                                    <option value="{{ $cate->id }}"
                                                                        {{ $Product->childcategory_id == $cate->id ? 'selected' : '' }}>
                                                                        {{ $cate->title }}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="error"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="discount_type"
                                                            class="col-sm-4 col-form-label">Discount Type</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" name='discount_type'
                                                                id="discount_type">
                                                                <option value="">--Select Discount Type--</option>
                                                                <option value="fixed"
                                                                    {{ $Product->discount_type == 'fixed' ? 'selected' : '' }}>
                                                                    Fixed</option>
                                                                <option value="percentage"
                                                                    {{ $Product->discount_type == 'percentage' ? 'selected' : '' }}>
                                                                    Percentage</option>
                                                            </select>
                                                            <span class="error"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="discount"
                                                            class="col-sm-4 col-form-label">Discount</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="number"
                                                                placeholder="Discount" id="discount" name="discount"
                                                                value="{{ $Product->discount }}">
                                                            <span class="error"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="tax_id" class="col-sm-4 col-form-label">Tax
                                                            Id</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" name='tax_id' id="tax_id">
                                                                <option value="">Select Tax</option>
                                                                @foreach ($tax as $t)
                                                                    <option value="{{ $t->id }}"
                                                                        {{ $Product->tax_id == $t->id ? 'selected' : '' }}>
                                                                        {{ $t->tax_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="error"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="delivery_days" class="col-sm-4 col-form-label">No of
                                                            Days Delivery <span style="color:red">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control required" min="0"
                                                                max="15" type="number"
                                                                placeholder="No of Days Delivery" id="delivery_days"
                                                                name="delivery_days"
                                                                value="{{ $Product->delivery_days }}" required>
                                                            <span class="error"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="hsn_code" class="col-sm-4 col-form-label">HSN Code
                                                            <span style="color:red">*</span></label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control required" type="text"
                                                                placeholder="HSN Code" id="hsn_code" name="hsn_code"
                                                                value="{{ $Product->hsn_code }}" required>
                                                            <span class="error"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label for="tag" class="col-sm-4 col-form-label">Tag <span
                                                                style="color:red">*</span></label>
                                                        <div class="col-sm-8">
                                                            <select id="tag" name="tag" class="form-control">
                                                                <option value="0">-- 0 --</option>
                                                                <option value="LC" style="display:none;"
                                                                    {{ $Product->tag == 'LC' ? 'selected' : '' }}>LC
                                                                </option>
                                                                <option value="NA"
                                                                    {{ $Product->tag == 'NA' ? 'selected' : '' }}>NA
                                                                </option>
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
                                                                <div style="display: flex; align-items: center;">
                                                                    <input type="radio" name="is_variant"
                                                                        id="variant_yes" value="yes"
                                                                        {{ count($productattributes) > 0 ? 'checked' : '' }}
                                                                        style="width: auto; height: auto; margin-right: 8px;">
                                                                    <label for="variant_yes"
                                                                        style="margin-bottom: 0;">Yes</label>
                                                                </div>
                                                                <div style="display: flex; align-items: center;">
                                                                    <input type="radio" name="is_variant"
                                                                        id="variant_no" value="no"
                                                                        {{ count($productattributes) == 0 ? 'checked' : '' }}
                                                                        style="width: auto; height: auto; margin-right: 8px;">
                                                                    <label for="variant_no"
                                                                        style="margin-bottom: 0;">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 no-variant-fields"
                                                    style="{{ count($productattributes) > 0 ? 'display:none;' : '' }}">
                                                    <div class="form-group row">
                                                        <label for="prod_regular_price"
                                                            class="col-sm-4 col-form-label">Regular Price(MRP)</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" step="any" type="text"
                                                                placeholder="Enter Price" id="prod_regular_price"
                                                                name="prod_regular_price"
                                                                value="{{ $Product->regular_price }}">
                                                            <span class="error"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 no-variant-fields"
                                                    style="{{ count($productattributes) > 0 ? 'display:none;' : '' }}">
                                                    <div class="form-group row">
                                                        <label for="prod_stock"
                                                            class="col-sm-4 col-form-label">Stock</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="number"
                                                                placeholder="Enter Stock" id="prod_stock"
                                                                name="prod_stock" value="{{ $Product->stock }}">
                                                            <span class="error"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group ">
                                                        <label for="description"
                                                            class="col-sm-6 col-form-label">Description</label>
                                                        <div>
                                                            <textarea class="summernote" name="description" id="description">{!! html_entity_decode($Product->description) !!}</textarea>
                                                            <span class="error"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12" style="display:none;">
                                                    <div class="form-group ">
                                                        <label for="usage"
                                                            class="col-sm-6 col-form-label">Usage</label>
                                                        <div class="col-sm-10">
                                                            <textarea class="summernote" name="usage" id="usage">{!! html_entity_decode($Product->usage) !!}</textarea>
                                                            <span class="error"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="button" name="next" class="next1 action-button old_product1"
                                            value="Next" />
                                        <input style="display:none;" type="submit" name="next"
                                            class="next action-button newbutton2" value="Update" id="submit_btn" />
                                        <input type="button" name="next" class="next action-button product1"
                                            value="Next" style="display:none;" />
                                    </fieldset>

                                    <!-- product variant -->
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
                                        <div id="product_attribute_edit" class="content">
                                            <div class="container-fluid att-box">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <input type="hidden" id="productpage_type" value="edit">
                                                            <label for="attr_type_select" class="col-form-label">Attribute
                                                                Type</label>
                                                            <select
                                                                class="form-control box-dd form-control-sm attribute_type_select attribute_val required2"
                                                                id="attr_type_select" name="attr_type_select">
                                                                <option value="">Attribute Type</option>
                                                                @foreach (\App\Models\Attribute::distinct()->get('attribute_type') as $attr)
                                                                    <option value="{{ $attr->attribute_type }}">
                                                                        {{ $attr->attribute_type }}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="cat_error" style="color:red;"></span>
                                                            <div class="err_addprod" style="color:red;display:none">Please
                                                                Add Product</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="col-md-12 col-form-label">&nbsp;</label>
                                                            <button class="btn btn-primary btn-add-attribute"
                                                                type="button" style="margin-top: 5px;">Add
                                                                Attribute</button>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 product">
                                                        <!-- Selected Attributes will be appended here -->
                                                    </div>

                                                    <div class="col-md-12 text-right variant1 d-none mt-3">
                                                        <div class="form-group">
                                                            <button class="btn btn-primary btn-generate-variants"
                                                                type="button">Generate Variants</button>
                                                            <div class="err_addvar" style="color:red;display:none">Please
                                                                Add variant</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 mt-3">
                                                        <span id="selectsize" style="color:red;"></span>
                                                        <div class="variant">
                                                            <!-- Generated Variants will be appended here -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="button" name="next" class="next2 action-button" value="Next"
                                            id="next_btn2" />
                                        <input type="button" name="previous" class="previous action-button-previous"
                                            value="Previous" />
                                    </fieldset>

                                    <!-- finish -->
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
                                                        <circle class="checkmark__circle" cx="26" cy="26"
                                                            r="25" fill="none" />
                                                        <path class="checkmark__check" fill="none"
                                                            d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                                                    </svg>
                                                </div>
                                                <h2 class="purple-text text-center"><strong>Success!</strong></h2>
                                                <p class="text-center mt-3">Product details and variants have been updated.
                                                    Click update to save changes.</p>
                                                <div class="row justify-content-center mt-4">
                                                    <div class="col-md-6">
                                                        <button type="submit"
                                                            class="btn btn-primary btn-lg btn-block action-button"
                                                            style="width: 100%;">Update Product</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="button" name="previous" class="previous action-button-previous"
                                            value="Previous" />
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
    <!-- Select2 CSS is loaded via CDN; select2 JS is typically global. If not, include it here. -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript">
        // ============================================================
        // Image URL Helper (mirrors PHP image_url() helper)
        // Strips hardcoded host:port from DB-stored paths
        // ============================================================
        function adminImageUrl(path) {
            if (!path) return '';
            // Strip http://127.0.0.1:PORT/public/ or http://localhost:PORT/public/
            path = path.replace(/^https?:\/\/(127\.0\.0\.1|localhost)(:\d+)?\/public\//, '');
            // Strip other known prefixes
            path = path.replace(/^public\/uploads\//, '')
                       .replace(/^public\/storage\//, '')
                       .replace(/^public\//, '')
                       .replace(/^storage\//, '')
                       .replace(/^uploads\//, '');
            path = path.replace(/^\/+/, '');
            return window.location.origin + '/uploads/' + path;
        }

        // ============================================================
        // Global Setup & Init
        // ============================================================
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('.category, #subcat_id, #childcat_id, #tax_id, #tag').select2({
                placeholder: "Select Value",
                width: '100%'
            });

            // Initial Variant Toggle State
            if ($('input[name="is_variant"]:checked').val() === 'yes') {
                $('.next1').show();
                $('#submit_btn').hide();
                $('.no-variant-fields').hide();
            } else {
                $('.next1').hide();
                $('#submit_btn').show();
                $('.no-variant-fields').show();
            }

            // Load existing variants if any
            product_attribute('{{ $Product->id }}');
        });

        // ============================================================
        // Category / Subcategory Logic
        // ============================================================
        $('#cat_id').change(function() {
            var cat_id = $(this).val();
            if (cat_id != '') {
                var token = $('meta[name="csrf-token"]').attr('content');
                var path = $('meta[name="base_url"]').attr('content') + '/get_subproducts';
                $.ajax({
                    url: path,
                    type: "POST",
                    data: {
                        _token: token,
                        id: cat_id
                    },
                    success: function(response) {
                        if (response.data.length > 0) {
                            $('#sub_cat').show();
                            $("#subcat_id").empty().append(
                                "<option value=''>Select Subcategory</option>");
                            $.each(response.data, function(key, value) {
                                $("#subcat_id").append("<option value='" + value.id + "'>" +
                                    value.title + "</option>");
                            });
                            $('#subcat_id').select2({
                                placeholder: "Select Subcategory",
                                width: '100%'
                            });
                        } else {
                            $('#sub_cat').hide();
                            $("#subcat_id").empty().append(
                                "<option value=''>Select Subcategory</option>");
                            $('#subcat_id').select2({
                                placeholder: "Select Subcategory",
                                width: '100%'
                            });
                        }
                    }
                });
            }
        });

        $('#subcat_id').change(function() {
            var subcat_id = $(this).val();
            if (subcat_id != '') {
                var token = $('meta[name="csrf-token"]').attr('content');
                var path = $('meta[name="base_url"]').attr('content') + '/get_childproducts';
                $.ajax({
                    url: path,
                    type: "GET",
                    data: {
                        _token: token,
                        id: subcat_id
                    },
                    success: function(response) {
                        if (response.categories.length > 0) {
                            $('#child_cat').show();
                            $("#childcat_id").empty().append(
                                "<option value=''>Select Child Category</option>");
                            $.each(response.categories, function(key, value) {
                                $("#childcat_id").append("<option value='" + value.id + "'>" +
                                    value.title + "</option>");
                            });
                            $('#childcat_id').select2({
                                placeholder: "Select Child Category",
                                width: '100%'
                            });
                        } else {
                            $('#child_cat').hide();
                            $("#childcat_id").empty().append(
                                "<option value=''>Select Child Category</option>");
                            $('#childcat_id').select2({
                                placeholder: "Select Child Category",
                                width: '100%'
                            });
                        }
                    }
                });
            }
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
        // Attribute & Variant Generation Logic
        // ============================================================
        var i = 2;
        var data = [];
        var attr = [];
        var variant = [];
        var variant_combos = []; // Track combinations like "Blue,S" to prevent duplicates

        function variants(raw_cat_id, option = "", attrid = "") {
            // Normalize input for comparison
            let normalizedInput = String(raw_cat_id).trim().toLowerCase();

            // Check if we already have this attribute (case-insensitive check against 'attr' array)
            let alreadyExists = false;
            for (let j = 0; j < attr.length; j++) {
                if (String(attr[j]).trim().toLowerCase() === normalizedInput) {
                    alreadyExists = true;
                    break;
                }
            }

            $('.variant1').removeClass('d-none');

            if (!alreadyExists) {
                attr.push(raw_cat_id);

                $.ajax({
                    url: "{{ route('product.attribute') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: raw_cat_id
                    },
                    success: function(response) {

                        // Determine the correct display value and build options
                        let optionsHtml = '<option value="">Select Type</option>';
                        let matchedValue = null;

                        $('#attr_type_select option').each(function() {
                            let optVal = $(this).val();
                            let optText = $(this).text();

                            if (optVal) {
                                let isSelected = (String(optVal).trim().toLowerCase() ===
                                    normalizedInput);
                                if (isSelected) {
                                    matchedValue = optVal;
                                }
                                optionsHtml += `<option value="${optVal}">${optText}</option>`;
                            }
                        });

                        // Fail-safe: If no match found in dropdown, use the raw value
                        if (!matchedValue) {
                            matchedValue = raw_cat_id;
                            optionsHtml += `<option value="${raw_cat_id}">${raw_cat_id}</option>`;
                        }

                        if (attr.length > 0) {
                            attr[attr.length - 1] = matchedValue;
                        }

                        let details = `
                    <div class="row border1 mt-3" id="child${i}">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="col-sm-12 col-form-label">Attribute Type</label>
                                <select class="form-control attr-type-change" id="attr_select_${i}" data-rowid="${i}" data-prev="${matchedValue}" style="width: 100%;">
                                    ${optionsHtml}
                                </select>
                                <input type="hidden" name="attribute_name[]" value="${matchedValue}">
                                <input type="hidden" name="attribute_id[]" value="${attrid}">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label class="col-sm-12 col-form-label">Attribute Values <span style="color:red">*</span></label>
                                <select class="chil_cat_id required attribute_values" name="attribute_value_${matchedValue}[]" id="chil_cat_id${i}" required style="width:100%;" multiple="multiple"></select>
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-sm btn-danger mt-4" id="${i}|${matchedValue}" onclick="removeproduct(this)">Remove</button>
                        </div>
                    </div>`;

                        $('.product').append(details);

                        // Initialize Select2 on the new Attribute Type dropdown - ENABLED by default
                        $(`#attr_select_${i}`).select2({
                            placeholder: "Select Type",
                            width: '100%'
                        });

                        // Set the value AFTER Select2 initialization
                        $(`#attr_select_${i}`).val(matchedValue).trigger('change');

                        var html_option = [];
                        if (response.data) {
                            $.each(response.data, function(id, attribute_type) {
                                html_option.push(attribute_type);
                            });
                        }

                        // Initialize Select2 with the data
                        let currentIndex = i; // Capture current i value for closure
                        $('#chil_cat_id' + currentIndex).select2({
                            placeholder: 'Select Value',
                            data: html_option,
                            width: '100%'
                        });

                        // Debug: Log the option value being set
                        console.log('Setting values for attribute:', matchedValue);
                        console.log('Option value received:', option);
                        console.log('Option type:', typeof option);
                        console.log('Current index:', currentIndex);
                        console.log('Available options:', html_option);

                        // Set stored values AFTER Select2 is initialized
                        if (option && option !== "") {
                            // Use setTimeout to ensure Select2 is fully rendered
                            setTimeout(function() {
                                let opt;
                                if (Array.isArray(option)) {
                                    opt = option;
                                } else if (typeof option === 'string') {
                                    // Split by comma and trim whitespace
                                    opt = option.split(',').map(v => v.trim()).filter(v => v !== '');
                                } else {
                                    opt = [option];
                                }

                                console.log('Processed option array:', opt);
                                $('#chil_cat_id' + currentIndex).val(opt).trigger("change");

                                // Verify the value was set
                                let setValue = $('#chil_cat_id' + currentIndex).val();
                                console.log('Value set for #chil_cat_id' + currentIndex + ':',
                                    setValue);

                                if (!setValue || setValue.length === 0) {
                                    console.error('Failed to set values! Retrying...');
                                    // Retry once more
                                    setTimeout(function() {
                                        $('#chil_cat_id' + currentIndex).val(opt).trigger(
                                            "change");
                                        console.log('Retry result:', $('#chil_cat_id' +
                                            currentIndex).val());
                                    }, 200);
                                }
                            }, 300);
                        }

                        // Reset the main dropdown
                        $('#attr_type_select').val('').trigger('change');

                        i++;
                    }
                });
            } else {
                swal("Attention", "This attribute type has already been added.", "info");
            }
        }

        $('.btn-add-attribute').click(function() {
            let cat_id = $('#attr_type_select').val();
            if (cat_id != '') {
                variants(cat_id);
            }
        });

        $('.btn-generate-variants').click(function() {
            let allSelects = $('.attribute_values');
            if (allSelects.length === 0) {
                swal("Attention", "Please add at least one attribute first.", "warning");
                return;
            }

            let attributeArrays = [];
            let hasEmpty = false;
            allSelects.each(function() {
                let val = $(this).val();
                if (!val || val.length === 0) {
                    hasEmpty = true;
                } else {
                    attributeArrays.push(val);
                }
            });

            if (hasEmpty) {
                swal("Attention", "Please select values for all attribute types.", "warning");
                return;
            }

            function cartesian(arrays) {
                if (arrays.length === 0) return [
                    []
                ];
                return arrays.reduce(function(acc, arr) {
                    var result = [];
                    acc.forEach(function(combo) {
                        arr.forEach(function(val) {
                            result.push(combo.concat([val]));
                        });
                    });
                    return result;
                }, [
                    []
                ]);
            }

            let combinations = cartesian(attributeArrays);
            combinations.forEach(function(combo) {
                let value = combo.join(',');
                let label = combo.join(' / ');
                let vid = Math.floor(Math.random() * 1000000);
                renderVariantRow(vid.toString(), value, label);
            });
        });

        function renderVariantRow(vid, value, label, existingData = null) {
            if (variant.indexOf(vid.toString()) !== -1) return;

            // Strict normalization: Remove ALL whitespace, commas and lowercase for comparison
            let normalizedValue = value.toString().replace(/[\s,]/g, '').toLowerCase();
            if (variant_combos.indexOf(normalizedValue) !== -1) return;

            variant.push(vid.toString());
            variant_combos.push(normalizedValue);

            let sku = existingData ? existingData.sku : '';
            let photo = existingData ? existingData.photo : '';
            let regPrice = existingData ? existingData.regular_price : '';
            let salePrice = existingData ? existingData.sale_price : '';
            let stock = existingData ? existingData.in_stock : '0';
            let imagesHtml = '';

            if (photo) {
                photo.split(',').forEach(p => {
                    let imgPath = p.trim();
                    if (imgPath) {
                        imagesHtml +=
                            `<img src="${adminImageUrl(imgPath)}" style="max-height: 60px; margin-right: 5px; border-radius: 4px;">`;
                    }
                });
            }

            let details = `
        <div class="card mb-3 border" id="vchild${vid}">
            <div class="card-header d-flex justify-content-between align-items-center bg-light">
                <span class="font-weight-bold">Variant: ${label}</span>
                <div>
                    <button type="button" class="btn btn-sm btn-outline-primary mr-2" onclick="exvariant('vo${vid}')"><i class="fa fa-expand"></i></button>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removevariant('${vid}')"><i class="fa fa-trash"></i></button>
                </div>
            </div>
            <div class="card-body" id="vo${vid}" style="${existingData ? 'display:none;' : ''}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SKU <span style="color:red">*</span></label>
                            <input type="text" class="form-control required2" name="sku[]" value="${sku}" required placeholder="SKU">
                            <input type="hidden" name="variant_id[]" value="${vid}">
                            <input type="hidden" name="attribute_value[]" value="${value}">
                            <span class="err_emptyval text-danger" style="display:none">Required</span>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label>Images <span style="color:red">*</span></label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <a id="lfm${vid}" data-input="thumbnail${vid}" data-preview="holder${vid}" data-multiple="true" class="btn btn-primary lfm-v">
                                    <i class="fa fa-picture-o"></i>
                                </a>
                            </span>
                            <input id="thumbnail${vid}" class="form-control required2" type="text" name="photo[]" value="${photo}">
                            <span class="err_emptyval text-danger" style="display:none">Required</span>
                        </div>
                        <div id="holder${vid}" class="mt-2 d-flex flex-wrap">${imagesHtml}</div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Reg. Price <span style="color:red">*</span></label>
                            <input type="text" class="form-control required2" name="regular_price[]" value="${regPrice}" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Stock <span style="color:red">*</span></label>
                            <input type="number" class="form-control required2" name="stock[]" value="${stock}" required>
                            <input type="hidden" name="sale_price[]" value="${salePrice}">
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

            $('.variant').append(details);
            var lfm_route = (typeof route_prefix !== 'undefined') ? route_prefix : ($('meta[name="route_prefix"]').attr('content') || '/laravel-filemanager');
            $(` #lfm${vid}`).filemanager('image', {
                prefix: lfm_route,
                multiple: true
            });
        }

        function removeproduct(d) {
            var id = d.id.split('|')[0];
            let dval = d.id.split('|')[1];

            attr.splice(attr.indexOf(dval), 1);
            $('#child' + id).remove();
            if ($('.product .row').length == 0) {
                $('.variant1').addClass('d-none');
            }
        }

        function removevariant(vid) {
            let combo = $(`#vchild${vid}`).find('input[name="attribute_value[]"]').val();
            if (combo) {
                let normalized = combo.replace(/,/g, '');
                variant_combos.splice(variant_combos.indexOf(normalized), 1);
            }
            variant.splice(variant.indexOf(vid.toString()), 1);
            $('#vchild' + vid).remove();
        }

        function exvariant(id) {
            $('#' + id).toggle();
        }

        function product_attribute(id) {
            $.ajax({
                url: "{{ route('product.variant') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(response) {
                    if (response.productattribute) {
                        $.each(response.productattribute, function(key, data) {
                            variants(data.attribute_name, data.attribute_value, data.id);
                        });
                    }
                    if (response.productvariant) {
                        $.each(response.productvariant, function(key, data) {
                            renderVariantRow(data.id, data.variants, data.variants, data);
                        });
                    }
                }
            });
        }

        // Handle Attribute Type Change in Row
        $(document).on('change', '.attr-type-change', function() {
            let select = $(this);
            let newVal = select.val();
            let rowId = select.data('rowid');
            let prevVal = select.data('prev');

            // Check if new value exists in other rows
            if (attr.includes(newVal) && newVal !== prevVal) {
                swal("Attention", "This attribute type has already been added.", "info");
                select.val(prevVal).trigger('change');
                return;
            }

            // Update attr array
            let idx = attr.indexOf(prevVal);
            if (idx !== -1) {
                attr[idx] = newVal;
            } else {
                attr.push(newVal);
            }

            // Update hidden input
            $(`#child${rowId} input[name="attribute_name[]"]`).val(newVal);

            // Update Remove Button ID
            let removeBtn = $(`#child${rowId} .btn-danger`);
            removeBtn.attr('id', `${rowId}|${newVal}`);

            // Update Attribute Value Select Name
            let valueSelect = $(`#chil_cat_id${rowId}`);
            valueSelect.attr('name', `attribute_value_${newVal}[]`);

            // Fetch New Values
            valueSelect.empty();

            $.ajax({
                url: "{{ route('product.attribute') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: newVal
                },
                success: function(response) {
                    let html_option = [];
                    if (response.data) {
                        $.each(response.data, function(id, attribute_type) {
                            html_option.push(attribute_type);
                        });
                    }
                    valueSelect.select2({
                        placeholder: 'Select Value',
                        data: html_option
                    });
                }
            });

            // Update prev data
            select.data('prev', newVal);
        });

        // ============================================================
        // Wizard & Validation Logic
        // ============================================================
        function selectvalidation() {
            let flag = true;
            $('.form-control.required:visible').each(function() {
                if ($(this).val() === '' || $(this).val() === null) {
                    flag = false;
                    $(this).addClass('is-invalid');
                    $(this).next('.error').text('Required').show();
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).next('.error').text('').hide();
                }
            });

            if (flag) {
                $('.next1').hide();
                $('.product1').show();
                $('.product1').click();
            } else {
                swal("Attention", 'Please fill in all required fields.', "warning");
            }
        }

        function selectvalidation1() {
            // Clear previous error messages
            $("#selectsize").html("");

            // Check if variants are required but missing
            if ($('input[name="is_variant"]:checked').val() === 'yes' && variant.length == 0) {
                $("#selectsize").html("Please add at least one variant.");
            }

            // Mark invalid fields but don't block navigation
            $('.required2:visible').each(function() {
                if ($(this).val() === '' || $(this).val() === null) {
                    $(this).addClass('is-invalid');
                    $(this).next('.err_emptyval').show();
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).next('.err_emptyval').hide();
                }
            });

            // Always allow navigation to finish step
            $('.product2').click();
        }

        $('.next1').off('click').on('click', selectvalidation);
        $('.next2').off('click').on('click', selectvalidation1);

        // ============================================================
        // Wizard Navigation Script
        // ============================================================
        $(document).on('click', '.action-button', function() {
            var current_fs = $(this).parent();
            var next_fs = current_fs.next();

            // Add active class to progress bar
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            // Show next fieldset
            next_fs.show();

            // Hide current fieldset with animation
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    var opacity = 1 - now;
                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 500
            });
        });

        $(document).on('click', '.action-button-previous', function() {
            var current_fs = $(this).parent();
            var previous_fs = current_fs.prev();

            // Remove active class from progress bar
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            // Show previous fieldset
            previous_fs.show();

            // Hide current fieldset with animation
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    var opacity = 1 - now;
                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 500
            });
        });

        $('#msform').on('submit', function(e) {
            // Final check
            if ($('input[name="is_variant"]:checked').val() === 'no') {
                if ($('#prod_regular_price').val() === '' || $('#prod_stock').val() === '') {
                    e.preventDefault();
                    swal("Attention", "Please enter Regular Price and Stock for non-variant product.", "warning");
                }
            }
        });
    </script>
    <script>
        var lfm_route = (typeof route_prefix !== 'undefined') ? route_prefix : ($('meta[name="route_prefix"]').attr('content') || '/laravel-filemanager');
        $('#lfm').filemanager('image', {
            prefix: lfm_route
        });
    </script>
@endsection

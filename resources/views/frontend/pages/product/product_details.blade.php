@extends('frontend.layouts.master')

@section('content')

    <style>
        ul li {

            list-style: none;

        }

        .mb-15 {

            margin-bottom: 15px;

        }

        #review .review-rating {

            margin-bottom: 10px;

        }

        #review .review-rating i {

            color: #ff9800;

            font: 14px;

        }

        #review .review-rating span {

            font-weight: 700;

            font-size: 15px;

            font-family: poppins;

        }

        #review .review-details p {

            font-size: 13px;

            margin: 0;

            line-height: 1.9;

        }

        .mt-50 {

            margin-top: 50px;

        }

        .submit_a_review_area>h4 {

            font-size: 18px;

            font-family: poppins;

        }

        .form-group {

            margin-bottom: 1rem;

        }

        input[type=checkbox],

        input[type=radio] {

            box-sizing: border-box;

            padding: 0;

        }

        .submit_a_review_area .form-group>label {

            font-size: 14px;

            display: block;

            font-family: poppins;

        }

        .submit_a_review_area .form-group .form-control {

            font-size: 14px;

        }

        /* .form-control {

        display: block;

        width: 100%;

        height: calc(1.5em + 0.75rem + 2px);

        padding: 0.375rem 0.75rem;

        font-size: 1rem;

        font-weight: 400;

        line-height: 1.5;

        color: #495057;

        background-color: #fff;

        background-clip: padding-box;

        border: 1px solid #ced4da;

        border-radius: 0.25rem;

        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;

    } */

        .w-100 {

            width: 100% !important;

        }

        .psd {

            padding-right: 0px !important;

            padding-left: 0px !important;

        }

        .rat {

            font-family: poppins;

            font-size: 16px;

            font-weight: 400;

        }

        .btn-add-cart1 {

            display: inline-block;

            font-family: poppins;

            font-weight: 500;

            font-size: 15px;

            color: black;

            padding: 6px 4px;

            background: black;

            color: #fff;

            transition: all .3s ease;

            border: 1px solid black;

        }

        .star-rating {

            direction: rtl;

            display: inline-block;

            padding: 20px;

            cursor: default;

        }

        .star-rating input[type="radio"] {

            display: none;

        }

        .star-rating label {

            color: #bbb;

            font-size: 18px;

            padding: 0;

            cursor: pointer;

            -webkit-transition: all 0.3s ease-in-out;

            transition: all 0.3s ease-in-out;

        }

        .star-rating label:hover,

        .star-rating label:hover~label,

        .star-rating input[type="radio"]:checked~label {

            color: #f2b600;

        }
    </style>

    <main>

        <div class="content-search">

            <div class="container container-100">

                <i class="far fa-times-circle" id="close-search"></i>

                <h3 class="text-center">what are your looking for ?</h3>

                <form method="get" action="/search" role="search" style="position: relative;">

                    <input type="text" class="form-control control-search" value="" autocomplete="off"
                        placeholder="Enter Search ..." aria-label="SEARCH" name="q">

                    <button class="button_search" type="submit">search</button>

                </form>

            </div>

        </div>

        <div class="container">

            <div class="menu-breadcrumb">

                <ul class="breadcrumb">

                    <li><a href="#">Home</a></li>

                    <li><a href="#">FLOWER</a></li>

                    <li><a href="#">Queen Rose - Pink</a></li>

                </ul>

            </div>

        </div>

        <div class="product-detail">

            <div class="container">

                <div class="row">

                    @php

                        $photos = explode(',', $products->photo);

                        $variant_val = App\Models\ProductVariant::where('product_id', $products->id)
                            ->orderBy('id', 'desc')
                            ->first();

                        $categories = DB::table('categories')->where('id', $products->cat_id)->first();

                    @endphp

                    <div class="slider-for">

                        @foreach ($photos as $key => $photo)
                            <div class="product-content">

                                <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12 img-content">

                                    <img src="{{ $photo }}" id="product_img{{ $products->id }}"
                                        class="img-responsive" alt="img-holiwood">

                                </div>

                                <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12 detail">

                                    <h1>{{ $products->title }}</h1>

                                    <p class="p1">{!! html_entity_decode($products->summary) !!}<br class="hidden-md hidden-sm hidden-xs"></p>

                                    <div class="star">
                                        </figure>
                                    @endif

                                    @if (count($data) > 0)
                                        @foreach ($data as $key => $items)
                                            <div class="size col-md-3 col-sm-6 col-xs-12">

                                                <span class="lb-size">{{ $key }} <span
                                                        class="sta-red">*</span></span>

                                                <div class="select-custom attrib_colr">

                                                    <input type="hidden" name="product" id="product{{ $products->id }}"
                                                        value="{{ $products->id }}">

                                                    @php

                                                        $arr_cnt = count($data);

                                                    @endphp

                                                    <select name="attrib_{{ $key }}_{{ $products->id }}"
                                                        id="attrib_{{ $key }}_{{ $products->id }}"
                                                        class="productoption attrib_{{ $products->id }}"
                                                        data-id="{{ $products->id }}">

                                                        <option value="">{{ $key }}</option>

                                                        @foreach ($data[$key] as $size)
                                                            @foreach (explode(',', $size->arrtibute_value) as $k1 => $size1)
                                                                <option
                                                                    value="{{ json_encode($data) . '|' . $products->id . '|' . $key . '|' . $size1 }}"
                                                                    {{ $k1 == count(explode(',', $size->arrtibute_value)) - 1 ? 'selected' : '' }}>
                                                                    {{ $size1 }}</option>
                                                            @endforeach
                                                        @endforeach

                                                    </select>

                                                </div>

                                            </div>
                                        @endforeach
                                    @endif

                                    <!-- @if (isset($data['Colour']) && count($data['Colour']) > 0)
    <div class="color col-lg-8 col-md-6 col-sm-6 col-xs-12 attrib_colrr" >

                                    <div class="div-color " ><span class="lb-color" >Color  </span>

                                        <span class="sta-red">*</span></div>

                                        @php $clr=""; @endphp

                                        @foreach ($data['Colour'] as $color)
    @php

        $colorstyle =
            "

                                   display: inline-block;

    width: 40px;

    height: 40px;

    border-radius: 50%;

    border: 1px solid #ddd;

    background: " .
            $color->arrtibute_name .
            ";

    margin-right: 10px;

    transition: all .3s ease";

    @endphp

                                        <input type="hidden" name="color" id="color{{ $color->arrtibute_name }}" value="{{ $color->arrtibute_name }}">

                                        <input type="hidden" name="product" id="product{{ $products->id }}" value="{{ $products->id }}">

                                        <span class="color" style="{{ $colorstyle }}" id="{{ $color->arrtibute_name . '|' . $products->id }}" data-id="{{ $color->arrtibute_name . '|' . $products->id }}"></span>
    @endforeach

                                </div>
    @endif -->

                                    <!-- <div class="color col-lg-8 col-md-6 col-sm-6 col-xs-12">

             <div class="div-color"><span class="lb-color">Color <span class="sta-red">*</span></span></div>

             <a href="#"><span class="color-1"></span></a> <a href="#"><span class="color-2"></span></a> <a href="#"><span class="color-3"></span></a>

             <a href="#"><span class="color-4"></span></a> <a href="#"><span class="color-5"></span></a>

            </div> -->

                                    <p class="require"></p>

                                    <div class="Quality">

                                        <div class="input-group input-number-group">

                                            <span class="text-qua">Quantity:</span>

                                            <div class="input-group-button">

                                                <span class="input-number-decrement" data-title="newarrivals"
                                                    data-category="{{ $categories->title }}"
                                                    data-id="{{ $products->id }}">-</span>

                                            </div>

                                            <input class="input-number input-numbersnewarrivals_{{ $products->id }}"
                                                type="number" min="0" max="1000" id="total_quantity"
                                                value="01" data-id="{{ $products->id }}">

                                            <div class="input-group-button">

                                                <span class="input-number-increment" data-title="newarrivals"
                                                    data-category="{{ $categories->title }}"
                                                    data-id="{{ $products->id }}">+</span>

                                            </div>

                                            <span class="dola">₹</span><span class="total-prince_{{ $products->id }}"
                                                data-price="{{ $variant_value->sale_price }}">{{ $variant_value->sale_price }}</span>

                                        </div>

                                    </div>

                                    <div class="add-cart">

                                        <a href="javascript:void(0);" data-quantity="1"
                                            data-product-id="{{ $products->id }}"
                                            class="default_set btn-add-cart add_to_cart add_to_cartid{{ $products->id }}"
                                            id="add_to_cart{{ $categories->title }}_{{ $products->id }}">Add to cart</a>

                                        <a href="javascript:void(0);" data-quantity="1"
                                            data-product-id="{{ $products->id }}"
                                            class="default_set btn-add-cart buynow buynowid{{ $products->id }}"
                                            id="buynow{{ $categories->title }}_{{ $products->id }}">Buy Now</a>

                                        <a href="javascript:void(0);"
                                            class="default_set list-icon icon-2 add_to_wishlist wishlist{{ $products->id }} wish1{{ $products->id }}"
                                            data-quantity="1" data-id="{{ $products->id }}"
                                            id="add_to_wishlist_{{ $products->id }}">

                                            @php

                                                if (Auth::guard('customer')->check()) {
                                                    $get_wishlists = DB::table('wishlists')
                                                        ->where('customer_id', auth()->guard('customer')->user()->id)
                                                        ->where('product_id', $products->id)
                                                        ->get();
                                                } else {
                                                    $get_wishlists = DB::table('wishlists')
                                                        ->where('product_id', $products->id)
                                                        ->get();
                                                }

                                            @endphp

                                            @if (count($get_wishlists) > 0)
                                                <i class="fa fa-heart whats_new_icon_{{ $products->id }} icon1_{{ $products->id }}"
                                                    style="color:red;"></i>
                                            @else
                                                <i
                                                    class="fa fa-heart whats_new_icon_{{ $products->id }} icon1_{{ $products->id }}"></i>
                                            @endif

                                        </a>

                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>

                    <div class="slider-nav col-lg-5 col-md-6 col-sm-12 col-xs-12">

                        @php

                            $photos = explode(',', $products->photo);

                        @endphp

                        @foreach ($photos as $key => $photo)
                            <div><img src="{{ $photo }}" class="img-responsive" alt="img-holiwood">

                            </div>
                        @endforeach

                        <!-- <div><img src="{{ asset('frontend/img/product-2.jpg') }}" class="img-responsive" alt="img-holiwood">

                        </div>

                        <div><img src="{{ asset('frontend/img/product-3.jpg') }}" class="img-responsive" alt="img-holiwood">

                        </div>

                        <div><img src="{{ asset('frontend/img/product-4.jpg') }}" class="img-responsive" alt="img-holiwood">

                        </div> -->

                    </div>

                    <div class="col-lg-7 connect-us col-md-6 col-sm-12 col-xs-12">

                        <a href="#" id="like-fb"></a>

                        <a href="#" id="like-tw"></a>

                        <a href="#" id="like-gg"></a>

                        <a href="#" id="like-share"></a>

                    </div>

                </div>

            </div>

            <div class="product-text" style="padding: 10px 0px!important;">

                <div class="container">

                    <ul class="nav nav-tabs menu-tab">

                        <li class="active"><a data-toggle="tab" href="#decription">Description</a>

                            <figure id="fi-decription"></figure>

                        </li>

                        <li><a data-toggle="tab" href="#review">Reviews

                                ({{ \App\Models\ProductReviews::where(['product_id' => $products->id, 'status' => 'accept'])->count() }})</a>

                            <figure id="fi-write"></figure>

                        </li>

                        <!-- <li><a data-toggle="tab" href="#product-tag">Product Tags</a><figure id="fi-product-tag"></figure></li> -->

                        <li><a data-toggle="tab" href="#write">Cancellation & Return Policy</a>

                            <figure id="fi-write"></figure>

                        </li>

                        <li><a data-toggle="tab" href="#addtional">Additional Information</a>

                            <figure id="fi-addtional"></figure>

                        </li>

                    </ul>

                    <div class="tab-content">

                        <div id="decription" class="tab-pane fade in active">

                            {!! html_entity_decode($products->description) !!}

                        </div>

                        <!-- <div id="product-tag" class="tab-pane fade">

       <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.

       <br><br>

    Fusce aliquet, ante cursus gravida sagittis, justo erat rhoncus sapien, eget condimentum ligula magna sed est. Suspendisse molestie ligula tortor. Suspendisse vitae orci ac purus eleifend malesuada at vel tellus. Sed ac semper magna. Mauris consequat blandit risus. Cras dictum eros libero, a scelerisque quam laoreet non. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nullam pharetra euismod felis, a eleifend magna.</p>

     </div> -->

                        <div id="review" class="tab-pane fade">

                            <div class="reviews_area">

                                @if (Auth::guard('customer')->check())

                                    <ul>

                                        <li>

                                            <!-- <h2 class="title">

                                            ({{ \App\Models\ProductReviews::where('product_id', $products->id)->count() }}) For

                                            {{ $products->title }}</h2> -->

                                            @php

                                                $reviews = \App\Models\ProductReviews::where([
                                                    'product_id' => $products->id,
                                                    'status' => 'accept',
                                                ])
                                                    ->latest()
                                                    ->paginate(5);

                                            @endphp

                                            <div class="single_user_review mb-15">

                                                @if (count($reviews) > 0)
                                                    @foreach ($reviews as $review)
                                                        <div class="review-rating">

                                                            @for ($i = 0; $i < '5'; $i++)
                                                                @if ($review->rate > $i)
                                                                    <i class="fa fa-star " aria-hidden="true"></i>
                                                                @else
                                                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                @endif
                                                            @endfor

                                                            <span>{{ $review->review }}</span>

                                                        </div>

                                                        <div class="review-details">

                                                            <p>by <a
                                                                    href="#">{{ ucfirst(\App\Models\CustomerTable::where('id', $review->customer_id)->value('name')) }}</a>

                                                                on <span>-

                                                                    {{ \Carbon\Carbon::parse($review->created_at)->format('M,d,Y') }}</span>

                                                            </p>

                                                        </div>
                                                    @endforeach
                                                @endif

                                            </div>

                                            <!-- <div class="single_user_review mb-15">

                                            <div class="review-rating">

                                                <i class="fa fa-star" aria-hidden="true"></i>

                                                <i class="fa fa-star" aria-hidden="true"></i>

                                                <i class="fa fa-star" aria-hidden="true"></i>

                                                <i class="fa fa-star" aria-hidden="true"></i>

                                                <i class="fa fa-star" aria-hidden="true"></i>

                                                <span>for Design</span>

                                            </div>

                                            <div class="review-details">

                                                <p>by <a href="#">Sandy</a> on <span>12 Sep 2019</span></p>

                                            </div>

                                        </div>

                                        <div class="single_user_review">

                                            <div class="review-rating">

                                                <i class="fa fa-star" aria-hidden="true"></i>

                                                <i class="fa fa-star" aria-hidden="true"></i>

                                                <i class="fa fa-star" aria-hidden="true"></i>

                                                <i class="fa fa-star" aria-hidden="true"></i>

                                                <i class="fa fa-star" aria-hidden="true"></i>

                                                <span>for Value</span>

                                            </div>

                                            <div class="review-details">

                                                <p>by <a href="#">Gayathri</a> on <span>12 Sep 2019</span></p>

                                            </div>

                                        </div>

                                    </li> -->

                                    </ul>
                                @else
                                    <p class="py-5"><a href="{{ route('user.auth', $products->slug) }}">Click here !</a>
                                        you need

                                        to login!</p><br>

                                @endif

                            </div>

                            <div class="submit_a_review_area mt-50">

                                @if (Auth::guard('customer')->check())
                                    <h4>Submit A Review</h4>

                                    <form method="POST" action="{{ route('product.review', $products->slug) }}">

                                        @csrf

                                        <div class="form-group">

                                            <span class="rat">Your Ratings</span>

                                            @error('review')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror

                                            <div class="star-rating">

                                                <input id="star-5" type="radio" name="rate" value="5" />

                                                <label for="star-5" title="5 stars">

                                                    <i class="active fa fa-star" aria-hidden="true"></i>

                                                </label>

                                                <input id="star-4" type="radio" name="rate" value="4" />

                                                <label for="star-4" title="4 stars">

                                                    <i class="active fa fa-star" aria-hidden="true"></i>

                                                </label>

                                                <input id="star-3" type="radio" name="rate" value="3" />

                                                <label for="star-3" title="3 stars">

                                                    <i class="active fa fa-star" aria-hidden="true"></i>

                                                </label>

                                                <input id="star-2" type="radio" name="rate" value="2" />

                                                <label for="star-2" title="2 stars">

                                                    <i class="active fa fa-star" aria-hidden="true"></i>

                                                </label>

                                                <input id="star-1" type="radio" name="rate" value="1" />

                                                <label for="star-1" title="1 star">

                                                    <i class="active fa fa-star" aria-hidden="true"></i>

                                                </label>

                                                @error('rate')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror

                                            </div>

                                        </div>

                                        <input type="hidden" name="customer_id"
                                            value="{{ Auth::guard('customer')->user()->id }}">

                                        <input type="hidden" name="product_id" value="{{ $products->id }}">

                                        <div class="col-md-6 psd form-group" style="padding-right: 10px !important;">

                                            <label for="name">Nickname</label>

                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Your Name"
                                                value="{{ Auth::guard('customer')->user()->name }}">

                                            @error('name')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror

                                        </div>

                                        <div class="col-md-6 psd form-group">

                                            <label for="name">Email</label>

                                            <input type="email" class="form-control" name="email" id="email"
                                                placeholder="Your EMail"
                                                value="{{ Auth::guard('customer')->user()->email }}">

                                            @error('email')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror

                                        </div>

                                        <div class="form-group">

                                            <label for="comments">Comments</label>

                                            <textarea class="form-control" name="review" id="comments" rows="5" data-max-length="150"></textarea>

                                            @error('review')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror

                                        </div>

                                        <button type="submit" class="btn-add-cart1">Submit Review</button>

                                    </form>
                                @else
                                @endif

                            </div>

                        </div>

                        <div id="write" class="tab-pane fade">

                            {!! html_entity_decode($products->return_cancellation) !!}

                        </div>

                        <div id="addtional" class="tab-pane fade">

                            {!! html_entity_decode($products->additional_info) !!}

                        </div>

                    </div>

                </div>

                <!-- select modal for setting data-option -->

                <div class="modal" tabindex="-1" role="dialog">

                    <div class="modal-dialog" role="document">

                        <div class="modal-content">

                            <div class="modal-header">

                                <h5 class="modal-title">Modal title</h5>

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                    <span aria-hidden="true">&times;</span>

                                </button>

                            </div>

                            <div class="modal-body">

                                @php

                                    $products1 = \App\Models\Product::with('rel_prods')
                                        ->where('slug', $products->slug)
                                        ->first();

                                    $attribute_get = DB::table('attributes')->get();

                                    $product_orders = \App\Models\ProductAttribute::distinct('arrtibute_name')
                                        ->where('product_id', $products1->id)
                                        ->get(['arrtibute_name']);

                                    $attribute_value = \App\Models\ProductAttribute::where('product_id', $products1->id)
                                        ->orderBy('id', 'desc')
                                        ->first();

                                    $product_variant = DB::table('product_variant')
                                        ->where('product_id', $products1->id)
                                        ->orderBy('id', 'desc')
                                        ->first();

                                    $data = [];

                                    $categories = DB::table('categories')->where('id', $products1->cat_id)->first();

                                    foreach ($product_orders as $value) {
                                        $data[$value->arrtibute_name] = DB::table('product_attributes')
                                            ->select('arrtibute_name', 'arrtibute_value', 'id')

                                            ->where('product_id', $products1->id)

                                            ->where('arrtibute_name', $value->arrtibute_name)

                                            ->get();
                                    }

                                @endphp

                                @if (count($data) > 0)
                                    @foreach ($data as $key => $items)
                                        <div class="size col-md-6 col-sm-6 col-xs-12">

                                            <span class="lb-size label_name_{{ $products->id }}">{{ $key }}
                                                <span class="sta-red">*</span></span>

                                            @php

                                                $arr_cnt = count($data);

                                            @endphp

                                            <div class="select-custom attrib_colr attrib_{{ $key }}_val">

                                                <input type="hidden" name="product" id="product{{ $products->id }}"
                                                    value="{{ $products->id }}">

                                                <input type="hidden" id="setarrtibute_val">

                                                <select name="attrib_{{ $key }}_{{ $products->id }}"
                                                    id="attrib_{{ $key }}_{{ $products->id }}"
                                                    class="productoption attrib_{{ $products->id }} ol-md-6 col-sm-6 col-xs-12"
                                                    style="text-align:center" data-id="{{ $products->id }}">

                                                    <option value="">{{ $key }}</option>

                                                    @foreach ($data[$key] as $size)
                                                        @foreach (explode(',', $size->arrtibute_value) as $k1 => $size1)
                                                            <option
                                                                value="{{ json_encode($data) . '|' . $products->id . '|' . $key . '|' . $size1 }}"
                                                                {{ $k1 == count(explode(',', $size->arrtibute_value)) - 1 ? 'selected' : '' }}>
                                                                {{ $size1 }}</option>
                                                        @endforeach
                                                    @endforeach

                                                </select>

                                            </div>

                                        </div>
                                    @endforeach
                                @endif

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-primary">Save changes</button>

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- modal-end -->

                <div class="related" style="padding: 40px 0 20px 0!important;">

                    <div class="container">

                        <h1>Related Products</h1>

                        @if (count($products->rel_prods) > 0)
                            <div class="row">

                                @foreach ($products->rel_prods as $item)
                                    @php

                                        @$wishitem = \App\Models\Wishlist::where([
                                            'status' => 'active',
                                            'product_id' => $data->id,
                                            'customer_id' => auth()->guard('customer')->user()->id,
                                        ])->get();

                                    @endphp

                                    @if ($item->id != $products->id)
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 product-category">

                                            <div class="product-image-category">

                                                @php

                                                    $size_guide = explode(',', $item->size_guide);

                                                    $product_variant = DB::table('product_variant')
                                                        ->where('product_id', $item->id)
                                                        ->orderBy('id', 'desc')
                                                        ->first();

                                                @endphp

                                                <figure class="sale sale{{ $item->id }} product-figure"><a
                                                        href="#"><img src="{{ $size_guide[0] }}"
                                                            class="img-responsive" alt="img-holiwood"></a></figure>

                                                <style>
                                                    .related .product-category .product-image-category .sale{{ $item->id }}::before {

                                                        content: '{{ $item->conditions }}';

                                                    }
                                                </style>

                                                <div class="product-icon-category">

                                                    <a href="/product_detail/{{ $item->slug }}"><i
                                                            class="far fa-eye"></i></a>

                                                    <a href="javascript:void(0);"
                                                        class="add_to_wishlist2 wish2{{ $item->id }}"
                                                        data-quantity="1"data-id="{{ $item->id }}"
                                                        id="add_to_wishlist_{{ $item->id }}">

                                                        @php

                                                            $get_wishlists = DB::table('wishlists')
                                                                ->where('product_id', $item->id)
                                                                ->get();

                                                        @endphp

                                                        @if (count($get_wishlists) > 0)
                                                            <i class="fa fa-heart whats_new_icon_{{ $item->id }} icon2_{{ $item->id }} "
                                                                style="color:red;"></i>
                                                        @else
                                                            <i
                                                                class="fa fa-heart whats_new_icon_{{ $item->id }} icon2_{{ $item->id }}"></i>
                                                        @endif

                                                    </a>

                                                </div>

                                            </div>

                                            <div class="product-title-category">

                                                <h5><a href="javascript:void(0);">{{ $item->title }}</a></h5>

                                                <div class="star">

                                                    {!! html_entity_decode(App\Http\Controllers\Frontend\WhatisnewController::productreview($item->id)) !!}

                                                </div>

                                                <div class="prince">
                                                    ${{ number_format($product_variant->sale_price, 2) }}<s
                                                        class="strike">${{ number_format($product_variant->regular_price, 2) }}</s>
                                                </div>

                                            </div>

                                        </div>
                                    @endif
                                @endforeach

                                <!-- <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 product-category">

                                <div class="product-image-category">

                                    <a href="#"><img src="{{ asset('frontend/img/tulia-5.jpg') }}" class="img-responsive"

                                            alt="img-holiwood"></a>

                                    <div class="product-icon-category">

                                        <a href="#"><i class="far fa-eye"></i></a>

                                        <a href="#"><i class="fas fa-shopping-basket"></i></a>

                                        <a href="#"><i class="far fa-heart"></i></a>

                                    </div>

                                </div>

                                <div class="product-title-category">

                                    <h5><a href="#">Bouquet Lavender</a></h5>

                                    <div class="star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i

                                            class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>

                                    </div>

                                    <div class="prince">$160.8</div>

                                </div>

                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 product-category">

                                <div class="product-image-category">

                                    <figure class="hot"><a href="#"><img src="{{ asset('frontend/img/tulia-7.jpg') }}"

                                                class="img-responsive" alt="img-holiwood"></a></figure>

                                    <div class="product-icon-category">

                                        <a href="#"><i class="far fa-eye"></i></a>

                                        <a href="#"><i class="fas fa-shopping-basket"></i></a>

                                        <a href="#"><i class="far fa-heart"></i></a>

                                    </div>

                                </div>

                                <div class="product-title-category">

                                    <h5><a href="#">Fun & Flirty By BloomNation</a></h5>

                                    <div class="star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i

                                            class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>

                                    </div>

                                    <div class="prince">$200.7</div>

                                </div>

                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 product-category">

                                <div class="product-image-category">

                                    <a href="#"><img src="{{ asset('frontend/img/tulia-8.jpg') }}" class="img-responsive"

                                            alt="img-holiwood"></a>

                                    <div class="product-icon-category">

                                        <a href="#"><i class="far fa-eye"></i></a>

                                        <a href="#"><i class="fas fa-shopping-basket"></i></a>

                                        <a href="#"><i class="far fa-heart"></i></a>

                                    </div>

                                </div>

                                <div class="product-title-category">

                                    <h5><a href="#">Bouquet Rose</a></h5>

                                    <div class="star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i

                                            class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>

                                    </div>

                                    <div class="prince">$350.4</div>

                                </div>

                            </div> -->

                            </div>
                        @endif

                    </div>

                </div>

            </div>

    </main>

@endsection

@section('script')
    <script src="{{ asset('frontend/js/function-slick.js') }}"></script>

    <script src="{{ asset('frontend/js/function-flower.js') }}"></script>

    <script src="{{ asset('frontend/js/function-input-number.js') }}"></script>

    <script src="{{ asset('frontend/js/function-select-custom.js') }}"></script>

    <script src="{{ asset('frontend/js/function-back-top.js') }}"></script>

    <script src="{{ asset('frontend/js/funtion-header-v3.js') }}"></script>

    <script src="{{ asset('frontend/js/function-sidebar.js') }}"></script>

    <script src="{{ asset('frontend/js/function-search-v2.js') }}"></script>
@endsection

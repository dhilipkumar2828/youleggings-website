@extends('frontend.layouts.arrivals_products_master_new')

@section('content')
    <main class="main-content cart-main-content">

        <!--== Start Page Header Area Wrapper ==-->

        <!--== Start Page Header Area Wrapper ==-->
        <style>
            .wrapper {
                overflow-x: unset;
            }

            .nice-select .list {
                height: 200px !important;
                overflow-y: scroll !important;
            }

            section.browse-list-section.mobviewsecone {
                display: none;
            }

            @media (max-width: 767px) {
                section.browse-list-section.mobviewsecone {
                    display: block;
                }

                .topnavnewmega {

                    display: none;
                }
            }
        </style>

        @php
            $total_Amt = number_format($shipping + $sub_amt, 2, '.', '');
            $deliverycharges = '0';
            $shipping_charges = '0';
            $deliverydetails = DB::table('shippingcharges')
                ->where('from', '<=', $sub_amt)
                ->where('to', '>=', $sub_amt)
                ->first();
            if (!empty($deliverydetails)) {
                $deliverycharges = $deliverydetails->amount;
            }

            if ($deliverycharges) {
                $shipping_charges = number_format($deliverycharges + $shipping, 2, '.', '');
                $total_Amt = number_format($deliverycharges + $sub_amt, 2, '.', '');
            }

            if (count($coupon) > 0) {
                $coupan_id = $coupon['id'];
                $coupan_details = DB::table('coupon')->where('id', $coupan_id)->first();
                $discount_Amt = 0;
                if ($coupan_details->product_id < 1) {
                    if ($coupan_details->offer_details == 1) {
                        $discount_Amt = number_format($coupon['discount'], 2);
                    } else {
                        $discount_Amt = number_format(($sub_amt * $coupon['discount']) / 100, 2, '.', '');
                    }
                }
            }
        @endphp

        <section class="browse-list-section mobviewsecone">
            <!-- category list custom -->

            <div class="container">

                <div class="row mb-n4 mb-sm-n10 g-3 g-sm-6">
                    <div id="owl-one" class="owl-carousel owl-theme">

                        @php
                            $category = DB::table('categories')
                                ->select('title', 'id', 'slug', 'photo')
                                ->where('is_parent', 0)
                                ->orderBy('headerorder', 'asc')
                                ->where('header', 'active')
                                ->where('status', 'active')
                                ->get();
                        @endphp

                        @foreach ($category as $c)
                            <div class="item">

                                <div class="category-item text-center">
                                    <a href="{{ url('product_list') . '/' . $c->slug }}" style="color:black !important;">
                                        <img src="{{ $c->photo }}" class="img-fluid menuimg" width="64"
                                            height="64" alt="">
                                        <h5 class="title fontsiz mt-0 mb-0">{{ $c->title }}</h5>

                                    </a>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            </div>
        </section>

        <section class="page-header-area">
            <div class="container">

                <div class="row">
                    <div class="col-md-6">
                        <div class="page-header-st3-content">
                            <h2 class="page-header-title">Cart</h2>
                        </div>
                    </div>

                    <div class="col-md-6 justify-content-end d-flex">
                        <div class="page-header-st3-content">
                            <ol class="breadcrumb justify-content-center justify-content-md-start">
                                <li class="breadcrumb-item"><a class="text-dark" href="{{ url('index') }}">Home</a></li>
                                <li class="breadcrumb-item active text-dark" aria-current="page">Cart</li>
                            </ol>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!--== End Page Header Area Wrapper ==-->

        <!--== End Page Header Area Wrapper ==-->

        <!--== Start Product Area Wrapper ==-->

        <section class="section-space padd-tb-60">

            <div class="container">
                <div class="row">
                    <div class="col-md-12">

                        <div class="coupon-accordion" id="CouponAccordion">
                            <div class="card">
                                <h3 class="mb-0 p-3 fs-6">
                                    <i class="fa fa-info-circle"></i>

                                    <a href="#/" data-bs-toggle="collapse" data-bs-target="#couponaccordion">Click here
                                        to enter your coupon code</a>
                                </h3>
                                <div id="couponaccordion" class="collapse" data-bs-parent="#CouponAccordion">
                                    <div class="card-body">
                                        <div class="apply-coupon-wrap">
                                            <form action="#" method="post" id="checkout_form">
                                                <div class="row">

                                                    @if (count(Session::get('coupon', [])) > 0)
                                                        <button type="button" class="default-btn w-100"
                                                            id="remove_coupon">Remove Coupon</button>
                                                    @else
                                                        <div class="col-md-6">
                                                            <input type="hidden" name="coupontotal" id="coupantotal"
                                                                value="{{ $sub_amt }}">
                                                            <input type="text" name="cart-coupon"
                                                                placeholder="Coupon code" class="form-control"
                                                                id="coupon_code" style="width:100%;">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <button type="button" class="default-btn w-100"
                                                                id="apply_coupon">Apply Coupon</button>
                                                    @endif
                                                    <span class="coupon_err text-danger"></span>
                                                    <span class="coupon_success text-success"></span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--== End Checkout Coupon Accordion ==-->
                    </div>

                    <div class="row mt-4 mb-4">

                        @if (count($carts) > 0)
                            <div class="col-12 col-lg-8">
                                <div class="cartproduct_render">
                                    @include('frontend.pages.cart.main_cartlist')
                                </div>
                                <a href="{{ url('index') }}" class="optional-btn">Continue Shopping</a>
                            </div>

                            <div class="col-12 col-lg-4">
                                <span class="ajaxupdate_render">
                                    @include('frontend.pages.cart.ajax_update')
                                </span>
                            </div>
                        @else
                            <img src="{{ url('frontend/img/empty_cart.png') }}" style="width:11em;">
                            <b class="text-center">Your Cart is empty</b>
                        @endif

                    </div>
                </div>
            </div>
            </div>

        </section>

        <!--== End Product Area Wrapper ==-->

    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // When plus button is clicked
            $('.inc').click(function() {
                // Trigger the remove coupon button click
                $('#remove_coupon').click();
            });

            // When minus button is clicked
            $('.dec').click(function() {
                // Trigger the remove coupon button click
                $('#remove_coupon').click();
            });

            // Optionally, you can handle the click event of the remove coupon button itself
            $('#remove_coupon').click(function() {
                // Logic to remove the coupon, e.g., making an AJAX request, hiding the coupon section, etc.
                console.log("Coupon removed");
                // Add your remove coupon functionality here
            });
        });
    </script>
@endsection

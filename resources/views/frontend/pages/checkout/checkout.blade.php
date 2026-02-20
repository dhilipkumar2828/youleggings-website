@extends('frontend.layouts.arrivals_products_master_new')

@section('content')
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

    <main class="main-content">

        <!--== Start Page Header Area Wrapper ==-->
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
                <!-- style="margin-top:100px;" -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="page-header-st3-content">
                            <h2 class="page-header-title">Checkout</h2>
                        </div>
                    </div>

                    <div class="col-md-6 justify-content-end d-flex">
                        <div class="page-header-st3-content">
                            <ol class="breadcrumb justify-content-center justify-content-md-start">
                                <li class="breadcrumb-item"><a class="text-dark" href="{{ url('index') }}">Home</a></li>
                                <li class="breadcrumb-item active text-dark" aria-current="page">Checkout</li>
                            </ol>

                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!--== End Page Header Area Wrapper ==-->

        <!--== Start Shopping Checkout Area Wrapper ==-->
        <section class="shopping-checkout-wrap section-space padd-tb-30" style="padding-top: 25px;">
            <div class="container">

                <div class="checkout-page-coupon-wrap">
                    <!--== Start Checkout Coupon Accordion ==-->

                    <!----
                            <div class="coupon-accordion" id="CouponAccordion">
                                <div class="card">
                                    <h3>
                                        <i class="fa fa-info-circle"></i>

                                        <a href="#/" data-bs-toggle="collapse" data-bs-target="#couponaccordion">Click here to enter your code</a>
                                    </h3>
                                    <div id="couponaccordion" class="collapse" data-bs-parent="#CouponAccordion">
                                        <div class="card-body">
                                            <div class="apply-coupon-wrap">
                                                <form action="#" method="post" id="checkout_form">
                                                    <div class="row">
                                                        @if (count(Session::get('coupon', [])) > 0)
    <button type="button" class="default-btn w-100" id="remove_coupon">Remove Coupon</button>
@else
    <div class="col-md-6">
                                                            <input type="text" name="cart-coupon" placeholder="Coupon code" class="form-control" id="coupon_code" style="width:100%;">
                                                            </div>
                                                            <div class="col-md-6">
                                                            <button type="button" class="default-btn w-100" id="apply_coupon">Apply Coupon</button>
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

                        </div>
                        ---->

                    <div class="row">
                        <!-- <form action="{{ url('checkout_store') }}" method="post" id="billing_address"> -->
                        <div class="col-lg-6">
                            <!--== Start Billing Accordion ==-->
                            <div class="checkout-billing-details-wrap">
                                <h2 class="title mt-0">Billing Address</h2>
                                <div class="billing-form-wrap">

                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="f_name" class="mb-1">First name <span class="required"
                                                        title="required">*</span></label>
                                                <input id="f_name" type="text" class="form-control"
                                                    value={{ $shipping_address ? $shipping_address->sfirst_name : '' }}>
                                                <div id="fn_err" class="f_nameerr text-danger" style="display:none;">This
                                                    field is required</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">

                                                <label for="l_name" class="mb-1">Last name </label>
                                                <input id="l_name" type="text" class="form-control"
                                                    value={{ $shipping_address ? $shipping_address->slast_name : '' }}>

                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <div class="form-group" class="mb-1">
                                                <label for="phone">Phone Number <span class="required"
                                                        title="required">*</span></label>
                                                <input id="phone" name="phone" minlength="10" maxlength="10"
                                                    onkeypress="return isNumber(event)" type="text"
                                                    class="form-control" required
                                                    value={{ $shipping_address ? $shipping_address->sphone_number : '' }}>
                                                <div id="phone_err" class="phoneerr text-danger" style="display:none;">
                                                    This field is required</div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <div class="form-group mb-2">
                                                <label for="street-address" class="mb-1">Address <span class="required"
                                                        title="required">*</span></label>
                                                <input id="street-address" type="text" class="form-control"
                                                    placeholder="House number and street name"
                                                    value="{{ $shipping_address ? $shipping_address->sstreet_1 : '' }}">
                                                <div id="street1_err" class="addresserr text-danger"
                                                    style="display:none;">This field is required</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="street-address2" class="visually-hidden mb-1">Street address 2
                                                    <span class="required" title="required"
                                                        value="{{ $shipping_address ? $shipping_address->sstreet_2 : '' }}">*</span></label>
                                                <input id="street-address2" type="text" class="form-control"
                                                    placeholder="Apartment, suite, unit etc. (optional)">

                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label for="town" class="mb-1">Town / City <span class="required"
                                                        title="required">*</span></label>
                                                <input id="town" type="text" class="form-control"
                                                    value={{ $shipping_address ? $shipping_address->scity : '' }}>
                                                <div id="city_err" class="cityerr text-danger" style="display:none;">
                                                    This field is required</div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label for="inputfState" class=" control-label d-block mb-1">State <span
                                                        class="color">*</span></label>
                                                <select name="state" id="state" class="form-control wide"
                                                    onchange="productgstchange()" required>
                                                    <option value="">Select State</option>
                                                    @foreach ($states as $id => $state)
                                                        <option value="{{ $id }}">{{ $state }}</option>
                                                    @endforeach
                                                </select>
                                                <div id="city_err" class="stateerr text-danger" style="display:none;">
                                                    This field is required</div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label for="pz-code" class="mb-1">Pincode</label>
                                                <input id="pin-code" type="text" name="pincode" class="form-control"
                                                    onkeypress="return isNumber(event)"
                                                    value={{ $shipping_address ? $shipping_address->spincode : '' }}>
                                                <div id="pincode_err" class="pincodeerr text-danger"
                                                    style="display:none;">This field is required</div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="com_name">Company name (optional)</label>
                                                        <input id="com_name" type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-4">
                                                    <div class="form-group">
                                                        <label for="country">Country <abbr class="required" title="required">*</abbr></label>
                                                        <select id="country" class="form-control wide">
                                                            <option>Bangladesh</option>
                                                            <option>Afghanistan</option>
                                                            <option>Albania</option>
                                                            <option>Algeria</option>
                                                            <option>Armenia</option>
                                                            <option>India</option>
                                                            <option>Pakistan</option>
                                                            <option>England</option>
                                                            <option>London</option>
                                                            <option>London</option>
                                                            <option>China</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="email">Email address <abbr class="required" title="required">*</abbr></label>
                                                        <input id="email" type="text" class="form-control">
                                                    </div>
                                                </div> -->
                                        <div id="CheckoutBillingAccordion2" class="col-md-12 mb-2">
                                            <div class="checkout-box" data-bs-toggle="collapse"
                                                data-bs-target="#CheckoutTwo" aria-expanded="false" role="toolbar">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input visually-hidden"
                                                        id="ship-to-different-address">
                                                    <label class="custom-control-label"
                                                        for="ship-to-different-address">Ship to a different
                                                        address?</label>
                                                </div>
                                            </div>

                                            <div id="CheckoutTwo" class="collapse"
                                                data-bs-parent="#CheckoutBillingAccordion2">
                                                <h2 class="title mt-0">Shipping Address</h2>
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <div class="form-group">
                                                            <label for="sf_name" class="mb-1">First name <span
                                                                    class="required" title="required">*</span></label>
                                                            <input id="sfirst_name" type="text" class="form-control">
                                                            <div id="pincode_err" class="sf_nameerr text-danger"
                                                                style="display:none;">This field is required</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <div class="form-group">
                                                            <label for="sl_name" class="mb-1">Last name</label>
                                                            <input id="slast_name" type="text" class="form-control">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-2">
                                                        <div class="form-group" class="mb-1">
                                                            <label for="phone">Phone Number <span class="required"
                                                                    title="required">*</span></label>
                                                            <input id="s-phone" minlength="10" maxlength="10"
                                                                onkeypress="return isNumber(event)" type="text"
                                                                class="form-control" required>
                                                            <div id="phone_err" class="checkout_err"></div>
                                                            <div id="pincode_err" class="s_phoneerr text-danger"
                                                                style="display:none;">This field is required</div>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-12 mb-4">
                                                                <div class="form-group">
                                                                    <label for="country2">Country <abbr class="required" title="required">*</abbr></label>
                                                                    <select id="country2" class="form-control wide">
                                                                        <option>Bangladesh</option>
                                                                        <option>Afghanistan</option>
                                                                        <option>Albania</option>
                                                                        <option>Algeria</option>
                                                                        <option>Armenia</option>
                                                                        <option>India</option>
                                                                        <option>Pakistan</option>
                                                                        <option>England</option>
                                                                        <option>London</option>
                                                                        <option>London</option>
                                                                        <option>China</option>
                                                                    </select>
                                                                </div>
                                                            </div> -->
                                                    <div class="col-md-12 mb-2">
                                                        <div class="form-group mb-2">
                                                            <label for="street-address2-3" class="mb-1">Address <span
                                                                    class="required" title="required">*</span></label>
                                                            <input id="s-address" type="text" class="form-control"
                                                                placeholder="House number and street name">
                                                            <div id="pincode_err" class="s_addresserr text-danger"
                                                                style="display:none;">This field is required</div>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label for="street-address2-2"
                                                                class="visually-hidden mb-1">Address 2 <span
                                                                    class="required" title="required">*</span></label>
                                                            <input id="s-address2" type="text" class="form-control"
                                                                placeholder="Apartment, suite, unit etc. (optional)">
                                                            <div id="pincode_err" class="pincodeerr text-danger"
                                                                style="display:none;">This field is required</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-2">
                                                        <div class="form-group">
                                                            <label for="town3" class="mb-1">Town / City <span
                                                                    class="required" title="required">*</span></label>
                                                            <input id="stown" type="text" class="form-control">
                                                            <div id="pincode_err" class="s_cityerr text-danger"
                                                                style="display:none;">This field is required</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <div class="form-group">
                                                            <label for="inputfState"
                                                                class=" control-label d-block mb-1">State <span
                                                                    class="color">*</span></label>
                                                            <select name="state" id="sstate"
                                                                class="form-control wide">
                                                                @foreach ($states as $id => $state)
                                                                    @if ($id == '31')
                                                                        {{ $selected = 'selected' }}
                                                                    @else
                                                                        {{ $selected = '' }}
                                                                    @endif
                                                                    <option {{ $selected }}
                                                                        value="{{ $id }}">{{ $state }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <div id="pincode_err" class="s_stateerr text-danger"
                                                                style="display:none;">This field is required</div>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-2">
                                                        <div class="form-group">
                                                            <label for="pz-code2" class="mb-1">Postcode / ZIP
                                                                (optional)</label>
                                                            <input id="spin-code" type="text" class="form-control"
                                                                onkeypress="return isNumber(event)">
                                                            <div id="pincode_err" class="s_pincodeerr text-danger"
                                                                style="display:none;">This field is required</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span id="shipping_serviceability" data-shipping="unavailable"></span>
                                        <!-- <div class="col-md-12">
                                                    <div class="form-group mb-0">
                                                        <label for="order-notes">Order notes (optional)</label>
                                                        <textarea id="order-notes" class="form-control"
                                                            placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                                    </div>
                                                </div> -->
                                    </div>
                                    <!-- </form> -->
                                </div>
                            </div>
                            <!--== End Billing Accordion ==-->
                        </div>
                        <div class="col-lg-6">
                            <!--== Start Order Details Accordion ==-->
                            <div class="checkout-order-details-wrap">
                                <div class="order-details-table-wrap table-responsive">
                                    <h5>Your Order</h5>

                                    <div class="render_payment_info">
                                        @include('frontend.pages.checkout.payment_info')
                                    </div>
                                    <!-- <h2 class="title mb-25">Your order</h2>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="product-name">Product</th>
                                                    <th class="product-total">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-body">
                                            @foreach ($products as $pro)
    <tr class="cart-item">
                                                    <td class="product-name">{{ $pro->product_name }}<span class="product-quantity"> × {{ $pro->product_qty }}</span></td>
                                                    <td class="product-total">₹ {{ $pro->product_qty * $pro->price }}</td>
                                                </tr>
    @endforeach
                                            </tbody>
                                            <tfoot class="table-foot">
                                                <tr class="cart-subtotal">
                                                    <th>Subtotal</th>
                                                    <td>₹ {{ $sub_amt }}</td>
                                                </tr>
                                                <tr class="shipping">
                                                    <th>Shipping</th>
                                                    <td>Flat rate: ₹ </td>
                                                </tr>
                                                <tr class="order-total">
                                                    <th>Total </th>

                                                </tr>
                                            </tfoot>
                                        </table> -->
                                    <div class="shop-payment-method">
                                        <div id="PaymentMethodAccordion">
                                            <!-- <div class="card">
                                                    <div class="card-header" id="check_payments">
                                                        <h5 class="title" data-bs-toggle="collapse" data-bs-target="#itemOne" aria-controls="itemOne" aria-expanded="true">Debit / Credit Card</h5>
                                                    </div>
                                                    <div id="itemOne" class="collapse show" aria-labelledby="check_payments" data-bs-parent="#PaymentMethodAccordion">
                                                        <div class="card-body">
                                                            <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.</p>
                                                        </div>
                                                    </div>
                                                </div> -->
                                            <!-- <div class="card">
                                                    <div class="card-header" id="check_payments2">
                                                        <h5 class="title" data-bs-toggle="collapse" data-bs-target="#itemTwo" aria-controls="itemTwo" aria-expanded="false">Check payments</h5>
                                                    </div>
                                                    <div id="itemTwo" class="collapse" aria-labelledby="check_payments2" data-bs-parent="#PaymentMethodAccordion">
                                                        <div class="card-body">
                                                            <p>Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
                                                        </div>
                                                    </div>
                                                </div> -->
                                            <div class="card">
                                                <!-- <div class="card-header" id="check_payments3">
                                                        <h5 class="title payment_mode" data-mode="cod" data-bs-toggle="collapse" data-bs-target="#itemThree" aria-controls="itemTwo" aria-expanded="false" value="COD">Cash on delivery</h5>

                                                    </div> -->

                                                <div id="itemThree" class="collapse" aria-labelledby="check_payments3"
                                                    data-bs-parent="#PaymentMethodAccordion">
                                                    <div class="card-body">
                                                        <!-- <p>Pay with cash upon delivery.</p> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="card">
                                                    <div class="card-header" id="check_payments4">
                                                        <h5 class="title payment_mode" data-mode="upi" data-bs-toggle="collapse" data-bs-target="#itemFour" aria-controls="itemFour" aria-expanded="false" value="UPI Payment">UPI Payment</h5>
                                                    </div>
                                                    <div id="itemFour" class="collapse" aria-labelledby="check_payments4" data-bs-parent="#PaymentMethodAccordion">
                                                        <div class="card-body">
                                                            <p>Pay with cash upon delivery.</p>
                                                        </div>
                                                    </div>
                                                </div> -->
                                            <!--<div class="card">
                                                    <div class="card-header" id="check_payments5">
                                                        <h5 class="title payment_mode" data-mode="cod" data-bs-toggle="collapse" data-bs-target="#itemFive" aria-controls="itemFive" aria-expanded="false" value="cod">COD</h5>
                                                    </div>
                                                    <span class="err_paymentstatus text-danger" style="display:none;">Please select the payment method</span>
                                                    <div id="itemFive" class="collapse" aria-labelledby="check_payments5" data-bs-parent="#PaymentMethodAccordion">
                                                        <div class="card-body">
                                                            <p> Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account. </p>
                                                        </div>
                                                    </div>
                                                </div>-->
                                            <!-- <div id="payment_err" class="checkout_err"></div> -->
                                            <!-- <div class="card">
                                                    <div class="card-header" id="check_payments4">
                                                        <h5 class="title" data-bs-toggle="collapse" data-bs-target="#itemFour" aria-controls="itemTwo" aria-expanded="false">PayPal Express Checkout</h5>
                                                    </div>
                                                    <div id="itemFour" class="collapse" aria-labelledby="check_payments4" data-bs-parent="#PaymentMethodAccordion">
                                                        <div class="card-body">
                                                            <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.</p>
                                                        </div>
                                                    </div>
                                                </div> -->

                                            <!-- <div class="card">
                                                    <input type="hidden" id="hidRazorKey" value="{{ env('RAZOR_KEY') }}">
                                                    <div class="card-header" id="check_payments5">
                                                        <h5 class="title payment_mode" data-mode="razorPay" data-bs-toggle="collapse" data-bs-target="#itemFive" aria-controls="itemFive" aria-expanded="false" value="Razor Pay">Razor pay - (Credit Card / Debit Card / UPI)</h5>
                                                    </div>
                                                    <span class="err_paymentstatus text-danger" style="display:none;">Please select the payment method</span>
                                                    <div id="itemFive" class="collapse" aria-labelledby="check_payments5" data-bs-parent="#PaymentMethodAccordion">
                                                    </div>
                                                </div>-->

                                        </div>

                                        <div class="payment-container">
                                            <input type="hidden" id="hidRazorKey" value="{{ env('RAZOR_KEY') }}">
                                            <h2>Payment</h2>
                                            <p>All transactions are secure and encrypted.</p>
                                            <div class="payment-option">
                                                <input type="radio" id="option2" name="payment-method"
                                                    class="radio payment_mode" data-mode="cod" aria-expanded="false"
                                                    value="cod" checked>
                                                <label for="option2">
                                                    <div class="payment-detail">
                                                        <img src="https://support.sitegiant.com/wp-content/uploads/2022/08/cash-on-delivery-banner.png"
                                                            alt="">

                                                    </div>

                                                </label>
                                            </div>

                                            <span class="err_paymentstatus text-danger" style="display:none;">Please
                                                select the payment method</span>
                                            <div id="itemFive" class="collapse" aria-labelledby="check_payments5"
                                                data-bs-parent="#PaymentMethodAccordion">
                                            </div>
                                        </div>

                                        <p class="p-text">Your personal data will be used to process your order, support
                                            your experience throughout this website</p>
                                        <div class="agree-policy mb-4">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" id="privacy"
                                                    class="custom-control-input visually-hidden">
                                                <label for="privacy" class="custom-control-label">I have read and agree
                                                    to the website terms and conditions <span
                                                        class="required">*</span></label>
                                                <div id="err_terms_conditions" class="err_terms_conditions text-danger"
                                                    style="display:none;">Please check the policy</div>
                                            </div>
                                        </div>
                                        <button type="button" class="default-btn w-100 proceed_to_checkout"
                                            id="place_order">Place order</button>
                                        <!-- <a href="account.html" class="btn-place-order">Place order</a> -->
                                    </div>
                                </div>
                            </div>
                            <!--== End Order Details Accordion ==-->

                        </div>
                        <!-- </form>  -->
                    </div>

                </div>
        </section>
        <!--== End Shopping Checkout Area Wrapper ==-->

    </main>

    <form method="post" name="redirect" action="" id="redirect">
        <input type=hidden id="encRequest" name="encRequest" value="">
        <input type=hidden id="access_code" name="access_code" value="">
    </form>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('privacy');
        checkbox.checked = true;
        checkbox.addEventListener('click', function(e) {
            e.preventDefault();
            this.checked = true;
        });
    });

    function productgstchange() {
        $("#productcolorsvarients").html('')

        var token = $('meta[name="csrf-token"]').attr('content');
        var path = $('meta[name="base_url"]').attr('content') + '/getproductgst';

        $(".others").css('display', 'none');
        $(".tamilnadu").css('display', 'none');
        $.ajax({
            url: path,
            type: "GET",
            data: {
                _token: token,
                state: $("#state").val(),
                amount: $("#sub_amount").val(),
                deliver_charge: $("#deliver_charge").val(),
                discountvalus: $("#discountvalus").val(),
            },
            success: function(response) {

                if (response != '') {
                    console.log(response.data);
                    var gst = response.data.gst_amount / 2;
                    var state1 = response.data.state;
                    /* if(state1==31){
                         $(".tamilnadu").show();
                          $(".others").hide();
                          $("#gst1").html(gst)
                         $("#gst2").html(gst)

                     }else{
                         $(".others").show();
                          $(".tamilnadu").hide();
                          $("#gst_amount").html(response.data.gst_amount1)
                          $("#gst").html(response.data.gst_amount)
                     }*/

                    $("#gst_amount").html(response.data.gst_amount1)
                    $("#gst").html(response.data.gst_amount)

                    $("#shipping_charge").val(response.data.gst_amount)
                    $("#newamount").html(response.data.totalamount)

                    $("#ship_discount_amount").val(response.data.shipping_dis_amount)
                    $("#ship_discount_amount1").html(response.data.shipping_dis_amount)

                    $("#deliver_charge").val(response.data.deliver_charge)
                    $("#shipping_amount").html(response.data.deliver_charge)
                }
            }
        });
    }

    window.onload = function() {
        productgstchange();

    };

    // window.onbeforeunload = function() {
    //         return "Please don't refresh";
    //     }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#phone').on('paste', function(event) {
            var pastedText = (event.originalEvent.clipboardData || window.clipboardData).getData(
            'text');
            var cleanText = pastedText.replace(/\D+/g, ''); // Remove all non-numeric characters

            if (pastedText !== cleanText) {}

            event.preventDefault();
            $(this).val(cleanText);
        });
    });
</script>
<script>
    var field = document.querySelector('[name="phone","pincode"]');

    field.addEventListener('keypress', function(event) {
        var key = event.keyCode;
        if (key === 32) {
            event.preventDefault();
        }
    });
</script>
<style>
    .payment-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .payment-container h2 {
        margin-top: 0;
    }

    .payment-container .payment-option {
        margin-bottom: 20px;
        border: 1px solid lightgrey;
        border-radius: 5px;
        display: flex;
        padding: 10px;
        align-items: flex-start;
    }

    .payment-container .payment-option label {
        display: flex;
        cursor: pointer;
        flex-direction: column;
        justify-content: flex-start;
    }

    .payment-container .payment-option input {
        margin-right: 10px;
    }

    .payment-container .icons {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    .payment-container .icons img {
        margin-right: 10px;
        width: 50px;
    }

    .payment-container .icons span {
        margin-left: 5px;
    }

    .payment-container .razorpay-info {
        margin-left: 36px;
        color: #666;
    }

    .payment-container label div {
        display: table-row;
    }

    .payment-container .payment-detail {
        margin-bottom: 10px;
        display: flex;
        flex-direction: row;
    }

    .payment-container .payment-detail-desc {
        border-left: 2px solid grey;
        margin-left: 10px;
        padding-left: 10px;
        font-weight: bold;
    }

    .payment-container .payment-option .radio {
        margin-top: 10px;
        width: 25px;
    }

    .payment-container .payment-detail img {
        width: 150px;
    }

    @media only screen and (max-width: 425px) {
        .payment-container .payment-detail img {
            width: 140px;
        }

        .payment-container .payment-detail {
            flex-wrap: wrap;
        }

        .payment-container .payment-detail-desc {
            border: none;
            margin-left: 0px;
            padding-left: 0px;
        }
    }
</style>

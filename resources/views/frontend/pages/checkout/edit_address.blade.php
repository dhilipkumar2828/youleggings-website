@extends('frontend.layouts.arrivals_products_master_new')

@section('content')
    <style>
        .wrapper {
            overflow-x: initial !important;
        }

        .nice-select .list {
            height: 200px !important;
            overflow-y: scroll !important;
        }
    </style>
    <main class="main-content">

        <!--== Start Page Header Area Wrapper ==-->
        <section class="page-header-area pt-10 pb-9" data-bg-color="#FFF3DA">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <div class="page-header-st3-content text-center text-md-start">
                            <ol class="breadcrumb justify-content-center justify-content-md-start">
                                <li class="breadcrumb-item"><a class="text-dark" href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active text-dark" aria-current="page">Edit Address</li>
                            </ol>
                            <h2 class="page-header-title">Edit Address</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--== End Page Header Area Wrapper ==-->

        <!--== Start Shopping Checkout Area Wrapper ==-->
        <section class="shopping-checkout-wrap section-space" style="padding-top: 25px;">
            <div class="container">
                <div class="checkout-page-coupon-wrap">
                    <!--== Start Checkout Coupon Accordion ==-->
                    <div class="coupon-accordion" id="CouponAccordion">
                        <div class="card">

                            <div id="couponaccordion" class="collapse" data-bs-parent="#CouponAccordion">
                                <div class="card-body">
                                    <div class="apply-coupon-wrap">
                                        <p>If you have a coupon code, please apply it below.</p>
                                        <form action="#" method="post">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text"
                                                            placeholder="Coupon code">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="button" class="btn-coupon">Apply coupon</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--== End Checkout Coupon Accordion ==-->
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <!--== Start Billing Accordion ==-->
                        <div class="checkout-billing-details-wrap">
                            <h2 class="title mt-0">Edit Address</h2>
                            <div class="billing-form-wrap">
                                <form action="{{ url('update_address') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="f_name">First name <abbr class="required"
                                                        title="required">*</abbr></label>
                                                @if ($type == 'billing')
                                                    <input id="f_name" type="text" name="first_name"
                                                        value=" {{ isset($address->first_name) ? $address->first_name : '' }}"
                                                        class="form-control">
                                                    <input type="hidden" name="type" value="billing">
                                                @else
                                                    <input id="f_name" type="text" name="sfirst_name"
                                                        value=" {{ isset($address->sfirst_name) ? $address->sfirst_name : '' }}"
                                                        class="form-control">
                                                    <input type="hidden" name="type" value="shipping">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="l_name">Last name <abbr class="required"
                                                        title="required">*</abbr></label>
                                                @if ($type == 'billing')
                                                    <input id="l_name" type="text" name="last_name"
                                                        value="{{ isset($address->last_name) ? $address->last_name : '' }}"
                                                        class="form-control">
                                                @else
                                                    <input id="l_name" type="text" name="slast_name"
                                                        value="{{ isset($address->slast_name) ? $address->slast_name : '' }}"
                                                        class="form-control">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="phone">Phone Number</label>
                                                @if ($type == 'billing')
                                                    <input id="type" type="text" name="phone_number"
                                                        value="{{ isset($address->phone_number) ? $address->phone_number : '' }}"
                                                        class="form-control">
                                                @else
                                                    <input id="phone" type="text" name="sphone_number"
                                                        value="{{ isset($address->sphone_number) ? $address->sphone_number : '' }}"
                                                        class="form-control" required>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="street-address">Address <abbr class="required"
                                                        title="required">*</abbr></label>
                                                @if ($type == 'billing')
                                                    <input id="street-address" type="text" name="street_1"
                                                        value="{{ isset($address->street_1) ? $address->street_1 : '' }}"
                                                        class="form-control" placeholder="House number and street name">
                                                @else
                                                    <input id="street-address" type="text" name="sstreet_1"
                                                        value="{{ isset($address->sstreet_1) ? $address->sstreet_1 : '' }}"
                                                        class="form-control" placeholder="House number and street name">
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="street-address2" class="visually-hidden">Street address 2
                                                    <abbr class="required" title="required">*</abbr></label>
                                                @if ($type == 'billing')
                                                    <input id="street-address2" name="street_2" type="text"
                                                        class="form-control"
                                                        value="{{ isset($address->street_2) ? $address->street_2 : '' }}"
                                                        placeholder="Apartment, suite, unit etc. (optional)">
                                                @else
                                                    <input id="street-address" name="sstreet_2" type="stext"
                                                        value="{{ isset($address->sstreet_1) ? $address->sstreet_1 : '' }}"
                                                        class="form-control" placeholder="House number and street name">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="town">Town / City <abbr class="required"
                                                        title="required">*</abbr></label>
                                                @if ($type == 'billing')
                                                    <input id="town" type="text" name="city"
                                                        value="{{ isset($address->city) ? $address->city : '' }}"class="form-control">
                                                @else
                                                    <input id="town" type="text" name="scity"
                                                        value="{{ isset($address->scity) ? $address->scity : '' }}"class="form-control">
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-4">
                                            <div class="form-group">
                                                <label for="district" class="d-block">State <abbr class="required"
                                                        title="required">*</abbr></label>
                                                @if ($type == 'billing')
                                                    <select name="state" id="state" class="form-control wide">
                                                    @else
                                                        <select name="sstate" id="state" class="form-control wide">
                                                @endif

                                                @foreach ($states as $state)
                                                    @if ($type == 'billing')
                                                        <option value="{{ $state->id }}"
                                                            {{ $address->state == $state->id ? 'selected' : '' }}>
                                                            {{ $state->state }}</option>
                                                    @else
                                                        <option value="{{ $state->id }}"
                                                            {{ $address->sstate == $state->id ? 'selected' : '' }}>
                                                            {{ $state->state }}</option>
                                                    @endif
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="pz-code">Pincode</label>
                                                @if ($type == 'billing')
                                                    <input id="pz-code" type="text" name="pincode"
                                                        value="{{ isset($address->pincode) ? $address->pincode : '' }}"
                                                        class="form-control">
                                                @else
                                                    <input id="pz-code" type="text" name="spincode"
                                                        value="{{ isset($address->spincode) ? $address->spincode : '' }}"
                                                        class="form-control">
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--== End Billing Accordion ==-->
                    </div>

                </div>
            </div>
        </section>
        <!--== End Shopping Checkout Area Wrapper ==-->

    </main>
@endsection

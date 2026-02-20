@extends('frontend.layouts.arrivals_products_master')

@section('content')
    <main class="main-content">

        <!--== Start Page Header Area Wrapper ==-->

        <section class="page-header-area">

            <div class="container">

                <!-- style="margin-top:100px;" -->

                <div class="row">

                    <div class="col-md-6">

                        <div class="page-header-st3-content">

                            <h2 class="page-header-title">Forget Password</h2>

                        </div>

                    </div>

                    <div class="col-md-6 justify-content-end d-flex">

                        <div class="page-header-st3-content">

                            <ol class="breadcrumb justify-content-center justify-content-md-start">

                                <li class="breadcrumb-item"><a class="text-dark" href="{{ url('index') }}">Home</a></li>

                                <li class="breadcrumb-item active text-dark" aria-current="page">Forget Paassword</li>

                            </ol>

                        </div>

                    </div>

                </div>

            </div>

        </section>

        </div>

        <!-- PRODUCT DETAILS AREA START -->

        <div class="ltn__product-area ltn__product-gutter mb-60">

            <div class="container" style="display:none" id="hide_code">

                <div class="row">

                    <div class="col-lg-12">

                        <div class="account-login-inner" style="width: 100%; text-align: -webkit-center;">

                            <p class="text-center" style="color:green;">Generated Password sended to your Phone Number.</p>

                            <div class="btn-wrapper mt-30">

                                <a href="{{ url('user/auth') }}">

                                    <button class="theme-btn-1 btn btn-block" type="button">Login</button>

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="container" id="hide_email">

                <div class="row">

                    <div class="col-lg-12">

                        <div class="account-login-inner" style="width: 100%; text-align: -webkit-center;">

                            <form class="ltn__form-box contact-form-box pb-50 pt-50" method="POST" style="width: 50%; ">

                                <!-- <label for="login_username">Email <sup>*</sup></label> -->

                                <input type="email" id="forget_email" class="form-control mb-3"
                                    placeholder="Enter your phone" name="phone">

                                <span class="forget_email_err text-danger" style="display:none;">This field is
                                    required</span>

                                <div class="btn-wrapper mt-30">

                                    <button class="theme-btn-1 btn btn-block" type="button"
                                        id="submit_email">Submit</button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- PRODUCT DETAILS AREA END -->

    </main>
@endsection

@section('script')
@endsection

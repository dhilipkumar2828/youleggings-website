@extends('frontend.layouts.master')

@section('content')
    <div class="ltn__feature-area section-bg-1 pt-200 pb-30">

        <div class="container">

            <div class="row">

                <div class="col-lg-12">

                    <div class="section-title-area ltn__section-title-2 text-center">

                        <h5 class="section-title about-us-title" style="font-size: 34px;">Your Order has been placed<span>
                                !</span></h5>

                    </div>

                </div>

            </div>

            <div class="row justify-content-center">

                <div class="col-lg-8 col-sm-8 col-12">

                    <div class="ltn__feature-item ltn__feature-item-10">

                        <div class="ltn__feature-info">

                            <img src="{{ asset('frontend/img/about/gif-2.gif') }}" alt="Completed"
                                style="width:90px;height:90px;">

                            <!-- <img src="{{ asset('frontend/img/about/development.png') }}" alt="#"> -->

                            <br>

                            <br>

                            <p><b>Order ID : </b> {{ $order_id }}</p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection

@section('script')
@endsection

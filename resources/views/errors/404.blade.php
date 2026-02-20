@extends('frontend.layouts.arrivals_products_master')

@section('content')
    <main class="main-content">

        <!--== Start Hero Area Wrapper ==-->

        <!--<section class="hero-two-slider-area position-relative">-->

        <div class="container mb-4">

            <div class="row">

                <div class="col-md-12">

                    <div class="page-not-found">

                        <img src="{{ asset('frontend/img/photos/page_not_found.jpg') }}" style="width:90%;" alt="Image">

                        <!--<h3 class="title">Opps! You Lost</h3>-->

                        <button class="btn btn-primary">Go to <a href="{{ url('index') }}">Home</a> Page</button>

                    </div>

                </div>

            </div>

        </div>

        <!--</section>-->

        <!--== End Faq Area Wrapper ==-->

    </main>
@endsection

@extends('frontend.layouts.arrivals_products_master')

@section('content')
    <main class="main-content">

        <!--== Start Page Header Area Wrapper ==-->

        <nav aria-label="breadcrumb" class="breadcrumb-style1">

            <div class="container">

                <ol class="breadcrumb justify-content-center">

                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>

                    <li class="breadcrumb-item active" aria-current="page">Faq</li>

                </ol>

            </div>

        </nav>

        <!--== Start Faq Area Wrapper ==-->

        <section class="faq-area section-padding">

            <div class="container">

                <div class="row flex-xl-row-reverse align-items-center">

                    <div class="col-lg-6 col-xl-7">

                        <div class="faq-thumb">

                            <img src="{{ asset('frontend/img/photos/faq-home.webp') }}" width="601" height="368"
                                alt="Image" class="img-fluid rounded shadow-sm">

                        </div>

                    </div>

                    <div class="col-lg-6 col-xl-5">

                        <div class="faq-content">

                            <div class="faq-text-img"><img src="{{ asset('frontend/img/photos/faq.webp') }}" width="199"
                                    height="169" alt="Image"></div>

                            <h2 class="faq-title fw-bold">Frequently Asked Questions</h2>

                            <div class="faq-line mb-4" style="width: 60px; height: 3px; background: #000;"></div>

                            <p class="faq-desc text-muted">Find answers to our most common questions below. If you can't find what you're looking for, please contact our support team.</p>

                        </div>

                    </div>

                </div>

                <div class="row mt-5">

                    <div class="col-12">

                        <div class="faq-dynamic-content bg-white p-4 rounded shadow-sm">
                            @if(isset($faqss) && $faqss->description)
                                {!! $faqss->description !!}
                            @else
                                <div class="text-center py-5">
                                    <h4 class="text-muted">No FAQ content available yet.</h4>
                                    <p>Please check back later or contact us for assistance.</p>
                                </div>
                            @endif
                        </div>

                    </div>

                </div>

            </div>

        </section>

        <!--== End Faq Area Wrapper ==-->

    </main>
@endsection

@section('script')
@endsection

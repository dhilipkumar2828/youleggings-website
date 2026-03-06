@extends('frontend.layouts.arrivals_products_master_new')

@section('content') 
    <main class="main-content">

        <!-- HEADER -->
        <section class="py-5 about-bgjpg">
            <div class="container">
                <div class="row d-flex align-items-center">

                    <div class="col-md-6 text-white">
                        <h2 class="text-white mb-5">{{ $abouts->promise_desc ?? 'At You Legging, we believe every woman deserves comfort without compromise. Born from the legacy of TANTEX.' }}</h2>

                        <p>Our leggings are crafted with premium fabrics, designed to offer:</p>
                        <ul class="about-list">
                            <li><i class="fa fa-check"></i> {{ $abouts->why_choose_1_title ?? 'A perfect fit that flatters every body type' }}</li>
                            <li><i class="fa fa-check"></i> {{ $abouts->why_choose_2_title ?? 'Stretch that adapts to your lifestyle' }}</li>
                            <li><i class="fa fa-check"></i> {{ $abouts->why_choose_3_title ?? 'Durability that lasts wash after wash' }}</li>
                        </ul>

                        <p class="mt-5">{!! $abouts->description ?? 'Whether you are at work, running errands, or relaxing at home, You Legging moves with you.' !!}</p>
                    </div>

                    <div class="col-md-6 mb-4">
                        <img class="rounded" src="{{ isset($abouts->photo) ? asset('uploads/about/'.$abouts->photo) : 'https://you.oceansoftwares.in/demo/frontend/img/about-banner.png' }}" />
                    </div>

                </div>
            </div>
        </section>

        <!-- WHY CHOOSE US -->
        <section class="py-5 bg-light">
            <div class="container">

                <div class="row d-flex align-items-center aboutall mt-5">

                    <div class="col-md-12 text-center">
                        <h2 class="fw-bold mb-4">Why Choose You Leggings?</h2>
                    </div>
                </div>

                <div class="row d-flex align-items-center justify-content-center aboutall mb-0 mt-5 pb-5">
                    @for($i=1; $i<=5; $i++)
                      @php 
                          $tField = "why_choose_{$i}_title"; 
                          $dField = "why_choose_{$i}_desc";
                          $defaultTitles = [1=>'From TANTEX Legacy', 2=>'Zero Compromise Quality', 3=>'Affordable Luxury', 4=>'Everyday Versatility', 5=>'Wide Range of Choices'];
                          $defaultDescs = [1=>'A brand you already trust', 2=>'Premium fabrics, tested for durability', 3=>'High-end feel at market-friendly prices', 4=>'Designed for work, play, and everything in between', 5=>'Colors, styles, and fits for every woman'];
                      @endphp
                      <div class="col-md-4 mb-5 pb-5">
                          <h3>{{ $abouts->$tField ?? $defaultTitles[$i] }}</h3>
                          <p>{{ $abouts->$dField ?? $defaultDescs[$i] }}</p>
                      </div>
                    @endfor
                </div>

            </div>
        </section>

    </main>
@endsection

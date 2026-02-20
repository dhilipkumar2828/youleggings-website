@extends('frontend.layouts.arrivals_products_master_new')

@section('content')
    <style>
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
                            <h2 class="page-header-title">Wishlist</h2>
                        </div>
                    </div>

                    <div class="col-md-6 justify-content-end d-flex">
                        <div class="page-header-st3-content">
                            <ol class="breadcrumb justify-content-center justify-content-md-start">
                                <li class="breadcrumb-item"><a class="text-dark" href="{{ url('index') }}">Home</a></li>
                                <li class="breadcrumb-item active text-dark" aria-current="page">Wishlist</li>
                            </ol>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!--== Start Page Header Area Wrapper ==-->

        <section class="page-header-area pt-1 pb-1 d-none" data-bg-color="#FFF3DA">

            <div class="container">

                <div class="row">

                    <div class="col-md-5">

                        <div class="page-header-st3-content text-center text-md-start">

                            <ol class="breadcrumb justify-content-center justify-content-md-start">

                                <li class="breadcrumb-item"><a class="text-dark" href="index.html">Home</a></li>

                                <li class="breadcrumb-item active text-dark" aria-current="page">Wishlist</li>

                            </ol>

                            <h2 class="page-header-title">Wishlist</h2>

                        </div>

                    </div>

                    <div class="col-md-7">
                        @if (Auth::guard('customer')->check())
                            <h5 class="showing-pagination-results mt-md-9 text-center text-md-end">Showing
                                {{ count($wishlist) }} Results</h5>
                        @else
                            <h5 class="showing-pagination-results mt-md-9 text-center text-md-end">Showing 0 Results</h5>
                        @endif

                    </div>

                </div>

            </div>

        </section>

        <!--== End Page Header Area Wrapper ==-->

        @include('frontend.wishlist_table')

    </main>
@endsection

@section('script')
@endsection

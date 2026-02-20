@extends('frontend.layouts.arrivals_products_master_new')
@section('content')
    <style>
        .hh-grayBox {
            background-color: #F8F8F8;
            margin-bottom: 20px;
            padding: 35px;
            margin-top: 20px;
        }

        .pt45 {
            padding-top: 45px;
        }

        .order-tracking {
            text-align: center;
            width: 25%;
            position: relative;
            display: block;
        }

        .order-tracking .is-complete {
            display: block;
            position: relative;
            border-radius: 50%;
            height: 30px;
            width: 30px;
            border: 0px solid #AFAFAF;
            background-color: #f7be16;
            margin: 0 auto;
            transition: background 0.25s linear;
            -webkit-transition: background 0.25s linear;
            z-index: 2;
        }

        .order-tracking .is-complete:after {
            display: block;
            position: absolute;
            content: '';
            height: 14px;
            width: 7px;
            top: -2px;
            bottom: 0;
            left: 5px;
            margin: auto 0;
            border: 0px solid #AFAFAF;
            border-width: 0px 2px 2px 0;
            transform: rotate(45deg);
            opacity: 0;
        }

        .order-tracking.completed .is-complete {
            border-color: #27aa80;
            border-width: 0px;
            background-color: #27aa80;
        }

        .order-tracking.completed .is-complete:after {
            border-color: #fff;
            border-width: 0px 3px 3px 0;
            width: 7px;
            left: 11px;
            opacity: 1;
        }

        .order-tracking p {
            color: #A4A4A4;
            font-size: 16px;
            margin-top: 8px;
            margin-bottom: 0;
            line-height: 20px;
        }

        .order-tracking p span {
            font-size: 14px;
        }

        .order-tracking.completed p {
            color: #000;
        }

        .order-tracking::before {
            content: '';
            display: block;
            height: 3px;
            width: calc(100% - 40px);
            background-color: #f7be16;
            top: 13px;
            position: absolute;
            left: calc(-50% + 20px);
            z-index: 0;
        }

        .order-tracking:first-child:before {
            display: none;
        }

        .order-tracking.completed:before {
            background-color: #27aa80;
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

    <body>
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
        <!-- partial:index.partial.html -->
        <div class="container">
            <div class="row justify-center text-center">

                <div class="col-12 hh-grayBox mt-4 mb-4 pt40 pb20">
                    <h5 class="mb-3 text-center" style="font-weight:700;">Order Tracking</h5>
                    <hr class="mb-3"><br>
                    @if (!empty($order))
                        <div class="mt-3 row justify-content-between">
                            <div
                                class="order-tracking {{ $order->status == 'Received' || $order->status == 'Confirmed' || $order->status == 'Processing' || $order->status == 'Delivered' ? 'completed' : '' }}">
                                <span class="is-complete"></span>
                                <p>Ordered Placed<br><span>{{ date('d-m-Y', strtotime($order->created_at)) }}</span></p>
                            </div>
                            <div
                                class="order-tracking {{ $order->status == 'Confirmed' || $order->status == 'Processing' || $order->status == 'Delivered' ? 'completed' : '' }}">
                                <span class="is-complete"></span>
                                <p>Ordered
                                    Unfullied<br><span>{{ $order->status == 'Confirmed' ? date('d-m-Y', strtotime($order->updated_at)) : '' }}</span>
                                </p>
                            </div>
                            <div
                                class="order-tracking {{ $order->status == 'Processing' || $order->status == 'Delivered' ? 'completed' : '' }}">
                                <span class="is-complete"></span>
                                <p>Yet to
                                    Dispatched<br><span>{{ $order->status == 'Processing' ? date('d-m-Y', strtotime($order->updated_at)) : '' }}</span>
                                </p>
                            </div>
                            <div class="order-tracking {{ $order->status == 'Delivered' ? 'completed' : '' }}">
                                <span class="is-complete"></span>
                                <p>Dispatched
                                    Order<br><span>{{ $order->status == 'Delivered' ? date('d-m-Y', strtotime($order->updated_at)) : '' }}</span>
                                </p>
                            </div>
                        </div>
                    @else
                        <p>Invalid Order Id</p>
                    @endif
                </div>
            </div>
        </div>
    @endsection

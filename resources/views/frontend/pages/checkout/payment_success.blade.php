@extends('frontend.layouts.arrivals_products_master_new')

@section('content')
    <style>
        .main-container {

            width: 100%;

            height: 100%;

            display: flex;

            flex-flow: column;

            justify-content: center;

            align-items: center;

        }

        .check-container {

            width: 6.25rem;

            height: 7.5rem;

            display: flex;

            flex-flow: column;

            align-items: center;

            justify-content: space-between;

        }

        .check-container .check-background {

            width: 100%;

            height: calc(100% - 1.25rem);

            background: linear-gradient(to bottom right, #5de593, #41d67c);

            box-shadow: 0px 0px 0px 65px rgba(255, 255, 255, 0.25) inset, 0px 0px 0px 65px rgba(255, 255, 255, 0.25) inset;

            transform: scale(0.84);

            border-radius: 50%;

            animation: animateContainer 0.75s ease-out forwards 0.75s;

            display: flex;

            align-items: center;

            justify-content: center;

            opacity: 0;

        }

        .check-container .check-background svg {

            width: 65%;

            transform: translateY(0.25rem);

            stroke-dasharray: 80;

            stroke-dashoffset: 80;

            animation: animateCheck 0.35s forwards 1.25s ease-out;

        }

        .check-container .check-shadow {

            bottom: calc(-15% - 5px);

            left: 0;

            border-radius: 50%;

            background: radial-gradient(closest-side, rgba(73, 218, 131, 1), transparent);

            animation: animateShadow 0.75s ease-out forwards 0.75s;

        }

        @keyframes animateContainer {

            0% {

                opacity: 0;

                transform: scale(0);

                box-shadow: 0px 0px 0px 65px rgba(255, 255, 255, 0.25) inset, 0px 0px 0px 65px rgba(255, 255, 255, 0.25) inset;

            }

            25% {

                opacity: 1;

                transform: scale(0.9);

                box-shadow: 0px 0px 0px 65px rgba(255, 255, 255, 0.25) inset, 0px 0px 0px 65px rgba(255, 255, 255, 0.25) inset;

            }

            43.75% {

                transform: scale(1.15);

                box-shadow: 0px 0px 0px 43.334px rgba(255, 255, 255, 0.25) inset, 0px 0px 0px 65px rgba(255, 255, 255, 0.25) inset;

            }

            62.5% {

                transform: scale(1);

                box-shadow: 0px 0px 0px 0px rgba(255, 255, 255, 0.25) inset, 0px 0px 0px 21.667px rgba(255, 255, 255, 0.25) inset;

            }

            81.25% {

                box-shadow: 0px 0px 0px 0px rgba(255, 255, 255, 0.25) inset, 0px 0px 0px 0px rgba(255, 255, 255, 0.25) inset;

            }

            100% {

                opacity: 1;

                box-shadow: 0px 0px 0px 0px rgba(255, 255, 255, 0.25) inset, 0px 0px 0px 0px rgba(255, 255, 255, 0.25) inset;

            }

        }

        @keyframes animateCheck {

            from {

                stroke-dashoffset: 80;

            }

            to {

                stroke-dashoffset: 0;

            }

        }

        @keyframes animateShadow {

            0% {

                opacity: 0;

                width: 100%;

                height: 15%;

            }

            25% {

                opacity: 0.25;

            }

            43.75% {

                width: 40%;

                height: 7%;

                opacity: 0.35;

            }

            100% {

                width: 85%;

                height: 15%;

                opacity: 0.25;

            }

        }
    </style>

    <main class="main-content">

        <div class="container"
            style="margin-top:5%; margin-bottom:5%; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px; padding: 10px">

            <div class="row">

                <div class="box">

                    <div class="">

                        <div class="main-container">

                            <div class="check-container mt-4">

                                <div class="check-background">

                                    <svg viewBox="0 0 65 51" fill="none" xmlns="http://www.w3.org/2000/svg">

                                        <path d="M7 25L27.3077 44L58.5 7" stroke="white" stroke-width="13"
                                            stroke-linecap="round" stroke-linejoin="round" />

                                    </svg>

                                </div>

                                <div class="check-shadow"></div>

                            </div>

                        </div>

                    </div>

                    <div class="jumbotron">

                        <h2 class="text-center">Thank you! </h2>

                        <p class="text-center">Your Products will be shipped as soon as possible</p>

                        <!--<p class="text-center">Your Payment has been Successful. Your Products will be shipped as soon as possible</p>-->

                        <p class="text-center "><b>Your order id is: <span
                                    style="color:#6DA93E">{{ $order_id }}</span></b></p>

                        <p class="text-center h6 mb-3"><b>Amount: ₹{{ $amount }}</b></p>

                        <center>
                            <div class="btn-group" style="margin-bottom:50px;">

                                <a href="{{ url('customer/my_account') }}" class="btn btn-lg btn-warning">CONTINUE</a>

                            </div>
                        </center>

                    </div>

                </div>

            </div>

        </div>

    </main>
@endsection

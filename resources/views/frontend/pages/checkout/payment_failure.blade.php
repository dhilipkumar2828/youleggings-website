<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Payment unsuccessfull</title>

</head>

<body style="background:#F7D4CE;">

    <div class="container" style="margin-top:5%;">

        <div class="row">

            <div class="jumbotron p-5 rounded bg-white" style="box-shadow: 2px 2px 4px #000000;">

                <div class="text-center">

                    <img src="{{ 'frontend/img/error-img.gif' }}" alt="" class="img-fluid w-25">

                </div>

                <h2 class="text-center">Your Payment has been UnSuccessful. </h2>

                <center>
                    <div class="btn-group" style="margin-top:50px;">

                        <a href="{{ url('customer/my_account') }}" class="btn btn-lg btn-warning">CONTINUE</a>

                    </div>
                </center>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>

@extends('frontend.layouts.arrivals_products_master')

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

                <div class="">

                    <div class="main-container">

                        <img src="{{ 'frontend/img/error-img.gif' }}" alt="" class="img-fluid w-25">

                    </div>

                </div>

                <div class="jumbotron p-5 ">

                    <h2 class="text-center">Your Payment has been UnSuccessful. </h2>

                    <center>
                        <div class="btn-group" style="margin-top:50px;">

                            <a href="{{ url('customer/my_account') }}" class="btn btn-lg btn-warning">CONTINUE</a>

                        </div>
                    </center>

                </div>

            </div>

        </div>

    </main>
@endsection

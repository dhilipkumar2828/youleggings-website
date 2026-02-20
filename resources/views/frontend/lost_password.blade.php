@extends('frontend.layouts.arrivals_products_master')

@section('content')
    <style>

    </style>

    <main class="main-content">

        <!--== Start Page Header Area Wrapper ==-->

        <!--== Start Page Header Area Wrapper ==-->

        <section class="page-header-area pt-1 pb-1" data-bg-color="#FFF3DA">

            <div class="container">

                <div class="row">

                    <div class="col-md-5">

                        <div class="page-header-st3-content text-center text-md-start">

                            <ol class="breadcrumb justify-content-md-start">

                                <li class="breadcrumb-item"><a class="text-dark" href="index.html">Home</a></li>

                                <li class="breadcrumb-item active text-dark" aria-current="page">Lost Password</li>

                            </ol>

                            <h2 class="page-header-title">Lost Password</h2>

                        </div>

                    </div>

                </div>

            </div>

        </section>

        <section class="my-account-area section-space padd-tb-30">

            <div class="container" style="text-align:center">

                <div class="box">

                    <div class="tab">

                        <button class="tablinks active" onclick="openCity(event, 'Email')">Email</button>

                        <button class="tablinks" onclick="openCity(event, 'Phone')">Phone</button>

                    </div>

                    <div id="Email" class="tabcontent active">

                        <form action="{{ url('create_lostpassword') }}" class="form-horizontal" method="POST">

                            {{ csrf_field() }}

                            <div class="row">

                                <div class="form-group mb-6">

                                    <label>Enter the Registered Mail :</label>

                                    <input type="hidden" name="type" value="email">

                                    <input type="email" id="email" name="email" class="form-control" required>

                                </div>

                                <div class="form-group">

                                    <button type="submit" class="btn">Send Password</button>

                                </div>

                            </div>

                        </form>

                    </div>

                    <div id="Phone" class="tabcontent">

                        <form action="{{ url('create_lostpassword') }}" class="form-horizontal" method="POST">

                            {{ csrf_field() }}

                            <div class="row">

                                <div class="form-group mb-6">

                                    <label>Enter the Registered Phone Number :</label>

                                    <input type="hidden" name="type" value="phone">

                                    <input type="tel" id="phone" name="phone" class="form-control" required>

                                </div>

                                <div class="form-group">

                                    <button type="submit" class="btn">Send Password</button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </section>

    </main>

    <script>
        function openCity(evt, cityName) {

            var i, tabcontent, tablinks;

            tabcontent = document.getElementsByClassName("tabcontent");

            for (i = 0; i < tabcontent.length; i++) {

                tabcontent[i].style.display = "none";

            }

            tablinks = document.getElementsByClassName("tablinks");

            for (i = 0; i < tablinks.length; i++) {

                tablinks[i].className = tablinks[i].className.replace(" active", "");

            }

            document.getElementById(cityName).style.display = "block";

            evt.currentTarget.className += " active";

        }
    </script>
@endsection

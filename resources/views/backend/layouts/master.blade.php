<!DOCTYPE html>
<html lang="en">

<head>
    @include('backend.layouts.head')

</head>

<body class="fixed-left">

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- ========== Left Sidebar Start ========== -->
        @include('backend.layouts.saidebar')
        <!-- Left Sidebar End -->

        <!-- Start right Content here -->

        <div class="content-page">
            <!-- Start content -->
            <div class="content">

                <!-- Top Bar Start -->
                <div class="topbar">

                    <div class="topbar-left d-none d-lg-block"
                        style="background: #fff; width: 240px; height: 70px; display: flex !important; align-items: center; justify-content: center;">
                        <div class="text-center w-100">
                            <a href="{{ url('/admin') }}" class="logo d-block">
                                <img src="https://you.oceansoftwares.in/demo/frontend/img/you-leggings.png"
                                    style="max-height: 50px; width: auto; vertical-align: middle;" class="img-fluid" />
                            </a>
                        </div>
                    </div>

                    @include('backend.layouts.nav')

                </div>
                <!-- Top Bar End -->

                @yield('content')

            </div> <!-- content -->

            @include('backend.layouts.footer')

        </div>
        <!-- End Right content here -->

    </div>
    <!-- END wrapper -->

    <!-- jQuery  -->
    @include('backend.layouts.script')

</body>

</html>

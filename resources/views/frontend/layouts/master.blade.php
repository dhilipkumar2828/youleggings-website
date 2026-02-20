<!DOCTYPE html>

<html>

<head>

    @include('frontend.layouts.head')

</head>

<body>

    <script>
        fbq('track', 'Purchase', {
            currency: "INR",
            value: 30.00
        });
    </script>

    <div class="container">

        <div class="row">

            <div class="col-md-12">

                @include('backend.layouts.notification')

            </div>

        </div>

    </div>

    @include('frontend.layouts.header')

    </section>

    @yield('content')

    @include('frontend.layouts.footer')

    @include('frontend.layouts.script')

</body>

</html>

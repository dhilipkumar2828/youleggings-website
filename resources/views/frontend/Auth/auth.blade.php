@extends('frontend.layouts.arrivals_products_master_new')

@section('content')
    <section class="page-header-area mb-5">

        <div class="container">

            <div class="row">

                <div class="col-md-6">

                    <div class="page-header-st3-content">

                        <h2 class="page-header-title">Login</h2>

                    </div>

                </div>

                <div class="col-md-6 justify-content-end d-flex">

                    <div class="page-header-st3-content">

                        <ol class="breadcrumb justify-content-md-start">

                            <li class="breadcrumb-item"><a class="text-dark"
                                    href="http://localhost/pandian/vinoth/index">Home</a></li>

                            <li class="breadcrumb-item"><a class="text-dark"
                                    href="http://localhost/pandian/vinoth/whatisnew">Login</a>

                            </li>

                        </ol>

                    </div>
                </div>
            </div>

        </div>

    </section>

    <div class="login-section">
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="col-md-5 ">

                    <div class="login-card text-start d-flex flex-column">

                        <h3 class="text-center">Mobile Phone Verification
                        </h3>

                        <form action="{{ route('login.sumbit') }}" class="form-horizontal mb-0" method="POST"
                            name="mobPassForm">
                            @csrf
                            @php
                                $sessionError = Session::get('error');
                                Session::put('error', '');
                            @endphp

                            @if ($sessionError)
                                <div class="infield" style="text-align:center;">
                                    <span class="text-danger common_session_err"
                                        style="color:red;">{{ $sessionError }}</span>
                                </div>
                            @endif
                            <form action="{{ route('verifyotp') }}" method="POST">

                                @csrf
                                <!-- Mobile Input -->
                                <div class="mb-4 mt-4 position-relative main_div">

                                    <input type="tel" id="mobileInput" class="form-control text-center p-3"
                                        placeholder="Enter your mobile number" minlength="10" maxlength="10">
                                    <span class="text-danger mobile_err"></span>

                                </div>
                                <div id ="verify_otp" style = "display:none">
                                    <input type="text" name="otp" minlength="6" maxlength="6" pattern="[0-9]{6}"
                                        class="form-control text-center p-3" placeholder="Enter 6-digit OTP">
                                    <span class="text-danger otp_err"></span>

                                    <p id="some_div"></p>

                                </div>
                                <!-- OTP (Initially Hidden) -->
                                <div id="resendotpField" class="d-flex d-none">

                                    <p><span><a href="javascript:;" id="resentotpbtn" onclick="sendotp(1)">Resend
                                                OTP</a></span></p>

                                </div>
                                <div class="otptext  mt-2">
                                    <p class="mb-3 text-info-white text-center">We will send you a 6 Digit Verification Code
                                    </p>
                                </div>
                                <!-- Send OTP -->
                                <div class="d-grid mb-0">
                                    <button
                                        class="btn btn-light rounded-pill fw-bold d-flex justify-content-center align-items-center gap-2"
                                        type="button" id="sendOtpButton" onclick="sendotp(1)">
                                        Send OTP
                                    </button>
                                </div>

                                <div class="d-grid mb-3 d-none" id="verifyotpdiv">
                                    <button
                                        class="btn btn-light rounded-pill fw-bold d-flex justify-content-center align-items-center gap-2"
                                        type="button" id="verifyotp" onclick="authVerifyOtp()">
                                        Verify OTP
                                    </button>
                                </div>

                            </form>
                        </form>
                    </div>

                </div>

            </div>

        </div>
    </div>
@endsection

<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // public/js/otp.js

        let timerId;
        var timeLeft = 30;
        var elem = document.getElementById('some_div');

        function countdown() {
            $('#resendotpField').hide();
            if (timeLeft == -1) {
                clearInterval(timerId);
                $('#resendotpField').removeClass('d-none').addClass('d-block');
                elem.innerHTML = '';
            } else {
                elem.innerHTML = 'Resend OTP in ' + timeLeft + ' seconds remaining';
                timeLeft--;
            }
        }

        function sendotp(mtype) {
            $(".mobile_err").html('');
            $("#sendotpmessage").css('display', 'none');
            $('#verify_otp').css('display', 'none');
            $(".common_session_err").html('');
            $(".otp_err").html('');
            $(".otp_mobile_err").html('');
            if (mtype == 1) {
                var mobile = document.getElementById('mobileInput').value;
                var emobile = '.mobile_err';
            } else {
                var mobile = document.getElementById('verifyphone').value;
                var emobile = '.otp_mobile_err';
            }
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if (!mobile) {
                $(emobile).html('Please enter your mobile number');
                return;
            }

            $.ajax({

                url: "{{ route('generateotp') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: {
                    mobile: mobile,
                },
                success: function(data) {
                    $('#verify_otp').css('display', 'block');
                    $("#sendotpmessage").css('display', 'block');
                    $(".sentopt_screen").css('display', 'none');
                    $(".verify_screen").css('display', 'block');
                    $('#first_screen').hide();
                    $("#verify_screen").show();
                    $("#verifyphone").val(mobile);
                    if (data.message == "OTP sent successfully.") {
                        timeLeft = 30;
                        timerId = setInterval(countdown, 1000);
                        $('#sendOtpButton').removeClass('d-flex').addClass('d-none');
                        $('#verifyotpdiv').removeClass('d-none').addClass('d-block');
                        $('#resendotpField').removeClass('d-block').addClass('d-none');
                        $("#sendotpmessage").html(data.message);

                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    console.log('Response:', xhr.responseText);
                }
            });
        }

        function guestsendotp() {

            $(".mobile_err1").html('');
            $("#sendotpmessage").css('display', 'none');
            const mobile = document.getElementById('guest_mobile').value;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if (!mobile) {
                $(".mobile_err1").html('Please enter your mobile number');
                return;
            }

            $.ajax({

                url: "{{ route('guestgenerateotp') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: {
                    mobile: mobile,
                },
                success: function(data) {
                    $("#sendotpmessage1").css('display', 'block');

                    $("#guestlogincode").css('display', 'block');
                    if (data.message == "OTP sent successfully.") {
                        $("#sendotpmessage1").html(data.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    console.log('Response:', xhr.responseText);
                }
            });
        }

        function authVerifyOtp() {
            $(".otp_err").html('');
            $(".mobile_err").html('');
            const otp = document.getElementsByName('otp')[0].value;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const mobile = document.getElementById('mobileInput').value;
            $('.main_div').removeClass('mb-4').addClass('mb-0');
            if (!mobile) {
                $(".mobile_err").html('Please enter your mobile number');
                return;
            }

            if (!otp || !otp.match(/[0-9]{6}/)) {
                $(".otp_err").html('Please enter 6 digit OTP.');
                return;
            }

            $.ajax({
                url: "{{ route('verifyotp') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: {
                    mobile: mobile,
                    otp: otp
                },
                success: function(data) {
                    if (data.hasOwnProperty('error') && data.error.hasOwnProperty('mobile')) {
                        $(".otp_mobile_err").html(data.error.mobile);
                    }
                    if (data.hasOwnProperty('error') && data.error.hasOwnProperty('otp')) {
                        $(".otp_err").html(data.error.otp);
                    }

                    if (!data.hasOwnProperty('error') && data.hasOwnProperty('cartData')) {
                        if (data.cartData == 1) {
                            location.href = "{{ route('cart') }}";
                        } else {
                            location.href = "{{ route('index') }}";
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    console.log('Response:', xhr.responseText);
                }
            });
        }

        function mobPassSubmit() {
            $(".mobile_err").html('');
            $(".password_err").html('');
            $(".common_session_err").html('');

            const mobile = document.getElementsByName('mobile')[0].value;
            const pass = document.getElementById('inputpass').value

            var err = 0;
            if (!mobile || !mobile.match(/[0-9]{10}/)) {
                $(".mobile_err").html('Please enter 10 digit Mobile Number.');
                err = 1;
            }

            if (pass.trim() == '') {
                $(".password_err").html('Please enter the Password.');
                err = 1;
            }

            if (!err) {
                document.getElementsByName('mobPassForm')[0].submit();
            }
        }
    </script>
</body>

</html>

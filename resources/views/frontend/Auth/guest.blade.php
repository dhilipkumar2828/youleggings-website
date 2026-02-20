<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base_url" content="{{ url('/') }}">
    <title>Prrayasha Login</title>
    <link rel="icon" href="../assets/images/green-logo.jpeg" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/newstyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Aclonica&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .form-control::placeholder {
            color: white !important;
            opacity: 1;
        }

        .form-control:focus {
            border-bottom: 1px dotted white !important;
            box-shadow: none;
        }

        .text-start {
            text-align: start !important;
        }

        .login-card p {
            color: #fff;
            text-align: center;
            font-size: 12px;
            margin-bottom: 0px;

        }
    </style>

</head>

<body>
    <div class="banner-section">
        <div class="login-container">
            <!-- Left Side -->
            <div class="left-sections">
                <img src="../assets/images/green-logo.jpeg" alt="PRRAYASHA COLLECTIONS Logo" class="logo-img">
            </div>

            <!-- Right Side -->
            <!-- Right Side -->
            <div class="right-section d-flex flex-column justify-content-between">
                <div>
                    <div class="background-image"></div>

                    <div class="login-card text-start d-flex flex-column" style="height: 100%;">
                        <h4 class="mb-4">Guest Login</h4>

                        <form action="{{ route('guestverifyOtp') }}" class="form-horizontal" method="POST"
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
                                <div class="mb-4 position-relative main_div">
                                    <span class="position-absolute top-50 translate-middle-y ms-3 text-muted">
                                        <i class="fas fa-mobile-alt"></i>
                                    </span>
                                    <input type="tel" id="guest_mobile"
                                        class="form-control ps-1 bg-transparent border-bottom text-white text-center"
                                        placeholder="Enter your mobile number"
                                        style="border-radius: 0; border-top: none; border-left: none; border-right: none; padding-top: 0.65rem; padding-bottom: 0.65rem;"
                                        minlength="10" maxlength="10">
                                    <span class="text-danger mobile_err" style="color:red;font-size:small"></span>

                                </div>
                                <div id ="verify_otp" style = "display:none">
                                    <input type="text" name="otp" minlength="6" maxlength="6"
                                        pattern="[0-9]{6}"
                                        class="form-control text-center bg-transparent border-bottom text-white"
                                        placeholder="Enter 6-digit OTP"
                                        style="border-radius: 0; border-top: none; border-left: none; border-right: none; padding-top: 0.45rem; padding-bottom: 0.45rem;">
                                    <span class="text-danger otp_err" style="color:red;font-size:small"></span>

                                    <p id="some_div"></p>

                                </div>
                                <!-- OTP (Initially Hidden) -->
                                <div id="resendotpField" class="d-flex d-none">

                                    <p><span><a href="javascript:;" id="resentotpbtn" onclick="guestsendotp()">Resend
                                                OTP</a></span></p>

                                </div>
                                <div class="otptext  mt-4">
                                    <p class="mb-3 text-info-white small">We will send you a 6 Digit Verification Code
                                    </p>
                                </div>
                                <!-- Send OTP -->
                                <div class="d-grid mb-3">
                                    <button
                                        class="btn btn-light rounded-pill fw-bold d-flex justify-content-center align-items-center gap-2"
                                        type="button" style="color: #080a54;" id="sendOtpButton"
                                        onclick="guestsendotp()">
                                        GET OTP <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>

                                <div class="d-grid mb-3 d-none" id="verifyotpdiv">
                                    <button
                                        class="btn btn-light rounded-pill fw-bold d-flex justify-content-center align-items-center gap-2"
                                        type="button" style="color: #080a54;" id="verifyotp" onclick="authVerifyOtp()">
                                        Verify OTP<i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>

                            </form>
                        </form>

                        <!-- Push these links to the bottom of the card -->
                        <div class="mt-auto pt-5 text-center">
                            <p class="text-info-white small ">Already have an account?
                                <a href="{{ route('user.auth') }}" class="guest-login-link">Login Here</a>
                            </p>
                            <p class="mb-0">
                                <a href="{{ url('register') }}" class="guest-login-link">Create an account</a>
                            </p>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <script></script>

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

        function guestsendotp() {

            $(".mobile_err").html('');
            $("#sendotpmessage").css('display', 'none');
            const mobile = document.getElementById('guest_mobile').value;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if (!mobile) {
                $(".mobile_err").html('Please enter your mobile number');
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

        function authVerifyOtp() {
            $(".otp_err").html('');
            $(".mobile_err").html('');
            const otp = document.getElementsByName('otp')[0].value;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const mobile = document.getElementById('guest_mobile').value;
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

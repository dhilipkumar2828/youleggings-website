@extends('frontend.layouts.arrivals_products_master')

@section('content')
    <main class="main-content">

        <!--== Start Page Header Area Wrapper ==-->

        <section class="page-header-area">

            <div class="container">

                <!-- style="margin-top:100px;" -->

                <div class="row">

                    <div class="col-md-6">

                        <div class="page-header-st3-content">

                            <h2 class="page-header-title">Account</h2>

                        </div>

                    </div>

                    <div class="col-md-6 justify-content-end d-flex">

                        <div class="page-header-st3-content">

                            <ol class="breadcrumb justify-content-center justify-content-md-start">

                                <li class="breadcrumb-item"><a class="text-dark" href="{{ url('index') }}">Home</a></li>

                                <li class="breadcrumb-item active text-dark" aria-current="page">Account</li>

                            </ol>

                        </div>

                    </div>

                </div>

            </div>

        </section>

        <!--== End Page Header Area Wrapper ==-->

        <!--== Start Account Area Wrapper ==-->

        <section class="section-space">

            <div class="container">

                <div class="row mb-n8">

                    <div class="col-lg-6 mb-8">

                        <!--== Start Login Area Wrapper ==-->

                        <div class="my-account-item-wrap">

                            <!--==    <h3 class="title">Mobile OTP Login</h3> -->

                            <div class="my-account-form">

                                <!--   <form action="{{ route('generateotp') }}" >
                                        @csrf
                                                <input type="text" id="mobile" name="mobile" placeholder="Enter your mobile number">

                                        <button type="button" id="sendOtpButton">Send OTP</button>
                                        <span id="sendotpmessage" style="display:none;"></span>

                                    </form>
                                    <div class="col-md-12">&nbsp;</div>
                                    <div class="verify" style="display:none;">
                                    <form  action="{{ route('verifyotp') }}" method="POST">
                                        @csrf
                                        <input type="text" id="verifyphone" name="mobile" placeholder="Enter your mobile number">
                                        <input type="text" name="otp" placeholder="Enter OTP">
                                        <button type="submit">Verify OTP</button>
                                    </form>
                                    </div> -->
                                <!---
                                    <h3 class="title"> Login</h3>
                                    <p><small>Enter your mobile number and we'll send you a login code</small></p>
                                    <form action="{{ route('login.sumbit') }}" class="form-horizontal" method="POST">

                                              @csrf

                                            <div class="form-group mb-6">

                                                <label for="login_username">Mobile Number  <sup>*</sup></label>

                                                <input type="text" id="inputemail" name="number">

                                             <span class="text-danger email_err"></span>

                                            </div>

                                            <div class="form-group mb-6">

                                                <label for="login_pwsd">Password <sup>*</sup></label>

                                                <input type="password" id="inputpass" name="password">

                                          <span class="text-danger password_err"></span>

                                            </div>

                                            <a href="{{ url('forget_password') }}"><small>FORGOTTEN YOUR PASSWORD?</small></a>

                                            <div class="form-group d-flex align-items-center mb-14 flex-column">

                                            <button type="button" id="login_submit" class="default-btn w-100 mb-4">Login</button>

                                                <div class="form-check ms-3 ">

                                                    <input type="checkbox" class="form-check-input" id="remember_pwsd">

                                                    <label class="form-check-label" for="remember_pwsd">Get an OTP on your phone</label>

                                                </div>

                                            </div>

                                        </form>
                                        ---->

                                <h3 class="title"> Guest Login</h3>

                                <div class="sentopt_screen_guest">

                                    <form action="{{ route('guestverifyOtp') }}" class="form-horizontal" method="POST">

                                        @csrf

                                        <div class="form-group mb-6">

                                            <label for="login_username">Mobile Number <sup>*</sup></label>

                                            <input type="text" id="guest_mobile" name="guest_mobile"
                                                placeholder="Enter your mobile number" pattern="[0-9]{10}" required>

                                            <span class="text-danger mobile_err1"></span>

                                        </div>

                                        <div class="form-group mb-6" style="display:none;" id="guestlogincode">

                                            <label for="login_username">Enter code <sup>*</sup></label>

                                            <input type="text" name="guest_otp" placeholder="6 digit code">
                                        </div>

                                        <div class="form-group mb-6">

                                            <input type="checkbox" class="form-check-input" id="remember_pwsd">

                                            <label class="form-check-label" for="remember_pwsd"
                                                id="guest_sendOtpButton">Login with OTP</label>

                                        </div>

                                        <div class="form-group d-flex align-items-center mb-14 flex-column">
                                            <span id="sendotpmessage1" style="display:none;"></span>
                                            <button type="submit" id="guest_login_submit"
                                                class="default-btn w-100 mb-4">Verify OTP</button>

                                        </div>
                                    </form>
                                </div>

                            </div>

                        </div>

                        <!--== End Login Area Wrapper ==-->

                    </div>

                </div>

            </div>

        </section>

        <!--== End Account Area Wrapper ==-->

        <!-- Modal -->

        <div class="modal fade" id="otpmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title mt-0" id="exampleModalLabel">Enter OTP</h5>

                    </div>

                    <div class="modal-body text-center">

                        <h5 class="mb-0">Please enter the One-time Password to verify your account</h5>

                        <p class="opacity-50">A one-Time Password has been sent to +91 7401439306</p>

                        <form>

                            <div class="form-group">

                                <input type="text" class="form-control text-center mb-4" placeholder="">

                                <button type="button" class="btn btn-primary">Submit</button>

                            </div>

                            <p>Didn't Receive the OTP? <a href="" class="text-danger">Resend code</a></p>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </main>
@section('scripts')
    <script type="text/javascript">
        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
    </script>
@endsection
@endsection
<script>
    // public/js/otp.js

    document.addEventListener('DOMContentLoaded', function() {

        document.getElementById('guest_sendOtpButton').onclick = guestsendotp;

    });

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
</script>

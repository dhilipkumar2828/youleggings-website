<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="base_url" content="{{ url('/') }}">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');

    * {

        padding: 0px;

        margin: 0px;

        box-sizing: border-box;

    }

    :root {

        --linear-grad: linear-gradient(45deg, #223f65, #0e1a30);

        --grad-clr1: #223f65;

        --grad-clr2: #243b55;

    }

    /* :root {

  --linear-grad: linear-gradient(to right, #141E30, #243B55);

  --grad-clr1: #141E30;

  --grad-clr2: #243B55;

} */

    /* :root {

  --linear-grad: linear-gradient(to right, #1E3023, #3B5534);

  --grad-clr1: #1E3023;

  --grad-clr2: #3B5534;

} */

    /* :root {

  --linear-grad: linear-gradient(to right, #30231E, #55343B);

  --grad-clr1: #30231E;

  --grad-clr2: #55343B;

} */

    /* :root {

  --linear-grad: linear-gradient(to right, #301E23, #55343B);

  --grad-clr1: #301E23;

  --grad-clr2: #55343B;

} */

    body {

        /* height: 100vh; */

        background: #f6f5f7;

        place-content: normal;

        font-family: 'Poppins', sans-serif;

        overflow: hidden;

        position: absolute;

        right: 0;

        top: 60px;

    }

    .container {

        position: relative;

        width: 850px;

        height: 500px;

        background-color: #FFF;

        box-shadow: 25px 30px 55px #5557;

        border-radius: 13px;

        overflow: hidden;

    }

    .form-container {

        position: absolute;

        width: 60%;

        height: 100%;

        padding: 0px 40px;

        transition: all 0.6s ease-in-out;

    }

    .sign-up-container {

        opacity: 0;

        z-index: 1;

    }

    .sign-in-container {

        z-index: 2;

    }

    form {

        height: 100%;

        display: flex;

        flex-direction: column;

        align-items: center;

        justify-content: center;

        padding: 0px 50px;

    }

    h1 {

        color: #333;

    }

    .social-container {

        margin: 20px 0px;

    }

    .social-container a {

        border: 1px solid #DDD;

        border-radius: 50%;

        display: inline-flex;

        justify-content: center;

        align-items: center;

        margin: 0px 5px;

        height: 40px;

        width: 40px;

    }

    span {

        font-size: 12px;

    }

    .infield {

        position: relative;

        margin: 8px 0px;

        width: 100%;

    }

    input {

        width: 100%;

        padding: 15px 15px;

        outline: none;

        border-bottom: 1px solid #11111157;

        border-top: none;

        border-left: none;

        border-right: none;

    }

    label {

        position: absolute;

        left: 50%;

        top: 100%;

        transform: translateX(-50%);

        width: 0%;

        height: 2px;

        background: var(--linear-grad);

        transition: width 0.3s ease;

    }

    input:focus~label {

        width: 100%;

    }

    a {

        color: #333;

        font-size: 14px;

        text-decoration: none;

        margin: 15px 0px;

    }

    a.forgot {

        padding-bottom: 3px;

        border-bottom: 2px solid #EEE;

    }

    button {

        border-radius: 20px;

        border: 1px solid var(--grad-clr1);

        background: var(--grad-clr2);

        color: #FFF;

        font-size: 12px;

        font-weight: bold;

        padding: 12px 45px;

        letter-spacing: 1px;

        text-transform: uppercase;

    }

    .form-container button {

        margin-top: 17px;

        transition: 80ms ease-in;

    }

    .form-container button:hover {

        background: #FFF;

        color: var(--grad-clr1);

    }

    .overlay-container {

        position: absolute;

        top: 0;

        left: 60%;

        width: 40%;

        height: 100%;

        overflow: hidden;

        transition: transform 0.6s ease-in-out;

        z-index: 9;

    }

    #overlayBtn {

        cursor: pointer;

        position: absolute;

        left: 50%;

        top: 348px;

        transform: translateX(-50%);

        width: 143.67px;

        height: 40px;

        border: 1px solid #FFF;

        background: transparent;

        border-radius: 20px;

    }

    img.squaree {

        width: 130px;

    }

    .overlay {

        position: relative;

        background: var(--linear-grad);

        color: #FFF;

        left: -150%;

        height: 100%;

        width: 250%;

        transition: transform 0.6s ease-in-out;

    }

    .overlay-panel {

        position: absolute;

        display: flex;

        align-items: center;

        justify-content: center;

        flex-direction: column;

        padding: 0px 40px;

        text-align: center;

        height: 100%;

        width: 340px;

        transition: 0.6s ease-in-out;

    }

    .overlay-left {

        right: 60%;

        transform: translateX(-12%);

    }

    .overlay-right {

        right: 0;

        transform: translateX(0%);

    }

    .overlay-panel h1 {

        color: #FFF;

    }

    p {

        font-size: 14px;

        font-weight: 300;

        line-height: 20px;

        letter-spacing: 0.5px;

        margin: 25px 0px 35px;

    }

    .overlay-panel button {

        border: none;

        background-color: transparent;

    }

    .right-panel-active .overlay-container {

        transform: translateX(-150%);

    }

    .right-panel-active .overlay {

        transform: translateX(50%);

    }

    .right-panel-active .overlay-left {

        transform: translateX(25%);

    }

    .right-panel-active .overlay-right {

        transform: translateX(35%);

    }

    .right-panel-active .sign-in-container {

        transform: translateX(20%);

        opacity: 0;

    }

    .right-panel-active .sign-up-container {

        transform: translateX(66.7%);

        opacity: 1;

        z-index: 5;

        animation: show 0.6s;

    }

    @keyframes show {

        0%,
        50% {

            opacity: 0;

            z-index: 1;

        }

        50.1%,
        100% {

            opacity: 1;

            z-index: 5;

        }

    }

    btnScaled {

        animation: scaleBtn 0.6s;

    }

    @keyframes scaleBtn {

        0% {

            width: 143.67px;

        }

        50% {

            width: 250px;

        }

        100% {

            width: 143.67px;

        }

    }

    .square {

        position: absolute;

        height: 400px;

        top: 50%;

        left: 50%;

        transform: translate(181%, 11%);

        opacity: 0.2;

    }

    .big-circle {

        position: absolute;

        width: 500px;

        height: 500px;

        border-radius: 50%;

        background: linear-gradient(45deg, #223f65, #0e1a30);

        bottom: 50%;

        right: 50%;

        transform: translate(-40%, 38%);

    }

    .social-containerr p span a {

        text-decoration: underline;

        color: #1e375a;

        font-weight: 500;

    }

    .inner-circle {

        position: absolute;

        width: 72%;

        height: 72%;

        background-color: white;

        border-radius: 50%;

        top: 50%;

        left: 50%;

        transform: translate(-50%, -50%);

    }

    .form-container.sign-in-container h1 {

        padding-bottom: 20px;

    }

    .form-container.sign-up-container h1 {

        padding-bottom: 20px;

    }

    img.squaree {

        width: 140px;

        background: #fff;

        border-radius: 118px;

        padding: 9px;

    }

    a.forgot.otptextlog {

        float: left;

        font-size: 10px;

        border-bottom: none;

        margin-top: 0;

    }

    a.forgot.forgotpass {

        font-size: 10px;

        float: right;

        border-bottom: none;

        margin-top: 0;

    }
</style>

<span class="big-circle">

    <span class="inner-circle"></span>

</span>

<img src="{{ url('frontend/img//bg-overlay.jpg') }}" class="square" alt="" />

<div class="container" id="container">

    <div class="form-container sign-up-container">

        <form action="{{ route('register.sumbit') }}" class="form-horizontal" method="POST">

            <h1>Create Account</h1>

            <div class="infield">

                <input type="text" id="register_username" name="name" placeholder="Name" required>

                <span class="text-danger regname_err" style="color:red;"></span>

                <label></label>

            </div>

            <div class="infield">

                <input type="email" placeholder="Email Address" id="register_email" name="email">

                <span class="text-danger regemail_err" style="color:red;"></span>

                <label></label>

            </div>

            <div class="infield">

                <input type="text" id="register_phone_number" placeholder="Mobile Number" name="phone_number"
                    required onkeypress="return isNumber(event)" minlength="10" maxlength="10">

                <span class="text-danger regphone_err" style="color:red;"></span>

                <label></label>

            </div>

            <div class="infield">

                <input type="password" id="register_pwsd" placeholder="Password" name="password" required>

                <span class="text-danger regpassword_err" style="color:red;"></span>

                <label></label>

            </div>

            <button type="button" id="register_submit" class="optional-btn">Sign Up</button>

        </form>

    </div>

    <div class="form-container sign-in-container">

        <div class="sentopt_screen">

            <form action="{{ route('login.sumbit') }}" class="form-horizontal" method="POST" name="mobPassForm">

                @csrf

                <h1>Sign in</h1>

                @php

                    $sessionError = Session::get('error');

                    Session::put('error', '');

                @endphp

                @if ($sessionError)
                    <div class="infield" style="text-align:center;">

                        <span class="text-danger common_session_err" style="color:red;">{{ $sessionError }}</span>

                    </div>
                @endif

                <div class="infield">

                    <input type="text" id="mobile" name="mobile" placeholder="Enter your mobile number"
                        minlength="10" maxlength="10" />

                    <span class="text-danger mobile_err" style="color:red;"></span>

                    <label></label>

                </div>

                <div class="infield">

                    <input type="password" placeholder="Password" id="inputpass" name="password">

                    <span class="text-danger password_err" style="color:red;"></span>

                    <label></label>

                </div>

                <div class="infield">

                    <a href="#" class="forgot otptextlog" id="sendOtpButton" onclick="sendotp(1)">Login with
                        OTP</a>

                    <a href="{{ url('forget_password') }}" class="forgot forgotpass">Forgot your password?</a>

                </div>

                <button type="button" id="login_submit" class="default-btn w-100 mb-4" onclick="mobPassSubmit()">Sign
                    In</button>

                <div class="social-containerr">

                    <p>Continue as a Guest Login ? <span><a href="{{ url('guest/auth') }}">Here</a></span></p>

                </div>

            </form>

        </div>

        <div class="verify_screen" style="display:none;">

            <form action="{{ route('verifyotp') }}" method="POST">

                @csrf

                <h1>Sign in</h1>

                <div class="infield">

                    <input type="text" id="verifyphone" name="mobile" placeholder="Enter your mobile number"
                        pattern="[0-9]{10}" required>

                    <span class="text-danger otp_mobile_err" style="color:red;"></span>

                    <label></label>

                </div>

                <div class="infield">

                    <input type="text" name="otp" placeholder="6 digit code" minlength="6" maxlength="6"
                        pattern="[0-9]{6}" required>

                    <span class="text-danger otp_err" style="color:red;"></span>

                    <label></label>

                </div>

                <div class="infield">

                    <a href="#" class="forgot otptextlog" id="sendOtpButton" onclick="sendotp(2)">Login with
                        OTP</a>

                    <a href="{{ url('forget_password') }}" class="forgot forgotpass">Forgot your password?</a>

                </div>

                <button type="button" class="default-btn w-100 mb-4" onclick="authVerifyOtp()">Verify OTP</button>

                <div class="social-containerr">

                    <p>Continue as a Guest Login ? <span><a href="{{ url('guest/auth') }}">Here</a></span></p>

                </div>

            </form>

        </div>

    </div>

    <div class="overlay-container" id="overlayCon">

        <div class="overlay">

            <div class="overlay-panel overlay-left">

                <img src="{{ url('frontend/img//Prrayasha.png') }}" class="squaree" alt="" />

                <p>To keep connected with us please login with your personal info</p>

                <button>Sign In</button>

            </div>

            <div class="overlay-panel overlay-right">

                <img src="{{ url('frontend/img//Prrayasha.png') }}" class="squaree" alt="" />

                <p>Enter your personal details and start journey with us</p>

                <button id="signUpBtn">Sign Up</button>
            </div>

        </div>

        <button id="overlayBtn"></button>

    </div>

</div>

<script>
    const container = document.getElementById('container');

    const overlayCon = document.getElementById('overlayCon');

    const overlayBtn = document.getElementById('overlayBtn');

    overlayBtn.addEventListener('click', () => {

        container.classList.toggle('right-panel-active');

        overlayBtn.classList.remove('btnScaled');

        window.requestAnimationFrame(() => {

            overlayBtn.classList.add('btnScaled');

        });

    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $('#register_submit').click(function() {

        var input = $('#register_email').val();

        function validateEmail(email) {

            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            return regex.test(email);

        }

        var isemail_valid = validateEmail(input);

        var token = $('meta[name="csrf-token"]').attr('content');

        var base_url = $('meta[name="base_url"]').attr('content');

        console.log('Base URL:', base_url);

        console.log('CSRF Token:', token);

        if (!base_url) {

            console.error('Base URL is not defined');

            return;

        }

        if (!token) {

            console.error('CSRF Token is not defined');

            return;

        }

        var path = base_url + '/user/register';

        var redirect = base_url + '/index';

        console.log('Register URL:', path);

        console.log('Redirect URL:', redirect);

        if ($('#register_username').val() != "" && $('#register_phone_number').val() != "" && $(
                '#register_pwsd').val() != "" && $('#register_pwsd').val().length >= 4) {

            $('.regname_err').text('');

            $('.regphone_err').text('');

            //$('.regemail_err').text('');

            $('.regpassword_err').text('');

            $.ajax({

                url: path,

                type: 'POST',

                data: {

                    _token: token,

                    name: $('#register_username').val(),

                    email: $('#register_email').val(),

                    phone_number: $('#register_phone_number').val(),

                    password: $('#register_pwsd').val()

                },

                headers: {

                    'X-CSRF-TOKEN': token

                },

                success: function(data) {

                    if (data.error == false) {

                        $('.regphone_err').text('Phone number already taken');

                    } else {

                        $('.regemail_err').text('');

                        $('input').val('');

                        // window.location.href = redirect;

                        if (data.hasOwnProperty('cartData')) {

                            if (data.cartData == 1) {

                                location.href = "{{ route('checkout1') }}";

                            } else {

                                location.href = "{{ route('index') }}";

                            }

                        }

                    }

                },

                error: function(xhr) {

                    console.error('Error:', xhr.responseText);

                }

            });

        }

        if ($('#register_username').val() == "") {

            $('.regname_err').text('This field is required');

        } else {

            $('.regname_err').text('');

        }

        if ($('#register_phone_number').val() == "") {

            $('.regphone_err').text('This field is required');

        } else {

            $('.regphone_err').text('');

        }

        if ($('#register_pwsd').val() == "") {

            $('.regpassword_err').text('This field is required');

        } else if ($('#register_pwsd').val().length <= 4) {

            $('.regpassword_err').text('Password must be greater than 4 characters');

        } else {

            $('.regpassword_err').text('');

        }

    });
</script>

<script>
    // public/js/otp.js

    function sendotp(mtype) {

        $(".mobile_err").html('');

        $("#sendotpmessage").css('display', 'none');

        $(".common_session_err").html('');

        $(".otp_err").html('');

        $(".otp_mobile_err").html('');

        if (mtype == 1) {

            var mobile = document.getElementById('mobile').value;

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

                $("#sendotpmessage").css('display', 'block');

                $(".sentopt_screen").css('display', 'none');

                $(".verify_screen").css('display', 'block');

                $("#verifyphone").val(mobile)

                if (data.message == "OTP sent successfully.") {

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

        $(".otp_mobile_err").html('');

        const otp = document.getElementsByName('otp')[0].value;

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const mobile = document.getElementById('verifyphone').value;

        if (!mobile) {

            $(".otp_mobile_err").html('Please enter your mobile number');

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

                        location.href = "{{ route('checkout1') }}";

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

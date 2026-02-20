<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base_url" content="{{ url('/') }}">
    <title>Prrayasha Login | Create Account</title>
    <link rel="icon" href="./assets/images/green-logo.jpeg" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/newstyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Aclonica&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Custom placeholder and focus styles */
        .form-control::placeholder {
            color: white !important;
            opacity: 1;

        }

        .form-control:focus {
            border-bottom: 1px dotted white !important;
            box-shadow: none;
        }
    </style>
</head>

<body>
    <div class="banner-section">
        <div class="login-container">
            <!-- Left Side -->
            <div class="left-sections">
                <img src="./assets/images/green-logo.jpeg" alt="PRRAYASHA COLLECTIONS Logo" class="logo-img">

            </div>

            <!-- Right Side -->
            <div class="right-section">
                <div class="background-image"></div>
                <!-- Close Button
        <button class="close-button" onclick="handleClose()">
          &times;
        </button>-->
                <div class="login-card text-start">
                    <h4 class="mb-4">Create Account</h4>

                    <form id="registerForm" class="form-horizontal" method="POST">
                        @csrf

                        <!-- Name Input -->
                        <div class="mb-3 position-relative">
                            <span class="position-absolute top-50 translate-middle-y ms-3 text-muted">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" class="form-control ps-1 bg-transparent border-bottom text-white"
                                placeholder="Enter your name" name ="name"
                                style="border-radius: 0; border-top: none; border-left: none; border-right: none;"
                                required>
                            <span class="text-danger" id="name_error" style = "font-size:small"></span>
                        </div>

                        <!-- Email Input -->
                        <div class="mb-3 position-relative">
                            <span class="position-absolute top-50 translate-middle-y ms-3 text-muted">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" class="form-control ps-1 bg-transparent border-bottom text-white"
                                placeholder="Enter your email address" name="email"
                                style="border-radius: 0; border-top: none; border-left: none; border-right: none;"
                                required>
                            <span class="text-danger" id="email_error" style = "font-size:small"></span>
                        </div>

                        <!-- Mobile Number Input -->
                        <div class="mb-3 position-relative">
                            <span class="position-absolute top-50 translate-middle-y ms-3 text-muted">
                                <i class="fas fa-mobile-alt"></i>
                            </span>
                            <input type="tel" class="form-control ps-1 bg-transparent border-bottom text-white"
                                placeholder="Enter your mobile number" name="phone_number" id="phoneInput"
                                style="border-radius: 0; border-top: none; border-left: none; border-right: none;"
                                required>
                            <span class="text-danger" id="phone_error" style = "font-size:small"></span>
                        </div>

                        <!-- Sign Up Button -->
                        <div class="d-grid">
                            <button
                                class="btn btn-light rounded-pill fw-bold d-flex justify-content-center align-items-center gap-2"
                                type="submit" style="color: #080a54;">
                                Sign up <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>

                    </form>

                    <p class="mt-3 text-center">
                        <a href="{{ route('user.auth') }}" class="guest-login-link">Back to login</a>
                    </p>

                </div>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('phoneInput').addEventListener('input', function(e) {
            let digitsOnly = this.value = this.value.replace(/\D/g, '');
            if (digitsOnly.length > 10) {
                digitsOnly = digitsOnly.slice(0, 10);
            }

            this.value = digitsOnly;
        });
        $(document).ready(function() {
            $('#registerForm').on('submit', function(e) {
                e.preventDefault();

                // Clear previous error messages
                $('#email_error').text('');
                $('#phone_error').text('');
                $('#name_error').text('');

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('register.sumbit') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function(response) {
                        if (response.error === false && response.authenticated) {
                            // Redirect to home or dashboard if authenticated
                            window.location.href = response.redirect;
                        } else if (response.message.includes("Mail")) {
                            $('#email_error').text(response.message);
                        } else if (response.message.includes("Phone")) {
                            $('#phone_error').text(response.message);
                        } else {
                            alert('Unexpected error. Please try again.');
                        }
                    },
                    error: function(xhr) {
                        // Handle validation errors
                        let errors = xhr.responseJSON.errors;
                        if (errors.name) {
                            $('#name_error').text(errors.name[0]);
                        }
                        if (errors.email) {
                            $('#email_error').text(errors.email[0]);
                        }
                        if (errors.phone_number) {
                            $('#phone_error').text(errors.phone_number[0]);
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>

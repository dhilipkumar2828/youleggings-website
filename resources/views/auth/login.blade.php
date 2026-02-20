<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Admin Login | You Leggings</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #e3007b;
            --primary-gradient: linear-gradient(135deg, #e3007b 0%, #d2006d 100%);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--primary-gradient);
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(0, 0, 0, 0.1) 0%, transparent 40%);
            pointer-events: none;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
            position: relative;
            z-index: 1;
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .glass-card {
            background: #ffffff;
            border-radius: 30px;
            padding: 45px;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.2);
        }

        .logo-wrap {
            text-align: center;
            margin-bottom: 35px;
            background: #fff;
            border-radius: 20px;
        }

        .logo-wrap img {
            height: 55px;
        }

        .form-title {
            color: #1a1a1a;
            font-size: 26px;
            font-weight: 800;
            text-align: center;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .form-subtitle {
            color: #7d8590;
            text-align: center;
            margin-bottom: 40px;
            font-size: 15px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            color: #4a5568;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 18px;
        }

        .form-control {
            background: #f8fafd !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 14px !important;
            color: #2d3748 !important;
            padding: 14px 15px 14px 50px !important;
            height: auto !important;
            transition: all 0.3s ease;
            font-size: 15px;
        }

        .form-control:focus {
            background: #ffffff !important;
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 4px rgba(255, 63, 108, 0.08) !important;
        }

        .btn-login {
            background: var(--primary-gradient);
            border: none;
            border-radius: 14px;
            color: white;
            width: 100%;
            padding: 16px;
            font-weight: 700;
            font-size: 16px;
            margin-top: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(255, 63, 108, 0.2);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(255, 63, 108, 0.3);
            filter: brightness(1.05);
        }

        .forgot-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            color: #a0aec0;
            font-size: 14px;
            text-decoration: none;
            transition: color 0.3s;
            font-weight: 500;
        }

        .forgot-link:hover {
            color: var(--primary);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Error States */
        .is-invalid {
            border-color: #ef4444 !important;
        }

        .invalid-feedback {
            color: #ef4444;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="glass-card">
            <div class="logo-wrap">
                <img src="https://you.oceansoftwares.in/demo/frontend/img/you-leggings.png" alt="logo">
            </div>

            <h2 class="form-title">Welcome Back</h2>
            <p class="form-subtitle">Admin control panel access</p>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Email Address</label>
                    <div class="input-wrap">
                        <i class="dripicons-mail"></i>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" required placeholder="Enter your email">
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrap">
                        <i class="dripicons-lock"></i>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" required
                            placeholder="Enter your password">
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    Login
                </button>

                <a href="#" class="forgot-link">Recover access credentials?</a>
            </form>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
</body>

</html>

<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if (app()->getLocale() === 'ar') dir="rtl" @endif>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ asset(config('app.logo')) }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <title>{{ __('Admin Login') }} - {{ config('app.name') }}</title>
    <x-dashboard.styles />
    <x-dashboard.scripts-header />

@if (app()->getLocale() == 'ar')
    <link rel="stylesheet" href="{{ asset('backend/css/rtl.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body * {
            font-family: 'Cairo', sans-serif !important;
        }
    </style>
@endif

<style>
    body {
        background: #f4f6f8;
        font-family: 'DM Sans', sans-serif;
        min-height: 100vh;
    }
    .login-card {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    .login-left {
        background-color: #006c35;
        color: white;
        text-align: center;
        padding: 3rem 2rem;
    }
    .login-left img {
        max-width: 130px;
    }
    .login-left h2 {
        font-weight: 700;
        margin-top: 1.5rem;
    }
    .login-left p {
        font-size: 0.95rem;
        opacity: 0.9;
    }
    .login-right {
        padding: 3rem 2.5rem;
        background: #fff;
    }
    .form-control {
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
    }
    .btn-login {
        background-color: #006c35;
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        padding: 0.8rem;
        transition: 0.3s;
    }
    .btn-login:hover {
        background-color: #008f45;
    }
    .forgot-link {
        color: #006c35;
        font-weight: 500;
        text-decoration: none;
    }
    .forgot-link:hover {
        text-decoration: underline;
    }
    .text-muted small {
        font-size: 0.85rem;
    }
    .toggle-password {
        position: absolute;
        top: 50%;
        right: 1rem;
        transform: translateY(-50%);
        cursor: pointer;
    }
</style>

</head>

<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="col-lg-8 col-xl-7 login-card">
            <div class="row g-0">
                <!-- Left Section -->
                <div class="col-md-5 d-flex flex-column align-items-center justify-content-center login-left">
                    <img src="{{ asset(config('app.logo')) }}" alt="{{ config('app.name') }}">
                    <h2 class="mt-4">{{ __('Welcome Back!') }}</h2>
                    <p class="mt-2">{{ __('Sign in to manage your dashboard and access admin features.') }}</p>
                </div>

            <!-- Right Section -->
            <div class="col-md-7 login-right">
                <h3 class="fw-bold mb-4 text-center">{{ __('Admin Login') }}</h3>

                <!-- Session / Error Messages -->
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">{{ __('Invalid login credentials. Please try again.') }}</div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="user">
                    @csrf

                    <div class="form-group mb-4">
                        <label for="email" class="form-label fw-semibold">{{ __('Email Address') }}</label>
                        <input id="email" type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required autofocus autocomplete="email"
                               placeholder="{{ __('Enter your email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4 position-relative">
                        <label for="password" class="form-label fw-semibold">{{ __('Password') }}</label>
                        <input id="password" type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               required autocomplete="current-password"
                               placeholder="{{ __('Enter your password') }}">
                        <span class="toggle-password text-secondary">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </span>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember"
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="forgot-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Password?') }}
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-login w-100 text-white">
                        {{ __('Login') }}
                    </button>

                    <p class="text-center text-muted mt-4 small">
                        🔐 {{ __('Your connection is secured and encrypted.') }}
                    </p>
                </form>

                <!-- Optional Social Logins -->

                {{-- <div class="text-center mt-4">
                    <div class="text-muted mb-2">{{ __('Or login using') }}</div>
                    <button type="button" class="btn btn-outline-secondary w-100 mb-2">
                        <i class="bi bi-google me-2"></i>{{ __('Google') }}
                    </button>
                    <button type="button" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-github me-2"></i>{{ __('GitHub') }}
                    </button>
                </div> --}}

            </div>
        </div>
    </div>
</div>

<x-dashboard.scripts-footer />

<!-- Password toggle script -->
<script>
    const togglePassword = document.querySelector('.toggle-password');
    const passwordInput = document.querySelector('#password');
    const toggleIcon = document.querySelector('#toggleIcon');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        toggleIcon.classList.toggle('bi-eye');
        toggleIcon.classList.toggle('bi-eye-slash');
    });
</script>

</body>
</html>

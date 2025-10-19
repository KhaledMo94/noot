<x-guest-layout>
<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if (app()->getLocale() === 'ar') dir="rtl" @endif>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Confirm Password') }} - {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset(config('app.logo')) }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <x-dashboard.styles />
    <x-dashboard.scripts-header />

@if (app()->getLocale() == 'ar')
    <link rel="stylesheet" href="{{ asset('backend/css/rtl.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:slnt,wght@-11..11,200..1000&display=swap" rel="stylesheet">
    <style>
        body * {
            font-family: 'Cairo', sans-serif !important;
        }
    </style>
@endif

<style>
    body {
        background: #f7f8fa;
        font-family: 'DM Sans', sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card {
        border-radius: 12px;
        overflow: hidden;
    }

    .form-header {
        background-color: #006c35;
        color: #fff;
        text-align: center;
        padding: 2rem 2.5rem;
        border-radius: 12px 12px 0 0;
    }

    .form-header img {
        max-width: 150px;
        margin-bottom: 1rem;
    }

    .form-section {
        padding: 2rem 2.5rem;
        background: #fff;
        border-radius: 0 0 12px 12px;
    }

    .form-section p {
        color: #6b7280;
        font-size: 0.95rem;
        text-align: center;
    }

    .form-control {
        border-radius: 50px;
        padding: 0.75rem 1.25rem;
        font-size: 0.95rem;
    }

    .btn-primary {
        background-color: #006c35;
        border: none;
        border-radius: 50px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-primary:hover {
        background-color: #004d26;
    }

    .back-to-login {
        display: block;
        text-align: center;
        margin-top: 15px;
        color: #006c35;
        text-decoration: none;
        font-weight: 500;
    }

    .back-to-login:hover {
        text-decoration: underline;
    }
</style>

</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="shadow card border-0">
                    <div class="form-header">
                        <img src="{{ asset(config('app.logo')) }}" alt="{{ config('app.name') }}">
                        <h1>{{ __('Confirm Password') }}</h1>
                        <p class="text-white-50">{{ __('Please confirm your password before continuing.') }}</p>
                    </div>

                <div class="form-section">
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="form-control" placeholder="{{ __('Enter your password') }}">
                            @error('password')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">{{ __('Confirm Password') }}</button>
                    </form>

                    <a href="{{ route('login') }}" class="back-to-login">{{ __('Back to Login') }}</a>
                </div>
            </div>

            <p class="mt-4 text-center text-muted">
                © {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
            </p>
        </div>
    </div>
</div>

<x-dashboard.scripts-footer />

</body>

</html>

</x-guest-layout>

<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if (app()->getLocale() === 'ar') dir="rtl" @endif>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Verify Email') }} - {{ config('app.name') }}</title>
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

    .btn-logout {
        background: none;
        border: none;
        color: #6b7280;
        text-decoration: underline;
        font-size: 0.9rem;
    }

    .btn-logout:hover {
        color: #004d26;
        text-decoration: none;
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
                        <h1>{{ __('Verify Your Email') }}</h1>
                        <p class="text-white-50">{{ __('Before getting started, please verify your email address.') }}</p>
                    </div>
                <div class="form-section">
                    <p>{{ __('We’ve sent a verification link to your email. If you didn’t receive it, you can request another one below.') }}</p>

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success text-center mt-3" role="alert">
                            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                {{ __('Resend Verification Email') }}
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn-logout">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-dashboard.scripts-footer />
</body>

</html>

@extends('layouts.app')
@section('title', 'OTP Login')
@section('content')
    <div class="login-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="login-card">
                        @if (request('phone'))
                            {{-- OTP Verify --}}
                            <div class="text-center mb-4">
                                <h3 class="login-title">
                                    Verify OTP
                                </h3>
                                <p class="login-subtitle">
                                    Enter the OTP sent to {{ request('phone') }}
                                </p>
                            </div>
                            {{-- Error --}}
                            @if ($errors->any())
                                <div class="alert alert-danger border-0 rounded-4 py-2">
                                    {{ $errors->first() }}
                                </div>
                            @endif
                            {{-- Verify Form --}}
                            <form method="POST" action="{{ route('login.otp.verify.submit') }}">
                                @csrf
                                <input type="hidden" name="phone" value="{{ request('phone') }}">
                                {{-- OTP --}}
                                <div class="mb-4">
                                    <label class="login-label">
                                        OTP Code
                                    </label>
                                    <div class="login-input-wrap">
                                        <i class="bi bi-shield-lock"></i>
                                        <input type="text" name="otp" maxlength="6" required autofocus
                                            placeholder="000000" class="form-control login-input text-center"
                                            style="
                                            font-size:1.2rem;
                                            font-weight:700;
                                            letter-spacing:.35rem;
                                            padding-left:0;
                                       ">
                                    </div>
                                </div>
                                {{-- Button --}}
                                <button type="submit" class="login-btn">
                                    Verify & Login
                                    <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </form>
                            {{-- Back --}}
                            <div class="text-center mt-4">
                                <a href="{{ route('login') }}" class="login-link">
                                    Back to Login
                                </a>
                            </div>
                        @else
                            {{-- Send OTP --}}
                            <div class="text-center mb-4">
                                <h3 class="login-title">
                                    Login with OTP
                                </h3>
                                <p class="login-subtitle">
                                    Enter your phone number to receive OTP
                                </p>
                            </div>
                            {{-- Error --}}
                            @if ($errors->any())
                                <div class="alert alert-danger border-0 rounded-4 py-2">
                                    {{ $errors->first() }}
                                </div>
                            @endif
                            {{-- Send Form --}}
                            <form method="POST" action="{{ route('login.otp.send') }}">
                                @csrf
                                {{-- Phone --}}
                                <div class="mb-4">
                                    <label class="login-label">
                                        Phone Number
                                    </label>
                                    <div class="login-input-wrap">

                                        <i class="bi bi-telephone"></i>

                                        <input type="tel" name="phone" required autofocus
                                            placeholder="+91 XXXXX XXXXX" class="form-control login-input">
                                    </div>
                                </div>
                                {{-- Button --}}
                                <button type="submit" class="login-btn">
                                    Send OTP
                                    <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </form>
                            {{-- Bottom --}}
                            <div class="text-center mt-4">
                                <a href="{{ route('login') }}" class="login-link">
                                    Back to Login
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

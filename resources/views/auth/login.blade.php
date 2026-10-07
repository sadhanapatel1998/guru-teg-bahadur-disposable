@extends('layouts.app')

@section('title', 'Login')

@section('content')

    <div class="login-page">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-4 col-md-6">

                    <div class="login-card">

                        {{-- Heading --}}
                        <div class="text-center mb-4">

                            <h3 class="login-title">
                                Sign In
                            </h3>

                            <p class="login-subtitle">
                                Access your account to continue
                            </p>

                        </div>



                        {{-- Error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger border-0 rounded-4 py-2">
                                {{ $errors->first() }}
                            </div>
                        @endif



                        {{-- Form --}}
                        <form method="POST" action="{{ route('login') }}">

                            @csrf


                            {{-- Email --}}
                            <div class="mb-3">

                                <label class="login-label">
                                    Email Address
                                </label>

                                <div class="login-input-wrap">

                                    <i class="bi bi-envelope"></i>

                                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                        placeholder="Enter your email" class="form-control login-input">

                                </div>

                            </div>



                            {{-- Password --}}
                            <div class="mb-3">

                                <label class="login-label">
                                    Password
                                </label>

                                <div class="login-input-wrap">

                                    <i class="bi bi-lock"></i>

                                    <input type="password" name="password" required placeholder="Enter password"
                                        class="form-control login-input">

                                </div>

                            </div>



                            {{-- Remember --}}
                            <div class="d-flex justify-content-between align-items-center mb-4">

                                <div class="form-check">

                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                    <label class="form-check-label" for="remember">

                                        Remember me

                                    </label>

                                </div>

                            </div>



                            {{-- Button --}}
                            <button type="submit" class="login-btn">

                                Sign In

                                <i class="bi bi-arrow-right ms-2"></i>

                            </button>

                        </form>



                        {{-- Bottom --}}
                        <div class="text-center mt-4">

                            {{-- <a href="{{ route('login.otp') }}" class="login-link">

                                Login with OTP

                            </a> --}}

                            <div class="mt-2 login-bottom-text">

                                Don’t have an account?

                                <a href="{{ route('register') }}" class="login-link">

                                    Create Account

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

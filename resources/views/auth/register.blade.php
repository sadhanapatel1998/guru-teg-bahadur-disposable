@extends('layouts.app')
@section('title', 'Register')
@section('content')
    <div class="login-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-6">
                    <div class="login-card">
                        {{-- Heading --}}
                        <div class="text-center mb-4">
                            <h3 class="login-title">
                                Create Account
                            </h3>
                            <p class="login-subtitle">
                                Join and start shopping premium collections
                            </p>
                        </div>
                        {{-- Error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger border-0 rounded-4 py-2">
                                {{ $errors->first() }}
                            </div>
                        @endif
                        {{-- Register Form --}}
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            {{-- Name --}}
                            <div class="mb-3">
                                <label class="login-label">
                                    Full Name
                                </label>
                                <div class="login-input-wrap">
                                    <i class="bi bi-person"></i>
                                    <input type="text" name="name" value="{{ old('name') }}" required
                                        placeholder="Enter full name" class="form-control login-input">
                                </div>
                            </div>
                            {{-- Email --}}
                            <div class="mb-3">
                                <label class="login-label">
                                    Email Address
                                </label>
                                <div class="login-input-wrap">
                                    <i class="bi bi-envelope"></i>
                                    <input type="email" name="email" value="{{ old('email') }}" required
                                        placeholder="Enter email" class="form-control login-input">
                                </div>
                            </div>
                            {{-- Phone --}}
                            <div class="mb-3">
                                <label class="login-label">
                                    Phone Number
                                </label>
                                <div class="login-input-wrap">
                                    <i class="bi bi-telephone"></i>
                                    <input type="tel" name="phone" value="{{ old('phone') }}" required
                                        placeholder="+91 XXXXX XXXXX" class="form-control login-input">
                                </div>
                            </div>
                            {{-- Password --}}
                            <div class="mb-3">
                                <label class="login-label">
                                    Password
                                </label>
                                <div class="login-input-wrap">
                                    <i class="bi bi-lock"></i>
                                    <input type="password" name="password" required minlength="8"
                                        placeholder="Create password" class="form-control login-input">
                                </div>
                            </div>
                            {{-- Confirm Password --}}
                            <div class="mb-4">
                                <label class="login-label">
                                    Confirm Password
                                </label>
                                <div class="login-input-wrap">
                                    <i class="bi bi-shield-lock"></i>
                                    <input type="password" name="password_confirmation" required
                                        placeholder="Confirm password" class="form-control login-input">
                                </div>
                            </div>
                            {{-- Button --}}
                            <button type="submit" class="login-btn">
                                Create Account
                                <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </form>
                        {{-- Bottom --}}
                        <div class="text-center mt-4">
                            <div class="login-bottom-text">
                                Already have an account?
                                <a href="{{ route('login') }}" class="login-link">
                                    Sign In
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

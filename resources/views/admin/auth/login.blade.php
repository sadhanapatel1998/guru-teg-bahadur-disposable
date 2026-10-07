<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Finesse By Design</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        :root {
            /* ===============================
               FINESSE BY DESIGN BRAND COLORS
            =============================== */

            --kkt-primary: #0B6FAE;
            --kkt-secondary: #118CC4;
            --kkt-accent: #55B9E1;

            --kkt-blue-dark: #075A91;
            --kkt-blue-light: #EAF6FC;

            --kkt-silver: #AEB6BE;
            --kkt-silver-light: #E8EDF1;
            --kkt-silver-dark: #737D86;

            --kkt-bg: #F5F8FA;
            --kkt-card: #FFFFFF;
            --kkt-light: #EDF6FB;

            --kkt-dark: #151B21;
            --kkt-text: #52606B;
            --kkt-muted: #87939D;

            --kkt-border: #DDE6EC;

            --kkt-shadow:
                0 15px 40px rgba(11, 111, 174, .10),
                0 30px 70px rgba(20, 30, 40, .10);

            --kkt-radius: 22px;
            --kkt-radius-sm: 14px;

            --kkt-gradient:
                linear-gradient(
                    135deg,
                    #075A91 0%,
                    #0B6FAE 38%,
                    #118CC4 70%,
                    #55B9E1 100%
                );

            --kkt-silver-gradient:
                linear-gradient(
                    135deg,
                    #757F88 0%,
                    #AEB6BE 35%,
                    #EEF1F3 65%,
                    #919AA2 100%
                );
        }

        * {
            font-family: 'Rubik', sans-serif;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;

            background:
                radial-gradient(
                    circle at top right,
                    rgba(85, 185, 225, .14),
                    transparent 28%
                ),
                radial-gradient(
                    circle at bottom left,
                    rgba(174, 182, 190, .16),
                    transparent 30%
                ),
                linear-gradient(
                    135deg,
                    #F8FBFD 0%,
                    #EEF5F9 52%,
                    #E5EEF4 100%
                );

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 30px 15px;

            overflow-x: hidden;
        }

        .login-card {
            width: 100%;
            max-width: 440px;

            background: rgba(255, 255, 255, .96);

            border-radius: var(--kkt-radius);

            padding: 42px;

            border: 1px solid rgba(11, 111, 174, .10);

            box-shadow: var(--kkt-shadow);

            position: relative;
            overflow: hidden;

            backdrop-filter: blur(16px);
        }

        /* Premium top accent */
        .login-card::before {
            content: '';

            position: absolute;

            top: 0;
            left: 0;
            right: 0;

            height: 4px;

            background: var(--kkt-gradient);
        }

        /* Decorative blue glow */
        .login-card::after {
            content: '';

            position: absolute;

            top: -90px;
            right: -90px;

            width: 210px;
            height: 210px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(85, 185, 225, .16),
                    rgba(11, 111, 174, .05) 55%,
                    transparent 72%
                );

            pointer-events: none;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 22px;

            position: relative;
            z-index: 2;
        }

        .login-logo img {
            width: 290px;
            height: 115px;

            max-width: 100%;

            object-fit: contain;

            display: block;

            margin: 0 auto;
        }

        .login-heading {
            text-align: center;

            margin-bottom: 28px;

            position: relative;
            z-index: 2;
        }

        .login-heading h1 {
            margin: 0 0 7px;

            font-size: 1.55rem;

            font-weight: 800;

            color: var(--kkt-dark);
        }

        .login-heading p {
            margin: 0;

            font-size: .86rem;

            color: var(--kkt-muted);
        }

        .form-label {
            font-size: .86rem;

            font-weight: 700;

            color: var(--kkt-dark);

            margin-bottom: 8px;
        }

        .input-group {
            border-radius: var(--kkt-radius-sm);

            overflow: hidden;

            border: 1px solid var(--kkt-border);

            transition:
                border-color .25s ease,
                box-shadow .25s ease;

            background: #fff;
        }

        .input-group:focus-within {
            border-color: var(--kkt-primary);

            box-shadow:
                0 0 0 .20rem rgba(11, 111, 174, .10);
        }

        .input-group-text {
            background: #fff;

            border: none;

            color: var(--kkt-primary);

            padding-left: 16px;
            padding-right: 6px;

            font-size: 1rem;
        }

        .form-control {
            border: none;

            height: 52px;

            font-size: .92rem;

            color: var(--kkt-text);

            box-shadow: none !important;

            background: #fff;
        }

        .form-control:focus {
            background: #fff;
        }

        .form-control::placeholder {
            color: #9CA7B0;
        }

        .remember-box {
            display: flex;

            align-items: center;
            justify-content: space-between;

            margin-top: 5px;
            margin-bottom: 26px;
        }

        .form-check-label {
            font-size: .84rem;

            color: var(--kkt-muted);
        }

        .form-check-input {
            border-color: var(--kkt-silver);
        }

        .form-check-input:checked {
            background-color: var(--kkt-primary);
            border-color: var(--kkt-primary);
        }

        .form-check-input:focus {
            border-color: var(--kkt-primary);

            box-shadow:
                0 0 0 .18rem rgba(11, 111, 174, .12);
        }

        .btn-login {
            width: 100%;

            height: 54px;

            border: none;

            border-radius: 14px;

            background: var(--kkt-gradient);

            color: #fff;

            font-weight: 700;

            font-size: .95rem;

            letter-spacing: .3px;

            transition: all .28s ease;

            box-shadow:
                0 12px 26px rgba(11, 111, 174, .24);
        }

        .btn-login:hover {
            background:
                linear-gradient(
                    135deg,
                    #064F80,
                    #0B6FAE 45%,
                    #1596CF
                );

            transform: translateY(-2px);

            color: #fff;

            box-shadow:
                0 16px 34px rgba(11, 111, 174, .30);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login i {
            font-size: 1rem;
        }

        .alert-danger {
            border: 1px solid rgba(220, 53, 69, .12);

            background: rgba(220, 53, 69, .07);

            color: #B42318;

            border-radius: 12px;

            font-size: .84rem;
        }

        /* Small premium divider */
        .premium-divider {
            width: 56px;
            height: 3px;

            margin: 12px auto 0;

            border-radius: 20px;

            background: var(--kkt-silver-gradient);
        }

        @media (max-width: 576px) {
            body {
                padding: 20px 14px;
            }

            .login-card {
                padding: 30px 22px;

                border-radius: 18px;
            }

            .login-logo {
                margin-bottom: 18px;
            }

            .login-logo img {
                width: 230px;
                height: auto;

                max-width: 100%;

                margin: 0 auto;

                object-fit: contain;
            }

            .login-heading {
                margin-bottom: 24px;
            }

            .login-heading h1 {
                font-size: 1.35rem;
            }

            .login-heading p {
                font-size: .8rem;
            }
        }
    </style>
</head>

<body>

    <div class="login-card">

        <div class="login-logo">

            @if (setting('site_logo'))

                <img
                    src="{{ asset('public/storage/' . setting('site_logo')) }}"
                    alt="{{ config('app.name') }}"
                >

            @else

                <img
                    src="{{ base_public_url('assets/img/Finessebydesign.png') }}"
                    alt="{{ config('app.name') }}"
                >

            @endif

        </div>

        <div class="login-heading">

            <p>
                Sign in to manage Finesse By Design
            </p>

            <div class="premium-divider"></div>

        </div>

        @if ($errors->any())

            <div class="alert alert-danger py-2 px-3 mb-4">

                {{ $errors->first() }}

            </div>

        @endif

        <form
            method="POST"
            action="{{ route('admin.login.submit') }}"
        >

            @csrf

            <div class="mb-3">

                <label class="form-label">
                    Email Address
                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-envelope"></i>

                    </span>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        placeholder="admin@gmail.com"
                        required
                        autofocus
                    >

                </div>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Password
                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-lock"></i>

                    </span>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="••••••••"
                        required
                    >

                </div>

            </div>

            <div class="remember-box">

                <div class="form-check">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="remember"
                        id="remember"
                    >

                    <label
                        class="form-check-label"
                        for="remember"
                    >
                        Remember me
                    </label>

                </div>

            </div>

            <button
                type="submit"
                class="btn btn-login"
            >

                <i class="bi bi-shield-lock me-2"></i>

                Sign In

            </button>

        </form>

    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    ></script>

</body>
</html>
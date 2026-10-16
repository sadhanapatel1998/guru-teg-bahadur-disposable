<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) - {{ setting('site_tagline', 'Premium Shopping') }}</title>
    <meta name="description" content="@yield('meta_description', setting('meta_description', ''))">
    <meta name="keywords" content="@yield('meta_keywords', setting('meta_keywords', ''))">

    <meta property="og:title" content="@yield('og_title', config('app.name'))">
    <meta property="og:description" content="@yield('og_description', '')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    {{-- Favicon --}}
    <link rel="icon"
        href="{{ setting('site_favicon') ? asset('public/storage/' . setting('site_favicon')) : asset('images/favicon.png') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ base_public_url('assets/css/style.css') }}">
    @stack('styles')
    <style>
        /* ============================================================
           NAVBAR SHADOW & PURE WHITE BACKGROUND
        ============================================================ */
        .navbar.navbar-kkt {
            background: #FFFFFF !important;
            border-bottom: 1px solid #E8EDF2 !important;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.08), 0 1px 4px rgba(0, 0, 0, 0.04) !important;
        }

        /* ============================================================
           LUXURY SPLIT-PANE MEGA DROPDOWN (DESKTOP)
        ============================================================ */
        .nav-item.dropdown-mega {
            position: relative;
        }

        .nav-item.dropdown-mega > .nav-link {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            color: var(--kkt-dark) !important;
        }

        .nav-item.dropdown-mega:hover > .nav-link {
            background: rgba(30, 58, 95, 0.06) !important;
            color: var(--kkt-primary) !important;
            border-radius: 14px;
        }

        .nav-item.dropdown-mega > .nav-link.dropdown-toggle::after {
            display: inline-block;
            transition: transform 0.25s ease;
            margin-left: 6px;
            vertical-align: 0.15em;
        }

        .nav-item.dropdown-mega:hover > .nav-link.dropdown-toggle::after {
            transform: rotate(180deg);
        }

        @media (min-width: 992px) {
            .mega-category-dropdown {
                position: absolute !important;
                top: 80% !important;
                left: 0 !important;
                width: 280px !important;
                min-width: 260px !important;
                max-width: 320px !important;
                background: #FFFFFF !important;
                border: 1px solid #E2E8F0 !important;
                border-radius: 18px !important;
                padding: 8px !important;
                margin-top: 8px !important;
                box-shadow:
                    0 10px 30px rgba(11, 111, 174, 0.08),
                    0 20px 45px rgba(15, 23, 42, 0.12) !important;
                display: none;
                opacity: 0;
                visibility: hidden;
                transform: translateY(10px);
                transition: opacity 0.22s ease, transform 0.22s ease, visibility 0.22s ease;
                overflow: hidden;
                z-index: 1050;
            }

            .nav-item.dropdown-mega:hover .mega-category-dropdown,
            .nav-item.dropdown-mega .mega-category-dropdown.show {
                display: block !important;
                opacity: 1 !important;
                visibility: visible !important;
                transform: translateY(0) !important;
            }

            .mega-desktop-wrapper {
                display: block !important;
                width: 100%;
            }

            .mega-mobile-wrapper {
                display: none !important;
            }
        }

        @media (min-width: 992px) and (max-width: 1199px) {
            .mega-category-dropdown {
                left: 0 !important;
                width: 270px !important;
                min-width: 260px !important;
                max-width: 300px !important;
            }
        }

        /* Categories Dropdown List */
        .mega-cat-sidebar {
            width: 100%;
            background: #FFFFFF;
            border-right: none;
            padding: 4px;
            display: flex;
            flex-direction: column;
            max-height: 480px;
            overflow-y: auto;
        }

        .mega-cat-sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .mega-cat-sidebar::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 4px;
        }

        .mega-sidebar-header {
            padding: 6px 12px 10px 12px;
            border-bottom: 1px solid #E8EDF2;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .mega-sidebar-title {
    font-size: 13px;
    font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #64748B;
        }

        .mega-sidebar-count {
            font-family: 'Poppins', sans-serif;
            font-size: 10.5px;
            font-weight: 600;
            color: #0B6FAE;
            background: #E0F2FE;
            padding: 2px 7px;
            border-radius: 10px;
        }

        .mega-cat-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .mega-cat-item {
            margin: 0;
        }

        .mega-cat-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 9px 14px;
            border-radius: 10px;
            text-decoration: none;
            color: #1E293B;
          font-size: 14.5px;
            font-weight: 500;
            transition: all 0.2s cubic-bezier(0.25, 0.8, 0.25, 1);
            border: 1px solid transparent;
        }

        .mega-arrow {
            font-size: 11px;
            color: #94A3B8;
            transition: transform 0.2s ease, color 0.2s ease;
        }

        .mega-cat-link:hover,
        .mega-cat-item.active .mega-cat-link {
            background: #F0F7FD;
            color: #0B6FAE;
            font-weight: 600;
            border-color: rgba(11, 111, 174, 0.25);
            transform: translateX(3px);
            box-shadow: 0 2px 8px rgba(11, 111, 174, 0.08);
        }

        .mega-cat-link:hover .mega-arrow,
        .mega-cat-item.active .mega-arrow {
            color: #0B6FAE;
            transform: translateX(3px);
        }

        .mega-cat-footer {
            border-top: 1px solid #E8EDF2;
            margin-top: 8px;
            padding-top: 8px;
        }

        .mega-cat-footer-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            border-radius: 8px;
            background: #F8FAFC;
            color: #0B6FAE;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .mega-cat-footer-link:hover {
            background: #E0F2FE;
            color: #09446B;
        }

        /* ============================================================
           MOBILE CATEGORIES DROPDOWN (< 992px)
        ============================================================ */
        @media (max-width: 991.98px) {
            .nav-item.dropdown-mega {
                width: 100% !important;
                position: relative !important;
            }

            .nav-item.dropdown-mega > .nav-link.dropdown-toggle {
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                width: 100% !important;
                padding: 14px 16px !important;
                border-radius: 14px !important;
                background: transparent !important;
                border: none !important;
                box-shadow: none !important;
                cursor: pointer !important;
            }

            .nav-item.dropdown-mega > .nav-link.dropdown-toggle::after {
                display: inline-block !important;
                margin-left: auto !important;
                font-size: 14px;
                transition: transform 0.25s ease;
            }

            .nav-item.dropdown-mega.open > .nav-link.dropdown-toggle::after,
            .nav-item.dropdown-mega > .nav-link[aria-expanded="true"]::after {
                transform: rotate(180deg) !important;
            }

            .mega-category-dropdown {
                position: static !important;
                transform: none !important;
                float: none !important;
                width: 100% !important;
                min-width: 100% !important;
                max-width: 100% !important;
                background: #F8FAFC !important;
                border: 1px solid #E2E8F0 !important;
                border-radius: 16px !important;
                box-shadow: none !important;
                padding: 10px !important;
                margin-top: 8px !important;
                margin-bottom: 8px !important;
                display: none !important;
                opacity: 1 !important;
                visibility: visible !important;
            }

            .nav-item.dropdown-mega.open > .mega-category-dropdown,
            .mega-category-dropdown.show {
                display: block !important;
            }

            .mega-desktop-wrapper {
                display: none !important;
            }

            .mega-mobile-wrapper {
                display: block !important;
            }

            .mobile-all-products-btn {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 11px 16px;
                background: linear-gradient(135deg, #0A4F7D 0%, #0B6FAE 100%);
                color: #FFFFFF !important;
                border-radius: 12px;
                text-decoration: none;
                font-family: 'Poppins', sans-serif;
                font-size: 13px;
                font-weight: 600;
                margin-bottom: 8px;
                box-shadow: 0 4px 12px rgba(11, 111, 174, 0.2);
            }

            .mobile-all-products-btn span {
                font-size: 12px;
                opacity: 0.9;
            }

            .mobile-cat-list-wrap {
                display: flex;
                flex-direction: column;
                gap: 6px;
            }

            .mobile-cat-direct-link {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 11px 14px;
                background: #FFFFFF;
                border: 1px solid #E8EDF2;
                border-radius: 12px;
                text-decoration: none;
                color: #1E293B;
                font-family: 'Poppins', sans-serif;
                font-size: 13.5px;
                font-weight: 500;
                transition: all 0.2s ease;
            }

            .mobile-cat-direct-link:hover,
            .mobile-cat-direct-link:active {
                background: #F0F7FD;
                color: #0B6FAE;
                border-color: rgba(11, 111, 174, 0.3);
            }

            .mobile-cat-direct-link i {
                font-size: 12px;
                color: #94A3B8;
            }
        }

        /* ============================================================
           GTB MODERN 3-TIER HEADER & STICKY NAVIGATION STYLES
        ============================================================ */
        :root {
            --gtb-navy: #0B3A63;
            --gtb-navy-dark: #072642;
            --gtb-red: #D9232E;
            --gtb-red-hover: #B71923;
        }

        /* Tier 1: Top Bar */
        .gtb-topbar {
            background-color: var(--gtb-navy) !important;
            color: #FFFFFF;
            font-size: 13px;
            padding: 7px 0;
            line-height: 1.4;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .gtb-topbar-link {
            color: rgba(255, 255, 255, 0.92) !important;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 12.5px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .gtb-topbar-link:hover {
            color: #FFFFFF !important;
            opacity: 1;
        }

        .gtb-topbar-link i {
            font-size: 13px;
            color: #FFFFFF;
        }

        .gtb-topbar-divider {
            color: rgba(255, 255, 255, 0.35);
            margin: 0 14px;
            font-size: 12px;
            user-select: none;
        }

        .gtb-follow-text {
            color: rgba(255, 255, 255, 0.9);
            font-size: 12.5px;
            font-weight: 600;
            margin-right: 12px;
            letter-spacing: 0.2px;
        }

        .gtb-social-links {
            gap: 8px;
        }

        .gtb-social-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.14);
            color: #FFFFFF !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none !important;
            font-size: 13px;
            transition: all 0.25s ease;
        }

        .gtb-social-icon:hover {
            background: var(--gtb-red);
            color: #FFFFFF !important;
            transform: translateY(-2px);
        }

        /* Tier 2: Middle Header */
        .gtb-mid-header {
            background: #FFFFFF;
            padding: 0px 0;
            border-bottom: 1px solid #F1F5F9;
            transition: padding 0.25s ease;
        }

        .gtb-brand-col {
            flex-shrink: 0;
        }

        .gtb-brand-link {
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
        }

        .gtb-header-logo {
            height: 68px;
            max-height: 68px;
            width: auto !important;
            max-width: 280px !important;
            object-fit: contain !important;
            display: block !important;
            transition: height 0.25s ease, max-height 0.25s ease;
        }

        .gtb-header-logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.15;
        }

        .gtb-logo-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 21px;
            color: var(--gtb-navy);
            letter-spacing: -0.5px;
        }

        .gtb-logo-sub {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 11px;
            color: var(--gtb-red);
            letter-spacing: 2.2px;
        }

        /* Pill Search Bar */
        .gtb-search-col {
            flex: 1;
            max-width: 580px;
            margin: 0 24px;
        }

        .gtb-search-form {
            position: relative;
            width: 100%;
        }

        .gtb-search-input-wrap {
            position: relative;
            width: 100%;
            display: flex;
            align-items: center;
        }

        .gtb-search-input {
            width: 100%;
            height: 48px;
            border-radius: 50px;
            border: 1.5px solid #CBD5E1;
            background: #F8FAFC;
            padding: 10px 52px 10px 22px;
            font-size: 14px;
            color: #0F172A;
            font-weight: 400;
            outline: none;
            transition: all 0.25s ease;
        }

        .gtb-search-input:focus {
            background: #FFFFFF;
            border-color: var(--gtb-navy);
            box-shadow: 0 0 0 3px rgba(11, 58, 99, 0.1);
        }

        .gtb-search-input::placeholder {
            color: #94A3B8;
            font-size: 13.5px;
        }

        .gtb-search-btn {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--gtb-red);
            color: #FFFFFF;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .gtb-search-btn:hover {
            background: var(--gtb-red-hover);
            transform: translateY(-50%) scale(1.04);
        }

        /* Live Search Dropdown */
        .gtb-search-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            right: 0;
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            box-shadow: 0 14px 40px rgba(15, 23, 42, 0.12);
            max-height: 380px;
            overflow-y: auto;
            z-index: 1100;
            padding: 8px;
        }

        .gtb-search-dropdown .search-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 10px;
            text-decoration: none !important;
            transition: background 0.2s ease;
            border-bottom: 1px solid #F1F5F9;
        }

        .gtb-search-dropdown .search-item:last-child {
            border-bottom: none;
        }

        .gtb-search-dropdown .search-item:hover {
            background: #F8FAFC;
        }

        .gtb-search-dropdown .search-item img {
            width: 44px;
            height: 44px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #E2E8F0;
        }

        /* Action Blocks (Help, Account, Cart) */
        .gtb-actions-col {
            gap: 20px;
            flex-shrink: 0;
        }

        .gtb-action-item {
            display: flex;
            align-items: center;
            gap: 11px;
            text-decoration: none !important;
            color: #0F172A !important;
            transition: transform 0.2s ease;
        }

        .gtb-action-icon {
            width: 44px;
            height: 44px;
            min-width: 44px;
            border-radius: 50%;
            background: #EEF4F9;
            border: 1px solid rgba(226, 232, 240, 0.8);
            color: var(--gtb-navy);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            transition: all 0.25s ease;
        }

        .gtb-action-item:hover .gtb-action-icon {
            background: #E2ECF5;
            border-color: #CBD5E1;
            color: var(--gtb-navy);
        }

        /* Cart action item - exact replica of shared design */
        .gtb-cart-item {
            display: inline-flex;
            align-items: center;
            gap: 11px;
            text-decoration: none !important;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .gtb-cart-item:hover {
            transform: translateY(-1px);
        }

        .gtb-cart-icon-wrap {
            width: 46px;
            height: 46px;
            min-width: 46px;
            border-radius: 50%;
            background: #EEF4F9;
            border: 1px solid rgba(226, 232, 240, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .gtb-cart-item:hover .gtb-cart-icon-wrap {
            background: #E4EEF7;
            border-color: #CBD5E1;
            box-shadow: 0 4px 12px rgba(11, 58, 99, 0.08);
        }

        .gtb-cart-bag-icon {
            stroke: #073863;
            transition: transform 0.2s ease;
        }

        .gtb-cart-item:hover .gtb-cart-bag-icon {
            transform: scale(1.05);
        }

        .gtb-cart-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 20px;
            height: 20px;
            min-width: 20px;
            border-radius: 50%;
            background: #D9232E;
            color: #FFFFFF;
            font-family: 'Poppins', sans-serif;
            font-size: 11px;
            font-weight: 700;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #FFFFFF;
            box-shadow: 0 2px 6px rgba(217, 35, 46, 0.45);
            transition: transform 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes cartPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.28); }
            100% { transform: scale(1); }
        }

        .cart-badge-updated {
            animation: cartPulse 0.35s ease;
        }

        .gtb-action-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
            line-height: 1.15;
        }

        .gtb-action-label {
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            color: #5B738B;
            font-weight: 500;
            margin-bottom: 2px;
            letter-spacing: 0.1px;
        }

        .gtb-action-val {
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            color: var(--gtb-navy);
            font-weight: 700;
            white-space: nowrap;
        }

        .gtb-cart-total {
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            color: #D9232E;
            font-weight: 700;
            white-space: nowrap;
            letter-spacing: -0.2px;
            transition: color 0.2s ease;
        }

        .gtb-account-dropdown .dropdown-toggle::after {
            display: none;
        }

        .gtb-user-menu {
            border-radius: 14px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.1);
            padding: 8px;
            min-width: 190px;
        }

        .gtb-user-menu .dropdown-item {
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 13px;
            font-weight: 500;
            color: #1E293B;
        }

        .gtb-user-menu .dropdown-item:hover {
            background: #F8FAFC;
            color: var(--gtb-navy);
        }

        .gtb-mobile-icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #F1F5F9;
            color: var(--gtb-navy);
            border: 1px solid #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            padding: 0;
            text-decoration: none !important;
            transition: all 0.2s ease;
        }

        .gtb-mobile-icon-btn:hover {
            background: var(--gtb-navy);
            color: #FFFFFF;
        }

        .gtb-mobile-toggler {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 1px solid #E2E8F0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #FFFFFF;
        }

        .gtb-mobile-toggler:focus {
            box-shadow: none;
        }

        /* ============================================================
           COMBINED STICKY HEADER CONTAINER (Tier 2 Middle Header + Tier 3 Nav Bar)
           Both Middle Header and Navigation Bar stick together on scroll
        ============================================================ */
        .gtb-sticky-header-combo {
            position: -webkit-sticky !important;
            position: sticky !important;
            top: 0 !important;
            z-index: 1040 !important;
            width: 100% !important;
            background: #FFFFFF !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            transition: box-shadow 0.25s ease, background-color 0.25s ease;
        }

        .gtb-sticky-header-combo.is-stuck {
            box-shadow: 0 8px 25px rgba(11, 58, 99, 0.12) !important;
        }

        /* Subtle compacting on scroll */
        /* .gtb-sticky-header-combo.is-stuck .gtb-mid-header {
            padding: 7px 0 !important;
        } */

        /* .gtb-sticky-header-combo.is-stuck .gtb-header-logo {
            height: 52px !important;
            max-height: 52px !important;
        } */

        .gtb-sticky-header-combo.is-stuck .gtb-action-icon {
            width: 38px !important;
            height: 38px !important;
            min-width: 38px !important;
            font-size: 17px !important;
        }

        .gtb-sticky-header-combo.is-stuck .gtb-cart-icon-wrap {
            width: 40px !important;
            height: 40px !important;
            min-width: 40px !important;
        }

        .gtb-sticky-header-combo.is-stuck .gtb-nav-link {
            padding-top: 10px !important;
            padding-bottom: 10px !important;
        }

        /* Tier 3: Navigation Bar inside sticky combo */
        #gtb-sticky-nav-header.gtb-main-sticky-nav {
            position: relative !important;
            top: auto !important;
            z-index: 1040 !important;
            width: 100% !important;
            background: #FFFFFF !important;
            border-top: 1px solid #EEF2F6;
            border-bottom: 1px solid #E2E8F0;
            box-shadow: none !important;
        }

        .gtb-sticky-nav-inner {
            min-height: 52px;
            position: relative;
            width: 100%;
        }

        /* Navigation List */
        .gtb-nav-list {
            display: flex;
            align-items: center;
            gap: 2px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .gtb-nav-item {
            position: relative;
        }

        #gtb-sticky-nav-header .gtb-nav-link {
            position: relative;
            display: inline-flex;
            align-items: center;
            padding: 15px 18px !important;
            font-family: 'Poppins', sans-serif !important;
            font-size: 16px !important;
            font-weight: 500 !important;
            color: #1E293B !important;
            text-decoration: none !important;
            transition: color 0.2s ease;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            border-radius: 0 !important;
        }

        #gtb-sticky-nav-header .gtb-nav-link:hover {
            color: var(--gtb-red) !important;
            background: transparent !important;
        }

        /* Active Indicator Tab */
        #gtb-sticky-nav-header .gtb-nav-link.active {
            color: var(--gtb-red) !important;
            background: transparent !important;
        }

        #gtb-sticky-nav-header .gtb-nav-link.active::after,
        #gtb-sticky-nav-header .gtb-nav-link:hover::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 18px;
            right: 18px;
            height: 3px;
            background: var(--gtb-red);
            border-radius: 3px 3px 0 0;
        }

        /* Dropdown Chevron */
        #gtb-sticky-nav-header .gtb-nav-link.dropdown-toggle::after {
            display: inline-block;
            margin-left: 6px;
            vertical-align: 0.15em;
            transition: transform 0.25s ease;
        }

        #gtb-sticky-nav-header .gtb-nav-item:hover > .gtb-nav-link.dropdown-toggle::after {
            transform: rotate(180deg);
        }

        /* Right Side Trust Badges (Matching Shared Reference Design) */
        .gtb-nav-features {
            display: flex;
            align-items: center;
            margin-left: auto;
            flex-shrink: 0;
            gap: 0;
        }

        .gtb-feature-block {
            display: flex;
            align-items: center;
            padding: 0 16px;
        }

        .gtb-feature-block:first-child {
            padding-left: 0;
        }

        .gtb-feature-block:last-child {
            padding-right: 0;
        }

        .gtb-feature-divider {
            width: 1px;
            height: 28px;
            background-color: #E2E8F0;
            flex-shrink: 0;
        }

        .gtb-feature-icon-wrap {
            color: #0B3A63;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-right: 9px;
        }

        .gtb-feature-icon-wrap svg {
            width: 26px;
            height: 26px;
            display: block;
        }

        .gtb-feature-text-wrap {
            display: flex;
            flex-direction: column;
            line-height: 1.25;
        }

        .gtb-feature-title {
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 500;
            color: #0B3A63;
            white-space: nowrap;
            letter-spacing: -0.2px;
        }

        .gtb-feature-sub {
            font-family: 'Inter', sans-serif;
            font-size: 11.5px;
            font-weight: 400;
            color: #64748B;
            white-space: nowrap;
        }

        @media (min-width: 992px) and (max-width: 1199.98px) {
            .gtb-feature-block {
                padding: 0 10px;
            }

            .gtb-feature-title {
                font-size: 12px;
            }

            .gtb-feature-sub {
                font-size: 11px;
            }

            .gtb-feature-icon-wrap svg {
                width: 22px;
                height: 22px;
            }

            #gtb-sticky-nav-header .gtb-nav-link {
                padding: 15px 12px !important;
                font-size: 13.5px;
            }
        }

        /* Responsive Mobile & Tablet */
        @media (max-width: 991.98px) {
            .gtb-topbar {
                font-size: 11.5px;
                padding: 6px 0;
            }

            .gtb-topbar-left {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
                gap: 6px 12px;
            }

            .gtb-topbar-right {
                display: none !important;
            }

            .gtb-topbar-divider {
                margin: 0 4px;
            }

            .gtb-header-logo {
                height: 48px !important;
                max-height: 48px !important;
            }

            .gtb-logo-title {
                font-size: 17px;
            }

            .gtb-logo-sub {
                font-size: 9px;
            }

            .gtb-sticky-nav-inner {
                min-height: auto;
            }

            #gtb-sticky-nav-header.gtb-main-sticky-nav {
                border-top: none !important;
            }

            .gtb-nav-features {
                display: none !important;
            }

            /* Mobile Dropdown Menu */
            .gtb-nav-collapse.collapse:not(.show) {
                display: none !important;
            }

            .gtb-nav-collapse.collapsing {
                transition: height 0.25s ease;
            }

            .gtb-nav-collapse.collapse.show {
                display: block !important;
                background: #FFFFFF;
                border-top: 1px solid #E2E8F0;
                padding: 12px 0 16px 0;
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
            }

            .gtb-nav-list {
                flex-direction: column;
                align-items: stretch;
                padding: 0 12px;
                gap: 4px;
            }

            #gtb-sticky-nav-header .gtb-nav-link {
                padding: 11px 14px !important;
                border-radius: 10px !important;
                font-size: 14px;
                width: 100%;
            }

            #gtb-sticky-nav-header .gtb-nav-link.active::after,
            #gtb-sticky-nav-header .gtb-nav-link:hover::after {
                display: none !important;
            }

            #gtb-sticky-nav-header .gtb-nav-link.active {
                background: #FEF2F2 !important;
                color: var(--gtb-red) !important;
            }
        }
    </style>
</head>

<body>

    {{-- ============================================================
         GTB HEADER SECTION (3-TIER MODERN DESIGN)
    ============================================================ --}}
    {{-- Tier 1: Top Bar (Navy Blue) - Scrolls away naturally --}}
    <div class="gtb-topbar">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="gtb-topbar-left d-flex align-items-center">
                <a href="mailto:{{ setting('site_email', 'info@GTBdisposable.com') }}" class="gtb-topbar-link">
                    <i class="bi bi-envelope"></i>
                    <span>{{ setting('site_email', 'info@GTBdisposable.com') }}</span>
                </a>
                <span class="gtb-topbar-divider">|</span>
                <a href="tel:{{ setting('site_phone', '+91 9310099249') }}" class="gtb-topbar-link">
                    <i class="bi bi-telephone"></i>
                    <span>{{ setting('site_phone', '+91 9310099249') }}</span>
                </a>
            </div>

            <div class="gtb-topbar-right d-flex align-items-center">
                <span class="gtb-follow-text">Follow Us</span>
                <div class="gtb-social-links d-flex align-items-center">
                    <a href="{{ setting('social_facebook', 'https://www.facebook.com/') }}" target="_blank" rel="noopener" class="gtb-social-icon" title="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="{{ setting('social_instagram', 'https://www.instagram.com/') }}" target="_blank" rel="noopener" class="gtb-social-icon" title="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="{{ setting('social_linkedin', '#') }}" target="_blank" rel="noopener" class="gtb-social-icon" title="LinkedIn">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    <a href="{{ setting('social_youtube', '#') }}" target="_blank" rel="noopener" class="gtb-social-icon" title="YouTube">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- COMBINED STICKY HEADER (Tier 2 Middle Header + Tier 3 Nav Bar) --}}
    {{-- Both Middle Header and Navigation Bar stick together on scroll at top: 0 --}}
    <header id="gtb-sticky-header-combo" class="gtb-header-wrapper gtb-sticky-header-combo">
        {{-- Tier 2: Middle Header (Logo, Centered Pill Search, 3 Action Blocks) - Desktop --}}
        <div class="gtb-mid-header d-none d-lg-block">
            <div class="container">
                <div class="gtb-mid-inner d-flex align-items-center justify-content-between">
                    {{-- Logo --}}
                    <div class="gtb-brand-col">
                        <a class="gtb-brand-link" href="{{ route('home') }}">
                            @if (setting('site_logo'))
                                <img src="{{ asset('public/storage/' . setting('site_logo')) }}" alt="{{ config('app.name', 'Guru Teg Bahadur Disposable') }}" class="gtb-header-logo" style="width:auto; max-width:280px; object-fit:contain;">
                            @else
                                <span class="gtb-header-logo-text">
                                    <span class="gtb-logo-title">GURU TEG BAHADUR</span>
                                    <span class="gtb-logo-sub">DISPOSABLE CROCKERY</span>
                                </span>
                            @endif
                        </a>
                    </div>

                    {{-- Search Bar (Desktop) --}}
                    <div class="gtb-search-col">
                        <form action="{{ route('shop') }}" method="GET" class="gtb-search-form" role="search">
                            <div class="gtb-search-input-wrap">
                                <input type="search"
                                       name="q"
                                       id="search-input"
                                       class="gtb-search-input"
                                       placeholder="Search for products, categories..."
                                       value="{{ request('q') }}"
                                       autocomplete="off"
                                       aria-label="Search products">
                                <button type="submit" class="gtb-search-btn" aria-label="Search">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                            <div id="search-results-dropdown" class="gtb-search-dropdown d-none"></div>
                        </form>
                    </div>

                    {{-- Action Blocks (Help, Account, Cart) on Desktop --}}
                    <div class="gtb-actions-col d-flex align-items-center">
                        {{-- Action 1: Need Help? --}}
                        <a href="tel:{{ setting('site_phone', '+91 9310099249') }}" class="gtb-action-item">
                            <div class="gtb-action-icon">
                                <i class="bi bi-headset"></i>
                            </div>
                            <div class="gtb-action-info">
                                <span class="gtb-action-label">Need Help?</span>
                                <span class="gtb-action-val">{{ setting('site_phone', '+91 9310099249') }}</span>
                            </div>
                        </a>

                        {{-- Action 2: Login / My Account --}}
                        @auth
                            <div class="dropdown gtb-account-dropdown">
                                <a href="#" class="gtb-action-item dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="gtb-action-icon">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <div class="gtb-action-info">
                                        <span class="gtb-action-label">Hello,</span>
                                        <span class="gtb-action-val">{{ Str::words(Auth::user()->name, 1, '') }}</span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end gtb-user-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('account.dashboard') }}">
                                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('account.orders') }}">
                                            <i class="bi bi-box-seam me-2"></i> My Orders
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('account.profile') }}">
                                            <i class="bi bi-person me-2"></i> My Profile
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="gtb-action-item">
                                <div class="gtb-action-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div class="gtb-action-info">
                                    <span class="gtb-action-label">Sign In</span>
                                    <span class="gtb-action-val">My Account</span>
                                </div>
                            </a>
                        @endauth

                        {{-- Action 3: Cart (Exact match of shared design) --}}
                        @php
                            $cartTotalAmount = app(\App\Services\CartService::class)->totals()['subtotal'] ?? 0;
                            $cartCount = app(\App\Services\CartService::class)->count();
                        @endphp
                        <a href="{{ route('cart.index') }}" class="gtb-cart-item" title="View Cart">
                            <div class="gtb-cart-icon-wrap position-relative">
                                <svg class="gtb-cart-bag-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#073863" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="4" y="8" width="16" height="13" rx="2" ry="2"></rect>
                                    <path d="M8 8V6a4 4 0 0 1 8 0v2"></path>
                                </svg>
                                <span class="gtb-cart-badge" id="desktop-cart-count">
                                    {{ $cartCount }}
                                </span>
                            </div>
                            <div class="gtb-action-info">
                                <span class="gtb-action-label">Cart</span>
                                <span class="gtb-cart-total">₹{{ number_format($cartTotalAmount, 2) }}</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tier 3: Sticky Navigation Bar with Unique ID & Class --}}
    <nav id="gtb-sticky-nav-header" class="navbar navbar-expand-lg gtb-main-sticky-nav py-0">
        <div class="container">
            {{-- Mobile Row (< 992px) with Logo, Search, Cart & Menu toggler --}}
            <div class="gtb-mobile-bar d-flex d-lg-none align-items-center justify-content-between w-100 py-2">
                <a class="gtb-brand-link" href="{{ route('home') }}">
                    @if (setting('site_logo'))
                        <img src="{{ asset('public/storage/' . setting('site_logo')) }}" alt="{{ config('app.name', 'Guru Teg Bahadur Disposable') }}" class="gtb-mobile-logo" style="height: 60px; max-height: 62px; width: auto; max-width: 200px; object-fit: contain;">
                    @else
                        <span class="gtb-logo-title fs-5">GTB Crockery</span>
                    @endif
                </a>

                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn gtb-mobile-icon-btn" data-bs-toggle="collapse" data-bs-target="#gtbMobileSearchCollapse" aria-label="Search">
                        <i class="bi bi-search"></i>
                    </button>
                    <a href="{{ route('cart.index') }}" class="btn gtb-mobile-icon-btn position-relative" title="Cart">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#073863" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="8" width="16" height="13" rx="2" ry="2"></rect>
                            <path d="M8 8V6a4 4 0 0 1 8 0v2"></path>
                        </svg>
                        <span class="gtb-cart-badge" id="mobile-cart-count">
                            {{ $cartCount }}
                        </span>
                    </a>
                    <button class="navbar-toggler gtb-mobile-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#gtbNavCollapse" aria-controls="gtbNavCollapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>

            {{-- Mobile Collapsible Search --}}
            <div class="collapse d-lg-none w-100" id="gtbMobileSearchCollapse">
                <form action="{{ route('shop') }}" method="GET" class="gtb-search-form pb-2 pt-1 position-relative" role="search">
                    <div class="gtb-search-input-wrap">
                        <input type="search"
                               name="q"
                               id="mobile-search-input"
                               class="gtb-search-input"
                               placeholder="Search products, categories...
"
                               value="{{ request('q') }}"
                               autocomplete="off">
                        <button type="submit" class="gtb-search-btn" aria-label="Search">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    <div class="gtb-search-dropdown d-none"></div>
                </form>
            </div>

            <div class="gtb-sticky-nav-inner d-flex align-items-center justify-content-between w-100">
                {{-- Navigation Menu (Desktop & Collapsible for Mobile) --}}
                <div class="collapse navbar-collapse gtb-nav-collapse" id="gtbNavCollapse">
                    {{-- Nav Links List --}}
                    <ul class="gtb-nav-list navbar-nav me-auto">
                        <li class="gtb-nav-item nav-item">
                            <a class="gtb-nav-link nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                Home
                            </a>
                        </li>

                        <li class="gtb-nav-item nav-item">
                            <a class="gtb-nav-link nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                                About
                            </a>
                        </li>

                        @php
                            $categories = \App\Models\Category::active()->orderBy('name')->get();
                        @endphp
                        <li class="gtb-nav-item nav-item dropdown-mega">
                            <a class="gtb-nav-link nav-link dropdown-toggle"
                               href="{{ route('shop') }}"
                               role="button"
                               id="productsMenuToggle"
                               aria-expanded="false">
                                <span>Categories</span>
                            </a>

                            {{-- SINGLE UNIFIED CATEGORIES DROPDOWN MENU FOR DESKTOP & MOBILE --}}
                            <div class="mega-category-dropdown">
                                {{-- DESKTOP VIEW (>= 992px) --}}
                                <div class="mega-desktop-wrapper d-none d-lg-block">
                                    <div class="mega-cat-sidebar">
                                        <div class="mega-sidebar-header">
                                            <span class="mega-sidebar-title">Categories</span>
                                            <span class="mega-sidebar-count">{{ $categories->count() }}</span>
                                        </div>
                                        <ul class="mega-cat-list">
                                            @foreach ($categories as $cat)
                                                <li class="mega-cat-item">
                                                    <a href="{{ route('shop.category', $cat->slug) }}" class="mega-cat-link">
                                                        <span class="mega-cat-name">{{ $cat->name }}</span>
                                                        <i class="bi bi-chevron-right mega-arrow"></i>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="mega-cat-footer">
                                            <a href="{{ route('shop') }}" class="mega-cat-footer-link">
                                                <span>All Products & Categories</span>
                                                <i class="bi bi-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                {{-- MOBILE VIEW (< 992px) --}}
                                <div class="mega-mobile-wrapper d-lg-none">
                                    {{-- Direct Link to All Products --}}
                                    <a href="{{ route('shop') }}" class="mobile-all-products-btn">
                                        <span class="d-flex align-items-center gap-2">
                                            <i class="bi bi-grid"></i>
                                            <strong>All Products</strong>
                                        </span>
                                        <span>Explore Catalog &rarr;</span>
                                    </a>

                                    <div class="mobile-cat-list-wrap">
                                        @foreach ($categories as $cat)
                                            <a href="{{ route('shop.category', $cat->slug) }}" class="mobile-cat-direct-link">
                                                <span>{{ $cat->name }}</span>
                                                <i class="bi bi-chevron-right"></i>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="gtb-nav-item nav-item">
                            <a class="gtb-nav-link nav-link {{ request()->routeIs('shop') ? 'active' : '' }}" href="{{ route('shop') }}">
                                Shops
                            </a>
                        </li>
                        <li class="gtb-nav-item nav-item">
                            <a class="gtb-nav-link nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}" href="{{ route('blog.index') }}">
                                Blogs
                            </a>
                        </li>
                        <li class="gtb-nav-item nav-item">
                            <a class="gtb-nav-link nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                                Contact
                            </a>
                        </li>
                    </ul>

                    {{-- Mobile User & Quick Links Drawer Section (< 992px) --}}
                    <div class="d-lg-none mt-3 pt-3 border-top px-3">
                        @auth
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="gtb-action-icon" style="width:36px; height:36px; min-width:36px;">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold fs-6">{{ Auth::user()->name }}</div>
                                        <div class="text-muted small">{{ Auth::user()->email }}</div>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Logout</button>
                                </form>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('account.dashboard') }}" class="btn btn-sm btn-primary flex-fill">Dashboard</a>
                                <a href="{{ route('account.orders') }}" class="btn btn-sm btn-outline-secondary flex-fill">Orders</a>
                            </div>
                        @else
                            <div class="d-flex gap-2 mb-2">
                                <a href="{{ route('login') }}" class="btn btn-sm btn-primary flex-fill">Login / Account</a>
                            </div>
                        @endauth
                        <div class="mt-3 pt-2 border-top text-center">
                            <a href="tel:{{ setting('site_phone', '+91 9310099249') }}" class="text-decoration-none text-muted small">
                                <i class="bi bi-telephone me-1 text-danger"></i> Need Help? {{ setting('site_phone', '+91 9310099249') }}
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Right Side Trust / Feature Badges (Desktop Only, matching shared reference) --}}
                <div class="gtb-nav-features d-none d-lg-flex align-items-center">
                    {{-- Feature 1: Wide Range of Products --}}
                    <div class="gtb-feature-block">
                        <div class="gtb-feature-icon-wrap">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 9h4" />
                                <path d="M1 13h5" />
                                <path d="M3 17h3" />
                                <path d="M9 17h1" />
                                <path d="M13 17h4" />
                                <circle cx="11.5" cy="17.5" r="2" />
                                <circle cx="18.5" cy="17.5" r="2" />
                                <path d="M8 5h7a1 1 0 0 1 1 1v11" />
                                <path d="M16 8h3.3a1 1 0 0 1 .8.4l2.5 3.3a1 1 0 0 1 .4.6V16a1 1 0 0 1-1 1h-1.5" />
                            </svg>
                        </div>
                        <div class="gtb-feature-text-wrap">
                            <span class="gtb-feature-title">Wide Range</span>
                            <span class="gtb-feature-sub">of Products</span>
                        </div>
                    </div>

                    <div class="gtb-feature-divider"></div>

                    {{-- Feature 2: Bulk & Retail Supply --}}
                    <div class="gtb-feature-block">
                        <div class="gtb-feature-icon-wrap">
                            <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                <path d="m9 12 2 2 4-4" />
                            </svg>
                        </div>
                        <div class="gtb-feature-text-wrap">
                            <span class="gtb-feature-title">Bulk &amp; Retail</span>
                            <span class="gtb-feature-sub">Supply</span>
                        </div>
                    </div>

                    <div class="gtb-feature-divider"></div>

                    {{-- Feature 3: Trusted by Homes, Businesses & Caterers --}}
                    <div class="gtb-feature-block">
                        <div class="gtb-feature-icon-wrap">
                            <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </div>
                        <div class="gtb-feature-text-wrap">
                            <span class="gtb-feature-title">Trusted by Homes,</span>
                            <span class="gtb-feature-sub">Businesses &amp; Caterers</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

    {{-- Flash Messages --}}
    @if (session('success') || session('error'))
        <div class="toast-container">
            <div class="toast show align-items-center text-white {{ session('success') ? 'bg-success' : 'bg-danger' }} border-0"
                role="alert">
                <div class="d-flex">
                    <div class="toast-body">{{ session('success') ?? session('error') }}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    @yield('content')
    
    {{-- GTB MODERN FOOTER (MATCHING SHARED DESIGN) --}}
    <footer class="gw-footer gtb-modern-footer" style="
            background: radial-gradient(circle at bottom left, rgba(17,140,196,.04), transparent 30%),
                        linear-gradient(180deg, #FFFFFF 0%, #F6F9FB 100%);
        ">
        <div class="container">
            {{-- Top Feature Strip (Floating Card) --}}
            <div class="gtb-footer-features-card">
                {{-- Feature 1: Wide Range of Products --}}
                <div class="gtb-ff-item">
                    <div class="gtb-ff-icon-wrap gtb-ff-icon-pink">
                        <i class="bi bi-cart3"></i>
                    </div>
                    <div class="gtb-ff-content">
                        <h6 class="gtb-ff-title">Wide Range of Products</h6>
                        <span class="gtb-ff-sub">Everything for your business needs</span>
                    </div>
                </div>

                <div class="gtb-ff-divider d-none d-lg-block"></div>

                {{-- Feature 2: Quality You Can Trust --}}
                <div class="gtb-ff-item">
                    <div class="gtb-ff-icon-wrap gtb-ff-icon-blue">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div class="gtb-ff-content">
                        <h6 class="gtb-ff-title">Quality You Can Trust</h6>
                        <span class="gtb-ff-sub">Premium &amp; Durable Products</span>
                    </div>
                </div>

                <div class="gtb-ff-divider d-none d-lg-block"></div>

                {{-- Feature 3: Bulk & Retail Supply --}}
                <div class="gtb-ff-item">
                    <div class="gtb-ff-icon-wrap gtb-ff-icon-green">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div class="gtb-ff-content">
                        <h6 class="gtb-ff-title">Bulk &amp; Retail Supply</h6>
                        <span class="gtb-ff-sub">On-Time Delivery, Every Time</span>
                    </div>
                </div>

                <div class="gtb-ff-divider d-none d-lg-block"></div>

                {{-- Feature 4: Dedicated Support --}}
                <div class="gtb-ff-item">
                    <div class="gtb-ff-icon-wrap gtb-ff-icon-amber">
                        <i class="bi bi-headset"></i>
                    </div>
                    <div class="gtb-ff-content">
                        <h6 class="gtb-ff-title">Dedicated Support</h6>
                        <span class="gtb-ff-sub">Here to Help You Grow</span>
                    </div>
                </div>
            </div>

            {{-- Main 5 Columns Footer Grid --}}
            <div class="gtb-footer-main-grid">
                {{-- Column 1: Brand & About --}}
                <div class="gtb-footer-col gtb-footer-brand-col">
                    <a href="{{ route('home') }}" class="gtb-footer-logo-link">
                        @if (setting('site_logo'))
                            <img src="{{ asset('public/storage/' . setting('site_logo')) }}" alt="{{ config('app.name', 'Guru Teg Bahadur Disposable') }}" class="gtb-footer-logo-img">
                        @else
                            <div class="gtb-footer-logo-fallback">
                                <span class="gtb-fl-title">GURU TEG BAHADUR</span>
                                <span class="gtb-fl-sub">— DISPOSABLE —</span>
                            </div>
                        @endif
                    </a>
                    <p class="gtb-footer-about-text">
                        {{ setting('site_description', 'Guru Teg Bahadur Disposable is a trusted supplier of quality disposable tableware and catering products, offering reliable products and convenient solutions to customers across India and beyond.') }}
                    </p>
                    <a href="{{ route('about') }}" class="gtb-footer-knowmore-btn">
                        <span>Know More</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                {{-- Column 2: Quick Links --}}
                <div class="gtb-footer-col">
                    <h6 class="gtb-footer-heading">Quick Links</h6>
                    <div class="gtb-footer-heading-line"></div>
                    <ul class="gtb-footer-links-list">
                        <li><a href="{{ route('home') }}" class="gtb-footer-link"><i class="bi bi-chevron-right gtb-link-arrow"></i> Home</a></li>
                        <li><a href="{{ route('about') }}" class="gtb-footer-link"><i class="bi bi-chevron-right gtb-link-arrow"></i> About Us</a></li>
                        <li><a href="{{ route('shop') }}" class="gtb-footer-link"><i class="bi bi-chevron-right gtb-link-arrow"></i> Shop</a></li>
                        <li><a href="{{ route('blog.index') }}" class="gtb-footer-link"><i class="bi bi-chevron-right gtb-link-arrow"></i> Blogs</a></li>
                        <li><a href="{{ route('contact') }}" class="gtb-footer-link"><i class="bi bi-chevron-right gtb-link-arrow"></i> Contact</a></li>
                    </ul>
                </div>

                {{-- Column 3: Categories --}}
                <div class="gtb-footer-col">
                    <h6 class="gtb-footer-heading">Categories</h6>
                    <div class="gtb-footer-heading-line"></div>
                    <ul class="gtb-footer-links-list">
                        @php
                            $footerCategories = \App\Models\Category::orderBy('name')->take(6)->get();
                        @endphp
                        @if($footerCategories->count() >= 4)
                            @foreach($footerCategories as $category)
                                <li>
                                    <a href="{{ route('shop.category', $category->slug) }}" class="gtb-footer-link">
                                        <i class="bi bi-chevron-right gtb-link-arrow"></i> {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <li><a href="{{ route('shop', ['q' => 'Aluminium Foil']) }}" class="gtb-footer-link"><i class="bi bi-chevron-right gtb-link-arrow"></i> Aluminium Foil Rolls</a></li>
                            <li><a href="{{ route('shop', ['q' => 'Catering']) }}" class="gtb-footer-link"><i class="bi bi-chevron-right gtb-link-arrow"></i> Catering &amp; Party Supplies</a></li>
                            <li><a href="{{ route('shop', ['q' => 'Cups Bowls']) }}" class="gtb-footer-link"><i class="bi bi-chevron-right gtb-link-arrow"></i> Disposable Cups &amp; Bowls</a></li>
                            <li><a href="{{ route('shop', ['q' => 'Plates Spoons']) }}" class="gtb-footer-link"><i class="bi bi-chevron-right gtb-link-arrow"></i> Disposable Plates &amp; Spoons</a></li>
                            <li><a href="{{ route('shop', ['q' => 'Kitchen']) }}" class="gtb-footer-link"><i class="bi bi-chevron-right gtb-link-arrow"></i> Kitchen &amp; Houseware</a></li>
                            <li><a href="{{ route('shop', ['q' => 'Cleaning']) }}" class="gtb-footer-link"><i class="bi bi-chevron-right gtb-link-arrow"></i> Kitchen Cleaning Products</a></li>
                        @endif
                    </ul>
                </div>

                {{-- Column 4: Useful Links --}}
                <div class="gtb-footer-col">
                    <h6 class="gtb-footer-heading">Useful Links</h6>
                    <div class="gtb-footer-heading-line"></div>
                    <ul class="gtb-footer-links-list">
                        @if(isset($footerPages) && $footerPages && $footerPages->count())
                            @foreach($footerPages as $page)
                                <li>
                                    <a href="{{ route('page.show', $page->slug) }}" class="gtb-footer-link">
                                        <i class="bi bi-chevron-right gtb-link-arrow"></i> {{ $page->title }}
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <li><a href="{{ route('page.show', 'privacy-policy') }}" class="gtb-footer-link"><i class="bi bi-chevron-right gtb-link-arrow"></i> Privacy Policy</a></li>
                            <li><a href="{{ route('page.show', 'refund-policy') }}" class="gtb-footer-link"><i class="bi bi-chevron-right gtb-link-arrow"></i> Return &amp; Refund Policy</a></li>
                            <li><a href="{{ route('page.show', 'shipping-policy') }}" class="gtb-footer-link"><i class="bi bi-chevron-right gtb-link-arrow"></i> Shipping Policy</a></li>
                            <li><a href="{{ route('page.show', 'terms-conditions') }}" class="gtb-footer-link"><i class="bi bi-chevron-right gtb-link-arrow"></i> Terms &amp; Conditions</a></li>
                        @endif
                    </ul>
                </div>

                {{-- Column 5: Contact Us --}}
                <div class="gtb-footer-col gtb-footer-contact-col">
                    <h6 class="gtb-footer-heading">Contact Us</h6>
                    <div class="gtb-footer-heading-line"></div>
                    <div class="gtb-footer-contact-list">
                        {{-- Address --}}
                        <div class="gtb-fc-item">
                            <div class="gtb-fc-icon gtb-fc-icon-pink">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div class="gtb-fc-text">
                                {{ setting('site_address', '7/64 moti nagar near Ashoka electricals') }}
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="gtb-fc-item">
                            <div class="gtb-fc-icon gtb-fc-icon-blue">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <div class="gtb-fc-text">
                                <a href="tel:{{ setting('site_phone', '+91 9310099249') }}">
                                    {{ setting('site_phone', '+91 9310099249') }}
                                </a>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="gtb-fc-item">
                            <div class="gtb-fc-icon gtb-fc-icon-green">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div class="gtb-fc-text">
                                <a href="mailto:{{ setting('site_email', 'info@GTBdisposable.com') }}">
                                    {{ setting('site_email', 'info@GTBdisposable.com') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Decorative Wave Graphic at Bottom of Content --}}
        <div class="gtb-footer-wave-wrap">
            <svg class="gtb-footer-wave-svg" viewBox="0 0 1440 90" fill="none" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,50 C280,15 540,75 840,40 C1100,10 1300,55 1440,25 L1440,90 L0,90 Z" fill="#E8F2FA" opacity="0.6"/>
                <path d="M0,65 C320,35 660,80 980,45 C1200,20 1340,60 1440,40 L1440,90 L0,90 Z" fill="#D3E8F9" opacity="0.75"/>
                <path d="M0,80 C360,55 740,85 1100,65 C1260,52 1380,70 1440,60 L1440,90 L0,90 Z" fill="#0B3A63"/>
            </svg>
        </div>

        {{-- Bottom Copyright & Social Bar --}}
        <div class="gtb-footer-bottom-bar">
            <div class="container">
                <div class="gtb-fbb-inner d-flex align-items-center justify-content-between flex-wrap">
                    <div class="gtb-fbb-copy">
                        &copy; {{ date('Y') }} {{ config('app.name', 'Guru Teg Bahadur Disposable') }}. All Rights Reserved.
                    </div>

                    <div class="gtb-fbb-social-wrap d-flex align-items-center">
                        <span class="gtb-fbb-divider d-none d-sm-inline-block"></span>
                        <div class="gtb-fbb-social-icons d-flex align-items-center">
                            <a href="{{ setting('social_facebook', 'https://www.facebook.com/') }}" target="_blank" rel="noopener" class="gtb-bottom-social-btn" title="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="{{ setting('social_instagram', 'https://www.instagram.com/') }}" target="_blank" rel="noopener" class="gtb-bottom-social-btn" title="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="{{ setting('social_linkedin', '#') }}" target="_blank" rel="noopener" class="gtb-bottom-social-btn" title="LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="{{ setting('social_youtube', '#') }}" target="_blank" rel="noopener" class="gtb-bottom-social-btn" title="YouTube">
                                <i class="bi bi-youtube"></i>
                            </a>
                            <a href="{{ setting('social_whatsapp', 'https://wa.me/919310099249') }}" target="_blank" rel="noopener" class="gtb-bottom-social-btn" title="WhatsApp">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        // CSRF setup for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Auto-dismiss toasts
        setTimeout(() => {
            document.querySelectorAll('.toast').forEach(t => new bootstrap.Toast(t, {
                autohide: true,
                delay: 3500
            }).hide());
        }, 3500);

        // AJAX Search (Desktop + Mobile)
        let searchTimeout;
        $('#search-input, #mobile-search-input').on('input', function() {
            const inputEl = $(this);
            const q = inputEl.val().trim();
            const form = inputEl.closest('form');
            const $d = form.find('.gtb-search-dropdown, #search-results-dropdown');
            clearTimeout(searchTimeout);
            if (q.length < 2) {
                $d.addClass('d-none').empty();
                return;
            }
            searchTimeout = setTimeout(() => {
                $.get('{{ route('search.ajax') }}', {
                    q
                }, function(data) {
                    if (!data.length) {
                        $d.addClass('d-none');
                        return;
                    }
                    let html = data.map(p => `
                <a href="${p.url}" class="search-item">
                    <img src="${p.image}" alt="${p.name}">
                    <div><div style="font-size:.88rem;font-weight:600;">${p.name}</div>
                    <div style="color:var(--gtb-red, #D9232E);font-weight:700;">₹ ${Math.round(parseFloat(p.price)).toLocaleString('en-IN')}</div></div>
                </a>`).join('');
                    $d.html(html).removeClass('d-none');
                });
            }, 300);
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('form').length) {
                $('.gtb-search-dropdown, #search-results-dropdown').addClass('d-none');
            }
        });

        // Sticky Header scroll elevation class (both combo container and nav)
        const stickyCombo = document.getElementById('gtb-sticky-header-combo');
        const stickyNav = document.getElementById('gtb-sticky-nav-header');
        if (stickyCombo || stickyNav) {
            const checkSticky = () => {
                const isStuck = window.scrollY > 30;
                if (stickyCombo) stickyCombo.classList.toggle('is-stuck', isStuck);
                if (stickyNav) stickyNav.classList.toggle('is-stuck', isStuck);
            };
            window.addEventListener('scroll', checkSticky, { passive: true });
            checkSticky();
        }

        // Shared helper: keep the navbar cart badges (mobile + desktop) and total amounts in sync
        // instantly without needing a page refresh.
        window.updateCartHeader = function(count, total) {
            if (count !== undefined && count !== null) {
                $('#mobile-cart-count, #desktop-cart-count')
                    .text(count)
                    .addClass('cart-badge-updated');
                setTimeout(() => {
                    $('#mobile-cart-count, #desktop-cart-count').removeClass('cart-badge-updated');
                }, 400);
            }
            if (total !== undefined && total !== null) {
                let formatted = total;
                if (typeof total === 'number') {
                    formatted = '₹' + total.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                } else if (typeof total === 'string' && !total.includes('₹')) {
                    const num = parseFloat(total);
                    formatted = !isNaN(num)
                        ? '₹' + num.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                        : '₹' + total;
                }
                $('.gtb-cart-total')
                    .text(formatted)
                    .addClass('cart-badge-updated');
                setTimeout(() => {
                    $('.gtb-cart-total').removeClass('cart-badge-updated');
                }, 400);
            }
        };

        // Backward compatibility
        window.updateCartCount = function(count, total) {
            window.updateCartHeader(count, total);
        };

        // Add to Cart AJAX (product listing / category / wishlist cards).
        // The product detail page (products/show.blade.php) has its own handler
        // with a loading spinner on the button, so we skip delegating to this one
        // there to avoid submitting the request twice.
        $(document).on('click', '.btn-add-to-cart:not(#main-add-to-cart)', function(e) {
            e.preventDefault();
            const btn = $(this);
            const productId = btn.attr('data-product-id');
            const variantId = btn.attr('data-variant-id') || null;
            const qty = parseInt($('#qty-input').val() || 1);

            $.post('{{ route('cart.add') }}', {
                    product_id: productId,
                    product_variant_id: variantId,
                    quantity: qty
                })
                 .done(res => {
                    if (res.success) {
                        window.updateCartHeader(res.count, res.cart_total || res.subtotal_formatted || res.total_formatted);
                        showToast(res.message, 'success');
                    }
                })
                .fail(() => showToast('Failed to add product to cart', 'danger'));
        });

        // Wishlist toggle (Global for all product cards)
        $(document).on('click', '.btn-wishlist:not(.pdp-btn-wishlist)', function(e) {
            e.preventDefault();
            @guest
                showToast('Please log in to add items to your wishlist', 'info');
                setTimeout(() => {
                    window.location.href = '{{ route('login') }}';
                }, 1200);
                return;
            @endguest
            const btn = $(this);
            const productId = btn.data('product-id') || btn.attr('data-product-id');
            if (!productId) return;

            $.post('{{ route('wishlist.toggle') }}', {
                product_id: productId
            })
            .done(res => {
                if (res.success) {
                    btn.toggleClass('wishlisted', res.inWishlist);
                    const $icon = btn.find('i');
                    if (res.inWishlist) {
                        $icon.removeClass('bi-heart').addClass('bi-heart-fill text-danger');
                    } else {
                        $icon.removeClass('bi-heart-fill text-danger').addClass('bi-heart');
                    }
                    showToast(res.message, res.inWishlist ? 'success' : 'info');
                }
            })
            .fail(() => {
                showToast('Failed to update wishlist', 'danger');
            });
        });

        function showToast(msg, type = 'success') {
            const id = 'toast-' + Date.now();
            const bg = type === 'success' ? 'bg-success' : (type === 'danger' ? 'bg-danger' : 'bg-warning text-dark');
            const html =
                `<div id="${id}" class="toast show align-items-center text-white ${bg} border-0 mb-2" role="alert">
        <div class="d-flex"><div class="toast-body">${msg}</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div></div>`;
            let container = document.querySelector('.toast-container');
            if (!container) {
                container = document.createElement('div');
                container.className = 'toast-container';
                document.body.appendChild(container);
            }
            container.insertAdjacentHTML('beforeend', html);
            setTimeout(() => document.getElementById(id)?.remove(), 3500);
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"></script>
    <script>
        (function() {
            'use strict';
         const REELS = [
        {id:1, videoId:'uAmxdUDmJKw'},
        {id:2, videoId:'bIqAijsjH08'},
        {id:3, videoId:'Aw6QwM01kG8'},
        {id:4, videoId:'rIuwqzQO_xQ'},
        {id:5, videoId:'3P10tqraZsg'},
        { id: 6, videoId: 'lseFh9qG3g8'}
        ];

            /* ============================================================
               2. DOM REFS
            ============================================================ */
            const phoneScreen = document.querySelector('.rs-screen');
            const stripSlides = document.querySelectorAll('.rs-strip-slide');
            const stripCards = document.querySelectorAll('.rs-strip-card');

            /* Phone screen elements */
            const elMainVideo = document.getElementById('rsMainVideo');
            const elProdCat = document.querySelector('.rs-prod-cat');
            const elProdName = document.querySelector('.rs-prod-name');
            const elProdPrice = document.querySelector('.rs-prod-price');
            const elLikes = document.querySelectorAll('.rs-action-btn')[0]?.querySelector('p');
            const elComments = document.querySelectorAll('.rs-action-btn')[1]?.querySelector('p');

            /* ============================================================
               3. UPDATE PHONE with selected reel data
            ============================================================ */
            function updatePhone(index) {
                const reel = REELS[index];
                if (!reel) return;

                /* ---- Update placeholder / video ---- */
                if (elMainVideo) {
                    
                   const frame = document.getElementById('rsYoutubeFrame');
                        if(frame){

                           frame.src =
                            'https://www.youtube-nocookie.com/embed/' +
                            reel.videoId +
                            '?autoplay=1&mute=1&controls=0&playsinline=1';

                        }
                        
                }

                /* ---- Animate screen transition ---- */
                if (phoneScreen) {
                    phoneScreen.style.opacity = '0';
                    phoneScreen.style.transform = 'scale(0.97)';
                    setTimeout(function() {
                        phoneScreen.style.transition = 'opacity .35s ease, transform .35s ease';
                        phoneScreen.style.opacity = '1';
                        phoneScreen.style.transform = 'scale(1)';
                    }, 80);
                }
            }

            /* ============================================================
               4. SET ACTIVE CARD
            ============================================================ */
            function setActiveCard(index) {
                stripCards.forEach(function(card, i) {
                    if (i === index) {
                        card.classList.add('rs-active-card');
                    } else {
                        card.classList.remove('rs-active-card');
                    }
                });
                updatePhone(index);
            }

            /* ============================================================
               5. CLICK HANDLERS on strip cards
            ============================================================ */
            stripCards.forEach(function(card, i) {
                card.addEventListener('click', function() {
                    setActiveCard(i);
                    /* If swiper exists, slide to that index */
                    if (window._rsSwiper) {
                        window._rsSwiper.slideTo(i);
                    }
                });
            });

            /* ============================================================
               6. SWIPER — Vertical strip (auto-advances every 3s)
            ============================================================ */
            document.addEventListener('DOMContentLoaded', function() {

                /* Detect tablet/mobile for direction */
                const isMobile = window.innerWidth <= 900;

                window._rsSwiper = new Swiper('#rsStripSwiper', {
                    direction: isMobile ? 'horizontal' : 'vertical',
                    slidesPerView: isMobile ? 1.4 : 5,
                    spaceBetween: 16,
                    loop: !isMobile,
                    speed: isMobile ? 600 : 900,
                    grabCursor: true,
                    freeMode: isMobile,
                    centeredSlides: false,
                    autoplay: isMobile ? false : {
                        delay: 2000,
                        disableOnInteraction: false
                    },
                    mousewheel: false,
                    on: {
                        slideChange: function () {
                            const idx = this.realIndex % REELS.length;
                            setActiveCard(idx);
                        }
                    }

                });

                /* Initial state */
                setActiveCard(0);

                /* ---- Pause autoplay when user hovers the phone ---- */
                const phoneEl = document.getElementById('rsPhone');
                if (phoneEl && window._rsSwiper) {
                    phoneEl.addEventListener('mouseenter', function() {
                        window._rsSwiper.autoplay.stop();
                    });
                    phoneEl.addEventListener('mouseleave', function() {
                        window._rsSwiper.autoplay.start();
                    });
                }
            });

            /* ============================================================
               7. RESIZE HANDLER — re-init swiper direction on breakpoint
            ============================================================ */
            let _resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(_resizeTimer);
                _resizeTimer = setTimeout(function() {
                    if (window._rsSwiper) {
                        window._rsSwiper.destroy(true, true);
                    }
                    const isMob = window.innerWidth <= 900;
                    window._rsSwiper = new Swiper('#rsStripSwiper', {
                        direction: isMob ? 'horizontal' : 'vertical',
                      slidesPerView: isMob ? 1.4 : 5,
                       slidesPerView: isMob ? 1.4 : 5,
                            spaceBetween: 16,
                            loop: !isMob,
                            freeMode: isMob,
                            speed: isMob ? 600 : 900,
                        autoplay: {
                            delay: 8000,
                            disableOnInteraction: false,
                            pauseOnMouseEnter: true,
                        },
                        on: {
                            slideChange: function() {
                                const idx = this.realIndex % REELS.length;
                                setActiveCard(idx);
                            }
                        }
                    });
                }, 250);
            });

        })();

        /* ============================================================
           CATEGORIES DROPDOWN HANDLERS (MOBILE TOGGLE & CLICK-OUTSIDE)
        ============================================================ */
        (function() {
            // Helper to toggle mobile categories dropdown
            function toggleMobileProducts(e) {
                if (e) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                var megaItem = document.querySelector('.nav-item.dropdown-mega');
                var toggleBtn = document.getElementById('productsMenuToggle');
                var megaMenu = document.querySelector('.mega-category-dropdown');
                if (!megaItem || !megaMenu) return;

                var willOpen = !megaItem.classList.contains('open');
                megaItem.classList.toggle('open', willOpen);
                megaMenu.classList.toggle('show', willOpen);
                if (toggleBtn) {
                    toggleBtn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
                }
            }

            // Click listener
            document.addEventListener('click', function(e) {
                var isMobile = window.innerWidth < 992;

                // 1. Tapping "Categories" toggle button on mobile
                var toggle = e.target.closest('#productsMenuToggle');
                if (toggle && isMobile) {
                    toggleMobileProducts(e);
                    return;
                }

                // 2. Tapping inside the mobile mega dropdown
                var insideMega = e.target.closest('.mega-category-dropdown');
                if (insideMega && isMobile) {
                    // If tapped on an <a> link, allow natural navigation to proceed
                    if (e.target.closest('a')) {
                        return;
                    }
                    // Prevent closing dropdown when tapping inside container padding
                    e.stopPropagation();
                    return;
                }

                // 3. Tapping outside closes the mobile categories dropdown
                if (isMobile) {
                    var openMegaItem = document.querySelector('.nav-item.dropdown-mega.open');
                    if (openMegaItem) {
                        openMegaItem.classList.remove('open');
                        var openMenu = openMegaItem.querySelector('.mega-category-dropdown');
                        if (openMenu) openMenu.classList.remove('show');
                        var btn = document.getElementById('productsMenuToggle');
                        if (btn) btn.setAttribute('aria-expanded', 'false');
                    }
                }
            });
        })();
    </script>

    @stack('scripts')
</body>

</html>

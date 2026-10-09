@php
$refSrc = 'C:/Users/USWT/.gemini/antigravity/brain/1ad19c4d-288a-4184-8bac-fe830844fd22/.user_uploaded/media_1791451785224_80db1502.png';
if (file_exists($refSrc)) {
$destImg = public_path('assets/img/about-reference.png');
if (!file_exists($destImg) || @filesize($destImg) !== @filesize($refSrc)) {
@copy($refSrc, $destImg);
}
$destImages = public_path('images/about-reference.png');
if (!is_dir(public_path('images'))) {
@mkdir(public_path('images'), 0777, true);
}
if (!file_exists($destImages) || @filesize($destImages) !== @filesize($refSrc)) {
@copy($refSrc, $destImages);
}
}
@endphp
@extends('layouts.app')
@section('title', 'About Us - Guru Teg Bahadur Disposable')
@section('meta_description', 'Guru Teg Bahadur Disposable is a trusted supplier of quality disposable tableware, cutlery, and catering essentials.')

@push('styles')
<style>
    /* ============================================================
       ABOUT US — EXACT MATCH TO SHARED DESIGN
    ============================================================ */
    .gtb-about-page-section {
        background: #F8FAFC;
        padding: 35px 0 65px;
    }

    /* Common Card Panels */
    .about-hero-block,
    .about-custom-block {
        background: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 22px;
        padding: 36px 40px;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.03);
    }

    /* Eyebrow Overline */
    .about-eyebrow {
        font-family: 'Poppins', sans-serif;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #8A99A8;
        margin-bottom: 8px;
    }

    /* Main Headings */
    .about-main-title span,
    .about-custom-title span {
        font-family: 'Poppins', sans-serif;
        font-size: 40px;
        font-weight: 700;
        line-height: 1.25;
        margin-bottom: 16px;
    }

    .about-main-title .title-main-word {
        color: #0F172A;
        position: relative;
        display: inline-block;
        /* padding-bottom: 4px; */
    }

    /* Dark navy underline accent under "About" matching image */
    .about-main-title .title-main-word::after {
        display: none;
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3.5px;
        background: #0B3A63;
        border-radius: 2px;
    }

    .about-custom-title .title-main-word {
        color: #0F172A;
    }

    .title-accent-word {
        color: #E11D48;
    }

    /* Body Paragraphs */
    .about-body-p {
        font-family: 'Poppins', sans-serif;
        font-size: 14.5px;
        font-weight: 400;
        color: #556473;
        line-height: 1.68;
        margin-bottom: 14px;
    }

    .about-body-desc {
        font-family: 'Poppins', sans-serif;
        font-size: 13.5px;
        font-weight: 400;
        color: #64748B;
        line-height: 1.65;
    }

    /* Top Hero Right Photo Frame */
    .about-hero-img-frame {
        width: 100%;
    height: 365px;
        border-radius: 18px;
        overflow: hidden;
        background-color: #F1F5F9;
        border: 1px solid #ECEFF2;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
        position: relative;
    }

    .about-hero-img-crop {
        position: relative;
        width: 100%;
        height: 100%;
        overflow: hidden;
        border-radius: 18px;
    }

    .about-crop-img-hero {
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: auto;
        max-width: none;
        display: block;
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .about-hero-img-frame:hover .about-crop-img-hero {
        transform: scale(1.025);
    }

    /* 2 Feature Highlight Cards */
    .about-feature-box {
        background: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 16px;
        padding: 22px 24px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.02);
        height: 100%;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }

    .about-feature-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
        border-color: #D1D5DB;
    }

 .feature-box-icon {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 22px;
}

    .feature-box-icon.icon-blue {
        background: #E0F2FE;
        color: #0284C7;
    }

    .feature-box-icon.icon-rose {
        background: #FFE4E6;
        color: #E11D48;
    }

    .feature-box-title {
        font-family: 'Poppins', sans-serif;
        font-size: 18px;
        font-weight: 700;
        color: #0F172A;
        margin-bottom: 5px;
    }

    .feature-box-desc {
        font-family: 'Poppins', sans-serif;
        font-size: 13.8px;
    color: #556473;
        line-height: 1.6;
        margin: 0;
    }

    /* 6 Customization Feature Pills */
    .about-pills-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 22px;
    }

    .about-pill-item {
        background: #FFFFFF;
        border: 1px solid #ECEFF2;
        border-radius: 14px;
        padding: 10px 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.02);
        transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .about-pill-item:hover {
        transform: translateY(-2px);
        border-color: #CBD5E1;
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.05);
    }

    .pill-circle-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 15px;
    }

    .pill-circle-icon.pill-icon-pink {
        background: #FFE4E6;
        color: #E11D48;
    }

    .pill-circle-icon.pill-icon-blue {
        background: #E0F2FE;
        color: #0284C7;
    }

    .pill-circle-icon.pill-icon-green {
        background: #DCFCE7;
        color: #16A34A;
    }

    .pill-circle-icon.pill-icon-amber {
        background: #FEF3C7;
        color: #D97706;
    }

    .pill-circle-icon.pill-icon-purple {
        background: #F3E8FF;
        color: #9333EA;
    }

    .pill-circle-icon.pill-icon-coral {
        background: #FFE4E6;
        color: #EF4444;
    }

    .pill-text-icon {
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        font-size: 14px;
        line-height: 1;
    }

    .pill-label {
        font-family: 'Poppins', sans-serif;
        font-size: 13px;
    font-weight: 600;
        color: #0F172A;
        line-height: 1.3;
        margin: 0;
    }

    /* Custom Products Image Frame */
    .about-custom-img-frame {
        width: 100%;
        height: 100%;
        min-height: 385px;
        border-radius: 18px;
        overflow: hidden;
        background-color: #F1F5F9;
        border: 1px solid #ECEFF2;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
        position: relative;
    }

    .about-custom-img-crop {
        position: relative;
        width: 100%;
        height: 100%;
        min-height: 385px;
        overflow: hidden;
        border-radius: 18px;
    }

    .about-crop-img-custom {
        position: absolute;
        bottom: 0%;
        right: 0%;
        width: 100%;
        height: auto;
        max-width: none;
        display: block;
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .about-custom-img-frame:hover .about-crop-img-custom {
        transform: scale(1.025);
    }

    /* Responsive Adjustments */
    @media (max-width: 991px) {

        .about-hero-block,
        .about-custom-block {
            padding: 26px 22px;
            border-radius: 18px;
        }

        .about-main-title,
        .about-custom-title {
            font-size: 1.9rem;
        }

        .about-hero-img-frame {
            height: 260px;
        }

        .about-custom-img-frame,
        .about-custom-img-crop {
            min-height: 300px;
        }

        .about-pills-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .gtb-about-page-section {
            padding: 20px 0 45px;
        }

        .about-hero-block,
        .about-custom-block {
            padding: 20px 16px;
            border-radius: 14px;
        }

        .about-main-title,
        .about-custom-title {
            font-size: 1.6rem;
        }

        .about-pills-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .about-feature-box {
            padding: 16px 14px;
            gap: 12px;
        }

        .feature-box-icon {
            width: 42px;
            height: 42px;
            font-size: 18px;
        }
    }
</style>
@endpush

@section('content')
<div class="breadcrumb-kkt">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size: 0.84rem;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">About Us</li>
            </ol>
        </nav>
    </div>
</div>

<section class="gtb-about-page-section">
    <div class="container">

        {{-- SECTION 1: TOP PANEL / HERO & HIGHLIGHTS --}}
        <div class="about-hero-block">
            <div class="row g-4 align-items-center">
                {{-- Left Column: About Us Text --}}
                <div class="col-lg-6">
                    <div class="about-hero-content">
                        <div class="about-eyebrow">ABOUT OUR COMPANY</div>
                        <h1 class="about-main-title">
                            <span class="title-main-word">About</span> <span class="title-accent-word">Us</span>
                        </h1>
                        <p class="about-body-p">
                            Guru Teg Bahadur Disposable is a trusted name in the supply of quality disposable tableware and catering products, offering reliable and practical solutions for businesses, events, and everyday needs. We are committed to providing a wide range of disposable products that combine convenience, durability, and excellent value.
                        </p>
                        <p class="about-body-p mb-0">
                            Our extensive product range includes disposable plates, spoons, bowls, glasses, cups, wooden cutlery, serving items, and other catering essentials. With a strong focus on product quality and customer satisfaction, we carefully source and supply products that meet diverse requirements. Whether for parties, catering services, restaurants, events, or large gatherings, Guru Teg Bahadur Disposable offers dependable products at competitive prices, making disposable serving solutions simple and convenient for every customer.
                        </p>
                    </div>
                </div>

                {{-- Right Column: Tableware Photo --}}
                <div class="col-lg-6">
                    <div class="about-hero-img-frame">
                        <div class="about-hero-img-crop">
                            <img src="{{ base_public_url('assets/img/about-one.jpg') }}"
                                alt="Guru Teg Bahadur Disposable Crockery &amp; Tableware"
                                class="about-crop-img-hero"
                                onerror="this.onerror=null; this.src='{{ asset('images/about-one.jpg') }}';">
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2 Highlight Cards (Below Hero Row) --}}
            <div class="row g-3 g-md-4 mt-2 mt-md-3">
                {{-- Card 1: Trusted by Leading Businesses --}}
                <div class="col-md-6">
                    <div class="about-feature-box">
                        <div class="feature-box-icon icon-blue">
                            <i class="bi bi-building"></i>
                        </div>
                        <div class="feature-box-text">
                            <h3 class="feature-box-title">Trusted by Leading Businesses</h3>
                            <p class="feature-box-desc">
                                We proudly serve both retail and bulk orders with flexible MOQs, catering to hospitality, corporate, gifting, and luxury lifestyle segments. Our commitment to quality has made us a regular supplier to prestigious hospitality groups, including ITC Hotels and Taj Hotels.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Global Presence --}}
                <div class="col-md-6">
                    <div class="about-feature-box">
                        <div class="feature-box-icon icon-rose">
                            <i class="bi bi-globe2"></i>
                        </div>
                        <div class="feature-box-text">
                            <h3 class="feature-box-title">Global Presence</h3>
                            <p class="feature-box-desc">
                                With a strong global presence, we export our handcrafted creations to countries such as the United Kingdom, Germany, France, Spain, Italy, New Zealand, and South Africa, while continuing to deliver excellence across the domestic market.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 2: BOTTOM PANEL / CUSTOMISABLE EXCELLENCE --}}
        <div class="about-custom-block mt-4 mt-lg-5">
            <div class="row g-4 align-items-center">
                {{-- Left Column: Customization Services --}}
                <div class="col-lg-7">
                    <div class="about-custom-content">
                        <div class="about-eyebrow">TAILORED TO YOUR BRAND</div>
                        <h2 class="about-custom-title">
                            <span class="title-main-word">Customisable</span> <span class="title-accent-word">Excellence</span>
                        </h2>
                        <p class="about-body-p mb-4">
                            At Finesse By Design, customization is at the heart of what we do. We offer a wide range of personalization options to help businesses, hotels, brands, and individuals create truly distinctive products.
                        </p>

                        {{-- 6 Customization Pills (3 cols x 2 rows) --}}
                        <div class="about-pills-grid">
                            {{-- Pill 1: Custom Logo Branding --}}
                            <div class="about-pill-item">
                                <div class="pill-circle-icon pill-icon-pink">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                    </svg>
                                </div>
                                <span class="pill-label">Custom Logo<br class="d-none d-sm-block"> Branding</span>
                            </div>

                            {{-- Pill 2: Name Engraving --}}
                            <div class="about-pill-item">
                                <div class="pill-circle-icon pill-icon-blue">
                                    <span class="pill-text-icon">Aa</span>
                                </div>
                                <span class="pill-label">Name Engraving</span>
                            </div>

                            {{-- Pill 3: Precision Etching --}}
                            <div class="about-pill-item">
                                <div class="pill-circle-icon pill-icon-green">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                        <polyline points="2 17 12 22 22 17"></polyline>
                                        <polyline points="2 12 12 17 22 12"></polyline>
                                    </svg>
                                </div>
                                <span class="pill-label">Precision Etching</span>
                            </div>

                            {{-- Pill 4: Monogram & Personalized Designs --}}
                            <div class="about-pill-item">
                                <div class="pill-circle-icon pill-icon-amber">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                </div>
                                <span class="pill-label">Monogram &amp;<br class="d-none d-sm-block"> Personalized Designs</span>
                            </div>

                            {{-- Pill 5: Corporate Branding Solutions --}}
                            <div class="about-pill-item">
                                <div class="pill-circle-icon pill-icon-purple">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                    </svg>
                                </div>
                                <span class="pill-label">Corporate Branding<br class="d-none d-sm-block"> Solutions</span>
                            </div>

                            {{-- Pill 6: Product Customization Available --}}
                            <div class="about-pill-item">
                                <div class="pill-circle-icon pill-icon-coral">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="4" y1="21" x2="4" y2="14"></line>
                                        <line x1="4" y1="10" x2="4" y2="3"></line>
                                        <line x1="12" y1="21" x2="12" y2="12"></line>
                                        <line x1="12" y1="8" x2="12" y2="3"></line>
                                        <line x1="20" y1="21" x2="20" y2="16"></line>
                                        <line x1="20" y1="12" x2="20" y2="3"></line>
                                        <line x1="1" y1="14" x2="7" y2="14"></line>
                                        <line x1="9" y1="8" x2="15" y2="8"></line>
                                        <line x1="17" y1="16" x2="23" y2="16"></line>
                                    </svg>
                                </div>
                                <span class="pill-label">Product Customization<br class="d-none d-sm-block"> Available</span>
                            </div>
                        </div>

                        {{-- Closing Paragraph --}}
                        <p class="about-body-desc mb-0">
                            From design modifications and size adjustments to exclusive finishes and bespoke creations, we tailor each product to match your specific requirements and brand identity. Whether you need luxury hospitality ware, corporate gifting solutions, or signature branded collections, our team transforms your vision into beautifully crafted, handcrafted pieces that leave a lasting impression.
                        </p>
                    </div>
                </div>

                {{-- Right Column: Custom Printed Logo Products Photo --}}
                <div class="col-lg-5">
                    <div class="about-custom-img-frame">
                        <div class="about-custom-img-crop">
                            <img src="{{ base_public_url('assets/img/about-two.jpg') }}"
                                alt="Customizable Excellence Branded Disposable Ware"
                                class="about-crop-img-custom"
                                onerror="this.onerror=null; this.src='{{ asset('images/about-two.jpg') }}';">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
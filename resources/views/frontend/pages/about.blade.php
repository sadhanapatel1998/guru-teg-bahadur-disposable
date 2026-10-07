@extends('layouts.app')
@section('title', 'About us - Finesse By Design')

@push('styles')
<style>
    /* ============================================================
       ABOUT US — CLEAN & SHARP BORDERLESS DESIGN
    ============================================================ */
    .about-clean-section {
        background: #F8FAFC;
        padding: 30px 0 55px;
    }

    /* Natural Text Flow (Clean, Sharp, Unbolded) */
    .about-flow-text {
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 400;
        color: #475569;
        line-height: 1.85;
        text-align: justify;
        text-justify: inter-word;
        margin-bottom: 0;
    }

    /* Clean & Sharp Surface Card - ZERO BORDERS */
    .about-sharp-card {
        background: #FFFFFF;
        border: none !important;
        border-radius: 12px;
        padding: 28px 32px;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
        margin-bottom: 20px;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .about-sharp-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.07);
    }

    /* Split Cards for Hospitality & Global Presence - ZERO BORDERS */
    .about-split-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 20px;
    }

    .about-sharp-split-card {
        background: #FFFFFF;
        border: none !important;
        border-radius: 12px;
        padding: 24px 26px;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
        display: flex;
        gap: 16px;
        align-items: flex-start;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .about-sharp-split-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.07);
    }

    .about-sharp-icon {
        width: 44px;
        height: 44px;
        border: none !important;
        border-radius: 10px;
        background: #EDF6FB;
        color: var(--kkt-primary, #0B6FAE);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
        transition: all 0.25s ease;
    }

    .about-sharp-split-card:hover .about-sharp-icon {
        background: var(--kkt-gradient);
        color: #FFFFFF;
    }

    /* Subheading - ZERO BORDERS */
    .about-sharp-subheading {
        font-family: 'Poppins', sans-serif;
        font-size: 14.5px;
        font-weight: 600;
        color: #0F172A;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 16px;
        border: none !important;
    }

    /* 7 Customization Services Grid - ZERO BORDERS */
    .about-services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 14px;
        margin-bottom: 24px;
    }

    .about-sharp-tile {
        background: #F8FAFC;
        border: none !important;
        border-radius: 10px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: all 0.25s ease;
    }

    .about-sharp-tile:hover {
        background: #FFFFFF;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.06);
    }

    .about-sharp-tile-icon {
        width: 36px;
        height: 36px;
        border: none !important;
        border-radius: 8px;
        background: #EDF6FB;
        color: var(--kkt-primary, #0B6FAE);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        flex-shrink: 0;
        transition: all 0.25s ease;
    }

    .about-sharp-tile:hover .about-sharp-tile-icon {
        background: var(--kkt-gradient);
        color: #FFFFFF;
    }

    .about-sharp-tile-title {
        font-family: 'Poppins', sans-serif;
        font-size: 13.5px;
        font-weight: 500;
        color: #1E293B;
        margin: 0;
        line-height: 1.35;
        transition: color 0.2s ease;
    }

    .about-sharp-tile:hover .about-sharp-tile-title {
        color: var(--kkt-primary, #0B6FAE);
    }

    /* Responsive */
    @media (max-width: 991px) {
        .about-sharp-card {
            padding: 22px 22px;
        }
        .about-split-row {
            grid-template-columns: 1fr;
            gap: 16px;
        }
    }

    @media (max-width: 768px) {
        .about-clean-section {
            padding: 20px 0 35px;
        }
        .about-sharp-card {
            padding: 18px 16px;
            border-radius: 10px;
        }
        .about-sharp-split-card {
            padding: 18px 16px;
            border-radius: 10px;
            gap: 12px;
        }
        .about-flow-text {
            font-size: 14px;
            line-height: 1.7;
        }
        .about-services-grid {
            grid-template-columns: 1fr;
            gap: 10px;
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

<section class="about-clean-section">
    <div class="container">
        {{-- Hero Header (Matched to Home Page sec-main-heading & sec-heading-accent) --}}
        <div class="text-center mb-4">
            <h1 class="sec-main-heading mb-0">
                About <span class="sec-heading-accent">us</span>
            </h1>
        </div>

        {{-- Section 1: Main Story Card (Clean, Sharp, Borderless) --}}
        <div class="about-sharp-card">
            <p class="about-flow-text">
                Finesse By Design is a trusted name in the manufacturing of premium brass and silver-plated articles, bringing exceptional craftsmanship and quality to clients across India and the world. With over 43 years of manufacturing excellence, we are a renowned export house committed to creating timeless products that blend elegance, durability, and superior workmanship. As a direct manufacturer, we eliminate middlemen, offering export-quality products at competitive factory prices. Every article is meticulously handcrafted by skilled artisans and undergoes a stringent 7-step quality assurance process, ensuring perfection in every piece. Our product range is available in Premium Brass, Silver-Plated, Nickel-Plated, Matte, and Shine Finishes, with complete customization options including tailor-made designs and personalized logos to meet the unique requirements of our clients.
            </p>
        </div>

        {{-- Section 2: Split Cards for Hospitality & Global Presence (Clean, Sharp, Borderless) --}}
        <div class="about-split-row">
            {{-- Hospitality & Bulk Orders --}}
            <div class="about-sharp-split-card">
                <div class="about-sharp-icon">
                    <i class="bi bi-building"></i>
                </div>
                <p class="about-flow-text">
                    We proudly serve both retail and bulk orders with flexible MOQs, catering to hospitality, corporate, gifting, and luxury lifestyle segments. Our commitment to quality has made us a regular supplier of premium tableware to prestigious hospitality groups, including ITC Hotels and Taj Hotels.
                </p>
            </div>

            {{-- Global Presence --}}
            <div class="about-sharp-split-card">
                <div class="about-sharp-icon">
                    <i class="bi bi-globe2"></i>
                </div>
                <p class="about-flow-text">
                    With a strong global presence, we export our handcrafted creations to countries such as the United Kingdom, Germany, France, Spain, Italy, New Zealand, and South Africa, while continuing to deliver excellence across the domestic market.
                </p>
            </div>
        </div>

        {{-- Section 3: Customisable Excellence (Clean, Sharp, Borderless) --}}
        <div class="about-sharp-card mb-0">
            <div class="text-center mb-3">
                <h2 class="sec-main-heading mb-0">
                    Customisable <span class="sec-heading-accent">Excellence</span>
                </h2>
            </div>

            <p class="about-flow-text mb-4">
                At Finesse By Design, customization is at the heart of what we do. We offer a wide range of personalization options to help businesses, hotels, brands, and individuals create truly distinctive products.
            </p>

            <h3 class="about-sharp-subheading">Our Customization Services Include:</h3>

            {{-- 7 Services Grid (Clean, Sharp, Borderless) --}}
            <div class="about-services-grid">
                <div class="about-sharp-tile">
                    <div class="about-sharp-tile-icon"><i class="bi bi-award"></i></div>
                    <h4 class="about-sharp-tile-title">Custom Logo Branding</h4>
                </div>

                <div class="about-sharp-tile">
                    <div class="about-sharp-tile-icon"><i class="bi bi-pen"></i></div>
                    <h4 class="about-sharp-tile-title">Name Engraving</h4>
                </div>

                <div class="about-sharp-tile">
                    <div class="about-sharp-tile-icon"><i class="bi bi-lightning-charge"></i></div>
                    <h4 class="about-sharp-tile-title">Precision Etching</h4>
                </div>

                <div class="about-sharp-tile">
                    <div class="about-sharp-tile-icon"><i class="bi bi-layers"></i></div>
                    <h4 class="about-sharp-tile-title">Elegant Embossing</h4>
                </div>

                <div class="about-sharp-tile">
                    <div class="about-sharp-tile-icon"><i class="bi bi-type"></i></div>
                    <h4 class="about-sharp-tile-title">Monogram &amp; Personalized Designs</h4>
                </div>

                <div class="about-sharp-tile">
                    <div class="about-sharp-tile-icon"><i class="bi bi-briefcase"></i></div>
                    <h4 class="about-sharp-tile-title">Corporate Branding Solutions</h4>
                </div>

                <div class="about-sharp-tile">
                    <div class="about-sharp-tile-icon"><i class="bi bi-sliders"></i></div>
                    <h4 class="about-sharp-tile-title">Product Customization Available</h4>
                </div>
            </div>

            {{-- Closing Vision Paragraph --}}
            <div class="pt-3">
                <p class="about-flow-text">
                    From design modifications and size adjustments to exclusive finishes and bespoke creations, we tailor each product to match your specific requirements and brand identity. Whether you need luxury hospitality ware, corporate gifting solutions, or signature branded collections, our team transforms your vision into beautifully crafted, handcrafted pieces that leave a lasting impression.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection

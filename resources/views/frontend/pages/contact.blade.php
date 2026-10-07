@extends('layouts.app')
@section('title', 'Contact Us')

@section('content')
    {{-- Breadcrumb --}}
    <div class="breadcrumb-kkt">
        <div class="container">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">
                            <i class="bi bi-house-door-fill me-1"></i>
                            Home
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Contact
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- Contact Section --}}
    <section class="contact-section">
        <div class="container">
            <div class="row align-items-center g-5">
                {{-- Left Info --}}
                <div class="col-lg-5">
                    <span class="contact-badge">
                        Get In Touch
                    </span>
                    <h2 class="contact-title">
                        Get In
                     <span>Touch With Us</span>
                    </h2>
                    <p class="contact-desc">
                        Have questions or need assistance? Our team is here to help.
                    </p>
                    {{-- Contact Info --}}
                    <div class="contact-info-wrapper">
                        {{-- Phone --}}
                        <div class="contact-info-box">
                            <div class="contact-icon">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <div>
                                <h6>Phone Number</h6>
                                <p>{{ setting('site_phone') }}</p>
                            </div>
                        </div>
                        {{-- Email --}}
                        <div class="contact-info-box">
                            <div class="contact-icon">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div>
                                <h6>Email Address</h6>
                                <p>{{ setting('site_email') }}</p>
                            </div>
                        </div>
                        {{-- Address --}}
                        <div class="contact-info-box">
                            <div class="contact-icon">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div>
                                <h6>Office Address</h6>
                                <p>{{ setting('site_address') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Contact Form --}}
                <div class="col-lg-7">
                    <div class="contact-card">
                        <div class="contact-card-header">
                            <h3>
                                Send Us a Message
                            </h3>
                            <p>
                                Fill out the form and we’ll contact you shortly.
                            </p>
                        </div>
                        {{-- Success --}}
                        @if (session('success'))
                            <div class="alert alert-success border-0 rounded-4 py-3">
                                {{ session('success') }}
                            </div>
                        @endif
                        {{-- Form --}}
                        <form method="POST" action="{{ route('contact.submit') }}">
                            @csrf
                            <div class="row g-4">
                                {{-- Name --}}
                                <div class="col-md-6">
                                    <label class="contact-label">
                                        Full Name
                                    </label>
                                    <input type="text" name="name" class="form-control contact-input"
                                        placeholder="Enter your name" required>
                                </div>
                                {{-- Email --}}
                                <div class="col-md-6">
                                    <label class="contact-label">
                                        Email Address
                                    </label>
                                    <input type="email" name="email" class="form-control contact-input"
                                        placeholder="Enter your email" required>
                                </div>
                                {{-- Phone --}}
                                <div class="col-md-6">
                                    <label class="contact-label">
                                        Phone Number
                                    </label>
                                    <input type="tel" name="phone" class="form-control contact-input"
                                        placeholder="+91 XXXXX XXXXX">
                                </div>
                                {{-- Subject --}}
                                <div class="col-md-6">
                                    <label class="contact-label">
                                        Subject
                                    </label>
                                    <input type="text" name="subject" class="form-control contact-input"
                                        placeholder="Enter subject">
                                </div>
                                {{-- Message --}}
                                <div class="col-12">
                                    <label class="contact-label">
                                        Your Message
                                    </label>
                                    <textarea name="message" rows="5" class="form-control contact-textarea" placeholder="Write your message..."
                                        required></textarea>
                                </div>
                            </div>
                            {{-- Button --}}
                            <button type="submit" class="contact-btn">
                                Send Message
                                <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>  




    {{-- Google Map --}}
{{-- <section class="contact-map-section">
    <div class="map-card">
       <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6996.250880244178!2d77.1368778!3d28.7456715!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d0132cd377003%3A0xf91f52fafdf12841!2sSANNI%20CAD%20CAM%20PVT%20LTD!5e0!3m2!1sen!2sin!4v1780737977712!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</section>
 --}}

@endsection
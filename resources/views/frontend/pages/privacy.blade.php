@extends('layouts.app')
@section('content')
    <div class="breadcrumb-kkt">
        <div class="container">
            <nav>
                <ol class="breadcrumb mb-0" style="font-size:.84rem;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ ucfirst(request()->route()->getName()) }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h3>Privacy Policy</h3>

                    <p>
                        At Sanni Cad Cam Private Limited, we are committed to protecting the privacy and security of our
                        customers, visitors, and business partners. This Privacy Policy explains how we collect, use, and
                        safeguard the information you provide while using our website.
                    </p>

                    <h5>Information We Collect</h5>

                    <p>
                        We may collect personal information such as your name, phone number, email address, company details,
                        and any information submitted through enquiry or contact forms.
                    </p>

                    <h5>How We Use Your Information</h5>

                    <p>
                        The information collected is used to respond to enquiries, provide product information, improve our
                        services, process requests, and communicate important updates related to our business.
                    </p>

                    <h5>Data Protection</h5>

                    <p>
                        We implement appropriate security measures to protect your personal information from unauthorized
                        access, disclosure, alteration, or misuse.
                    </p>

                    <h5>Third-Party Sharing</h5>

                    <p>
                        We do not sell, rent, or trade your personal information to third parties. Information may only be
                        shared when required by law or for legitimate business operations.
                    </p>

                    <h5>Cookies</h5>

                    <p>
                        Our website may use cookies to enhance user experience, analyze website traffic, and improve website
                        functionality.
                    </p>

                    <h5>Your Consent</h5>

                    <p>
                        By using our website, you consent to the collection and use of information in accordance with this
                        Privacy Policy.
                    </p>

                    <h5>Contact Us</h5>

                    <p>
                        If you have any questions regarding this Privacy Policy or the handling of your personal
                        information, please contact us through the details provided on our website.
                    </p>

                </div>
            </div>
        </div>
    </section>
@endsection

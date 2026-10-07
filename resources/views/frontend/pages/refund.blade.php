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
                    <div class="bg-white rounded-4 border p-5" style="font-size:.97rem;line-height:1.9;color:#444;">
                        <h3 class="mb-4">Disclaimer</h3>

                        <p>
                            The information provided on this website is for general informational purposes only.
                            While Sanni Cad Cam Private Limited makes every effort to ensure the accuracy and
                            reliability of the information presented, we make no guarantees regarding its
                            completeness, accuracy, or suitability for any specific purpose.
                        </p>

                        <p>
                            Product specifications, images, pricing, and availability are subject to change
                            without prior notice. Actual products may vary from the images displayed on the website.
                        </p>

                        <p>
                            We shall not be liable for any loss or damage arising from the use of this website
                            or reliance on any information provided herein. Visitors are advised to verify all
                            product details before making any purchasing decisions.
                        </p>

                        <p>
                            By using this website, you acknowledge and agree to this disclaimer and its terms.
                        </p>
                    </div>

                </div>
            </div>
        </div>
        </div>
    </section>
@endsection

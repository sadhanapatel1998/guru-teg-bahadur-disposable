@extends('layouts.app')
@section('content')
<div class="breadcrumb-kkt"><div class="container"><nav><ol class="breadcrumb mb-0" style="font-size:.84rem;"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">{{ ucfirst(request()->route()->getName()) }}</li></ol></nav></div></div>
<section class="py-5"><div class="container"><div class="row justify-content-center"><div class="col-lg-8">
<div class="bg-white rounded-4 border p-5" style="font-size:.97rem;line-height:1.9;color:#444;">
<h3 class="mb-4">Terms & Conditions</h3>

<p>
    Welcome to Sanni Cad Cam Private Limited. By accessing and using this website,
    you agree to comply with and be bound by the following Terms & Conditions.
</p>

<p>
    The information provided on this website is for general informational purposes only.
    While we strive to keep all information accurate and up to date, we make no warranties
    regarding the completeness, reliability, or accuracy of the content.
</p>

<p>
    All products, specifications, pricing, and availability are subject to change without
    prior notice. Images displayed on the website are for reference purposes and may vary
    from the actual product.
</p>

<p>
    Unauthorized use, reproduction, or distribution of any content, images, logos, or
    materials from this website is strictly prohibited without prior written permission.
</p>

<p>
    We shall not be held liable for any direct, indirect, incidental, or consequential
    damages arising from the use of this website or reliance on any information provided herein.
</p>

<p>
    By continuing to use this website, you acknowledge and agree to these Terms & Conditions.
    We reserve the right to modify these terms at any time without prior notice.
</p>

</div>
</div></div></div></section>
@endsection

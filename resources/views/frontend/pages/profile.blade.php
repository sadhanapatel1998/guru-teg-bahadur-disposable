@extends('layouts.app')

@push('styles')

<style>
:root{
    --primary:#f97316;
    --dark:#0f172a;
    --light:#f8fafc;
}

/* =========================
   HERO SECTION
========================= */
.profile-hero{
    background:linear-gradient(135deg,#0f172a,#1e293b);
    padding:35px 0;
    position:relative;
    overflow:hidden;
    color:#fff;
}

.profile-hero::before{
    content:'';
    position:absolute;
    width:450px;
    height:450px;
    background:rgba(249,115,22,.12);
    border-radius:50%;
    top:-180px;
    right:-120px;
}

.profile-hero::after{
    content:'';
    position:absolute;
    width:350px;
    height:350px;
    background:rgba(255,255,255,.05);
    border-radius:50%;
    bottom:-150px;
    left:-120px;
}

.about-badge{
    display:inline-block;
    background:var(--primary);
    color:#fff;
    padding:10px 25px;
    border-radius:50px;
    font-weight:600;
    font-size:14px;
    letter-spacing:1px;
}

.profile-title{
    font-size:55px;
    font-weight:800;
    margin-top:20px;
    margin-bottom:15px;
}

.profile-subtitle{
    font-size:18px;
    color:#d1d5db;
    max-width:750px;
    margin:auto;
}

/* =========================
   COMMON
========================= */
.section-title{
    font-size:40px;
    font-weight:800;
    color:var(--dark);
}

.section-desc{
    color:#64748b;
    max-width:700px;
    margin:auto;
}

.bg-light-custom{
    background:var(--light);
}

/* =========================
   COMPANY CARD
========================= */
.company-card{
    background:#fff;
    border-radius:25px;
    padding:45px;
    box-shadow:0 15px 40px rgba(0,0,0,.08);
}

.profile-content{
    font-size:17px;
    line-height:2;
    color:#555;
}

/* =========================
   INFO TABLE
========================= */
.info-card{
    background:#fff;
    border-radius:25px;
    overflow:hidden;
    box-shadow:0 15px 40px rgba(0,0,0,.08);
}

.info-table{
    margin-bottom:0;
}

.info-table th{
    width:35%;
    background:#f8fafc;
    color:#0f172a;
    font-weight:700;
}

.info-table th,
.info-table td{
    padding:18px;
    vertical-align:middle;
}

/* =========================
   STAT BOX
========================= */
.stat-box{
    background:#fff;
    border-radius:20px;
    padding:35px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
    transition:.4s;
    height:100%;
    border-top:4px solid var(--primary);
}

.stat-box:hover{
    transform:translateY(-8px);
}

.stat-box i{
    font-size:42px;
    color:var(--primary);
    margin-bottom:15px;
    display:block;
}

.stat-box h6{
    font-weight:700;
    color:#64748b;
}

.stat-box p{
    margin:0;
    font-weight:600;
}

/* =========================
   WHY US
========================= */
.why-card{
    background:#fff;
    border-radius:20px;
    padding:30px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
    transition:.4s;
    height:100%;
}

.why-card:hover{
    background:var(--primary);
    color:#fff;
    transform:translateY(-8px);
}

.why-card:hover i{
    color:#fff;
}

.why-card i{
    font-size:40px;
    color:var(--primary);
    margin-bottom:20px;
    display:block;
}

.why-card span{
    font-weight:600;
}

/* =========================
   RESPONSIVE
========================= */
@media(max-width:991px){

    .profile-title{
        font-size:40px;
    }

    .section-title{
        font-size:30px;
    }

    .company-card{
        padding:25px;
    }
}
</style>

@endpush

@section('content')

<!-- =========================
     BREADCRUMB
========================= -->

<div class="breadcrumb-kkt">
    <div class="container">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
            <li class="breadcrumb-item active">
                Company Profile
            </li>
        </ol>
    </nav>
</div>

</div>

<!-- =========================
     HERO
========================= -->

<section class="profile-hero">
    <div class="container text-center">
    <span class="about-badge">
        COMPANY PROFILE
    </span>

    <h1 class="profile-title">
        Sanni Cad Cam Private Limited
    </h1>

    <p class="profile-subtitle">
        Trusted Manufacturer & Supplier of CNC Routers, Laser Machines,
        CNC Spare Parts and Industrial Automation Solutions.
    </p>

</div>

</section>

<!-- =========================
     ABOUT COMPANY
========================= -->

<section class="py-5">
    <div class="container">
    <div class="company-card">

        <h2 class="section-title mb-4">
            About Our Company
        </h2>

        <p class="profile-content">
            <strong>Sanni Cad Cam Private Limited</strong> is a leading
            manufacturer and supplier of CNC Router Spare Parts, CNC Routers,
            Laser Cutting Machines, Laser Marking Machines, CNC Engraving Machines,
            and Industrial Automation Solutions.
        </p>

        <p class="profile-content">
            Backed by extensive industry experience and a highly skilled team,
            we provide innovative, reliable, and cost-effective solutions that
            meet the growing demands of modern industries.
        </p>

        <p class="profile-content">
            Our commitment to quality, technological excellence, customer
            satisfaction, and continuous innovation has helped us build a
            strong reputation across India.
        </p>

    </div>

</div>


</section>

<!-- =========================
     BASIC INFORMATION
========================= -->

<section class="py-5 bg-light-custom">
    <div class="container">
    <div class="text-center mb-5">
        <h2 class="section-title">
            Basic Information
        </h2>
    </div>

    <div class="info-card">

        <div class="table-responsive">

            <table class="table info-table">

                <tbody>

                    <tr>
                        <th>Nature of Business</th>
                        <td>Trader – Retailer</td>
                    </tr>

                    <tr>
                        <th>Additional Business</th>
                        <td>
                            Office / Sales Office <br>
                            Wholesale Business <br>
                            Retail Business <br>
                            Warehouse / Depot
                        </td>
                    </tr>

                    <tr>
                        <th>Company CEO</th>
                        <td>Sanju Bamel</td>
                    </tr>

                    <tr>
                        <th>Registered Address</th>
                        <td>
                            Basement & Ground Floor B-9/1,
                            Badli Industrial Area Estate Phase-1,
                            North West Delhi - 110042
                        </td>
                    </tr>

                    <tr>
                        <th>Total Employees</th>
                        <td>51 - 100 People</td>
                    </tr>

                    <tr>
                        <th>GST Registration Date</th>
                        <td>08-09-2022</td>
                    </tr>

                    <tr>
                        <th>Legal Status</th>
                        <td>Limited Company</td>
                    </tr>

                    <tr>
                        <th>Annual Turnover</th>
                        <td>₹25 Crore - ₹100 Crore</td>
                    </tr>

                    <tr>
                        <th>GST Partner Name</th>
                        <td>Sanju Kumar Bamel, Azad Singh</td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

</section>

<!-- =========================
     STATUTORY PROFILE
========================= -->

<section class="py-5">
    <div class="container">
    <div class="text-center mb-5">
        <h2 class="section-title">
            Statutory Profile
        </h2>
    </div>

    <div class="row g-4">

        <div class="col-lg-3 col-md-6">
            <div class="stat-box">
                <i class="bi bi-globe"></i>
                <h6>IEC Code</h6>
                <p>ABCCS5191A</p>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-box">
                <i class="bi bi-receipt"></i>
                <h6>TAN No.</h6>
                <p>DELS7*****</p>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-box">
                <i class="bi bi-file-earmark-text"></i>
                <h6>GST No.</h6>
                <p>27ABCCS5191A2ZH</p>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-box">
                <i class="bi bi-building"></i>
                <h6>CIN No.</h6>
                <p>U51506DL2019PTC353975</p>
            </div>
        </div>

    </div>

</div>
</section>

<!-- =========================
     WHY US
========================= -->

<section class="py-5 bg-light-custom">
    <div class="container">
    <div class="text-center mb-5">
        <h2 class="section-title">
            Why Choose Us
        </h2>

        <p class="section-desc">
            Factors that make us a preferred choice among our customers.
        </p>
    </div>

    @php
        $features = [
            ['icon'=>'bi-award','title'=>'Quality Assurance'],
            ['icon'=>'bi-people','title'=>'Expert Team'],
            ['icon'=>'bi-gear','title'=>'Advanced Technology'],
            ['icon'=>'bi-currency-rupee','title'=>'Competitive Pricing'],
            ['icon'=>'bi-truck','title'=>'Timely Delivery'],
            ['icon'=>'bi-headset','title'=>'After Sales Support'],
            ['icon'=>'bi-shield-check','title'=>'Trusted Brand'],
            ['icon'=>'bi-diagram-3','title'=>'Strong Network'],
        ];
    @endphp

    <div class="row g-4">

        @foreach($features as $item)

        <div class="col-lg-3 col-md-4 col-sm-6">

            <div class="why-card">

                <i class="bi {{ $item['icon'] }}"></i>

                <span>
                    {{ $item['title'] }}
                </span>

            </div>

        </div>

        @endforeach

    </div>

</div>

</section>

@endsection

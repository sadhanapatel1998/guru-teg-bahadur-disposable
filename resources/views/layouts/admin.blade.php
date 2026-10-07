<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Finesse by Designed Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

  {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ base_public_url('assets/css/admin.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jodit@3.24.9/build/jodit.min.css">
 
    @stack('styles')
</head>
<body>

<div class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-logo"
     style="
        padding:10px;
        margin:12px;
        background:#fff;
        border-radius:10px;
        box-shadow:0 6px 18px rgba(0,0,0,.06);
        text-align:center;
     ">
    <a class="navbar-brand d-flex align-items-center justify-content-center"
       href="{{ route('home') }}">
        @if (setting('site_logo'))
            <img src="{{ asset('public/storage/' . setting('site_logo')) }}"
                 alt="{{ config('app.name') }}"
                 style="
                    width:100%;
                    max-width:190px;
                    max-height:75px;
                    height:auto;
                    object-fit:contain;
                    display:block;
                    margin:auto;
                    border-radius:6px;
                 ">
        @else
            <p>Logo</p>
        @endif
    </a>
</div>
    <nav class="sidebar-nav">
        <div class="sidebar-section">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="sidebar-section">Catalog</div>
          <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="bi bi-grid"></i> Categories
        </a>
                 
        <a href="{{ route('admin.subcategories.index') }}" class="nav-link {{ request()->routeIs('admin.subcategories.*') ? 'active' : '' }}">
            <i class="bi bi-grid-3x3-gap"></i> Subcategories
        </a>
        <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Products
        </a>
      

        <div class="sidebar-section">Sales</div>
        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i> Orders
        </a>
        <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Customers
        </a>
        <a href="{{ route('admin.coupons.index') }}" class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
            <i class="bi bi-tag"></i> Coupons
        </a>
        <a href="{{ route('admin.reviews.index') }}" class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            <i class="bi bi-star"></i> Reviews
        </a>

        <div class="sidebar-section">Content</div>
        <a href="{{ route('admin.banners.index') }}" class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
            <i class="bi bi-image"></i> Banners
        </a>
        <a href="{{ route('admin.blogs.index') }}" class="nav-link {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
            <i class="bi bi-newspaper"></i> Blogs
        </a>
        <a href="{{ route('admin.blog-categories.index') }}" class="nav-link {{ request()->routeIs('admin.blog-categories.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Blog Category
        </a>
        
        {{-- <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
            <i class="bi bi-chat-quote"></i> Testimonials
        </a>

        <div class="sidebar-section">Reports</div>
        <a href="{{ route('admin.reports.sales') }}" class="nav-link {{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}">
            <i class="bi bi-graph-up"></i> Sales
        </a>
        <a href="{{ route('admin.reports.inventory') }}" class="nav-link {{ request()->routeIs('admin.reports.inventory') ? 'active' : '' }}">
            <i class="bi bi-boxes"></i> Inventory
        </a>
        <a href="{{ route('admin.reports.customers') }}" class="nav-link {{ request()->routeIs('admin.reports.customers') ? 'active' : '' }}">
            <i class="bi bi-person-lines-fill"></i> Customer Report
        </a> --}}

<div class="sidebar-section">Settings</div>

<div class="nav-item">
    <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('admin.settings.*') || request()->routeIs('admin.pages.*') ? 'active' : '' }}"
       data-bs-toggle="collapse"
       href="#settingsMenu"
       role="button"
       aria-expanded="{{ request()->routeIs('admin.settings.*') || request()->routeIs('admin.pages.*') ? 'true' : 'false' }}"
       aria-controls="settingsMenu">
        <span>
            <i class="bi bi-gear"></i> Settings
        </span>
        <i class="bi bi-chevron-down"></i>
    </a>

    <div class="collapse {{ request()->routeIs('admin.settings.*') || request()->routeIs('admin.pages.*') ? 'show' : '' }}"
         id="settingsMenu">

        <a href="{{ route('admin.settings.general') }}"
           class="nav-link ms-3 {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i class="bi bi-globe"></i> Web Settings
        </a>

        <a href="{{ route('admin.pages.index') }}"
           class="nav-link ms-3 {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i> Pages
        </a>

    </div>
</div>

         <div class="sidebar-section">Tools</div>

        <a href="{{ route('admin.settings.storage-link') }}"
        class="nav-link"
        onclick="return confirm('Copy storage files and fix image issue?')">
            <i class="bi bi-link-45deg"></i>
            Fix Storage
        </a>

        <a href="{{ route('admin.settings.clear-cache') }}"
        class="nav-link"
        onclick="return confirm('Clear Application Cache?')">
            <i class="bi bi-arrow-clockwise"></i>
            Clear Cache
        </a>

        <div class="mt-3 mb-2 mx-2">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="nav-link w-100 text-start" style="background:none;border:none;color:rgba(255,255,255,.5);">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </nav>
</div>

<div class="admin-main">
    <div class="admin-topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-light d-lg-none" onclick="document.getElementById('adminSidebar').classList.toggle('open')">
                <i class="bi bi-list fs-5"></i>
            </button>
            <h6 class="mb-0 fw-700">@yield('title', 'Dashboard')</h6>
        </div>
        <div class="d-flex align-items-center gap-3">
            @if($lowStock = \App\Models\Product::where('manage_stock',true)->whereColumn('stock','<=','low_stock_threshold')->where('stock','>',0)->count())
            <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i>{{ $lowStock }} Low Stock</span>
            @endif
            <div class="d-flex align-items-center gap-2">
                <div style="width:36px;height:36px;border-radius:50%;background:var(--admin-light);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--admin-primary);">
                    {{ strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) }}
                </div>
                <span style="font-size:.85rem;font-weight:600;">{{ Auth::guard('admin')->user()->name }}</span>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mx-4 mt-3 mb-0" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mx-4 mt-3 mb-0" role="alert">
        <i class="bi bi-x-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="admin-content">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jodit@3.24.9/build/jodit.min.js"></script>

<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
</script>
@stack('scripts')
</body>
</html>

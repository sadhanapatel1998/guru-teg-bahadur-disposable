@extends('layouts.app')
@section('title', '404 — Page Not Found')
@section('content')
<section class="py-5" style="min-height:70vh;display:flex;align-items:center;">
<div class="container text-center">
    <div style="font-size:6rem;font-weight:900;color:var(--kkt-light);line-height:1;">404</div>
    <h3 class="fw-800 mt-2" style="color:var(--kkt-dark);">Page Not Found</h3>
    <p class="text-muted mb-4">The page you're looking for doesn't exist or has been moved.</p>
    <a href="{{ route('home') }}" class="btn btn-primary px-5 me-2">Go Home</a>
    <a href="{{ route('shop') }}" class="btn btn-outline-primary px-5">Browse Shop</a>
</div>
</section>
@endsection

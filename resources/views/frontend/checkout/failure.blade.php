@extends('layouts.app')
@section('title', 'Payment Failed')
@section('content')
<section class="py-5">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div style="width:80px;height:80px;background:#fce4ec;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:2.2rem;margin:0 auto 24px;">❌</div>
            <h3 class="fw-800" style="color:var(--kkt-dark);">Payment Failed</h3>
            <p class="text-muted">Something went wrong with your payment. No amount was charged.</p>
            <div class="d-flex gap-3 justify-content-center mt-4">
                <a href="{{ route('checkout.index') }}" class="btn btn-primary px-4">Try Again</a>
                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary px-4">Back to Cart</a>
            </div>
        </div>
    </div>
</div>
</section>
@endsection

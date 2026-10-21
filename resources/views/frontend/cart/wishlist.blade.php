@extends('layouts.app')
@section('title', 'Wishlist')
@section('content')
<section class="py-4 py-lg-5" id="wishlist-section" style="background:#F8FAFC;min-height:75vh;">
    <div class="container">
        @include('customer.partials.topbar', ['title' => 'My Wishlist'])

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <h4 class="fw-700 text-dark mb-0" id="wishlist-count-title" style="font-family:'Poppins',sans-serif;">My Wishlist (<span id="wishlist-count">{{ $items->count() }}</span>)</h4>
            <a href="{{ route('shop') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:10px;font-weight:600;"><i class="bi bi-bag-plus me-1"></i> Continue Shopping</a>
        </div>

        <div id="wishlist-empty-state" class="text-center py-5 bg-white rounded-4 border {{ $items->isEmpty() ? '' : 'd-none' }}">
            <i class="bi bi-heart" style="font-size:3rem;color:#CBD5E1;display:block;"></i>
            <h5 class="mt-3 text-muted">Your wishlist is empty</h5>
            <a href="{{ route('shop') }}" class="btn text-white mt-2 px-4" style="background:#D9232E;border-radius:12px;font-weight:600;"><i class="bi bi-cart3 me-1"></i> Browse Products</a>
        </div>

        <div class="row g-3" id="wishlist-grid" style="{{ $items->isEmpty() ? 'display:none;' : '' }}">
            @foreach($items as $item)
                @if($item->product)
                    @include('partials.product-card', ['product' => $item->product])
                @endif
            @endforeach
        </div>
    </div>
</section>
@endsection

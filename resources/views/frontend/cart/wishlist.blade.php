@extends('layouts.app')
@section('title', 'Wishlist')
@section('content')
<div class="breadcrumb-kkt">
    <div class="container">
        <nav>
            <ol class="breadcrumb mb-0" style="font-size:.84rem;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house-door-fill me-1"></i>Home</a></li>
                <li class="breadcrumb-item active">Wishlist</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5" id="wishlist-section">
    <div class="container">
        <h5 class="fw-700 mb-4" id="wishlist-count-title">My Wishlist (<span id="wishlist-count">{{ $items->count() }}</span>)</h5>

        <div id="wishlist-empty-state" class="text-center py-5 {{ $items->isEmpty() ? '' : 'd-none' }}">
            <i class="bi bi-heart" style="font-size:3rem;color:#cbd5e1;display:block;"></i>
            <h5 class="mt-3 text-muted">Your wishlist is empty</h5>
            <a href="{{ route('shop') }}" class="btn btn-primary mt-2">Browse Products</a>
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

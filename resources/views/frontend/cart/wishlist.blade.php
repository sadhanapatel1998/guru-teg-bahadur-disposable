@extends('layouts.app')
@section('title', 'Wishlist')
@section('content')
<div class="breadcrumb-kkt"><div class="container"><nav><ol class="breadcrumb mb-0" style="font-size:.84rem;"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Wishlist</li></ol></nav></div></div>
<section class="py-5">
<div class="container">
    <h5 class="fw-700 mb-4">My Wishlist ({{ $items->count() }})</h5>
    @if($items->isEmpty())
    <div class="text-center py-5"><i class="bi bi-heart" style="font-size:3rem;color:#e9ecef;display:block;"></i><h5 class="mt-3 text-muted">Your wishlist is empty</h5><a href="{{ route('shop') }}" class="btn btn-primary mt-2">Browse Products</a></div>
    @else
    <div class="row g-3">
        @foreach($items as $item) @if($item->product) @include('partials.product-card', ['product' => $item->product]) @endif @endforeach
    </div>
    @endif
</div>
</section>
@endsection

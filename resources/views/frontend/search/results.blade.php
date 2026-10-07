@extends('layouts.app')
@section('title', 'Search: ' . $query)
@section('content')
<div class="breadcrumb-kkt"><div class="container"><nav><ol class="breadcrumb mb-0" style="font-size:.84rem;"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Search</li></ol></nav></div></div>
<section class="py-5">
<div class="container">
    @if($query)
    <h5 class="fw-700 mb-1">Results for "{{ $query }}"</h5>
    <p class="text-muted mb-4" style="font-size:.88rem;">{{ $products instanceof \Illuminate\Pagination\LengthAwarePaginator ? $products->total() : 0 }} products found</p>
    @endif
    @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->count())
    <div class="row g-3">
        @foreach($products as $product) @include('partials.product-card', ['product' => $product]) @endforeach
    </div>
    <div class="mt-4 d-flex justify-content-center">{{ $products->links() }}</div>
    @elseif($query)
    <div class="text-center py-5"><i class="bi bi-search" style="font-size:3rem;color:#e9ecef;display:block;"></i><h5 class="mt-3 text-muted">We couldn’t find any products in this category or subcategory. </h5><a href="{{ route('shop') }}" class="btn btn-primary mt-2">Browse All</a></div>
    @endif
</div>
</section>
@endsection

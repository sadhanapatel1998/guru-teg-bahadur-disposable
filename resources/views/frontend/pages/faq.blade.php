@extends('layouts.app')
@section('content')
<div class="breadcrumb-kkt"><div class="container"><nav><ol class="breadcrumb mb-0" style="font-size:.84rem;"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">{{ ucfirst(request()->route()->getName()) }}</li></ol></nav></div></div>
<section class="py-5"><div class="container"><div class="row justify-content-center"><div class="col-lg-8">
<div class="bg-white rounded-4 border p-5" style="font-size:.97rem;line-height:1.9;color:#444;">
<p>This page content is managed via the admin panel. Please update it from Settings.</p>
</div>
</div></div></div></section>
@endsection

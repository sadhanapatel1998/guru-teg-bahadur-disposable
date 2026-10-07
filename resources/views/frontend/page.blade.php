@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)

@section('content')

<div class="breadcrumb-kkt">
    <div class="container">
        <nav>
            <ol class="breadcrumb mb-0" style="font-size:.84rem;">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>

                <li class="breadcrumb-item active">
                    {{ $page->title }}
                </li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-10">
                <div class="page-content">
                    {!! $page->content !!}
                </div>

            </div>

        </div>

    </div>
</section>

@endsection
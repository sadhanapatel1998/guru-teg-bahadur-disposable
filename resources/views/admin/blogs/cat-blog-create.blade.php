@extends('layouts.admin')

@section('title', isset($blogCategory) ? 'Edit Blog Category' : 'Create Blog Category')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                {{ isset($blogCategory) ? 'Edit Blog Category' : 'Create Blog Category' }}
            </h3>

            <p class="text-muted mb-0">
                Manage blog category details
            </p>
        </div>

    </div>

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <form
                action="{{ isset($blogCategory)
                    ? route('admin.blog-categories.update', $blogCategory->id)
                    : route('admin.blog-categories.store') }}"
                method="POST"
            >

                @csrf

                @if(isset($blogCategory))
                    @method('PUT')
                @endif

                <div class="row">

                    {{-- CATEGORY NAME --}}
                    <div class="col-lg-6 mb-4">

                        <label class="form-label fw-semibold">
                            Category Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control rounded-3"
                            placeholder="Enter category name"
                            value="{{ old('name', $blogCategory->name ?? '') }}"
                        >

                        @error('name')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                    {{-- SLUG --}}
                    <div class="col-lg-6 mb-4">

                        <label class="form-label fw-semibold">
                            Slug
                        </label>

                        <input
                            type="text"
                            name="slug"
                            class="form-control rounded-3"
                            placeholder="category-slug"
                            value="{{ old('slug', $blogCategory->slug ?? '') }}"
                        >

                        @error('slug')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                    {{-- STATUS --}}
                    <div class="col-lg-12 mb-4">

                        <div class="form-check form-switch">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="is_active"
                                value="1"
                                {{ old('is_active', $blogCategory->is_active ?? true) ? 'checked' : '' }}
                            >

                            <label class="form-check-label">
                                Active Category
                            </label>

                        </div>

                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="d-flex justify-content-end">

                    <a
                        href="{{ route('admin.blog-categories.index') }}"
                        class="btn btn-light border rounded-3 px-4 me-2"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="btn btn-admin-primary text-white rounded-3 px-4"
                    >

                        <i class="bi bi-check-circle me-2"></i>

                        {{ isset($blogCategory) ? 'Update Category' : 'Create Category' }}

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
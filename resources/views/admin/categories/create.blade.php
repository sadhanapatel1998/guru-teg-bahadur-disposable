@extends('layouts.admin')

@section('title', isset($category) ? 'Edit Category' : 'Add Category')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1 fw-semibold">
                {{ isset($category) ? 'Edit Category' : 'Add Category' }}
            </h4>

            <p class="text-muted small mb-0">
                Manage category details
            </p>

        </div>

        <a href="{{ route('admin.categories.index') }}"
           class="btn btn-light border rounded-3 px-3">

            <i class="bi bi-arrow-left me-1"></i>
            Back

        </a>

    </div>

    <form method="POST"
          action="{{ isset($category)
                    ? route('admin.categories.update', $category->id)
                    : route('admin.categories.store') }}"
          enctype="multipart/form-data">

        @csrf

        @isset($category)
            @method('PUT')
        @endisset

        <div class="row g-4">

            {{-- Left Side --}}
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-4">

                        <h6 class="fw-semibold mb-4">
                            Basic Information
                        </h6>

                        {{-- Name --}}
                        <div class="mb-3">

                            <label class="form-label small fw-medium">
                                Category Name
                            </label>

                            <input type="text"
                                   name="name"
                                   id="category-name"
                                   class="form-control rounded-3"
                                   value="{{ old('name', $category->name ?? '') }}"
                                   required>

                        </div>

                        {{-- Slug --}}
                        <div class="mb-3">

                            <label class="form-label small fw-medium">
                                Slug
                            </label>

                            <input type="text"
                                   name="slug"
                                   id="category-slug"
                                   class="form-control rounded-3"
                                   value="{{ old('slug', $category->slug ?? '') }}">

                        </div>

                        {{-- Description --}}
                        <div class="mb-3">

                            <label class="form-label small fw-medium">
                                Description
                            </label>

                            <textarea name="description"
                                      rows="4"
                                      class="form-control rounded-3">{{ old('description', $category->description ?? '') }}</textarea>

                        </div>

                        {{-- Icon --}}
                        <div>

                            <label class="form-label small fw-medium">
                                Icon
                            </label>

                            <input type="text"
                                   name="icon"
                                   class="form-control rounded-3"
                                   placeholder="bi bi-grid"
                                   value="{{ old('icon', $category->icon ?? '') }}">

                        </div>

                    </div>

                </div>

                {{-- SEO --}}
                <div class="card border-0 shadow-sm rounded-4 mt-4">

                    <div class="card-body p-4">

                        <h6 class="fw-semibold mb-4">
                            SEO Settings
                        </h6>

                        {{-- Meta Title --}}
                        <div class="mb-3">

                            <label class="form-label small fw-medium">
                                Meta Title
                            </label>

                            <input type="text"
                                   name="meta_title"
                                   class="form-control rounded-3"
                                   value="{{ old('meta_title', $category->meta_title ?? '') }}">

                        </div>

                        {{-- Meta Description --}}
                        <div class="mb-3">

                            <label class="form-label small fw-medium">
                                Meta Description
                            </label>

                            <textarea name="meta_description"
                                      rows="3"
                                      class="form-control rounded-3">{{ old('meta_description', $category->meta_description ?? '') }}</textarea>

                        </div>

                        {{-- Meta Keywords --}}
                        <div>

                            <label class="form-label small fw-medium">
                                Meta Keywords
                            </label>

                            <input type="text"
                                   name="meta_keywords"
                                   class="form-control rounded-3"
                                   value="{{ old('meta_keywords', $category->meta_keywords ?? '') }}">

                        </div>

                    </div>

                </div>

            </div>

            {{-- Right Side --}}
            <div class="col-lg-4">

                {{-- Image --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">

                    <div class="card-body p-4">

                        <h6 class="fw-semibold mb-4">
                            Category Image
                        </h6>

                        <input type="file"
                               name="image"
                               class="form-control rounded-3">

                        @if(isset($category) && $category->image)

                            <img src="{{ $category->image_url }}"
                                 class="img-fluid rounded-3 border mt-3">

                        @endif

                    </div>

                </div>

                {{-- Settings --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">

                    <div class="card-body p-4">

                        <h6 class="fw-semibold mb-4">
                            Settings
                        </h6>

                        {{-- Sort --}}
                        <div class="mb-3">

                            <label class="form-label small fw-medium">
                                Sort Order
                            </label>

                            <input type="number"
                                   name="sort_order"
                                   class="form-control rounded-3"
                                   value="{{ old('sort_order', $category->sort_order ?? 0) }}">

                        </div>

                        {{-- Active --}}
                        <div class="form-check form-switch mb-3">

                            <input class="form-check-input"
                                   type="checkbox"
                                   name="is_active"
                                   value="1"
                                   id="is_active"
                                   {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>

                            <label class="form-check-label small" for="is_active">
                                Active
                            </label>

                        </div>

                        {{-- Featured --}}
                        <div class="form-check form-switch">

                            <input class="form-check-input"
                                   type="checkbox"
                                   name="is_featured"
                                   value="1"
                                   id="is_featured"
                                   {{ old('is_featured', $category->is_featured ?? false) ? 'checked' : '' }}>

                            <label class="form-check-label small" for="is_featured">
                                Featured
                            </label>

                        </div>

                    </div>

                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="btn btn-dark w-100 rounded-3 py-2">

                    {{ isset($category) ? 'Update Category' : 'Create Category' }}

                </button>

            </div>

        </div>

    </form>

</div>

@endsection


@push('scripts')

<script>

document.getElementById('category-name').addEventListener('keyup', function () {

    let slug = this.value
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)/g, '');

    document.getElementById('category-slug').value = slug;

});

</script>

@endpush
@extends('layouts.admin')

@section('title', isset($subcategory) ? 'Edit Subcategory' : 'Add Subcategory')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1 fw-semibold">
                {{ isset($subcategory) ? 'Edit Subcategory' : 'Add Subcategory' }}
            </h4>

            <p class="text-muted small mb-0">
                Manage subcategory details
            </p>

        </div>

        <a href="{{ route('admin.subcategories.index') }}"
           class="btn btn-light border rounded-3 px-3">

            <i class="bi bi-arrow-left me-1"></i>
            Back

        </a>

    </div>

    <form method="POST"
          action="{{ isset($subcategory)
                    ? route('admin.subcategories.update', $subcategory->id)
                    : route('admin.subcategories.store') }}"
          enctype="multipart/form-data">

        @csrf

        @isset($subcategory)
            @method('PUT')
        @endisset

        <div class="row g-4">

            {{-- Left Side --}}
            <div class="col-lg-8">

                {{-- Basic Information --}}
                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-4">

                        <h6 class="fw-semibold mb-4">
                            Basic Information
                        </h6>

                        {{-- Category --}}
                        <div class="mb-3">

                            <label class="form-label small fw-medium">
                                Select Category
                            </label>

                            <select name="category_id"
                                    class="form-select rounded-3"
                                    required>

                                <option value="">
                                    Choose Category
                                </option>

                                @foreach($categories as $cat)

                                    <option value="{{ $cat->id }}"
                                        {{ old('category_id', $subcategory->category_id ?? '') == $cat->id ? 'selected' : '' }}>

                                        {{ $cat->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        {{-- Name --}}
                        <div class="mb-3">

                            <label class="form-label small fw-medium">
                                Subcategory Name
                            </label>

                            <input type="text"
                                   name="name"
                                   id="subcategory-name"
                                   class="form-control rounded-3"
                                   value="{{ old('name', $subcategory->name ?? '') }}"
                                   required>

                        </div>

                        {{-- Slug --}}
                        <div class="mb-3">

                            <label class="form-label small fw-medium">
                                Slug
                            </label>

                            <input type="text"
                                   name="slug"
                                   id="subcategory-slug"
                                   class="form-control rounded-3"
                                   value="{{ old('slug', $subcategory->slug ?? '') }}">

                        </div>

                        {{-- Description --}}
                        <div class="mb-3">

                            <label class="form-label small fw-medium">
                                Description
                            </label>

                            <textarea name="description"
                                      rows="4"
                                      class="form-control rounded-3">{{ old('description', $subcategory->description ?? '') }}</textarea>

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
                                   value="{{ old('meta_title', $subcategory->meta_title ?? '') }}">

                        </div>

                        {{-- Meta Description --}}
                        <div class="mb-3">

                            <label class="form-label small fw-medium">
                                Meta Description
                            </label>

                            <textarea name="meta_description"
                                      rows="3"
                                      class="form-control rounded-3">{{ old('meta_description', $subcategory->meta_description ?? '') }}</textarea>

                        </div>

                        {{-- Meta Keywords --}}
                        <div>

                            <label class="form-label small fw-medium">
                                Meta Keywords
                            </label>

                            <input type="text"
                                   name="meta_keywords"
                                   class="form-control rounded-3"
                                   value="{{ old('meta_keywords', $subcategory->meta_keywords ?? '') }}">

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
                            Subcategory Image
                        </h6>

                        <input type="file"
                               name="image"
                               class="form-control rounded-3">

                        @if(isset($subcategory) && $subcategory->image)

                            <img src="{{ $subcategory->image_url }}"
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
                                   value="{{ old('sort_order', $subcategory->sort_order ?? 0) }}">

                        </div>

                        {{-- Active --}}
                        <div class="form-check form-switch mb-3">

                            <input class="form-check-input"
                                   type="checkbox"
                                   name="is_active"
                                   value="1"
                                   id="is_active"
                                   {{ old('is_active', $subcategory->is_active ?? true) ? 'checked' : '' }}>

                            <label class="form-check-label small" for="is_active">
                                Active
                            </label>

                        </div>

                    </div>

                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="btn btn-dark w-100 rounded-3 py-2">

                    {{ isset($subcategory) ? 'Update Subcategory' : 'Create Subcategory' }}

                </button>

            </div>

        </div>

    </form>

</div>

@endsection


@push('scripts')

<script>

document.getElementById('subcategory-name').addEventListener('keyup', function () {

    let slug = this.value
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)/g, '');

    document.getElementById('subcategory-slug').value = slug;

});

</script>

@endpush
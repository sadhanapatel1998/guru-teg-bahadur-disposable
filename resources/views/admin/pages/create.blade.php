                                                                                                                                            @extends('layouts.admin')

@section('title', isset($page) ? 'Edit Page' : 'Create Page')

@section('content')

<div class="container-fluid">
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-dark">
            {{ isset($page) ? 'Edit Page' : 'Create Page' }}
        </h3>

        <p class="text-muted mb-0">
            Manage your page content
        </p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <form action="{{ isset($page) ? route('admin.pages.update', $page->id) : route('admin.pages.store') }}"
            method="POST">

            @csrf

            @if(isset($page))
                @method('PUT')
            @endif

            <div class="row">

                {{-- PAGE TITLE --}}
                <div class="col-lg-8 mb-4">

                    <label class="form-label fw-semibold">
                        Page Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control form-control-lg rounded-3"
                        placeholder="Enter page title"
                        value="{{ old('title', $page->title ?? '') }}"
                        required>

                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                {{-- STATUS --}}
                <div class="col-lg-4 mb-4">

                    <label class="form-label fw-semibold">
                        Status
                    </label>

                    <select name="status" class="form-select form-select-lg rounded-3">

                        <option value="draft"
                            {{ old('status', $page->status ?? 'draft') == 'draft' ? 'selected' : '' }}>
                            Draft
                        </option>

                        <option value="published"
                            {{ old('status', $page->status ?? '') == 'published' ? 'selected' : '' }}>
                            Published
                        </option>

                    </select>

                </div>

                {{-- SLUG --}}
                <div class="col-lg-12 mb-4">

                    <label class="form-label fw-semibold">
                        Slug
                    </label>

                    <input
                        type="text"
                        name="slug"
                        id="slug"
                        class="form-control rounded-3"
                        placeholder="about-us"
                        value="{{ old('slug', $page->slug ?? '') }}"
                        required>

                    @error('slug')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                {{-- CONTENT --}}
                <div class="col-lg-12 mb-4">

                    <label class="form-label fw-semibold">
                        Page Content
                    </label>

                    <textarea
                        name="content"
                        id="editor"
                        class="form-control rounded-3"
                        rows="10">{{ old('content', $page->content ?? '') }}</textarea>

                    @error('content')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

            </div>

            {{-- SEO SECTION --}}
            <div class="card border rounded-4 mt-4">

                <div class="card-header bg-white border-0 pt-4 px-4">

                    <h5 class="fw-bold mb-1">
                        SEO Settings
                    </h5>

                    <p class="text-muted small mb-0">
                        Improve search engine visibility
                    </p>

                </div>

                <div class="card-body px-4 pb-4">

                    <div class="row">

                        {{-- META TITLE --}}
                        <div class="col-lg-12 mb-4">

                            <label class="form-label fw-semibold">
                                Meta Title
                            </label>

                            <input
                                type="text"
                                name="meta_title"
                                class="form-control rounded-3"
                                placeholder="Meta title"
                                value="{{ old('meta_title', $page->meta_title ?? '') }}">

                        </div>

                        {{-- META DESCRIPTION --}}
                        <div class="col-lg-12 mb-4">

                            <label class="form-label fw-semibold">
                                Meta Description
                            </label>

                            <textarea
                                name="meta_description"
                                rows="4"
                                class="form-control rounded-3"
                                placeholder="Meta description...">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>

                        </div>

                        {{-- META KEYWORDS --}}
                        <div class="col-lg-6 mb-4">

                            <label class="form-label fw-semibold">
                                Meta Keywords
                            </label>

                            <input
                                type="text"
                                name="meta_keywords"
                                class="form-control rounded-3"
                                placeholder="keyword1, keyword2"
                                value="{{ old('meta_keywords', $page->meta_keywords ?? '') }}">

                        </div>

                        {{-- CANONICAL URL --}}
                        <div class="col-lg-6 mb-4">

                            <label class="form-label fw-semibold">
                                Canonical URL
                            </label>

                            <input
                                type="text"
                                name="canonical_url"
                                class="form-control rounded-3"
                                placeholder="https://example.com/page"
                                value="{{ old('canonical_url', $page->canonical_url ?? '') }}">

                        </div>

                    </div>

                </div>

            </div>

            {{-- BUTTONS --}}
            <div class="d-flex justify-content-end mt-4">

                <a href="{{ route('admin.pages.index') }}"
                    class="btn btn-light border rounded-3 px-4 me-2">
                    Cancel
                </a>

                <button type="submit" class="btn btn-admin-primary text-white">
                    <i class="bi bi-check-circle me-2"></i>

                    {{ isset($page) ? 'Update Page' : 'Create Page' }}
                </button>

            </div>

        </form>

    </div>

</div>

</div>

@endsection

@push('scripts')

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
ClassicEditor.create(document.querySelector('#editor'))
    .catch(error => {
        console.error(error);
    });

document.getElementById('title').addEventListener('keyup', function() {

    let slug = this.value
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');

    document.getElementById('slug').value = slug;
});
</script>

@endpush

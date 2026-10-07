@extends('layouts.admin')

@section('title', isset($blog) ? 'Edit Blog Post' : 'Create Blog Post')

@section('content')

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-1 text-dark">
                    {{ isset($blog) ? 'Edit Blog Post' : 'Create Blog Post' }}
                </h3>

                <p class="text-muted mb-0">
                    Manage your blog content and SEO settings
                </p>
            </div>

        </div>

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-4">

                <form action="{{ isset($blog) ? route('admin.blogs.update', $blog->id) : route('admin.blogs.store') }}"
                    method="POST" enctype="multipart/form-data">

                    @csrf

                    @if (isset($blog))
                        @method('PUT')
                    @endif

                    <div class="row">

                        {{-- TITLE --}}
                        <div class="col-lg-8 mb-4">

                            <label class="form-label fw-semibold">
                                Blog Title
                            </label>

                            <input type="text" name="title" class="form-control form-control-lg rounded-3"
                                placeholder="Enter blog title" value="{{ old('title', $blog->title ?? '') }}">

                        </div>

                        {{-- STATUS --}}
                        <div class="col-lg-4 mb-4">

                            <label class="form-label fw-semibold">
                                Status
                            </label>

                            <select name="status" class="form-select form-select-lg rounded-3">
                                <option value="draft" {{ old('status', $blog->status ?? '') == 'draft' ? 'selected' : '' }}>
                                    Draft
                                </option>

                                <option value="published"
                                    {{ old('status', $blog->status ?? '') == 'published' ? 'selected' : '' }}>
                                    Published
                                </option>

                            </select>

                        </div>

                        {{-- SLUG --}}
                        <div class="col-lg-6 mb-4">

                            <label class="form-label fw-semibold">
                                Slug
                            </label>

                            <input type="text" name="slug" class="form-control rounded-3" placeholder="blog-post-url"
                                value="{{ old('slug', $blog->slug ?? '') }}">

                        </div>

                        {{-- CATEGORY --}}
                        <div class="col-lg-6 mb-4">

                            <label class="form-label fw-semibold">
                                Category
                            </label>

                            <select name="blog_category_id" class="form-select rounded-3">

                                <option value="">
                                    Select Category
                                </option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('blog_category_id', $blog->blog_category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- SHORT DESCRIPTION --}}
                        <div class="col-lg-12 mb-4">

                            <label class="form-label fw-semibold">
                                Short Description
                            </label>

                            <textarea name="excerpt" rows="4" class="form-control rounded-3" placeholder="Write short description...">{{ old('excerpt', $blog->excerpt ?? '') }}</textarea>

                        </div>

                      {{-- CONTENT --}}
                            <div class="col-lg-12 mb-4">

                                <label class="form-label fw-semibold">
                                    Blog Content
                                </label>

                                <textarea
                                    name="body"
                                    id="editor"
                                    class="form-control rounded-3"
                                >{{ old('body', $blog->body ?? '') }}</textarea>

                            </div>

                        {{-- THUMBNAIL --}}
                        <div class="col-lg-6 mb-4">

                            <label class="form-label fw-semibold">
                                Thumbnail Image
                            </label>

                            <input type="file" name="thumbnail" class="form-control rounded-3">

                            @if (isset($blog) && $blog->thumbnail)
                                <div class="mt-3">

                                    <img src="{{ asset('public/storage/' . $blog->thumbnail) }}" class="img-fluid rounded-3 border"
                                        style="width:140px;height:100px;object-fit:cover;">

                                </div>
                            @endif

                        </div>

                        {{-- TAGS --}}
                        <div class="col-lg-6 mb-4">

                            <label class="form-label fw-semibold">
                                Tags
                            </label>
                           <input
                                type="text"
                                name="tags"
                                class="form-control rounded-3"
                                placeholder="business, education, marketing"
                                value="{{ old('tags', isset($blog) ? (is_array($blog->tags) ? implode(',', $blog->tags) : $blog->tags) : '') }}">

                        </div>

                    </div>

                    {{-- SEO SECTION --}}
                    <div class="card border rounded-4 mt-3">

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

                                    <input type="text" name="meta_title" class="form-control rounded-3"
                                        placeholder="Meta title" value="{{ old('meta_title', $blog->meta_title ?? '') }}">

                                </div>



                                {{-- META DESCRIPTION --}}
                                <div class="col-lg-12">

                                    <label class="form-label fw-semibold">
                                        Meta Description
                                    </label>

                                    <textarea name="meta_description" rows="4" class="form-control rounded-3" placeholder="Meta description...">{{ old('meta_description', $blog->meta_description ?? '') }}</textarea>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- BUTTONS --}}
                    <div class="d-flex justify-content-end mt-4">

                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-light border rounded-3 px-4 me-2">
                            Cancel
                        </a>

                        <button type="submit" class="btn btn-admin-primary text-white">
                            <i class="bi bi-check-circle me-2"></i>

                            {{ isset($blog) ? 'Update Blog' : 'Publish Blog' }}
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection

@push('scripts')
<script>
    new Jodit('#editor', {
        height: 450,
        placeholder: 'Start writing...'
    });
</script>
@endpush
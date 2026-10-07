@extends('layouts.admin')
@section('title', 'Blog Posts')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Blog Posts</h4>
            <p class="text-muted mb-0">
                Manage all blog posts
            </p>
        </div>

        <a href="{{ route('admin.blogs.create') }}" class="btn btn-admin-primary text-white">

            <i class="bi bi-plus-circle me-1"></i>
            Add Blog

        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="70">#</th>
                            <th width="90">Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Published</th>
                            <th width="150" class="text-center">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($blogs as $blog)
                            <tr>
                                <td>
                                    {{ $blog->id }}
                                </td>
                                <td>

                                    <img src="{{ $blog->thumbnail_url }}" alt="{{ $blog->title }}" class="rounded-3 border"
                                        width="60" height="60" style="object-fit:cover;">
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark mb-1">
                                        {{ $blog->title }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $blog->slug }}
                                    </small>
                                </td>
                                <td>
                                    @if ($blog->blogCategory)
                                        <span class="badge bg-info-subtle text-dark px-3 py-2 rounded-pill">
                                            {{ $blog->blogCategory->name }}
                                        </span>
                                    @else
                                        <span class="text-muted">
                                            N/A
                                        </span>
                                    @endif
                                </td>
                                <td>

                                    @if ($blog->status == 'published')
                                        <span class="badge bg-success px-3 py-2 rounded-pill">
                                            Published
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                            Draft
                                        </span>
                                    @endif

                                </td>
                                <td>
                                    <span class="fw-semibold">
                                        {{ $blog->views }}
                                    </span>
                                </td>
                                <td>

                                    @if ($blog->published_at)
                                        {{ $blog->published_at->format('d M Y') }}
                                    @else
                                        <span class="text-muted">
                                            --
                                        </span>
                                    @endif

                                </td>
                                <td>

                                    <div class="d-flex gap-2">

                                        {{-- Edit --}}
                                        <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-sm btn-warning">

                                            <i class="fa-solid fa-pen-to-square"></i>

                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST"
                                            onsubmit="return confirm('Delete this category?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger">

                                                <i class="fa-solid fa-trash-can"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8" class="text-center py-5">

                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486740.png" width="90"
                                        class="mb-3">

                                    <h6 class="fw-bold">
                                        No Blogs Found
                                    </h6>

                                    <p class="text-muted mb-0">
                                        Start by creating your first blog post.
                                    </p>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    @if ($blogs->hasPages())
        <div class="mt-4">
            {{ $blogs->links() }}

        </div>
    @endif

@endsection

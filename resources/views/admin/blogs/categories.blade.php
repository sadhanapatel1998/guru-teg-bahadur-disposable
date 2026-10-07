@extends('layouts.admin')

@section('title', 'Blog Categories')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Blog Categories
            </h3>

            <p class="text-muted mb-0">
                Manage all blog categories
            </p>
        </div>

        <a href="{{ route('admin.blog-categories.create') }}"
           class="btn btn-admin-primary text-white rounded-3">

            <i class="bi bi-plus-circle me-2"></i>
            Add Category

        </a>

    </div>

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead class="bg-light">

                        <tr>

                            <th class="px-4 py-3 fw-semibold">
                                #
                            </th>

                            <th class="py-3 fw-semibold">
                                Category Name
                            </th>

                            <th class="py-3 fw-semibold">
                                Slug
                            </th>

                            <th class="py-3 fw-semibold">
                                Blogs
                            </th>

                            <th class="py-3 fw-semibold">
                                Status
                            </th>

                            <th class="text-end px-4 py-3 fw-semibold">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($categories as $key => $category)

                            <tr>

                                <td class="px-4">
                                    {{ $key + 1 }}
                                </td>

                                <td>

                                    <div class="fw-semibold text-dark">
                                        {{ $category->name }}
                                    </div>

                                </td>

                                <td>

                                    <span class="text-muted">
                                        {{ $category->slug }}
                                    </span>

                                </td>

                                <td>

                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                        {{ $category->blogs_count ?? $category->blogs->count() }} Blogs
                                    </span>

                                </td>

                                <td>

                                    @if($category->is_active)

                                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                            Active
                                        </span>

                                    @else

                                        <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                                            Inactive
                                        </span>

                                    @endif

                                </td>

                               

                                <td class="text-end px-4">

                                    <div class="d-flex justify-content-end gap-2">

                                        <a href="{{ route('admin.blog-categories.edit',$category->id) }}"
                                         class="btn btn-sm btn-warning">

                                            <i class="bi bi-pencil-square"></i>

                                        </a>

                                        <form
                                            action="{{ route('admin.blog-categories.destroy',$category->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Delete this category?')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                               class="btn btn-sm btn-danger"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="text-center py-5">

                                    <img
                                        src="https://cdn-icons-png.flaticon.com/512/7486/7486740.png"
                                        width="90"
                                        class="mb-3 opacity-75"
                                    >

                                    <h6 class="fw-semibold mb-1">
                                        No Categories Found
                                    </h6>

                                    <p class="text-muted small mb-0">
                                        Start by creating your first blog category
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>
             {{-- Pagination --}}
                <div class="d-flex justify-content-between align-items-center mt-4">

                    <div class="text-muted small mx-3">
                        Showing
                        {{ $categories->firstItem() }}
                        to
                        {{ $categories->lastItem() }}
                        of
                        {{ $categories->total() }}
                        entries
                    </div>

                    {{ $categories->links('pagination::bootstrap-5') }}

                </div>

        </div>

    </div>

</div>

@endsection
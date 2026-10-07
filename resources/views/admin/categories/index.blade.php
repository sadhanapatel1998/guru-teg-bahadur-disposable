@extends('layouts.admin')
@section('title', 'Categories')

@section('content')

    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="fw-bold mb-1">
                    Categories Management
                </h4>

                <p class="text-muted mb-0">
                    Manage all product categories
                </p>
            </div>

            <a href="{{ route('admin.categories.create') }}" class="btn btn-admin-primary text-white">

                <i class="bi bi-plus-circle me-2"></i>
                Add Category
            </a>

        </div>

        {{-- Card --}}
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Table --}}
                <div class="table-responsive">

                    <table class="table align-middle table-hover">

                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Featured</th>
                                <th width="150">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($categories as $category)
                                <tr>

                                    {{-- Serial --}}
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    {{-- Image --}}
                                    <td>

                                        @if ($category->image)
                                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}" width="80"
                                                height="80" class="rounded-3 border" style="object-fit:cover;">
                                        @else
                                            <div class="text-muted small">
                                                No Image
                                            </div>
                                        @endif

                                    </td>

                                    {{-- Name --}}
                                    <td>

                                        <div class="fw-semibold">
                                            {{ $category->name }}
                                        </div>

                                        @if ($category->description)
                                            <small class="text-muted">
                                                {{ Str::limit($category->description, 50) }}
                                            </small>
                                        @endif

                                    </td>

                                    {{-- Slug --}}
                                    <td>
                                        <code>{{ $category->slug }}</code>
                                    </td>

                                    {{-- Status --}}
                                    <td>

                                        @if ($category->is_active)
                                            <span class="badge bg-success">
                                                Active
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                Inactive
                                            </span>
                                        @endif

                                    </td>

                                    {{-- Featured --}}
                                    <td>

                                        @if ($category->is_featured)
                                            <span class="badge bg-primary">
                                                Featured
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                No
                                            </span>
                                        @endif

                                    </td>

                                    {{-- Actions --}}
                                    <td>

                                        <div class="d-flex gap-2">

                                            {{-- Edit --}}
                                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                class="btn btn-sm btn-warning">

                                                <i class="fa-solid fa-pen-to-square"></i>

                                            </a>

                                            {{-- Delete --}}
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                                method="POST" onsubmit="return confirm('Delete this category?')">

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

                                    <td colspan="7" class="text-center py-5">

                                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486740.png" width="120"
                                            class="mb-3">

                                        <h6>No Categories Found</h6>

                                        <p class="text-muted mb-0">
                                            Add your first category.
                                        </p>

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>


                </div>
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

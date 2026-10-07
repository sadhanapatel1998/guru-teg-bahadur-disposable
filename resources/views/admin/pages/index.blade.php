@extends('layouts.admin')
@section('title', 'Blog Posts')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Pages</h4>
            <p class="text-muted mb-0">
                Manage all Pages
            </p>
        </div>

        <a href="{{ route('admin.pages.create') }}" class="btn btn-admin-primary text-white">

            <i class="bi bi-plus-circle me-1"></i>
            Add Page

        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="70">#</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th width="150" class="text-center">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pages as $page)
                            <tr>
                                <td>{{ $page->id }}</td>

                                <td>
                                    {{ $page->title }}
                                </td>

                                <td>
                                    {{ $page->slug }}
                                </td>

                             <td>
                                @if ($page->status == 'published')
                                    <span class="badge bg-success">
                                        Published
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        Draft
                                    </span>
                                @endif
                            </td>
                                <td>
                                    <div class="d-flex gap-2">

                                        <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST"
                                            onsubmit="return confirm('Delete this page?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>

                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    No Pages Found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
   @if ($pages->hasPages())
    {{ $pages->links() }}
@endif

@endsection

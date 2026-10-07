@extends('layouts.admin')

@section('title', 'Banners')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Banner Management</h4>
            <p class="text-muted mb-0">Manage homepage banners</p>
        </div>

       <a href="{{ route('admin.banners.create') }}" class="btn btn-admin-primary text-white">
        <i class="bi bi-plus-circle me-2"></i>Add Banner
    </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table align-middle table-hover">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Banner</th>
                            <th>Status</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($banners as $banner)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                @if($banner->image)
                                    <img 
                                        src="{{ asset('/public/storage/'.$banner->image) }}"
                                        alt="{{ $banner->title }}"
                                        width="120"
                                        height="70"
                                        class="rounded-3 border"
                                        style="object-fit:cover;"
                                    >
                                @else
                                    <div class="text-muted small">
                                        No Image
                                    </div>
                                @endif
                            </td>

                            <td>
                                @if($banner->is_active)
                                    <span class="badge bg-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td>

                                <div class="d-flex gap-2">

                                    <a href="{{ route('admin.banners.edit', $banner->id) }}"
                                        class="btn btn-sm btn-warning">
                                       <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <form action="{{ route('admin.banners.destroy', $banner->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Delete this banner?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="btn btn-sm btn-danger">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486740.png"
                                    width="120"
                                    class="mb-3">

                                <h6>No Banners Found</h6>

                                <p class="text-muted mb-0">
                                    Add your first homepage banner.
                                </p>
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

@endsection
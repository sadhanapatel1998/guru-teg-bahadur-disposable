@extends('layouts.admin')
@section('title', isset($banner) ? 'Edit Banner' : 'Add Banner')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-700 mb-0">
        {{ isset($banner) ? 'Edit Banner' : 'Add New Banner' }}
    </h5>

    <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Back
    </a>
</div>

<form method="POST"
      action="{{ isset($banner) ? route('admin.banners.update', $banner) : route('admin.banners.store') }}"
      enctype="multipart/form-data">

    @csrf
    @isset($banner)
        @method('PUT')
    @endisset

    <div class="row g-4">

        {{-- Left --}}
        <div class="col-xl-12">
            
      
            {{-- Desktop Image --}}
            <div class="form-card mb-4">
                <h6 class="fw-700 mb-3 pb-2 border-bottom">
                    Desktop Banner
                </h6>

                <div class="mb-3">
                    <label class="form-label">
                        Banner Image
                        @if(!isset($banner))
                            <span class="text-danger">*</span>
                        @endif
                    </label>

                    <input type="file"
                           name="image"
                           accept="image/*"
                           class="form-control @error('image') is-invalid @enderror">

                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if(isset($banner) && $banner->image)
                    <img src="{{ asset('public/storage/' . $banner->image) }}"
                         class="img-fluid rounded border"
                         style="max-height:220px; width:100%; object-fit:cover;">
                @endif
            </div>

            {{-- Mobile Image --}}
            <div class="form-card mb-4">
                <h6 class="fw-700 mb-3 pb-2 border-bottom">
                    Mobile Banner
                </h6>

                <div class="mb-3">
                    <label class="form-label">
                        Mobile Image
                    </label>

                    <input type="file"
                           name="mobile_image"
                           accept="image/*"
                           class="form-control @error('mobile_image') is-invalid @enderror">

                    @error('mobile_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if(isset($banner) && $banner->mobile_image)
                    <img src="{{ asset('public/storage/' . $banner->mobile_image) }}"
                         class="img-fluid rounded border"
                         style="max-height:220px; width:100%; object-fit:cover;">
                @endif
            </div>

            {{-- Status --}}
            <div class="form-card mb-4">

                <div class="form-check form-switch">
                    <input class="form-check-input"
                           type="checkbox"
                           role="switch"
                           id="isActive"
                           name="is_active"
                           value="1"
                           {{ old('is_active', $banner->is_active ?? true) ? 'checked' : '' }}>

                    <label class="form-check-label" for="isActive">
                        Active Banner
                    </label>
                </div>

            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="btn btn-admin-primary text-white w-40 py-2">

                <i class="bi bi-check2-circle me-2"></i>

                {{ isset($banner) ? 'Update Banner' : 'Create Banner' }}
            </button>


        </div>

    </div>

</form>

@endsection
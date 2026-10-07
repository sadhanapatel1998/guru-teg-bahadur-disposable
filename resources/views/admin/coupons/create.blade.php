@extends('layouts.admin')

@section('title', isset($coupon) ? 'Edit Coupon' : 'Add Coupon')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-semibold mb-1">
                {{ isset($coupon) ? 'Edit Coupon' : 'Add Coupon' }}
            </h4>

            <p class="text-muted small mb-0">
                Manage coupon details
            </p>
        </div>

        <a href="{{ route('admin.coupons.index') }}"
           class="btn btn-light border rounded-3">
            <i class="bi bi-arrow-left me-1"></i>
            Back
        </a>

    </div>

    <form method="POST"
          action="{{ isset($coupon)
                    ? route('admin.coupons.update', $coupon->id)
                    : route('admin.coupons.store') }}">

        @csrf

        @isset($coupon)
            @method('PUT')
        @endisset

        <div class="row g-4">

            <div class="col-lg-12">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-4">

                        <h6 class="fw-semibold mb-4">
                            Coupon Information
                        </h6>

                        {{-- Code --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Coupon Code
                            </label>

                            <input type="text"
                                   name="code"
                                   class="form-control rounded-3"
                                   value="{{ old('code', $coupon->code ?? '') }}"
                                   required>

                        </div>

                        {{-- Description --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Description
                            </label>

                            <textarea name="description"
                                      rows="3"
                                      class="form-control rounded-3">{{ old('description', $coupon->description ?? '') }}</textarea>

                        </div>

                        <div class="row">

                            {{-- Type --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Coupon Type
                                </label>

                                <select name="type"
                                        class="form-select rounded-3"
                                        required>

                                    <option value="percentage"
                                        {{ old('type', $coupon->type ?? '') == 'percentage' ? 'selected' : '' }}>
                                        Percentage
                                    </option>

                                    <option value="fixed"
                                        {{ old('type', $coupon->type ?? '') == 'fixed' ? 'selected' : '' }}>
                                        Fixed
                                    </option>

                                </select>

                            </div>

                            {{-- Value --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Discount Value
                                </label>

                                <input type="number"
                                       step="0.01"
                                       name="value"
                                       class="form-control rounded-3"
                                       value="{{ old('value', $coupon->value ?? '') }}"
                                       required>

                            </div>

                        </div>

                        <div class="row">

                            {{-- Min Order --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Minimum Order Amount
                                </label>

                                <input type="number"
                                       step="0.01"
                                       name="min_order_amount"
                                       class="form-control rounded-3"
                                       value="{{ old('min_order_amount', $coupon->min_order_amount ?? '') }}">

                            </div>

                            {{-- Max Discount --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Maximum Discount Amount
                                </label>

                                <input type="number"
                                       step="0.01"
                                       name="max_discount_amount"
                                       class="form-control rounded-3"
                                       value="{{ old('max_discount_amount', $coupon->max_discount_amount ?? '') }}">

                            </div>

                        </div>

                        <div class="row">

                            {{-- Usage Limit --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Usage Limit
                                </label>

                                <input type="number"
                                       name="usage_limit"
                                       class="form-control rounded-3"
                                       value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}">

                            </div>

                            {{-- Per User --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Usage Limit Per User
                                </label>

                                <input type="number"
                                       name="usage_limit_per_user"
                                       class="form-control rounded-3"
                                       value="{{ old('usage_limit_per_user', $coupon->usage_limit_per_user ?? 1) }}">

                            </div>

                        </div>

                        <div class="row">

                            {{-- Start Date --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Start Date
                                </label>

                                <input type="datetime-local"
                                       name="starts_at"
                                       class="form-control rounded-3"
                                       value="{{ old('starts_at', isset($coupon->starts_at) ? $coupon->starts_at->format('Y-m-d\TH:i') : '') }}">

                            </div>

                            {{-- Expiry Date --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Expiry Date
                                </label>

                                <input type="datetime-local"
                                       name="expires_at"
                                       class="form-control rounded-3"
                                       value="{{ old('expires_at', isset($coupon->expires_at) ? $coupon->expires_at->format('Y-m-d\TH:i') : '') }}">

                            </div>

                            <h6 class="fw-semibold mb-4">
                            Settings
                        </h6>

                        {{-- Active --}}
                        <div class="form-check form-switch mb-3">

                            <input class="form-check-input"
                                   type="checkbox"
                                   name="is_active"
                                   value="1"
                                   id="is_active"
                                   {{ old('is_active', $coupon->is_active ?? true) ? 'checked' : '' }}>

                            <label class="form-check-label"
                                   for="is_active">

                                Active Coupon

                            </label>

                        </div>
                           {{-- Submit --}}
                     <div class="text-end">

                    <button type="submit"
                            class="btn btn-dark rounded-3 px-4 py-2">

                        {{ isset($coupon) ? 'Update Coupon' : 'Create Coupon' }}

                    </button>

                        </div>

                        </div>

                    </div>

                </div>

            </div>

           
        </div>

    </form>

</div>

@endsection
@extends('layouts.app')
@section('title', 'My Profile')
@section('content')
<div class="py-5" style="background:#f8f9fa;min-height:70vh;">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="bg-white rounded-4 border p-4 mb-4">
                <h6 class="fw-700 mb-4">Update Profile</h6>
                @if($errors->any())<div class="alert alert-danger py-2 mb-3" style="font-size:.84rem;">{{ $errors->first() }}</div>@endif
                <form method="POST" action="{{ route('account.profile.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="text-center mb-4">
                        <img src="{{ $user->avatar_url }}" id="avatar-preview" style="width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid var(--kkt-light);">
                        <label for="avatar-input" class="d-block mt-2" style="cursor:pointer;font-size:.84rem;color:var(--kkt-primary);">Change Photo</label>
                        <input type="file" id="avatar-input" name="avatar" class="d-none" accept="image/*" onchange="previewAvatar(this)">
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-600" style="font-size:.85rem;">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600" style="font-size:.85rem;">Phone</label>
                            <input type="tel" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600" style="font-size:.85rem;">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" value="{{ old('dob', $user->dob?->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600" style="font-size:.85rem;">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">Prefer not to say</option>
                                <option value="male" {{ $user->gender === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ $user->gender === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ $user->gender === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4 px-4">Save Changes</button>
                </form>
            </div>
            <div class="bg-white rounded-4 border p-4">
                <h6 class="fw-700 mb-4">Change Password</h6>
                <form method="POST" action="{{ route('account.password.update') }}">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-600" style="font-size:.85rem;">Current Password</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-600" style="font-size:.85rem;">New Password</label>
                        <input type="password" name="password" class="form-control" required minlength="8">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-600" style="font-size:.85rem;">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4 px-4">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@push('scripts')
<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById('avatar-preview').src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection

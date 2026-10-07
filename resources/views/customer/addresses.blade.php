@extends('layouts.app')
@section('title', 'My Addresses')
@section('content')
<div class="py-5" style="background:#f8f9fa;min-height:70vh;">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-700 mb-0">Saved Addresses</h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAddressModal">+ Add New</button>
            </div>
            <div class="row g-3">
                @forelse($addresses as $addr)
                <div class="col-md-6">
                    <div class="bg-white rounded-4 border p-4 h-100">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="badge" style="background:var(--kkt-light);color:var(--kkt-primary);">{{ ucfirst($addr->type) }}</span>
                            @if($addr->is_default)<span class="badge bg-success" style="font-size:.7rem;">Default</span>@endif
                        </div>
                        <div class="fw-600">{{ $addr->name }}</div>
                        <div style="font-size:.84rem;color:#555;line-height:1.8;margin-top:4px;">
                            {{ $addr->address_line1 }}<br>
                            @if($addr->address_line2){{ $addr->address_line2 }}<br>@endif
                            {{ $addr->city }}, {{ $addr->state }} {{ $addr->pincode }}<br>
                            📞 {{ $addr->phone }}
                        </div>
                        <form method="POST" action="{{ route('account.addresses.destroy', $addr) }}" onsubmit="return confirm('Delete?')" class="mt-3">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm" style="border-radius:8px;font-size:.78rem;">Delete</button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-4 text-muted">No addresses saved yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
</div>

{{-- Add Address Modal --}}
<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0"><h5 class="modal-title fw-700">Add New Address</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <form method="POST" action="{{ route('account.addresses.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-600" style="font-size:.85rem;">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600" style="font-size:.85rem;">Phone</label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600" style="font-size:.85rem;">Address Line 1</label>
                            <input type="text" name="address_line1" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600" style="font-size:.85rem;">Address Line 2</label>
                            <input type="text" name="address_line2" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-600" style="font-size:.85rem;">City</label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-600" style="font-size:.85rem;">State</label>
                            <input type="text" name="state" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-600" style="font-size:.85rem;">Pincode</label>
                            <input type="text" name="pincode" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600" style="font-size:.85rem;">Type</label>
                            <select name="type" class="form-select">
                                <option value="home">Home</option>
                                <option value="work">Work</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check"><input class="form-check-input" type="checkbox" name="is_default" id="is_default" value="1"><label class="form-check-label" for="is_default" style="font-size:.84rem;">Set as Default</label></div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-4 py-2">Save Address</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Checkout')
@section('content')
<div class="breadcrumb-kkt">
    <div class="container">
        <nav><ol class="breadcrumb mb-0" style="font-size:.84rem;">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Cart</a></li>
            <li class="breadcrumb-item active">Checkout</li>
        </ol></nav>
    </div>
</div>

<section class="py-4">
<div class="container">
<form method="POST" action="{{ route('checkout.process') }}" id="checkout-form">
    @csrf
    <div class="row g-4">
        <div class="col-lg-7">
            {{-- Saved Addresses --}}
            @if($addresses->count())
            <div class="p-4 bg-white rounded-4 border mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-700 mb-0">Saved Addresses</h6>
                    <span class="text-muted small" style="font-size:0.78rem;">Click a card to select</span>
                </div>
                @foreach($addresses as $addr)
                <div class="border rounded-3 p-3 mb-2 position-relative gtb-addr-card"
                     onclick="fillAddress(this)"
                     data-address='@json($addr)'
                     style="cursor:pointer;transition:all .2s;border-color:#e9ecef;background:#ffffff;"
                     id="addr-{{ $addr->id }}">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <strong class="addr-name-text" style="font-size:.88rem;color:#0B3A63;">{{ $addr->name }}</strong>
                            @if($addr->type)
                            <span class="badge" style="background:#EAF3F9;color:#0B3A63;font-size:.7rem;">{{ ucfirst($addr->type) }}</span>
                            @endif
                            @if($addr->is_default)
                            <span class="badge bg-success" style="font-size:.65rem;">Default</span>
                            @endif
                        </div>
                        <button type="button"
                                class="btn btn-sm d-inline-flex align-items-center gap-1 py-1 px-2.5 rounded-pill edit-addr-btn"
                                style="font-size:0.75rem; font-weight:600; background:#FFFFFF; border:1px solid #CBD5E1; color:#0B3A63; transition:all 0.15s ease;"
                                onclick="event.stopPropagation(); openEditAddressModal('{{ $addr->id }}')"
                                title="Edit this address">
                            <i class="bi bi-pencil-square text-danger"></i>
                            <span>Edit</span>
                        </button>
                    </div>
                    <div class="addr-phone-text text-muted mt-1" style="font-size:.8rem;">
                        <i class="bi bi-telephone me-1 text-muted"></i><span>{{ $addr->phone }}</span>
                    </div>
                    <div class="addr-full-text" style="font-size:.82rem;color:#555;margin-top:4px;line-height:1.45;">
                        {{ $addr->full_address }}
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Shipping Details --}}
            <div class="p-4 bg-white rounded-4 border mb-4">
                <h6 class="fw-700 mb-3">Shipping Information</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-600" style="font-size:.85rem;">Full Name *</label>
                        <input type="text" name="shipping_name" id="addr_name" class="form-control @error('shipping_name') is-invalid @enderror" value="{{ old('shipping_name', Auth::user()->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-600" style="font-size:.85rem;">Phone *</label>
                        <input type="tel" name="shipping_phone" id="addr_phone" class="form-control @error('shipping_phone') is-invalid @enderror" value="{{ old('shipping_phone', Auth::user()->phone) }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-600" style="font-size:.85rem;">Address Line 1 *</label>
                        <input type="text" name="shipping_address_line1" id="addr_line1" class="form-control" value="{{ old('shipping_address_line1') }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-600" style="font-size:.85rem;">Address Line 2</label>
                        <input type="text" name="shipping_address_line2" id="addr_line2" class="form-control" value="{{ old('shipping_address_line2') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-600" style="font-size:.85rem;">City *</label>
                        <input type="text" name="shipping_city" id="addr_city" class="form-control" value="{{ old('shipping_city') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-600" style="font-size:.85rem;">State *</label>
                        <input type="text" name="shipping_state" id="addr_state" class="form-control" value="{{ old('shipping_state') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-600" style="font-size:.85rem;">Pincode *</label>
                        <input type="text" name="shipping_pincode" id="addr_pincode" class="form-control" value="{{ old('shipping_pincode') }}" required>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-1 mt-3 text-muted" style="font-size:0.8rem;">
                    <i class="bi bi-geo-alt text-primary me-1"></i>
                    <span>Delivery locations are automatically saved to your dashboard address book.</span>
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="p-4 bg-white rounded-4 border">
                <h6 class="fw-700 mb-3">Payment Method</h6>
                <div class="d-flex flex-column gap-3">
                    <label class="d-flex align-items-center gap-3 p-3 border rounded-3" style="cursor:pointer;">
                        <input type="radio" name="payment_method" value="razorpay" checked class="form-check-input mt-0">
                        <div>
                            <div class="fw-600" style="font-size:.9rem;">Online Payment</div>
                            <div style="font-size:.78rem;color:#6c757d;">Cards, UPI, Net Banking, Wallets via Razorpay</div>
                        </div>
                        <img src="https://razorpay.com/favicon.png" height="24" class="ms-auto">
                    </label>
                    <label class="d-flex align-items-center gap-3 p-3 border rounded-3" style="cursor:pointer;">
                        <input type="radio" name="payment_method" value="cod" class="form-check-input mt-0">
                        <div>
                            <div class="fw-600" style="font-size:.9rem;">Cash on Delivery</div>
                            <div style="font-size:.78rem;color:#6c757d;">Pay when you receive the order</div>
                        </div>
                     <div class="ms-auto fw-bold text-success fs-5">
                            ₹
                        </div>
                    </label>
                </div>
                <div class="mt-3">
                    <label class="form-label fw-600" style="font-size:.85rem;">Order Notes (Optional)</label>
                    <textarea name="notes" class="form-control" rows="2" placeholder="Any special instructions..."></textarea>
                </div>
            </div>
        </div>

        {{-- Order Summary --}}
        <div class="col-lg-5">
            <div class="p-4 bg-white rounded-4 border" style="position:sticky;top:130px;">
                <h6 class="fw-700 mb-3">Order Summary</h6>
                @foreach($items as $item)
                @if($item->product)
                <div class="d-flex gap-3 align-items-center mb-3">
                    <div class="position-relative">
                        <img src="{{ $item->product->thumbnail_url }}" style="width:52px;height:52px;object-fit:cover;border-radius:8px;">
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" style="background:var(--kkt-primary);font-size:.65rem;">{{ $item->quantity }}</span>
                    </div>
                    <div class="flex-grow-1">
                        <div style="font-size:.85rem;font-weight:600;">{{ Str::limit($item->product->name, 30) }}</div>
                        @if($item->productVariant)<div style="font-size:.75rem;color:#6c757d;">{{ $item->productVariant->label }}</div>@endif
                    </div>
                    <div style="font-weight:700;font-size:.9rem;">₹{{ number_format($item->line_total, 2) }}</div>
                </div>
                @endif
                @endforeach
                <hr>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted" style="font-size:.87rem;">Subtotal</span><span>₹{{ number_format($totals['subtotal'], 2) }}</span></div>
                @if($totals['discount'] > 0)
                <div class="d-flex justify-content-between mb-2"><span class="text-muted" style="font-size:.87rem;">Discount</span><span class="text-success">-₹{{ number_format($totals['discount'], 2) }}</span></div>
                @endif
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted" style="font-size:.87rem;">Shipping</span>
                    @if($totals['shippingCharge'] > 0)
                        <span style="font-weight:600;">₹{{ number_format($totals['shippingCharge'], 2) }}</span>
                    @else
                        <span class="text-success fw-bold">
                            <i class="bi bi-truck me-1"></i>Free
                        </span>
                    @endif
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-700 mb-4" style="font-size:1.1rem;">
                    <span>Total</span><span style="color:var(--kkt-primary);">₹{{ number_format($totals['total'], 2) }}</span>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 fw-700" style="border-radius:10px;font-size:1rem;">
                    <i class="bi bi-lock me-2"></i>Place Order
                </button>
                <p class="text-center mt-3" style="font-size:.75rem;color:#6c757d;"><i class="bi bi-shield-check me-1"></i>Secured by 256-bit SSL encryption</p>
            </div>
        </div>
    </div>
</form>

{{-- Edit Saved Address Modal (Outside checkout form to prevent nested form submissions) --}}
<div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-header border-bottom py-3 px-4" style="background:#F8FAFC;">
                <div class="d-flex align-items-center gap-2">
                    <div style="width:34px;height:34px;border-radius:50%;background:#EEF4F9;display:flex;align-items:center;justify-content:center;color:#0B3A63;">
                        <i class="bi bi-pencil-square text-danger"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-dark mb-0" id="editAddressModalLabel" style="font-size:1.05rem;">Edit Saved Address</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="edit-address-form" onsubmit="event.preventDefault(); saveEditedAddress();">
                    <input type="hidden" id="edit_addr_id" value="">

                    <div id="edit-addr-alert" class="alert alert-danger d-none py-2 px-3 mb-3" style="font-size:0.84rem;"></div>

                    <div class="row g-3">
                        {{-- 1. Full Name --}}
                        <div class="col-md-6">
                            <label class="form-label fw-600 mb-1" style="font-size:.84rem;">Full Name <span class="text-danger">*</span></label>
                            <input type="text" id="edit_name" class="form-control form-control-sm rounded-3" placeholder="e.g. John Doe" required>
                        </div>

                        {{-- 2. Phone --}}
                        <div class="col-md-6">
                            <label class="form-label fw-600 mb-1" style="font-size:.84rem;">Phone <span class="text-danger">*</span></label>
                            <input type="tel" id="edit_phone" class="form-control form-control-sm rounded-3" placeholder="10-digit mobile number" required>
                        </div>

                        {{-- 3. Address Line 1 --}}
                        <div class="col-12">
                            <label class="form-label fw-600 mb-1" style="font-size:.84rem;">Address Line 1 <span class="text-danger">*</span></label>
                            <input type="text" id="edit_address_line1" class="form-control form-control-sm rounded-3" placeholder="House/Flat No., Building Name, Street" required>
                        </div>

                        {{-- 4. Address Line 2 --}}
                        <div class="col-12">
                            <label class="form-label fw-600 mb-1" style="font-size:.84rem;">Address Line 2 <span class="text-muted fw-normal">(Optional)</span></label>
                            <input type="text" id="edit_address_line2" class="form-control form-control-sm rounded-3" placeholder="Area, Colony, Landmark">
                        </div>

                        {{-- 5. City --}}
                        <div class="col-md-4">
                            <label class="form-label fw-600 mb-1" style="font-size:.84rem;">City <span class="text-danger">*</span></label>
                            <input type="text" id="edit_city" class="form-control form-control-sm rounded-3" placeholder="City" required>
                        </div>

                        {{-- 6. State --}}
                        <div class="col-md-4">
                            <label class="form-label fw-600 mb-1" style="font-size:.84rem;">State <span class="text-danger">*</span></label>
                            <input type="text" id="edit_state" class="form-control form-control-sm rounded-3" placeholder="State" required>
                        </div>

                        {{-- 7. Pincode --}}
                        <div class="col-md-4">
                            <label class="form-label fw-600 mb-1" style="font-size:.84rem;">Pincode <span class="text-danger">*</span></label>
                            <input type="text" id="edit_pincode" class="form-control form-control-sm rounded-3" placeholder="6-digit pincode" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <button type="button" class="btn btn-light border px-4 rounded-3" data-bs-dismiss="modal" style="font-size:.85rem;font-weight:600;">Cancel</button>
                        <button type="submit" class="btn text-white px-4 rounded-3 d-inline-flex align-items-center gap-2" id="edit-addr-submit-btn" style="background:#0B3A63;font-size:.85rem;font-weight:600;">
                            <span class="btn-text">Save Changes</span>
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
</section>

@push('styles')
<style>
.gtb-addr-card {
    transition: all 0.2s ease;
}
.gtb-addr-card:hover {
    border-color: #CBD5E1 !important;
    box-shadow: 0 4px 12px rgba(11, 58, 99, 0.05);
}
.edit-addr-btn {
    transition: all 0.15s ease;
}
.edit-addr-btn:hover {
    background: #0B3A63 !important;
    border-color: #0B3A63 !important;
    color: #FFFFFF !important;
}
.edit-addr-btn:hover i {
    color: #FFFFFF !important;
}
</style>
@endpush

@push('scripts')
<script>
function fillAddress(target, elOpt) {
    let addr = null;
    let cardEl = null;

    if (target instanceof HTMLElement) {
        cardEl = target;
        try {
            addr = JSON.parse(cardEl.dataset.address);
        } catch (e) {
            addr = {};
        }
    } else {
        addr = target || {};
        cardEl = elOpt;
    }

    if (!cardEl && addr && addr.id) {
        cardEl = document.getElementById('addr-' + addr.id);
    }

    document.querySelectorAll('[id^="addr-"]').forEach(e => {
        e.style.borderColor = '#e9ecef';
        e.style.background = '#ffffff';
    });

    if (cardEl) {
        cardEl.style.borderColor = '#0B3A63';
        cardEl.style.background = '#F0F7FD';
    }

    if (addr && addr.name && document.getElementById('addr_name')) {
        document.getElementById('addr_name').value = addr.name;
    }
    if (addr && addr.phone && document.getElementById('addr_phone')) {
        document.getElementById('addr_phone').value = addr.phone;
    }
    if (document.getElementById('addr_line1')) {
        document.getElementById('addr_line1').value = (addr && addr.address_line1) || '';
    }
    if (document.getElementById('addr_line2')) {
        document.getElementById('addr_line2').value = (addr && addr.address_line2) || '';
    }
    if (document.getElementById('addr_city')) {
        document.getElementById('addr_city').value = (addr && addr.city) || '';
    }
    if (document.getElementById('addr_state')) {
        document.getElementById('addr_state').value = (addr && addr.state) || '';
    }
    if (document.getElementById('addr_pincode')) {
        document.getElementById('addr_pincode').value = (addr && addr.pincode) || '';
    }
}

function openEditAddressModal(addrId) {
    const card = document.getElementById('addr-' + addrId);
    if (!card) return;

    let addr = {};
    try {
        addr = JSON.parse(card.dataset.address);
    } catch(e) {
        console.error('Failed to parse address data', e);
        return;
    }

    document.getElementById('edit_addr_id').value = addr.id || '';
    document.getElementById('edit_name').value = addr.name || '';
    document.getElementById('edit_phone').value = addr.phone || '';
    document.getElementById('edit_address_line1').value = addr.address_line1 || '';
    document.getElementById('edit_address_line2').value = addr.address_line2 || '';
    document.getElementById('edit_city').value = addr.city || '';
    document.getElementById('edit_state').value = addr.state || '';
    document.getElementById('edit_pincode').value = addr.pincode || '';

    const alertEl = document.getElementById('edit-addr-alert');
    if (alertEl) {
        alertEl.classList.add('d-none');
        alertEl.innerHTML = '';
    }

    const modalEl = document.getElementById('editAddressModal');
    if (modalEl) {
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    }
}

function saveEditedAddress() {
    const addrId = document.getElementById('edit_addr_id').value;
    if (!addrId) return;

    const name = document.getElementById('edit_name').value.trim();
    const phone = document.getElementById('edit_phone').value.trim();
    const line1 = document.getElementById('edit_address_line1').value.trim();
    const line2 = document.getElementById('edit_address_line2').value.trim();
    const city = document.getElementById('edit_city').value.trim();
    const state = document.getElementById('edit_state').value.trim();
    const pincode = document.getElementById('edit_pincode').value.trim();

    const alertEl = document.getElementById('edit-addr-alert');
    const submitBtn = document.getElementById('edit-addr-submit-btn');
    const btnText = submitBtn ? submitBtn.querySelector('.btn-text') : null;
    const spinner = submitBtn ? submitBtn.querySelector('.spinner-border') : null;

    if (!name || !phone || !line1 || !city || !state || !pincode) {
        if (alertEl) {
            alertEl.classList.remove('d-none');
            alertEl.textContent = 'Please fill in all required fields marked with *.';
        }
        return;
    }

    if (submitBtn) submitBtn.disabled = true;
    if (btnText) btnText.textContent = 'Saving...';
    if (spinner) spinner.classList.remove('d-none');
    if (alertEl) alertEl.classList.add('d-none');

    $.ajax({
        url: '{{ url("/account/addresses") }}/' + addrId,
        type: 'POST',
        data: {
            _method: 'PUT',
            _token: '{{ csrf_token() }}',
            name: name,
            phone: phone,
            address_line1: line1,
            address_line2: line2,
            city: city,
            state: state,
            pincode: pincode
        },
        dataType: 'json',
        success: function(res) {
            if (res.success && res.address) {
                const card = document.getElementById('addr-' + addrId);
                if (card) {
                    card.dataset.address = JSON.stringify(res.address);

                    const nameEl = card.querySelector('.addr-name-text');
                    if (nameEl) nameEl.textContent = res.address.name;

                    const phoneEl = card.querySelector('.addr-phone-text span');
                    if (phoneEl) phoneEl.textContent = res.address.phone;

                    const fullEl = card.querySelector('.addr-full-text');
                    if (fullEl) {
                        fullEl.textContent = res.full_address || [
                            res.address.address_line1,
                            res.address.address_line2,
                            res.address.city,
                            res.address.state,
                            res.address.pincode
                        ].filter(Boolean).join(', ');
                    }

                    fillAddress(card);
                }

                const modalEl = document.getElementById('editAddressModal');
                if (modalEl) {
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                }

                if (typeof showToast === 'function') {
                    showToast('Address updated successfully!', 'success');
                }
            } else {
                if (alertEl) {
                    alertEl.classList.remove('d-none');
                    alertEl.textContent = res.message || 'Could not update address. Please try again.';
                }
            }
        },
        error: function(xhr) {
            let errorMsg = 'Failed to update address. Please check your inputs.';
            if (xhr.responseJSON) {
                if (xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                if (xhr.responseJSON.errors) {
                    errorMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                }
            }
            if (alertEl) {
                alertEl.classList.remove('d-none');
                alertEl.innerHTML = errorMsg;
            }
        },
        complete: function() {
            if (submitBtn) submitBtn.disabled = false;
            if (btnText) btnText.textContent = 'Save Changes';
            if (spinner) spinner.classList.add('d-none');
        }
    });
}
</script>
@endpush
@endsection

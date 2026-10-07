@extends('layouts.app')
@section('title', 'Complete Payment')
@section('content')
<div class="py-5 text-center">
    <div class="container">
        <div class="d-inline-block p-5 bg-white rounded-4 border" style="max-width:480px;width:100%;">
            <div style="width:64px;height:64px;background:var(--kkt-light);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.8rem;margin:0 auto 20px;">💳</div>
            <h5 class="fw-700 mb-2">Complete Your Payment</h5>
            <p class="text-muted mb-4" style="font-size:.88rem;">Order #{{ $order->order_number }} — ₹{{ number_format($order->total, 2) }}</p>
            <button id="rzp-button" class="btn btn-primary btn-lg px-5 fw-700">
                Pay ₹{{ number_format($order->total, 2) }}
            </button>
            <div class="mt-3" style="font-size:.76rem;color:#6c757d;"><i class="bi bi-lock-fill me-1"></i>Secured by Razorpay</div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    key: '{{ $rpData["key_id"] }}',
    amount: {{ $rpData["amount"] }},
    currency: '{{ $rpData["currency"] }}',
    name: '{{ setting("site_name", "Gastrowellness") }}',
    description: 'Order #{{ $order->order_number }}',
    order_id: '{{ $rpData["razorpay_order_id"] }}',

    prefill: {
        name: '{{ $order->user->name }}',
        email: '{{ $order->user->email }}',
        contact: '{{ $order->user->phone }}'
    },

    theme: {
        color: '#2E6F40'
    },

    handler: function (response) {
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("checkout.razorpay.callback") }}';

        var fields = {
            _token: '{{ csrf_token() }}',
            razorpay_payment_id: response.razorpay_payment_id,
            razorpay_order_id: response.razorpay_order_id,
            razorpay_signature: response.razorpay_signature
        };

        for (var k in fields) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = k;
            input.value = fields[k];
            form.appendChild(input);
        }

        document.body.appendChild(form);
        form.submit();
    }
};

var rzp = new Razorpay(options);

document.getElementById('rzp-button').onclick = function (e) {
    e.preventDefault();
    rzp.open();
};

window.onload = function () {
    rzp.open();
};
var rzp = new Razorpay(options);
document.getElementById('rzp-button').onclick = function(e) { rzp.open(); e.preventDefault(); };
window.onload = function() { rzp.open(); };
</script>
@endpush
@endsection

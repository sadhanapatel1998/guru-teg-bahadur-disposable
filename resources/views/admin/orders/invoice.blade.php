<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        * { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; box-sizing: border-box; }
        body { margin: 0; padding: 24px; color: #1E293B; background: #FFFFFF; }
        .header { border-bottom: 3px solid #0B3A63; padding-bottom: 18px; margin-bottom: 20px; }
        .company-name { font-size: 22px; font-weight: bold; line-height: 1.15; }
        .company-name .gtb-navy { color: #0B3A63; }
        .company-name .gtb-red { color: #D9232E; display: block; font-size: 11px; letter-spacing: 2.2px; font-weight: 700; margin-top: 3px; }
        .invoice-title { font-size: 20px; color: #0B3A63; font-weight: bold; letter-spacing: 0.8px; }
        table { width: 100%; border-collapse: collapse; }
        .items-table th { background: #0B3A63; color: #FFFFFF; padding: 9px 10px; text-align: left; font-size: 11px; font-weight: bold; letter-spacing: 0.4px; }
        .items-table td { padding: 9px 10px; border-bottom: 1px solid #E2E8F0; color: #1E293B; }
        .items-table tr:nth-child(even) td { background: #F8FAFC; }
        .totals-table td { padding: 5px 10px; color: #334155; }
        .totals-table .total-row td { font-weight: bold; font-size: 14px; border-top: 2.5px solid #0B3A63; padding-top: 10px; color: #0B3A63; }
        .info-box { border: 1px solid #E2E8F0; border-radius: 6px; padding: 12px 14px; background: #F8FAFC; }
        .info-box-title { color: #0B3A63; font-size: 11px; font-weight: bold; letter-spacing: 0.8px; margin-bottom: 8px; padding-bottom: 5px; border-bottom: 1px solid #E2E8F0; }
        .label { color: #64748B; font-size: 11px; }
    </style>
</head>
<body>
@php
    $logoPath = null;
    $siteLogo = setting('site_logo');
    if ($siteLogo && file_exists(public_path('storage/' . $siteLogo))) {
        $logoPath = public_path('storage/' . $siteLogo);
    } elseif ($siteLogo && file_exists(storage_path('app/public/' . $siteLogo))) {
        $logoPath = storage_path('app/public/' . $siteLogo);
    }
@endphp

<div class="header">
    <table>
        <tr>
            <td width="60%" style="vertical-align:top;">
                @if($logoPath)
                    <div style="margin-bottom:6px;">
                        <img src="{{ $logoPath }}" style="height:50px; max-width:220px; object-fit:contain;">
                    </div>
                @else
                    <div class="company-name">
                        <span class="gtb-navy">Guru Teg Bahadur</span>
                        <span class="gtb-red">DISPOSABLE CROCKERY</span>
                    </div>
                @endif
                <div style="color:#64748B; margin-top:5px; font-size:11px;">
                    {{ setting('site_address', '7/64 moti nagar near Ashoka elctricals') }}
                </div>
                <div style="color:#334155; margin-top:4px; font-size:11px;">
                    Phone: <strong>{{ setting('site_phone', '+91 9310099249') }}</strong> &nbsp;|&nbsp; Email: <strong>{{ setting('site_email', 'info@GTBdisposable.com') }}</strong>
                </div>
            </td>
            <td width="40%" style="text-align:right; vertical-align:top;">
                <div class="invoice-title">TAX INVOICE</div>
                <div style="margin-top:8px; line-height:1.6;">
                    <span style="color:#D9232E; font-size:13px; font-weight:bold;">#{{ $order->order_number }}</span><br>
                    <span class="label">Date: </span><strong>{{ $order->created_at->format('d M Y') }}</strong><br>
                    <span class="label">Payment: </span>
                    @if(strtolower($order->payment_status) === 'paid')
                        <strong style="color:#16A34A;">Paid</strong>
                    @else
                        <strong style="color:#D9232E;">{{ ucfirst($order->payment_status) }}</strong>
                    @endif
                </div>
            </td>
        </tr>
    </table>
</div>

<table style="margin-bottom:20px;">
    <tr>
        <td width="50%" style="padding-right:15px; vertical-align:top;">
            <div class="info-box">
                <div class="info-box-title">BILL TO</div>
                <strong style="color:#0B3A63; font-size:13px;">{{ $order->shipping_name }}</strong><br>
                <div style="color:#334155; margin-top:3px; line-height:1.45;">
                    {{ $order->shipping_address_line1 }}<br>
                    @if($order->shipping_address_line2){{ $order->shipping_address_line2 }}<br>@endif
                    {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_pincode }}<br>
                    Phone: <strong>{{ $order->shipping_phone }}</strong>
                </div>
            </div>
        </td>
        <td width="50%" style="padding-left:5px; vertical-align:top;">
            <div class="info-box">
                <div class="info-box-title">ORDER DETAILS</div>
                <table>
                    <tr><td class="label" style="padding:2px 0;">Order Number:</td><td style="padding:2px 0;"><strong style="color:#0B3A63;">{{ $order->order_number }}</strong></td></tr>
                    <tr><td class="label" style="padding:2px 0;">Order Date:</td><td style="padding:2px 0;"><strong>{{ $order->created_at->format('d M Y') }}</strong></td></tr>
                    <tr><td class="label" style="padding:2px 0;">Payment Method:</td><td style="padding:2px 0;"><strong>{{ strtoupper($order->payment_method) }}</strong></td></tr>
                    <tr><td class="label" style="padding:2px 0;">Order Status:</td><td style="padding:2px 0;"><strong style="color:#0B3A63;">{{ ucfirst($order->status) }}</strong></td></tr>
                </table>
            </div>
        </td>
    </tr>
</table>

<table class="items-table" style="margin-bottom:20px;">
    <thead>
        <tr>
            <th style="width:5%;">#</th>
            <th style="width:38%;">Product</th>
            <th style="width:17%;">SKU</th>
            <th style="width:12%;">Variant</th>
            <th style="text-align:right; width:13%;">Price</th>
            <th style="text-align:center; width:5%;">Qty</th>
            <th style="text-align:right; width:10%;">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->items as $i => $item)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td><strong style="color:#0B3A63;">{{ $item->product_name }}</strong></td>
            <td>{{ $item->product_sku }}</td>
            <td>{{ $item->variant_label ?? '—' }}</td>
            <td style="text-align:right;">₹{{ number_format($item->price, 2) }}</td>
            <td style="text-align:center;">{{ $item->quantity }}</td>
            <td style="text-align:right;"><strong style="color:#0B3A63;">₹{{ number_format($item->total, 2) }}</strong></td>
        </tr>
        @endforeach
    </tbody>
</table>

<table style="margin-left:auto; width:280px;" class="totals-table">
    <tr><td>Subtotal</td><td style="text-align:right;">₹{{ number_format($order->subtotal, 2) }}</td></tr>
    @if($order->discount_amount > 0)
    <tr><td>Discount {{ $order->coupon_code ? '(' . $order->coupon_code . ')' : '' }}</td>
        <td style="text-align:right; color:#16A34A; font-weight:bold;">-₹{{ number_format($order->discount_amount, 2) }}</td></tr>
    @endif
    <tr><td>Shipping</td><td style="text-align:right;">₹{{ number_format($order->shipping_charge, 2) }}</td></tr>
    @if($order->tax_amount > 0)
    <tr><td>Tax</td><td style="text-align:right;">₹{{ number_format($order->tax_amount, 2) }}</td></tr>
    @endif
    <tr class="total-row">
        <td>TOTAL</td>
        <td style="text-align:right; color:#D9232E; font-size:16px; font-weight:bold;">
            ₹{{ number_format($order->total, 2) }}
        </td>
    </tr>
</table>

<div style="margin-top:40px; border-top:1px solid #E2E8F0; padding-top:16px; color:#64748B; text-align:center; font-size:11px;">
    Thank you for shopping with <strong style="color:#0B3A63;">Guru Teg Bahadur Disposable</strong>!
    @if(setting('site_email'))
        <br><span style="color:#64748B;">For support, contact: <strong style="color:#D9232E;">{{ setting('site_email') }}</strong></span>
    @endif
</div>
</body>
</html>

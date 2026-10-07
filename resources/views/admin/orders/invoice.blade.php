<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        * { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }
        body { margin: 0; padding: 20px; color: #333; }
        .header { border-bottom: 3px solid #0F766E; padding-bottom: 20px; margin-bottom: 20px; }
        .company-name { font-size: 24px; font-weight: bold; color: #0F766E; }
        .invoice-title { font-size: 18px; color: #253D2C; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; }
        .items-table th { background: #0F766E; color: white; padding: 8px 10px; text-align: left; }
        .items-table td { padding: 8px 10px; border-bottom: 1px solid #e9ecef; }
        .items-table tr:nth-child(even) td { background: #f8f9fa; }
        .totals-table td { padding: 5px 10px; }
        .totals-table .total-row td { font-weight: bold; font-size: 14px; border-top: 2px solid #0F766E; padding-top: 8px; }
        .info-box { border: 1px solid #e9ecef; border-radius: 6px; padding: 12px; }
        .label { color: #6c757d; font-size: 11px; }
    </style>
</head>
<body>
<div class="header">
    <table>
        <tr>
            <td width="60%">
                <div class="company-name">Gastro Wellness</div>
                <div style="color:#6c757d;margin-top:4px;">{{ setting('site_address', 'Your Business Address') }}</div>
                <div>📞 {{ setting('site_phone') }} | ✉ {{ setting('site_email') }}</div>
            </td>
            <td width="40%" style="text-align:right;">
                <div class="invoice-title">TAX INVOICE</div>
                <div style="margin-top:8px;">
                    <strong>#{{ $order->order_number }}</strong><br>
                    <span class="label">Date: </span>{{ $order->created_at->format('d M Y') }}<br>
                    <span class="label">Payment: </span><strong>{{ ucfirst($order->payment_status) }}</strong>
                </div>
            </td>
        </tr>
    </table>
</div>

<table style="margin-bottom:20px;">
    <tr>
        <td width="50%" style="padding-right:20px;">
            <div class="info-box">
                <div class="label" style="margin-bottom:6px;font-weight:bold;">BILL TO</div>
                <strong>{{ $order->shipping_name }}</strong><br>
                {{ $order->shipping_address_line1 }}<br>
                @if($order->shipping_address_line2){{ $order->shipping_address_line2 }}<br>@endif
                {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_pincode }}<br>
                📞 {{ $order->shipping_phone }}
            </div>
        </td>
        <td width="50%">
            <div class="info-box">
                <div class="label" style="margin-bottom:6px;font-weight:bold;">ORDER DETAILS</div>
                <table>
                    <tr><td class="label">Order Number:</td><td><strong>{{ $order->order_number }}</strong></td></tr>
                    <tr><td class="label">Order Date:</td><td>{{ $order->created_at->format('d M Y') }}</td></tr>
                    <tr><td class="label">Payment Method:</td><td>{{ strtoupper($order->payment_method) }}</td></tr>
                    <tr><td class="label">Order Status:</td><td>{{ ucfirst($order->status) }}</td></tr>
                </table>
            </div>
        </td>
    </tr>
</table>

<table class="items-table" style="margin-bottom:20px;">
    <thead>
        <tr>
            <th>#</th>
            <th>Product</th>
            <th>SKU</th>
            <th>Variant</th>
            <th style="text-align:right;">Price</th>
            <th style="text-align:center;">Qty</th>
            <th style="text-align:right;">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->items as $i => $item)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $item->product_name }}</td>
            <td>{{ $item->product_sku }}</td>
            <td>{{ $item->variant_label ?? '—' }}</td>
            <td style="text-align:right;">₹{{ number_format($item->price, 2) }}</td>
            <td style="text-align:center;">{{ $item->quantity }}</td>
            <td style="text-align:right;">₹{{ number_format($item->total, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<table style="margin-left:auto;width:260px;" class="totals-table">
    <tr><td>Subtotal</td><td style="text-align:right;">₹{{ number_format($order->subtotal, 2) }}</td></tr>
    @if($order->discount_amount > 0)
    <tr><td>Discount {{ $order->coupon_code ? '(' . $order->coupon_code . ')' : '' }}</td>
        <td style="text-align:right;color:green;">-₹{{ number_format($order->discount_amount, 2) }}</td></tr>
    @endif
    <tr><td>Shipping</td><td style="text-align:right;">₹{{ number_format($order->shipping_charge, 2) }}</td></tr>
    @if($order->tax_amount > 0)
    <tr><td>Tax</td><td style="text-align:right;">₹{{ number_format($order->tax_amount, 2) }}</td></tr>
    @endif
    <tr class="total-row">
        <td>TOTAL</td><td style="text-align:right;color:#000;font-size:15px;">₹{{ number_format($order->total, 2) }}</td>
    </tr>
</table>

<div style="margin-top:40px;border-top:1px solid #e9ecef;padding-top:16px;color:#6c757d;text-align:center;font-size:11px;">
    Thank you for shopping with Gastro Wellness For support: {{ setting('site_email') }}
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Status Update</title>
<style>
  body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; color: #333; }
  .wrapper { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
  .header { background: #0F766E; padding: 28px 40px; text-align: center; }
  .header h1 { color: #fff; margin: 0; font-size: 22px; }
  .body { padding: 32px 40px; }
  .body p { margin: 0 0 16px; line-height: 1.6; }
  .status-box { text-align: center; margin: 24px 0; }
  .status-badge { display: inline-block; padding: 12px 32px; border-radius: 50px; font-size: 18px; font-weight: 700; letter-spacing: 0.5px; }
  .status-pending     { background: #fff3cd; color: #856404; }
  .status-confirmed   { background: #d1ecf1; color: #0c5460; }
  .status-processing  { background: #cce5ff; color: #004085; }
  .status-shipped     { background: #d4edda; color: #155724; }
  .status-delivered   { background: #CFFFDC; color: #2E6F40; }
  .status-cancelled   { background: #f8d7da; color: #721c24; }
  .status-returned    { background: #e2e3e5; color: #383d41; }
  .order-meta { background: #f8fdf9; border: 1px solid #CFFFDC; border-radius: 6px; padding: 14px 18px; margin: 20px 0; font-size: 14px; }
  .order-meta table { width: 100%; border-collapse: collapse; }
  .order-meta td { padding: 3px 0; }
  .order-meta td:last-child { text-align: right; font-weight: 600; }
  .btn { display: inline-block; background: #B51736; color: #fff !important; padding: 12px 28px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px; }
  .footer { background: #f8fdf9; padding: 18px 40px; text-align: center; font-size: 12px; color: #888; border-top: 1px solid #CFFFDC; }
</style>
</head>
<body>
@php
  $statusMap = [
    'pending'    => ['icon' => '🕐', 'label' => 'Pending'],
    'confirmed'  => ['icon' => '✅', 'label' => 'Confirmed'],
    'processing' => ['icon' => '⚙️',  'label' => 'Processing'],
    'shipped'    => ['icon' => '🚚', 'label' => 'Shipped'],
    'delivered'  => ['icon' => '📦', 'label' => 'Delivered'],
    'cancelled'  => ['icon' => '❌', 'label' => 'Cancelled'],
    'returned'   => ['icon' => '↩️', 'label' => 'Returned'],
  ];
  $current = $statusMap[$order->status] ?? ['icon' => '📋', 'label' => ucfirst($order->status)];
@endphp
<div class="wrapper">
  <div class="header">
    <h1>Order Status Update</h1>
  </div>
  <div class="body">
    <p>Hi <strong>{{ $order->user->name ?? $order->shipping_name }}</strong>,</p>
    <p>Your order <strong>#{{ $order->order_number }}</strong> has been updated.</p>

    <div class="status-box">
      <div class="status-badge status-{{ $order->status }}">
        {{ $current['icon'] }} {{ $current['label'] }}
      </div>
    </div>

    @if($order->status === 'shipped' && $order->tracking_number)
    <p style="text-align:center">
      <strong>Tracking Number:</strong> {{ $order->tracking_number }}
      @if($order->tracking_url)
        — <a href="{{ $order->tracking_url }}">Track Shipment</a>
      @endif
    </p>
    @endif

    @if($order->status === 'delivered')
    <p>Your order has been delivered! We hope you love your purchase. Please leave a review to help other customers.</p>
    @elseif($order->status === 'cancelled')
    <p>Your order has been cancelled. If a payment was made, a refund will be initiated within 5–7 business days.</p>
    @endif

    <div class="order-meta">
      <table>
        <tr><td>Order Number</td><td>#{{ $order->order_number }}</td></tr>
        <tr><td>Order Date</td><td>{{ $order->created_at->format('d M Y') }}</td></tr>
        <tr><td>Total Amount</td><td>₹{{ number_format($order->total, 2) }}</td></tr>
      </table>
    </div>

    <p style="text-align:center; margin-top:24px;">
      <a href="{{ url('/account/orders/' . $order->id) }}" class="btn">View Order Details</a>
    </p>
  </div>
  <div class="footer">
    <p>© {{ date('Y') }} Gastro Wellness. All rights reserved.</p>
  </div>
</div>
</body>
</html>

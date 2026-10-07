<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Confirmed</title>
<style>
  body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; color: #333; }
  .wrapper { max-width: 620px; margin: 30px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
  .header { background: #0F766E; padding: 32px 40px; text-align: center; }
  .header h1 { color: #fff; margin: 0; font-size: 24px; }
  .header p { color: #CFFFDC; margin: 6px 0 0; font-size: 14px; }
  .body { padding: 32px 40px; }
  .body p { margin: 0 0 16px; line-height: 1.6; }
  .order-meta { background: #f8fdf9; border: 1px solid #CFFFDC; border-radius: 6px; padding: 16px 20px; margin-bottom: 24px; }
  .order-meta table { width: 100%; border-collapse: collapse; font-size: 14px; }
  .order-meta td { padding: 4px 0; }
  .order-meta td:last-child { text-align: right; font-weight: 600; }
  .items-table { width: 100%; border-collapse: collapse; font-size: 14px; margin-bottom: 24px; }
  .items-table th { background: #0F766E; color: #fff; padding: 10px 12px; text-align: left; }
  .items-table td { padding: 10px 12px; border-bottom: 1px solid #eee; vertical-align: top; }
  .totals { text-align: right; font-size: 14px; margin-bottom: 24px; }
  .totals table { margin-left: auto; }
  .totals td { padding: 4px 0 4px 24px; }
  .totals .grand-total td { font-size: 16px; font-weight: 700; color: #0F766E; border-top: 2px solid #0F766E; padding-top: 8px; }
  .btn { display: inline-block; background: #0F766E; color: #fff !important; padding: 12px 28px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px; }
  .footer { background: #f8fdf9; padding: 20px 40px; text-align: center; font-size: 12px; color: #888; border-top: 1px solid #CFFFDC; }
</style>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <h1> Order Confirmed!</h1>
    <p>Thank you for shopping with Gastro Wellness</p>
  </div>
  <div class="body">
    <p>Hi <strong>{{ $order->user->name ?? $order->shipping_name }}</strong>,</p>
    <p>Your order has been placed successfully and is being processed. Here's a summary:</p>

    <div class="order-meta">
      <table>
        <tr><td>Order Number</td><td>#{{ $order->order_number }}</td></tr>
        <tr><td>Order Date</td><td>{{ $order->created_at->format('d M Y, h:i A') }}</td></tr>
        <tr><td>Payment Method</td><td>{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</td></tr>
        <tr><td>Payment Status</td><td>{{ ucfirst($order->payment_status) }}</td></tr>
      </table>
    </div>

    <table class="items-table">
      <thead>
        <tr>
          <th>Product</th>
          <th>Qty</th>
          <th style="text-align:right">Price</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->items as $item)
        <tr>
          <td>
            {{ $item->product_name }}
            @if($item->variant_label)
              <br><small style="color:#888">{{ $item->variant_label }}</small>
            @endif
          </td>
          <td>{{ $item->quantity }}</td>
          <td style="text-align:right">₹{{ number_format($item->total, 2) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="totals">
      <table>
        <tr><td>Subtotal</td><td>₹{{ number_format($order->subtotal, 2) }}</td></tr>
        @if($order->discount_amount > 0)
        <tr><td>Discount</td><td>-₹{{ number_format($order->discount_amount, 2) }}</td></tr>
        @endif
        <tr><td>Shipping</td><td>{{ $order->shipping_charge > 0 ? '₹'.number_format($order->shipping_charge,2) : 'Free' }}</td></tr>
        <tr class="grand-total"><td>Total</td><td>₹{{ number_format($order->total, 2) }}</td></tr>
      </table>
    </div>

    <p><strong>Shipping to:</strong><br>
      {{ $order->shipping_name }}, {{ $order->shipping_phone }}<br>
      {{ $order->shipping_address_line1 }}@if($order->shipping_address_line2), {{ $order->shipping_address_line2 }}@endif<br>
      {{ $order->shipping_city }}, {{ $order->shipping_state }} – {{ $order->shipping_pincode }}
    </p>

    <p style="text-align:center; margin-top:28px;">
      {{-- <a href="{{ url('/account/orders/' . $order->id) }}" class="btn">Track Your Order</a> --}}
    </p>
  </div>
  <div class="footer">
    <p>© {{ date('Y') }} Gastro Wellness. All rights reserved.</p>
    <p>If you have any questions, reply to this email or contact our support.</p>
  </div>
</div>
</body>
</html>

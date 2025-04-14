<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Receipt</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }
        .item-row {
            margin: 3px 0;
        }
        .total-section {
            margin-top: 5px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3 style="margin: 0;">{{ config('app.name') }}</h3>
        <p style="margin: 2px 0;">Order #{{ $order->order_number }}</p>
        <p style="margin: 2px 0;">Date: {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
    </div>

    <div class="divider"></div>

    @if($order->customer)
    <div>
        <p style="margin: 2px 0;">Customer: {{ $order->customer->name }}</p>
    </div>
    <div class="divider"></div>
    @endif

    <div>
        <table style="width: 100%;">
            <tr>
                <th style="text-align: left;">Item</th>
                <th style="text-align: right;">Qty</th>
                <th style="text-align: right;">Price</th>
                <th style="text-align: right;">Total</th>
            </tr>
            @foreach($order->orderItems as $item)
            <tr>
                <td>{{ $item->product_json['name'] }}</td>
                <td style="text-align: right;">{{ $item->quantity }}</td>
                <td style="text-align: right;">{{ number_format($item->product_json['selling_price'], 2) }}</td>
                <td style="text-align: right;">{{ number_format($item->quantity * $item->product_json['selling_price'], 2) }}</td>
            </tr>
            @endforeach
        </table>
    </div>

    <div class="divider"></div>

    <div class="total-section">
        <table style="width: 100%;">
            <tr>
                <td>Subtotal:</td>
                <td class="text-right">{{ number_format($order->sub_total, 2) }}</td>
            </tr>
            <tr>
                <td>Tax:</td>
                <td class="text-right">{{ number_format($order->tax_total, 2) }}</td>
            </tr>
            <tr>
                <td>Discount:</td>
                <td class="text-right">{{ number_format($order->discount_total, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Total:</strong></td>
                <td class="text-right"><strong>{{ number_format($order->total, 2) }}</strong></td>
            </tr>
            <tr>
                <td>Paid:</td>
                <td class="text-right">{{ number_format($order->paid, 2) }}</td>
            </tr>
            <tr>
                <td>Due:</td>
                <td class="text-right">{{ number_format($order->due, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="divider"></div>

    <div class="text-center">
        <p style="margin: 5px 0;">Thank you for your business!</p>
    </div>
</body>
</html>
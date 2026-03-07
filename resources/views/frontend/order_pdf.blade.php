<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Invoice #{{ $order->order_id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 13px;
            color: #333;
        }
        .page-wrapper {
            padding: 30px;
        }
        /* Header */
        .invoice-header {
            display: block;
            width: 100%;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
            overflow: hidden;
        }
        .company-name {
            font-size: 22px;
            font-weight: bold;
            float: left;
            color: #222;
        }
        .invoice-label {
            float: right;
            text-align: right;
        }
        .invoice-label h2 {
            font-size: 20px;
            color: #555;
            font-weight: normal;
        }
        .invoice-label p {
            font-size: 12px;
            color: #777;
        }
        .clearfix::after { content: ''; display: table; clear: both; }

        /* Info Row */
        .info-row {
            width: 100%;
            margin-bottom: 20px;
            overflow: hidden;
        }
        .info-block {
            float: left;
            width: 50%;
            padding-right: 20px;
        }
        .info-block h4 {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 8px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .info-block p {
            font-size: 12px;
            line-height: 1.8;
            color: #444;
        }
        .info-block p strong {
            color: #222;
        }

        /* Status badges */
        .badge-paid   { color: #2e7d32; font-weight: bold; }
        .badge-unpaid { color: #c62828; font-weight: bold; }

        /* Summary Section */
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 6px;
            color: #333;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table thead tr {
            background-color: #f0f0f0;
        }
        table thead th {
            font-size: 12px;
            font-weight: bold;
            padding: 9px 10px;
            text-align: left;
            border: 1px solid #ddd;
            color: #555;
        }
        table tbody td {
            padding: 8px 10px;
            font-size: 12px;
            border: 1px solid #eee;
            color: #444;
            vertical-align: middle;
        }
        .text-right  { text-align: right; }
        .text-center { text-align: center; }

        /* Totals */
        .totals-table {
            width: 50%;
            float: right;
            margin-top: 10px;
        }
        .totals-table td {
            padding: 7px 10px;
            font-size: 13px;
            border: none;
        }
        .totals-table .label-col {
            color: #666;
            text-align: left;
        }
        .totals-table .value-col {
            text-align: right;
            font-weight: bold;
            color: #333;
        }
        .totals-table tr.grand-total td {
            font-size: 15px;
            font-weight: bold;
            color: #111;
            border-top: 2px solid #333;
            padding-top: 10px;
        }

        /* Footer */
        .invoice-footer {
            margin-top: 50px;
            border-top: 1px solid #eee;
            padding-top: 15px;
            font-size: 11px;
            color: #aaa;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="page-wrapper">

    {{-- Header --}}
    <div class="invoice-header clearfix">
        <div class="company-name">You Leggings</div>
        <div class="invoice-label">
            <h2>INVOICE</h2>
            <p>#{{ $order->order_id }}</p>
            <p>Date: {{ date('d M Y', strtotime($order->created_at)) }}</p>
        </div>
    </div>

    {{-- Order & Address Info --}}
    <div class="info-row clearfix">

        {{-- Order Details --}}
        <div class="info-block">
            <h4>Order Details</h4>
            <p>
                <strong>Order ID:</strong> {{ $order->order_id }}<br>
                <strong>Date:</strong> {{ date('d M Y', strtotime($order->created_at)) }}<br>
                <strong>Payment:</strong>
                @if($order->payment_status == 'paid')
                    <span class="badge-paid">Paid</span>
                @else
                    <span class="badge-unpaid">Unpaid</span>
                @endif
                <br>
                <strong>Method:</strong> {{ $order->payment_id ?? 'N/A' }}<br>
                <strong>Status:</strong>
                @if($order->status == 'Received')
                    Order Confirmed
                @elseif($order->status == 'Processing')
                    Unfulfilled Orders
                @elseif($order->status == 'Delivered')
                    Dispatched Orders
                @else
                    {{ $order->status }}
                @endif
            </p>
        </div>

        {{-- Billing Address --}}
        <div class="info-block">
            <h4>Billing Address</h4>
            @if(isset($billing_address) && $billing_address)
                <p>
                    <strong>{{ $billing_address->first_name }} {{ $billing_address->last_name }}</strong><br>
                    {{ $billing_address->address }}<br>
                    {{ $billing_address->city }},
                    @if(is_object($state) && $state->state) {{ $state->state }}, @endif
                    {{ $billing_address->pincode }}<br>
                    Phone: {{ $billing_address->phone_number }}
                </p>
            @else
                <p>No billing address available.</p>
            @endif
        </div>

    </div>

    @if(isset($shipping_address) && $shipping_address)
    <div class="info-row clearfix">
        <div class="info-block" style="width:100%;">
            <h4>Shipping Address</h4>
            <p>
                <strong>{{ $shipping_address->sfirst_name ?? '' }} {{ $shipping_address->slast_name ?? '' }}</strong><br>
                {{ $shipping_address->saddress ?? '' }}<br>
                {{ $shipping_address->scity ?? '' }}
                @if($shipping_address->spincode ?? false), {{ $shipping_address->spincode }} @endif<br>
                @if($shipping_address->sphone_number ?? false) Phone: {{ $shipping_address->sphone_number }} @endif
            </p>
        </div>
    </div>
    @endif

    {{-- Product Table --}}
    <div class="section-title">Order Summary</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th class="text-center">Variant</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Unit Price (₹)</th>
                <th class="text-right">Total (₹)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->order_product->name ?? 'Product' }}</td>
                <td class="text-center">{{ $item->option ?? '—' }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-center">{{ number_format($item->amount, 2) }}</td>
                <td class="text-right">{{ number_format($item->amount * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Totals --}}
    <div class="clearfix">
        <table class="totals-table">
            <tr>
                <td class="label-col">Subtotal</td>
                <td class="value-col">&#8377;{{ number_format($order->sub_total, 2) }}</td>
            </tr>
            @if($order->tax_rate)
            <tr>
                <td class="label-col">Tax (GST)</td>
                <td class="value-col">&#8377;{{ number_format($order->tax_rate, 2) }}</td>
            </tr>
            @endif
            <tr>
                <td class="label-col">Shipping</td>
                <td class="value-col">&#8377;{{ number_format($delivery_charge, 2) }}</td>
            </tr>
            @if($order->discound_amount)
            <tr>
                <td class="label-col">Discount</td>
                <td class="value-col">- &#8377;{{ number_format($order->discound_amount, 2) }}</td>
            </tr>
            @endif
            <tr class="grand-total">
                <td class="label-col">Grand Total</td>
                <td class="value-col">
                    @php
                        // Use the stored total if it has a value, otherwise calculate
                        if ($order->total > 0) {
                            $grand_total = $order->total;
                        } else {
                            $items_total = 0;
                            foreach ($data as $item) {
                                $items_total += ($item->amount * $item->quantity);
                            }
                            $grand_total = $items_total + $delivery_charge - ($order->discound_amount ?? 0);
                        }
                    @endphp
                    &#8377;{{ number_format($grand_total, 2) }}
                </td>
            </tr>
        </table>
    </div>

    {{-- Footer --}}
    <div class="invoice-footer">
        Thank you for shopping with You Leggings! For any queries, contact us at youleggings@gmail.com
    </div>

</div>
</body>
</html>

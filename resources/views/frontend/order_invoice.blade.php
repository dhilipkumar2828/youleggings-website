<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; font-family: 'Inter', sans-serif; color: #333; padding: 40px 0; }
        .invoice-card { background: #fff; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); padding: 40px; max-width: 900px; margin: 0 auto; }
        .invoice-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; border-bottom: 2px solid #f8f9fa; padding-bottom: 30px; }
        .logo { max-width: 180px; }
        .invoice-title { font-size: 32px; font-weight: 800; color: #ec407a; margin: 0; }
        .details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 40px; }
        .address-box h5 { font-size: 14px; text-transform: uppercase; letter-spacing: 1px; color: #999; margin-bottom: 15px; }
        .address-box p { font-size: 15px; line-height: 1.6; margin: 0; }
        .table thead { background: #fdf2f5; }
        .table thead th { border: none; color: #ec407a; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; padding: 15px; }
        .table tbody td { padding: 15px; vertical-align: middle; border-bottom: 1px solid #f8f9fa; }
        .total-section { margin-top: 30px; display: flex; justify-content: flex-end; }
        .total-table { width: 300px; }
        .total-table td { padding: 8px 0; }
        .grand-total { font-size: 20px; font-weight: 800; color: #ec407a; border-top: 2px solid #fdf2f5; padding-top: 15px !important; }
        .footer { margin-top: 50px; text-align: center; color: #999; font-size: 13px; }
        @media print {
            body { padding: 0; background: #fff; }
            .invoice-card { box-shadow: none; border: none; max-width: 100%; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="text-center mb-4 no-print">
            <button onclick="window.print()" class="btn btn-dark rounded-pill px-4 me-2">Print Invoice</button>
            <button onclick="generatePDF()" class="btn btn-primary rounded-pill px-4" style="background:#ec407a; border:none;">Download PDF</button>
        </div>

        <div class="invoice-card" id="invoice">
            <div class="invoice-header">
                <div>
                    <img src="{{ asset('frontend/images/logo.png') }}" alt="You Leggings" class="logo mb-3">
                    <p class="mb-0"><strong>You Leggings</strong></p>
                    <p class="text-muted small">GSTN: 33AWPPJ9059B2ZD</p>
                </div>
                <div class="text-end">
                    <h1 class="invoice-title">INVOICE</h1>
                    <p class="mb-0">Order #{{ $order->order_id }}</p>
                    <p class="text-muted small">Date: {{ $order->created_at->format('M d, Y') }}</p>
                    <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill px-3 mt-2">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
            </div>

            <div class="details-grid">
                <div class="address-box">
                    <h5>Billing & Shipping</h5>
                    <p><strong>{{ $user->name }}</strong></p>
                    <p>{{ $user->address }}</p>
                    <p>{{ $user->city }}, {{ $user->state }} - {{ $user->postcode }}</p>
                    <p>India</p>
                    <p>Phone: {{ $user->phone }}</p>
                </div>
                <div class="address-box text-end">
                    <h5>Payment Method</h5>
                    <p>{{ strtoupper($order->payment_type) }}</p>
                    <p class="text-muted small">Transaction ID: {{ $order->payment_id ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Item Description</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                        <tr>
                            <td>
                                <strong>{{ $product_name[$key] }}</strong>
                                @php $option = json_decode($item->option, true); @endphp
                                @if(isset($option['variant']))
                                    <br><small class="text-muted">Variant: {{ $option['variant'] }}</small>
                                @endif
                            </td>
                            <td class="text-center">₹{{ number_format($item->amount, 2) }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">₹{{ number_format($item->amount * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="total-section">
                <table class="total-table">
                    <tr>
                        <td class="text-muted">Subtotal</td>
                        <td class="text-end">₹{{ number_format($order->sub_total, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Shipping</td>
                        <td class="text-end">₹{{ number_format($delivery_charge, 2) }}</td>
                    </tr>
                    @if($order->discound_amount > 0)
                    <tr>
                        <td class="text-muted">Discount</td>
                        <td class="text-end text-success">-₹{{ number_format($order->discound_amount, 2) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="grand-total">Total Amount</td>
                        <td class="text-end grand-total">₹{{ number_format($order->total, 2) }}</td>
                    </tr>
                </table>
            </div>

            <div class="footer">
                <p>Thank you for shopping with You Leggings!</p>
                <p class="mb-0 small">This is a computer generated invoice and does not require a signature.</p>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function generatePDF() {
            const element = document.getElementById('invoice');
            const opt = {
                margin:       [10, 10],
                filename:     'Invoice-{{ $order->order_id }}.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #ec407a;
            --secondary: #fce4ec;
            --dark: #2d3436;
            --text-muted: #888;
            --bg: #fdfbfb;
        }
        body { background: var(--bg); font-family: 'Outfit', sans-serif; color: var(--dark); padding: 50px 0; }
        
        .invoice-container { max-width: 850px; margin: 0 auto; }
        
        .invoice-card { 
            background: #fff; 
            border-radius: 30px; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.06); 
            padding: 60px; 
            position: relative;
            overflow: hidden;
            border: 1px solid #f0f0f0;
        }
        .invoice-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(90deg, var(--primary), #f06292);
        }

        .invoice-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 50px; }
        .logo { max-width: 160px; }
        .invoice-title-group { text-align: right; }
        .invoice-label { 
            font-family: 'Playfair Display', serif; 
            font-size: 42px; 
            font-weight: 900; 
            color: var(--primary); 
            line-height: 1;
            margin-bottom: 5px;
        }
        .order-ref { font-size: 14px; font-weight: 600; color: #999; letter-spacing: 1px; }

        .details-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; margin-bottom: 50px; }
        .info-box h5 { 
            font-size: 11px; 
            text-transform: uppercase; 
            letter-spacing: 1.5px; 
            color: var(--primary); 
            font-weight: 800;
            margin-bottom: 15px; 
            opacity: 0.7;
        }
        .info-box p { font-size: 14px; line-height: 1.6; margin-bottom: 0; font-weight: 500; }
        .info-box strong { font-weight: 700; color: #000; display: block; margin-bottom: 4px; font-size: 15px; }

        .status-section {
            background: #fdfdfd;
            border: 1px solid #f8f8f8;
            border-radius: 16px;
            padding: 20px 30px;
            margin-bottom: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .status-item { display: flex; align-items: center; gap: 12px; }
        .status-dot { width: 8px; height: 8px; border-radius: 50%; }
        .status-text { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }

        .item-table { width: 100%; margin-bottom: 40px; border-collapse: separate; border-spacing: 0 10px; }
        .item-table th { 
            padding: 15px 20px; 
            font-size: 11px; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            color: #999; 
            border-bottom: 2px solid #f8f8f8;
            font-weight: 800;
        }
        .item-table td { padding: 20px; background: #fff; border-bottom: 1px solid #f8f8f8; }
        .item-desc { display: flex; flex-direction: column; }
        .item-name { font-weight: 700; color: #333; font-size: 15px; }
        .item-variant { font-size: 12px; color: #999; margin-top: 2px; }

        .summary-wrapper { display: flex; justify-content: flex-end; }
        .summary-table { width: 320px; }
        .summary-table tr td { padding: 10px 0; font-size: 14px; }
        .summary-label { color: #888; font-weight: 500; }
        .summary-value { text-align: right; font-weight: 700; color: #333; }
        .grand-total-row td { 
            padding-top: 25px !important; 
            border-top: 2px solid #f8f8f8;
            font-size: 24px !important;
            font-weight: 800 !important;
            color: var(--primary) !important;
        }

        .footer { 
            margin-top: 60px; 
            padding-top: 30px; 
            border-top: 1px dashed #eee; 
            text-align: center;
        }
        .footer p { font-size: 13px; color: #999; margin-bottom: 5px; }
        .footer .brand { font-weight: 700; color: var(--primary); }

        .btn-group-custom { margin-bottom: 30px; display: flex; gap: 10px; justify-content: center; }
        .btn-custom { 
            padding: 12px 30px; 
            border-radius: 50px; 
            font-weight: 700; 
            font-size: 14px; 
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            border: none;
        }
        .btn-dark { background: #2d3436; color: #fff; }
        .btn-primary-custom { background: var(--primary); color: #fff; }
        .btn-custom:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); color: #fff; }

        @media print {
            body { padding: 0; background: #fff; }
            .invoice-card { box-shadow: none; border: none; padding: 0; }
            .btn-group-custom { display: none; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="invoice-container">
        
        <div class="btn-group-custom no-print">
            <a href="javascript:window.print()" class="btn-custom btn-dark">
                <i class="fas fa-print"></i> Print Invoice
            </a>
            <button onclick="generatePDF()" class="btn-custom btn-primary-custom">
                <i class="fas fa-download"></i> Download PDF
            </button>
        </div>

        <div class="invoice-card" id="invoice">
            
            <div class="invoice-header">
                <img src="{{ asset('frontend/images/logo.png') }}" alt="You Leggings" class="logo">
                <div class="invoice-title-group">
                    <h1 class="invoice-label">Invoice</h1>
                    <span class="order-ref">ORDER #{{ $order->order_id }}</span>
                </div>
            </div>

            <div class="status-section">
                @php
                    $oStatus = trim($order->status);
                    if(empty($oStatus)) $oStatus = 'Pending';
                    $oStatusColor = match(strtolower($oStatus)) {
                        'pending'   => '#f57f17',
                        'confirmed', 'processing' => '#1565c0',
                        'shipped'   => '#6a1b9a',
                        'delivered' => '#2e7d32',
                        'cancelled' => '#c62828',
                        default     => '#999',
                    };
                @endphp
                <div class="status-item">
                    <div class="status-dot" style="background: {{ $oStatusColor }};"></div>
                    <span class="status-text" style="color: {{ $oStatusColor }};">ORDER: {{ $oStatus }}</span>
                </div>
                
                @php
                    $pStatus = trim($order->payment_status);
                    if(empty($pStatus)) $pStatus = 'Pending';
                    $pStatusColor = (strtolower($pStatus) == 'paid' || strtolower($pStatus) == 'completed') ? '#2e7d32' : '#f57f17';
                @endphp
                <div class="status-item">
                    <div class="status-dot" style="background: {{ $pStatusColor }};"></div>
                    <span class="status-text" style="color: {{ $pStatusColor }};">PAYMENT: {{ $pStatus }}</span>
                </div>
                
                <div class="status-item">
                    <span class="status-text" style="color: #999; font-weight: 500;">
                        <i class="far fa-calendar-alt"></i> {{ $order->created_at->format('M d, Y') }}
                    </span>
                </div>
            </div>

            <div class="details-row">
                <div class="info-box">
                    <h5>Ship To</h5>
                    <strong>{{ $user->name }}</strong>
                    <p>{{ $user->address }}<br>
                    {{ $user->city }}, {{ $user->state }} - {{ $user->postcode }}<br>
                    India<br>
                    <i class="fas fa-phone-alt"></i> {{ $user->phone }}</p>
                </div>
                <div class="info-box">
                    <h5>Bill From</h5>
                    <strong>You Leggings</strong>
                    <p>Attire Logistics,<br>
                    Surandai, Tamil Nadu - 627859<br>
                    India<br>
                    GSTN: 33AWPPJ9059B2ZD</p>
                </div>
                <div class="info-box text-end">
                    <h5>Payment Method</h5>
                    <strong style="text-transform: uppercase;">{{ $order->payment_type }}</strong>
                    <p class="text-muted">Transaction ID:<br>{{ $order->payment_id ?: 'N/A' }}</p>
                </div>
            </div>

            <table class="item-table">
                <thead>
                    <tr>
                        <th>Product Description</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $item)
                        <tr>
                            <td>
                                <div class="item-desc">
                                    <span class="item-name">{{ $product_name[$key] }}</span>
                                    @php $option = json_decode($item->option, true); @endphp
                                    @if(isset($option['variant']))
                                        <span class="item-variant">Variant: {{ $option['variant'] }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center font-weight-bold">₹{{ number_format($item->amount, 2) }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end font-weight-bold">₹{{ number_format($item->amount * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="summary-wrapper">
                <table class="summary-table">
                    <tr>
                        <td class="summary-label">Subtotal</td>
                        <td class="summary-value">₹{{ number_format($order->sub_total, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="summary-label">Shipping & Handling</td>
                        <td class="summary-value">₹{{ number_format($delivery_charge, 2) }}</td>
                    </tr>
                    @if($order->discound_amount > 0)
                        <tr>
                            <td class="summary-label">Discount Applied</td>
                            <td class="summary-value text-success">-₹{{ number_format($order->discound_amount, 2) }}</td>
                        </tr>
                    @endif
                    <tr class="grand-total-row">
                        <td>Total Amount</td>
                        <td class="text-end">₹{{ number_format($order->total, 2) }}</td>
                    </tr>
                </table>
            </div>

            <div class="footer">
                <p>Thank you for choosing <span class="brand">You Leggings</span>!</p>
                <p class="mb-0 small">This is a computer generated invoice and does not require a physical signature.</p>
                <p class="small text-muted">Visit us at: www.youleggings.com</p>
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
                html2canvas:  { scale: 2, useCORS: true, letterRendering: true },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>
</body>
</html>

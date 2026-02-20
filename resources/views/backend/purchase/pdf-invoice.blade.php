<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Invoice #{{ $invoiceid }}</title>

    <style>
        body {

            font-family: "Courier New", Courier, "Lucida Sans Typewriter", "Lucida Typewriter", monospace !important;

            letter-spacing: -0.3px;

        }

        .invoice-wrapper {
            width: 700px;
            margin: auto;
        }

        .nav-sidebar .nav-header:not(:first-of-type) {
            padding: 1.7rem 0rem .5rem;
        }

        .logo {
            font-size: 50px;
        }

        .sidebar-collapse .brand-link .brand-image {
            margin-top: -33px;
        }

        .content-wrapper {
            margin: auto !important;
        }

        .billing-company-image {
            width: 50px;
        }

        .billing_name {
            text-transform: uppercase;
        }

        .billing_address {
            text-transform: capitalize;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 10px;
        }

        td {
            padding: 10px;
            vertical-align: top;
        }

        .row {
            display: block;
            clear: both;
        }

        .text-right {
            text-align: right;
        }

        .table-hover thead tr {
            background: #eee;
        }

        .table-hover tbody tr:nth-child(even) {
            background: #fbf9f9;
        }

        address {
            font-style: normal;
        }
    </style>

</head>

<body>

    <div class="row invoice-wrapper">

        <div class="col-md-12">

            <div class="row">

                <div class="col-md-12">

                    <table class="table">

                        <tr>

                            <td>

                                <h4>

                                    <span class="">Invoice #{{ $invoiceid }}</span>

                                </h4>

                            </td>

                            <td class="text-right">

                                <strong>Date: {{ date('d M Y') }}</strong>

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

            <br><br>

            <div class="row invoice-info">

                <div class="col-md-12">

                    <table class="table">

                        <tr>

                            <td>

                                <div class="">

                                    From

                                    <address>

                                        <strong>{{ $vendor->vendor_name }}</strong><br>

                                        {{ $vendor->address }}<br>

                                        Email: {{ $vendor->email }}

                                    </address>

                                </div>

                            </td>

                            <td>

                                <div class="">

                                    To

                                    <address>

                                        <strong class="billing_name">Balaji Hakari</strong><br>

                                        <span class="billing_address">#32, Madhura Chetana Colony, Hubli</span><br>

                                        <span class="billing_gst">#TAXNUMBER</span><br>

                                        Phone: +91-7019101234<br>

                                        Email: customer@gmail.com

                                    </address>

                                </div>

                            </td>

                            <td>

                                <div class="text-right">

                                    <b>Invoice #{{ $invoiceid }}</b><br>

                                    Paid for REASON

                                </div>

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

            <br><br>

            <div class="row">

                <div class="col-md-12 table-responsive">

                    <table class="table table-condensed table-hover">

                        <thead>

                            <tr>

                                <th>Product</th>

                                <th>Attribute Type</th>

                                <th>Attribute Value</th>

                                <th>Qty</th>

                                <th>Tax(%)</th>

                                <th>Price</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($productdetail as $k => $item)
                                <tr>

                                    <td>{{ $item->product_name }}</td>

                                    <td>{{ $item->attribute_name }}</td>

                                    <td>{{ $item->attribute_value }}</td>

                                    <td>{{ $item->quantity }}</td>

                                    <td>{{ $item->tax_rate }}%</td>

                                    <td class="text-right">&#8377; {{ $item->buying_price }}</td>

                                </tr>

                                @php

                                    @$gstvalue += @((int) $item->buying_price / 100) * (int) $item->tax_rate;

                                @endphp
                            @endforeach

                            <tr>

                                <td colspan="4" class="text-right">Sub Total</td>

                                <td class="text-right"><strong>&#8377; {{ $amount }}</td>

                            </tr>

                            <!-- @foreach ($gstAmount as $k => $item)
@endforeach -->

                            <tr>

                                <td colspan="4" class="text-right">TAX </td>

                                <td class="text-right"><strong>&#8377; {{ $gstvalue }}</strong></td>

                            </tr>

                            <tr>

                                <td colspan="4" class="text-right">Total Payable</td>

                                <td class="text-right"><strong>&#8377; {{ $totalAmount + $gstvalue }}</strong></td>

                            </tr>

                        </tbody>

                    </table>

                </div>

                <!-- /.col -->

            </div>

            <br><br><br>

            <div>

                <small><small>NOTE: This is system generate invoice no need of signature</small></small>

            </div>

        </div>

    </div>

</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>BMS - Admin & Dashboard</title>

    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/morris/morris.css') }}">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/switch-button-bootstrap/css/bootstrap-switch-button.min.css') }}">
    <!-- DataTables -->
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('assets/css/custom-category.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/plugins/RWD-Table-Patterns/dist/css/rwd-table.min.css') }} rel="stylesheet"
        type="text/css" media="screen">

    <link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css">

    <style>
        .title-address {
            margin-bottom: 30px;
            font-size: 18px;
            font-weight: 600;
        }

        .title-details {
            color: #5c727d;
        }

        .panel {
            padding: 0 120px;
        }

        .pdf-table .table td,
        .table th {
            border: 1px solid #dee2e6;
        }

        .pdf-table .table>tbody>tr>.no-line {
            border: none;
        }

        .btn-wrapper {
            display: block;
            margin-top: 30px;
            width: 100%;
        }

        .animated {
            -webkit-animation-duration: 1s;
            -webkit-animation-fill-mode: both;
            animation-duration: 1s;
            animation-fill-mode: both;
        }

        .btn:last-child {
            margin-right: 0;
        }

        .theme-btn-1 {
            background-color: #6b57c9;
            color: #fff !important;
        }

        .btn-effect-1:after {
            width: 0%;
            height: 100%;
            top: 0;
            left: 0;
            background: #ffffff;
        }

        .btn {
            border-radius: 0;
            display: inline-block;
            font-size: 16px;
            font-weight: 400;
            font-family: var(--ltn__heading-font);
            padding: 17px 35px;
            text-align: center;
            cursor: pointer;
            -webkit-transition: all 0.3s ease 0s;
            -o-transition: all 0.3s ease 0s;
            transition: all 0.3s ease 0s;
            position: relative;
            z-index: 1;
            margin-right: 15px;
        }

        .btn-effect-1:hover {
            color: #071c1f;
        }

        .theme-btn-1:hover {
            background-color: #071c1f;
            color: #ffffff;
        }

        .btn:last-child {
            margin-right: 0;
        }
    </style>
</head>

<body>

    <div id="element" class="page-content-wrapper">

        <div class="row order_to_print" style="overflow: auto;">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body" style="margin: 0px 50px; padding: 0px 60px;">

                        <div class="row" style="overflow: auto;">
                            <div class="col-md-12">
                                <table style="width:100%" class="text-center">
                                    <tr>
                                        <td class="blue">
                                            TAX INVOICE
                                        </td>
                                    </tr>
                                </table>
                                <table style="width:100%;overflow: auto;">

                                    <tr>
                                        <td width="50%" rowspan="2">
                                            <div class="company">
                                                <div class="company-logo">
                                                    <img src="https://prrayashacollections.com/frontend/img/Prrayasha Collection LOGO.jpeg"
                                                        width="100%" class="squaree" alt="">
                                                </div>
                                                <div class="company-details">
                                                    <h2> Prrayasha Collections</h2>
                                                    <p>GSTN : 33AWPPJ9059B2ZD </p>
                                                    <p>Provident Cosmo City, DR Abdul Kalam Road,<br> Pudhupakkam
                                                        Village, Chengalpet 603103</p>
                                                    <p>+9191590 24967
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p>Invoice # <b>{{ $order->order_id }}</b></p>
                                            <p>Invoice Date: <b>{{ date('M d, Y', strtotime($order->created_at)) }}</b>
                                            </p>
                                        </td>
                                        <td>
                                            Payment Status : <span
                                                class="badge badge-pill badge @if ($order->payment_status == 'paid') text-success  mr-2
                                                @else
                                                text-danger  mr-2 @endif">{{ $order->payment_status }}</span><br>

                                            Payment Method : {{ $order->payment_type }}

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <address>
                                                <strong>Billing Address :</strong><br>
                                                @if (isset($billing_address))
                                                    Name:
                                                    {{ $billing_address->first_name . $billing_address->last_name }}<br>
                                                    Phone: {{ $billing_address->phone_number }}<br>
                                                    Address: {{ $billing_address->address }}<br>
                                                    State: {{ $state->state }}<br>
                                                    City: {{ $billing_address->city }}<br>
                                                    Zip: {{ $billing_address->pincode }}<br>
                                                @endif
                                            </address>
                                        </td>
                                        <td>
                                            <address>
                                                <strong>Shipping Address :</strong><br>

                                                @if (isset($shipping_address))
                                                    Name:
                                                    {{ $shipping_address->sfirst_name . $shipping_address->slast_name }}<br>
                                                    Phone: {{ $shipping_address->sphone_number }}<br>
                                                    Address: {{ $shipping_address->saddress }}<br>
                                                    State: {{ $state->state }}<br>
                                                    City: {{ $shipping_address->scity }}<br>
                                                    Zip: {{ $shipping_address->spincode }}<br>
                                                @endif

                                            </address>
                                        </td>
                                    </tr>

                                    <tr>

                                        <td>Place of Supply <br> <b>89 - Chengalpattu</b></td>
                                        <td>Due Date: <br> Immediate on Receipt</td>
                                    </tr>
                                </table>

                                <table>
                                    <thead>

                                        <tr class="bg-blue">
                                            <th class="text-center">#</th>
                                            <th width="40%">Item</th>
                                            <th class="text-end">HSN/SAC</th>
                                            <th class="text-end">Quantity</th>
                                            <th class="text-end">Rate/Item</th>
                                            <th class="text-end">Per</th>
                                            <th class="text-end">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $datas)
                                            <?php
                                            $product_id = $datas->product_id;
                                            $products = DB::table('products')->where('id', $product_id)->first();
                                            $gsttax = DB::table('taxes')->where('id', 1)->first();
                                            
                                            ?>
                                            <tr>
                                                <td class="text-center" width="5%"> {{ $key + 1 }}</td>
                                                <td>
                                                    <b>{{ $product_name[$key] }}</b>
                                                </td>
                                                <td class="text-end" width="10%">{{ $products->hsn_code }}</td>
                                                <td class="text-end" width="10%">{{ $datas->quantity }} Nos</td>
                                                <td width="15%" class="fw-bold text-end">
                                                    ₹{{ number_format($datas->amount, 2, '.', '') }}</td>
                                                <td></td>
                                                <td class="text-end" class="text-end">
                                                    ₹{{ number_format($datas->amount * $datas->quantity, 2, '.', '') }}
                                                </td>
                                            </tr>
                                        @endforeach

                                        <tr>
                                            <td></td>
                                            <td class="total-heading text-end">Total Amount - <small>Inc. all
                                                    vat/tax</small> </td>
                                            <td colspan="1" class="total-heading"></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-end">₹{{ number_format($order->sub_total, 2, '.', '') }}
                                            </td>

                                        </tr>
                                        <?php
                                        $gst11 = '';
                                        if (!empty($order->gst)) {
                                            $gst11 = $order->gst / 2;
                                        }
                                        ?>
                                        <?php

                                        if($state->id==31 ){
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td class="total-heading text-end"> CGST {{ $gsttax->percentage }}% </td>
                                            <td colspan="1" class="total-heading"></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-end">{{ number_format($gst11, 2) }}</td>

                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class="total-heading text-end"> SGST {{ $gsttax->percentage }}% </td>
                                            <td colspan="1" class="total-heading"></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-end">{{ number_format($gst11, 2) }}</td>

                                        </tr>
                                        <?php }else{?>
                                        <tr>
                                            <td></td>
                                            <td class="total-heading text-end"> IGST {{ $gsttax->percentage1 }}% </td>
                                            <td colspan="1" class="total-heading"></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-end"> ₹ {{ $order->gst }}</td>

                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td></td>
                                            <td class="text-end">Shipping Amount</td>
                                            <td></td>
                                            <td class="text-end"></td>
                                            <td></td>

                                            <td class="text-end" colspan="2">
                                                ₹{{ number_format($delivery_charge, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class="text-end">Discount Amount</td>
                                            <td></td>
                                            <td class="text-end"></td>
                                            <td></td>

                                            <td class="text-end" colspan="2">
                                                ₹{{ number_format($order->ship_discount_amount, 2, '.', '') }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class="text-end">Coupon Applied</td>
                                            <td></td>
                                            <td class="text-end"></td>
                                            <td></td>

                                            <td class="text-end" colspan="2">
                                                ₹{{ number_format($order->discound_amount, 2, '.', '') }}</td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td class="text-end">Total</td>
                                            <td></td>
                                            <td class="text-end"></td>
                                            <td></td>

                                            <td class="text-end" colspan="2">
                                                ₹{{ number_format($order->sub_total + $order->deliver_charge - $order->discound_amount - $order->ship_discount_amount, 2, '.', '') }}
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                                <?php
                                $total = $order->sub_total + $order->deliver_charge - $order->discound_amount - $order->ship_discount_amount;
                                ?>
                                <table style="width:100%">
                                    <tr>
                                        <td>
                                            <?php
                                            function numberToWords($number)
                                            {
                                                $words = [
                                                    '0' => 'Zero',
                                                    '1' => 'One',
                                                    '2' => 'Two',
                                                    '3' => 'Three',
                                                    '4' => 'Four',
                                                    '5' => 'Five',
                                                    '6' => 'Six',
                                                    '7' => 'Seven',
                                                    '8' => 'Eight',
                                                    '9' => 'Nine',
                                                    '10' => 'Ten',
                                                    '11' => 'Eleven',
                                                    '12' => 'Twelve',
                                                    '13' => 'Thirteen',
                                                    '14' => 'Fourteen',
                                                    '15' => 'Fifteen',
                                                    '16' => 'Sixteen',
                                                    '17' => 'Seventeen',
                                                    '18' => 'Eighteen',
                                                    '19' => 'Nineteen',
                                                    '20' => 'Twenty',
                                                    '30' => 'Thirty',
                                                    '40' => 'Forty',
                                                    '50' => 'Fifty',
                                                    '60' => 'Sixty',
                                                    '70' => 'Seventy',
                                                    '80' => 'Eighty',
                                                    '90' => 'Ninety',
                                                ];
                                            
                                                if ($number < 100) {
                                                    if ($number <= 20) {
                                                        return $words[$number];
                                                    } else {
                                                        $tens = floor($number / 10) * 10;
                                                        $units = $number % 10;
                                                        return $units ? $words[$tens] . ' ' . $words[$units] : $words[$tens];
                                                    }
                                                } elseif ($number < 1000) {
                                                    $hundreds = floor($number / 100);
                                                    $remainder = $number % 100;
                                                    return $words[$hundreds] . ' Hundred' . ($remainder ? ' ' . numberToWords($remainder) : '');
                                                }
                                            }
                                            
                                            //$amount = 489;
                                            // echo numberToWords($total); // Output: Four Hundred Eighty Nine
                                            
                                            ?>
                                            Amount Chargable (in words): INR <?php echo numberToWords($total); ?>
                                        </td>
                                    </tr>

                                    <tr class="text-end">
                                        <td>Amount Paid: ₹{{ number_format($total, 2, '.', '') }}</td>
                                    </tr>

                                </table>

                                <table style="width:100%">
                                    <tr>
                                        <td width="70%" class="text-end">Pay Using UPI</td>

                                        <td width="30%" class="text-end">For Prrayasha Collection</td>
                                    </tr>

                                    <tr>
                                        <td class="text-end"> </td>
                                        <td class="text-end"> <img width="40%"
                                                src="https://taslim.oceansoftwares.in/prrayasha/public/frontend/img/sign.jpg">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Notes:<br>Thank you for the Shopping</td>

                                        <td>Terms and Conditions:
                                            <ul>
                                                <li>Products once sold cannot be returned or exchanged unless damage
                                                    issue.</li>
                                                <li>To return or exchange for damage reasons, parcel opening video
                                                    without any edits and cuts is must and has to shared with us through
                                                    email (prayashacollections@gmail.com) or whatsapp (9159024967) with
                                                    your order details.</li>
                                                <li>No return or exchange for size issues.</li>
                                            </ul>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>

                        <div class="row">

                            <div class="btn-wrapper animated" style="text-align:center">
                                {{-- <a href="{{url('/generate-pdf')}}" class="theme-btn-1 btn btn-effect-1 text-uppercase"  class="btn-primary" >Download</a> --}}
                                <button onclick="download_pdf()" class="theme-btn-1 btn btn-effect-1 text-uppercase"
                                    id="printPageButton" data-html2canvas-ignore="true">Download</button>
                            </div>

                        </div>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div><!-- container fluid -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.1/html2pdf.bundle.min.js"></script>
    <script type="text/javascript">
        function download_pdf() {
            let element = document.getElementById('element');
            html2pdf(element, {
                margin: 5,
                padding: 2,
                image: {
                    type: 'jpeg',
                    quality: 0.95
                },
                html2canvas: {
                    scale: 2,
                    logging: true
                },

            });
        }
    </script>
    <style>
        @media print {
            #printPageButton {
                display: none;
            }
        }
    </style>
</body>

</html>

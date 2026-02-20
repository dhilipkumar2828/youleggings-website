@extends('frontend.layouts.arrivals_products_master_new')

@section('content')
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

        section.browse-list-section.mobviewsecone {
            display: none;
        }

        @media (max-width: 767px) {
            section.browse-list-section.mobviewsecone {
                display: block;
            }

            .topnavnewmega {
                display: none;
            }
        }
    </style>
    <section class="browse-list-section mobviewsecone">
        <!-- category list custom -->

        <div class="container">

            <div class="row mb-n4 mb-sm-n10 g-3 g-sm-6">
                <div id="owl-one" class="owl-carousel owl-theme">

                    @php
                        $category = DB::table('categories')
                            ->select('title', 'id', 'slug', 'photo')
                            ->where('is_parent', 0)
                            ->orderBy('headerorder', 'asc')
                            ->where('header', 'active')
                            ->where('status', 'active')
                            ->get();
                    @endphp

                    @foreach ($category as $c)
                        <div class="item">

                            <div class="category-item text-center">
                                <a href="{{ url('product_list') . '/' . $c->slug }}" style="color:black !important;">
                                    <img src="{{ $c->photo }}" class="img-fluid menuimg" width="64" height="64"
                                        alt="">
                                    <h5 class="title fontsiz mt-0 mb-0">{{ $c->title }}</h5>

                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        </div>
    </section>
    <div class="container ">
        <div class="page-content-wrapper ">

            <div class="row order_to_print">
                <div class="col-12">
                    <div class=" ">
                        <div class="card-body mb-4 mt-4">
                            <div class="pdf-body">
                                <div id="section-to-print">
                                    <div class="row">
                                        <div class="col-12">

                                            <div class="table-responsive pdf-table">

                                                <table style="width:100%" class="text-center table">
                                                    <tr>
                                                        <td class="blue">
                                                            TAX INVOICE
                                                        </td>
                                                    </tr>
                                                </table>
                                                <table style="width:100%" class="table">

                                                    <tr>
                                                        <td width="50%" rowspan="2">
                                                            <div class="company">
                                                                <div class="company-logo">
                                                                    <img src="https://you.oceansoftwares.in/demo/frontend/img/you-leggings.png"
                                                                        width="300px;" class="squaree" alt="">
                                                                </div>
                                                                <div class="company-details">

                                                                    <p>GSTN : 0212535 </p>
                                                                    <p>5/4, Surya Nagar, 2nd Street, Bridgeway Colony Extn,
                                                                        Tirupur - 641607</p>
                                                                    <p>+91 740143 24967</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0">Invoice # <b>{{ $order->order_id }}</b></p>
                                                            <p>Invoice Date:
                                                                <b>{{ date('M d, Y', strtotime($order->created_at)) }}</b>
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
                                                        <td></td>
                                                    </tr>
                                                </table>

                                                <table class="table">
                                                    <thead>

                                                        <tr class="bg-blue">
                                                            <th class="text-center">#</th>
                                                            <th width="40%">Item</th>
                                                            <th class="text-end">HSN/SAC</th>
                                                            <th class="text-end">Info</th>
                                                            <th class="text-end">Quantity</th>
                                                            <th class="text-end">Rate/Item</th>
                                                            <!--<th class="text-end">Per</th>-->
                                                            <th class="text-end">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $gsttax = DB::table('taxes')->where('id', 1)->first();
                                                        ?>
                                                        @foreach ($data as $key => $datas)
                                                            <?php
                                                            $product_id = $datas->product_id;
                                                            $products = DB::table('products')->where('id', $product_id)->first();
                                                            
                                                            ?>
                                                            <tr>
                                                                <td class="text-center" width="5%"> {{ $key + 1 }}
                                                                </td>

                                                                <td>
                                                                    @if (isset($product_name[$key]))
                                                                        <b>{{ $product_name[$key] }}</b>
                                                                    @else
                                                                        <b>Product Name Not Available</b>
                                                                    @endif
                                                                </td>

                                                                <td class="text-end" width="10%">
                                                                    @if ($products && isset($products->hsn_code))
                                                                        {{ $products->hsn_code }}
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                </td>
                                                                <td class="text-end">
                                                                    {{ $datas->option }}
                                                                </td>
                                                                <td class="text-end" width="10%">{{ $datas->quantity }}
                                                                    Nos</td>
                                                                <td width="15%" class="fw-bold text-end">
                                                                    ₹{{ number_format($datas->amount, 2, '.', '') }}</td>
                                                                <!--<td></td>-->
                                                                <td class="text-end" class="text-end">
                                                                    ₹{{ number_format($datas->amount * $datas->quantity, 2, '.', '') }}
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                        <tr>
                                                            <td></td>
                                                            <td class="total-heading text-end">Total Amount - <small>Inc.
                                                                    all vat/tax</small> </td>
                                                            <td colspan="1" class="total-heading"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-end">
                                                                ₹{{ number_format($order->sub_total, 2, '.', '') }}</td>

                                                        </tr>
                                                        <?php
                                                        $gst11 = 0;
                                                        if (!empty($order->gst)) {
                                                            $gst11 = $order->gst / 2;
                                                        }
                                                        ?>
                                                        <?php

                                        if($state->id==31 ){
                                            $csGST = $gsttax->percentage / 2;
                                        ?>
                                                        <tr>
                                                            <td></td>
                                                            <td class="total-heading text-end"> CGST {{ $csGST }}%
                                                            </td>
                                                            <td colspan="1" class="total-heading"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-end">{{ number_format($gst11, 2) }}</td>

                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td class="total-heading text-end"> SGST {{ $csGST }}%
                                                            </td>
                                                            <td colspan="1" class="total-heading"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-end">{{ number_format($gst11, 2) }}</td>

                                                        </tr>
                                                        <?php }else{?>
                                                        <tr>
                                                            <td></td>
                                                            <td class="total-heading text-end"> IGST
                                                                {{ $gsttax->percentage1 }}% </td>
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
                                                                ₹{{ number_format($order->ship_discount_amount, 2, '.', '') }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td class="text-end">Coupon Applied</td>
                                                            <td></td>
                                                            <td class="text-end"></td>
                                                            <td></td>

                                                            <td class="text-end" colspan="2">
                                                                ₹{{ number_format($order->discound_amount, 2, '.', '') }}
                                                            </td>
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
                                                <table style="width:100%" class="table">
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
                                                        <td>Amount Payabel: ₹{{ number_format($total, 2, '.', '') }}</td>
                                                    </tr>

                                                </table>

                                                <table style="width:100%" class="table">

                                                    <tr>
                                                        <td>Notes:<br>Thank you for the Shopping</td>

                                                        <td>Terms and Conditions:
                                                            <ul>
                                                                <li>Products once sold cannot be returned or exchanged
                                                                    unless damage issue.</li>
                                                                <li>To return or exchange for damage reasons, parcel opening
                                                                    video without any edits and cuts is must and has to
                                                                    shared with us through email (youleggings@gmail.com) or
                                                                    whatsapp (740143 24967) with your order details.</li>
                                                                <li>No return or exchange for size issues.</li>
                                                                <li>For any queries or disputes related to products or
                                                                    payments:
                                                                    <br>Email youleggings@gmail.com (response within 2
                                                                    working days).

                                                                    <br>If no response, contact WhatsApp +91 740143 24967
                                                                    (response within 2 working days).

                                                                    <br>If unresolved thereafter, you may proceed with legal
                                                                    action as per applicable laws.
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>

                                                </table>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">

                                <div class="btn-wrapper animated" style="text-align:center">
                                    <a class=" btn btn-effect-1" type="button" class="btn-primary" id="printPageButton"
                                        onclick="window.print()">Print</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div><!-- container fluid -->
    </div>
    <style>
        @media print {
            #printPageButton {
                display: none;
            }
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #section-to-print,
            #section-to-print * {
                visibility: visible;
            }

            #section-to-print {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>

    @if (count($deleted_products) > 0)
        <script>
            let deletedProducts = @json($deleted_products);
            deletedProducts.forEach(product => {
                alert(product.message);
            });
        </script>
    @endif

    @if (count($deactivated_products) > 0)
        <script>
            let deactivatedProducts = @json($deactivated_products);
            deactivatedProducts.forEach(product => {
                alert(product.message);
            });
        </script>
    @endif
@endsection

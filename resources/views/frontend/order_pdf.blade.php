<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Tulia - Admin & Dashboard</title>

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
</head>

<body>

    <div class="page-content-wrapper ">

        <div class="row order_to_print">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">
                                <div class="invoice-title">

                                    <h4 class="float-right font-16"><strong>Order #{{ $order->order_id }}</strong></h4>
                                    <h3 class="m-t-0">
                                        <img src="{{ asset('frontend/img/logo.png') }}" style="height: 100px;"
                                            alt="logo" />
                                    </h3>
                                </div>
                                <hr>
                                <?php
                                if ($order->payment_status != '' && $order_status == 'paid') {
                                    $sStatus = '<span style="color:green;font-size: 18px;">' . $order->payment_status . '</span>';
                                } else {
                                    $sStatus = '<span style="color:red;font-size: 18px;">Unpaid</span>';
                                }
                                
                                $status22 = '';
                                
                                if ($order->status == 'Received') {
                                    $status22 = 'Order Confirmed';
                                } elseif ($order->status == 'Processing') {
                                    $status22 = 'Unfullied  Orders';
                                } elseif ($order->status == 'Delivered') {
                                    $status22 = 'Dispatched  Orders';
                                } else {
                                    $status22 = $order->status;
                                }
                                
                                ?>
                                <div class="row">
                                    <div class="col-6">
                                        <address>
                                            <strong>Order Details</strong><br>

                                            Order ID: {{ $order->order_id }}<br>
                                            Order Date : {{ date('M d, Y', strtotime($order->created_at)) }}<br>
                                            Payment Status : {!! $sStatus !!}<br>
                                            Order Status : {{ $status22 }}<br>
                                            Payment Method : {{ $order->payment_id }}

                                        </address>
                                    </div>
                                    <div class="col-6 text-right">
                                        <address>

                                        </address>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 m-t-30">
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
                                    </div>
                                    <div class="col-6 m-t-30 text-right">
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
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="panel panel-default">
                                    <div class="p-2">
                                        <h3 class="panel-title font-20"><strong>Order summary</strong></h3>
                                    </div>
                                    <div class="">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>

                                                        <td><strong>Product Name</strong></td>
                                                        <td class="text-center"><strong>Actual Price</strong></td>
                                                        <td class="text-center"><strong>Tax</strong></td>
                                                        <td class="text-center"><strong>Discount</strong></td>
                                                        <td class="text-center"><strong>Quantity</strong></td>
                                                        <td class="text-center"><strong>Totals</strong></td>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($data as $datas)
                                                        <tr>
                                                            <td>{{ $datas->order_product->title }}</td>
                                                            <td class="text-center">{{ $datas->total_tax }}</td>
                                                            <td class="text-center">{{ $datas->tax_rate }}</td>
                                                            <td class="text-center">{{ $datas->discount_amount }}</td>
                                                            <td class="text-center">{{ $datas->quantity }}</td>
                                                            <td class="text-center">
                                                                {{ $datas->amount * $datas->quantity }}</td>
                                                        </tr>
                                                    @endforeach

                                                    <tr>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line"></td>
                                                        <td class="thick-line text-center">
                                                            <strong>Tax</strong>
                                                        </td>

                                                        <td class="thick-line text-right">₹{{ $order->tax_rate }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <!-- <td class="thick-line"></td> -->
                                                        <td class="no-line text-center">
                                                            <strong>Subtotal</strong>
                                                        </td>

                                                        <td class="no-line text-right">₹{{ $order->sub_total }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center">
                                                            <strong>Shipping</strong>
                                                        </td>

                                                        <td class="no-line text-right">{{ $delivery_charge }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center">
                                                            <strong>Discount</strong>
                                                        </td>

                                                        <td class="no-line text-right">
                                                            <h4 class="m-0">₹{{ $order->discound_amount }}</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center">
                                                            <strong>Total</strong>
                                                        </td>

                                                        <td class="no-line text-right">
                                                            <h4 class="m-0">
                                                                ₹{{ $order->sub_total + $delivery_charge - $order->discound_amount }}
                                                            </h4>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <br>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="row">
                            <div class="col-12" style="width:100%;text-align:center">
                                <button type="button" class="btn-primary" onclick="window.print()">Print</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div><!-- container fluid -->
</body>

</html>

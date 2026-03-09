@extends('backend.layouts.master')

@section('content')

    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row d-print-none">
                <div class="col-sm-12">
                    <div class="float-right page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a>Orders</a></li>
                            <li class="breadcrumb-item active"> Order Invoice</li>
                        </ol>
                    </div>
                    <h5 class="page-title">Orders</h5>
                </div>
            </div>
            <!-- end row -->

            <div class="card m-b-30 card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="card-title font-18 mt-0 mb-0" id="order">

                            <span class=d-block>Invoice</span>

                            <?php

                $tempPara = '';

                if(isset($_REQUEST['status']) && $_REQUEST['status']=="paid"){
                    $tempPara = '?status=paid';
                }
                if(isset($_REQUEST['status']) && $_REQUEST['status']=="unpaid"){
                    $tempPara = '?status=unpaid';
                }
                    if($previousOrder > 0){?>

                            <?php }
                    ?>
                            <h4>{{ $order->order_id }}</h4>
                            <?php
                    if($nextOrder > 0){?>
                            <!--     <a href="{{ url('view_detail') }}/{{ $nextOrder }}{{ $tempPara }}" title="Next Order"> <i class="fa fa-angle-right"-->
                            <!--aria-hidden="true"></i></a>-->
                            <?php }
                    ?>
                        </h6>
                    </div>

                    <div class="col-md-6 text-right">
                        <a href="#" onclick="history.go(-1)" id="add-btn-order">
                            <i class="fa fa-angle-left" aria-hidden="true"></i> Back
                        </a>

                    </div>
                </div>
            </div>

        </div>

        <div class="row order_to_print">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                @if (auth()->user()->can('all_orders-edit') or
                                        auth()->user()->can('recieved_orders-edit') or
                                        auth()->user()->can('confirmed_orders-edit') or
                                        auth()->user()->can('processing_orders-edit') or
                                        auth()->user()->can('delivered_orders-edit'))
                                    <div class="row" style="
    padding-left: 19px;
">
                                        <div class="col-md-12 border py-3">

                                            <form method="post" action="{{ route('order.status') }}">
                                                @csrf
                                                <!-- @method('PATCH') -->
                                                <div class="row col-md-12">
                                                    <div class="col-md-3">
                                                        <strong>Tracking Id</strong>
                                                        <input typex="text" class="form-control" name="tracking_id"
                                                            id="tracking_id" value="{{ $order->tracking_id }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <strong>Order Status</strong>

                                                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                                                        <select name="status" class="form-control" id="condition">
                                                            <!----
                                                                    <option value='received'
                                                                        {{ $order->status == 'received' ? 'selected' : '' }}>Received
                                                                    </option>

                                                                    <option value='Confirmed'
                                                                        {{ $order->status == 'Confirmed' ? 'selected' : '' }}>Confirmed
                                                                    </option>
                                                                    --->
                                                            <option value='Processing'
                                                                {{ $order->status == 'Processing' ? 'selected' : '' }}>
                                                                Unfullied Orders
                                                            </option>
                                                            <option value='Delivered'
                                                                {{ $order->status == 'Delivered' ? 'selected' : '' }}>
                                                                Dispatched Orders
                                                            </option>
                                                            <!----
                                                                    <option value='Cancelled'
                                                                        {{ $order->status == 'Cancelled' ? 'selected' : '' }}>
                                                                        Cancelled Orders
                                                                    </option>
                                                                     <option value='Returned'
                                                                        {{ $order->status == 'Returned' ? 'selected' : '' }}>
                                                                        Returned Orders
                                                                    </option>
                                                                    ---->

                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <strong>Pay Status</strong>
                                                        <?php

                                                        if($order->payment_status!='paid'){?>
                                                        <select name="payment_status" id="payment_status"
                                                            class="form-control" disabled>

                                                            <option value='paid'
                                                                {{ $order->payment_status == 'paid' ? 'selected' : '' }}>
                                                                Paid
                                                            </option>
                                                            <option value='unpaid'
                                                                {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>
                                                                Unpaid
                                                            </option>

                                                        </select>
                                                        <?php } else {?>
                                                        <select name="payment_status" id="payment_status"
                                                            class="form-control">
                                                            <option value='paid'
                                                                {{ $order->payment_status == 'paid' ? 'selected' : '' }}>
                                                                Paid
                                                            </option>
                                                        </select>
                                                        <?php } ?>

                                                    </div>
                                                    <div class="col-md-3" style="
    margin-top: 24px;
">
                                                        <strong>&nbsp;</strong>
                                                        <!--<button class="btn btn-sm btn-success">Update</button>-->
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                        @if ($order->status == 'Cancelled')
                                            <div class="col-md-7">
                                                <div class="card m-b-30">
                                                    <div class="card-body">

                                                        <table class="table table-bordered dt-responsive nowrap"
                                                            style="border-collapse: collapse; border-spacing: 0; width: 50%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Reason</th>
                                                                    <th>Order Date</th>
                                                                    <th> Status</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <tr>
                                                                    <td>{{ @$order->reasons->reason }}</td>
                                                                    <td>{{ @\Carbon\Carbon::parse($order->reasons->created_at)->format('M,d,Y') }}
                                                                    </td>
                                                                    <td><input type="checkbox" name="toogle"
                                                                            value="{{ @$order->reasons->id }}"
                                                                            data-toggle="switchbutton"
                                                                            {{ @$order->reasons->status == 'active' ? 'checked' : '' }}
                                                                            data-onlabel="active" data-offlabel="inactive"
                                                                            data-size="sm" data-onstyle="success"
                                                                            data-offstyle="danger"></td>
                                                                </tr>
                                                            </tbody>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">&nbsp;</div>
                        <div class="row" id="order_to_print">
                            <div class="col-md-12">
                                <table style="width:100%" class="text-center"
                                    style=" height: 28px;
            text-align: left;
            font-size: 16px;
            ">

                                </table>
                                <table style="width:100%">

                                    <tr>
                                        <td width="50%" rowspan="2"
                                            style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                            <div class="company">
                                                <div class="company-logo"
                                                    style=" margin-bottom: 4px;
            display: inline-block;

            font-size: 14px;
            font-weight: 400;">

                                                </div>
                                                <div class="company-details">
                                                    <h2>You Leggings</h2>
                                                    <span>GSTN : 33AWPP0000000 </span><br>
                                                    <span>5/4, Surya Nagar, 2nd Street, Bridgeway Colony Extn, Tirupur -
                                                        641607</span><br>
                                                    <span>+91 74014 39306</span><br>
                                                </div>
                                            </div>
                                        </td>
                                        <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                            <p>Invoice # <b>{{ $order->order_id }}</b></p>
                                            <p>Invoice Date: <b>{{ date('M d, Y', strtotime($order->created_at)) }}</b></p>
                                        </td>
                                        <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                            Payment Status : <span
                                                class="badge badge-pill badge @if ($order->payment_status == 'paid') text-success  mr-2
                                                @else
                                                text-danger  mr-2 @endif">{{ $order->payment_status }}</span><br>

                                            Payment Method : {{ $order->payment_type }}

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">
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
                                        <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">
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

                                        <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">Place of
                                            Supply <br> <b>89 - Chengalpattu</b></td>
                                        <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">Due Date: <br>
                                            Immediate on Receipt</td>

                                        <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">&nbsp;</td>
                                    </tr>
                                </table>

                                <table
                                    style=" height: 28px;
            text-align: left;
            font-size: 16px;
            ">
                                    <thead>

                                        <tr class="bg-blue">
                                            <th class="text-center"
                                                style="height: 28px;
            text-align: left;
            font-size: 16px;
            border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                                #</th>
                                            <th width="40%"
                                                style="height: 28px;
            text-align: left;
            font-size: 16px;
            border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                                Item</th>
                                            <th width="10%"
                                                style="height: 28px;
            text-align: left;
            font-size: 16px;
            border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                                Photo</th>
                                            <th width="10%"
                                                style="height: 28px;
            text-align: left;
            font-size: 16px;
            border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                                Size</th>
                                            <th class="text-end"
                                                style="height: 28px;
            text-align: left;
            font-size: 16px;
            border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                                HSN/SAC</th>
                                            <th class="text-end"
                                                style="height: 28px;
            text-align: left;
            font-size: 16px;
            border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                                Quantity</th>
                                            <th class="text-end"
                                                style="height: 28px;
            text-align: left;
            font-size: 16px;
            border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                                Rate/Item</th>
                                            <th class="text-end"
                                                style="height: 28px;
            text-align: left;
            font-size: 16px;
            border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                                Per</th>
                                            <th class="text-end"
                                                style="height: 28px;
            text-align: left;
            font-size: 16px;
            border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                                Amount</th>
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
                                            
                                            if ($products) {
                                                $product_variant = DB::table('product_variants')->where('product_id', $product_id)->first();
                                                $A_prodimg = explode(',', $product_variant->photo);
                                                $aProductvariant_photo = $A_prodimg[0];
                                                $product_name = $products->name;
                                                $hsn_code = $products->hsn_code;
                                            } else {
                                                $product_name = 'Unknown Product (Deleted)';
                                                $hsn_code = 'N/A';
                                                $aProductvariant_photo = ''; // Placeholder or empty
                                            }
                                            
                                            ?>
                                            <tr>
                                                <td class="text-center" width="5%"
                                                    style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                                    {{ $key + 1 }}</td>
                                                <td>
                                                    <b>{{ $product_name }}</b>
                                                </td>
                                                <td class="text-start" width="10%"
                                                    style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"> <img
                                                        src="{{ image_url($aProductvariant_photo) }}"
                                                        style="width:50px;height:50px;"></td>
                                                <td class="text-start" width="10%"
                                                    style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                                    {{ $datas->option }}</td>
                                                <td class="text-end" width="10%"
                                                    style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                                    {{ $hsn_code }}</td>
                                                <td class="text-end" width="10%"
                                                    style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                                    {{ $datas->quantity }} Nos</td>
                                                <td width="15%" class="fw-bold text-end"
                                                    style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                                    ₹{{ number_format($datas->amount, 2, '.', '') }}</td>
                                                <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                                <td class="text-end" class="text-end"
                                                    style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                                    ₹{{ number_format($datas->amount * $datas->quantity, 2, '.', '') }}
                                                </td>
                                            </tr>
                                        @endforeach

                                        <tr>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td class="total-heading text-end"
                                                style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">Total
                                                Amount - <small>Inc. all tax</small> </td>
                                            <td colspan="1" class="total-heading"
                                                style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td class="text-end"
                                                style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">
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
                                        ?>
                                        <tr>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td class="total-heading text-end"
                                                style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"> CGST
                                                {{ $gsttax->percentage / 2 }}% </td>
                                            <td colspan="1" class="total-heading"
                                                style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td class="text-end"
                                                style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                                {{ number_format($gst11, 2) }}</td>

                                        </tr>
                                        <tr>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td class="total-heading text-end"
                                                style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"> SGST
                                                {{ $gsttax->percentage / 2 }}% </td>
                                            <td colspan="1" class="total-heading"
                                                style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td class="text-end"
                                                style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                                {{ number_format($gst11, 2) }}</td>

                                        </tr>

                                        <?php }else{?>
                                        <tr>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td class="total-heading text-end"
                                                style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"> IGST
                                                {{ $gsttax->percentage1 }}% </td>
                                            <td colspan="1" class="total-heading"
                                                style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <t style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"d>
                                                </td>
                                                <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                                <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                                <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                                <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                                <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                                <td class="text-end"
                                                    style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"> ₹
                                                    {{ $order->gst }}</td>

                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td class="text-end"
                                                style=" border: 1px solid #908989;padding: 8px;font-size: 14px;text-align:right;"
                                                colspan="6">Shipping Amount</td>

                                            <td class="text-end" colspan="2"
                                                style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                                ₹{{ number_format($delivery_charge, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td class="text-end"
                                                style=" border: 1px solid #908989;padding: 8px;font-size: 14px;text-align:right;"
                                                colspan="6">Discount Amount</td>

                                            <td class="text-end" colspan="2"
                                                style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                                ₹{{ number_format($order->ship_discount_amount, 2, '.', '') }}</td>
                                        </tr>
                                        <tr>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td class="text-end"
                                                style=" border: 1px solid #908989;padding: 8px;font-size: 14px;text-align:right;"
                                                colspan="6">Coupon Applied</td>

                                            <td class="text-end" colspan="2"
                                                style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                                ₹{{ number_format($order->discound_amount, 2, '.', '') }}</td>
                                        </tr>

                                        <tr>
                                            <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;"></td>
                                            <td class="text-end"
                                                style=" border: 1px solid #908989;padding: 8px;font-size: 14px;text-align:right;"
                                                colspan="6">Total</td>

                                            <td class="text-end" colspan="2"
                                                style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                                ₹{{ number_format($order->sub_total + $order->deliver_charge - $order->discound_amount - $order->ship_discount_amount, 2, '.', '') }}
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                                <?php
                                $total = $order->sub_total + $order->deliver_charge - $order->discound_amount - $order->ship_discount_amount;
                                ?>
                                <table style="width:100%"
                                    style=" height: 28px;
            text-align: left;
            font-size: 16px;
            ">
                                    <tr>
                                        <td
                                            style=" border: 1px solid #908989;padding: 8px;font-size: 14px;text-align:right;">
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
                                                } elseif ($number < 100000) {
                                                    $thousands = floor($number / 1000);
                                                    $remainder = $number % 1000;
                                                    return numberToWords($thousands) . ' Thousand' . ($remainder ? ' ' . numberToWords($remainder) : '');
                                                }
                                            }
                                            
                                            //$amount = 489;
                                            // echo numberToWords($total); // Output: Four Hundred Eighty Nine
                                            
                                            ?>
                                            Amount Chargable (in words): INR <?php echo numberToWords($total); ?>
                                        </td>
                                    </tr>

                                    <tr class="text-end">
                                        <td
                                            style=" border: 1px solid #908989;padding: 8px;font-size: 14px;text-align:right;">
                                            Amount Paid: ₹{{ number_format($total, 2, '.', '') }}</td>
                                    </tr>

                                </table>

                                <table style="width:100%">

                                    <tr>
                                        <td style=" border: 1px solid #908989;padding: 8px;font-size: 14px;">
                                            Notes:<br>Thank you for the Shopping</td>

                                        <td
                                            style=" border: 1px solid #908989;padding: 8px;font-size: 14px;width:70% !important;">
                                            Terms and Conditions:
                                            <ul>
                                                <li>Products once sold cannot be returned or exchanged unless damage issue.
                                                </li>
                                                <li>To return or exchange for damage reasons, parcel opening video without
                                                    any edits and cuts is must and has to shared with us through email
                                                    (youleggings@gmail.com) or whatsapp (7401439306) with your order
                                                    details.</li>

                                            </ul>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div><!-- container fluid -->

    </div>
    <!-- End Right content here -->

    </div>
    <!-- END wrapper -->

@endsection

@section('scripts')
    <script>
        $('input[name=toogle]').change(function() {
            var mode = $(this).prop('checked');
            var id = $(this).val();
            // alert(id);
            $.ajax({

                url: "{{ route('reason.Status') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    mode: mode,
                    id: id,
                },
                success: function(response) {
                    console.log(response.status);
                }
            })
        });

        $('#add-btn1').click(function(e) {
            //$('.order_to_print').print();
            // printDiv();
        })

        function printDiv() {
            var divToPrint = document.getElementById("order_to_print");
            newWin = window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        }

        /*
        function printDiv()
        {

          var divToPrint=document.getElementsByClassName('order_to_print')[0];

          var newWin=window.open('','Print-Window');

          newWin.document.open();

          newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

          newWin.document.close();

          setTimeout(function(){newWin.close();},10);

        }
        */
    </script>

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

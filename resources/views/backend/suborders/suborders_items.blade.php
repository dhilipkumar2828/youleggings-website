@extends('backend.layouts.master')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row d-print-none">

                <div class="col-sm-12">

                    <div class="float-right page-breadcrumb">

                        <ol class="breadcrumb">

                            <li class="breadcrumb-item"><a href="#">Manage Orders</a></li>

                            <li class="breadcrumb-item active"> Order Invoice</li>

                        </ol>

                    </div>

                    <h5 class="page-title">Order Invoice</h5>

                </div>

            </div>

            <!-- end row -->

            <div class="card m-b-30 card-body">

                <h4 class="card-title font-20 mt-0" id="order">Order Invoice</h4>

                <a href="{{ route('order.index') }}" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left"
                        aria-hidden="true"></i> Back</a>

                <a href="javascript:window.print()" id="add-btn1" style="color: #ffffff;"
                    class="waves-effect waves-light"><i class="fa fa-print"> Print</i></a>

            </div>

        </div>

        <div class="row">

            <div class="col-12">

                <div class="card m-b-30">

                    <div class="card-body">

                        <div class="row">

                            <div class="col-12">

                                <div class="invoice-title">

                                    <h4 class="float-right font-16"><strong>Order #{{ $order->order_id }}</strong></h4>

                                    <h3 class="m-t-0">

                                        <img src="{{ asset('frontend/img/tulia-logo.png') }}"
                                            style="width: 7%;

                                          height: 50px;"
                                            alt="logo" height="22" />

                                    </h3>

                                </div>

                                <hr>

                                <div class="row">

                                    <div class="col-6">

                                        <address>

                                            <strong>Order Details</strong><br>

                                            Order ID: {{ $sub_orders->orders_id }}<br>

                                            Order Date : {{ date('M d, Y', strtotime($sub_orders->created_at)) }}<br>

                                            Payment Status : <span
                                                class="badge badge-pill badge @if ($order->payment_status == 'paid') text-success  mr-2

                                                @else

                                                text-danger  mr-2 @endif">{{ $sub_orders->payment_status }}</span><br>

                                            Payment Method : {{ $sub_orders->payment_type }}

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

                                            Name: {{ $order->customer_details->name }}<br>

                                            Email: {{ $order->customer_details->email }}<br>

                                            Phone: {{ $order->customer_details->phone }}<br>

                                            Address: {{ $order->customer_details->address }}<br>

                                            State: {{ $order->customer_details->state }}<br>

                                            City: {{ $order->customer_details->city }}<br>

                                            Zip: {{ $order->customer_details->postcode }}<br>

                                        </address>

                                    </div>

                                    <div class="col-6 m-t-30 text-right">

                                        <address>

                                            <strong>Shipping Address :</strong><br>

                                            Name: {{ $order->customer_details->name }}<br>

                                            Email: {{ $order->customer_details->email }}<br>

                                            Phone: {{ $order->customer_details->phone }}<br>

                                            Address: {{ $order->customer_details->saddress }}<br>

                                            State: {{ $order->customer_details->sstate }}<br>

                                            City: {{ $order->customer_details->scity }}<br>

                                            Zip: {{ $order->customer_details->spostcode }}<br>

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

                                                        <td><strong>S No</strong></td>

                                                        <td><strong>Product Name</strong></td>

                                                        <td class="text-center"><strong>Quantity</strong>

                                                        </td>

                                                        <td class="text-center"><strong>Option</strong>

                                                        </td>

                                                        <!-- <td class="text-center"><strong>Size</strong>

                                                                                </td> -->

                                                        <td class="text-center"><strong>Totals</strong></td>

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    <!-- foreach ($order->lineItems as $line) or some such thing here -->

                                                    @php

                                                        $rowcnt = 1;

                                                    @endphp

                                                    @foreach ($suborders_items as $datas)
                                                        @php

                                                            $get_product = DB::table('products')
                                                                ->where('id', $datas->products_id)
                                                                ->first();

                                                        @endphp

                                                        <tr>

                                                            <td>{{ $rowcnt }}</td>

                                                            <td>{{ $get_product->title }}</td>

                                                            <td class="text-center">{{ $datas->quantity }}</td>

                                                            <td class="text-center">{{ $datas->option }}</td>

                                                            <!-- <td class="text-center">json_decode($datas->option,true)['Color']</td> -->

                                                            <td class="text-center">₹ {{ $datas->amount }}</td>

                                                        </tr>

                                                        @php $rowcnt++; @endphp
                                                    @endforeach

                                                    <!-- <tr>

                                                                                <td>BS-400</td>

                                                                                <td class="text-center">$20.00</td>

                                                                                <td class="text-center">3</td>

                                                                                <td class="text-right">$60.00</td>

                                                                            </tr>

                                                                            <tr>

                                                                                <td>BS-1000</td>

                                                                                <td class="text-center">$600.00</td>

                                                                                <td class="text-center">1</td>

                                                                                <td class="text-right">$600.00</td>

                                                                            </tr> -->

                                                    <tr>

                                                        <td class="thick-line"></td>

                                                        <td class="thick-line"></td>

                                                        <td class="thick-line"></td>

                                                        <!-- <td class="thick-line"></td> -->

                                                        <td class="thick-line text-center">

                                                            <strong>Subtotal</strong>

                                                        </td>

                                                        <td class="thick-line text-right">₹{{ $order->sub_total }}</td>

                                                    </tr>

                                                    <tr>

                                                        <td class="no-line"></td>

                                                        <td class="no-line"></td>

                                                        <td class="no-line"></td>

                                                        <td class="no-line text-center">

                                                            <strong>Shipping</strong>

                                                        </td>

                                                        <td class="no-line text-right">Free Delivery</td>

                                                    </tr>

                                                    <tr>

                                                        <td class="no-line"></td>

                                                        <td class="no-line"></td>

                                                        <td class="no-line"></td>

                                                        <td class="no-line text-center">

                                                            <strong>Tax</strong>

                                                        </td>

                                                        <td class="no-line text-right">
                                                            ₹{{ $order->sub_total * $order->tax_rate }}</td>

                                                    </tr>

                                                    <tr>

                                                        <td class="no-line"></td>

                                                        <td class="no-line"></td>

                                                        <td class="no-line"></td>

                                                        <td class="no-line text-center">

                                                            <strong>Total</strong>

                                                        </td>

                                                        <td class="no-line text-right">

                                                            <h4 class="m-0">₹{{ $order->total }}</h4>

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
    </script>
@endsection

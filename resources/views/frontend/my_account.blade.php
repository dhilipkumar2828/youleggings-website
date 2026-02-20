@extends('frontend.layouts.arrivals_products_master_new')
@section('content')
    <style>
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

        .tableorder .dataTables_length label {
            display: flex;
            align-items: center;
        }

        .tableorder .dataTables_length label select {
            width: 100px;
            margin: 0px 10px;
        }

        .tableorder .dataTables_filter label {
            display: flex;
            align-items: center;
            justify-content: end;
        }

        .tableorder .dataTables_filter label .form-control {
            width: 200px;
        }

        .tableorder #datatable {
            margin-top: 20px;
        }
    </style>

    <main class="main-content">
        <!--== Start Page Header Area Wrapper ==-->

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
                                        <img src="{{ $c->photo }}" class="img-fluid menuimg" width="64"
                                            height="64" alt="">
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

        <section class="page-header-area">
            <div class="container">
                <!-- style="margin-top:100px;" -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="page-header-st3-content">
                            <h2 class="page-header-title">My Account</h2>
                        </div>
                    </div>

                    <div class="col-md-6 justify-content-end d-flex">
                        <div class="page-header-st3-content">
                            <ol class="breadcrumb justify-content-center justify-content-md-start">
                                <li class="breadcrumb-item"><a class="text-dark" href="{{ url('index') }}">Home</a></li>
                                <li class="breadcrumb-item active text-dark" aria-current="page">My Account</li>
                            </ol>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!--== End Page Header Area Wrapper ==-->
        <!--== Start My Account Area Wrapper ==-->
        <section class="my-account-area section-space">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <div class="my-account-tab-menu nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="dashboad-tab" data-bs-toggle="tab"
                                data-bs-target="#dashboad" type="button" role="tab" aria-controls="dashboad"
                                aria-selected="true">Dashboard</button>
                            <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders"
                                type="button" role="tab" aria-controls="orders" aria-selected="false"> Orders</button>
                            <!-- <button class="nav-link" id="download-tab" data-bs-toggle="tab" data-bs-target="#download" type="button" role="tab" aria-controls="download" aria-selected="false">Download</button> -->
                            <!-- <button class="nav-link" id="payment-method-tab" data-bs-toggle="tab" data-bs-target="#payment-method" type="button" role="tab" aria-controls="payment-method" aria-selected="false">Payment Method</button> -->
                            <button class="nav-link" id="address-edit-tab" data-bs-toggle="tab"
                                data-bs-target="#address-edit" type="button" role="tab" aria-controls="address-edit"
                                aria-selected="false">address</button>
                            @if (auth()->guard('users')->user())
                                <button class="nav-link" id="account-info-tab" data-bs-toggle="tab"
                                    data-bs-target="#account-info" type="button" role="tab"
                                    aria-controls="account-info" aria-selected="false">Account Details</button>
                            @endif
                            <button class="nav-link" onclick="window.location.href='{{ url('user/logout') }}'"
                                type="button">Logout</button>

                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="dashboad" role="tabpanel"
                                aria-labelledby="dashboad-tab">
                                <div class="myaccount-content">
                                    <h3>Dashboard</h3>
                                    <div class="welcome">
                                        <?php
                                        if (Auth::guard('users')->check()) {
                                            $customer_name = $customer_name->name;
                                        } elseif (Auth::guard('guest')->check()) {
                                            $customer_name = auth()->guard('guest')->user()->mobile;
                                        } else {
                                            $customer_name = '';
                                        }
                                        ?>
                                        <p>Hello, <strong> {{ $customer_name }}</strong>
                                    </div>
                                    <p>From your account dashboard. you can easily check & view your recent orders, manage
                                        your shipping and billing addresses and edit your password and account details.</p>

                                    <?php

                                           if(isset($ordersrecently->order_id)){
                                               ?>
                                    <p><strong>Recently Ordered: </strong></p>

                                    <?php
                                    
                                    if (isset($ordersrecently->payment_status)) {
                                        if ($ordersrecently->payment_status != '' && $ordersrecently->payment_status == 'paid') {
                                            $sStatus1 = '<span class="badge badge-success fw-normal" style="background-color: #54cc96;">Paid</span>';
                                        } else {
                                            $sStatus1 = '<span class="badge badge-default fw-normal" style="background-color: #eff3f6;color: #0a1832;">Unpaid</span>';
                                        }
                                    } else {
                                        $sStatus1 = '<span class="badge badge-default fw-normal" style="background-color: #eff3f6;color: #0a1832;">Unpaid</span>';
                                    }
                                    ?>
                                    <p>Order Id : <strong>{{ $ordersrecently->order_id }} </strong></p>
                                    <p>Order Date : <strong>@php echo date('d-m-Y', strtotime($ordersrecently->created_at)); @endphp </strong></p>
                                    <p>Payment Status : <strong>{!! $sStatus1 !!}</strong></p>
                                    <p>Total : <strong><span
                                                class="amt_symbol">₹</span>{{ number_format($ordersrecently->sub_total + $ordersrecently->deliver_charge - $ordersrecently->discound_amount - $ordersrecently->ship_discount_amount, 2) }}
                                        </strong></p>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                <div class="myaccount-content tableorder">
                                    <h3>Orders</h3>
                                    <div class="myaccount-table  text-center">
                                        <table id="datatable"
                                            class="table table-bordered dt-responsive nowrap w-100 text-center">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>S. No</th>
                                                    <th>Order Id</th>
                                                    <th>Order Date</th>
                                                    <!-- <th>Payment Mode</th> -->
                                                    <th>Payment Status</th>
                                                    <!--<th>Status</th>-->
                                                    <th>Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $row = 1;
                                                @endphp
                                                @foreach ($orders as $o)
                                                    @php
                                                        $products = DB::table('products')
                                                            ->where('id', $o->product_id)
                                                            ->first();
                                                        $product_variant = DB::table('product_variants')
                                                            ->where('product_id', $o->product_id)
                                                            ->first();

                                                    @endphp
                                                    <?php
                                                    if ($o->payment_status != '' && $o->payment_status == 'paid') {
                                                        $sStatus = '<span class="badge badge-success fw-normal" style="background-color: #54cc96;">Paid</span>';
                                                    } else {
                                                        $sStatus = '<span class="badge badge-default fw-normal" style="background-color: #eff3f6;color: #0a1832;">Unpaid</span>';
                                                    }
                                                    ?>
                                                    <?php
                                                    
                                                    $status22 = '';
                                                    
                                                    if ($o->status == 'Received') {
                                                        $status22 = 'Order Confirmed';
                                                    } elseif ($o->status == 'Processing') {
                                                        $status22 = 'Unfulfilled Orders';
                                                    } elseif ($o->status == 'Delivered') {
                                                        $status22 = 'Dispatched  Orders';
                                                    } else {
                                                        $status22 = $o->status;
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td>{{ $row }}</tf>
                                                        <td>{{ $o->order_id }}</td>
                                                        <td>@php echo date('d-m-Y', strtotime($o->created_at)); @endphp</td>
                                                        <!-- <td>{{ $o->payment_id }}</td> -->
                                                        <td>{!! $sStatus !!}</td>

                                                        <!--<td>{{ $status22 }}</td>-->
                                                        <td><span
                                                                class="amt_symbol">₹</span>{{ number_format($o->sub_total + $o->deliver_charge - $o->discound_amount - $o->ship_discount_amount, 2) }}
                                                        </td>
                                                        <td>
                                                            <a class="view_order"
                                                                href="{{ url('/order_pdf/') . '/' . $o->id }}">
                                                                View
                                                            </a>
                                                            <?php
                                                                 if($o->status!='Received'){
                                                                 ?>
                                                            <!--<a class="view_order dropdown-item" href="{{ url('/order_tracking/') . '/' . $o->order_id }}">-->
                                                            <!-- <button type="button" class="btn-primary btn-sm" style="padding:5px 15px !important;font-size: 12px !important;text-transform: capitalize;">Track </button>-->
                                                            <!--</a>-->
                                                            <?php } ?>
                                                            <?php

                                                                 if($o->status=='Processing' || $o->status=='Received'){
                                                                 ?>
                                                            <!-----
                                                                          <button type="button" onclick="cancelrequest({{ $o->id }},1);" class="btn-primary btn-sm" style="padding:5px 15px !important;font-size: 12px !important;text-transform: capitalize;">Cancel Request </button>
                                                                        ---->
                                                            <?php } ?>
                                                            <?php
                                                                 if($o->status=='Delivered'){
                                                                 ?>
                                                            <!-----
                                                                          <button type="button" onclick="retrunrequest({{ $o->id }},1);" class="btn-primary btn-sm" style="padding:5px 15px !important;font-size: 12px !important;text-transform: capitalize;">Return Request </button>
                                                                            ---->
                                                            <?php } ?>
                                                        </td>
                                                        <!-- <td><a href="review.html" class="check-btn sqr-btn ">View</a></td> -->
                                                    </tr>
                                                    @php $row++ @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="address-edit" role="tabpanel"
                                aria-labelledby="address-edit-tab">
                                <div class="myaccount-content addressinfo">
                                    <div class="row">
                                        <div class="col-md-6">

                                            <h3>Billing Address</h3>
                                            @if (isset($billing_address))
                                                <address>
                                                    <h6 class="billname">
                                                        {{ $billing_address->first_name . $billing_address->last_name }}
                                                    </h6>
                                                    <p>{{ $billing_address->phone_number }}</p>
                                                    <p>{{ $billing_address->address }}</p>
                                                    <p>{{ $state->state }}</p>
                                                    <p>{{ $billing_address->pincode }}</p>
                                                </address>
                                                <a href="{{ url('edit_address/?type=billing') }}" class="editbtn"><i
                                                        class="fa fa-edit"></i> Edit Address</a>
                                            @endif

                                        </div>
                                        <div class="col-md-6">

                                            <h3>Shipping Address</h3>
                                            @if (isset($shipping_address))
                                                <address>
                                                    <h6 class="billname">
                                                        {{ $shipping_address->sfirst_name . $shipping_address->slast_name }}
                                                    </h6>
                                                    <p>{{ $shipping_address->sphone_number }}</p>
                                                    <p>{{ $shipping_address->saddress }}</p>
                                                    <p>{{ $state->state }}</p>
                                                    <p>{{ $shipping_address->spincode }}</p>
                                                </address>
                                                <a href="{{ url('edit_address/?type=shipping') }}" class="editbtn"><i
                                                        class="fa fa-edit"></i> Edit Address</a>
                                            @endif
                                        </div>

                                    </div>

                                </div>
                            </div>
                            @if (auth()->guard('users')->user())
                                <div class="tab-pane fade" id="account-info" role="tabpanel"
                                    aria-labelledby="account-info-tab">
                                    <div class="myaccount-content">
                                        <h3>Account Details</h3>
                                        <div class="account-details-form">
                                            <form action="#">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="single-input-item">
                                                            <label for="first-name" class="required">Name</label>
                                                            <input type="text" id="user_name"
                                                                value="{{ $account->name }}" />
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- <div class="single-input-item">
                                                        <label for="display-name" class="required">Display Name</label>
                                                        <input type="text" id="display-name" />
                                                    </div> -->
                                                <div class="single-input-item">
                                                    <label for="email" class="required">Email Address</label>
                                                    <input type="email" id="user_email"
                                                        value="{{ $account->email }}" />
                                                </div>
                                                <fieldset>
                                                    <legend>Password change</legend>
                                                    <div class="single-input-item">
                                                        <label for="current-pwd" class="required">Current Password</label>
                                                        <input type="password" id="user_previouspassword"
                                                            name="ltn__name" value="12345">
                                                        <span id="err_prevpassword" style="color:red;display:none;">This
                                                            Field is Required</span>
                                                        <span id="err_msg" style="color:red;display:none;">Enter correct
                                                            password</span>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <label for="new-pwd" class="required">New
                                                                    Password</label>
                                                                <input type="password" id="user_new_password"
                                                                    name="ltn__lastname">
                                                                <span id="err_newpassword"
                                                                    style="color:red;display:none;">This Field is
                                                                    Required</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="single-input-item">
                                                                <label for="confirm-pwd" class="required">Confirm
                                                                    Password</label>
                                                                <input type="password" id="user_confirm_newpassword"
                                                                    name="ltn__lastname">
                                                                <span id="err_confirmnewpassword"
                                                                    style="color:red;display:none;">This Field is
                                                                    Required</span>
                                                                <span id="err_passwordmatch"
                                                                    style="color:red;display:none;">Password not
                                                                    matches</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <div class="single-input-item">
                                                    <button class="default-btn" id="update_userdetails"
                                                        type="button">Save Changes</button>
                                                    <span id="success_msg" style="color:green;display:none;">Details
                                                        updated successfully</span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--== End My Account Area Wrapper ==-->
    </main>
@endsection

<script>
    function cancelrequest(vals, id) {

        var token = $('meta[name="csrf-token"]').attr('content');
        var path = $('meta[name="base_url"]').attr('content') + '/getcancelrequest';

        $.ajax({
            url: path,
            type: "GET",
            data: {
                _token: token,
                order_id: vals,
                cancel: id,

            },
            success: function(response) {
                if (response.data) {
                    alert("Cancel Submit Successfully");
                    location.reload(true);
                }

            }
        });
    }

    function retrunrequest(vals, id) {

        var token = $('meta[name="csrf-token"]').attr('content');
        var path = $('meta[name="base_url"]').attr('content') + '/getreturnrequest';

        $.ajax({
            url: path,
            type: "GET",
            data: {
                _token: token,
                order_id: vals,
                cancel: id,

            },
            success: function(response) {
                if (response.data) {
                    alert("Return Request Submit Successfully");
                    location.reload(true);
                }

            }
        });
    }
</script>

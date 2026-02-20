@extends('backend.layouts.master')

@section('content')

@include('backend.layouts.notification')

<div class="page-content-wrapper ">

    <div class="container-fluid">

        <div class="row">

            <div class="col-sm-12">

                <div class="float-right page-breadcrumb">

                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="#">Home</a></li>

                        <li class="breadcrumb-item"><a href="#">Payment</a></li>

                        <li class="breadcrumb-item active">Payment Method</li>

                    </ol>

                </div>

                <h5 class="page-title">Payment Method</h5>

            </div>

        </div>

        <div class="card m-b-30 card-body">

            <h4 class="card-title font-20 mt-0">Payment Method</h4>

            <!-- <a href="add-product.html" id="add-btn" style="color: #ffffff;"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a> -->

        </div>

        <div class="row">

            <div class="col-12">

                <div class="card m-b-30">

                    <div class="card-body">

                        <!-- <h4 class="mt-0 header-title">Textual inputs</h4>

                                            <p class="text-muted m-b-30 font-14">Here are examples of <code

                                                    class="highlighter-rouge">.form-control</code> applied to each

                                                textual HTML5 <code class="highlighter-rouge">&lt;input&gt;</code> <code

                                                        class="highlighter-rouge">type</code>.</p> -->

                        <form action="{{route('Cash_On_Delivery')}}" method="post">

                            @csrf

                            <div class="card shadow p-3 mb-3">

                                <h6>Cash On Delivery</h6>

                                <div class="row">

                                    <div class="col-md-12">

                                        @if($errors->any())

                                        <div class="alert alert-danger">

                                            <ul>

                                                @foreach ($errors->all() as $error )

                                                <li>

                                                    {{$error}}

                                                </li>

                                                @endforeach

                                            </ul>

                                        </div>

                                        @endif

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Display Cash

                                                On Delivery</label>

                                            <div class="col-sm-8">

                                                <input type="checkbox" name="status" value="on"

                                                    data-toggle="switchbutton" data-onlabel="on" data-offlabel="off"

                                                    data-size="sm" data-onstyle="success" data-offstyle="danger"

                                                    {{ (@$citem[0]['status'] == 'on') ? 'checked' : '' }}>

                                                <!-- <input type="checkbox" name="status" checked data-toggle="toggle" data-size="sm" value="On"> -->

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input"

                                                class="col-sm-6 col-form-label">Attach</label>

                                            <!-- <img src="assets/images/image.png" class="admin-image"> -->

                                            <div class="col-sm-10">

                                                <div class="input-group d-flex align-items-center" style="border: 1px dashed #ced4da; border-radius: 8px; padding: 0 5px; background: #fff; height: 45px;">
                                    <span class="input-group-btn" style="margin-right:0;">
                                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary ripple" style="border-radius: 6px; padding: 6px 12px;">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnail" class="form-control" type="text" value="{{@$citem[0][\'image\']}}" name="image" style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;" placeholder="Select an image...">
                                </div>

                                                <div id="holder" style="margin-top:15px;max-height:100px;"><img src="{{@$citem[0]['image']}}" alt="promo image"style="max-height: 90px;max-width:120px"></div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Enter

                                                Text</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" name="title" type="text"

                                                    value="{{@$citem[0]['title']}}" placeholder="Cash On Delivery" required

                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <input class="form-control" name="payment_type" type="hidden" placeholder=""

                                        required id="example-text-input" value="Cash_On_Delivery">

                                    <input class="form-control" name="payment_id" type="hidden" placeholder=""

                                        id="example-text-input" value="{{@$citem[0]['id']}}">

                                    <div class=" col-md-12 d-flex">

                                        <button class="btn btn-primary" type="submit">Submit</button>&nbsp;

                                    </div>

                                </div>

                            </div>

                        </form>

                        <form action="{{route('Stripe')}}" method="post">

                            @csrf

                            @php

                            $citem=\App\Models\PaymentMethod::where('payment_type','Stripe')->get()

                            @endphp

                            <div class="card shadow p-3 mb-3">

                                <h6>Stripe</h6>

                                <div class="row ">

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Display

                                                Stripe</label>

                                            <div class="col-sm-8">

                                                <input type="checkbox" name="status" value="on"

                                                    data-toggle="switchbutton" data-onlabel="on" data-offlabel="off"

                                                    data-size="sm" data-onstyle="success" data-offstyle="danger"

                                                    {{ (@$citem[0]['status'] == 'on') ? 'checked' : '' }}>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input"

                                                class="col-sm-6 col-form-label">Attach</label>

                                            <!-- <img src="assets/images/image.png" class="admin-image"> -->

                                            <div class="col-sm-10">

                                                <div class="input-group d-flex align-items-center" style="border: 1px dashed #ced4da; border-radius: 8px; padding: 0 5px; background: #fff; height: 45px;">
                                    <span class="input-group-btn" style="margin-right:0;">
                                        <a id="lfm1" data-input="thumbnail1" data-preview="holder" class="btn btn-primary ripple" style="border-radius: 6px; padding: 6px 12px;">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnail1" class="form-control" type="text" value="{{@$citem[0][\'image\']}}" name="image" style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;" placeholder="Select an image...">
                                </div>

                                                <div id="holder" style="margin-top:15px;max-height:100px;"></div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Stripe

                                                Key</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" name="Stripe_Key"

                                                    value="{{@$citem[0]['Stripe_Key']}}" type="text" placeholder="Stripe Key"

                                                    required id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Stripe

                                                Secret</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" name="Stripe_Secret"

                                                    value="{{@$citem[0]['Stripe_Secret']}}" type="text" placeholder="Stripe Secret"

                                                    required id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Enter

                                                Text</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" name="title"

                                                    value="{{@$citem[0]['title']}}" type="text" placeholder="Stripe"

                                                    required id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <input class="form-control" name="payment_type" type="hidden" placeholder=""

                                        required id="example-text-input" value="Stripe">

                                    <input class="form-control" name="payment_id" type="hidden" placeholder=""

                                        id="example-text-input" value="{{@$citem[0]['id']}}">

                                    <div class=" col-md-12 d-flex">

                                        <button class="btn btn-primary" type="submit">Submit</button>&nbsp;

                                    </div>

                                </div>

                            </div>

                        </form>

                        <form action="{{route('Paypal')}}" method="post">

                            @csrf

                            @php

                            $citem=\App\Models\PaymentMethod::where('payment_type','Paypal')->get()

                            @endphp

                            <div class="card shadow p-3 mb-3">

                                <h6>Paypal</h6>

                                <div class="row mt-5">

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Display

                                                Paypal</label>

                                            <div class="col-sm-8">

                                                <input type="checkbox" name="status" value="on"

                                                    data-toggle="switchbutton" data-onlabel="on" data-offlabel="off"

                                                    data-size="sm" data-onstyle="success" data-offstyle="danger"

                                                    {{ (@$citem[0]['status'] == 'on') ? 'checked' : '' }}>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input"

                                                class="col-sm-6 col-form-label">Attach</label>

                                            <!-- <img src="assets/images/image.png" class="admin-image"> -->

                                            <div class="col-sm-10">

                                                <div class="input-group d-flex align-items-center" style="border: 1px dashed #ced4da; border-radius: 8px; padding: 0 5px; background: #fff; height: 45px;">
                                    <span class="input-group-btn" style="margin-right:0;">
                                        <a id="lfm2" data-input="thumbnail2" data-preview="holder" class="btn btn-primary ripple" style="border-radius: 6px; padding: 6px 12px;">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnail2" class="form-control" type="text" value="{{@$citem[0][\'image\']}}" name="image" style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;" placeholder="Select an image...">
                                </div>

                                                <div id="holder" style="margin-top:15px;max-height:100px;"></div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Paypal

                                                Client ID</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text"

                                                    value="{{@$citem[0]['Paypal_Client_ID']}}" placeholder="Client ID" required

                                                    name="Paypal_Client_ID" id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Paypal

                                                Client Secret</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text"

                                                    value="{{@$citem[0]['Paypal_Client_Secret']}}" placeholder="Client Secret"

                                                    required name="Paypal_Client_Secret" id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <!-- <div class="col-md-4 mt-4">

                                        <div class="custom-control custom-checkbox">

                                            <input type="checkbox" name="customCheck1" class="custom-control-input" id="customCheck1"

                                                data-parsley-multiple="groups" data-parsley-mincheck="2">

                                            <label class="custom-control-label" for="customCheck1">Paypal Check

                                                Sandbox</label>

                                        </div>

                                    </div> -->

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Enter

                                                Text</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text" placeholder="Paypal" required

                                                    name="title" value="{{@$citem[0]['title']}}"

                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <input class="form-control" name="payment_type" type="hidden" placeholder=""

                                        required id="example-text-input" value="Paypal">

                                    <input class="form-control" name="payment_id" type="hidden" placeholder=""

                                        id="example-text-input" value="{{@$citem[0]['id']}}">

                                    <div class=" col-md-12 d-flex">

                                        <button class="btn btn-primary" type="submit">Submit</button>&nbsp;

                                    </div>

                                </div>

                            </div>

                        </form>

                        <form action="{{route('RazorPay')}}" method="post">

                            @csrf

                            @php

                            $citem=\App\Models\PaymentMethod::where('payment_type','RazorPay')->get()

                            @endphp

                            <div class="card shadow p-3 mb-3">

                                <h6>RazorPay</h6>

                                <div class="row ">

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Display

                                            RazorPay</label>

                                            <div class="col-sm-8">

                                                <input type="checkbox" name="status" value="on"

                                                    data-toggle="switchbutton" data-onlabel="on" data-offlabel="off"

                                                    data-size="sm" data-onstyle="success" data-offstyle="danger"

                                                    {{ (@$citem[0]['status'] == 'on') ? 'checked' : '' }}>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input"

                                                class="col-sm-6 col-form-label">Attach</label>

                                            <!-- <img src="assets/images/image.png" class="admin-image"> -->

                                            <div class="col-sm-10">

                                                <div class="input-group d-flex align-items-center" style="border: 1px dashed #ced4da; border-radius: 8px; padding: 0 5px; background: #fff; height: 45px;">
                                    <span class="input-group-btn" style="margin-right:0;">
                                        <a id="lfm3" data-input="thumbnail3" data-preview="holder" class="btn btn-primary ripple" style="border-radius: 6px; padding: 6px 12px;">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnail3" class="form-control" type="text" value="{{@$citem[0][\'image\']}}" name="image" style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;" placeholder="Select an image...">
                                </div>

                                                <div id="holder" style="margin-top:15px;max-height:100px;"><img src="{{@$citem[0]['image']}}" alt="promo image"style="max-height: 90px;max-width:120px"></div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">RazorPay

                                                Key</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text"

                                                    value="{{@$citem[0]['RazorPay_Key']}}" name="RazorPay_Key"

                                                    placeholder="RazorPay Key" required id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">RazorPay

                                            Secret Key</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text"

                                                    value="{{@$citem[0]['RazorPay_Secret_Key']}}" name="RazorPay_Secret_Key"

                                                    placeholder="RazorPay Secret Key" required id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Enter

                                                Text</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text"

                                                    value="{{@$citem[0]['title']}}" name="title"

                                                    placeholder="RazorPay" required id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <input class="form-control" name="payment_type" type="hidden" placeholder=""

                                        required id="example-text-input" value="RazorPay">

                                    <input class="form-control" name="payment_id" type="hidden" placeholder=""

                                        id="example-text-input" value="{{@$citem[0]['id']}}">

                                    <div class=" col-md-12 d-flex">

                                        <button class="btn btn-primary" type="submit">Submit</button>&nbsp;

                                    </div>

                                </div>

                            </div>

                        </form>

                        <form action="{{route('Display_Paytm')}}" method="post">

                            @csrf

                            @php

                            $citem=\App\Models\PaymentMethod::where('payment_type','Display_Paytm')->get()

                            @endphp

                            <div class="card shadow p-3 mb-3">

                                <h6>Display Paytm</h6>

                                <div class="row ">

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Display

                                            Paytm</label>

                                            <div class="col-sm-8">

                                                <input type="checkbox" name="status" value="on"

                                                    data-toggle="switchbutton" data-onlabel="on" data-offlabel="off"

                                                    data-size="sm" data-onstyle="success" data-offstyle="danger"

                                                    {{ (@$citem[0]['status'] == 'on') ? 'checked' : '' }}>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input"

                                                class="col-sm-6 col-form-label">Attach</label>

                                            <!-- <img src="assets/images/image.png" class="admin-image"> -->

                                            <div class="col-sm-10">

                                                <div class="input-group d-flex align-items-center" style="border: 1px dashed #ced4da; border-radius: 8px; padding: 0 5px; background: #fff; height: 45px;">
                                    <span class="input-group-btn" style="margin-right:0;">
                                        <a id="lfm4" data-input="thumbnail4" data-preview="holder" class="btn btn-primary ripple" style="border-radius: 6px; padding: 6px 12px;">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnail4" class="form-control" type="text" value="{{@$citem[0][\'image\']}}" name="image" style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;" placeholder="Select an image...">
                                </div>

                                                <div id="holder" style="margin-top:15px;max-height:100px;"><img src="{{@$citem[0]['image']}}" alt="promo image"style="max-height: 90px;max-width:120px"></div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Paytm

                                                Mercent</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text"

                                                    value="{{@$citem[0]['Paytm_Mercent']}}" name="Paytm_Mercent"

                                                    placeholder="Paytm Mercent" required id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Paytm

                                                Website</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="url"

                                                    value="{{@$citem[0]['Paytm_Website']}}" name="Paytm_Website"

                                                    placeholder="Paytm Website" required id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Paytm

                                                Industry</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text"

                                                    value="{{@$citem[0]['Paytm_Industry']}}" name="Paytm_Industry"

                                                    placeholder="Paytm Industry" required id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Paytm Is

                                                Paytm</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" type="text"

                                                    value="{{@$citem[0]['Paytm_Is_Paytm']}}" name="Paytm_Is_Paytm"

                                                    placeholder="Paytm Is Paytm" required id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Paytm Paytm

                                                Mode</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" name="Paytm_Paytm_Mode"

                                                    value="{{@$citem[0]['Paytm_Paytm_Mode']}}" type="text"

                                                    placeholder="Paytm Paytm Mode" required id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Enter

                                                Text</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" name="title"

                                                    value="{{@$citem[0]['title']}}" type="text" placeholder="Paytm"

                                                    required id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <input class="form-control" name="payment_type" type="hidden" placeholder=""

                                        required id="example-text-input" value="Display_Paytm">

                                    <input class="form-control" name="payment_id" type="hidden" placeholder=""

                                        id="example-text-input" value="{{@$citem[0]['id']}}">

                                    <div class=" col-md-12 d-flex">

                                        <button class="btn btn-primary" type="submit">Submit</button>&nbsp;

                                    </div>

                                </div>

                            </div>

                        </form>

                        <form action="{{route('SSL_Commerz')}}" method="post">

                            @csrf

                            @php

                            $citem=\App\Models\PaymentMethod::where('payment_type','SSL_Commerz')->get()

                            @endphp

                            <div class="card shadow p-3 mb-3">

                                <h6>SSL Commerz</h6>

                                <div class="row ">

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Display

                                                sslcommerz</label>

                                            <div class="col-sm-8">

                                                <input type="checkbox" name="status" value="on"

                                                    data-toggle="switchbutton" data-onlabel="on" data-offlabel="off"

                                                    data-size="sm" data-onstyle="success" data-offstyle="danger"

                                                    {{ (@$citem[0]['status'] == 'on') ? 'checked' : '' }}>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input"

                                                class="col-sm-6 col-form-label">Attach</label>

                                            <!-- <img src="assets/images/image.png" class="admin-image"> -->

                                            <div class="col-sm-10">

                                                <div class="input-group d-flex align-items-center" style="border: 1px dashed #ced4da; border-radius: 8px; padding: 0 5px; background: #fff; height: 45px;">
                                    <span class="input-group-btn" style="margin-right:0;">
                                        <a id="lfm5" data-input="thumbnail5" data-preview="holder" class="btn btn-primary ripple" style="border-radius: 6px; padding: 6px 12px;">
                                            <i class="fa fa-picture-o"></i> Choose
                                        </a>
                                    </span>
                                    <input id="thumbnail5" class="form-control" type="text" value="{{@$citem[0][\'image\']}}" name="image" style="border: none !important; box-shadow: none !important; background: transparent !important; margin-left: 10px; height: 100% !important; padding: 0;" placeholder="Select an image...">
                                </div>

                                                <div id="holder" style="margin-top:15px;max-height:100px;"></div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">SSLCommerz

                                                Store Id</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" name="SSLCommerz_Store_Id"

                                                    value="{{@$citem[0]['SSLCommerz_Store_Id']}}" type="text"

                                                    placeholder="SSLCommerz Store Id" required id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">SSLCommerz

                                                Store Password</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" name="SSLCommerz_Store_Password"

                                                    value="{{@$citem[0]['SSLCommerz_Store_Password']}}" type="text"

                                                    placeholder="SSLCommerz Store Password" required id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">SSLCommerz

                                                Sandbox Check</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" name="SSLCommerz_Sandbox_Check"

                                                    value="{{@$citem[0]['SSLCommerz_Sandbox_Check']}}" type="text"

                                                    placeholder="SSLCommerz Sandbox Check" required id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group row">

                                            <label for="example-text-input" class="col-sm-4 col-form-label">Enter

                                                Text</label>

                                            <div class="col-sm-8">

                                                <input class="form-control" name="title" type="text"

                                                    value="{{@$citem[0]['title']}}" placeholder="SSLCommerz" required

                                                    id="example-text-input">

                                            </div>

                                        </div>

                                    </div>

                                    <input class="form-control" name="payment_type" type="hidden" placeholder=""

                                        required id="example-text-input" value="SSL_Commerz">

                                    <input class="form-control" name="payment_id" type="hidden" placeholder=""

                                        id="example-text-input" value="{{@$citem[0]['id']}}">

                                    <div class=" col-md-12 d-flex">

                                        <button class="btn btn-primary" type="submit">Submit</button>&nbsp;

                                    </div>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div> <!-- end col -->

        </div> <!-- end row -->

    </div><!-- container fluid -->

</div> <!-- Page content Wrapper -->

@endsection

@section('scripts')

<script>

$(document).ready(function() {

    $('form').parsley();

});

</script>

<script src="{{asset('/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>

<script>

$('#lfm,#lfm1,#lfm2,#lfm3,#lfm4,#lfm5').filemanager('image');

</script>

<script>

$(document).ready(function() {

    if ($("#elm1").length > 0) {

        tinymce.init({

            selector: "textarea#elm1",

            theme: "modern",

            height: 300,

            plugins: [

                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",

                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",

                "save table contextmenu directionality emoticons template paste textcolor"

            ],

            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",

            style_formats: [{

                    title: 'Bold text',

                    inline: 'b'

                },

                {

                    title: 'Red text',

                    inline: 'span',

                    styles: {

                        color: '#ff0000'

                    }

                },

                {

                    title: 'Red header',

                    block: 'h1',

                    styles: {

                        color: '#ff0000'

                    }

                },

                {

                    title: 'Example 1',

                    inline: 'span',

                    classes: 'example1'

                },

                {

                    title: 'Example 2',

                    inline: 'span',

                    classes: 'example2'

                },

                {

                    title: 'Table styles'

                },

                {

                    title: 'Table row 1',

                    selector: 'tr',

                    classes: 'tablerow1'

                }

            ]

        });

    }

});

</script>

<script>

$('input[name=toogle]').change(function() {

    // var mode = $(this).prop('checked');

    var id = $(this).val();

    // alert(id);

    $.ajax({

        url: "{{route('payment_status')}}",

        type: "POST",

        data: {

            _token: '{{csrf_token()}}',

            mode: mode,

            id: id,

        },

        success: function(response) {

            console.log(response.status);

        }

    })

});

</script>

<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

@endsection

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
    </style>

    <main class="main-content">
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
        <!--== Start Page Header Area Wrapper ==-->
        <section class="page-header-area pt-2 pb-2" data-bg-color="#FFF3DA">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <div class="page-header-st3-content text-center text-md-start">
                            <ol class="breadcrumb justify-content-center justify-content-md-start">
                                <li class="breadcrumb-item"><a class="text-dark" href="{{ url('index') }}">Home</a></li>
                                <li class="breadcrumb-item active text-dark" aria-current="page">Cancellation Policy</li>
                            </ol>
                            <h2 class="page-header-title">Cancellation Policy</h2>
                        </div>
                    </div>
                    <!-- <div class="col-md-7">
                                <h5 class="showing-pagination-results mt-5 mt-md-9 text-center text-md-end">Showing 06 Results</h5>
                            </div> -->
                </div>
            </div>
        </section>
        <!--== End Page Header Area Wrapper ==-->

        <!--== Start Product Area Wrapper ==-->
        <section class="">
            <div class="container">
                <!-- <div class="row p-3">
                            <h2 class="page-header-title text-center p-3">Terms & Conditions</h2>
                            <div class="policy-list">
                            <h5>CANCELLATION POLICY</h5>
                        </div> -->
                <div class="policy-list-1">
                    <h5>Cancellation before shipment:</h5>
                    <li>If the order or the item(s) that you want to cancel have not been shipped yet, you can write to our
                        customer support team at enquiry@baptisthealthcare.in or call us on +91 8148148487.</li>
                    <li class="page-header-title">In such cases, the order will be cancelled and the money will be refunded
                        to you within 24-48
                        business hours after the cancellation request. </li>
                </div>
                <div class="policy-list-1">
                    <h5>Cancellation post shipment:</h5>
                    <li class="page-header-title">If you wish to cancel an order that has been shipped but has not yet been
                        delivered, please get in
                        touch with our Customer Support team at enquiry@baptisthealthcare.in </li>
                    <li>In case you have cancelled an order, which has already been handed over to the courier company on
                        our end, they may still attempt delivery. Kindly do not accept the delivery of the order. </li>
                    <li>Once we receive the product(s) back and verify its packaging/condition, we will refund your money
                        within 24-48 business hours. </li>
                    <h5>How will I get refunded for the cancelled orders and how long will this process take?</h5>
                    <li>In case of cancellation before shipment, we process the refund within 24-48 business hours after
                        receiving the cancellation request.</li>
                    <li>In case of cancellation once the shipment has already been dispatched or if it is being returned, we
                        process the refund once the products have been received and verified at our warehouse. </li>
                    <li>For payments done through credit/debit cards or net banking, the refund will be processed to the
                        same account from which the payment was made within 24-48 business hours of us receiving the
                        products back. It may take 2-3 additional business days for the amount to reflect in your account.
                    </li>
                    <li>For cash on delivery transactions, we will initiate a bank transfer against the refund amount for
                        the
                        billing details shared by you. This process will be completed within 24-48 business hours of us
                        receiving the products back and your bank details on email. It will take an additional 2-3 business
                        days for the amount to reflect in your account. </li>
                    <li>What if I used discount vouchers during the time of payment and I have to cancel my order? </li>
                    <li>Discount vouchers are intended for one-time use only and shall be treated as used even if you cancel
                        the order. </li>
                </div>
                <div class="policy-list-1">
                    <h5 class="page-header-title">RETURNS, REPLACEMENTS, AND REFUNDS </h5>
                    <h5>How do I return an item purchased on www.tuliacosmetics.com? </h5>
                    <li class="page-header-title">Tulia offers its customers an ‘Easy return policy, wherein you can raise a
                        return/exchange request for a product within 5 days of its delivery. We also accept partial returns
                        wherein you can raise a return
                        request for one or all products in your order. </li>
                    <p>Step 1: Contact our Customer Support team via email (enquiry@baptisthealthcare.in) within 5
                        business days of receiving the order. </p>
                    <p>Step 2: Provide us with your order ID details and your request to return/replace/refund your order.
                        Kindly email an image of the product and the invoice for our reference. </p>
                    <p>Step 3: We will pick up the products within 2-4 business days. We will initiate the refund or
                        replacement process only if the products are received by us in their original packaging with their
                        seals, labels, and barcodes intact. </p>
                    <li class="page-header-title">Note: If it is a case of replacement, it is subject to the availability of
                        stock. In cases when a
                        replacement may not be available, we will refund you the full amount. Kindly refer to the next
                        question for exclusions to refunds. </li>
                </div>
                <div class="policy-list-1">
                    <h5 class="page-header-title">WHICH ARE THE ITEMS THAT CANNOT BE RETURNED/EXCHANGED? </h5>
                    <li class="page-header-title">Returns will not be accepted under the following conditions: </li>
                    <li class="page-header-title">The product is damaged due to misuse/overuse. </li>
                    <li class="page-header-title">Returned without original packaging including price tags, labels, original
                        packing, freebies, and other accessories, or if the original packaging is damaged. </li>
                    <li class="page-header-title">The serial number has tampered. </li>
                    <li class="page-header-title">Defective products that are covered under Seller/Manufacturer’s warranty.
                    </li>
                    <li class="page-header-title">The product is used or altered. </li>
                    <li class="page-header-title">If a request is initiated after 5 business days of order delivery. </li>
                    <li class="page-header-title">Free product provided by the brand.</li>
                </div>
                <div class="policy-list-1">
                    <h5>Categories not eligible for return: </h5>
                    <li class="page-header-title">Innovative Products cannot be returned since they are available during
                        select promotions and
                        ordered on demand. </li>
                    <li class="page-header-title">Personal care appliances cannot be returned due to hygiene issues. </li>
                    <li class="page-header-title">Please note: For certain marketing campaigns or mega sale periods, special
                        return/exchange/refund
                        rules may apply. Information regarding this is visible on the promotion banner. For any
                        clarification, please feel free to contact our customer care.</li>
                    <h5>I have received a damaged or defective item/wrong product in my order, how should I proceed?</h5>
                    <li class="page-header-title">Our shipments go through rigorous quality check processes before they
                        leave our warehouse. However, in the rare case that your product is damaged during shipment or
                        transit, you can request a replacement or cancellation and refund. </li>
                    <li class="page-header-title">If you have received an item in a damaged/defective condition or have been
                        sent a wrong product, you can follow a few simple steps to initiate your return/refund within 5 days
                        of receiving the order: </li>
                    <p>Step 1: Contact our Customer Support team via email (enquiry@baptisthealthcare.in) within 5 business
                        days of receiving the order. </p>
                    <p>Step 2: Provide us with your order ID details and your request to return/replace/refund the
                        defective/wrong items in your order. Kindly share an image of the product and the invoice for our
                        reference.</p>
                    <p>Step 3: We will pick up the products within 2-4 business days. We will initiate the refund or
                        replacement process only if the products are received by us in their original packaging with their
                        seals, labels, and barcodes intact.</p>
                    <li class="page-header-title">Note: If it is a case of replacement, it is subject to the availability of
                        stock. In case that a replacement may not be available, we will refund you the full amount.</li>
                    <h5>Do I have to return the free product/gift when I return a product?</h5>
                    <li class="page-header-title">Yes. The free product/gift is included as a part of the item order and
                        needs to be returned along with the originally delivered product.</li>
                    <h5>Can I return part of my order?</h5>
                    <li class="page-header-title">Yes. A return can be created at the item level and if you have ordered
                        multiple items, you can initiate a return/replacement/refund for any individual item. However, any
                        product being returned needs to be returned in full including all components as well as any
                        complimentary gifts or products which came along with it.</li>
                    <h5>How will I get refunded for the returned orders and how long will this process take?</h5>
                    <li class="page-header-title">In case of a return/replacement/refund, we process the refund once the
                        products have been received and verified at our warehouse.</li>
                    <li class="page-header-title">For payments done through credit/debit cards or net banking, the refund
                        will be processed to the same account from which the payment was made within 24-48 business hours of
                        us receiving the products back. It may take 2-3 additional business days for the amount to reflect
                        in your account.</li>
                    <li class="page-header-title">For cash on delivery transactions, we will initiate a bank transfer
                        against the refund amount against the billing details shared by you. This process will be completed
                        within 24-48 business hours of us receiving the products back and your bank details on email. It
                        will take an additional 2-3 business days for the amount to reflect in your account.</li>
                </div>

            </div>
            </div>
        </section>
        <br>
        <!--== End Product Area Wrapper ==-->

        <!--== Start Product Banner Area Wrapper ==-->
        <!-- <section>
                    <div class="container"> -->
        <!--== Start Product Category Item ==-->
        <!-- <a href="product.html" class="product-banner-item pb-5">
                            <img src="assets/images/shop/banner/7.webp" width="1170" height="240" alt="Image-HasTech">
                        </a> -->
        <!--== End Product Category Item ==-->
        <!-- </div>
                </section> -->
        <!--== End Product Banner Area Wrapper ==-->

    </main>
@endsection

@section('script')
@endsection

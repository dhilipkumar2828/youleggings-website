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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

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

        <section class="page-header-area">

            <div class="container">

                <!-- style="margin-top:100px;" -->

                <div class="row">

                    <div class="col-md-6">

                        <div class="page-header-st3-content">

                            <h2 class="page-header-title">Contact Us</h2>

                        </div>

                    </div>

                    <div class="col-md-6 justify-content-end d-flex">

                        <div class="page-header-st3-content">

                            <ol class="breadcrumb justify-content-center justify-content-md-start">

                                <li class="breadcrumb-item"><a class="text-dark" href="{{ url('index') }}">Home</a></li>

                                <li class="breadcrumb-item active text-dark" aria-current="page">Contact Us</li>

                             </ol>

                        </div>

                    </div>

                </div>

            </div>

        </section>

        <div style="background:var(--white-7)" class="py-4 mb-4">

            <div class="container mb-4">

                <div class="row">

                    <div class="contact-heading">

                        <h3 class="text-center font-500 mb-4 m-mb-3 animated fadeIn">Get in Touch</h3>

                    </div>

                    <div class="col-lg-7  contact-content">

                        <p>We're delighted to assist you with any inquiries you may have about our exquisite collections of
                            clothing and accessories. Our commitment is to provide exceptional service and ensure your
                            experience with You Leggings is enjoyable. Please reach out to us if you have any questions or
                            need assistance. We look forward to hearing from you!</p>

                    </div>

                    <div class="col-lg-5 login-form">

                        <div class="card-body border loginheight m-mt-5" style="background:#fff">

                            <div class="tab-content mt-4" id="myTabContent">

                                <!-- user tab -->

                                <div class="tab-pane fade show active" id="userlogin" role="tabpanel"
                                    aria-labelledby="user-tab">

                                    <form id="contactForm" class="ltn__form-box contact-form-box" action="{{ route('contact_form') }}" method="POST">
                                        @csrf
                                        <div class="mb-4">

                                            <label class="form-label">Name</label>

                                            <input type="text" id="" placeholder="" class="form-control"
                                                name="name" required>

                                            <span class="text-danger name_err"></span>

                                        </div>

                                        <div class="mb-4">

                                            <label class="form-label">Mobile Number </label>

                                            <input type="tel" id="inputphone" placeholder="" class="form-control"
                                                name="phone" required>

                                            <span class="text-danger phone_err"></span>

                                        </div>

                                        <div class="mb-4">

                                            <label class="form-label">Email address</label>

                                            <input type="email" id="inputemail" placeholder="" class="form-control"
                                                name="email" required>

                                            <span class="text-danger email_err"></span>

                                        </div>

                                        <div class="mb-4">

                                            <div class="form-group">

                                                <label for="exampleFormControlTextarea1 " class="mb-2">Message</label>

                                                <textarea class="form-control" name="message" id="exampleFormControlTextarea1" required rows="3"></textarea>

                                            </div>

                                        </div>

                                        <div class="mb-4">

                                            <button type="submit" class="theme-btn-1 btn ">Send Message</button>

                                        </div>
                                    </form>

                                    <!-- user tab -->

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class=" ">

            <div class="container my-5 ">

                <div class="row">

                    <div class="col-lg-4 m-mb-1 t-mb-1">
                        <div class="inquiries-card">
                            <img src="{{ asset('frontend/img/icons/mail.jpg') }}" width="70" class="m-3">
                            <div class="inquiries-card-inner"><a class="" href="mailto:{{ $settings->email ?? 'youleggings@gmail.com' }}"
                                    rel="nofollow">{{ $settings->email ?? 'youleggings@gmail.com' }}</a> </div>
                        </div>
                    </div>

                    <div class="col-lg-4 m-mb-1 t-mb-1">
                        <div class="inquiries-card">
                            <img src="{{ asset('frontend/img/icons/location.jpg') }}" width="70" class="m-3">
                            <div class="inquiries-card-inner">
                                {!! $settings->address ?? '5/4, Surya Nagar, 2nd Street, Bridgeway Colony Extn, Tirupur - 641607' !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 m-mb-1 t-mb-1">
                        <div class="inquiries-card">
                            <img src="{{ asset('frontend/img/icons/phone.jpg') }}" width="70" class="m-3">
                            <div class="inquiries-card-inner"><a class="phone" href="tel:{{ $settings->phone ?? '+91 740143 24967' }}">{{ $settings->phone ?? '+91 740143 24967' }}</a> </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </main>
@endsection

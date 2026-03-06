@extends('frontend.layouts.arrivals_products_master_new')

@section('content')
<main class="main-content">
    <!-- PAGE HEADER -->
    <section class="page-header-area py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="fw-bold mb-0">Terms & Conditions</h2>
                </div>
                <div class="col-md-6 text-md-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 justify-content-md-end">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Terms & Conditions</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- TERMS CONTENT -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="policy-content bg-white p-4 p-md-5 rounded shadow-sm">
                        @if(isset($terms_con) && $terms_con->description)
                            <div class="dynamic-html-content">
                                {!! $terms_con->description !!}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <h4 class="text-muted">Terms & Conditions content is currently unavailable.</h4>
                                <p>Please check back later or contact us for assistance.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('script')
@endsection

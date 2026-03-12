@extends('frontend.layouts.app')

@section('title', 'Terms & Conditions | You Leggings')

@section('content')
<section class="section policy-page">
    <div class="policy-hero">
        <div class="container">
            <span class="section-subtitle">Legal</span>
            <h1 class="section-title">Terms & Conditions</h1>
            <p class="hero-desc">Please read our terms of service before using our website.</p>
        </div>
    </div>

    <div class="container">
        <div class="policy-content card">
            @if($content && $content->description)
                {!! $content->description !!}
            @else
                <div class="empty-state">
                    <p>Terms & Conditions content is currently being updated. Please check back later.</p>
                </div>
            @endif
        </div>
    </div>
</section>

<style>
.policy-page {
    padding-top: 120px;
    background-color: var(--grey-50);
}

.policy-hero {
    text-align: center;
    padding: 60px 0;
    background: linear-gradient(135deg, var(--primary-50) 0%, #fff 100%);
    margin-bottom: 40px;
}

.policy-content {
    background: #fff;
    padding: 60px;
    border-radius: 24px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    line-height: 1.8;
    color: var(--grey-700);
}

.policy-content h2 {
    color: var(--grey-900);
    margin-top: 40px;
    margin-bottom: 20px;
    font-size: 1.8rem;
}

.policy-content p {
    margin-bottom: 20px;
}

.hero-desc {
    max-width: 600px;
    margin: 20px auto 0;
    color: var(--grey-600);
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .policy-content {
        padding: 30px;
    }
}
</style>
@endsection

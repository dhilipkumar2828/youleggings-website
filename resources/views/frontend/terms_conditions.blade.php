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
            <h2>1. Introduction</h2>
            <p>Welcome to You Leggings. By accessing our website and using our services, you agree to be bound by the following terms and conditions. If you do not agree with any part of these terms, please do not use our website.</p>

            <h2>2. Use of the Site</h2>
            <p>You may use our site for lawful purposes only. You must not use the site in any way that causes, or may cause, damage to the site or impairment of the availability or accessibility of the site.</p>

            <h2>3. Product Information and Pricing</h2>
            <p>We strive to provide accurate product descriptions and pricing information. However, errors may occur. In the event that an item is listed at an incorrect price or with incorrect information, we reserve the right to cancel any orders placed for that item.</p>

            <h2>4. Orders and Payments</h2>
            <p>All orders are subject to acceptance and availability. We reserve the right to refuse or cancel any order for any reason. Payment must be made through our secure checkout process using the available payment methods.</p>

            <h2>5. Intellectual Property</h2>
            <p>The content on this website, including text, graphics, logos, and images, is the property of You Leggings and is protected by copyright and other intellectual property laws. You may not reproduce, distribute, or display any part of this site without our prior written consent.</p>

            <h2>6. Limitation of Liability</h2>
            <p>You Leggings shall not be liable for any direct, indirect, incidental, or consequential damages resulting from the use or inability to use our website or services, even if we have been advised of the possibility of such damages.</p>

            <h2>7. Governing Law</h2>
            <p>These terms and conditions are governed by and construed in accordance with the laws of India. Any disputes arising out of or in connection with these terms shall be subject to the exclusive jurisdiction of the courts in Tamil Nadu.</p>

            <h2>8. Contact Information</h2>
            <p>If you have any questions about these Terms & Conditions, please contact us at support@youleggings.com.</p>
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

@extends('frontend.layouts.app')

@section('title', 'Privacy Policy | You Leggings')

@section('content')
<section class="section policy-page">
    <div class="policy-hero">
        <div class="container">
            <span class="section-subtitle">Legal</span>
            <h1 class="section-title">Privacy Policy</h1>
            <p class="hero-desc">Your privacy is important to us. Learn how we handle your data.</p>
        </div>
    </div>

    <div class="container">
        <div class="policy-content card">
            <h2>1. Information We Collect</h2>
            <p>At You Leggings, we collect information that you provide directly to us. This includes your name, email address, shipping address, billing address, and payment information when you make a purchase or create an account. We also collect data about your interactions with our website through cookies and similar technologies.</p>

            <h2>2. How We Use Your Information</h2>
            <p>We use the information we collect to:</p>
            <ul>
                <li>Process and fulfill your orders, including sending emails to confirm your order status and shipment.</li>
                <li>Communicate with you about products, services, offers, and promotions.</li>
                <li>Improve our website, products, and overall customer experience.</li>
                <li>Protect against, identify, and prevent fraud and other unlawful activity.</li>
            </ul>

            <h2>3. Information Sharing and Disclosure</h2>
            <p>We do not sell, trade, or otherwise transfer your personally identifiable information to outside parties. This does not include trusted third parties who assist us in operating our website, conducting our business, or servicing you, so long as those parties agree to keep this information confidential.</p>

            <h2>4. Data Security</h2>
            <p>We implement a variety of security measures to maintain the safety of your personal information. Your personal information is contained behind secured networks and is only accessible by a limited number of persons who have special access rights to such systems.</p>

            <h2>5. Cookies and Similar Technologies</h2>
            <p>We use cookies to help us remember and process the items in your shopping cart, understand and save your preferences for future visits, and compile aggregate data about site traffic and site interaction so that we can offer better site experiences and tools in the future.</p>

            <h2>6. Changes to Our Privacy Policy</h2>
            <p>We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page. You are advised to review this Privacy Policy periodically for any changes.</p>

            <h2>7. Contact Us</h2>
            <p>If there are any questions regarding this privacy policy, you may contact us using our contact form or via email at support@youleggings.com.</p>
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

.policy-content ul {
    margin-bottom: 20px;
    padding-left: 20px;
}

.policy-content li {
    margin-bottom: 10px;
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

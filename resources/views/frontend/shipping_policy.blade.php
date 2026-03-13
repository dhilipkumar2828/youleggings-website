@extends('frontend.layouts.app')

@section('title', 'Shipping Policy | You Leggings')

@section('content')
<section class="section policy-page">
    <div class="policy-hero">
        <div class="container">
            <span class="section-subtitle">Support</span>
            <h1 class="section-title">Shipping Policy</h1>
            <p class="hero-desc">Learn about our shipping rates, methods, and delivery timelines.</p>
        </div>
    </div>

    <div class="container">
        <div class="policy-content card">
            <h2>1. Shipping Locations</h2>
            <p>We offer reliable shipping services to most locations across India. Whether you're in a metropolitan city or a smaller town, we strive to bring You Leggings right to your doorstep.</p>

            <h2>2. Processing Time</h2>
            <p>Orders are typically processed and prepared for shipment within 1-2 business days (excluding Sundays and public holidays) after receiving your order confirmation email.</p>

            <h2>3. Delivery Timelines</h2>
            <ul>
                <li><strong>Metro Cities:</strong> 3-5 business days.</li>
                <li><strong>Rest of India:</strong> 5-7 business days.</li>
            </ul>
            <p>Please note that delivery times are estimates and may vary due to external factors like weather conditions, courier delays, or peak seasons.</p>

            <h2>4. Shipping Charges</h2>
            <p>Shipping charges for your order will be calculated and displayed at checkout. We may offer free shipping on orders above a certain value as part of ongoing promotions.</p>

            <h2>5. Order Tracking</h2>
            <p>Once your order has shipped, you will receive an email notification with a tracking number that you can use to check its status. Tracking information may take up to 24 hours to become active.</p>

            <h2>6. Returns and Exchanges</h2>
            <p>We want you to love your leggings. If you receive a damaged or incorrect item, please contact us within 7 days of delivery. For more details, please refer to our full Returns Policy.</p>

            <h2>7. Contact Information</h2>
            <p>If you have any questions about your shipment, please reach out to us at support@youleggings.com.</p>
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

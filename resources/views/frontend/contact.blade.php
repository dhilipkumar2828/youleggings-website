@extends('frontend.layouts.app')

@section('title', 'Contact Us | You Leggings')

@section('content')
  <!-- Contact Page -->
  <section class="section page-view contact-page" id="contact-page" style="display: block;">
    <div class="page-main contact-main" style="background-color: #9f9f9f;">
      <div class="hero-overlay"></div>
      <div
        style="position: absolute; inset: 0; background-image: url('{{ ($contact && $contact->photo) ? image_url($contact->photo) : asset('frontend/images/bg-less/_DSC8175-Photoroom.png') }}'); background-size: auto 110%; background-position: right 100% top 50%; background-repeat: no-repeat; transform: scaleX(-1); z-index: 2;">
      </div>
      <div class="container page-main-content">
        <span class="hero-subtitle">Get In Touch</span>
        <h1 class="hero-title">{!! nl2br(e($contact->title ?? "We'd Love to \nHear From You")) !!}</h1>
      </div>
    </div>

    <div class="container page-body">
      <div class="contact-grid">
        <div class="contact-panel">
          <span class="section-subtitle">Get in Touch</span>
          <h2 class="section-title">We're delighted to assist you</h2>
          <p class="section-desc">We're delighted to assist you with any inquiries you may have about our exquisite collections of clothing and accessories. We look forward to hearing from you!</p>
          <ul class="contact-list" style="list-style: none; padding: 0;">
            <li><strong>Support Hours:</strong> Monday to Saturday, 9:30 AM - 7:00 PM</li>
            <li><strong>Response Time:</strong> We usually respond within 24 hours</li>
            <li><strong>Order Help:</strong> Share your order number for faster support</li>
            <li><strong>Bulk Enquiries:</strong> Retail and wholesale requests are welcome</li>
          </ul>
        </div>
        <form class="contact-form validate" action="{{ route('contact.submit') }}" method="POST">
          @csrf
          <span class="hero-subtitle" style="font-size: 11px; margin-bottom: 8px; display: block;">Message</span>
          <label for="contact-name">Name</label>
          <input id="contact-name" name="name" type="text" placeholder="Your full name" required alphabetsOnly>
          <label for="contact-mobile">Mobile Number</label>
          <input id="contact-mobile" name="phone" type="tel" placeholder="+91 98765 43210" required phoneIndia maxlength="10">
          <label for="contact-email">Email address</label>
          <input id="contact-email" name="email" type="email" placeholder="you@example.com" required>
          <label for="contact-message">Message</label>
          <textarea id="contact-message" name="message" rows="5" placeholder="Write your message" required></textarea>
          <button type="submit" class="btn">SEND MESSAGE</button>
        </form>
      </div>

      <div class="contact-details-block">
        <div class="contact-detail-card">
          <div class="contact-detail-icon"><i data-lucide="mail"></i></div>
          <h3>Email</h3>
          <p>{{ $contact->email ?? "youleggings@gmail.com" }}</p>
        </div>
        <div class="contact-detail-card">
          <div class="contact-detail-icon"><i data-lucide="map-pin"></i></div>
          <h3>Address</h3>
          <p>{{ $contact->address ?? "5/4, Surya Nagar, 2nd Street, Bridgeway Colony Extn, Tirupur - 641607" }}</p>
        </div>
        <div class="contact-detail-card">
          <div class="contact-detail-icon"><i data-lucide="phone"></i></div>
          <h3>Phone</h3>
          <p>{{ $contact->mobile ?? "+91 740143 24967" }}</p>
        </div>
      </div>
    </div>
  </section>
@endsection

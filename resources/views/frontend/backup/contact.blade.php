@extends('frontend.layouts.app')

@section('content')
  @if($contact)
  <!-- Contact Page -->
  <section class="section page-view contact-page-active" style="display: block;">
    <div class="page-main contact-main" style="background-color: #9f9f9f;">
      <div class="hero-overlay"></div>
      <div
        style="position: absolute; inset: 0; background-image: url('{{ asset('storage/' . $contact->photo) }}'); background-size: auto 110%; background-position: right 100% top 50%; background-repeat: no-repeat; transform: scaleX(-1); z-index: 2;">
      </div>
      <div class="container page-main-content">
        <span class="hero-subtitle">Reach Us</span>
        <h1 class="hero-title">{!! nl2br(e($contact->title)) !!}</h1>
      </div>
    </div>

    <div class="container page-body">
      <div class="contact-grid">
        <div class="contact-panel">
          <span class="section-subtitle">Get in Touch</span>
          <h2 class="section-title">We're delighted to assist you</h2>
          <p class="section-desc">We're delighted to assist you with any inquiries you may have about our exquisite
            collections of clothing and accessories.</p>
          <ul class="contact-list" style="list-style: none; padding: 0;">
            <li style="margin-bottom: 10px;"><strong>Address:</strong> {{ $contact->address }}</li>
            <li style="margin-bottom: 10px;"><strong>Email:</strong> {{ $contact->email }}</li>
            <li style="margin-bottom: 10px;"><strong>Phone:</strong> {{ $contact->mobile }}</li>
            <li style="margin-top: 20px;"><strong>Support Hours:</strong> Monday to Saturday, 9:30 AM - 7:00 PM</li>
            <li style="margin-bottom: 10px;"><strong>Response Time:</strong> We usually respond within 24 hours</li>
          </ul>
        </div>
        <form class="contact-form" action="{{ route('contact.store') }}" method="POST">
          @csrf
          <label for="contact-name">Name</label>
          <input id="contact-name" name="name" type="text" placeholder="Your full name" required>
          <label for="contact-mobile">Mobile Number</label>
          <input id="contact-mobile" name="mobile" type="tel" placeholder="+91 98765 43210" required>
          <label for="contact-email">Email address</label>
          <input id="contact-email" name="email" type="email" placeholder="you@example.com" required>
          <label for="contact-message">Message</label>
          <textarea id="contact-message" name="message" rows="5" placeholder="Write your message" required></textarea>
          <button type="submit" class="btn">Send Message</button>
        </form>
      </div>
    </div>
  </section>
  @else
  <div class="container py-5 text-center">
    <h2>Contact content Coming Soon</h2>
    <p>Please update the contact section in the admin panel.</p>
  </div>
  @endif
@endsection

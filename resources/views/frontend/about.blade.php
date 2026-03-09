@extends('frontend.layouts.app')

@section('title', 'About Us | You Leggings')

@section('content')
  <!-- About Page -->
  <section class="section about-page" id="about-page" style="display: block;">
    <div class="about-main" @if($about && $about->photo) style="background-image: url('{{ image_url($about->photo) }}');" @endif>
      <div class="about-main-overlay"></div>
      <div class="container about-main-content">
        <span class="hero-subtitle">{{ $about->sub_title ?? 'About You Leggings' }}</span>
        <h1 class="hero-title">{!! nl2br(e($about->title ?? "Comfort Without \nCompromise")) !!}</h1>
      </div>
    </div>

    <div class="container page-body">
      <div class="about-hero">
        <span class="section-subtitle">Our Story</span>
        <h2 class="section-title">{{ $about->description ?? 'Built on TANTEX Legacy, Designed for Every Woman' }}</h2>
      </div>

      <div class="about-story-split">
        <div class="about-story-card">
          <div class="about-story-content">
            <span class="about-story-tag">Our Promise</span>
            <h3>{{ $about->promise_title ?? 'Everyday Comfort, Premium Feel' }}</h3>
            <p>{!! nl2br(e($about->promise_desc ?? "At You Legging, we believe every woman deserves comfort without compromise. Born from the trusted legacy of TANTEX, we create bottom wear that blends affordability with high-end quality.")) !!}</p>
            
            <ul class="about-story-list">
              <li>A perfect fit that flatters every body type</li>
              <li>Stretch that adapts to your lifestyle</li>
              <li>Durability that lasts wash after wash</li>
            </ul>
          </div>
          <div class="about-story-image">
            <img src="{{ ($about && $about->photo) ? image_url($about->photo) : asset('frontend/images/Products/_DSC8682-Edit.jpg') }}" alt="You Leggings Our Story">
          </div>
        </div>
      </div>

      <div class="about-why">
        <h2 class="section-title">Why Choose You Leggings?</h2>
        <div class="about-why-grid">
            @for($i=1; $i<=5; $i++)
                @php 
                    $t = "why_choose_{$i}_title"; 
                    $d = "why_choose_{$i}_desc";
                @endphp
                @if($about && $about->$t)
                    <article class="about-why-card">
                        <h3>{{ $about->$t }}</h3>
                        <p>{{ $about->$d }}</p>
                    </article>
                @endif
            @endfor
            
            @if(!$about)
                <article class="about-why-card">
                    <h3>From TANTEX Legacy</h3>
                    <p>A trusted brand foundation with years of quality experience.</p>
                </article>
                <article class="about-why-card">
                    <h3>Zero Compromise Quality</h3>
                    <p>Premium fabrics, carefully tested for fit, comfort, and durability.</p>
                </article>
                <article class="about-why-card">
                    <h3>Affordable Luxury</h3>
                    <p>High-end feel at market-friendly prices for everyday wear.</p>
                </article>
            @endif
        </div>
      </div>
    </div>
  </section>
@endsection

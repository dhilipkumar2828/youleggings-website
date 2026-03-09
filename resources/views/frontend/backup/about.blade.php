@extends('frontend.layouts.app')

@section('content')
  @if($about)
  <!-- About Page -->
  <section class="section about-page-active" style="display: block; padding: 0 0 var(--spacing-xl); background: var(--bg-color);">
    <div class="about-main" style="height: 600px; position: relative; overflow: hidden; margin-top: -100px; background-image: url('{{ asset('storage/' . $about->photo) }}'); background-size: cover; background-position: center;">
      <div class="about-main-overlay" style="position: absolute; inset: 0; background: rgba(0,0,0,0.3);"></div>
      <div class="container about-main-content" style="position: relative; z-index: 2; height: 100%; display: flex; flex-direction: column; justify-content: center; color: #fff; padding-top: 80px;">
        <span class="hero-subtitle" style="color:#fff;">{{ $about->sub_title }}</span>
        <h1 class="hero-title" style="color:#fff;">{!! nl2br(e($about->title)) !!}</h1>
      </div>
    </div>

    <div class="container page-body">
      <div class="about-hero" style="text-align: center; margin-bottom: 50px;">
        <span class="section-subtitle">Our Story</span>
        <h2 class="section-title">{{ $about->description }}</h2>
      </div>

      <div class="about-story-split">
        <div class="about-story-card" style="display: flex; gap: 40px; align-items: center;">
          <div class="about-story-content" style="flex: 1;">
            <span class="about-story-tag" style="color: var(--primary-color); font-weight: 700;">Our Promise</span>
            <h3>{{ $about->promise_title }}</h3>
            {!! nl2br(e($about->promise_desc)) !!}
          </div>
          <div class="about-story-image" style="flex: 1;">
            <img src="{{ asset('storage/' . $about->photo) }}" alt="{{ $about->title }}" style="width: 100%; border-radius: 14px;">
          </div>
        </div>
      </div>

      <div class="about-why" style="margin-top: 80px;">
        <h2 class="section-title" style="text-align: center; margin-bottom: 40px;">Why Choose You Leggings?</h2>
        <div class="about-why-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px;">
          @for($i=1; $i<=5; $i++)
            @php 
              $t = "why_choose_{$i}_title"; 
              $d = "why_choose_{$i}_desc";
            @endphp
            @if($about->$t)
            <article class="about-why-card" style="background: #fff; padding: 24px; border-radius: 14px; box-shadow: 0 4px 12px rgba(125, 84, 101, 0.05); border: 1px solid #f0dbe4;">
              <h3 style="font-family: var(--font-serif); font-size: 20px; margin-bottom: 12px; color: var(--primary-color);">{{ $about->$t }}</h3>
              <p style="font-size: 14px; color: #666; font-family: var(--font-sans);">{{ $about->$d }}</p>
            </article>
            @endif
          @endfor
        </div>
      </div>
    </div>
  </section>
  @else
  <div class="container py-5 text-center">
    <h2>About content Coming Soon</h2>
    <p>Please update the about section in the admin panel.</p>
  </div>
  @endif
@endsection

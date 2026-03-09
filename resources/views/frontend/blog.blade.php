@extends('frontend.layouts.app')

@section('content')
  <!-- Blog Page -->
  <section class="section page-view blog-page-active" style="display: block;">
    <div class="page-main blog-main" style="background-color: #9f9f9f;">
      <div class="hero-overlay"></div>
      <div
        style="position: absolute; inset: 0; background-image: url('{{ asset('frontend/images/bg-less/_DSC8285-Photoroom.png') }}'); background-size: auto 120%; background-position: right -20% top 50%; background-repeat: no-repeat; transform: scaleX(); z-index: 2;">
      </div>
      <div class="container page-main-content">
        <span class="hero-subtitle">Insights & Style</span>
        <h1 class="hero-title">The You Leggings <br>Journal</h1>
      </div>
    </div>

    <div class="container page-body">
      <div class="blog-articles-grid">
        @foreach($blogs as $blog)
        <article class="blog-article-card">
          <div class="blog-article-image">
            <img src="{{ image_url($blog->photo) }}" alt="{{ $blog->title }}">
          </div>
          <div class="blog-article-content">
            <p class="blog-article-date"><i data-lucide="calendar-days"></i>{{ $blog->created_at->format('d-M-Y') }}</p>
            <h3>{{ $blog->title }}</h3>
          </div>
        </article>
        @endforeach
      </div>

      <div style="margin-top: 40px; display: flex; justify-content: center;">
        {{ $blogs->links() }}
      </div>
    </div>
  </section>
@endsection

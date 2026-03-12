@extends('frontend.layouts.app')

@section('content')
  <!-- Blog Page -->
  <section class="section page-view blog-page" style="display: block;">
    <div class="page-main blog-main" style="background-color: #9f9f9f;">
      <div class="hero-overlay"></div>
      <div
        style="position: absolute; inset: 0; background-image: url('{{ asset('frontend/images/bg-less/_DSC8285-Photoroom.png') }}'); background-size: auto 120%; background-position: right -20% top 50%; background-repeat: no-repeat; transform: scaleX(); z-index: 2;">
      </div>
      <div class="container page-main-content">
        <span class="hero-subtitle">{{ $heading->subtitle ?? 'Insights & Style' }}</span>
        <h1 class="hero-title">{!! $heading->value ?? 'The You Leggings <br>Journal' !!}</h1>
      </div>
    </div>

    <div class="container page-body">
      @if($featured_blog)
      <div class="blog-top-layout">
        <article class="blog-highlight-card">
          <a href="{{ route('blog_detail', $featured_blog->slug) }}" style="text-decoration: none; color: inherit;">
            <div class="blog-highlight-image">
              <img src="{{ image_url($featured_blog->photo) }}" alt="{{ $featured_blog->title }}">
            </div>
            <div class="blog-highlight-content">
              <h2>{{ $featured_blog->title }}</h2>
              <p>{{ Str::limit(strip_tags($featured_blog->description), 150) }}</p>
              <span class="blog-date">{{ date('d M Y', strtotime($featured_blog->publish_at)) }}</span>
            </div>
          </a>
        </article>

        <aside class="blog-most-read">
          <h3>Most Read</h3>
          <ul>
            @foreach($most_read as $m_blog)
            <li>
              <a href="{{ route('blog_detail', $m_blog->slug) }}">{{ $m_blog->title }}</a>
              <span>{{ date('d-M-Y', strtotime($m_blog->publish_at)) }}</span>
            </li>
            @endforeach
          </ul>
        </aside>
      </div>
      @endif

      <div class="blog-articles-head">
        <h2>View All Articles</h2>
      </div>

      <div class="blog-articles-grid">
        @foreach($blogs as $blog)
        @if($featured_blog && $blog->id == $featured_blog->id && $blogs->currentPage() == 1)
          @continue
        @endif
        <article class="blog-article-card">
          <a href="{{ route('blog_detail', $blog->slug) }}" class="blog-link-overlay"></a>
          <div class="blog-article-image">
            <img src="{{ image_url($blog->photo) }}" alt="{{ $blog->title }}">
          </div>
          <div class="blog-article-content">
            <p class="blog-article-date"><i data-lucide="calendar-days"></i>{{ date('d M Y', strtotime($blog->publish_at)) }}</p>
            <h3>{{ $blog->title }}</h3>
          </div>
        </article>
        @endforeach
      </div>

      @if($blogs->hasPages())
      <div class="blog-show-more-wrap">
        {{ $blogs->links() }}
      </div>
      @endif
    </div>
  </section>
@endsection

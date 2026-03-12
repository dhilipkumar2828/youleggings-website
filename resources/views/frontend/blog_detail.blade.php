@extends('frontend.layouts.app')

@section('title', $blog->title . ' | You Leggings')

@section('styles')
<style>
    /* Premium Blog Detail Styling */
    .blog-detail-page {
        background: #fff;
        padding-top: 100px; /* Space for fixed header */
    }

    .blog-detail-hero {
        padding: 60px 0 40px;
        background: linear-gradient(180deg, #fdf7fa 0%, #ffffff 100%);
        text-align: center;
    }

    .blog-category-tag {
        display: inline-block;
        padding: 6px 16px;
        background: var(--primary-color);
        color: #fff;
        border-radius: 100px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 700;
        margin-bottom: 24px;
    }

    .blog-detail-title {
        font-family: var(--font-serif);
        font-size: clamp(32px, 5vw, 48px);
        line-height: 1.2;
        color: #1a1a1a;
        max-width: 900px;
        margin: 0 auto 24px;
    }

    .blog-detail-meta {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 24px;
        color: #777;
        font-size: 14px;
        margin-bottom: 40px;
    }

    .blog-detail-meta span {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .blog-detail-meta span i {
        width: 16px;
        height: 16px;
        color: var(--primary-color);
    }

    .blog-main-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px 80px;
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 60px;
    }

    .blog-content-area {
        min-width: 0;
    }

    .featured-image-container {
        width: 100%;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 40px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }

    .featured-image-container img {
        width: 100%;
        height: auto;
        max-height: 600px;
        object-fit: cover;
        display: block;
    }

    .blog-article-body {
        font-size: 18px;
        line-height: 1.8;
        color: #333;
    }

    .blog-article-body p {
        margin-bottom: 24px;
    }

    .blog-article-body h2, .blog-article-body h3 {
        font-family: var(--font-serif);
        margin: 40px 0 20px;
        color: #000;
    }

    /* Sidebar */
    .blog-sidebar {
        position: sticky;
        top: 120px;
        height: fit-content;
    }

    .sidebar-widget {
        background: #fdfbfb;
        border: 1px solid #f0e6e9;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 30px;
    }

    .widget-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f0dbe4;
        font-family: var(--font-serif);
    }

    .recent-post-item {
        margin-bottom: 20px;
        display: flex;
        gap: 15px;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
    }

    .recent-post-item:hover {
        transform: translateX(5px);
    }

    .recent-post-thumb {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .recent-post-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .recent-post-info h4 {
        font-size: 14px;
        line-height: 1.4;
        margin-bottom: 5px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .recent-post-info span {
        font-size: 12px;
        color: #999;
    }

    /* Related Section */
    .more-articles {
        background: #fafafa;
        padding: 80px 0;
        border-top: 1px solid #eee;
    }

    @media (max-width: 991px) {
        .blog-main-container {
            grid-template-columns: 1fr;
        }
        .blog-sidebar {
            display: none;
        }
    }
</style>
@endsection

@section('content')
<div class="blog-detail-page">
    <header class="blog-detail-hero">
        <div class="container">
            <span class="blog-category-tag">Style Journal</span>
            <h1 class="blog-detail-title">{{ $blog->title }}</h1>
            <div class="blog-detail-meta">
                <span><i data-lucide="calendar"></i> {{ date('d M, Y', strtotime($blog->publish_at)) }}</span>
                <span><i data-lucide="user"></i> By {{ $blog->created_by ?? 'Admin' }}</span>
                <span><i data-lucide="clock"></i> 5 min read</span>
            </div>
        </div>
    </header>

    <div class="blog-main-container">
        <main class="blog-content-area">
            @if($blog->photo)
            <div class="featured-image-container">
                <img src="{{ image_url($blog->photo) }}" alt="{{ $blog->title }}">
            </div>
            @endif

            <div class="blog-article-body">
                {!! $blog->description !!}
            </div>
        </main>

        <aside class="blog-sidebar">
            <div class="sidebar-widget">
                <h3 class="widget-title">Recent Articles</h3>
                <div class="recent-posts-list">
                    @foreach($recent_blogs as $rblog)
                    <a href="{{ route('blog_detail', $rblog->slug) }}" class="recent-post-item">
                        <div class="recent-post-thumb">
                            <img src="{{ image_url($rblog->photo) }}" alt="{{ $rblog->title }}">
                        </div>
                        <div class="recent-post-info">
                            <h4>{{ $rblog->title }}</h4>
                            <span>{{ date('d M, Y', strtotime($rblog->publish_at)) }}</span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="sidebar-widget">
                <h3 class="widget-title">Follow Us</h3>
                <p style="font-size: 14px; color: #666;">Stay updated with our latest style tips and exclusive offers.</p>
                <div style="display: flex; gap: 15px; margin-top: 15px;">
                    <a href="#" style="color: #666;"><i data-lucide="instagram"></i></a>
                    <a href="#" style="color: #666;"><i data-lucide="facebook"></i></a>
                    <a href="#" style="color: #666;"><i data-lucide="twitter"></i></a>
                </div>
            </div>
        </aside>
    </div>
</div>


@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endsection


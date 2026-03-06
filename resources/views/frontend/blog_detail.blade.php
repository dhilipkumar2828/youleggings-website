@extends('frontend.layouts.arrivals_products_master_new')

@section('content')
<main class="main-content">
    <!-- PAGE HEADER -->
    <section class="page-header-area py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="fw-bold mb-0">Blog Details</h2>
                </div>
                <div class="col-md-6 text-md-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 justify-content-md-end">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('blogs') }}">Blogs</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $blog->title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- BLOG CONTENT -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Main Blog Content -->
                <div class="col-lg-8">
                    <article class="blog-details">
                        <div class="blog-feature-image mb-4">
                            <img src="{{ $blog->photo ? asset('uploads/blog/' . $blog->photo) : asset('premium_assets/images/Products/_DSC8716-Edit.jpg') }}" class="img-fluid rounded w-100" alt="{{ $blog->title }}">
                        </div>
                        
                        <div class="blog-meta mb-3 text-muted">
                            <span class="me-3"><i class="fa fa-calendar-o me-1"></i> {{ \Carbon\Carbon::parse($blog->publish_at)->format('d M, Y') }}</span>
                            <span><i class="fa fa-user-o me-1"></i> Admin</span>
                        </div>

                        <h1 class="fw-bold mb-4">{{ $blog->title }}</h1>
                        
                        <div class="blog-body-text">
                            {!! $blog->description !!}
                        </div>
                    </article>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <aside class="blog-sidebar">
                        <!-- Recent Posts -->
                        <div class="card border-0 shadow-sm p-4 mb-4">
                            <h4 class="fw-bold mb-4 border-bottom pb-2">Recent Posts</h4>
                            <div class="recent-posts-list">
                                @forelse($recent_blogs as $r_blog)
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0" style="width: 80px;">
                                        <img src="{{ $r_blog->photo ? asset('uploads/blog/' . $r_blog->photo) : asset('premium_assets/images/Products/_DSC8716-Edit.jpg') }}" class="img-fluid rounded" alt="{{ $r_blog->title }}">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1"><a href="{{ route('blog_detail', $r_blog->slug) }}" class="text-dark text-decoration-none">{{ Str::limit($r_blog->title, 40) }}</a></h6>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($r_blog->publish_at)->format('M d, Y') }}</small>
                                    </div>
                                </div>
                                @empty
                                <p>No other posts found.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Banner Advertise (Optional) -->
                        <div class="sidebar-promo">
                            <img src="{{ asset('premium_assets/images/banner1.jpg') }}" class="img-fluid rounded" alt="Promo">
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

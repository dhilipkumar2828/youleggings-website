@extends('frontend.layouts.master')

@section('content')
    <main>

        <div class="content-search">

            <div class="container container-100">

                <i class="far fa-times-circle" id="close-search"></i>

                <h3 class="text-center">what are your looking for ?</h3>

                <form method="get" action="/search" role="search" style="position: relative;">

                    <input type="text" class="form-control control-search" value="" autocomplete="off"
                        placeholder="Enter Search ..." aria-label="SEARCH" name="q">

                    <button class="button_search" type="submit">search</button>

                </form>

            </div>

        </div>

        @foreach ($blogs_banner as $data)
            <div class="container-fluid banner">

                <figure id="banner-figure"><a href="#"><img src="{{ $data->photo }}" class="img-responsive"
                            alt="img-holiwood" style="width: 100%"></a></figure>

                <div class="text-banner">

                    <h1>Blogs<br>Collection</h1>

                    <!-- <p>SALE UP TO 20% OFF</p>

      <a href="#">Shop now</a> -->

                </div>

            </div>
        @endforeach

        <div class="container content">

            <div class="row">

                <!-- <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">

        <form class="form-group">

         <input type="text" name="input-find" placeholder="Enter your search" class="input-lg">

         <button type="submit"><i class="fas fa-search"></i></button>

        </form>

       </div> -->

                <!-- <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 menu-breadcrumb">

        <ul class="breadcrumb">

      <li><a href="homev3.html">Home</a></li>

      <li><a href="#">Blogs</a></li>

        </ul>

       </div> -->

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 content-blog">

                    @foreach($blogs as $blogss)
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 product-blog">
                        <a href="{{ route('blog_detail', $blogss->slug) }}"><img src="{{ asset('uploads/blog/'.$blogss->photo) }}" class="img-responsive"
                                alt="{{ $blogss->title }}"></a>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 title-blog">
                        <h2><a href="{{ route('blog_detail', $blogss->slug) }}">{{ $blogss->title }}</a></h2>
                        <div class="time-blog">
                            <span class="time"><i class="far fa-calendar-alt"></i><span>{{ \Carbon\Carbon::parse($blogss->publish_at)->format('M d, Y') }}</span></span>
                            <span class="time"><i class="far fa-edit"></i><span>You Leggings</span></span>
                        </div>
                        <p>{!! Str::limit(strip_tags($blogss->description), 200) !!}</p>
                    </div>
                    @endforeach

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pagi" style="margin-top: 30px;">
                        {{ $blogs->links() }}
                    </div>

                    <!--  -->

                    <!--  -->

                    <!--  -->

                    <!--  -->

                    <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pagi">

         <ul class="pagination">

          <li><a href="#">01</a></li>

          <li><a href="#">02</a></li>

          <li><a href="#">03</a></li>

          <li><a href="#">04</a></li>

          <li><a href="#"><img src="{{ asset('frontend/img/Next.png') }}" class="img-responsive" alt="img-holiwood"></a></li>

         </ul>

        </div> -->

                </div>

            </div>

        </div>

    </main>
@endsection

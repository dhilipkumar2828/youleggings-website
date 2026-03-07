<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'You Leggings | Premium Comfort')</title>
  <meta name="description" content="@yield('meta_description', 'Discover premium comfort with You Leggings. Luxury made affordable.')">
  
  <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}?v={{ time() }}">
  
  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
  
  @yield('styles')
</head>

<body class="@php
    $routeName = request()->route() ? request()->route()->getName() : '';
    if ($routeName === 'index' || !$routeName) {
        echo '';
    } else {
        $baseName = str_replace(['_detail'], [''], $routeName);
        echo $baseName . '-page-active';
    }
@endphp">

  @include('frontend.partials.header')

  <main>
    @yield('content')
  </main>

  @include('frontend.partials.footer')

  <script src="{{ asset('frontend/js/main.js') }}"></script>
  <script>
    lucide.createIcons();
  </script>
  @yield('scripts')

</body>

</html>

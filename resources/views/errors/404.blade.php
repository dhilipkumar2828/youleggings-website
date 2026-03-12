@extends('frontend.layouts.app')

@section('title', '404 Page Not Found | You Leggings')

@section('styles')
<style>
    .not-found-page {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        background: #fff;
        padding: 100px 20px;
    }
    .not-found-content h1 {
        font-family: var(--font-serif);
        font-size: 150px;
        line-height: 1;
        color: var(--primary-color);
        margin: 0 0 10px;
    }
    .not-found-content h2 {
        font-size: 32px;
        color: #333;
        margin-bottom: 20px;
    }
    .not-found-content p {
        font-size: 18px;
        color: #666;
        margin-bottom: 40px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }
    .btn-return {
        display: inline-block;
        padding: 15px 40px;
        background: var(--primary-color);
        color: #fff;
        text-decoration: none;
        border-radius: 30px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(236, 64, 122, 0.3);
    }
    .btn-return:hover {
        background: var(--primary-dark);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(194, 24, 91, 0.4);
    }
</style>
@endsection

@section('content')
<main class="not-found-page">
    <div class="container">
        <div class="not-found-content">
            <h1>404</h1>
            <h2>Oops! Page Not Found</h2>
            <p>The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
            <a href="{{ route('index') }}" class="btn-return">Return to Home</a>
        </div>
    </div>
</main>
@endsection

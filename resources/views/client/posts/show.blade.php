@extends('layouts.master')

@section('title', $post->title)
@section('description', Str::limit(strip_tags($post->content), 160))

@section('content')
<style>
    :root {
        --primary: #4361ee;
        --primary-dark: #3a56d4;
        --gray-100: #f8fafc;
        --gray-200: #e2e8f0;
        --gray-600: #475569;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
    }

    .blog-container {
        max-width: 1240px;
        margin: 0 auto;
        padding: 2rem 1rem;
        font-family: 'Segoe UI', system-ui, sans-serif;
    }

    .breadcrumb {
        margin-bottom: 2rem;
        font-size: 0.95rem;
        color: var(--gray-600);
    }
    .breadcrumb a {
        color: var(--gray-600);
        text-decoration: none;
        transition: color 0.2s;
    }
    .breadcrumb a:hover {
        color: var(--primary);
    }
    .breadcrumb span {
        margin: 0 0.5rem;
        color: #94a3b8;
    }

    .blog-article {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        transition: transform 0.3s ease;
    }
    .blog-article:hover {
        transform: translateY(-8px);
    }

    .blog-hero-img {
        width: 100%;
        height: 420px;
        object-fit: cover;
    }

    .blog-content {
        padding: 3rem 3.5rem;
    }

    @media (max-width: 768px) {
        .blog-content {
            padding: 2rem 1.5rem;
        }
        .blog-hero-img { height: 280px; }
    }

    .blog-title {
        font-size: 2.8rem;
        font-weight: 800;
        line-height: 1.2;
        color: var(--gray-900);
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
        .blog-title { font-size: 2.2rem; }
    }

    .blog-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: 2.5rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .author-box {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .author-avatar {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #a855f7, #ec4899);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.5rem;
        box-shadow: 0 8px 20px rgba(168,85,247,0.3);
    }

    .author-name {
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 0.25rem;
    }

    .post-date {
        font-size: 0.95rem;
        color: var(--gray-600);
    }

    .read-time {
        font-size: 0.95rem;
        color: var(--gray-600);
        background: #f1f5f9;
        padding: 0.5rem 1rem;
        border-radius: 50px;
    }

    /* Nội dung bài viết */
    .blog-body {
        font-size: 1.15rem;
        line-height: 1.8;
        color: #334155;
        margin-bottom: 3rem;
    }
    .blog-body p {
        margin-bottom: 1.5rem;
    }
    .blog-body h2 {
        font-size: 1.9rem;
        margin: 2.5rem 0 1rem;
        color: var(--gray-900);
    }
    .blog-body h3 {
        font-size: 1.6rem;
        margin: 2rem 0 1rem;
    }
    .blog-body img {
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin: 2rem 0;
        max-width: 100%;
    }
    .blog-body blockquote {
        border-left: 5px solid var(--primary);
        background: #f8faff;
        padding: 1.5rem 2rem;
        margin: 2rem 0;
        font-style: italic;
        border-radius: 0 12px 12px 0;
    }

    /* Tags */
    .blog-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--gray-200);
    }

    .tag {
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        color: white;
        padding: 0.6rem 1.4rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .tag:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(59,130,246,0.4);
    }

    /* Nút quay lại */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: var(--gray-800);
        color: white;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-top: 4rem;
    }
    .btn-back:hover {
        background: #000;
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }
    .btn-back svg {
        transition: transform 0.3s;
    }
    .btn-back:hover svg {
        transform: translateX(-8px);
    }
</style>

<div class="blog-container">

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('client.home') }}">Trang chủ</a>
        <span>›</span>
        <a href="#">Tin tức</a>
        <span>›</span>
        <span style="color:#1e293b">{{ Str::limit($post->title, 50) }}</span>
    </div>

    <article class="blog-article">

        @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" 
                 alt="{{ $post->title }}" 
                 class="blog-hero-img">
        @endif

        <div class="blog-content">
            <h1 class="blog-title">{{ $post->title }}</h1>

            <!-- Meta -->
            <div class="blog-meta">
                <div class="author-box">
                    <div class="author-avatar">
                        {{ Str::upper(Str::substr($post->user?->name ?? 'A', 0, 1)) }}
                    </div>
                    <div>
                        <div class="author-name">{{ $post->user?->name ?? 'Admin' }}</div>
                        <div class="post-date">
                            {{ $post->created_at->format('d/m/Y') }}
                            @if($post->created_at->ne($post->updated_at))
                                <span style="color:#94a3b8"> • Cập nhật {{ $post->updated_at->diffForHumans() }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="read-time">
                    Đọc khoảng {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} phút
                </div>
            </div>

            <!-- Nội dung -->
            <div class="blog-body">
                {!! nl2br(e($post->content)) !!}
            </div>

            <!-- Tags -->
            <div class="blog-tags">
                <span class="tag">Tin tức</span>
                <span class="tag">Review phim</span>
                <span class="tag">Giải trí</span>
            </div>
        </div>
    </article>

    <!-- Nút quay lại -->
    <div style="text-align:center">
        <a href="{{ url()->previous() }}" class="btn-back">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Quay lại danh sách
        </a>
    </div>
</div>
@endsection
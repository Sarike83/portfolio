@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="btn_wrapper btn_centered">
            <a href="{{ route('post.create') }}" class="btn_link">
                <img src="{{ asset('storage/images/26317845.png') }}">
                <p class="btn_custom">➕ 新たな酔い旅</p>
            </a>
        </div>
        <h2 class="section_title mt-5">{{ Auth::user()->name }}さんの過去の酔い旅</h2>
        {{-- <div class="card-list contents-body"> --}}
            @if ($posts->isNotEmpty())
                <div class="card-body row justify-content-start mt-4">
                    @foreach ($posts as $post)
                        <div class="col-md-4 d-flex justify-content-center mb-4">
                            <a href="{{ route('post.review', $post->id) }}" class="post-item_link">
                                <div class="post_body">
                                    <div class="post-item_thumb-wrapper">
                                        <img
                                            src="{{ asset($post->image ? 'storage/' . $post->image : 'storage/images/no_image_logo.png') }}"
                                            alt="お店の写真"
                                            class="post_image"
                                        />
                                    </div>
                                    
                                    <div class="post-item_content post-item_content_mypage">
                                        <p class="post-item_bar">{{ $post->bar->name }}</p>
                                        <p class="post-item_date text-end">{{ $post->created_at->format('Y/m/d') }}</p> 
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center mt-4">
                    <p class="text-muted">まだ投稿がありません</p>
                </div>
            @endif

            {{-- ページネーションのリンク --}}
            <div class="text-center mb-4">
                {{ $posts->links() }}
            </div>
    </div>
@endsection
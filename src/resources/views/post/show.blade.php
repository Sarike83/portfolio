@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="section_title">みんなの酔い旅</h2>
    @if ($posts->isNotEmpty())
        <div class="card-body row justify-content-start mt-4">
            @foreach ($posts as $post)
                <div class="col-md-4 d-flex justify-content-center mb-4">
                    <a href="{{ route('post.review', ['post_id' => $post->id]) }}" class="post-item_link">
                        <div class="post_body">
                            <div class="post-item_thumb-wrapper">
                                <img
                                    src="{{ asset($post->image ? 'storage/' . $post->image : 'storage/images/no_image_logo.png') }}"
                                    alt="お店の写真"
                                    class="post_image"
                                />
                            </div>
                            
                            <div class="post-item_content">
                                <p class="post-item_bar">{{ $post->bar->name }}</p> 
                                {{-- <p class="post-item_user">{{ $post->user->name }}</p> --}}
                                @if ($post->user)
                                    <p class="post-item_user">{{ $post->user->name }}</p>
                                @else
                                    <p class="post-item_user">削除済みユーザー</p>
                                @endif
                                <p class="card-text text-muted post-date text-end">{{ $post->created_at->format('Y.m.d') }}</p>
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
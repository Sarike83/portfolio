@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="section_title">管理者画面</h2>
        <h3 class="text-center">{{ $user->name }} さんの投稿一覧</h3>

        <div class="card-body row justify-content-center mt-4">
            @if ($posts->isEmpty())
                <p class="text-center text-muted">このユーザーの投稿はありません。</p>
            @endif

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
                                        width="688"
                                        height="516"
                                    />
                                </div>
                                
                                <div class="post-item_content">
                                    <p class="post-item_bar">{{ $post->bar->name}}</p> 
                                    <p class="post-item_user">{{ $post->user->name }}</p>
                                    <p class="card-text text-muted post-date text-end">{{ $post->created_at->format('Y.m.d') }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('admin.home') }}" class="btn btn-secondary mb-3">ユーザー一覧に戻る</a>
        </div>
    </div>
@endsection
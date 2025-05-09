@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="bar_name text-center mt-5 mb-3">店名： {{ $post->bar->name }}</h3>
        <h6 class="bar_address text-center mb-5">{{$post->bar->address}}</h6>
        <div class="d-flex justify-content-center align-items-start">
            <div class="review_content border p-3" style="width: 48%; height: 300px; overflow-y: auto;">
                {!! nl2br($post->review) !!}
                {{-- 投稿の際に改行をしている箇所で、改行する関数 --}}
            </div>
            <div class="ms-4">
                <img
                    src="{{ asset($post->image ? 'storage/' . $post->image : 'storage/images/no_image_logo.png') }}"
                    alt="お店の写真"
                    class="img-fluid"
                    style="width: 450px; height: auto;"
                />
            </div>
        </div>

        {{-- いいねボタン --}}
        <div class="like_wrapper d-flex justify-content-center align-items-center gap-2 mx-auto border border-dark mt-5" style="width: 100px; height:50px;">
            <div class="like_heart">
                @auth
                    @if ($post->isLiked())
                        {{-- いいね外す --}}
                        <form action="{{ route('like.destroy', $post->id) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm p-0">
                                <i class="fa-solid fa-heart text-danger"></i>
                            </button>
                        </form>
                    @else
                        {{-- いいね --}}
                        <form action="{{ route('like.store', $post->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-sm p-0">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                        </form>
                    @endif
                @endauth
            </div>

            {{-- いいねのカウンター --}}
            <div class="like_count ms-2">
                <span>{{ $post->likes->count() }}</span>
            </div>
        </div>

        {{-- ログインユーザー＝投稿者の場合、編集・削除のページへ遷移 --}}
        @if (Auth::check() && (Auth::id() === $post->user_id || Auth::user()->role_id === 1))
            <div class="d-flex justify-content-center align-items-start gap-3 mt-4">
                <div class="m-2 text-center">
                    <a class="btn btn-primary" href="{{ route('post.edit', ['post_id' => $post->id]) }}">編集</a>
                </div>
                <div class="m-2 text-center">
                    <form action="{{ route('post.destroy', $post->id) }}" method="post" onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">削除</button>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection
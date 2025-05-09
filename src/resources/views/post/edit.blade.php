@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="section_title">
            投稿編集
        </h2>
        <div class="create_form w-75">
            <h3 class="text-center mt-5 mb-4">店名： {{ $edit_post->bar->name }}</h3>
            <form action="{{ route('post.update', ['post_id' => $edit_post->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                
                {{-- 投稿内容の編集 --}}
                <div class="d-flex">
                    <div class="form-group" style="width: 60%; height: 300px; overflow-y: auto;">
                        <textarea name="review" class="form-control" rows="10">{{ $edit_post->review }}</textarea>
                    </div>
                    @if($errors->has('review'))
                        <div class="alert alert-danger">メモ内容を入力してください</div>
                    @endif
    
                    <div class="ms-5">
                        <div>
                            <p>現在の画像:</p>
                            @if ($edit_post->image)
                                <img src="{{ asset('storage/' . $edit_post->image) }}" width="200">
                            @endif
                        </div>
                        <div class="mt-4">
                            <label for="image">画像を変更:</label>
                            <input type="file" name="image" accept="image/*">
                        </div>
                    </div>
                </div>

                {{-- 更新ボタン --}}
                <div class="d-flex justify-content-center m-2">
                    <button type="submit" class="btn btn-primary">更新</button>
                </div>
            </form>
        </div>
    </div>
@endsection
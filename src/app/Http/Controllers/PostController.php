<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\Bar;

class PostController extends Controller
{
    // 新規投稿メソッド
    public function create()
    {
        return view('post.create');
    }

    // フォームを送信した時の保存メソッド
    public function store(Request $request)
    {
        $validated = $request->validate([
            // 'bar_id' => 'required|exists:bars,id',
            'review' => 'required',
            'image' => 'nullable|image',
            'google_place_id' => 'required',
        ]);

        $user_id = Auth::id(); // ログインしているユーザーIDを取得
        
        // 店名がすでに登録されているかチェック
        $bar = Bar::firstOrCreate(
            ['google_place_id' => $request->google_place_id], // GoogleのIDでユニークチェック
            [
                'name' => $request->name,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]
        );

        $image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('images', 'public');
        }

        $post = Post::create([
            'user_id' => $user_id,
            'bar_id' => $bar->id,
            'review' => $validated['review'],
            'image' => $image,
        ]);

        return redirect()->route('mypage');
    }

    // 編集メソッド
    public function edit($post_id)
    {
        $edit_post = Post::findOrFail($post_id);

        // ログインしているユーザーと投稿したユーザーが一致していない場合は編集不可
        // if (Auth::user()->id != $edit_post->user_id) {
        //     return redirect()->route('home');
        // }

        return view('post.edit', compact('edit_post'));
    }

    // 他ユーザー投稿一覧メソッド
    public function show()
    {
        $posts = Post::with(['bar'])
                ->where('user_id', '!=', Auth::id()) // ログインしているユーザー以外の投稿を取得
                ->orderBy('created_at', 'DESC')
                ->simplePaginate(9);
                // ->get();
                // paginate()/get() どちらもデータを取得するためのメソッドのため、一緒に使うとエラーになる

        return view('post.show', compact('posts'));
        // return view('post.show', [
        //     'posts' => DB::table('posts')->paginate(9)
        // ]);
    }

    public function review($post_id)
    {
        $post = Post::with('bar')->findOrFail($post_id);

        return view('post.review', compact('post'));
    }

    // 更新メソッド
    public function update($post_id, Request $request)
    {
        $post = Post::findOrFail($post_id);

        $request->validate([
            'review' => 'required',
            'image' => 'nullable|image',
        ]);

        $post->review = $request->review;

        if ($request->hasFile('image')) {
            // 古い画像を削除
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
    
            // 新しい画像を保存
            $post->image = $request->file('image')->store('images', 'public');
        }
    
        $post->save();
    
        return redirect()->route('mypage')->with('success', '投稿を更新しました');
    }

    // 削除メソッド
    public function destroy($post_id)
    {
        $post = Post::find($post_id);

        if ($post !== null) {
            $post->delete();
        }

        return redirect(route('mypage'))->with('success', '投稿を削除しました');
    }
}

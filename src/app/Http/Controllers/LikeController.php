<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;
use App\Models\Post;

class LikeController extends Controller
{
    // private $like;

    // public function __construct(Like $like) {
    //     $this->like = $like;
    // }

    // いいねの保存
    public function store($post_id) {
        $user_id = Auth::id();

        // すでにいいねしている場合は何もしない
        if (Like::where('user_id', $user_id)->where('post_id', $post_id)->exists()) {
            return redirect()->back();
        }

        Like::create([
            'user_id' => $user_id,
            'post_id' => $post_id,
        ]);

        return redirect()->back();
    }

    // いいねの取り消し
    public function destroy($post_id) {
        $like = Like::where('user_id', Auth::id())->where('post_id', $post_id)->first();

        if ($like) {
            $like->delete();
        }

        return redirect()->back();
    }
}

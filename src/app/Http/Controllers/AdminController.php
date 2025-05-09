<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all(); // ユーザー一覧を取得
        $posts = Post::all(); // 投稿一覧を取得

        return view('admin.home', compact('users', 'posts'));
    }

    public function show(User $user)
    {
        $posts = Post::where('user_id', $user->id)
                ->orderBy('created_at', 'DESC')
                ->get(); // 指定ユーザーの投稿を取得

        return view('admin.show', compact('user', 'posts'));
    }

    // ユーザー削除メソッド
    public function destroy(User $user)
    {
        $user->delete();

        return redirect(route('admin.home'))->with('success', 'ユーザーを削除しました');
    }
}

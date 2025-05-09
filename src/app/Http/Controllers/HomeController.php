<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bar;
use App\Models\Like;
use App\Models\Post;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    
    public function index(Request $request)
    {
        return view('home');
    }

    public function mypage()
    {
        $posts = Post::with(['bar'])
                ->where('user_id', Auth::id()) // ログインしているユーザーの投稿のみ取得
                ->orderBy('created_at', 'DESC')
                ->simplePaginate(9);

        return view('mypage', compact('posts'));
    }

    // Google Maps API 練習用
    public function map() {
        return view('map');
    }
}

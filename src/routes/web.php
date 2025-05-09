<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/map', [App\Http\Controllers\HomeController::class, 'map'])->name('map'); // Google Maps API 練習用

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/mypage', [App\Http\Controllers\HomeController::class, 'mypage'])->name('mypage');
    
    Route::get('/post/create', [App\Http\Controllers\PostController::class, 'create'])->name('post.create');
    Route::post('/post/store', [App\Http\Controllers\PostController::class, 'store'])->name('post.store');
    Route::get('/post/edit/{post_id}', [App\Http\Controllers\PostController::class, 'edit'])->name('post.edit');
    Route::get('/post/show', [App\Http\Controllers\PostController::class, 'show'])->name('post.show');
    Route::get('/post/review/{post_id}', [App\Http\Controllers\PostController::class, 'review'])->name('post.review');
    Route::patch('/post/update/{post_id}', [App\Http\Controllers\PostController::class, 'update'])->name('post.update');
    Route::delete('/post/destroy/{post_id}', [App\Http\Controllers\PostController::class, 'destroy'])->name('post.destroy');
    
    Route::post('/bar/store', [App\Http\Controllers\BarController::class, 'store'])->name('bar.store');
    
    // いいね機能
    Route::post('/like/store/{post_id}', [App\Http\Controllers\LikeController::class, 'store'])->name('like.store');
    Route::delete('/like/destroy/{post_id}', [App\Http\Controllers\LikeController::class, 'destroy'])->name('like.destroy');
});

// 管理者用のルート
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/home', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.home');
    Route::get('/admin/show/{user}', [App\Http\Controllers\AdminController::class, 'show'])->name('admin.show');
    Route::delete('/admin/destroy/{user}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.destroy');
});
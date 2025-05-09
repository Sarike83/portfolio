<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'bar_id',
        'review',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class); // 投稿はUserに属する
    }

    public function bar()
    {
        return $this->belongsTo(Bar::class); // 投稿は1つのお店に属する
    }

    public function likes()
    {
        return $this->hasMany(Like::class); // 1つの投稿は複数のいいねがある
    }

    public function isLiked() {
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
    }
}

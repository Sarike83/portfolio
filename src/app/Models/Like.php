<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class); // いいねは1人のユーザーに属する
    }

    public function posts()
    {
        return $this->belongsTo(Post::class); // いいねは１つの投稿に属する
    }
}

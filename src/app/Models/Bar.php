<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bar extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'google_place_id',
        'latitude',
        'longitude',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class); // お店は複数の投稿がある
    }
}

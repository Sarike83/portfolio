<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bar;
use App\Models\Post;

class BarController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'google_place_id' => 'required|unique:bars,google_place_id',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        // すでに登録されているお店か確認
        $bar = Bar::firstOrCreate(
            ['google_place_id' => $validated['google_place_id']],
            $validated
        );

        return response()->json(['bar_id' => $bar->id]);

        // $bar = new Bar();
        // $bar->post_id = Post::id();
        // $bar->name = $request->name;
        // $bar->address = $request->address;
        // $bar->google_place_id = $request->google_place_id;
        // $bar->latitude = $request->latitude;
        // $bar->longitude = $request->longitude;

        // $bar->save();
    }
}

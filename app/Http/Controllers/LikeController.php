<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // Tambah Like
    public function store(Post $post)
    {
        Like::firstOrCreate([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
        ]);

        return back();
    }

    // Hapus Like
    public function destroy(Post $post)
    {
        $like = Like::where('user_id', Auth::id())
            ->where('post_id', $post->id)
            ->first();

        if ($like) {
            $like->delete();
        }

        return back();
    }
}

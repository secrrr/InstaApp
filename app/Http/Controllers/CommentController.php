<?php

namespace App\Http\Controllers;


use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Tambah komentar
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function destroy(Comment $comment)
    {
        $user = Auth::user();

        // Bisa dihapus jika pemilik komentar ATAU pemilik post
        if ($user->id !== $comment->user_id && $user->id !== $comment->post->user_id) {
            abort(403, 'Anda tidak punya izin untuk menghapus komentar ini.');
        }

        $comment->delete();
        return back()->with('success', 'Komentar berhasil dihapus!');
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // Form create post
    public function create()
    {
        return view('post.create'); // halaman untuk upload post
    }

    // Simpan post baru
    public function store(Request $request)
    {
        $request->validate([
            'caption' => 'nullable|string|max:255',
            'image'   => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('image')->store('posts', 'public');

        Post::create([
            'user_id'    => Auth::id(),
            'caption'    => $request->caption,
            'image_path' => $path,
        ]);

        return redirect()->route('home')->with('success', 'Post berhasil dibuat!');
    }

    // Detail post
    public function show(Post $post)
    {
        $post->load(['user', 'likes', 'comments.user']);
        return view('post.show', compact('post'));
    }

        public function like(Post $post)
    {
        $user = auth()->user();

        if (!$post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->create(['user_id' => $user->id]);
        }

        return back();
    }

    public function comment(Request $request, Post $post)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        return back();
    }

        public function destroy(Post $post)
    {
        // Hanya pemilik post yang bisa hapus
        if (Auth::id() !== $post->user_id) {
            abort(403, 'Anda tidak punya izin untuk menghapus post ini.');
        }

        $post->delete();
        return back()->with('success', 'Post berhasil dihapus!');
    }

    public function update(Request $request, Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403, 'Anda tidak punya izin untuk mengedit post ini.');
        }

        $request->validate([
            'caption' => 'nullable|string|max:255',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // hapus gambar lama
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            $post->image_path = $request->file('image')->store('posts', 'public');
        }

        $post->caption = $request->caption;
        $post->save();

        return back()->with('success', 'Post berhasil diperbarui!');
    }

    // Bisa ditambahkan edit, update, delete sesuai hak akses user login
}

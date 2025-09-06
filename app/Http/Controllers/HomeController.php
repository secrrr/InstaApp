<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Tampilkan seluruh postingan (feed)
     */
    public function index()
{
    $user = Auth::user();

    // ambil daftar id user yang sedang di-follow
    $followingIds = $user->following()->pluck('users.id')->toArray();

    // tambahkan id user sendiri
    $followingIds[] = $user->id;

    // ambil post hanya dari user yg difollow + diri sendiri
    $posts = Post::with(['user', 'likes', 'comments.user'])
                 ->whereIn('user_id', $followingIds)
                 ->latest()
                 ->get();

    return view('home.index', compact('posts', 'user'));
}
}

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;



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
    return view('auth.login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');;

    Route::get('/profile', function() {
        return redirect()->route('profile.show', auth()->user()->name);
    })->name('profile');

    // // Profile show berdasarkan nama
    // Route::get('/profile/{name}', [ProfileController::class, 'show'])
    //     ->name('profile.show');

    // Update foto profil
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])
    ->name('profile.updatePhoto');

    Route::get('/post/create', [PostController::class, 'create'])->name('posts.create'); 
    Route::post('/post', [PostController::class, 'store'])->name('posts.store'); 
    Route::get('/post/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('home.posts.like');
    Route::delete('/posts/{post}/like', [LikeController::class, 'destroy'])->name('home.posts.unlike');

    Route::post('/posts/{post}/comment', [CommentController::class, 'store'])->name('home.posts.comment');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::post('/home/posts/{post}/like', [PostController::class, 'like'])->name('home.posts.like');
    Route::post('/home/posts/{post}/comment', [PostController::class, 'comment'])->name('home.posts.comment');

    Route::get('/search', [SearchController::class, 'index']);

    Route::get('/profile/{name}', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/{id}/follow', [ProfileController::class, 'follow'])->name('profile.follow');
    Route::delete('/profile/{id}/unfollow', [ProfileController::class, 'unfollow'])->name('profile.unfollow');
});

require __DIR__.'/auth.php';

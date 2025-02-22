<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\UserController;
use PhpParser\Node\Stmt\Block;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(PostController::class)
    ->middleware('auth') // ここで全体に適用
    ->group(function () {
        Route::get('/', 'index')->name('posts.index');
        Route::post('/posts', 'store')->name('posts.store');
        Route::get('/posts/create', 'create')->name('posts.create');
        Route::get('/posts/{post}', 'show')->name('posts.show');
        Route::put('/posts/{post}', 'update')->name('posts.update');
        Route::delete('/posts/{post}', 'destroy')->name('posts.destroy');
        Route::get('/posts/{post}/edit', 'edit')->name('posts.edit');
    });

Route::middleware('auth')->controller(CommentController::class)->group(function () {
    Route::post('/comments', 'store')->name('comments.store');
    Route::get('/comments/{comment}/edit', 'edit')->name('comments.edit');
    Route::put('/comments/{comment}', 'update')->name('comments.update');
    Route::delete('/comments/{comment}', 'destroy')->name('comments.destroy');
});

Route::middleware('auth')->controller(FollowController::class)->group(function () {
    Route::post('/users/{user}/follow', 'follow')->name('users.follow');
    Route::delete('/users/{user}/unfollow', 'unfollow')->name('users.unfollow');
});

Route::middleware('auth')->controller(BlockController::class)->group(function () {
    Route::post('/users/{user}/block', 'block')->name('users.block');
    Route::delete('/users/{user}/unblock', 'unblock')->name('users.unblock');
});

// ユーザー詳細画面のルーティングを追加
Route::middleware('auth')->controller(UserController::class)->group(function () {
    Route::get('/users/{user}', 'show')->name('users.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/posts/{post}/join', [PostController::class, 'join'])->name('join');

Route::get('/edit', 'UserController@index')->name('user.index');

Route::post('/update', 'UserController@update')->name('user.update');

require __DIR__.'/auth.php';
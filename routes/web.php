<?php

use App\Http\Controllers\Admin\AdminSecretMessageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaLinkController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SecretMessageController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/visitor', [HomeController::class, 'storeVisitor'])->name('visitor.store');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/category/{slug}', [PostController::class, 'category'])->name('posts.category');

// Anonymous message routes
Route::get('/message', [SecretMessageController::class, 'create'])->name('messages.create');
Route::post('/message', [SecretMessageController::class, 'store'])->name('messages.store');

// Admin routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Posts
    Route::resource('posts', AdminPostController::class);
    
    // Media Links
    Route::post('/posts/{post}/media-links', [MediaLinkController::class, 'store'])->name('media-links.store');
    Route::delete('/media-links/{mediaLink}', [MediaLinkController::class, 'destroy'])->name('media-links.destroy');
    
    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
    // Messages
    Route::get('/messages', [AdminSecretMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [AdminSecretMessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{message}/reply', [AdminSecretMessageController::class, 'reply'])->name('messages.reply');
    Route::delete('/messages/{message}', [AdminSecretMessageController::class, 'destroy'])->name('messages.destroy');
    
    // Profile
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    
    // Visitors
    Route::get('/visitors', [\App\Http\Controllers\Admin\VisitorController::class, 'index'])->name('visitors.index');
});

require __DIR__.'/auth.php';

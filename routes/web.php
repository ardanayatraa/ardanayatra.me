<?php

use App\Http\Controllers\Admin\AdminSecretMessageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaLinkController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\FretBubbleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SecretMessageController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/visitor', [HomeController::class, 'storeVisitor'])->name('visitor.store');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/category/{slug}', [PostController::class, 'category'])->name('posts.category');

// FretBubble - Chord Diagram Generator
Route::get('/fretbubble', [FretBubbleController::class, 'index'])->name('fretbubble.index');
Route::get('/fretbubble/presets', [FretBubbleController::class, 'getPresets'])->name('fretbubble.presets');
Route::get('/fretbubble/presets/{id}', [FretBubbleController::class, 'getPreset'])->name('fretbubble.preset');

// Chord Learning
Route::get('/learningchord', [\App\Http\Controllers\ChordLearningController::class, 'index'])->name('chord-learning.index');

// Invoice Generator
Route::get('/invoicego', [InvoiceController::class, 'index'])->name('invoicego.index');
Route::post('/invoicego/generate', [InvoiceController::class, 'generate'])->name('invoicego.generate');

// Metronome
Route::get('/metronome', [\App\Http\Controllers\MetronomeController::class, 'index'])->name('metronome.index');

// Tridanta FastRead
Route::get('/fastread', [\App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
Route::get('/fastread/{slug}', [\App\Http\Controllers\NewsController::class, 'show'])->name('news.show');

// My Song
Route::get('/song', [\App\Http\Controllers\SongController::class, 'index'])->name('song.index');
Route::get('/song/{slug}', [\App\Http\Controllers\SongController::class, 'show'])->name('song.show');

// Debug Songs
Route::get('/debug-songs', function() {
    $songs = \App\Models\Song::all(['id', 'title', 'audio_file', 'cover_image']);
    return response()->json([
        'total' => $songs->count(),
        'songs' => $songs->map(function($s) {
            return [
                'id' => $s->id,
                'title' => $s->title,
                'audio_file' => $s->audio_file ?: 'NULL',
                'audio_file_length' => strlen($s->audio_file ?? ''),
                'cover_image' => $s->cover_image ?: 'NULL',
            ];
        })
    ]);
});

// Test R2 Connection Page
Route::get('/test-r2-connection', function() {
    return view('test-r2-connection');
});

// Test R2 Connection API (temporary)
Route::get('/test-r2', function() {
    try {
        // Get R2 config
        $config = config('filesystems.disks.r2');
        
        // Test write
        $testContent = 'Hello from Laravel! ' . now();
        \Storage::disk('r2')->put('test.txt', $testContent);
        
        // Test read
        $content = \Storage::disk('r2')->get('test.txt');
        
        // Test exists
        $exists = \Storage::disk('r2')->exists('test.txt');
        
        // Test public URL
        $publicUrl = \Storage::disk('r2')->url('test.txt');
        
        // Clean up
        \Storage::disk('r2')->delete('test.txt');
        
        return response()->json([
            'status' => 'success',
            'message' => '✅ R2 connection working!',
            'config' => [
                'bucket' => $config['bucket'],
                'endpoint' => $config['endpoint'],
                'public_url' => $config['url'],
                'region' => $config['region'],
            ],
            'test_results' => [
                'write' => 'OK',
                'read' => $content === $testContent ? 'OK' : 'FAILED',
                'exists' => $exists ? 'OK' : 'FAILED',
                'delete' => 'OK',
            ],
            'public_url' => $publicUrl,
            'note' => 'Jika semua OK, R2 siap digunakan!',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'config' => config('filesystems.disks.r2'),
            'help' => [
                'Cek R2_ACCESS_KEY_ID di .env',
                'Cek R2_SECRET_ACCESS_KEY di .env',
                'Cek R2_BUCKET sudah dibuat di Cloudflare',
                'Cek R2_ENDPOINT format: https://ACCOUNT_ID.r2.cloudflarestorage.com',
                'Jalankan: php artisan config:clear',
            ],
            'trace' => explode("\n", $e->getTraceAsString()),
        ], 500);
    }
});

// Test R2 Upload with Audio File
Route::get('/test-r2-audio', function() {
    return view('test-r2-audio');
});

Route::post('/test-r2-audio', [\App\Http\Controllers\UploadController::class, 'uploadAudio'])->name('test.r2.audio');

// API Upload Cover
Route::post('/api/upload-cover', [\App\Http\Controllers\UploadController::class, 'uploadCover']);

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
    
    // Chord Presets
    Route::resource('chord-presets', \App\Http\Controllers\Admin\ChordPresetController::class);
    
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
    Route::delete('/visitors/{visitor}', [\App\Http\Controllers\Admin\VisitorController::class, 'destroy'])->name('visitors.destroy');
    
    // Tridanta FastRead
    Route::resource('fastread', \App\Http\Controllers\Admin\NewsController::class)->parameters([
        'fastread' => 'news'
    ])->names([
        'index' => 'news.index',
        'create' => 'news.create',
        'store' => 'news.store',
        'show' => 'news.show',
        'edit' => 'news.edit',
        'update' => 'news.update',
        'destroy' => 'news.destroy',
    ]);
    
    // My Song
    Route::resource('songs', \App\Http\Controllers\Admin\SongController::class);
});

require __DIR__.'/auth.php';

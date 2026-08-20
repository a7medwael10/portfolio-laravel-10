<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [PortfolioController::class, 'home'])->name('home');
Route::get('/about', [PortfolioController::class, 'about'])->name('about');
Route::get('/skills', [PortfolioController::class, 'skills'])->name('skills');
Route::get('/experience', [PortfolioController::class, 'experience'])->name('experience');
Route::get('/projects', [PortfolioController::class, 'projects'])->name('projects');
Route::get('/contact', [PortfolioController::class, 'contact'])->name('contact');
Route::post('/contact', [PortfolioController::class, 'storeMessage'])->name('contact.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Fallback route for storage files when symlinks are not available (InfinityFree hosting)
Route::get('/storage/{path}', function ($path) {
    $storageFile = storage_path('app/public/' . $path);
    $publicFile = public_path('storage/' . $path);

    if (file_exists($publicFile)) {
        return response()->file($publicFile);
    }

    if (file_exists($storageFile)) {
        // Auto-copy to public/storage if missing
        $dir = dirname($publicFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        copy($storageFile, $publicFile);

        return response()->file($storageFile);
    }

    abort(404);
})->where('path', '.*');

require __DIR__.'/auth.php';

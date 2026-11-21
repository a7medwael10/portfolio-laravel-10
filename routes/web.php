<?php

use App\Http\Controllers\MaintenanceCommandController;
use App\Http\Controllers\MediaImageController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [PortfolioController::class, 'home'])->name('home');
Route::get('/about', [PortfolioController::class, 'about'])->name('about');
Route::get('/skills', [PortfolioController::class, 'skills'])->name('skills');
Route::get('/experience', [PortfolioController::class, 'experience'])->name('experience');
Route::get('/projects', [PortfolioController::class, 'projects'])->name('projects');
Route::get('/contact', [PortfolioController::class, 'contact'])->name('contact');
Route::post('/contact', [PortfolioController::class, 'storeMessage'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

Route::get('/media/images/{path}', MediaImageController::class)
    ->where('path', '.*')
    ->withoutMiddleware([
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \App\Http\Middleware\HandleInertiaRequests::class,
        \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
    ])
    ->name('media.image');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/maintenance/{command}', MaintenanceCommandController::class)
        ->whereIn('command', [
            'migrate',
            'migrate-fresh',
            'rollback',
            'seed',
            'optimize-clear',
            'queue-work',
            'queue-restart',
            'storage-link',
        ])
        ->name('maintenance.run');
});

require __DIR__.'/auth.php';

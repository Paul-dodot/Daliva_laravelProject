<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlatformController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', [GameController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/games', [GameController::class, 'index'])->name('games.index');
    Route::post('/games', [GameController::class, 'store'])->name('games.store');
    Route::put('/games/{game}', [GameController::class, 'update'])->name('games.update');
    Route::delete('/games/{game}', [GameController::class, 'destroy'])->name('games.destroy');
    Route::get('/games/trash', [GameController::class, 'trash'])->name('games.trash');
    Route::patch('/games/{id}/restore', [GameController::class, 'restore'])->name('games.restore');
    Route::delete('/games/{id}/force-delete', [GameController::class, 'forceDelete'])->name('games.force-delete');
    Route::get('/games/export', [GameController::class, 'export'])->name('games.export');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('platforms', [PlatformController::class, 'index'])->name('platforms.index');
    Route::post('platforms', [PlatformController::class, 'store'])->name('platforms.store');
    Route::put('platforms/{platform}', [PlatformController::class, 'update'])->name('platforms.update');
    Route::delete('platforms/{platform}', [PlatformController::class, 'destroy'])->name('platforms.destroy');
    Route::get('platforms/trash', [PlatformController::class, 'trash'])->name('platforms.trash');
    Route::patch('platforms/{id}/restore', [PlatformController::class, 'restore'])->name('platforms.restore');
    Route::delete('platforms/{id}/force-delete', [PlatformController::class, 'forceDelete'])->name('platforms.force-delete');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::redirect('/settings', '/settings/profile'); 
    Route::get('/settings/profile', Profile::class)->name('settings.profile');
    Route::get('/settings/password', Password::class)->name('settings.password');
    Route::get('/settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
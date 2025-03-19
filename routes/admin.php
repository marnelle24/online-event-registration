<?php 

use App\Http\Controllers\CategoryController;

use App\Http\Controllers\MinistryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SpeakerController;

Route::middleware(['admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/ministries', [MinistryController::class, 'index'])->name('admin.ministries');
    Route::get('/ministries/create', [MinistryController::class, 'create'])->name('admin.ministries.create');
    Route::post('/ministries', [MinistryController::class, 'store'])->name('admin.ministries.store');
    Route::get('/ministry/{id}', [MinistryController::class, 'show'])->name('admin.ministry.show');
    Route::get('/ministry/{id}/edit', [MinistryController::class, 'edit'])->name('admin.ministry.edit');
    Route::put('/ministry/{ministry}', [MinistryController::class, 'update'])->name('admin.ministry.update');
    Route::delete('/ministry/{ministry}', [MinistryController::class, 'destroy'])->name('admin.ministry.destroy');

    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories');

    // Speaker routes
    Route::prefix('speakers')->group(function () {
        Route::get('/', [SpeakerController::class, 'index'])->name('admin.speakers');
        Route::get('/create', [SpeakerController::class, 'create'])->name('admin.speakers.create');
        Route::post('/', [SpeakerController::class, 'store'])->name('admin.speakers.store');
        Route::get('/{id}', [SpeakerController::class, 'show'])->name('admin.speakers.show');
        Route::get('/{id}/edit', [SpeakerController::class, 'edit'])->name('admin.speakers.edit');
        Route::put('/{id}', [SpeakerController::class, 'update'])->name('admin.speakers.update');
        Route::delete('/{id}', [SpeakerController::class, 'destroy'])->name('admin.speakers.destroy');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.users');
        Route::get('/create', [AdminController::class, 'create'])->name('admin.users.create');
        Route::post('/', [AdminController::class, 'store'])->name('admin.users.store');
        Route::get('/{id}', [AdminController::class, 'show'])->name('admin.users.show');
        Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
        Route::put('/{id}', [AdminController::class, 'update'])->name('admin.users.update');
    });
});
    
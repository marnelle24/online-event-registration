<?php 

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MinistryController;
use App\Http\Controllers\ProgrammeController;
use App\Http\Controllers\RegistrantController;

Route::middleware(['admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories');

    // Ministry routes
    Route::prefix('ministry')->group(function () {
        Route::get('/', [MinistryController::class, 'index'])->name('admin.ministry');
        Route::get('/create', [MinistryController::class, 'create'])->name('admin.ministry.create');
        Route::post('/', [MinistryController::class, 'store'])->name('admin.ministry.store');
        Route::get('/{id}', [MinistryController::class, 'show'])->name('admin.ministry.show');
        Route::get('/{id}/edit', [MinistryController::class, 'edit'])->name('admin.ministry.edit');
        Route::put('/{id}', [MinistryController::class, 'update'])->name('admin.ministry.update');
        Route::delete('/{id}', [MinistryController::class, 'destroy'])->name('admin.ministry.destroy');
    });

    // Programme routes
    Route::prefix('programmes')->group(function () {
        Route::get('/', [ProgrammeController::class, 'index'])->name('admin.programmes');
        Route::get('/create', [ProgrammeController::class, 'create'])->name('admin.programmes.create');
        Route::post('/', [ProgrammeController::class, 'store'])->name('admin.programmes.store');
        Route::get('/{programmeCode}', [ProgrammeController::class, 'show'])->name('admin.programmes.show');
        Route::get('/{id}/edit', [ProgrammeController::class, 'edit'])->name('admin.programmes.edit');
        Route::put('/{id}', [ProgrammeController::class, 'update'])->name('admin.programmes.update');
        Route::put('/soft-delete/{id}', [ProgrammeController::class, 'softDelete'])->name('admin.programmes.soft-delete');
    });

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

    // Payment verification routes
    Route::prefix('payments')->group(function () {
        Route::post('/verify-bank-transfer/{confirmationCode}', [RegistrantController::class, 'verifyBankTransfer'])->name('admin.payments.verify-bank-transfer');
    });
    
});
    
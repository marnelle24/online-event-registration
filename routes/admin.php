<?php 

use App\Http\Controllers\CategoryController;

use App\Http\Controllers\MinistryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::middleware(['admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/ministries', [MinistryController::class, 'index'])->name('admin.ministries');
    Route::get('/ministries/create', [MinistryController::class, 'create'])->name('admin.ministries.create');
    Route::post('/ministries', [MinistryController::class, 'store'])->name('admin.ministries.store');
    Route::get('/ministry/{id}', [MinistryController::class, 'show'])->name('admin.ministry.show');
    Route::get('/ministry/{id}/edit', [MinistryController::class, 'edit'])->name('admin.ministry.edit');
    Route::put('/ministry/{ministry}', [MinistryController::class, 'update'])->name('admin.ministry.update');
    Route::put('/ministry/{ministry}', [MinistryController::class, 'destroy'])->name('admin.ministry.destroy');

    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories');
});
    
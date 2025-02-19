<?php 
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AdminController;

    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        // Add more admin routes here
    });
    
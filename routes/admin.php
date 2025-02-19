<?php 
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AdminController;

    Route::middleware(['web', 'auth', 'admin'])->group(function () {

        Route::get('/admin', function () {
            return redirect()->route('admin.dashboard');
        });

        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    });
    
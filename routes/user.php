<?php 
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\UserController;

    Route::middleware(['web', 'auth', 'user'])->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    });
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::get('/admin', function () {
        return redirect()->route('admin.dashboard');
    });

    // Admin Routes
    require __DIR__ . '/admin.php';

    // User Routes
    require __DIR__ . '/user.php';
});
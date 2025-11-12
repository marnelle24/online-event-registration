<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProgrammeController;
use App\Http\Controllers\RegistrantController;

//public routes
Route::get('/', function () {
    return view('pages/front-page');
})->name('frontpage');

Route::get('/about', function () {
    return view('pages/about');
})->name('about');

Route::get('/programmes', function () {
    return view('pages/programmes');
})->name('programmes');

Route::get('/categories', function () {
    return view('pages/categories');
})->name('categories');

Route::get('/categories/{slug}', function ($slug) {
    return view('pages/single-category', ['slug' => $slug]);
})->name('single-category');

Route::get('/programme/{programmeCode}', [ProgrammeController::class, 'publicShow'])->name('programme.show');
Route::get('/programme/{programmeCode}/register', [RegistrantController::class, 'register'])->name('programme.register');
Route::get('/programme/{programmeCode}/register-v2', [RegistrantController::class, 'registerV2'])->name('programme.register.v2');
Route::get('/registration/confirmation/{confirmationCode}', [RegistrantController::class, 'confirmation'])->name('registration.confirmation');
Route::get('/registration/payment/{confirmationCode}', [RegistrantController::class, 'payment'])->name('registration.payment');

// Payment routes
Route::get('/payment/callback', [RegistrantController::class, 'paymentCallback'])->name('payment.callback');
Route::post('/payment/webhook', [RegistrantController::class, 'paymentWebhook'])->name('payment.webhook');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::get('/admin', function () {
        return redirect()->route('admin.dashboard');
    });

    // Admin Routes
    require __DIR__ . '/admin.php';

    // User Routes
    require __DIR__ . '/user.php';
});
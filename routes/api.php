<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrantController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public API routes for registration
Route::post('/validate-promocode', [RegistrantController::class, 'validatePromocode']);
Route::post('/register-programme', [RegistrantController::class, 'store']);

// Payment API routes
Route::get('/payment-methods/{confirmationCode}', [RegistrantController::class, 'getPaymentMethods']);
Route::post('/process-payment/{confirmationCode}', [RegistrantController::class, 'processPayment']);

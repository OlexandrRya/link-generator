<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RegistrationController::class, 'show'])->name('registration.show');
Route::post('/register', [RegistrationController::class, 'register'])->name('registration.register');

Route::get('/links/{uid}', [LinkController::class, 'show'])->name('links.show');
Route::post('/links/{uid}', [LinkController::class, 'regenerate'])->name('links.regenerate');
Route::post('/links/{uid}/deactivate', [LinkController::class, 'deactivate'])->name('links.deactivate');

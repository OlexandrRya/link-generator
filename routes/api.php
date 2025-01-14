<?php

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

Route::post('/api/games/{uid_link}/play', [GameController::class, 'playGame'])->name('games.play');
Route::get('/api/games/{uid_link}/history', [GameController::class, 'getHistory'])->name('games.history');
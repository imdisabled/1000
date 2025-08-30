<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DayController;

Route::get('/', [DayController::class, 'dashboard'])->name('dashboard');
Route::get('/days', [DayController::class, 'index'])->name('days.index');
Route::get('/days/{day}', [DayController::class, 'show'])->name('days.show');
Route::post('/days/{day}/toggle', [DayController::class, 'toggle'])->name('days.toggle');
Route::post('/days/regenerate-quote', [DayController::class, 'regenerateQuote'])->name('days.regenerate-quote');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

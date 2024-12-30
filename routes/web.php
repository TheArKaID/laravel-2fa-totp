<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/2fa', [App\Http\Controllers\HomeController::class, 'verification'])->name('2fa.verification');
Route::post('/2fa/verify', [App\Http\Controllers\HomeController::class, 'verify'])->name('2fa.verify');

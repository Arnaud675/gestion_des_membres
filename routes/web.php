<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CotisationController;
use App\Http\Controllers\Members\MemberController;
use Illuminate\Support\Facades\Route;

// Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Zone admin
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Gestion des membres
Route::middleware('auth')->group(function () {
    Route::resource('members', MemberController::class);
});

Route::middleware('auth')->group(function () {
    Route::resource('cotisations', CotisationController::class);
});

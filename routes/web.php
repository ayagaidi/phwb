<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerController;

Route::get('/', function () {
    return view('welcome');
});

// Admin Control Panel Routes (under dashbord)
Route::prefix('admin')->group(function () {
    Route::get('/login', [OwnerController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [OwnerController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [OwnerController::class, 'logout'])->name('admin.logout');
    
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('admin.dashboard');
    });
});

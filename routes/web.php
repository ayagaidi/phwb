<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// Admin Control Panel Routes (under dashbord)
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::patch('/users/{id}/toggle', [AdminController::class, 'toggleUser'])->name('admin.users.toggle');

        // Programs
        Route::get('/programs', [AdminController::class, 'programs'])->name('admin.programs');
        Route::get('/programs/create', [AdminController::class, 'createProgram'])->name('admin.programs.create');
        Route::post('/programs', [AdminController::class, 'storeProgram'])->name('admin.programs.store');
        Route::get('/programs/{id}/edit', [AdminController::class, 'editProgram'])->name('admin.programs.edit');
        Route::put('/programs/{id}', [AdminController::class, 'updateProgram'])->name('admin.programs.update');
        Route::patch('/programs/{id}/toggle', [AdminController::class, 'toggleProgram'])->name('admin.programs.toggle');
        Route::delete('/programs/{id}', [AdminController::class, 'destroyProgram'])->name('admin.programs.destroy');
        Route::delete('/programs/{id}/image', [AdminController::class, 'deleteProgramImage'])->name('admin.programs.delete-image');
    });
});

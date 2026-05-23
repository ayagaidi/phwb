<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

// ==================== PUBLIC MODERN SITE ====================
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/', [App\Http\Controllers\SiteController::class, 'home'])->name('site.home');
Route::get('/programs', [App\Http\Controllers\SiteController::class, 'programs'])->name('site.programs');
Route::get('/volunteer', [App\Http\Controllers\SiteController::class, 'volunteer'])->name('site.volunteer');
Route::get('/membership', [App\Http\Controllers\SiteController::class, 'membership'])->name('site.membership');
Route::post('/membership', [App\Http\Controllers\SiteController::class, 'storeMembership'])->name('site.membership.store');
Route::get('/articles', [App\Http\Controllers\SiteController::class, 'articles'])->name('site.articles');
Route::get('/org-structure', [App\Http\Controllers\SiteController::class, 'org'])->name('site.org');
Route::get('/contact', [App\Http\Controllers\SiteController::class, 'contact'])->name('site.contact');

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// Admin Control Panel Routes (under dashbord)
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    // Language switcher (available even on login page)
    Route::get('/lang/{locale}', [AdminController::class, 'switchLanguage'])->name('admin.lang');

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

        // Volunteer Page Content
        Route::get('/volunteer-content', [AdminController::class, 'volunteerContent'])->name('admin.volunteer-content');
        Route::post('/volunteer-content', [AdminController::class, 'updateVolunteerContent'])->name('admin.volunteer-content.update');

        // Articles & News
        Route::get('/articles', [AdminController::class, 'articles'])->name('admin.articles');
        Route::get('/articles/create', [AdminController::class, 'createArticle'])->name('admin.articles.create');
        Route::post('/articles', [AdminController::class, 'storeArticle'])->name('admin.articles.store');
        Route::get('/articles/{id}/edit', [AdminController::class, 'editArticle'])->name('admin.articles.edit');
        Route::put('/articles/{id}', [AdminController::class, 'updateArticle'])->name('admin.articles.update');
        Route::patch('/articles/{id}/toggle', [AdminController::class, 'toggleArticle'])->name('admin.articles.toggle');
        Route::delete('/articles/{id}', [AdminController::class, 'destroyArticle'])->name('admin.articles.destroy');

        // Donation Methods
        Route::get('/donation-methods', [AdminController::class, 'donationMethods'])->name('admin.donation-methods');
        Route::get('/donation-methods/create', [AdminController::class, 'createDonationMethod'])->name('admin.donation-methods.create');
        Route::post('/donation-methods', [AdminController::class, 'storeDonationMethod'])->name('admin.donation-methods.store');
        Route::delete('/donation-methods/{id}', [AdminController::class, 'destroyDonationMethod'])->name('admin.donation-methods.destroy');

        // Organizational Structure
        Route::get('/org-structure', [AdminController::class, 'orgStructure'])->name('admin.org-structure');
        Route::get('/org-structure/create', [AdminController::class, 'createOrgUnit'])->name('admin.org-structure.create');
        Route::post('/org-structure', [AdminController::class, 'storeOrgUnit'])->name('admin.org-structure.store');
        Route::get('/org-structure/{id}/edit', [AdminController::class, 'editOrgUnit'])->name('admin.org-structure.edit');
        Route::put('/org-structure/{id}', [AdminController::class, 'updateOrgUnit'])->name('admin.org-structure.update');
        Route::delete('/org-structure/{id}', [AdminController::class, 'destroyOrgUnit'])->name('admin.org-structure.destroy');

        // Contact Settings
        Route::get('/contact-settings', [AdminController::class, 'contactSettings'])->name('admin.contact-settings');
        Route::post('/contact-settings', [AdminController::class, 'updateContactSettings'])->name('admin.contact-settings.update');

        // Profile
        Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::put('/profile/password', [AdminController::class, 'updatePassword'])->name('admin.profile.update-password');
    });
});

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
Route::get('/programs/{program}', [App\Http\Controllers\SiteController::class, 'showProgram'])->name('site.programs.show');
Route::get('/volunteer', [App\Http\Controllers\SiteController::class, 'volunteer'])->name('site.volunteer');
Route::get('/membership', [App\Http\Controllers\SiteController::class, 'membership'])->name('site.membership');
Route::post('/membership', [App\Http\Controllers\SiteController::class, 'storeMembership'])->name('site.membership.store');
Route::get('/articles', [App\Http\Controllers\SiteController::class, 'articles'])->name('site.articles');
Route::get('/articles/{article}', [App\Http\Controllers\SiteController::class, 'showArticle'])->name('site.articles.show');
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
        Route::get('/users', [AdminController::class, 'users'])->middleware('admin.permission:users,view')->name('admin.users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->middleware('admin.permission:users,create')->name('admin.users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->middleware('admin.permission:users,create')->name('admin.users.store');
        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->middleware('admin.permission:users,edit')->name('admin.users.edit');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->middleware('admin.permission:users,edit')->name('admin.users.update');
        Route::patch('/users/{id}/toggle', [AdminController::class, 'toggleUser'])->middleware('admin.permission:users,edit')->name('admin.users.toggle');
        Route::get('/users/{id}/permissions', [AdminController::class, 'permissions'])->middleware('admin.permission:users,edit')->name('admin.users.permissions');
        Route::put('/users/{id}/permissions', [AdminController::class, 'updatePermissions'])->middleware('admin.permission:users,edit')->name('admin.users.permissions.update');

         // Sliders
        Route::get('/sliders', [AdminController::class, 'sliders'])->middleware('admin.permission:sliders,view')->name('admin.sliders');
        Route::get('/sliders/create', [AdminController::class, 'createSlider'])->middleware('admin.permission:sliders,create')->name('admin.sliders.create');
        Route::post('/sliders', [AdminController::class, 'storeSlider'])->middleware('admin.permission:sliders,create')->name('admin.sliders.store');
        Route::get('/sliders/{id}/edit', [AdminController::class, 'editSlider'])->middleware('admin.permission:sliders,edit')->name('admin.sliders.edit');
        Route::put('/sliders/{id}', [AdminController::class, 'updateSlider'])->middleware('admin.permission:sliders,edit')->name('admin.sliders.update');
        Route::patch('/sliders/{id}/toggle', [AdminController::class, 'toggleSlider'])->middleware('admin.permission:sliders,edit')->name('admin.sliders.toggle');
        Route::delete('/sliders/{id}', [AdminController::class, 'destroySlider'])->middleware('admin.permission:sliders,delete')->name('admin.sliders.destroy');

        // Programs
        Route::get('/programs', [AdminController::class, 'programs'])->middleware('admin.permission:programs,view')->name('admin.programs');
        Route::get('/programs/create', [AdminController::class, 'createProgram'])->middleware('admin.permission:programs,create')->name('admin.programs.create');
        Route::post('/programs', [AdminController::class, 'storeProgram'])->middleware('admin.permission:programs,create')->name('admin.programs.store');
        Route::get('/programs/{id}/edit', [AdminController::class, 'editProgram'])->middleware('admin.permission:programs,edit')->name('admin.programs.edit');
        Route::put('/programs/{id}', [AdminController::class, 'updateProgram'])->middleware('admin.permission:programs,edit')->name('admin.programs.update');
        Route::patch('/programs/{id}/toggle', [AdminController::class, 'toggleProgram'])->middleware('admin.permission:programs,edit')->name('admin.programs.toggle');
        Route::delete('/programs/{id}', [AdminController::class, 'destroyProgram'])->middleware('admin.permission:programs,delete')->name('admin.programs.destroy');
        Route::delete('/programs/{id}/image', [AdminController::class, 'deleteProgramImage'])->middleware('admin.permission:programs,edit')->name('admin.programs.delete-image');

        // Volunteer Page Content
        Route::get('/volunteer-content', [AdminController::class, 'volunteerContent'])->middleware('admin.permission:volunteer-content,view')->name('admin.volunteer-content');
        Route::post('/volunteer-content', [AdminController::class, 'updateVolunteerContent'])->middleware('admin.permission:volunteer-content,update')->name('admin.volunteer-content.update');

        // Articles & News
        Route::get('/articles', [AdminController::class, 'articles'])->middleware('admin.permission:articles,view')->name('admin.articles');
        Route::get('/articles/create', [AdminController::class, 'createArticle'])->middleware('admin.permission:articles,create')->name('admin.articles.create');
        Route::post('/articles', [AdminController::class, 'storeArticle'])->middleware('admin.permission:articles,create')->name('admin.articles.store');
        Route::get('/articles/{id}/edit', [AdminController::class, 'editArticle'])->middleware('admin.permission:articles,edit')->name('admin.articles.edit');
        Route::put('/articles/{id}', [AdminController::class, 'updateArticle'])->middleware('admin.permission:articles,edit')->name('admin.articles.update');
        Route::patch('/articles/{id}/toggle', [AdminController::class, 'toggleArticle'])->middleware('admin.permission:articles,edit')->name('admin.articles.toggle');
        Route::delete('/articles/{id}', [AdminController::class, 'destroyArticle'])->middleware('admin.permission:articles,delete')->name('admin.articles.destroy');

        // Donation Methods
        Route::get('/donation-methods', [AdminController::class, 'donationMethods'])->middleware('admin.permission:donation-methods,view')->name('admin.donation-methods');
        Route::get('/donation-methods/create', [AdminController::class, 'createDonationMethod'])->middleware('admin.permission:donation-methods,create')->name('admin.donation-methods.create');
        Route::post('/donation-methods', [AdminController::class, 'storeDonationMethod'])->middleware('admin.permission:donation-methods,create')->name('admin.donation-methods.store');
        Route::get('/donation-methods/{id}/edit', [AdminController::class, 'editDonationMethod'])->middleware('admin.permission:donation-methods,edit')->name('admin.donation-methods.edit');
        Route::put('/donation-methods/{id}', [AdminController::class, 'updateDonationMethod'])->middleware('admin.permission:donation-methods,edit')->name('admin.donation-methods.update');
        Route::delete('/donation-methods/{id}', [AdminController::class, 'destroyDonationMethod'])->middleware('admin.permission:donation-methods,delete')->name('admin.donation-methods.destroy');

        // Membership Applications
        Route::get('/membership-applications', [AdminController::class, 'membershipApplications'])->middleware('admin.permission:membership-applications,view')->name('admin.membership-applications');
        Route::get('/membership-applications/export', [AdminController::class, 'exportMembershipApplications'])->middleware('admin.permission:membership-applications,export')->name('admin.membership-applications.export');

        Route::post('/membership-applications/mark-all-read', [AdminController::class, 'markAllMembershipAsRead'])->middleware('admin.permission:membership-applications,update')->name('admin.membership-applications.mark-all-read');

        Route::get('/membership-applications/{id}', [AdminController::class, 'showMembershipApplication'])->middleware('admin.permission:membership-applications,view')->name('admin.membership-applications.show');
        Route::put('/membership-applications/{id}', [AdminController::class, 'updateMembershipApplication'])->middleware('admin.permission:membership-applications,update')->name('admin.membership-applications.update');
        Route::post('/membership-applications/{id}/mark-read', [AdminController::class, 'markMembershipAsRead'])->middleware('admin.permission:membership-applications,update')->name('admin.membership-applications.mark-read');

        // Organizational Structure
        Route::get('/org-structure', [AdminController::class, 'orgStructure'])->middleware('admin.permission:org-structure,view')->name('admin.org-structure');
        Route::get('/org-structure/create', [AdminController::class, 'createOrgUnit'])->middleware('admin.permission:org-structure,create')->name('admin.org-structure.create');
        Route::post('/org-structure', [AdminController::class, 'storeOrgUnit'])->middleware('admin.permission:org-structure,create')->name('admin.org-structure.store');
        Route::get('/org-structure/{id}/edit', [AdminController::class, 'editOrgUnit'])->middleware('admin.permission:org-structure,edit')->name('admin.org-structure.edit');
        Route::put('/org-structure/{id}', [AdminController::class, 'updateOrgUnit'])->middleware('admin.permission:org-structure,edit')->name('admin.org-structure.update');
        Route::delete('/org-structure/{id}', [AdminController::class, 'destroyOrgUnit'])->middleware('admin.permission:org-structure,delete')->name('admin.org-structure.destroy');

        // Contact Settings
        Route::get('/contact-settings', [AdminController::class, 'contactSettings'])->middleware('admin.permission:contact-settings,view')->name('admin.contact-settings');
        Route::post('/contact-settings', [AdminController::class, 'updateContactSettings'])->middleware('admin.permission:contact-settings,update')->name('admin.contact-settings.update');

        // Profile
        Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::put('/profile/password', [AdminController::class, 'updatePassword'])->name('admin.profile.update-password');
    });
});

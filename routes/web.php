<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PeopleController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\HelpController;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Admin panel
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::resource('people', PeopleController::class);
    Route::resource('events', EventController::class);
    Route::resource('groups', GroupController::class);
    Route::resource('donations', DonationController::class)->only(['index', 'show', 'destroy']);

    // Admin kezelő
    Route::resource('users', UserController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::get('settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::resource('projects', \App\Http\Controllers\Admin\ProjectController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('tasks', \App\Http\Controllers\Admin\TaskController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::patch('tasks/{task}/status', [\App\Http\Controllers\Admin\TaskController::class, 'updateStatus'])->name('tasks.status');

    Route::get('help', [HelpController::class, 'index'])->name('help.index');
    Route::put('help/{help}', [HelpController::class, 'update'])->name('help.update');
    Route::get('sugo', [HelpController::class, 'sugo'])->name('sugo');
    Route::view('changelog', 'admin.changelog')->name('changelog');
});

require __DIR__.'/auth.php';

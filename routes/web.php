<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Admin\PeopleController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\HelpController;
use App\Http\Controllers\Admin\LinkController;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

// Locale switcher
Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

// Public event registration
Route::get('/e/ticket/{token}', [EventRegistrationController::class, 'ticket'])->name('events.ticket');
Route::get('/e/{slug}', [EventRegistrationController::class, 'show'])->name('events.public');
Route::post('/e/{slug}/register', [EventRegistrationController::class, 'register'])->name('events.register');
Route::get('/e/{slug}/confirmed', [EventRegistrationController::class, 'confirmed'])->name('events.confirmed');
Route::get('/e/{slug}/waitlisted', [EventRegistrationController::class, 'waitlisted'])->name('events.waitlisted');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Admin panel
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::get('people/export', [PeopleController::class, 'export'])->name('people.export');
    Route::post('people/import', [PeopleController::class, 'import'])->name('people.import');
    Route::post('people/filters', [PeopleController::class, 'saveFilter'])->name('people.filters.store');
    Route::delete('people/filters/{filter}', [PeopleController::class, 'deleteFilter'])->name('people.filters.destroy');
    Route::get('people/duplicates', [PeopleController::class, 'duplicates'])->name('people.duplicates');
    Route::post('people/merge', [PeopleController::class, 'merge'])->name('people.merge');
    Route::post('people/{person}/activities', [PeopleController::class, 'logActivity'])->name('people.activities.store');
    Route::delete('people/{person}/activities/{activity}', [PeopleController::class, 'deleteActivity'])->name('people.activities.destroy');
    Route::patch('people/{person}/lead', [PeopleController::class, 'updateLead'])->name('people.lead.update');
    Route::resource('people', PeopleController::class);
    Route::resource('events', EventController::class);
    Route::get('events/{event}/checkin', [EventController::class, 'checkinScanner'])->name('events.checkin');
    Route::post('events/{event}/checkin', [EventController::class, 'checkin'])->name('events.checkin.store');
    Route::post('events/{event}/checkin-manual', [EventController::class, 'checkinManual'])->name('events.checkin.manual');
    Route::delete('events/{event}/registrations/{registration}', [EventController::class, 'destroyRegistration'])->name('events.registrations.destroy');
    Route::delete('events/{event}/waitlist/{registration}', [EventController::class, 'destroyWaitlistEntry'])->name('events.waitlist.destroy');
    Route::post('events/{event}/waitlist/{registration}/promote', [EventController::class, 'promoteWaitlist'])->name('events.waitlist.promote');

    // Volunteer shifts (nested under events)
    Route::post('events/{event}/shifts', [\App\Http\Controllers\Admin\VolunteerShiftController::class, 'store'])->name('events.shifts.store');
    Route::put('events/{event}/shifts/{shift}', [\App\Http\Controllers\Admin\VolunteerShiftController::class, 'update'])->name('events.shifts.update');
    Route::delete('events/{event}/shifts/{shift}', [\App\Http\Controllers\Admin\VolunteerShiftController::class, 'destroy'])->name('events.shifts.destroy');
    Route::post('events/{event}/shifts/{shift}/signups', [\App\Http\Controllers\Admin\VolunteerShiftController::class, 'storeSignup'])->name('events.shifts.signups.store');
    Route::patch('events/{event}/shifts/{shift}/signups/{signup}/attended', [\App\Http\Controllers\Admin\VolunteerShiftController::class, 'toggleAttended'])->name('events.shifts.signups.attended');
    Route::delete('events/{event}/shifts/{shift}/signups/{signup}', [\App\Http\Controllers\Admin\VolunteerShiftController::class, 'destroySignup'])->name('events.shifts.signups.destroy');
    Route::resource('groups', GroupController::class);
    Route::post('groups/{group}/events', [GroupController::class, 'storeEvent'])->name('groups.events.store');
    Route::post('groups/{group}/files', [\App\Http\Controllers\Admin\GroupFileController::class, 'store'])->name('groups.files.store');
    Route::get('groups/{group}/files/{file}/download', [\App\Http\Controllers\Admin\GroupFileController::class, 'download'])->name('groups.files.download');
    Route::delete('groups/{group}/files/{file}', [\App\Http\Controllers\Admin\GroupFileController::class, 'destroy'])->name('groups.files.destroy');
    Route::resource('donations', DonationController::class)->only(['index', 'show', 'store', 'update', 'destroy']);

    // Admin kezelő
    Route::resource('users', UserController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::get('settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('settings/branding', [SettingsController::class, 'updateBranding'])->name('settings.branding');
    Route::post('settings/mail', [SettingsController::class, 'updateMail'])->name('settings.mail');

    Route::get('links', [LinkController::class, 'index'])->name('links.index');
    Route::post('links', [LinkController::class, 'store'])->name('links.store');
    Route::put('links/{link}', [LinkController::class, 'update'])->name('links.update');
    Route::delete('links/{link}', [LinkController::class, 'destroy'])->name('links.destroy');

    Route::resource('projects', \App\Http\Controllers\Admin\ProjectController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::post('projects/{project}/members', [\App\Http\Controllers\Admin\ProjectController::class, 'addMember'])->name('projects.members.add');
    Route::delete('projects/{project}/members/{user}', [\App\Http\Controllers\Admin\ProjectController::class, 'removeMember'])->name('projects.members.remove');
    Route::resource('tasks', \App\Http\Controllers\Admin\TaskController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::patch('tasks/{task}/status', [\App\Http\Controllers\Admin\TaskController::class, 'updateStatus'])->name('tasks.status');

    Route::get('campaigns', [\App\Http\Controllers\Admin\CampaignController::class, 'index'])->name('campaigns.index');
    Route::post('campaigns', [\App\Http\Controllers\Admin\CampaignController::class, 'store'])->name('campaigns.store');
    Route::put('campaigns/{campaign}', [\App\Http\Controllers\Admin\CampaignController::class, 'update'])->name('campaigns.update');
    Route::delete('campaigns/{campaign}', [\App\Http\Controllers\Admin\CampaignController::class, 'destroy'])->name('campaigns.destroy');
    Route::post('campaigns/{campaign}/send', [\App\Http\Controllers\Admin\CampaignController::class, 'send'])->name('campaigns.send');

    Route::get('help', [HelpController::class, 'index'])->name('help.index');
    Route::put('help/{help}', [HelpController::class, 'update'])->name('help.update');
    Route::get('sugo', [HelpController::class, 'sugo'])->name('sugo');
    Route::view('changelog', 'admin.changelog')->name('changelog');
});

require __DIR__.'/auth.php';

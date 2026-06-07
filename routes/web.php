<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DashboardWidgetController;
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
use App\Http\Controllers\PublicWebController;
use Illuminate\Support\Facades\Route;

// Public website
Route::get('/', [PublicWebController::class, 'home'])->name('public.home');
Route::get('/esemenyek', [PublicWebController::class, 'events'])->name('public.events');

// iCal feed (Google Calendar / Apple Calendar / Outlook subscription)
Route::get('/events.ics', [\App\Http\Controllers\IcalController::class, 'events'])->name('ical.events');

// Public changelog (no auth required)
Route::get('/changelog', [\App\Http\Controllers\PublicChangelogController::class, 'index'])->name('public.changelog');

// Public help (no auth required)
Route::get('/help', [\App\Http\Controllers\PublicHelpController::class, 'index'])->name('public.help');

// Locale switcher
Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

// Invitation-based registration
Route::get('/invite/{token}', [\App\Http\Controllers\InviteRegistrationController::class, 'show'])->name('invite.register');
Route::post('/invite/{token}', [\App\Http\Controllers\InviteRegistrationController::class, 'register'])->name('invite.register.submit');

// Payment callbacks
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('stripe/success/{token}', [\App\Http\Controllers\PaymentController::class, 'stripeSuccess'])->name('stripe.success');
    Route::get('stripe/cancel/{token}',  [\App\Http\Controllers\PaymentController::class, 'stripeCancel'])->name('stripe.cancel');
    Route::post('stripe/webhook',        [\App\Http\Controllers\PaymentController::class, 'stripeWebhook'])->name('stripe.webhook')
        ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
    Route::get('barion/callback/{token}', [\App\Http\Controllers\PaymentController::class, 'barionCallback'])->name('barion.callback');
    Route::get('barion/ipn',              [\App\Http\Controllers\PaymentController::class, 'barionIpn'])->name('barion.ipn');
    // Donation-specific callbacks
    Route::get('donation/stripe/success/{token}', [\App\Http\Controllers\PaymentController::class, 'stripeSuccessDonation'])->name('donation.stripe.success');
    Route::get('donation/stripe/cancel/{token}',  [\App\Http\Controllers\PaymentController::class, 'stripeCancelDonation'])->name('donation.stripe.cancel');
    Route::get('donation/barion/callback/{token}', [\App\Http\Controllers\PaymentController::class, 'barionCallbackDonation'])->name('donation.barion.callback');
});

// Email tracking (open pixel + click redirect)
Route::get('/track/open/{token}', [\App\Http\Controllers\TrackingController::class, 'open'])->name('track.open');
Route::get('/track/click/{token}', [\App\Http\Controllers\TrackingController::class, 'click'])->name('track.click');

// Unsubscribe
Route::get('/unsubscribe/{token}', [\App\Http\Controllers\UnsubscribeController::class, 'show'])->name('unsubscribe');
Route::post('/unsubscribe/{token}', [\App\Http\Controllers\UnsubscribeController::class, 'confirm'])->name('unsubscribe.confirm');
Route::post('/unsubscribe/{token}/resubscribe', [\App\Http\Controllers\UnsubscribeController::class, 'resubscribe'])->name('unsubscribe.resubscribe');

// Public donation form
Route::get('/donate',               [\App\Http\Controllers\DonationFormController::class, 'show'])->name('donate');
Route::post('/donate',              [\App\Http\Controllers\DonationFormController::class, 'submit'])->name('donate.submit');
Route::get('/donate/thanks/{token}',[\App\Http\Controllers\DonationFormController::class, 'thanks'])->name('donate.thanks');

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
    Route::post('dashboard/widgets', [DashboardWidgetController::class, 'save'])->name('dashboard.widgets');

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
    Route::get('donations/export', [\App\Http\Controllers\Admin\DonationExportController::class, 'export'])->name('donations.export');
    Route::resource('donations', DonationController::class)->only(['index', 'show', 'store', 'update', 'destroy']);

    // Admin kezelő (csak admin / super-admin)
    Route::middleware(\App\Http\Middleware\EnsureStrictAdmin::class)->group(function () {
        Route::resource('users', UserController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::post('invitations', [\App\Http\Controllers\Admin\InvitationController::class, 'store'])->name('invitations.store');
        Route::post('invitations/{invitation}/resend', [\App\Http\Controllers\Admin\InvitationController::class, 'resend'])->name('invitations.resend');
        Route::delete('invitations/{invitation}', [\App\Http\Controllers\Admin\InvitationController::class, 'destroy'])->name('invitations.destroy');
        Route::get('audit', [\App\Http\Controllers\Admin\AuditController::class, 'index'])->name('audit');
        Route::get('settings', [SettingsController::class, 'index'])->name('settings');
        Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::post('settings/branding', [SettingsController::class, 'updateBranding'])->name('settings.branding');
        Route::post('settings/mail', [SettingsController::class, 'updateMail'])->name('settings.mail');
        Route::post('settings/report', [SettingsController::class, 'updateReport'])->name('settings.report');
        Route::post('settings/report/test', [SettingsController::class, 'testReport'])->name('settings.report.test');
        Route::post('settings/payment', [SettingsController::class, 'updatePayment'])->name('settings.payment');
        Route::post('settings/donation', [SettingsController::class, 'updateDonationPage'])->name('settings.donation');
        Route::post('settings/website', [SettingsController::class, 'updateWebsite'])->name('settings.website');
        Route::get('website', [SettingsController::class, 'website'])->name('website');
    });

    Route::get('links', [LinkController::class, 'index'])->name('links.index');
    Route::post('links', [LinkController::class, 'store'])->name('links.store');
    Route::put('links/{link}', [LinkController::class, 'update'])->name('links.update');
    Route::delete('links/{link}', [LinkController::class, 'destroy'])->name('links.destroy');

    Route::resource('projects', \App\Http\Controllers\Admin\ProjectController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::post('projects/{project}/members', [\App\Http\Controllers\Admin\ProjectController::class, 'addMember'])->name('projects.members.add');
    Route::delete('projects/{project}/members/{user}', [\App\Http\Controllers\Admin\ProjectController::class, 'removeMember'])->name('projects.members.remove');
    Route::resource('tasks', \App\Http\Controllers\Admin\TaskController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::patch('tasks/{task}/status', [\App\Http\Controllers\Admin\TaskController::class, 'updateStatus'])->name('tasks.status');
    Route::post('tasks/{task}/comments', [\App\Http\Controllers\Admin\TaskCommentController::class, 'store'])->name('tasks.comments.store');
    Route::delete('tasks/{task}/comments/{comment}', [\App\Http\Controllers\Admin\TaskCommentController::class, 'destroy'])->name('tasks.comments.destroy');
    Route::post('tasks/{task}/attachments', [\App\Http\Controllers\Admin\TaskAttachmentController::class, 'store'])->name('tasks.attachments.store');
    Route::get('tasks/{task}/attachments/{attachment}/download', [\App\Http\Controllers\Admin\TaskAttachmentController::class, 'download'])->name('tasks.attachments.download');
    Route::delete('tasks/{task}/attachments/{attachment}', [\App\Http\Controllers\Admin\TaskAttachmentController::class, 'destroy'])->name('tasks.attachments.destroy');

    // Drip campaigns
    Route::get('drip-campaigns', [\App\Http\Controllers\Admin\DripCampaignController::class, 'index'])->name('drip-campaigns.index');
    Route::post('drip-campaigns', [\App\Http\Controllers\Admin\DripCampaignController::class, 'store'])->name('drip-campaigns.store');
    Route::get('drip-campaigns/{dripCampaign}', [\App\Http\Controllers\Admin\DripCampaignController::class, 'show'])->name('drip-campaigns.show');
    Route::put('drip-campaigns/{dripCampaign}', [\App\Http\Controllers\Admin\DripCampaignController::class, 'update'])->name('drip-campaigns.update');
    Route::delete('drip-campaigns/{dripCampaign}', [\App\Http\Controllers\Admin\DripCampaignController::class, 'destroy'])->name('drip-campaigns.destroy');
    Route::post('drip-campaigns/{dripCampaign}/toggle-status', [\App\Http\Controllers\Admin\DripCampaignController::class, 'toggleStatus'])->name('drip-campaigns.toggle-status');
    Route::post('drip-campaigns/{dripCampaign}/steps', [\App\Http\Controllers\Admin\DripCampaignController::class, 'storeStep'])->name('drip-campaigns.steps.store');
    Route::put('drip-campaigns/{dripCampaign}/steps/{step}', [\App\Http\Controllers\Admin\DripCampaignController::class, 'updateStep'])->name('drip-campaigns.steps.update');
    Route::delete('drip-campaigns/{dripCampaign}/steps/{step}', [\App\Http\Controllers\Admin\DripCampaignController::class, 'destroyStep'])->name('drip-campaigns.steps.destroy');
    Route::post('drip-campaigns/{dripCampaign}/enroll', [\App\Http\Controllers\Admin\DripCampaignController::class, 'enroll'])->name('drip-campaigns.enroll');
    Route::post('drip-campaigns/{dripCampaign}/enrollments/{enrollment}/cancel', [\App\Http\Controllers\Admin\DripCampaignController::class, 'cancelEnrollment'])->name('drip-campaigns.enrollments.cancel');

    Route::get('campaigns/recipient-count', [\App\Http\Controllers\Admin\CampaignController::class, 'recipientCount'])->name('campaigns.recipient-count');
    Route::get('campaigns', [\App\Http\Controllers\Admin\CampaignController::class, 'index'])->name('campaigns.index');
    Route::post('campaigns', [\App\Http\Controllers\Admin\CampaignController::class, 'store'])->name('campaigns.store');
    Route::put('campaigns/{campaign}', [\App\Http\Controllers\Admin\CampaignController::class, 'update'])->name('campaigns.update');
    Route::delete('campaigns/{campaign}', [\App\Http\Controllers\Admin\CampaignController::class, 'destroy'])->name('campaigns.destroy');
    Route::post('campaigns/{campaign}/send', [\App\Http\Controllers\Admin\CampaignController::class, 'send'])->name('campaigns.send');

    Route::get('email-templates/api', [\App\Http\Controllers\Admin\EmailTemplateController::class, 'apiList'])->name('email-templates.api');
    Route::get('email-templates/{emailTemplate}/preview', [\App\Http\Controllers\Admin\EmailTemplateController::class, 'preview'])->name('email-templates.preview');
    Route::resource('email-templates', \App\Http\Controllers\Admin\EmailTemplateController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::get('help', [HelpController::class, 'index'])->name('help.index');
    Route::put('help/{help}', [HelpController::class, 'update'])->name('help.update');
    Route::get('sugo', [HelpController::class, 'sugo'])->name('sugo');
    Route::view('changelog', 'admin.changelog')->name('changelog');

    // Integrations
    Route::get('integrations', [\App\Http\Controllers\Admin\IntegrationsController::class, 'index'])->name('integrations');
    Route::post('integrations/facebook', [\App\Http\Controllers\Admin\IntegrationsController::class, 'updateFacebook'])->name('integrations.facebook');
    Route::post('events/{event}/publish-facebook', [EventController::class, 'publishToFacebook'])->name('events.publish-facebook');

    Route::get('webhooks', [\App\Http\Controllers\Admin\WebhookController::class, 'index'])->name('webhooks.index');
    Route::post('webhooks', [\App\Http\Controllers\Admin\WebhookController::class, 'store'])->name('webhooks.store');
    Route::put('webhooks/{webhook}', [\App\Http\Controllers\Admin\WebhookController::class, 'update'])->name('webhooks.update');
    Route::patch('webhooks/{webhook}/toggle', [\App\Http\Controllers\Admin\WebhookController::class, 'toggleActive'])->name('webhooks.toggle');
    Route::delete('webhooks/{webhook}', [\App\Http\Controllers\Admin\WebhookController::class, 'destroy'])->name('webhooks.destroy');
    Route::get('webhooks/{webhook}/deliveries', [\App\Http\Controllers\Admin\WebhookController::class, 'deliveries'])->name('webhooks.deliveries');
    Route::post('webhooks/{webhook}/deliveries/{delivery}/retry', [\App\Http\Controllers\Admin\WebhookController::class, 'retry'])->name('webhooks.retry');
});

Route::get('/demo-login', \App\Http\Controllers\Auth\DemoLoginController::class)
    ->middleware('guest')
    ->name('demo.login');

require __DIR__.'/auth.php';

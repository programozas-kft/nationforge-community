<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ScheduledReportMail;
use App\Models\Donation;
use App\Models\Event;
use App\Models\Link;
use App\Models\Person;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'app_name'    => config('app.name'),
            'app_url'     => config('app.url'),
            'app_locale'  => config('app.locale'),
            'mail_from'   => config('mail.from.address'),
            'mail_name'   => config('mail.from.name'),
        ];
        $mailConfig = [
            'mailer'    => config('mail.default', 'log'),
            'host'      => env('MAIL_HOST', '127.0.0.1'),
            'port'      => env('MAIL_PORT', 587),
            'scheme'    => env('MAIL_SCHEME', 'tls'),
            'username'  => env('MAIL_USERNAME', ''),
            'has_pass'  => !empty(env('MAIL_PASSWORD')),
            'resend_key'=> !empty(env('RESEND_API_KEY')),
        ];
        $branding = [
            'org_name'      => Setting::get('brand_org_name', config('app.name')),
            'primary_color' => Setting::get('brand_primary_color', '#405189'),
            'logo'          => Setting::get('brand_logo'),
        ];
        $reportConfig = [
            'enabled'       => Setting::get('report_enabled', '0') === '1',
            'frequency'     => Setting::get('report_frequency', 'weekly'),
            'day_of_week'   => (int) Setting::get('report_day_of_week', 1),
            'day_of_month'  => (int) Setting::get('report_day_of_month', 1),
            'hour'          => (int) Setting::get('report_hour', 8),
            'recipients'    => Setting::get('report_recipients', ''),
        ];
        $donationConfig = [
            'enabled'     => Setting::get('donation_page_enabled', '0') === '1',
            'title'       => Setting::get('donation_page_title', ''),
            'description' => Setting::get('donation_page_description', ''),
            'presets'     => Setting::get('donation_presets', '1000,2000,5000,10000'),
            'currency'    => Setting::get('donation_currency', 'HUF'),
            'campaign'    => Setting::get('donation_campaign', ''),
            'bank_name'   => Setting::get('donation_bank_name', ''),
            'bank_iban'   => Setting::get('donation_bank_iban', ''),
            'bank_note'   => Setting::get('donation_bank_note', ''),
        ];
        $paymentConfig = [
            'provider' => Setting::get('payment_provider', ''),
        ];
        $links = Link::orderBy('sort_order')->orderBy('title')->get();
        return view('admin.settings.index', compact('settings', 'mailConfig', 'branding', 'reportConfig', 'donationConfig', 'paymentConfig', 'links'));
    }

    public function updateBranding(Request $request)
    {
        $request->validate([
            'org_name'      => 'nullable|string|max:100',
            'primary_color' => 'nullable|string|max:7',
            'logo'          => 'nullable|image|mimes:png,jpg,jpeg,svg|max:1024',
        ]);

        if ($request->filled('org_name')) {
            Setting::set('brand_org_name', $request->org_name);
        }
        if ($request->filled('primary_color')) {
            Setting::set('brand_primary_color', $request->primary_color);
        }
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->storeAs('branding', 'logo.' . $request->file('logo')->extension(), 'public');
            Setting::set('brand_logo', $path);
        }
        if ($request->boolean('remove_logo')) {
            Setting::set('brand_logo', null);
        }

        return redirect()->route('admin.settings')->with('success', __('settings.branding_saved'));
    }

    public function update(Request $request)
    {
        $map = [
            'app_name'   => 'APP_NAME',
            'mail_from'  => 'MAIL_FROM_ADDRESS',
            'mail_name'  => 'MAIL_FROM_NAME',
        ];

        $envPath = base_path('.env');
        $env = file_get_contents($envPath);

        foreach ($map as $field => $key) {
            if ($request->has($field)) {
                $this->writeEnv($env, $key, $request->input($field));
            }
        }

        file_put_contents($envPath, $env);
        Artisan::call('config:clear');

        return redirect()->route('admin.settings')->with('success', __('settings.saved'));
    }

    public function updateMail(Request $request)
    {
        $request->validate([
            'mail_mailer'    => 'required|in:smtp,resend,log',
            'mail_host'      => 'nullable|string|max:200',
            'mail_port'      => 'nullable|integer|min:1|max:65535',
            'mail_scheme'    => 'nullable|in:tls,ssl,null',
            'mail_username'  => 'nullable|string|max:200',
            'mail_password'  => 'nullable|string|max:300',
            'resend_api_key' => 'nullable|string|max:300',
        ]);

        $envPath = base_path('.env');
        $env = file_get_contents($envPath);

        $this->writeEnv($env, 'MAIL_MAILER', $request->mail_mailer);

        if ($request->mail_mailer === 'smtp') {
            $this->writeEnv($env, 'MAIL_HOST',   $request->input('mail_host', '127.0.0.1'));
            $this->writeEnv($env, 'MAIL_PORT',   $request->input('mail_port', '587'));
            $this->writeEnv($env, 'MAIL_SCHEME',  $request->input('mail_scheme', 'tls'));
            $this->writeEnv($env, 'MAIL_USERNAME', $request->input('mail_username', ''));
            if ($request->filled('mail_password')) {
                $this->writeEnv($env, 'MAIL_PASSWORD', $request->mail_password);
            }
        }

        if ($request->mail_mailer === 'resend' && $request->filled('resend_api_key')) {
            $this->writeEnv($env, 'RESEND_API_KEY', $request->resend_api_key);
        }

        file_put_contents($envPath, $env);
        Artisan::call('config:clear');

        return redirect()->route('admin.settings')->with('success', __('settings.mail_saved'));
    }

    public function updatePayment(Request $request)
    {
        $request->validate([
            'payment_provider'    => 'nullable|in:,stripe,barion',
            'stripe_publishable'  => 'nullable|string|max:200',
            'stripe_secret'       => 'nullable|string|max:200',
            'stripe_webhook_sec'  => 'nullable|string|max:200',
            'barion_api_key'      => 'nullable|string|max:200',
            'barion_merchant'     => 'nullable|email|max:150',
            'barion_environment'  => 'nullable|in:test,live',
        ]);

        Setting::set('payment_provider', $request->input('payment_provider', ''));

        if ($request->filled('stripe_publishable')) {
            Setting::set('stripe_publishable_key', $request->stripe_publishable);
        }
        if ($request->filled('stripe_secret')) {
            Setting::set('stripe_secret_key', $request->stripe_secret);
        }
        if ($request->filled('stripe_webhook_sec')) {
            Setting::set('stripe_webhook_secret', $request->stripe_webhook_sec);
        }
        if ($request->filled('barion_api_key')) {
            Setting::set('barion_api_key', $request->barion_api_key);
        }
        if ($request->filled('barion_merchant')) {
            Setting::set('barion_merchant_email', $request->barion_merchant);
        }
        Setting::set('barion_environment', $request->input('barion_environment', 'test'));

        return redirect()->route('admin.settings')->with('success', __('settings.payment_saved'));
    }

    public function updateReport(Request $request)
    {
        $request->validate([
            'report_enabled'      => 'nullable|boolean',
            'report_frequency'    => 'required|in:daily,weekly,monthly',
            'report_day_of_week'  => 'nullable|integer|min:1|max:7',
            'report_day_of_month' => 'nullable|integer|min:1|max:28',
            'report_hour'         => 'required|integer|min:0|max:23',
            'report_recipients'   => 'nullable|string|max:1000',
        ]);

        Setting::set('report_enabled',      $request->boolean('report_enabled') ? '1' : '0');
        Setting::set('report_frequency',    $request->report_frequency);
        Setting::set('report_day_of_week',  $request->input('report_day_of_week', 1));
        Setting::set('report_day_of_month', $request->input('report_day_of_month', 1));
        Setting::set('report_hour',         $request->report_hour);
        Setting::set('report_recipients',   $request->input('report_recipients', ''));

        return redirect()->route('admin.settings')->with('success', __('settings.report_saved'));
    }

    public function updateDonationPage(Request $request)
    {
        $request->validate([
            'donation_page_title'       => 'nullable|string|max:150',
            'donation_page_description' => 'nullable|string|max:500',
            'donation_presets'          => 'nullable|string|max:100',
            'donation_currency'         => 'nullable|in:HUF,EUR,USD',
            'donation_campaign'         => 'nullable|string|max:100',
            'donation_bank_name'        => 'nullable|string|max:150',
            'donation_bank_iban'        => 'nullable|string|max:50',
            'donation_bank_note'        => 'nullable|string|max:200',
        ]);

        Setting::set('donation_page_enabled',     $request->boolean('donation_page_enabled') ? '1' : '0');
        Setting::set('donation_page_title',       $request->input('donation_page_title', ''));
        Setting::set('donation_page_description', $request->input('donation_page_description', ''));
        Setting::set('donation_presets',          $request->input('donation_presets', '1000,2000,5000,10000'));
        Setting::set('donation_currency',         $request->input('donation_currency', 'HUF'));
        Setting::set('donation_campaign',         $request->input('donation_campaign', ''));
        Setting::set('donation_bank_name',        $request->input('donation_bank_name', ''));
        Setting::set('donation_bank_iban',        $request->input('donation_bank_iban', ''));
        Setting::set('donation_bank_note',        $request->input('donation_bank_note', ''));

        return redirect()->route('admin.settings')->with('success', __('settings.donation_saved'));
    }

    public function testReport(Request $request)
    {
        $recipients = array_filter(array_map('trim', explode(',', Setting::get('report_recipients', ''))));

        if (empty($recipients)) {
            return response()->json(['ok' => false, 'message' => __('settings.report_send_error')]);
        }

        $stats = [
            'people'          => Person::count(),
            'new_people'      => Person::whereMonth('created_at', now()->month)->count(),
            'events'          => Event::whereNotIn('status', ['cancelled', 'completed'])->where('starts_at', '>', now())->count(),
            'donations'       => Donation::where('status', 'completed')->sum('amount'),
            'subscribed'      => Person::where('is_subscribed', true)->count(),
            'recent_people'   => Person::latest()->limit(5)->get(),
            'upcoming_events' => Event::whereNotIn('status', ['cancelled', 'completed'])
                ->where('starts_at', '>', now())->orderBy('starts_at')->limit(5)->get(),
            'generated_at'    => now(),
        ];

        foreach ($recipients as $email) {
            Mail::to($email)->send(new ScheduledReportMail($stats));
        }

        return response()->json(['ok' => true]);
    }

    private function writeEnv(string &$env, string $key, string $value): void
    {
        $escaped = str_contains($value, ' ') ? '"' . addslashes($value) . '"' : $value;
        if (preg_match("/^{$key}=/m", $env)) {
            $env = preg_replace("/^{$key}=.*/m", "{$key}={$escaped}", $env);
        } else {
            $env .= "\n{$key}={$escaped}";
        }
    }
}

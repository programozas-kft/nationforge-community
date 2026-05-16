<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

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
        $links = Link::orderBy('sort_order')->orderBy('title')->get();
        return view('admin.settings.index', compact('settings', 'mailConfig', 'branding', 'links'));
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

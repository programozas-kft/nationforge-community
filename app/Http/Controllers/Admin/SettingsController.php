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
        $branding = [
            'org_name'      => Setting::get('brand_org_name', config('app.name')),
            'primary_color' => Setting::get('brand_primary_color', '#405189'),
            'logo'          => Setting::get('brand_logo'),
        ];
        $links = Link::orderBy('sort_order')->orderBy('title')->get();
        return view('admin.settings.index', compact('settings', 'branding', 'links'));
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
        // Beállítások mentése .env fájlba
        $map = [
            'app_name'   => 'APP_NAME',
            'mail_from'  => 'MAIL_FROM_ADDRESS',
            'mail_name'  => 'MAIL_FROM_NAME',
        ];

        $envPath = base_path('.env');
        $env = file_get_contents($envPath);

        foreach ($map as $field => $key) {
            if ($request->has($field)) {
                $value = $request->input($field);
                $env = preg_replace("/^{$key}=.*/m", "{$key}=\"{$value}\"", $env);
            }
        }

        file_put_contents($envPath, $env);
        Artisan::call('config:clear');

        return redirect()->route('admin.settings')->with('success', 'Beállítások mentve!');
    }
}

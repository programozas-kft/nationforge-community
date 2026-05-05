<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Link;
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
        $links = Link::orderBy('sort_order')->orderBy('title')->get();
        return view('admin.settings.index', compact('settings', 'links'));
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

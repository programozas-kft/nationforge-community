<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $default = Setting::get('default_locale', config('app.locale', 'hu'));
        App::setLocale(session('locale', $default));

        return $next($request);
    }
}

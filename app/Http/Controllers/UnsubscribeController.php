<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Setting;
use Illuminate\Http\Request;

class UnsubscribeController extends Controller
{
    public function show(string $token)
    {
        $person  = Person::where('unsubscribe_token', $token)->firstOrFail();
        $orgName = Setting::get('brand_org_name', config('app.name'));

        return view('public.unsubscribe', compact('person', 'token', 'orgName'));
    }

    public function confirm(string $token)
    {
        $person = Person::where('unsubscribe_token', $token)->firstOrFail();
        $person->update(['is_subscribed' => false]);

        return redirect()->route('unsubscribe', $token)
            ->with('unsubscribed', true);
    }

    public function resubscribe(string $token)
    {
        $person = Person::where('unsubscribe_token', $token)->firstOrFail();
        $person->update(['is_subscribed' => true]);

        return redirect()->route('unsubscribe', $token)
            ->with('resubscribed', true);
    }
}

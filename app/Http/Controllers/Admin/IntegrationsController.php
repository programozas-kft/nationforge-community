<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\WebhookService;
use Illuminate\Http\Request;

class IntegrationsController extends Controller
{
    public function index()
    {
        $fbPageId    = Setting::get('fb_page_id', '');
        $fbConfigured = !empty($fbPageId) && !empty(Setting::get('fb_page_access_token', ''));
        $icalUrl     = url('/events.ics');
        $eventTypes  = WebhookService::allEventTypes();

        return view('admin.integrations.index', compact('fbPageId', 'fbConfigured', 'icalUrl', 'eventTypes'));
    }

    public function updateFacebook(Request $request)
    {
        $request->validate([
            'fb_page_id'           => 'nullable|string|max:100',
            'fb_page_access_token' => 'nullable|string|max:500',
        ]);

        Setting::set('fb_page_id',           $request->input('fb_page_id', ''));
        Setting::set('fb_page_access_token', $request->input('fb_page_access_token', ''));

        return redirect()->route('admin.integrations')->with('success', __('integrations.settings_saved'));
    }
}

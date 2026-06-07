<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Setting;

class PublicWebController extends Controller
{
    public function home()
    {
        $cfg = [
            'hero_title'    => Setting::get('web_hero_title', Setting::get('brand_org_name', config('app.name'))),
            'hero_subtitle' => Setting::get('web_hero_subtitle', ''),
            'hero_image'    => Setting::get('web_hero_image', ''),
            'intro'         => Setting::get('web_intro', ''),
            'who_title'     => Setting::get('web_who_title', 'Neked szól ez az oldal, ha...'),
            'who_text'      => Setting::get('web_who_text', ''),
            'problems'      => array_filter(array_map('trim', explode("\n", Setting::get('web_problems', '')))),
            'services'      => $this->parseServices(Setting::get('web_services', '')),
            'booking_url'   => Setting::get('web_booking_url', ''),
            'booking_label' => Setting::get('web_booking_label', 'Időpontfoglalás'),
            'show_events'   => Setting::get('web_show_events', '1') === '1',
        ];

        $upcomingEvents = $cfg['show_events']
            ? Event::where('starts_at', '>', now())
                ->whereNotIn('status', ['cancelled'])
                ->orderBy('starts_at')
                ->limit(6)
                ->get()
            : collect();

        return view('public.home', compact('cfg', 'upcomingEvents'));
    }

    public function events()
    {
        $upcoming = Event::where('starts_at', '>', now())
            ->whereNotIn('status', ['cancelled'])
            ->orderBy('starts_at')
            ->get();

        $past = Event::where('starts_at', '<=', now())
            ->orderByDesc('starts_at')
            ->limit(12)
            ->get();

        return view('public.events', compact('upcoming', 'past'));
    }

    private function parseServices(string $raw): array
    {
        $services = [];
        foreach (array_filter(array_map('trim', explode("\n", $raw))) as $line) {
            $parts = array_map('trim', explode('|', $line, 2));
            $services[] = ['title' => $parts[0], 'desc' => $parts[1] ?? ''];
        }
        return $services;
    }
}

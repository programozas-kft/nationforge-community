<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Event;
use App\Models\Person;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $stats = [
            'people'      => Person::count(),
            'new_people'  => Person::whereMonth('created_at', now()->month)->count(),
            'events'      => Event::where('status', 'published')->where('starts_at', '>', now())->count(),
            'donations'   => Donation::where('status', 'completed')->sum('amount'),
            'subscribed'  => Person::where('is_subscribed', true)->count(),
        ];

        $recent_people = Person::latest()->limit(5)->get();
        $upcoming_events = Event::where('status', 'published')
            ->where('starts_at', '>', now())
            ->orderBy('starts_at')
            ->limit(5)
            ->get();


        return view('admin.dashboard', compact('stats', 'recent_people', 'upcoming_events'));
    }
}

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
            'events'      => Event::whereNotIn('status', ['cancelled', 'completed'])->where('starts_at', '>', now())->count(),
            'donations'   => Donation::where('status', 'completed')->sum('amount'),
            'subscribed'  => Person::where('is_subscribed', true)->count(),
        ];

        $recent_people = Person::latest()->limit(5)->get();
        $upcoming_events = Event::whereNotIn('status', ['cancelled', 'completed'])
            ->where('starts_at', '>', now())
            ->orderBy('starts_at')
            ->limit(5)
            ->get();

        // Grafikon adatok – utolsó 12 hónap
        $huMonths = ['jan','feb','már','ápr','máj','jún','júl','aug','szep','okt','nov','dec'];
        $monthLabels = [];
        $monthlyPeople = [];
        $monthlyDonations = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthLabels[]      = $huMonths[$date->month - 1] . ' ' . $date->format('Y');
            $monthlyPeople[]    = Person::whereYear('created_at', $date->year)
                                        ->whereMonth('created_at', $date->month)
                                        ->count();
            $monthlyDonations[] = (int) Donation::where('status', 'completed')
                                        ->whereYear('created_at', $date->year)
                                        ->whereMonth('created_at', $date->month)
                                        ->sum('amount');
        }

        // Státusz megoszlás
        $statusLabels = [
            'prospect'   => 'Érdeklődő',
            'supporter'  => 'Támogató',
            'member'     => 'Tag',
            'volunteer'  => 'Önkéntes',
            'donor'      => 'Adományozó',
            'vip'        => 'VIP',
            'inactive'   => 'Inaktív',
        ];
        $statusRaw = Person::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $statusData   = [];
        $statusNames  = [];
        foreach ($statusLabels as $key => $label) {
            if (isset($statusRaw[$key]) && $statusRaw[$key] > 0) {
                $statusNames[] = $label;
                $statusData[]  = $statusRaw[$key];
            }
        }

        return view('admin.dashboard', compact(
            'stats', 'recent_people', 'upcoming_events',
            'monthLabels', 'monthlyPeople', 'monthlyDonations',
            'statusNames', 'statusData'
        ));
    }
}

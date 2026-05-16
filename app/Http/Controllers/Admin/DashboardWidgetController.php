<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class DashboardWidgetController extends Controller
{
    public const DEFS = [
        'stat_contacts'   => ['label_key' => 'dashboard.w_stat_contacts',   'span' => 'quarter'],
        'stat_events'     => ['label_key' => 'dashboard.w_stat_events',     'span' => 'quarter'],
        'stat_donations'  => ['label_key' => 'dashboard.w_stat_donations',  'span' => 'quarter'],
        'stat_subscribed' => ['label_key' => 'dashboard.w_stat_subscribed', 'span' => 'quarter'],
        'chart_donations' => ['label_key' => 'dashboard.w_chart_donations', 'span' => 'full'],
        'list_contacts'   => ['label_key' => 'dashboard.w_list_contacts',   'span' => 'half'],
        'list_events'     => ['label_key' => 'dashboard.w_list_events',     'span' => 'half'],
        'chart_growth'    => ['label_key' => 'dashboard.w_chart_growth',    'span' => 'two-thirds'],
        'chart_status'    => ['label_key' => 'dashboard.w_chart_status',    'span' => 'one-third'],
    ];

    public static function layoutForUser(int $userId): array
    {
        $saved = Setting::get('dashboard_layout_' . $userId);
        if ($saved) {
            $config = json_decode($saved, true);
            // Merge with defs to pick up any new widgets not yet in saved config
            $known = array_keys(static::DEFS);
            $savedIds = array_column($config, 'id');
            foreach ($known as $id) {
                if (!in_array($id, $savedIds)) {
                    $config[] = ['id' => $id, 'visible' => true, 'order' => count($config) + 1];
                }
            }
            usort($config, fn($a, $b) => $a['order'] <=> $b['order']);
            return $config;
        }

        // Default: all visible, default order
        return array_values(array_map(
            fn($id, $i) => ['id' => $id, 'visible' => true, 'order' => $i + 1],
            array_keys(static::DEFS),
            range(0, count(static::DEFS) - 1)
        ));
    }

    public function save(Request $request)
    {
        $validIds = array_keys(static::DEFS);
        $widgets  = [];
        $order    = 1;

        foreach ($request->input('widgets', []) as $item) {
            $id = $item['id'] ?? '';
            if (in_array($id, $validIds)) {
                $widgets[] = [
                    'id'      => $id,
                    'visible' => (bool)($item['visible'] ?? true),
                    'order'   => $order++,
                ];
            }
        }

        Setting::set('dashboard_layout_' . auth()->id(), json_encode($widgets));

        return response()->json(['ok' => true]);
    }
}

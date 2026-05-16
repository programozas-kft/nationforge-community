<?php

namespace App\Console\Commands;

use App\Mail\ScheduledReportMail;
use App\Models\Donation;
use App\Models\Event;
use App\Models\Person;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendScheduledReport extends Command
{
    protected $signature   = 'report:send {--force : Send regardless of hour/day settings}';
    protected $description = 'Send the scheduled dashboard summary report email';

    public function handle(): int
    {
        if (!Setting::get('report_enabled') && !$this->option('force')) {
            $this->info('Scheduled reports are disabled.');
            return 0;
        }

        if (!$this->option('force') && !$this->isScheduledNow()) {
            return 0;
        }

        $recipients = array_filter(array_map('trim', explode(',', Setting::get('report_recipients', ''))));

        if (empty($recipients)) {
            $this->warn('No recipients configured. Add emails in Settings → Scheduled Reports.');
            return 1;
        }

        $stats = $this->buildStats();

        foreach ($recipients as $email) {
            Mail::to($email)->send(new ScheduledReportMail($stats));
        }

        $this->info('Report sent to ' . count($recipients) . ' recipient(s).');
        return 0;
    }

    private function isScheduledNow(): bool
    {
        $hour = (int) Setting::get('report_hour', 8);
        if (now()->hour !== $hour) {
            return false;
        }

        return match (Setting::get('report_frequency', 'weekly')) {
            'daily'   => true,
            'weekly'  => now()->dayOfWeekIso === (int) Setting::get('report_day_of_week', 1),
            'monthly' => now()->day === (int) Setting::get('report_day_of_month', 1),
            default   => false,
        };
    }

    private function buildStats(): array
    {
        return [
            'people'          => Person::count(),
            'new_people'      => Person::whereMonth('created_at', now()->month)->count(),
            'events'          => Event::whereNotIn('status', ['cancelled', 'completed'])->where('starts_at', '>', now())->count(),
            'donations'       => Donation::where('status', 'completed')->sum('amount'),
            'subscribed'      => Person::where('is_subscribed', true)->count(),
            'recent_people'   => Person::latest()->limit(5)->get(),
            'upcoming_events' => Event::whereNotIn('status', ['cancelled', 'completed'])
                ->where('starts_at', '>', now())
                ->orderBy('starts_at')
                ->limit(5)
                ->get(),
            'generated_at'    => now(),
        ];
    }
}

<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ScheduledReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly array $stats) {}

    public function build(): static
    {
        $orgName = Setting::get('brand_org_name', config('app.name'));

        return $this
            ->subject(__('emails.report.subject', ['app' => $orgName]))
            ->view('emails.scheduled_report')
            ->with([
                'stats'   => $this->stats,
                'orgName' => $orgName,
            ]);
    }
}

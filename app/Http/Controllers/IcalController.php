<?php

namespace App\Http\Controllers;

use App\Models\Event;

class IcalController extends Controller
{
    public function events()
    {
        $appName = config('app.name', 'NationForge');
        $appHost = parse_url(config('app.url', 'http://localhost'), PHP_URL_HOST) ?: 'nationforge';

        $events = Event::where('status', 'published')
            ->where('starts_at', '>', now()->subMonths(6))
            ->orderBy('starts_at')
            ->get();

        $lines = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//' . $appName . '//NationForge//EN',
            'CALSCALE:GREGORIAN',
            'METHOD:PUBLISH',
            'X-WR-CALNAME:' . $appName . ' Events',
        ];

        foreach ($events as $event) {
            $dtstart = $event->starts_at->utc()->format('Ymd\THis\Z');
            $dtend   = ($event->ends_at ?? $event->starts_at->copy()->addHour())->utc()->format('Ymd\THis\Z');
            $dtstamp = $event->created_at->utc()->format('Ymd\THis\Z');

            $lines[] = 'BEGIN:VEVENT';
            $lines[] = 'UID:nf-event-' . $event->id . '@' . $appHost;
            $lines[] = 'DTSTAMP:' . $dtstamp;
            $lines[] = 'DTSTART:' . $dtstart;
            $lines[] = 'DTEND:' . $dtend;
            $lines[] = $this->foldLine('SUMMARY:' . $this->escape($event->title));

            if ($event->description) {
                $desc = str_replace(["\r\n", "\r"], "\n", strip_tags($event->description));
                $lines[] = $this->foldLine('DESCRIPTION:' . $this->escape($desc));
            }

            $location = trim(implode(', ', array_filter([
                $event->venue_name,
                $event->address,
                $event->city,
            ])));
            if ($location) {
                $lines[] = $this->foldLine('LOCATION:' . $this->escape($location));
            }

            if ($event->is_online && $event->online_url) {
                $lines[] = 'URL:' . $event->online_url;
            }

            $lines[] = 'END:VEVENT';
        }

        $lines[] = 'END:VCALENDAR';

        $body = implode("\r\n", $lines) . "\r\n";

        return response($body, 200, [
            'Content-Type'        => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'inline; filename="events.ics"',
            'Cache-Control'       => 'public, max-age=3600',
        ]);
    }

    private function escape(string $text): string
    {
        return str_replace(
            ['\\', ';', ',', "\r\n", "\r", "\n"],
            ['\\\\', '\\;', '\\,', '\\n', '\\n', '\\n'],
            $text
        );
    }

    private function foldLine(string $line): string
    {
        // RFC 5545: fold at 75 octets, continuation lines start with SPACE
        if (mb_strlen($line, '8bit') <= 75) {
            return $line;
        }
        $output = '';
        while (mb_strlen($line, '8bit') > 75) {
            $output .= mb_substr($line, 0, 75, '8bit') . "\r\n ";
            $line = mb_substr($line, 75, null, '8bit');
        }
        return $output . $line;
    }
}

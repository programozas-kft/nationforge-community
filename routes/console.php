<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Scheduled summary report — runs hourly; the command itself checks frequency/hour/day
Schedule::command('report:send')->hourly();

// Process drip campaign auto-enrollments and due sends
Schedule::command('drip:process')->everyFifteenMinutes();

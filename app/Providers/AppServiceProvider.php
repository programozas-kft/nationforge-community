<?php

namespace App\Providers;

use App\Models\Donation;
use App\Models\EmailCampaign;
use App\Models\Event;
use App\Models\Group;
use App\Models\HelpArticle;
use App\Models\Person;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Observers\AuditObserver;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Fix Livewire + Filament URL generation in XAMPP subdirectory
        $appUrl = config('app.url');
        if ($appUrl) {
            URL::forceRootUrl($appUrl);
        }

        // Audit log observers
        foreach ([Person::class, Group::class, Event::class, Donation::class,
                  User::class, Project::class, Task::class, EmailCampaign::class,
                  HelpArticle::class] as $model) {
            $model::observe(AuditObserver::class);
        }
    }
}

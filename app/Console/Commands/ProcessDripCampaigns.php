<?php

namespace App\Console\Commands;

use App\Mail\DripMail;
use App\Models\DripCampaign;
use App\Models\DripEnrollment;
use App\Models\Person;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ProcessDripCampaigns extends Command
{
    protected $signature   = 'drip:process';
    protected $description = 'Auto-enroll contacts from triggers and send due drip emails';

    public function handle(): int
    {
        $this->autoEnroll();
        $this->processDueSends();
        return 0;
    }

    private function autoEnroll(): void
    {
        $campaigns = DripCampaign::where('status', 'active')
            ->whereIn('trigger_type', ['group_join', 'tag_added'])
            ->with('steps')
            ->get();

        foreach ($campaigns as $campaign) {
            if (!$campaign->steps->count()) {
                continue;
            }

            $alreadyEnrolled = DripEnrollment::where('drip_campaign_id', $campaign->id)
                ->pluck('person_id');

            if ($campaign->trigger_type === 'group_join' && $campaign->trigger_group_id) {
                $people = Person::whereHas('groups', fn ($q) => $q->where('groups.id', $campaign->trigger_group_id))
                    ->whereNotIn('id', $alreadyEnrolled)
                    ->get();
            } elseif ($campaign->trigger_type === 'tag_added' && $campaign->trigger_tag_id) {
                $people = Person::whereHas('tags', fn ($q) => $q->where('tags.id', $campaign->trigger_tag_id))
                    ->whereNotIn('id', $alreadyEnrolled)
                    ->get();
            } else {
                continue;
            }

            foreach ($people as $person) {
                $this->enroll($campaign, $person);
            }
        }
    }

    private function enroll(DripCampaign $campaign, Person $person): void
    {
        $firstStep = $campaign->steps->first();

        DripEnrollment::create([
            'drip_campaign_id'   => $campaign->id,
            'person_id'          => $person->id,
            'status'             => 'active',
            'current_step_index' => 0,
            'next_send_at'       => now()->addDays($firstStep->delay_days),
            'enrolled_at'        => now(),
        ]);
    }

    private function processDueSends(): void
    {
        $enrollments = DripEnrollment::where('status', 'active')
            ->where('next_send_at', '<=', now())
            ->with(['dripCampaign.steps', 'person'])
            ->get();

        foreach ($enrollments as $enrollment) {
            $steps = $enrollment->dripCampaign->steps;
            $step  = $steps->get($enrollment->current_step_index);

            if (!$step || !$enrollment->person) {
                $enrollment->update(['status' => 'completed', 'completed_at' => now()]);
                continue;
            }

            try {
                Mail::to($enrollment->person->email, $enrollment->person->full_name)
                    ->send(new DripMail($step, $enrollment->person));
            } catch (\Exception $e) {
                $this->warn("Failed sending to {$enrollment->person->email}: {$e->getMessage()}");
            }

            $nextIndex = $enrollment->current_step_index + 1;
            $nextStep  = $steps->get($nextIndex);

            if ($nextStep) {
                $enrollment->update([
                    'current_step_index' => $nextIndex,
                    'next_send_at'       => now()->addDays($nextStep->delay_days),
                ]);
            } else {
                $enrollment->update([
                    'status'             => 'completed',
                    'completed_at'       => now(),
                    'current_step_index' => $nextIndex,
                    'next_send_at'       => null,
                ]);
            }
        }
    }
}

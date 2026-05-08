<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CampaignMail;
use App\Models\EmailCampaign;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = EmailCampaign::latest()->get();
        $subscriberCount = Person::whereNotNull('email')
            ->where('email', '!=', '')
            ->where('is_subscribed', true)
            ->count();
        return view('admin.campaigns.index', compact('campaigns', 'subscriberCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:200',
            'subject'   => 'required|string|max:255',
            'body_html' => 'required|string',
            'from_name' => 'nullable|string|max:100',
            'from_email'=> 'nullable|email|max:150',
        ]);

        EmailCampaign::create([
            'name'       => $request->name,
            'subject'    => $request->subject,
            'body_html'  => $request->body_html,
            'from_name'  => $request->from_name  ?: config('mail.from.name'),
            'from_email' => $request->from_email ?: config('mail.from.address'),
            'status'     => 'draft',
        ]);

        return back()->with('success', __('campaigns.created'));
    }

    public function update(Request $request, EmailCampaign $campaign)
    {
        if (! $campaign->isDraft()) {
            return back()->with('error', __('campaigns.cannot_edit_sent'));
        }

        $request->validate([
            'name'      => 'required|string|max:200',
            'subject'   => 'required|string|max:255',
            'body_html' => 'required|string',
            'from_name' => 'nullable|string|max:100',
            'from_email'=> 'nullable|email|max:150',
        ]);

        $campaign->update($request->only('name', 'subject', 'body_html', 'from_name', 'from_email'));

        return back()->with('success', __('campaigns.updated'));
    }

    public function destroy(EmailCampaign $campaign)
    {
        $campaign->delete();
        return back()->with('success', __('campaigns.deleted'));
    }

    public function send(EmailCampaign $campaign)
    {
        if (! $campaign->isDraft()) {
            return back()->with('error', __('campaigns.already_sent'));
        }

        $resendKey = config('services.resend.key');
        if (empty($resendKey)) {
            return back()->with('error', __('campaigns.no_resend_key'));
        }

        $recipients = Person::whereNotNull('email')
            ->where('email', '!=', '')
            ->where('is_subscribed', true)
            ->get()
            ->pluck('email', 'full_name');

        if ($recipients->isEmpty()) {
            return back()->with('error', __('campaigns.no_recipients'));
        }

        $campaign->update(['status' => 'sending']);

        $sent   = 0;
        $failed = 0;

        foreach ($recipients as $name => $email) {
            try {
                Mail::to($email, $name)->send(new CampaignMail($campaign));
                $sent++;
            } catch (\Exception) {
                $failed++;
            }
        }

        $campaign->update([
            'status'           => $failed > 0 && $sent === 0 ? 'failed' : 'sent',
            'sent_at'          => now(),
            'sent_count'       => $sent,
            'failed_count'     => $failed,
            'recipients_count' => $recipients->count(),
        ]);

        return back()->with('success', __('campaigns.sent_ok', ['count' => $sent]));
    }
}

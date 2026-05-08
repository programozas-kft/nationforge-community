<?php

namespace App\Mail;

use App\Models\EmailCampaign;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CampaignMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public EmailCampaign $campaign) {}

    public function envelope(): Envelope
    {
        $fromEmail = $this->campaign->from_email ?: config('mail.from.address');
        $fromName  = $this->campaign->from_name  ?: config('mail.from.name');

        return new Envelope(
            from: new Address($fromEmail, $fromName),
            subject: $this->campaign->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.campaign',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

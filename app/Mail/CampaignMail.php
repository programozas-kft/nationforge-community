<?php

namespace App\Mail;

use App\Models\EmailCampaign;
use App\Models\Person;
use App\Services\EmailTrackingService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Email as SymfonyEmail;
use Illuminate\Support\Str;

class CampaignMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $processedBody;

    public function __construct(
        public EmailCampaign $campaign,
        public Person        $person,
        public string        $trackingToken,
    ) {
        $rendered            = Str::markdown($campaign->body_html);
        $this->processedBody = EmailTrackingService::process($rendered, $trackingToken);
    }

    public function envelope(): Envelope
    {
        $fromEmail      = $this->campaign->from_email ?: config('mail.from.address');
        $fromName       = $this->campaign->from_name  ?: config('mail.from.name');
        $unsubscribeUrl = route('unsubscribe', $this->person->unsubscribe_token);

        return new Envelope(
            from: new Address($fromEmail, $fromName),
            subject: $this->campaign->subject,
            using: [function (SymfonyEmail $msg) use ($unsubscribeUrl) {
                $msg->getHeaders()
                    ->addTextHeader('List-Unsubscribe', "<{$unsubscribeUrl}>")
                    ->addTextHeader('List-Unsubscribe-Post', 'List-Unsubscribe=One-Click');
            }],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.campaign');
    }

    public function attachments(): array
    {
        return [];
    }
}

<?php

namespace App\Mail;

use App\Models\DripStep;
use App\Models\Person;
use App\Services\EmailTrackingService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Email as SymfonyEmail;

class DripMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $processedBody;

    public function __construct(
        public DripStep $step,
        public Person   $person,
        public string   $trackingToken,
    ) {
        $this->processedBody = EmailTrackingService::process($step->body_html, $trackingToken);
    }

    public function envelope(): Envelope
    {
        $unsubscribeUrl = route('unsubscribe', $this->person->unsubscribe_token);

        return new Envelope(
            from: new Address(
                $this->step->from_email ?: config('mail.from.address'),
                $this->step->from_name  ?: config('mail.from.name'),
            ),
            subject: $this->step->subject,
            using: [function (SymfonyEmail $msg) use ($unsubscribeUrl) {
                $msg->getHeaders()
                    ->addTextHeader('List-Unsubscribe', "<{$unsubscribeUrl}>")
                    ->addTextHeader('List-Unsubscribe-Post', 'List-Unsubscribe=One-Click');
            }],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.drip');
    }

    public function attachments(): array
    {
        return [];
    }
}

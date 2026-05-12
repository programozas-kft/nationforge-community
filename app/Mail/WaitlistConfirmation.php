<?php

namespace App\Mail;

use App\Models\EventRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WaitlistConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public EventRegistration $registration) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: __('emails.waitlist.subject', ['event' => $this->registration->event->title]),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.waitlist-confirmation',
            with: [
                'registration' => $this->registration,
                'event'        => $this->registration->event,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

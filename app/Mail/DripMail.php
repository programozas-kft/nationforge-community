<?php

namespace App\Mail;

use App\Models\DripStep;
use App\Models\Person;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DripMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public DripStep $step,
        public Person   $person,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                $this->step->from_email ?: config('mail.from.address'),
                $this->step->from_name  ?: config('mail.from.name'),
            ),
            subject: $this->step->subject,
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

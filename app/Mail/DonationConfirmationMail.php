<?php

namespace App\Mail;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DonationConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly Donation $donation) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('donations.email_subject'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.donation_confirmation',
        );
    }
}

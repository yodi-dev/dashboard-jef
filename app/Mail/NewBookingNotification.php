<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewBookingNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '! New Booking Request: ' . $this->booking->package,
        );
    }


    public function content(): Content
    {
        return new Content(
            markdown: 'emails.bookings.new',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

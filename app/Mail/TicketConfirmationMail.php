<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $eventTitle;

    /**
     * Create a new message instance.
     */
    public function __construct($email, $eventTitle)
    {
        $this->email = $email;
        $this->eventTitle = $eventTitle;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'))
                    ->subject('Ticket Confirmation')
                    ->view('emails.ticket_confirmation')
                    ->with([
                        'email' => $this->email,
                        'eventTitle' => $this->eventTitle
                    ]);
    }
}

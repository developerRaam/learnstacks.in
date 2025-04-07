<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $emailData;
    public $siteTitle;

    public function __construct($emailData)
    {
        $this->emailData = $emailData;
        $this->siteTitle = "Rewardo";
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->siteTitle .' '. $this->emailData['subject'] ?? '',
            from: new Address(env('MAIL_FROM_ADDRESS'), $this->siteTitle)
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {       
        return new Content(
            view: 'admin.common.email',
            with: [
                'emailData' => $this->emailData,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

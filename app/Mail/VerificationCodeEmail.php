<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;


class VerificationCodeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(private $name)
    {
        //
    }

    /**
     * Get the message envelope.
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Verification Code Email',
    //     );
    // }
    public function envelope()
    {
       return new Envelope(
        subject: 'My Test Email',
       );
    }
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.test-email',
            with: ['name' => $this->name],
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

 
/**
* Get the message envelope.
*

*/

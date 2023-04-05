<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoginMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    private string $time;
    private string $ip;
    private string $name;

    /**
     * Create a new message instance.
     *
     * @param mixed $time
     * @param mixed $ip
     * @param mixed $name
     */
    public function __construct($time, $ip, $name)
    {
        $this->time = $time;
        $this->ip = $ip;
        $this->name = $name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: 'example@example.com',
            subject: 'Login',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail',
            with: [
                'ip' => $this->ip,
                'time' => $this->time,
                'name' => $this->name,
            ],
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

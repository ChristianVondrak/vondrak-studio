<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Fluent;

class LeadConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public Fluent $lead;

    /**
     * Create a new message instance.
     */
    public function __construct(array $lead)
    {
        $this->lead = new Fluent($lead);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Gracias por tu solicitud, ' . ($this->lead->name ?? 'cliente') . '!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.leads.confirmation',
            with: [
                'lead' => $this->lead,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

<?php

namespace App\Mail;

use App\Models\Penduduk;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AkunDitolakMail extends Mailable
{
    use Queueable, SerializesModels;

    public Penduduk $warga;
    public string $alasan;

    /**
     * Create a new message instance.
     */
    public function __construct(Penduduk $warga, string $alasan)
    {
        $this->warga  = $warga;
        $this->alasan = $alasan;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pemberitahuan Pendaftaran Akun SIPESDA - Desa Medini',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.akun_ditolak',
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

<?php

namespace App\Mail;

use App\Models\PermohonanSurat;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SuratDisetujuiMail extends Mailable
{
    use Queueable, SerializesModels;

    public PermohonanSurat $permohonan;

    /**
     * Create a new message instance.
     */
    public function __construct(PermohonanSurat $permohonan)
    {
        $this->permohonan = $permohonan;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $namaSurat = $this->permohonan->jenisSurat->nama_surat ?? 'Permohonan Surat';
        return new Envelope(
            subject: 'Surat Disetujui: ' . $namaSurat . ' - ' . ($this->permohonan->nomor_surat ?? 'SIPESDA'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.surat_disetujui',
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

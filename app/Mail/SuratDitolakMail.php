<?php

namespace App\Mail;

use App\Models\PermohonanSurat;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SuratDitolakMail extends Mailable
{
    use Queueable, SerializesModels;

    public PermohonanSurat $permohonan;
    public string $alasan;
    public string $ditolakOleh;

    /**
     * Create a new message instance.
     */
    public function __construct(PermohonanSurat $permohonan, string $alasan, string $ditolakOleh = 'Kepala Desa')
    {
        $this->permohonan  = $permohonan;
        $this->alasan      = $alasan;
        $this->ditolakOleh = $ditolakOleh;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $namaSurat = $this->permohonan->jenisSurat->nama_surat ?? 'Permohonan Surat';
        return new Envelope(
            subject: 'Pemberitahuan Permohonan Surat Ditolak: ' . $namaSurat . ' - SIPESDA Medini',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.surat_ditolak',
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

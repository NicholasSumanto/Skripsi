<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatusPublikasiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $publikasi;
    public $urlLogo;
    public $urlLacak;

    /**
     * Create a new message instance.
     */
    public function __construct($publikasi)
    {
        $this->publikasi = $publikasi;
        $this->urlLogo = asset('img/Duta_Wacana.png');
        $this->urlLacak = route('umum.lacak', ['kode_proses' => $publikasi->id_proses_permohonan]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Progres Permohonan Publikasi');
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(view: 'email.proses-permohonan');
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

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifikasiPublikasiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $namaPemohon;
    public $jenisPermohonan;
    public $tokenVerifikasi;
    public $judulPermohonan;
    public $urlLogo;
    public $urlVerifikasi;
    public $waktu;

    /**
     * Create a new message instance.
     */
    public function __construct($namaPemohon, $jenisPermohonan, $judulPermohonan, $tokenVerifikasi, $waktu)
    {
        $this->namaPemohon = $namaPemohon;
        $this->jenisPermohonan = $jenisPermohonan;
        $this->judulPermohonan = $judulPermohonan;
        $this->urlLogo = asset('img/Duta_Wacana.png');
        $this->urlVerifikasi = route('umum.verifikasi', ['token' => $tokenVerifikasi]);
        $this->waktu = $waktu;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verifikasi Permohonan Publikasi Biro 4',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.verifikasi-publikasi',
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

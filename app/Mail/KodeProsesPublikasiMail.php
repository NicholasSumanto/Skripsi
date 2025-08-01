<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KodeProsesPublikasiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $namaPemohon;
    public $jenisPermohonan;
    public $judulPermohonan;
    public $id_proses_permohonan;
    public $urlLogo;
    public $urlLacak;

    /**
     * Create a new message instance.
     */
    public function __construct($namaPemohon, $jenisPermohonan, $judulPermohonan, $idProsesPermohonan)
    {
        $this->namaPemohon = $namaPemohon;
        $this->jenisPermohonan = $jenisPermohonan;
        $this->judulPermohonan = $judulPermohonan;
        $this->id_proses_permohonan = $idProsesPermohonan;
        $this->urlLogo = asset('img/Duta_Wacana.png');
        $this->urlLacak = route('umum.lacak', ['kode_proses' => $idProsesPermohonan]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Kode Proses Permohonan Publikasi Biro 4',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.kode-proses-permohonan',
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

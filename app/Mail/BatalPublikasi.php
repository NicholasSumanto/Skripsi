<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BatalPublikasi extends Mailable
{
    use Queueable, SerializesModels;

    public $namaPemohon;
    public $jenisPermohonan;
    public $id_proses_permohonan;
    public $judulPermohonan;
    public $urlLogo;
    public $pesanBatal;
    public $keteranganBatal;

    /**
     * Create a new message instance.
     */
    public function __construct($namaPemohon, $jenisPermohonan, $judulPermohonan, $idProsesPermohonan, $pesanBatal, $keteranganBatal)
    {
        $this->namaPemohon = $namaPemohon;
        $this->jenisPermohonan = $jenisPermohonan;
        $this->judulPermohonan = $judulPermohonan;
        $this->id_proses_permohonan = $idProsesPermohonan;
        $this->pesanBatal = $pesanBatal;
        $this->keteranganBatal = $keteranganBatal;
        $this->urlLogo = asset('img/Duta_Wacana.png');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Batal Permohonan Publikasi Biro 4',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.batal-publikasi',
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

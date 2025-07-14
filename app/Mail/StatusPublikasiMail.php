<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Header\IdentificationHeader;


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

    public function build()
    {
        return $this->view('email.proses-permohonan')
            ->subject('Progres Permohonan Publikasi - ' . $this->publikasi->judul)
            ->withSymfonyMessage(function (Email $message) {
                $id = strtolower($this->publikasi->id_proses_permohonan);
                // Jika kosong atau tidak valid, beri prefix huruf
                $mailDomain = env('MAIL_DOMAIN_ID', 'staff.ukdw.ac.id');
                $messageId = "{$id}@{$mailDomain}";
                $message->getHeaders()->add(new IdentificationHeader('Message-ID', $messageId));

                $message->getHeaders()->addTextHeader('In-Reply-To', "<{$messageId}>");
                $message->getHeaders()->addTextHeader('References', "<{$messageId}>");
            });
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

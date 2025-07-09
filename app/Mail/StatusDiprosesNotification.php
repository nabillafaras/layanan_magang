<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pendaftaran;

class StatusDiprosesNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $pendaftaran;

    public function __construct(Pendaftaran $pendaftaran)
    {
        $this->pendaftaran = $pendaftaran;
    }

    public function build()
    {
        return $this->markdown('emails.status-diproses')
                    ->subject('Pendaftaran Magang Sedang Diproses - ' . $this->pendaftaran->nomor_pendaftaran)
                    ->with([
                        'nama' => $this->pendaftaran->nama_lengkap,
                        'nomor_pendaftaran' => $this->pendaftaran->nomor_pendaftaran,
                        'direktorat' => $this->pendaftaran->direktorat,
                        'unit_kerja' => $this->pendaftaran->unit_kerja,
                    ]);
    }
}
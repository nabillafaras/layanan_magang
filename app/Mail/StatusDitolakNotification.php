<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pendaftaran;

class StatusDitolakNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $pendaftaran;

    public function __construct(Pendaftaran $pendaftaran)
    {
        $this->pendaftaran = $pendaftaran;
    }

    public function build()
    {
        $mail = $this->markdown('emails.status-ditolak')
                     ->subject('Pemberitahuan Status Pendaftaran Magang - ' . $this->pendaftaran->nomor_pendaftaran)
                     ->with([
                         'nama' => $this->pendaftaran->nama_lengkap,
                         'nomor_pendaftaran' => $this->pendaftaran->nomor_pendaftaran,
                         'direktorat' => $this->pendaftaran->direktorat,
                         'unit_kerja' => $this->pendaftaran->unit_kerja,
                         'catatan' => $this->pendaftaran->catatan,
                     ]);

        // Lampirkan surat penolakan jika ada
        if ($this->pendaftaran->surat_ditolak) {
            $mail->attach(storage_path('app/public/' . $this->pendaftaran->surat_ditolak), [
                'as' => 'Surat_Penolakan_' . $this->pendaftaran->nomor_pendaftaran . '.pdf',
                'mime' => 'application/pdf',
            ]);
        }

        return $mail;
    }
}
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pendaftaran;

class StatusDiterimaNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $pendaftaran;

    public function __construct(Pendaftaran $pendaftaran)
    {
        $this->pendaftaran = $pendaftaran;
    }

    public function build()
    {
        $mail = $this->markdown('emails.status-diterima')
                     ->subject('Selamat! Pendaftaran Magang Anda Diterima - ' . $this->pendaftaran->nomor_pendaftaran)
                     ->with([
                         'nama' => $this->pendaftaran->nama_lengkap,
                         'nomor_pendaftaran' => $this->pendaftaran->nomor_pendaftaran,
                         'direktorat' => $this->pendaftaran->direktorat,
                         'unit_kerja' => $this->pendaftaran->unit_kerja,
                         'tanggal_mulai' => $this->pendaftaran->tanggal_mulai,
                         'tanggal_selesai' => $this->pendaftaran->tanggal_selesai,
                     ]);

        // Lampirkan surat balasan jika ada
        if ($this->pendaftaran->surat_balasan) {
            $mail->attach(storage_path('app/public/' . $this->pendaftaran->surat_balasan), [
                'as' => 'Surat_Balasan_' . $this->pendaftaran->nomor_pendaftaran . '.pdf',
                'mime' => 'application/pdf',
            ]);
        }

        return $mail;
    }
}
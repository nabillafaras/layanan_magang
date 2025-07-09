<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pendaftaran;
use App\Models\Laporan;

class StatusSelesaiNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $pendaftaran;
    public $laporan;

    public function __construct(Pendaftaran $pendaftaran, Laporan $laporan = null)
    {
        $this->pendaftaran = $pendaftaran;
        $this->laporan = $laporan;
    }

    public function build()
    {
        $mail = $this->markdown('emails.status-selesai')
                     ->subject('Selamat! Anda Telah Menyelesaikan Program Magang - ' . $this->pendaftaran->nomor_pendaftaran)
                     ->with([
                         'nama' => $this->pendaftaran->nama_lengkap,
                         'nomor_pendaftaran' => $this->pendaftaran->nomor_pendaftaran,
                         'direktorat' => $this->pendaftaran->direktorat,
                         'unit_kerja' => $this->pendaftaran->unit_kerja,
                         'tanggal_mulai' => $this->pendaftaran->tanggal_mulai,
                         'tanggal_selesai' => $this->pendaftaran->tanggal_selesai,
                     ]);

        // Lampirkan file-file terkait jika ada
        if ($this->laporan) {
            if ($this->laporan->sk_selesai) {
                $mail->attach(public_path($this->laporan->sk_selesai), [
                    'as' => 'SK_Selesai_' . $this->pendaftaran->nomor_pendaftaran . '.pdf',
                    'mime' => 'application/pdf',
                ]);
            }

            if ($this->laporan->sertifikat) {
                $mail->attach(public_path($this->laporan->sertifikat), [
                    'as' => 'Sertifikat_' . $this->pendaftaran->nomor_pendaftaran . '.pdf',
                    'mime' => 'application/pdf',
                ]);
            }

            if ($this->laporan->nilai_magang) {
                $mail->attach(public_path($this->laporan->nilai_magang), [
                    'as' => 'Nilai_Magang_' . $this->pendaftaran->nomor_pendaftaran . '.pdf',
                    'mime' => 'application/pdf',
                ]);
            }
        }

        return $mail;
    }
}
@component('mail::message')
# Pemberitahuan Status Pendaftaran Magang

Halo **{{ $nama }}**,

Terima kasih atas minat Anda untuk bergabung dalam program magang di Kementerian Sosial.

Setelah melalui proses seleksi, kami mohon maaf untuk memberitahukan bahwa pendaftaran Anda dengan nomor **{{ $nomor_pendaftaran }}** belum dapat kami terima pada periode ini.

**Detail Pendaftaran:**
- Nomor Pendaftaran: {{ $nomor_pendaftaran }}
- Direktorat: {{ $direktorat }}
- Unit Kerja: {{ $unit_kerja }}

@if($catatan)
**Catatan:**
{{ $catatan }}
@endif

Jangan berkecil hati! Kami mengundang Anda untuk mendaftar kembali pada periode pendaftaran berikutnya.

Terima kasih atas pengertian Anda.

Salam,<br>
Tim Magang Kementerian Sosial
@endcomponent
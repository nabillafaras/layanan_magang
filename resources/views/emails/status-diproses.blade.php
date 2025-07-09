@component('mail::message')
# Pendaftaran Magang Sedang Diproses

Halo **{{ $nama }}**,

Terima kasih telah mendaftar untuk program magang di Kementerian Sosial. Pendaftaran Anda dengan nomor **{{ $nomor_pendaftaran }}** sedang dalam proses review.

**Detail Pendaftaran:**
- Nomor Pendaftaran: {{ $nomor_pendaftaran }}
- Direktorat: {{ $direktorat }}
- Unit Kerja: {{ $unit_kerja }}

Kami akan mengirimkan pemberitahuan lebih lanjut mengenai status pendaftaran Anda melalui email ini.

Terima kasih atas kesabaran Anda.

Salam,<br>
Tim Magang Kementerian Sosial
@endcomponent
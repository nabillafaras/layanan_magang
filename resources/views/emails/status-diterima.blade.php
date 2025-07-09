@component('mail::message')
# Selamat! Pendaftaran Magang Anda Diterima

Halo **{{ $nama }}**,

Selamat! Pendaftaran magang Anda dengan nomor **{{ $nomor_pendaftaran }}** telah **DITERIMA**.

**Detail Penempatan:**
- Nomor Pendaftaran: {{ $nomor_pendaftaran }}
- Direktorat: {{ $direktorat }}
- Unit Kerja: {{ $unit_kerja }}
- Periode Magang: {{ \Carbon\Carbon::parse($tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($tanggal_selesai)->format('d M Y') }}

Silakan mempersiapkan diri untuk memulai program magang sesuai dengan tanggal yang telah ditentukan.

@component('mail::button', ['url' => config('app.url')])
Portal Magang
@endcomponent

Terima kasih dan selamat bergabung!

Salam,<br>
Tim Magang Kementerian Sosial
@endcomponent
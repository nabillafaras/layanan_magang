@component('mail::message')
# Selamat! Anda Telah Menyelesaikan Program Magang

Halo **{{ $nama }}**,

Selamat! Anda telah berhasil menyelesaikan program magang di Kementerian Sosial.

**Detail Program:**
- Nomor Pendaftaran: {{ $nomor_pendaftaran }}
- Direktorat: {{ $direktorat }}
- Unit Kerja: {{ $unit_kerja }}
- Periode Magang: {{ \Carbon\Carbon::parse($tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($tanggal_selesai)->format('d M Y') }}

Dokumen terkait penyelesaian magang telah dilampirkan dalam email ini.

Terima kasih atas dedikasi dan kontribusi Anda selama program magang. Semoga pengalaman ini bermanfaat untuk perkembangan karir Anda di masa depan.

@component('mail::button', ['url' => config('app.url')])
Portal Magang
@endcomponent

Salam sukses!

Salam,<br>
Tim Magang Kementerian Sosial
@endcomponent
@extends('layouts.header')

@section('title', 'Persyaratan - Kementerian Sosial RI')

@section('additional_css')
<style>
    /* Modern Variable Colors */
    :root {
        --primary-color: #8b0000;
        --primary-hover: #a00000;
        --secondary-color: #FFD700;
        --text-light: #ffffff;
        --text-dark: #333333;
        --bg-light: #f8f9fa;
        --transition: all 0.3s ease;
    }
    .hero {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        background-image: url('images/bg1.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        padding: 100px 10%;
        margin-bottom: 0;
        height: 100vh;
        position: relative;
        }

        /* Optional: Add a semi-transparent overlay to improve text readability */
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(164, 0, 0, 0.7); /* Keeps the original red color with transparency */
            z-index: 1;
        }

        .hero-content {
            max-width: 40%; /* Batasi lebar teks agar proporsional */
            margin-right: 20px; /* Beri jarak antara teks dan gambar */
            z-index: 2;
        }

        .hero-content h1 {
            font-size: 2.5rem;
            color: #ffffff;
            font-weight: bold;
        }

        .hero-content p {
            font-size: 1rem;
            margin-bottom: 20px;
            color:#f2f2f2; /* Sesuaikan warna teks dengan latar */
        }

        .hero-content .btn {
            background-color: #FFD700;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
        }

        .hero-content .btn:hover {
            background-color: #8b0000;
        }

        .hero-image img {
            max-width: 400px; /* Batasi lebar gambar */
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

    .information-section {
        padding: 50px 10%;
        background-color: #f8f9fa;
    }

    .information-section h2 {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .info-box {
        display: flex;
        align-items: flex-start;
        margin-bottom: 30px;
    }

    .info-box img {
        width: 150px;
        height: 150px;
        margin-right: 20px;
        border-radius: 10px;
    }

    .requirements-box {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }

    .requirements-box h3 {
        color: #a40000;
        border-bottom: 2px solid #a40000;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .requirements-box ul {
        padding-left: 20px;
    }

    .requirements-box li {
        margin-bottom: 10px;
        position: relative;
        padding-left: 10px;
    }

    .requirements-box li::before {
        content: "•";
        color: #a40000;
        font-weight: bold;
        display: inline-block;
        width: 1em;
        margin-left: -1em;
    }

    .steps-box {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }

    .steps-box h3 {
        color: #a40000;
        border-bottom: 2px solid #a40000;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .step-item {
        display: flex;
        margin-bottom: 20px;
    }

    .step-number {
        background-color: #a40000;
        color: white;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .step-content {
        flex-grow: 1;
    }

    .step-content h4 {
        margin-bottom: 5px;
        color: #333;
    }

    
</style>
@endsection

@section('content')
@include('layouts.transisi')
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Selamat Datang</h1>
            <p>
                Portal Layanan Digital Kementerian Sosial Republik Indonesia. Akses semua layanan sosial dalam satu
                platform terintegrasi.
            </p>
            <a href="#persyaratan" class="btn">Lihat Persyaratan Magang</a>
        </div>
    </section>

    <!-- Information Section -->
    <section id="persyaratan" class="information-section">
        <h2>Persyaratan Pendaftaran Magang di Kemensos RI</h2>
        
        <div class="requirements-box">
            <h3>Berkas dan Persyaratan yang Perlu Disiapkan</h3>
            <ul>
                <li>
                    <strong>Curriculum Vitae (CV)</strong>
                    <p>CV yang berisi informasi lengkap tentang data diri, riwayat pendidikan, pengalaman organisasi, kemampuan, dan keahlian yang dimiliki. Format CV bebas, namun disarankan maksimal 2 lembar dengan desain yang profesional.</p>
                </li>
                <li>
                    <strong>Transkrip Nilai</strong>
                    <p>Transkrip nilai terbaru dari institusi pendidikan dengan IPK minimal 3.00 (untuk S1) atau 2.75 (untuk D3). Transkrip harus dilegalisir oleh pihak kampus dan masih berlaku.</p>
                </li>
                <li>
                    <strong>Surat Pengantar dari Institusi Pendidikan</strong>
                    <p>Surat pengantar resmi dari institusi pendidikan yang menyatakan bahwa mahasiswa yang bersangkutan direkomendasikan untuk melaksanakan program magang di Kementerian Sosial RI. Surat harus ditandatangani oleh pejabat yang berwenang (Dekan/Kaprodi/Wadek).</p>
                </li>
                <li>
                    <strong>Surat Permohonan Magang</strong>
                    <p>Surat permohonan magang yang ditujukan kepada Kepala Biro Sumber Daya Manusia Kementerian Sosial RI. Format bisa diunduh di website resmi Kemensos.</p>
                </li>
                <li>
                    <strong>Pas Foto Berwarna</strong>
                    <p>Pas foto terbaru ukuran 4x6 dengan latar belakang merah (2 lembar) dan dalam bentuk digital (format .jpg atau .png).</p>
                </li>
                <li>
                    <strong>Fotokopi KTP</strong>
                    <p>Fotokopi KTP yang masih berlaku dan scan digital KTP.</p>
                </li>
                <li>
                    <strong>Proposal Magang</strong>
                    <p>Proposal singkat yang berisi rencana kegiatan selama magang (1-2 halaman) termasuk bidang yang diminati dan alasan pemilihan Kemensos sebagai tempat magang.</p>
                </li>
            </ul>
        </div>
        
        <div class="steps-box">
            <h3>Tata Cara Pendaftaran Magang</h3>
            
            <div class="step-item">
                <div class="step-number">1</div>
                <div class="step-content">
                    <h4>Akses Website Layanan Magang</h4>
                    <p>Kunjungi portal resmi Kemensos RI di <strong>layanan.magang.go.id</strong> dan klik tombol "Registrasi" lalu pilih menu "Pendaftaran".</p>
                </div>
            </div>
            
            <div class="step-item">
                <div class="step-number">2</div>
                <div class="step-content">
                    <h4>Mengisi Formulir Pendaftaran</h4>
                    <p>Lengkapi formulir pendaftaran online dengan data diri, informasi pendidikan, pilihan bidang magang, dan periode magang yang diinginkan. Pastikan semua informasi yang dimasukkan benar dan sesuai dengan dokumen pendukung.</p>
                </div>
            </div>
            
            <div class="step-item">
                <div class="step-number">3</div>
                <div class="step-content">
                    <h4>Unggah Dokumen Persyaratan</h4>
                    <p>Unggah semua dokumen persyaratan (CV, transkrip nilai, surat pengantar, dll.) dalam format PDF dengan ukuran maksimal 2MB per file. Pastikan semua file dapat dibuka dan jelas terbaca.</p>
                </div>
            </div>
            
            <div class="step-item">
                <div class="step-number">4</div>
                <div class="step-content">
                    <h4>Menunggu Verifikasi dan Konfirmasi</h4>
                    <p>Setelah mengirimkan pendaftaran, peserta akan diberikan nomor pendaftaran. tim Kemensos akan memverifikasi kelengkapan dokumen dan eligibilitas pendaftar. Proses ini memakan waktu 7-14 hari kerja. Status pendaftaran dapat dipantau dengan memasukkan nomor pendaftaran yang telah diberikan melalui menu "Cek Status" pada portal layanan magang.</p>
                </div>
            </div>
            
            <div class="step-item">
                <div class="step-number">5</div>
                <div class="step-content">
                    <h4>Pengumuman Hasil</h4>
                    <p>Pengumuman hasil seleksi akan diinformasikan melalui email dan dapat dilihat di portal layanan magang Kemensos. Peserta yang lolos seleksi akan menerima Surat Penerimaan Magang secara resmi dan mendapatkan akun untuk mengakses absensi selama kegiatan magang.</p>
                </div>
            </div>
            <div class="step-item">
                <div class="step-number">6</div>
                <div class="step-content">
                    <h4>Login ke Portal Layanan Magang</h4>
                    <p>Setelah akun diberikan, login ke sistem menggunakan nomor pendaftaran dan password yang telah diberikan. Pastikan menggunakan browser terbaru untuk pengalaman pengguna yang optimal.</p>
                </div>
            </div>
        </div>

        <div class="info-box">
            <img src="images/info1.jpg" alt="Informasi 1">
            <div>
                <h3>Bantuan Pendaftaran</h3>
                <p>
                    Jika mengalami kesulitan dalam proses pendaftaran atau memiliki pertanyaan, silakan hubungi tim dukungan Kemensos melalui email <strong>magang@kemsos.go.id</strong> atau nomor telepon <strong>(021) 3103591</strong> pada jam kerja (Senin-Jumat, 08.00-16.00 WIB).
                </p>
            </div>
        </div>
        
        <div class="info-box">
            <img src="images/info2.jpg" alt="Informasi 2">
            <div>
                <h3>Program Magang Unggulan</h3>
                <p>
                    Kementerian Sosial RI menyediakan berbagai program magang di bidang Pemberdayaan Sosial, Rehabilitasi Sosial, Perlindungan Sosial, Jaminan Sosial, dan Penanganan Fakir Miskin. Peserta magang akan mendapatkan pengalaman praktis dan pemahaman mendalam tentang kebijakan dan program sosial di Indonesia.
                </p>
            </div>
        </div>
        
        <div class="info-box">
            <img src="images/info3.jpg" alt="Informasi 3">
            <div>
                <h3>Keuntungan Program Magang</h3>
                <p>
                    Peserta magang di Kemensos RI akan mendapatkan sertifikat magang resmi, pengalaman bekerja di instansi pemerintah, jaringan profesional yang luas, dan kesempatan untuk berkontribusi langsung dalam program-program sosial nasional.
                </p>
            </div>
        </div>
    </section>

    <!-- Include Side Menu -->
    @include('layouts.menu')
    @include('layouts.footer')    
@endsection

@section('additional_scripts')
@endsection
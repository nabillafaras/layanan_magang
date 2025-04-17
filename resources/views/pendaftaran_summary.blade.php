<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary Pendaftaran Magang Kemensos RI</title>
    <!-- Font Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap dan Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- jsPDF untuk mengunduh PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    
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

    body {
        font-family: 'Calibri', sans-serif;
        overflow-x: hidden;
        color: var(--text-dark);
        background-image: linear-gradient(135deg, rgba(139, 0, 0, 0.9), rgba(80, 0, 0, 0.95)), url('images/bg1.png');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
        margin: 0;
        padding: 20px;
        position: relative;
    }
    
    body::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB4PSIwIiB5PSIwIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIyIiBoZWlnaHQ9IjIiIGZpbGw9IiNGRkQ3MDAiIGZpbGwtb3BhY2l0eT0iMC4xNSIvPjwvcGF0dGVybj48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI3BhdHRlcm4pIi8+PC9zdmc+');
        opacity: 0.4;
        z-index: 0;
        pointer-events: none;
    }

    .container {
        position: relative;
        z-index: 1;
        max-width: 800px;
        width: 100%;
        margin: 40px auto;
    }

    /* Animated Shapes */
    .shape {
        position: absolute;
        z-index: 0;
        opacity: 0.5;
    }
    
    .shape-1 {
        top: 10%;
        left: 5%;
        width: 50px;
        height: 50px;
        background: var(--secondary-color);
        border-radius: 50%;
        animation: floatAnimation 8s infinite alternate;
    }
    
    .shape-2 {
        bottom: 20%;
        right: 10%;
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        transform: rotate(45deg);
        animation: floatAnimation 12s infinite alternate-reverse;
    }
    
    @keyframes floatAnimation {
        0% {
            transform: translate(0, 0) rotate(0deg);
        }
        50% {
            transform: translate(20px, 20px) rotate(10deg);
        }
        100% {
            transform: translate(-20px, 10px) rotate(-10deg);
        }
    }

    .card {
        border-radius: 24px;
        overflow: hidden;
        border: none;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        background-color: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(15px);
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease;
        margin: 0 auto;
        animation: fadeIn 0.8s ease-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.35);
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary-color), #6b0000);
        color: var(--text-light);
        text-align: center;
        padding: 35px 25px;
        border-bottom: 5px solid var(--secondary-color);
        position: relative;
        overflow: hidden;
    }
    
    .card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB4PSIwIiB5PSIwIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIyIiBoZWlnaHQ9IjIiIGZpbGw9IiNGRkQ3MDAiIGZpbGwtb3BhY2l0eT0iMC4xNSIvPjwvcGF0dGVybj48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI3BhdHRlcm4pIi8+PC9zdmc+');
        opacity: 0.1;
        pointer-events: none;
    }
    
    .card-header::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, var(--secondary-color), #FFE55C, var(--secondary-color));
        background-size: 200% 100%;
        animation: gradientBG 3s ease infinite;
    }
    
    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .title-icon {
        font-size: 2.5rem;
        color: var(--text-light);
        margin-bottom: 15px;
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
        0% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-10px);
        }
        100% {
            transform: translateY(0px);
        }
    }

    .card-header h2 {
        font-weight: 700;
        margin-bottom: 10px;
        font-size: 2rem;
        color: var(--text-light);
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    .registration-number {
        background: linear-gradient(45deg, var(--secondary-color), #FFE55C);
        color: var(--primary-color);
        font-weight: bold;
        padding: 12px 25px;
        border-radius: 30px;
        display: inline-block;
        margin-top: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        position: relative;
        overflow: hidden;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.4);
        }
        100% {
            transform: scale(1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }
    }
    
    .registration-number h5 {
        margin: 0;
        font-size: 1.2rem;
    }
    
    .registration-number::before {
        content: '';
        position: absolute;
        top: -10px;
        left: -10px;
        right: -10px;
        bottom: -10px;
        background: linear-gradient(45deg, rgba(255, 215, 0, 0.5), rgba(255, 229, 92, 0.5));
        background-size: 200% 200%;
        animation: gradientBG 3s ease infinite;
        z-index: -1;
        border-radius: 40px;
    }

    .card-body {
        padding: 35px;
    }

    .list-group {
        margin-top: 20px;
        border-radius: 0;
        list-style: none;
        padding: 0;
    }

    .list-group-item {
        display: flex;
        align-items: center;
        padding: 16px 25px;
        border-left: none;
        border-right: none;
        transition: var(--transition);
        animation: fadeIn 0.5s ease;
        animation-fill-mode: both;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    .list-group-item:nth-child(odd) {
        background-color: rgba(248, 249, 250, 0.5);
    }
    
    .list-group-item:nth-child(even) {
        background-color: white;
    }

    .list-group-item:hover {
        background-color: rgba(255, 215, 0, 0.15);
        transform: translateX(5px);
    }

    .list-group-item:first-child {
        border-top: none;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }
    
    .list-group-item:last-child {
        border-bottom: none;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .icon {
        color: var(--primary-color);
        margin-right: 15px;
        width: 24px;
        height: 24px;
        text-align: center;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .list-group-item:hover .icon {
        transform: scale(1.2);
        color: var(--secondary-color);
        text-shadow: 0 0 10px rgba(139, 0, 0, 0.5);
    }

    .label {
        min-width: 180px;
        font-weight: bold;
        text-align: left;
        position: relative;
        color: var(--primary-color);
        transition: var(--transition);
    }

    .label::after {
        content: ":";
        position: absolute;
        right: 15px;
    }

    .value {
        margin-left: 20px;
        flex: 1;
        transition: var(--transition);
    }
    
    .list-group-item:hover .value {
        transform: scale(1.02);
        color: var(--primary-color);
        font-weight: 500;
    }

    .btn-action {
        padding:14px 20px;
        border-radius: 50px;
        font-weight: bold;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        margin-top: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        position: relative;
        overflow: hidden;
        font-size: 1.1rem;
        display: inline-block;
        text-decoration: none;
        text-align: center;
        width: 100%;
        
    }
    
    .btn-action::after {
        content: '';
        position: absolute;
        width: 0;
        height: 100%;
        top: 0;
        left: 0;
        background-color: rgba(255, 255, 255, 0.2);
        transition: width 0.3s ease;
        border-radius: 50px;
    }
    
    .btn-action:hover::after {
        width: 100%;
    }
    
    .btn-action i {
        margin-right: 10px;
        transition: transform 0.3s ease;
    }

    .btn-back {
            background: linear-gradient(135deg, var(--secondary-color), #ffc107);
            color: var(--primary-color);
        }
        
        .btn-back::after {
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .btn-back:hover {
            background: linear-gradient(135deg, #ffc107, var(--secondary-color));
            color: var(--primary-color);
        }

    .btn-download {
        background: linear-gradient(45deg, #28a745, #218838);
        color: white;
    }
    
    .btn-download:hover {
        background: linear-gradient(45deg, #218838, #1e7e34);
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }
    
    .btn-download:hover i {
        transform: translateY(-3px);
    }

    /* Loading Overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(139, 0, 0, 0.9);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        transition: opacity 0.5s ease, visibility 0.5s ease;
    }
    
    .loading-spinner {
        width: 60px;
        height: 60px;
        border: 5px solid rgba(255, 215, 0, 0.3);
        border-radius: 50%;
        border-top-color: var(--secondary-color);
        animation: spin 1s ease-in-out infinite;
    }
    
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
    
    .fade-out {
        opacity: 0;
        visibility: hidden;
    }

    /* Toast Notification */
    .toast-notification {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: linear-gradient(135deg, #28a745, #218838);
        color: white;
        padding: 15px 25px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        transform: translateY(100px);
        opacity: 0;
        transition: transform 0.5s ease, opacity 0.5s ease;
        z-index: 9999;
    }
    
    .toast-notification.show {
        transform: translateY(0);
        opacity: 1;
    }
    
    .toast-notification i {
        margin-right: 10px;
        font-size: 1.2rem;
    }

    /* Animasi untuk item list */
    .list-appear {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    
    .list-appear.active {
        opacity: 1;
        transform: translateY(0);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            padding: 0 15px;
        }
        
        .card-header {
            padding: 25px 15px;
        }
        
        .card-body {
            padding: 25px 15px;
        }
        
        .label {
            min-width: 120px;
        }
        
        .registration-number {
            padding: 10px 20px;
        }
        
        .registration-number h5 {
            font-size: 1rem;
        }
        
        .title-icon {
            font-size: 2rem;
        }
        
        .card-header h2 {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 576px) {
        .list-group-item {
            flex-direction: column;
            align-items: flex-start;
            padding: 15px;
        }
        
        .label {
            min-width: auto;
            margin-bottom: 5px;
            width: 100%;
        }
        
        .label::after {
            display: none;
        }
        
        .value {
            margin-left: 0;
            width: 100%;
            padding-left: 30px;
        }
        
        .icon {
            position: absolute;
            left: 15px;
            top: 15px;
        }
        
        .btn-action {
            font-size: 1rem;
            padding: 12px;
        }
    }
</style>
</head>
<body>


<!-- Toast Notification -->
<div class="toast-notification" id="toastNotification">
    <i class="fas fa-check-circle"></i>
    <span>PDF berhasil diunduh!</span>
</div>

<!-- Animated Shapes -->
<div class="shape shape-1"></div>
<div class="shape shape-2"></div>

<div class="container">
    <div class="card shadow" data-aos="fade-up" id="registrationCard">
        <div class="card-header">
            <div class="title-icon" data-aos="fade-down" data-aos-delay="100">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <h2 data-aos="fade-up" data-aos-delay="200"><strong>Rangkuman Pendaftaran</strong></h2>
            <div class="registration-number" data-aos="zoom-in" data-aos-delay="300">
                <h5 class="mb-0"><strong>Nomor Pendaftaran:</strong> {{ $pendaftaran->nomor_pendaftaran }}</h5>
            </div>
            <p class="text-light mt-3 mb-0" data-aos="fade-up" data-aos-delay="400">Berikut adalah informasi yang telah Anda daftarkan:</p>
        </div>

        <div class="card-body">
            <ul class="list-group" id="registrationList">
                <li class="list-group-item list-appear" data-aos="fade-up" data-aos-delay="150">
                    <div class="icon"><i class="fas fa-user"></i></div>
                    <strong class="label">Nama Lengkap</strong> 
                    <span class="value">{{ $pendaftaran->nama_lengkap }}</span>
                </li>
                <li class="list-group-item list-appear" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon"><i class="fas fa-envelope"></i></div>
                    <strong class="label">Email</strong> 
                    <span class="value">{{ $pendaftaran->email }}</span>
                </li>
                <li class="list-group-item list-appear" data-aos="fade-up" data-aos-delay="250">
                    <div class="icon"><i class="fas fa-university"></i></div>
                    <strong class="label">Asal Institusi Pendidikan</strong> 
                    <span class="value">{{ $pendaftaran->asal_universitas }}</span>
                </li>
                <li class="list-group-item list-appear" data-aos="fade-up" data-aos-delay="300">
                    <div class="icon"><i class="fas fa-book"></i></div>
                    <strong class="label">Jurusan/Bidang Keilmuan</strong> 
                    <span class="value">{{ $pendaftaran->jurusan }}</span>
                </li>
                <li class="list-group-item list-appear" data-aos="fade-up" data-aos-delay="350">
                    <div class="icon"><i class="fas fa-graduation-cap"></i></div>
                    <strong class="label">Program/Keahlian yang Diambil</strong> 
                    <span class="value">{{ $pendaftaran->prodi }}</span>
                </li>
                <li class="list-group-item list-appear" data-aos="fade-up" data-aos-delay="400">
                    <div class="icon"><i class="fas fa-calendar-alt"></i></div>
                    <strong class="label">Semester</strong> 
                    <span class="value">{{ $pendaftaran->semester }}</span>
                </li>
                <li class="list-group-item list-appear" data-aos="fade-up" data-aos-delay="450">
                    <div class="icon"><i class="fas fa-building"></i></div>
                    <strong class="label">Direktorat</strong> 
                    <span class="value">{{ $pendaftaran->direktorat }}</span>
                </li>
                <li class="list-group-item list-appear" data-aos="fade-up" data-aos-delay="500">
                    <div class="icon"><i class="fas fa-briefcase"></i></div>
                    <strong class="label">Unit Kerja</strong> 
                    <span class="value">{{ $pendaftaran->unit_kerja }}</span>
                </li>
            </ul>

            <div class="row mt-4">
                <div class="col-md-6" data-aos="fade-right" data-aos-delay="550">
                    <a href="{{ route('home') }}" class="btn-action btn-back">
                        <i class="fas fa-home"></i> Kembali ke Dashboard
                    </a>
                </div>
                <div class="col-md-6" data-aos="fade-left" data-aos-delay="600">
                    <button onclick="downloadPDF()" class="btn-action btn-download">
                        <i class="fas fa-download"></i> Download Bukti Pendaftaran
                    </button>
                </div>
            </div>
        </div>    
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS animation library
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });
        
        // Loading screen
        setTimeout(function() {
            document.getElementById('loadingOverlay').classList.add('fade-out');
            
            // Animasi untuk list items
            const listItems = document.querySelectorAll('.list-appear');
            listItems.forEach((item, index) => {
                setTimeout(() => {
                    item.classList.add('active');
                }, 100 * (index + 1));
            });
        }, 1000);
        
        // Hover effects for list items
        const listItems = document.querySelectorAll('.list-group-item');
        listItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(5px)';
                this.querySelector('.icon').style.transform = 'scale(1.2)';
                this.querySelector('.icon').style.color = 'var(--secondary-color)';
                this.querySelector('.value').style.transform = 'scale(1.02)';
                this.querySelector('.value').style.color = 'var(--primary-color)';
                this.querySelector('.value').style.fontWeight = '500';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
                this.querySelector('.icon').style.transform = 'scale(1)';
                this.querySelector('.icon').style.color = 'var(--primary-color)';
                this.querySelector('.value').style.transform = 'scale(1)';
                this.querySelector('.value').style.color = '';
                this.querySelector('.value').style.fontWeight = '';
            });
        });
        
        // Button hover effects
        const backBtn = document.querySelector('.btn-back');
        backBtn.addEventListener('mouseenter', function() {
            this.querySelector('i').style.transform = 'translateX(-5px)';
        });
        
        backBtn.addEventListener('mouseleave', function() {
            this.querySelector('i').style.transform = 'translateX(0)';
        });
        
        const downloadBtn = document.querySelector('.btn-download');
        downloadBtn.addEventListener('mouseenter', function() {
            this.querySelector('i').style.transform = 'translateY(-3px)';
        });
        
        downloadBtn.addEventListener('mouseleave', function() {
            this.querySelector('i').style.transform = 'translateY(0)';
        });
    });
    
    // Fungsi untuk download PDF
    function downloadPDF() {
            // Tampilkan loading
            document.getElementById('loadingOverlay').classList.remove('fade-out');
            
            // Gunakan jsPDF dan html2canvas untuk membuat PDF
            const { jsPDF } = window.jspdf;
            
            // Buat instance PDF
            const doc = new jsPDF('p', 'mm', 'a4');
            
            // Ambil elemen yang akan dijadikan PDF
            const element = document.getElementById('registrationCard');
            
            // Konversi elemen ke canvas
            html2canvas(element, {
                scale: 2,
                useCORS: true,
                logging: false
            }).then(canvas => {
                // Tambahkan gambar canvas ke PDF
                const imgData = canvas.toDataURL('image/png');
                const imgWidth = 190;
                const pageHeight = 297;
                const imgHeight = canvas.height * imgWidth / canvas.width;
                let heightLeft = imgHeight;
                let position = 10;
                
                doc.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
                
                // Jika konten lebih dari 1 halaman
                while (heightLeft >= 0) {
                    position = heightLeft - imgHeight;
                    doc.addPage();
                    doc.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;
                }
                
                // Simpan PDF
                doc.save('Bukti_Pendaftaran_{{ $pendaftaran->nomor_pendaftaran }}.pdf');
                
                // Sembunyikan loading
                setTimeout(function() {
                    document.getElementById('loadingOverlay').classList.add('fade-out');
                    
                    // Tampilkan notifikasi sukses
                    const toast = document.getElementById('toastNotification');
                    toast.classList.add('show');
                    
                    // Sembunyikan notifikasi setelah 3 detik
                    setTimeout(function() {
                        toast.classList.remove('show');
                    }, 3000);
                }, 1500);
            });
    }
</script>
</body>
</html>
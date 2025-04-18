@extends('layouts.header_user')

@section('title', $pengumuman->title . ' - Kementerian Sosial RI')

@section('additional_css')
<style>
    /* Detail Pengumuman Styles */
    .dashboard-header {
        margin-bottom: 30px;
        position: relative;
    }
    
    .dashboard-header h2 {
        font-weight: 700;
        color: var(--primary-color);
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
    }
    
    .dashboard-header h2::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        height: 4px;
        width: 60px;
        background: linear-gradient(90deg, var(--primary-color), #c13030);
        border-radius: 2px;
    }

    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin-bottom: 20px;
    }
    
    .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .breadcrumb-item a:hover {
        color: #c13030;
        text-decoration: underline;
    }
    
    .breadcrumb-item.active {
        color: #6c757d;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
        color: #6c757d;
    }
    
    /* Content Styles */
    .pengumuman-header {
        margin-bottom: 30px;
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 20px;
    }
    
    .pengumuman-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 15px;
        line-height: 1.3;
    }
    
    .pengumuman-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 20px;
        color: #6c757d;
    }
    
    .pengumuman-meta-item {
        display: flex;
        align-items: center;
    }
    
    .pengumuman-meta-item i {
        margin-right: 8px;
        color: var(--primary-color);
    }
    
    .media-content {
        margin-bottom: 30px;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }
    
    .media-content:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        transform: translateY(-5px);
    }
    
    .media-content img {
        width: 100%;
        max-height: 500px;
        object-fit: contain;
        background-color: #f8f9fa;
    }
    
    .pengumuman-content {
        line-height: 1.8;
        color: #333;
        font-size: 1.1rem;
    }
    
    .pengumuman-content p {
        margin-bottom: 20px;
    }
    
    .pengumuman-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 20px 0;
    }
    
    .pengumuman-content h1, 
    .pengumuman-content h2, 
    .pengumuman-content h3, 
    .pengumuman-content h4, 
    .pengumuman-content h5, 
    .pengumuman-content h6 {
        color: var(--primary-color);
        margin-top: 30px;
        margin-bottom: 15px;
        font-weight: 600;
    }
    
    .pengumuman-content ul, 
    .pengumuman-content ol {
        margin-bottom: 20px;
        padding-left: 20px;
    }
    
    .pengumuman-content li {
        margin-bottom: 10px;
    }
    
    .pengumuman-content table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border-radius: 8px;
        overflow: hidden;
    }
    
    .pengumuman-content table, 
    .pengumuman-content th, 
    .pengumuman-content td {
        border: 1px solid #dee2e6;
    }
    
    .pengumuman-content th {
        background-color: #f8f9fa;
        color: var(--primary-color);
        font-weight: 600;
        text-align: left;
        padding: 12px 15px;
    }
    
    .pengumuman-content td {
        padding: 12px 15px;
    }
    
    .pengumuman-content tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    
    .pengumuman-content blockquote {
        border-left: 4px solid var(--primary-color);
        padding: 15px 20px;
        background-color: #f8f9fa;
        margin: 20px 0;
        font-style: italic;
        color: #555;
        border-radius: 0 8px 8px 0;
    }
    
    .attachment-section {
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #e0e0e0;
    }
    
    .attachment-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }
    
    .attachment-title i {
        margin-right: 10px;
    }
    
    .attachment-btn {
        display: inline-flex;
        align-items: center;
        padding: 10px 20px;
        border-radius: 8px;
        background-color: #f8f9fa;
        color: var(--primary-color);
        border: 1px solid #dee2e6;
        transition: all 0.3s;
        text-decoration: none;
        font-weight: 500;
    }
    
    .attachment-btn:hover {
        background-color: var(--primary-color);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(139, 0, 0, 0.2);
    }
    
    .attachment-btn i {
        margin-right: 10px;
        font-size: 1.2rem;
    }
    
    .back-btn {
        display: inline-flex;
        align-items: center;
        padding: 8px 20px;
        border-radius: 8px;
        background-color: transparent;
        color: var(--primary-color);
        border: 1px solid var(--primary-color);
        transition: all 0.3s;
        text-decoration: none;
        font-weight: 500;
    }
    
    .back-btn:hover {
        background-color: var(--primary-color);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(139, 0, 0, 0.2);
    }
    
    .back-btn i {
        margin-right: 10px;
    }
    
    /* Animation Classes */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideInLeft {
        from { transform: translateX(-50px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideInRight {
        from { transform: translateX(50px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideInUp {
        from { transform: translateY(50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    @keyframes bounceIn {
        0% { transform: scale(0.8); opacity: 0; }
        50% { transform: scale(1.05); opacity: 0.8; }
        100% { transform: scale(1); opacity: 1; }
    }
    
    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    
    .slide-in-left {
        animation: slideInLeft 0.5s ease-in-out;
    }
    
    .slide-in-right {
        animation: slideInRight 0.5s ease-in-out;
    }
    
    .slide-in-up {
        animation: slideInUp 0.5s ease-in-out;
    }
    
    .bounce-in {
        animation: bounceIn 0.6s ease-in-out;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .pengumuman-title {
            font-size: 1.5rem;
        }
        
        .pengumuman-meta {
            gap: 10px;
        }
        
        .pengumuman-content {
            font-size: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <div class="dashboard-header fade-in">
        <h2 class="mb-4">Detail Pengumuman</h2>
        <ol class="breadcrumb mb-4 slide-in-right">
            <li class="breadcrumb-item"><a href="{{ route('user') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pengumuman') }}">Berita & Pengumuman</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($pengumuman->title, 30) }}</li>
        </ol>
    </div>

    <div class="card dashboard-card mb-4 bounce-in">
        <div class="card-body p-4">
            <div class="pengumuman-header">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge bg-primary">{{ $pengumuman->kategori }}</span>
                    <a href="{{ route('pengumuman') }}" class="back-btn">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                
                <h1 class="pengumuman-title slide-in-left">{{ $pengumuman->title }}</h1>
                
                <div class="pengumuman-meta slide-in-up">
                    <div class="pengumuman-meta-item">
                        <i class="far fa-calendar-alt"></i>
                        <span>{{ $pengumuman->published_at->translatedFormat('d F Y, H:i') }} WIB</span>
                    </div>
                    <div class="pengumuman-meta-item">
                        <i class="far fa-user"></i>
                        <span>Admin {{ $pengumuman->admin->name ?? 'Kementerian Sosial' }}</span>
                    </div>
                </div>
            </div>
            
            @if($pengumuman->content)
                <div class="media-content bounce-in">
                    @php
                        $extension = pathinfo(storage_path('app/public/'.$pengumuman->content), PATHINFO_EXTENSION);
                        $videoExtensions = ['mp4', 'mov', 'avi', 'wmv'];
                        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
                    @endphp
                    
                    @if(in_array(strtolower($extension), $imageExtensions))
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $pengumuman->content) }}" class="img-fluid" alt="{{ $pengumuman->title }}">
                        </div>
                    @elseif(in_array(strtolower($extension), $videoExtensions))
                        <div class="ratio ratio-16x9">
                            <video controls>
                                <source src="{{ asset('storage/' . $pengumuman->content) }}" type="video/{{ $extension }}">
                                Browser Anda tidak mendukung pemutaran video.
                            </video>
                        </div>
                    @endif
                </div>
            @endif
            
            <div class="pengumuman-content fade-in">
                {!! $pengumuman->isi !!}
            </div>
            
            @if($pengumuman->attachment)
                <div class="attachment-section slide-in-up">
                    <h5 class="attachment-title">
                        <i class="fas fa-paperclip"></i> Lampiran
                    </h5>
                    <a href="{{ asset('storage/' . $pengumuman->attachment) }}" class="attachment-btn" target="_blank">
                        <i class="fas fa-file-download"></i> Download Lampiran
                    </a>
                </div>
            @endif
            
            <div class="mt-5 text-center">
                <a href="{{ route('pengumuman') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Pengumuman
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animasi untuk gambar dalam konten
        const contentImages = document.querySelectorAll('.pengumuman-content img');
        contentImages.forEach(img => {
            img.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.03)';
                this.style.boxShadow = '0 10px 20px rgba(0,0,0,0.1)';
                this.style.transition = 'all 0.3s ease';
            });
            
            img.addEventListener('mouseleave', function() {
                this.style.transform = '';
                this.style.boxShadow = '';
            });
        });
        
        // Animasi scroll untuk media content
        const mediaContent = document.querySelector('.media-content');
        if (mediaContent) {
            window.addEventListener('scroll', function() {
                const scrollPosition = window.scrollY;
                const mediaPosition = mediaContent.getBoundingClientRect().top + window.scrollY;
                
                if (scrollPosition > mediaPosition - 500) {
                    mediaContent.classList.add('bounce-in');
                }
            });
        }
        
        // Highlight tabel saat hover
        const tableCells = document.querySelectorAll('.pengumuman-content td');
        tableCells.forEach(cell => {
            cell.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'rgba(139, 0, 0, 0.05)';
            });
            
            cell.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
    });
</script>
@endsection


<Actions>
  <Action name="Tambahkan fitur pencarian pengumuman" description="Implementasi fitur pencarian untuk memudahkan pengguna menemukan pengumuman tertentu" />
  <Action name="Buat fitur filter berdasarkan kategori" description="Tambahkan filter untuk menyaring pengumuman berdasarkan kategori" />
  <Action name="Implementasi fitur berbagi pengumuman" description="Tambahkan tombol untuk berbagi pengumuman ke media sosial atau melalui email" />
  <Action name="Tambahkan fitur komentar" description="Implementasi sistem komentar untuk pengumuman agar pengguna dapat berdiskusi" />
  <Action name="Buat notifikasi pengumuman baru" description="Tambahkan sistem notifikasi untuk memberitahu pengguna tentang pengumuman baru" />
</Actions>

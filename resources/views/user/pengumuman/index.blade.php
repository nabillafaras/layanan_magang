@extends('layouts.header_user')

@section('title', 'Pengumuman - Kementerian Sosial RI')

@section('additional_css')
<style>
    /* Pengumuman Specific Styles */
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
    
    /* Featured News Styles */
    .featured-news {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 25px;
        border-radius: 15px;
        margin-bottom: 30px;
        transition: all 0.3s;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .featured-news:hover {
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        transform: translateY(-5px);
    }
    
    .featured-media {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .featured-media img, 
    .featured-media video {
        width: 100%;
        border-radius: 10px;
        transition: all 0.5s;
    }
    
    .featured-media:hover img,
    .featured-media:hover video {
        transform: scale(1.03);
    }
    
    /* News Card Styles */
    .news-card {
        height: 100%;
        transition: all 0.3s;
        border-radius: 15px;
        overflow: hidden;
    }
    
    .news-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    
    .news-card .card-img-top {
        height: 200px;
        object-fit: cover;
        transition: all 0.5s;
    }
    
    .news-card:hover .card-img-top {
        transform: scale(1.05);
    }
    
    .news-image {
        position: relative;
        overflow: hidden;
        height: 200px;
    }
    
    .video-thumbnail {
        position: relative;
        height: 100%;
    }
    
    .video-thumbnail video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .play-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 2;
        transition: all 0.3s;
        opacity: 0.8;
    }
    
    .video-thumbnail:hover .play-icon {
        transform: translate(-50%, -50%) scale(1.2);
        opacity: 1;
    }
    
    .news-card .card-body {
        padding: 20px;
    }
    
    .news-card .card-title {
        font-weight: 600;
        margin-bottom: 15px;
        color: var(--primary-color);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 50px;
    }
    
    .news-card .card-text {
        color: #666;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 75px;
    }
    
    /* Badge Styles */
    .badge {
        padding: 8px 12px;
        font-weight: 500;
        border-radius: 30px;
        font-size: 0.75rem;
    }
    
    /* Merah Theme Buttons */
    .btn-merah {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }
    
    .btn-merah:hover {
        background-color: #6a0000;
        border-color: #6a0000;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(139, 0, 0, 0.2);
    }
    
    .btn-outline-merah {
        background-color: transparent;
        border-color: var(--primary-color);
        color: var(--primary-color);
    }
    
    .btn-outline-merah:hover {
        background-color: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(139, 0, 0, 0.2);
    }
    
    .bg-merah {
        background-color: var(--primary-color) !important;
        color: white;
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
    
    /* Empty State Styles */
    .empty-state {
        text-align: center;
        padding: 50px 0;
    }
    
    .empty-state img {
        max-width: 200px;
        margin-bottom: 20px;
        opacity: 0.7;
    }
    
    .empty-state h5 {
        color: #6c757d;
        font-weight: 500;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .featured-news {
            padding: 15px;
        }
        
        .news-card .card-img-top,
        .news-image {
            height: 180px;
        }
        
        .news-card .card-title {
            height: auto;
            -webkit-line-clamp: 2;
        }
        
        .news-card .card-text {
            height: auto;
            -webkit-line-clamp: 2;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <div class="dashboard-header fade-in">
        <h2 class="mb-4">Berita & Pengumuman</h2>
        <ol class="breadcrumb mb-4 slide-in-right">
            <li class="breadcrumb-item"><a href="{{ route('user') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Berita & Pengumuman</li>
        </ol>
    </div>

    @if($pengumuman->count() > 0)
        <!-- Featured/Latest Announcement -->
        @php $latestItem = $pengumuman->first(); @endphp
        <div class="featured-news slide-in-up">
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    @if($latestItem->content)
                        <div class="featured-media">
                            @php
                                $extension = pathinfo(storage_path('app/public/'.$latestItem->content), PATHINFO_EXTENSION);
                                $videoExtensions = ['mp4', 'mov', 'avi', 'wmv'];
                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
                            @endphp
                            
                            @if(in_array(strtolower($extension), $imageExtensions))
                                <img src="{{ asset('storage/' . $latestItem->content) }}" class="img-fluid" alt="{{ $latestItem->title }}">
                            @elseif(in_array(strtolower($extension), $videoExtensions))
                                <video class="w-100" controls>
                                    <source src="{{ asset('storage/' . $latestItem->content) }}" type="video/{{ $extension }}">
                                    Browser Anda tidak mendukung pemutaran video.
                                </video>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <span class="badge bg-merah mb-2">{{ $latestItem->kategori }}</span>
                    <h4 class="fw-bold mb-3">{{ $latestItem->title }}</h4>
                    <p class="text-muted mb-3">
                        <i class="far fa-calendar me-1"></i>
                        {{ $latestItem->published_at->translatedFormat('d F Y') }}
                        <span class="ms-3"><i class="far fa-user me-1"></i> Admin</span>
                    </p>
                    <div class="lead mb-4">
                        {!! Str::limit(strip_tags($latestItem->isi), 200) !!}
                    </div>
                    <a href="{{ route('pengumuman.show', $latestItem->id) }}" class="btn btn-merah">
                        Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <h4 class="section-title fade-in">Pengumuman Lainnya</h4>
            </div>
        </div>
        
        <!-- Other News/Announcements -->
        <div class="row">
            @foreach($pengumuman->skip(1) as $index => $item)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card news-card bounce-in" style="animation-delay: {{ 0.1 * $index }}s">
                    @if($item->content)
                        <div class="news-image">
                            @php
                                $extension = pathinfo(storage_path('app/public/'.$item->content), PATHINFO_EXTENSION);
                                $videoExtensions = ['mp4', 'mov', 'avi', 'wmv'];
                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
                            @endphp
                            
                            @if(in_array(strtolower($extension), $imageExtensions))
                                <img src="{{ asset('storage/' . $item->content) }}" class="card-img-top" alt="{{ $item->title }}">
                            @elseif(in_array(strtolower($extension), $videoExtensions))
                                <div class="video-thumbnail">
                                    <video>
                                        <source src="{{ asset('storage/' . $item->content) }}" type="video/{{ $extension }}">
                                    </video>
                                    <div class="play-icon">
                                        <i class="fas fa-play-circle fa-3x text-white"></i>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-merah">{{ $item->kategori }}</span>
                            <small class="text-muted">
                                <i class="far fa-calendar me-1"></i>
                                {{ $item->published_at->translatedFormat('d F Y') }}
                            </small>
                        </div>
                        <h5 class="card-title">{{ $item->title }}</h5>
                        <div class="card-text mb-3">
                            {!! Str::limit(strip_tags($item->isi), 100) !!}
                        </div>
                        <a href="{{ route('pengumuman.show', $item->id) }}" class="btn btn-sm btn-outline-merah">
                            Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination if needed -->
        @if($pengumuman->hasPages())
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $pengumuman->links() }}
                </div>
            </div>
        </div>
        @endif
    @else
        <div class="empty-state bounce-in">
            <img src="{{ asset('images/no-data.svg') }}" alt="Tidak ada pengumuman" class="img-fluid">
            <h5>Belum ada berita atau pengumuman untuk Anda saat ini</h5>
            <p class="text-muted">Pengumuman terbaru akan ditampilkan di sini</p>
        </div>
    @endif
</div>
@endsection

@section('additional_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animasi hover untuk video thumbnail
        const videoThumbnails = document.querySelectorAll('.video-thumbnail');
        videoThumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                const videoUrl = this.querySelector('source').src;
                window.location.href = videoUrl;
            });
        });
        
        // Animasi untuk card pengumuman
        const newsCards = document.querySelectorAll('.news-card');
        newsCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.querySelector('.card-title').style.color = '#c13030';
            });
            
            card.addEventListener('mouseleave', function() {
                this.querySelector('.card-title').style.color = '';
            });
        });
        
        // Animasi scroll untuk featured news
        const featuredNews = document.querySelector('.featured-news');
        if (featuredNews) {
            window.addEventListener('scroll', function() {
                const scrollPosition = window.scrollY;
                if (scrollPosition > 100) {
                    featuredNews.style.transform = 'translateY(-5px)';
                    featuredNews.style.boxShadow = '0 15px 30px rgba(0,0,0,0.15)';
                } else {
                    featuredNews.style.transform = '';
                    featuredNews.style.boxShadow = '';
                }
            });
        }
    });
</script>
@endsection
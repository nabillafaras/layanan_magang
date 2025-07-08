@extends('layouts.header_user')
@section('title', 'Berkas Selesai Magang - Kementerian Sosial RI')

@section('additional_css')
<style>
    :root {
        --primary-color: #8b0000;
    }

    /* Dashboard Header */
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

    /* Cards */
    .dashboard-card {
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s;
        margin-bottom: 25px;
        overflow: hidden;
        border: none;
    }
    
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    
    .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #e0e0e0;
        padding: 18px 25px;
    }

    .card-header h5, .card-header h4 {
        margin: 0;
        font-weight: 600;
        color: var(--primary-color);
        display: flex;
        align-items: center;
    }
    
    .card-header h5 i, .card-header h4 i {
        margin-right: 10px;
        color: var(--primary-color);
    }

    /* Berkas Items */
    .berkas-item {
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
        border: none;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 25px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        position: relative;
        overflow: hidden;
        height: 100%;
    }
    
    .berkas-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }

    .berkas-item::before {
        content: '';
        position: absolute;
        top: -20px;
        right: -20px;
        width: 120px;
        height: 120px;
        background: rgba(139, 0, 0, 0.05);
        border-radius: 50%;
        z-index: 0;
    }
    
    .berkas-icon {
        font-size: 3rem;
        margin-bottom: 20px;
        transition: all 0.3s;
        position: relative;
        z-index: 1;
    }

    .berkas-item:hover .berkas-icon {
        transform: scale(1.2);
    }
    
    .berkas-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: var(--primary-color);
        position: relative;
        z-index: 1;
    }
    
    .berkas-description {
        color: #6c757d;
        margin-bottom: 20px;
        font-size: 0.95rem;
        position: relative;
        z-index: 1;
    }
    
    .btn-view {
        background: linear-gradient(90deg, var(--primary-color), #c13030);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 30px;
        transition: all 0.3s ease;
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(139, 0, 0, 0.3);
        color: white;
    }
    
    .btn-download {
        background: linear-gradient(90deg, #28a745, #20c997);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 30px;
        transition: all 0.3s ease;
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        color: white;
    }

    .btn-secondary {
        background: #6c757d;
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 30px;
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .status-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 8px 15px;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 500;
        z-index: 2;
    }
    
    .status-tersedia {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .status-belum-tersedia {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .info-panel {
        background: linear-gradient(90deg, var(--primary-color), #c13030);
        color: white;
        padding: 25px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(139, 0, 0, 0.2);
    }
    
    .info-panel h5 {
        margin-bottom: 15px;
        font-weight: 600;
        font-size: 1.3rem;
    }
    
    .info-panel p {
        margin-bottom: 0;
        opacity: 0.95;
        font-size: 1rem;
    }

    /* Section Title */
    .section-title {
        position: relative;
        padding-bottom: 12px;
        margin-bottom: 25px;
        font-weight: 600;
        color: var(--primary-color);
    }

    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        height: 3px;
        width: 60px;
        background: linear-gradient(90deg, var(--primary-color), #c13030);
        border-radius: 2px;
    }

    /* Alert Styling */
    .alert-warning {
        background: linear-gradient(135deg, #fff3cd 0%, #fef7e1 100%);
        border: 1px solid #ffeaa7;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
    }

    .alert-warning i {
        color: #856404;
        margin-bottom: 15px;
    }

    .alert-warning h5 {
        color: #856404;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .alert-info {
        background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
        border: 1px solid #abd8e2;
        border-radius: 15px;
        padding: 25px;
    }

    .alert-info h6 {
        color: #0c5460;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .alert-info ul {
        color: #0c5460;
        margin-bottom: 0;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideInUp {
        from { transform: translateY(50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    
    .slide-in-up {
        animation: slideInUp 0.5s ease-in-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .berkas-icon {
            font-size: 2.5rem;
        }
        
        .berkas-item {
            padding: 20px;
        }
        
        .info-panel {
            padding: 20px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <h2>Berkas Selesai Magang</h2>
            </div>
            
            <!-- Info Panel -->
            <div class="info-panel fade-in">
                <h5><i class="fas fa-info-circle me-2"></i>Informasi Berkas Selesai Magang</h5>
                <p>Berikut adalah berkas-berkas yang akan Anda terima setelah menyelesaikan program magang di Kementerian Sosial RI. Pastikan untuk mengunduh dan menyimpan semua berkas dengan baik.</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-certificate me-2"></i>
                        Berkas Selesai Magang
                    </h4>
                </div>
                <div class="card-body">
                    @if(isset($dokumen_selesai))
                        <div class="row">
                            <!-- SK Selesai -->
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="berkas-item text-center position-relative slide-in-up">
                                    <div class="status-badge {{ $dokumen_selesai->sk_selesai ? 'status-tersedia' : 'status-belum-tersedia' }}">
                                        {{ $dokumen_selesai->sk_selesai ? 'Tersedia' : 'Belum Tersedia' }}
                                    </div>
                                    <div class="berkas-icon text-primary">
                                        <i class="fas fa-file-contract"></i>
                                    </div>
                                    <h5 class="berkas-title">Surat Keterangan Selesai</h5>
                                    <p class="berkas-description">
                                        Surat keterangan resmi yang menyatakan bahwa Anda telah menyelesaikan program magang dengan baik.
                                    </p>
                                    <div class="d-flex justify-content-center gap-2">
                                        @if($dokumen_selesai->sk_selesai)
                                            
                                            <a href="{{ url('storage/' . str_replace('storage/', '', $dokumen_selesai->sk_selesai)) }}" 
                                               download class="btn btn-success btn-sm">
                                                <i class="fas fa-download me-1"></i> Unduh
                                            </a>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled>
                                                <i class="fas fa-clock me-1"></i> Menunggu
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Sertifikat -->
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="berkas-item text-center position-relative slide-in-up" style="animation-delay: 0.2s;">
                                    <div class="status-badge {{ $dokumen_selesai->sertifikat ? 'status-tersedia' : 'status-belum-tersedia' }}">
                                        {{ $dokumen_selesai->sertifikat ? 'Tersedia' : 'Belum Tersedia' }}
                                    </div>
                                    <div class="berkas-icon text-success">
                                        <i class="fas fa-award"></i>
                                    </div>
                                    <h5 class="berkas-title">Sertifikat Magang</h5>
                                    <p class="berkas-description">
                                        Sertifikat resmi sebagai bukti telah mengikuti dan menyelesaikan program magang di Kementerian Sosial RI.
                                    </p>
                                    <div class="d-flex justify-content-center gap-2">
                                        @if($dokumen_selesai->sertifikat)
                                          
                                            <a href="{{ url('storage/' . str_replace('storage/', '', $dokumen_selesai->sertifikat)) }}" 
                                               download class="btn btn-success btn-sm">
                                                <i class="fas fa-download me-1"></i> Unduh
                                            </a>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled>
                                                <i class="fas fa-clock me-1"></i> Menunggu
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Nilai Magang -->
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="berkas-item text-center position-relative slide-in-up" style="animation-delay: 0.4s;">
                                    <div class="status-badge {{ $dokumen_selesai->nilai_magang ? 'status-tersedia' : 'status-belum-tersedia' }}">
                                        {{ $dokumen_selesai->nilai_magang ? 'Tersedia' : 'Belum Tersedia' }}
                                    </div>
                                    <div class="berkas-icon text-warning">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <h5 class="berkas-title">Nilai Magang</h5>
                                    <p class="berkas-description">
                                        Laporan penilaian kinerja selama mengikuti program magang berdasarkan evaluasi pembimbing.
                                    </p>
                                    <div class="d-flex justify-content-center gap-2">
                                        @if($dokumen_selesai->nilai_magang)
                                           
                                            <a href="{{ url('storage/' . str_replace('storage/', '', $dokumen_selesai->nilai_magang)) }}" 
                                               download class="btn btn-success btn-sm">
                                                <i class="fas fa-download me-1"></i> Unduh
                                            </a>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled>
                                                <i class="fas fa-clock me-1"></i> Menunggu
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Tambahan -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle me-2"></i>Informasi Penting:</h6>
                                    <ul class="mb-0">
                                        <li>Berkas-berkas akan tersedia setelah Anda menyelesaikan seluruh program magang</li>
                                        <li>Pastikan untuk mengunduh semua berkas sebelum masa akses berakhir</li>
                                        <li>Jika ada kendala dalam mengunduh berkas, hubungi pembimbing atau admin</li>
                                        <li>Simpan berkas dalam format digital dan cetak jika diperlukan</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-warning fade-in">
                                    <i class="fas fa-info-circle fa-3x mb-3"></i>
                                    <h5>Dokumen Belum Tersedia</h5>
                                    <p class="mb-0">Dokumen penyelesaian program belum tersedia. Pastikan Anda telah menyelesaikan seluruh program magang dan laporan akhir sudah disetujui.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_js')
<script>
    // Enhanced animations on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Animate berkas items
        const berkasItems = document.querySelectorAll('.berkas-item');
        berkasItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                item.style.transition = 'all 0.6s ease-out';
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, index * 150 + 300);
        });

        // Animate dashboard header
        const header = document.querySelector('.dashboard-header');
        if (header) {
            header.style.opacity = '0';
            header.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                header.style.transition = 'all 0.5s ease-out';
                header.style.opacity = '1';
                header.style.transform = 'translateY(0)';
            }, 100);
        }

        // Animate info panel
        const infoPanel = document.querySelector('.info-panel');
        if (infoPanel) {
            infoPanel.style.opacity = '0';
            infoPanel.style.transform = 'scale(0.95)';
            setTimeout(() => {
                infoPanel.style.transition = 'all 0.5s ease-out';
                infoPanel.style.opacity = '1';
                infoPanel.style.transform = 'scale(1)';
            }, 200);
        }

        // Add hover effects to buttons
        const buttons = document.querySelectorAll('.btn-view, .btn-download');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px) scale(1.05)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Add pulse animation to available document badges
        const availableBadges = document.querySelectorAll('.status-tersedia');
        availableBadges.forEach(badge => {
            badge.style.animation = 'pulse 2s infinite';
        });
    });

    // Add pulse keyframe animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(21, 87, 36, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(21, 87, 36, 0); }
            100% { box-shadow: 0 0 0 0 rgba(21, 87, 36, 0); }
        }
    `;
    document.head.appendChild(style);
</script>
@endsection
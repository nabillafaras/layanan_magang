@extends('layouts.header_admin')

@section('title', 'Direktorat 4 - Kementerian Sosial RI')

@section('additional_css')
<style>
    /* Dashboard Specific Styles */
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
    
    .card-header h5 {
        margin: 0;
        font-weight: 600;
        color: #333;
        display: flex;
        align-items: center;
    }
    
    .card-header h5 i, .card-header i {
        margin-right: 10px;
        color: var(--primary-color);
    }
    
    .table {
        width: 100%;
        margin-bottom: 0;
    }
    
    .table th {
        background-color: #f8f9fa;
        color: #333;
        font-weight: 600;
        padding: 15px;
        border-bottom: 2px solid #e0e0e0;
        white-space: nowrap;
    }
    
    .table td {
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #e0e0e0;
        transition: all 0.3s;
    }
    
    .table tr:hover td {
        background-color: rgba(139, 0, 0, 0.02);
    }
    
    .table tr:last-child td {
        border-bottom: none;
    }
    
    .btn {
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        border-radius: 50px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    
    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.875rem;
    }
    
    .btn::after {
        content: '';
        position: absolute;
        width: 0;
        height: 100%;
        top: 0;
        left: 0;
        transition: width 0.3s ease;
        z-index: -1;
        border-radius: 50px;
    }
    
    .btn:hover::after {
        width: 100%;
    }
    
    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), #5a0000);
        color: white;
    }
    
    .btn-primary::after {
        background-color: rgba(255, 255, 255, 0.2);
    }
    
    .btn-info {
        background: linear-gradient(135deg, #17a2b8, #138496);
        color: white;
    }
    
    .btn-info::after {
        background-color: rgba(255, 255, 255, 0.2);
    }
    
    .badge {
        padding: 8px 12px;
        font-weight: 500;
        border-radius: 30px;
        font-size: 0.85rem;
    }
    
    .bg-warning {
        background-color: #ffc107 !important;
        color: #212529 !important;
    }
    
    .bg-success {
        background-color: #28a745 !important;
        color: white !important;
    }
    
    .bg-danger {
        background-color: #dc3545 !important;
        color: white !important;
    }
    
    .bg-primary {
        background-color: var(--primary-color) !important;
        color: white !important;
    }
    
    .stats-card {
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }
    
    .stats-card .card-body {
        padding: 25px;
        position: relative;
        z-index: 1;
        overflow: hidden;
    }
    
    .stats-card .card-body::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        transform: rotate(30deg);
        z-index: -1;
    }
    
    .stats-card h2 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .stats-card p {
        font-size: 1.1rem;
        margin-bottom: 0;
    }
    
    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .modal-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6a0000 100%);
        color: white;
        border-bottom: none;
        padding: 1.2rem 1.5rem;
    }
    
    .modal-title {
        font-weight: 600;
    }
    
    .modal-body {
        padding: 1.5rem;
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
    
    @keyframes pulseGlow {
        0% { box-shadow: 0 0 0 0 rgba(139, 0, 0, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(139, 0, 0, 0); }
        100% { box-shadow: 0 0 0 0 rgba(139, 0, 0, 0); }
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
    
    .pulse-glow {
        animation: pulseGlow 2s infinite;
    }
    
    /* DataTables Custom Styling */
    .dataTables_wrapper .dataTables_length, 
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 15px;
    }
    
    .dataTables_wrapper .dataTables_length select, 
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 8px;
        padding: 8px 12px;
        border: 1px solid #ced4da;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 50px;
        padding: 5px 12px;
        margin: 0 3px;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--primary-color);
        color: white !important;
        border: none;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: rgba(139, 0, 0, 0.1);
        color: var(--primary-color) !important;
        border: none;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .table-responsive {
            border-radius: 15px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <div class="dashboard-header fade-in">
        <h2 class="mt-4">Direktorat 4</h2>
        <ol class="breadcrumb mb-4 slide-in-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Direktorat 4</li>
        </ol>
    </div>

    <!-- Jumlah Peserta Magang Aktif -->
    <div class="row">
        <div class="col-12">
            <div class="dashboard-card slide-in-up" style="animation-delay: 0.1s">
                <div class="card-header">
                    <h5><i class="fas fa-user-graduate"></i> Jumlah Peserta Magang Aktif</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="stats-card bg-primary text-white mb-4 bounce-in" style="animation-delay: 0.3s">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <h2 class="counter">{{ $jumlahPeserta }}</h2>
                                            <p class="mb-0">Peserta Aktif</p>
                                        </div>
                                        <div class="icon-box">
                                            <i class="fas fa-users fa-3x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-bordered" id="tabelAbsensi">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Lokasi Check In</th>
            <th>Lokasi Check Out</th>
            <th>Photo Check In</th>
            <th>Photo Check Out</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($absensi as $index => $a)
            <tr class="fade-in" style="animation-delay: {{ $index * 0.05 }}s">
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-2" style="width: 32px; height: 32px; border-radius: 50%; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                        <span>{{ $a->pendaftaran->nama_lengkap ?? 'Tidak diketahui' }}</span>
                    </div>
                </td>
                <td>{{ \Carbon\Carbon::parse($a->date)->format('d-m-Y') }}</td>
                <td>{{ $a->check_in_time ? \Carbon\Carbon::parse($a->check_in_time)->format('H:i:s') : '-' }}</td>
                <td>{{ $a->check_out_time ? \Carbon\Carbon::parse($a->check_out_time)->format('H:i:s') : '-' }}</td>
                
                <td>
                    @if($a->check_in_latitude && $a->check_in_longitude)
                        <button type="button" class="btn btn-sm btn-primary lihat-peta" 
                                data-bs-toggle="modal" 
                                data-bs-target="#mapModal" 
                                data-lat="{{ $a->check_in_latitude }}" 
                                data-lng="{{ $a->check_in_longitude }}"
                                data-lokasi="Check In: {{ $a->check_in_location }}">
                            <i class="fas fa-map-marker-alt me-1"></i> Lihat Peta
                        </button>
                    @else
                        {{ $a->check_in_location ?: '-' }}
                    @endif
                </td>
                <td>
                    @if($a->check_out_latitude && $a->check_out_longitude)
                        <button type="button" class="btn btn-sm btn-info lihat-peta" 
                                data-bs-toggle="modal" 
                                data-bs-target="#mapModal" 
                                data-lat="{{ $a->check_out_latitude }}" 
                                data-lng="{{ $a->check_out_longitude }}"
                                data-lokasi="Check Out: {{ $a->check_out_location }}">
                            <i class="fas fa-map-marker-alt me-1"></i> Lihat Peta
                        </button>
                    @else
                        {{ $a->check_out_location ?: '-' }}
                    @endif
                </td>
                
                <td>
                    @if($a->check_in_photo)
                        <button type="button" class="btn btn-sm btn-primary lihat-foto" 
                                data-bs-toggle="modal" 
                                data-bs-target="#photoModal" 
                                data-foto="{{ asset('storage/' . $a->check_in_photo) }}"
                                data-title="Foto Check In - {{ $a->pendaftaran->nama_lengkap ?? 'Tidak diketahui' }}">
                            <i class="fas fa-camera me-1"></i> Lihat Foto
                        </button>
                    @else
                        <span class="text-muted">Tidak ada foto</span>
                    @endif
                </td>
                <td>
                    @if($a->check_out_photo)
                        <button type="button" class="btn btn-sm btn-success lihat-foto" 
                                data-bs-toggle="modal" 
                                data-bs-target="#photoModal" 
                                data-foto="{{ asset('storage/' . $a->check_out_photo) }}"
                                data-title="Foto Check Out - {{ $a->pendaftaran->nama_lengkap ?? 'Tidak diketahui' }}">
                            <i class="fas fa-camera me-1"></i> Lihat Foto
                        </button>
                    @else
                        <span class="text-muted">Tidak ada foto</span>
                    @endif
                </td>
                <td>
                    <span class="badge {{ $a->status == 'Hadir' ? 'bg-success' : ($a->status == 'Izin' ? 'bg-warning' : 'bg-danger') }}">
                        {{ $a->status }}
                    </span>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal untuk menampilkan foto -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Foto Absensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalFoto" src="" alt="Foto Absensi" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

    <!-- Rekapitulasi Laporan Bulanan -->
    <div class="row">
        <div class="col-12">
            <div class="dashboard-card slide-in-up" style="animation-delay: 0.3s">
                <div class="card-header">
                    <h5><i class="fas fa-file-alt"></i> Rekapitulasi Laporan Bulanan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tabelLaporan">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Jenis Laporan</th>
                                    <th>Judul</th>
                                    <th>Periode</th>
                                    <th>Status</th>
                                    <th>Feedback</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($laporan as $index => $l)
                                    <tr class="fade-in" style="animation-delay: {{ $index * 0.05 }}s">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2" style="width: 32px; height: 32px; border-radius: 50%; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-user text-primary"></i>
                                                </div>
                                                <span>{{ $l->pendaftaran->nama_lengkap ?? 'Tidak diketahui' }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $l->jenis_laporan }}</td>
                                        <td>{{ $l->judul }}</td>
                                        <td>{{ $l->periode_bulan ? \Carbon\Carbon::parse($l->periode_bulan)->format('F Y') : '-' }}</td>
                                        <td>
                                            <span class="badge {{ $l->status == 'Menunggu' ? 'bg-warning' : ($l->status == 'Acc' ? 'bg-success' : 'bg-danger') }}">
                                                {{ $l->status }}
                                            </span>
                                        </td>
                                        <td>{{ $l->feedback ?: '-' }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.detail-laporan', ['id' => $l->id]) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye me-1"></i> Lihat
                                                </a>
                                                <a href="{{ asset($l->file_path) }}" class="btn btn-sm btn-info" target="_blank">
                                                    <i class="fas fa-download me-1"></i> Unduh
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk menampilkan peta -->
<div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mapModalLabel">
                    <i class="fas fa-map-marked-alt me-2"></i> Detail Lokasi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="map" style="width: 100%; height: 400px; border-radius: 10px;"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">

<!-- Leaflet CSS dan JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="anonymous" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="anonymous"></script>

<script>

    document.addEventListener('DOMContentLoaded', function() {
        // Event untuk tombol lihat foto
        $(document).on('click', '.lihat-foto', function() {
            var foto = $(this).data('foto');
            var title = $(this).data('title');
            
            $('#photoModalLabel').text(title);
            $('#modalFoto').attr('src', foto);
        });
    });

    $(document).ready(function() {
        // Inisialisasi DataTables dengan animasi
        $('#tabelAbsensi').DataTable({
            order: [[1, 'desc']],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
            },
            "drawCallback": function() {
                $('.dataTables_paginate .paginate_button').addClass('fade-in');
            }
        });
        
        $('#tabelLaporan').DataTable({
            order: [[3, 'desc']],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
            },
            "drawCallback": function() {
                $('.dataTables_paginate .paginate_button').addClass('fade-in');
            }
        });

        // Animasi counter untuk jumlah peserta
        $('.counter').each(function() {
            const $this = $(this);
            const countTo = parseInt($this.text());
            
            $({ countNum: 0 }).animate({
                countNum: countTo
            }, {
                duration: 1000,
                easing: 'swing',
                step: function() {
                    $this.text(Math.floor(this.countNum));
                },
                complete: function() {
                    $this.text(this.countNum);
                }
            });
        });

        // Variable untuk menyimpan instance map Leaflet
        let map = null;
        
        // Event listener untuk menampilkan modal dengan peta
        $('.lihat-peta').click(function() {
            const lat = $(this).data('lat');
            const lng = $(this).data('lng');
            const lokasi = $(this).data('lokasi');
            
            // Update judul modal
            $('#mapModalLabel').html('<i class="fas fa-map-marked-alt me-2"></i> Detail Lokasi - ' + lokasi);
            
            // Reset konten map container
            $('#map').html('');
        });
        
        // Event handler yang berjalan setelah modal ditampilkan sepenuhnya
        $('#mapModal').on('shown.bs.modal', function(e) {
            const button = $(e.relatedTarget); // Tombol yang memicu modal
            const lat = button.data('lat');
            const lng = button.data('lng');
            
            // Pastikan container sudah siap sebelum inisialisasi peta
            setTimeout(function() {
                initMap(lat, lng);
            }, 100);
        });
        
        // Event handler saat modal ditutup
        $('#mapModal').on('hidden.bs.modal', function() {
            // Hapus instance map untuk menghindari konflik
            if (map) {
                map.remove();
                map = null;
            }
        });
        
        // Fungsi untuk inisialisasi peta Leaflet
        function initMap(lat, lng) {
            // Hapus instance peta sebelumnya jika ada
            if (map) {
                map.remove();
            }
            
            const latLng = [parseFloat(lat), parseFloat(lng)];
            
            // Pastikan container map memiliki ukuran yang sesuai
            $('#map').css({
                'width': '100%',
                'height': '400px',
                'border-radius': '10px'
            });
            
            // Buat instance peta baru dengan animasi
            map = L.map('map', {
                center: latLng,
                zoom: 15,
                zoomControl: true,
                fadeAnimation: true,
                zoomAnimation: true
            });
            
            // Tambahkan tile layer OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19
            }).addTo(map);
            
            // Tambahkan marker dengan animasi
            const marker = L.marker(latLng, {
                opacity: 0
            }).addTo(map);
            
            // Animasi marker muncul
            setTimeout(function() {
                marker.setOpacity(1);
                marker.bindPopup($('#mapModalLabel').text())
                      .openPopup();
            }, 300);
            
            // Pastikan peta ter-render dengan baik
            map.invalidateSize();
        }
        
        // Tambahkan efek hover pada baris tabel
        const tableRows = document.querySelectorAll('#tabelAbsensi tbody tr, #tabelLaporan tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(5px)';
                this.style.transition = 'transform 0.3s ease';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });
    });
</script>
@endsection
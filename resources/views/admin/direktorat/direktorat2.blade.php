@extends('layouts.header_admin')

@section('title', 'Direktorat 2 - Kementerian Sosial RI')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Direktorat 2</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Direktorat 2</li>
    </ol>

    <!-- Jumlah Peserta Magang Aktif -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user-graduate me-1"></i>
                    Jumlah Peserta Magang Aktif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <h2 class="text-center">{{ $jumlahPeserta }}</h2>
                                    <p class="text-center mb-0">Peserta Aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekapitulasi Absensi -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-clipboard-list me-1"></i>
                    Rekapitulasi Absensi
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tabelAbsensi">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Lokasi Check In</th>
                                    <th>Lokasi Check Out</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($absensi as $a)
                                    <tr>
                                        <td>{{ $a->pendaftaran->nama_lengkap ?? 'Tidak diketahui' }}</td>
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
                                                    <i class="fas fa-map-marker-alt"></i> Lihat Peta
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
                                                    <i class="fas fa-map-marker-alt"></i> Lihat Peta
                                                </button>
                                            @else
                                                {{ $a->check_out_location ?: '-' }}
                                            @endif
                                        </td>
                                        <td>{{ $a->status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekapitulasi Laporan Bulanan -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-file-alt me-1"></i>
                    Rekapitulasi Laporan Bulanan
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
                                @foreach($laporan as $l)
                                    <tr>
                                        <td>{{ $l->pendaftaran->nama_lengkap ?? 'Tidak diketahui' }}</td>
                                        <td>{{ $l->jenis_laporan }}</td>
                                        <td>{{ $l->judul }}</td>
                                        <td>{{ $l->periode_bulan ? \Carbon\Carbon::parse($l->periode_bulan)->format('F Y') : '-' }}</td>
                                        <td>
                                            <span class="badge {{ $l->status == 'menunggu' ? 'bg-warning' : ($l->status == 'Acc' ? 'bg-success' : 'bg-danger') }}">
                                                {{ $l->status }}
                                            </span>
                                        </td>
                                        <td>{{ $l->feedback ?: '-' }}</td>
                                        <td>
                                            <a href="{{ route('admin.detail-laporan', ['id' => $l->id]) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                            <a href="{{ asset($l->file_path) }}" class="btn btn-sm btn-info" target="_blank">
                                                <i class="fas fa-download"></i> Unduh
                                            </a>
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
                <h5 class="modal-title" id="mapModalLabel">Detail Lokasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="map" style="width: 100%; height: 400px;"></div>
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
    $(document).ready(function() {
        $('#tabelAbsensi').DataTable({
            order: [[1, 'desc']],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
            }
        });
        
        $('#tabelLaporan').DataTable({
            order: [[3, 'desc']],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
            }
        });

        // Variable untuk menyimpan instance map Leaflet
        let map = null;
        
        // Event listener untuk menampilkan modal dengan peta
        $('.lihat-peta').click(function() {
            const lat = $(this).data('lat');
            const lng = $(this).data('lng');
            const lokasi = $(this).data('lokasi');
            
            // Update judul modal
            $('#mapModalLabel').text('Detail Lokasi - ' + lokasi);
            
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
                'height': '400px'
            });
            
            // Buat instance peta baru
            map = L.map('map', {
                center: latLng,
                zoom: 15,
                zoomControl: true
            });
            
            // Tambahkan tile layer OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19
            }).addTo(map);
            
            // Tambahkan marker
            L.marker(latLng).addTo(map)
                .bindPopup($('#mapModalLabel').text())
                .openPopup();
                
            // Pastikan peta ter-render dengan baik
            map.invalidateSize();
        }
    });
</script>
@endsection
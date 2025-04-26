<?php

use App\Http\Controllers\Admin1\Admin1Controller;
use App\Http\Controllers\Admin2\Admin2Controller;
use App\Http\Controllers\Admin3\Admin3Controller;
use App\Http\Controllers\Admin4\Admin4Controller;
use App\Http\Controllers\Admin5\Admin5Controller;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CreateController;
use App\Http\Controllers\DirektoratController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\Informasi_PesertaController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\LaporanAkhirController;
use App\Http\Controllers\LaporanBulananController;
use App\Http\Controllers\LoginAdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\Pendaftaran_SummaryController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PengumumanUserController;
use App\Http\Controllers\PersyaratanController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\Pimpinans\AbsensiPimpinanController;
use App\Http\Controllers\Pimpinans\LaporanPimpinanController;
use App\Http\Controllers\Pimpinans\PesertaPimpinanController;
use App\Http\Controllers\Pimpinans\PimpinanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekapAbsensiController;
use App\Http\Controllers\RekapLaporanController;
use App\Http\Controllers\SakitController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Berikut adalah definisi routes untuk aplikasi web. Routes ini di-load oleh
| RouteServiceProvider dan semuanya akan masuk ke group "web" middleware.
|
*/

// ====================================
// ROUTE PUBLIK (TIDAK PERLU LOGIN)
// ====================================
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi');
Route::get('/persyaratan', [PersyaratanController::class, 'index'])->name('persyaratan');
Route::get('/informasi_peserta', [Informasi_PesertaController::class, 'index'])->name('informasi_peserta');

// Routes untuk pendaftaran
Route::get('/pendaftaran', [PendaftaranController::class, 'showForm'])->name('pendaftaran');
Route::post('/pendaftaran/store', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
Route::get('/pendaftaran/summary/{id}', [Pendaftaran_SummaryController::class, 'index'])->name('pendaftaran.summary');

// Routes untuk cek status pendaftaran
Route::get('/cek-status', [StatusController::class, 'form'])->name('status.form');
Route::post('/cek-status', [StatusController::class, 'check'])->name('status.check');

// ====================================
// ROUTE AUTENTIKASI USER
// ====================================
Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [UserAuthController::class, 'authenticate'])->name('login.authenticate');

// ====================================
// ROUTE USER (PESERTA) - PERLU LOGIN
// ====================================
Route::middleware(['auth:web', 'checkRole:user'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
    
    // User Dashboard untuk menu absensi
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance');
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.check-in');
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.check-out');
    Route::get('/attendance/history', [AttendanceController::class, 'history'])->name('attendance.history');
    Route::get('/attendance/check-gps', [AttendanceController::class, 'checkGpsStatus'])->name('attendance.check-gps');
    Route::post('/attendance/request-gps-access', [AttendanceController::class, 'requestGpsAccess'])->name('attendance.request-gps-access');
    Route::get('/attendance/location-confirmation', [AttendanceController::class, 'showLocationConfirmation'])->name('attendance.location-confirmation');
    // Routes untuk fitur izin
    Route::get('/izin', [IzinController::class, 'index'])->name('izin');
    Route::post('/izin/submit', [IzinController::class, 'submit'])->name('izin.submit');
    // Routes untuk fitur sakit
    Route::get('/sakit', [SakitController::class, 'index'])->name('sakit');
    Route::post('/sakit/store', [SakitController::class, 'store'])->name('sakit.store');
    // Laporan Bulanan
    Route::get('/laporan/bulanan', [LaporanBulananController::class, 'index'])->name('laporan.bulanan');
    Route::post('/laporan/bulanan/upload', [LaporanBulananController::class, 'upload'])->name('laporan.bulanan.upload');
    Route::get('/laporan/bulanan/download/{id}', [LaporanBulananController::class, 'download'])->name('laporan.bulanan.download');
    Route::delete('/laporan/bulanan/delete/{id}', [LaporanBulananController::class, 'delete'])->name('laporan.bulanan.delete');
    // Laporan Akhir
    Route::get('/laporan/akhir', [LaporanAkhirController::class, 'index'])->name('laporan.akhir');
    Route::post('/laporan/akhir/upload', [LaporanAkhirController::class, 'upload'])->name('laporan.akhir.upload');
    Route::get('/laporan/akhir/download/{id}', [LaporanAkhirController::class, 'download'])->name('laporan.akhir.download');
    Route::delete('/laporan/akhir/delete/{id}', [LaporanAkhirController::class, 'delete'])->name('laporan.akhir.delete');
    //profile
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/change-password', [App\Http\Controllers\ProfileController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('update.password');
    //pengumuman
    Route::get('/pengumuman', [App\Http\Controllers\PengumumanUserController::class, 'index'])->name('pengumuman');
    Route::get('/pengumuman/{id}', [App\Http\Controllers\PengumumanUserController::class, 'show'])->name('pengumuman.show');
});

// ====================================
// ROUTE ADMIN
// ====================================
Route::prefix('admin')->group(function () {
    // Admin login routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [LoginAdminController::class, 'index'])->name('admin.login');
        Route::post('/login', [AdminAuthController::class, 'adminAuthenticate'])->name('admin.authenticate');
    });
    

    // Admin protected routes
    Route::middleware(['auth:admin', 'checkRole:admin'])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
        // Di dalam grup route admin
        
        
        // Admin dashboard untuk menu create admin
        Route::get('/create', [CreateController::class, 'create'])->name('admin.create');
        Route::post('/store', [CreateController::class, 'store'])->name('admin.store');
        
        // Peserta routes
        Route::get('/peserta', [PesertaController::class, 'index'])->name('admin.peserta');
        Route::put('/peserta/{id}', [PesertaController::class, 'update'])->name('admin.peserta.update');
        
        // route untuk rekap absensi
        Route::get('/rekap-absensi', [RekapAbsensiController::class, 'index'])->name('admin.rekapitulasi-absensi');
        Route::get('/export-absensi', [RekapAbsensiController::class, 'exportExcel'])->name('admin.export-absensi');
    
        // Rute untuk rekapitulasi laporan
        Route::get('/admin/rekapitulasi-laporan', [App\Http\Controllers\RekapLaporanController::class, 'index'])->name('admin.rekapitulasi-laporan');
        Route::get('/admin/export-laporan', [App\Http\Controllers\RekapLaporanController::class, 'exportExcel'])->name('admin.export-laporan');

        //pengelolaan per direktorat
        Route::get('/admin/direktorat/direktorat1', [DirektoratController::class, 'direktorat1'])->name('admin.direktorat.direktorat1');
        Route::get('/admin/direktorat/direktorat2', [DirektoratController::class, 'direktorat2'])->name('admin.direktorat.direktorat2');
        Route::get('/admin/direktorat/direktorat3', [DirektoratController::class, 'direktorat3'])->name('admin.direktorat.direktorat3');
        Route::get('/admin/direktorat/direktorat4', [DirektoratController::class, 'direktorat4'])->name('admin.direktorat.direktorat4');
        Route::get('/admin/direktorat/direktorat5', [DirektoratController::class, 'direktorat5'])->name('admin.direktorat.direktorat5');
        
        // Perbaikan pada route detail laporan
        Route::get('/admin/detail/laporan/{id}', [DirektoratController::class, 'detailLaporan'])->name('admin.detail-laporan');
                
        // Perbaikan route untuk submit feedback
        Route::post('/admin/submit-feedback/{id}', [DirektoratController::class, 'submitFeedback'])->name('admin.submit-feedback');
        Route::post('/admin/laporan/{id}/update-status', [DirektoratController::class, 'updateStatus'])->name('admin.update-status');
        Route::get('/admin/direktorat/{id}', [DirektoratController::class, 'showDirektorat'])->name('admin.direktorat');
        Route::get('/admin/direktorat/{direktorat}/map', [DirektoratController::class, 'mapDirektorat'])->name('admin.direktorat.map');
    

      
    // Pengumuman routes
Route::prefix('admin/pengumuman')->name('admin.pengumuman.')->group(function () {
    Route::get('/', [PengumumanController::class, 'index'])->name('index');
    Route::post('/', [PengumumanController::class, 'store'])->name('store');
    Route::put('/{pengumuman}', [PengumumanController::class, 'update'])->name('update');
    Route::delete('/{pengumuman}', [PengumumanController::class, 'destroy'])->name('destroy');
    Route::patch('/{pengumuman}/status', [PengumumanController::class, 'updateStatus'])->name('update.status');
});
});
});

// ====================================
// ROUTE PIMPINAN
// ====================================
Route::prefix('pimpinan')->group(function () {
    Route::middleware(['auth:admin', 'checkRole:pimpinan'])->group(function () {
        Route::get('/', [PimpinanController::class, 'index'])->name('pimpinan.dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('pimpinan.logout');
        // Route untuk data peserta
        Route::get('/pimpinan/peserta', [PesertaPimpinanController::class, 'index'])->name('pimpinan.peserta.index');
        Route::get('/pimpinan/peserta/{id}', [PesertaPimpinanController::class, 'show'])->name('pimpinan.peserta.show');
        // route untuk rekap absensi
        Route::get('/rekap-absensi', [AbsensiPimpinanController::class, 'index'])->name('pimpinan.absensi');
        Route::get('/export-absensi', [AbsensiPimpinanController::class, 'exportExcel'])->name('export-absensi');
    
        // Rute untuk rekapitulasi laporan
    Route::get('/rekapitulasi-laporan', [LaporanPimpinanController::class, 'index'])->name('pimpinan.laporan');
    Route::get('/export-laporan', [LaporanPimpinanController::class, 'exportExcel'])->name('export-laporan');
});
});

// ====================================
// ROUTE ADMIN1
// ====================================
Route::prefix('admin1')->group(function () {
    Route::middleware(['auth:admin', 'checkRole:admin1'])->group(function () {
        Route::get('/', [Admin1Controller::class, 'index'])->name('admin1.dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin1.logout');
    });
});


// ====================================
// ROUTE ADMIN2
// ====================================
Route::prefix('admin2')->group(function () {
    Route::middleware(['auth:admin', 'checkRole:admin2'])->group(function () {
        Route::get('/', [Admin2Controller::class, 'index'])->name('admin2.dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin2.logout');
    });
});


// ====================================
// ROUTE ADMIN3
// ====================================
Route::prefix('admin3')->group(function () {
    Route::middleware(['auth:admin', 'checkRole:admin3'])->group(function () {
        Route::get('/', [Admin3Controller::class, 'index'])->name('admin3.dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin3.logout');
    });
});


// ====================================
// ROUTE ADMIN4
// ====================================
Route::prefix('admin4')->group(function () {
    Route::middleware(['auth:admin', 'checkRole:admin4'])->group(function () {
        Route::get('/', [Admin4Controller::class, 'index'])->name('admin4.dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin4.logout');
    });
});

// ====================================
// ROUTE ADMIN5
// ====================================
Route::prefix('admin5')->group(function () {
    Route::middleware(['auth:admin', 'checkRole:admin5'])->group(function () {
        Route::get('/', [Admin5Controller::class, 'index'])->name('admin5.dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin5.logout');
    });
});
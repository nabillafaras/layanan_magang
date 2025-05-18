<?php

use App\Http\Controllers\Admin1\Admin1Controller;
use App\Http\Controllers\Admin1\Direktorat1Controller;
use App\Http\Controllers\Admin1\Peserta1Controller;
use App\Http\Controllers\Admin1\RekapAbsensi1Controller;
use App\Http\Controllers\Admin1\RekapLaporan1Controller;
use App\Http\Controllers\Admin1\Pengumuman1Controller;
use App\Http\Controllers\Admin1\AdminProfile1Controller;

use App\Http\Controllers\Admin2\Admin2Controller;
use App\Http\Controllers\Admin2\Direktorat2Controller;
use App\Http\Controllers\Admin2\Peserta2Controller;
use App\Http\Controllers\Admin2\RekapAbsensi2Controller;
use App\Http\Controllers\Admin2\RekapLaporan2Controller;
use App\Http\Controllers\Admin2\Pengumuman2Controller;
use App\Http\Controllers\Admin2\AdminProfile2Controller;

use App\Http\Controllers\Admin3\Admin3Controller;
use App\Http\Controllers\Admin3\Direktorat3Controller;
use App\Http\Controllers\Admin3\Peserta3Controller;
use App\Http\Controllers\Admin3\RekapAbsensi3Controller;
use App\Http\Controllers\Admin3\RekapLaporan3Controller;
use App\Http\Controllers\Admin3\Pengumuman3Controller;
use App\Http\Controllers\Admin3\AdminProfile3Controller;

use App\Http\Controllers\Admin4\Admin4Controller;
use App\Http\Controllers\Admin4\Direktorat4Controller;
use App\Http\Controllers\Admin4\Peserta4Controller;
use App\Http\Controllers\Admin4\RekapAbsensi4Controller;
use App\Http\Controllers\Admin4\RekapLaporan4Controller;
use App\Http\Controllers\Admin4\Pengumuman4Controller;
use App\Http\Controllers\Admin4\AdminProfile4Controller;

use App\Http\Controllers\Admin5\Admin5Controller;
use App\Http\Controllers\Admin5\Direktorat5Controller;
use App\Http\Controllers\Admin5\Peserta5Controller;
use App\Http\Controllers\Admin5\RekapAbsensi5Controller;
use App\Http\Controllers\Admin5\RekapLaporan5Controller;
use App\Http\Controllers\Admin5\Pengumuman5Controller;
use App\Http\Controllers\Admin5\AdminProfile5Controller;


use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\User\AttendanceController;
use App\Http\Controllers\Admin\CreateController;
use App\Http\Controllers\Admin\DirektoratController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\Informasi_PesertaController;
use App\Http\Controllers\User\IzinController;
use App\Http\Controllers\User\LaporanAkhirController;
use App\Http\Controllers\User\LaporanBulananController;
use App\Http\Controllers\LoginAdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\Pendaftaran_SummaryController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\User\PengumumanUserController;
use App\Http\Controllers\PersyaratanController;
use App\Http\Controllers\Admin\PesertaController;

use App\Http\Controllers\Pimpinans\AbsensiPimpinanController;
use App\Http\Controllers\Pimpinans\LaporanPimpinanController;
use App\Http\Controllers\Pimpinans\PesertaPimpinanController;
use App\Http\Controllers\Pimpinans\PimpinanController;
use App\Http\Controllers\Pimpinans\PimpinanProfileController;

use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\RekapAbsensiController;
use App\Http\Controllers\Admin\RekapLaporanController;
use App\Http\Controllers\User\SakitController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\User\UserController;
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
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('update.password');
    //pengumuman
    Route::get('/pengumuman', [PengumumanUserController::class, 'index'])->name('pengumuman');
    Route::get('/pengumuman/{id}', [PengumumanUserController::class, 'show'])->name('pengumuman.show');
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
        Route::get('/export-datapeserta', [PesertaController::class, 'exportExcel'])->name('admin.export-datapeserta');

        // route untuk rekap absensi
        Route::get('/rekap-absensi', [RekapAbsensiController::class, 'index'])->name('admin.rekapitulasi-absensi');
        Route::get('/export-absensi', [RekapAbsensiController::class, 'exportExcel'])->name('admin.export-absensi');
    
        // Rute untuk rekapitulasi laporan
        Route::get('/admin/rekapitulasi-laporan', [RekapLaporanController::class, 'index'])->name('admin.rekapitulasi-laporan');
        Route::get('/admin/export-laporan', [RekapLaporanController::class, 'exportExcel'])->name('admin.export-laporan');

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
        
        //Profile
        Route::get('/profile', [AdminProfileController::class, 'index'])->name('admin.profile.index');
        Route::put('/profile/update', [AdminProfileController::class, 'updateProfile'])->name('admin.profile.update');
        Route::put('/profile/update-password', [AdminProfileController::class, 'updatePassword'])->name('admin.profile.update-password');


      
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
        Route::get('/export-datapeserta', [PesertaPimpinanController::class, 'exportExcel'])->name('pimpinan.export-datapeserta');

        // route untuk rekap absensi
        Route::get('/rekap-absensi', [AbsensiPimpinanController::class, 'index'])->name('pimpinan.absensi');
        Route::get('/export-absensi', [AbsensiPimpinanController::class, 'exportExcel'])->name('export-absensi');
    
        // Rute untuk rekapitulasi laporan
        Route::get('/rekapitulasi-laporan', [LaporanPimpinanController::class, 'index'])->name('pimpinan.laporan');
        Route::get('/export-laporan', [LaporanPimpinanController::class, 'exportExcel'])->name('export-laporan');
    
        //Profile
        Route::get('/profile', [PimpinanProfileController::class, 'index'])->name('pimpinan.profile.index');
        Route::put('/profile/update', [PimpinanProfileController::class, 'updateProfile'])->name('pimpinan.profile.update');
        Route::put('/profile/update-password', [PimpinanProfileController::class, 'updatePassword'])->name('pimpinan.profile.update-password');

    });
});

// ====================================
// ROUTE ADMIN1
// ====================================
Route::prefix('admin1')->group(function () {
    Route::middleware(['auth:admin', 'checkRole:admin1'])->group(function () {
        Route::get('/', [Admin1Controller::class, 'index'])->name('admin1.dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin1.logout');

        //pengelolaan per direktorat
        Route::get('/admin1/direktorat1', [Direktorat1Controller::class, 'direktorat1'])->name('admin1.direktorat1');
    
        // Perbaikan pada route detail laporan
        Route::get('/admin1/detail/laporan/{id}', [Direktorat1Controller::class, 'detailLaporan'])->name('admin1.detail-laporan1');
                
        // Perbaikan route untuk submit feedback
        Route::post('/admin1/submit-feedback/{id}', [Direktorat1Controller::class, 'submitFeedback'])->name('admin1.submit-feedback');
        Route::post('/admin1/laporan/{id}/update-status', [Direktorat1Controller::class, 'updateStatus'])->name('admin1.update-status');
        Route::get('/admin1/direktorat1/{id}', [Direktorat1Controller::class, 'showDirektorat'])->name('admin1.direktorat');
        Route::get('/admin1/direktora1/{direktorat}/map', [Direktorat1Controller::class, 'mapDirektorat'])->name('admin1.direktorat.map');
    
        // Peserta routes
        Route::get('/peserta', [Peserta1Controller::class, 'index'])->name('admin1.peserta1');
        Route::put('/peserta/{id}', [Peserta1Controller::class, 'update'])->name('admin1.peserta1.update');
        Route::get('/export-datapeserta', [Peserta1Controller::class, 'exportExcel'])->name('admin1.export-datapeserta1');


        // route untuk rekap absensi
        Route::get('/rekap-absensi', [RekapAbsensi1Controller::class, 'index'])->name('admin1.rekapitulasi-absensi1');
        Route::get('/export-absensi', [RekapAbsensi1Controller::class, 'exportExcel'])->name('admin1.export-absensi1');
    
        // Rute untuk rekapitulasi laporan
        Route::get('/rekapitulasi-laporan', [RekapLaporan1Controller::class, 'index'])->name('admin1.rekapitulasi-laporan1');
        Route::get('/export-laporan', [RekapLaporan1Controller::class, 'exportExcel'])->name('admin1.export-laporan1');

        //Profile
        Route::get('/profile', [AdminProfile1Controller::class, 'index'])->name('admin1.profile.index');
        Route::put('/profile/update', [AdminProfile1Controller::class, 'updateProfile'])->name('admin1.profile.update');
        Route::put('/profile/update-password', [AdminProfile1Controller::class, 'updatePassword'])->name('admin1.profile.update-password');


            // Pengumuman routes
    Route::prefix('admin/pengumuman')->name('admin1.pengumuman1.')->group(function () {
        Route::get('/', [Pengumuman1Controller::class, 'index'])->name('index');
        Route::post('/', [Pengumuman1Controller::class, 'store'])->name('store');
        Route::put('/{pengumuman}', [Pengumuman1Controller::class, 'update'])->name('update');
        Route::delete('/{pengumuman}', [Pengumuman1Controller::class, 'destroy'])->name('destroy');
        Route::patch('/{pengumuman}/status', [Pengumuman1Controller::class, 'updateStatus'])->name('update.status');

    });
    });
});


// ====================================
// ROUTE ADMIN2
// ====================================
Route::prefix('admin2')->group(function () {
    Route::middleware(['auth:admin', 'checkRole:admin2'])->group(function () {
        Route::get('/', [Admin2Controller::class, 'index'])->name('admin2.dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin2.logout');

        //pengelolaan per direktorat
        Route::get('/admin2/direktorat2', [Direktorat2Controller::class, 'direktorat2'])->name('admin2.direktorat2');
    
        // Perbaikan pada route detail laporan
        Route::get('/admin2/detail/laporan/{id}', [Direktorat2Controller::class, 'detailLaporan'])->name('admin2.detail-laporan2');
                
        // Perbaikan route untuk submit feedback
        Route::post('/admin2/submit-feedback/{id}', [Direktorat2Controller::class, 'submitFeedback'])->name('admin2.submit-feedback');
        Route::post('/admin2/laporan/{id}/update-status', [Direktorat2Controller::class, 'updateStatus'])->name('admin2.update-status');
        Route::get('/admin2direktorat2/{id}', [Direktorat2Controller::class, 'showDirektorat'])->name('admin2.direktorat');
        Route::get('/admin2/direktora2/{direktorat}/map', [Direktorat2Controller::class, 'mapDirektorat'])->name('admin2.direktorat.map');

        // Peserta routes
        Route::get('/peserta', [Peserta2Controller::class, 'index'])->name('admin2.peserta2');
        Route::put('/peserta/{id}', [Peserta2Controller::class, 'update'])->name('admin2.peserta2.update');
        Route::get('/export-datapeserta', [Peserta2Controller::class, 'exportExcel'])->name('admin2.export-datapeserta2');

         // route untuk rekap absensi
         Route::get('/rekap-absensi', [RekapAbsensi2Controller::class, 'index'])->name('admin2.rekapitulasi-absensi2');
         Route::get('/export-absensi', [RekapAbsensi2Controller::class, 'exportExcel'])->name('admin2.export-absensi2');
     
         // Rute untuk rekapitulasi laporan
         Route::get('/rekapitulasi-laporan', [RekapLaporan2Controller::class, 'index'])->name('admin2.rekapitulasi-laporan2');
         Route::get('/export-laporan', [RekapLaporan2Controller::class, 'exportExcel'])->name('admin2.export-laporan2');
 
        //Profile
        Route::get('/profile', [AdminProfile2Controller::class, 'index'])->name('admin2.profile.index');
        Route::put('/profile/update', [AdminProfile2Controller::class, 'updateProfile'])->name('admin2.profile.update');
        Route::put('/profile/update-password', [AdminProfile2Controller::class, 'updatePassword'])->name('admin2.profile.update-password');


        // Pengumuman routes
    Route::prefix('admin/pengumuman')->name('admin2.pengumuman2.')->group(function () {
        Route::get('/', [Pengumuman2Controller::class, 'index'])->name('index');
        Route::post('/', [Pengumuman2Controller::class, 'store'])->name('store');
        Route::put('/{pengumuman}', [Pengumuman2Controller::class, 'update'])->name('update');
        Route::delete('/{pengumuman}', [Pengumuman2Controller::class, 'destroy'])->name('destroy');
        Route::patch('/{pengumuman}/status', [Pengumuman2Controller::class, 'updateStatus'])->name('update.status');

    });

    });
});


// ====================================
// ROUTE ADMIN3
// ====================================
Route::prefix('admin3')->group(function () {
    Route::middleware(['auth:admin', 'checkRole:admin3'])->group(function () {
        Route::get('/', [Admin3Controller::class, 'index'])->name('admin3.dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin3.logout');

        //pengelolaan per direktorat
        Route::get('/admin3/direktorat3', [Direktorat3Controller::class, 'direktorat3'])->name('admin3.direktorat3');
    
        // Perbaikan pada route detail laporan
        Route::get('/admin3/detail/laporan/{id}', [Direktorat3Controller::class, 'detailLaporan'])->name('admin3.detail-laporan3');
                
        // Perbaikan route untuk submit feedback
        Route::post('/admin3/submit-feedback/{id}', [Direktorat3Controller::class, 'submitFeedback'])->name('admin3.submit-feedback');
        Route::post('/admin3/laporan/{id}/update-status', [Direktorat3Controller::class, 'updateStatus'])->name('admin3.update-status');
        Route::get('/admin3direktorat3/{id}', [Direktorat3Controller::class, 'showDirektorat'])->name('admin3.direktorat');
        Route::get('/admin3/direktora3/{direktorat}/map', [Direktorat3Controller::class, 'mapDirektorat'])->name('admin3.direktorat.map');

        // Peserta routes
        Route::get('/peserta', [Peserta3Controller::class, 'index'])->name('admin3.peserta3');
        Route::put('/peserta/{id}', [Peserta3Controller::class, 'update'])->name('admin3.peserta3.update');
        Route::get('/export-datapeserta', [Peserta3Controller::class, 'exportExcel'])->name('admin3.export-datapeserta3');

         // route untuk rekap absensi
         Route::get('/rekap-absensi', [RekapAbsensi3Controller::class, 'index'])->name('admin3.rekapitulasi-absensi3');
         Route::get('/export-absensi', [RekapAbsensi3Controller::class, 'exportExcel'])->name('admin3.export-absensi3');
     
         // Rute untuk rekapitulasi laporan
         Route::get('/rekapitulasi-laporan', [RekapLaporan3Controller::class, 'index'])->name('admin3.rekapitulasi-laporan3');
         Route::get('/export-laporan', [RekapLaporan3Controller::class, 'exportExcel'])->name('admin3.export-laporan3');
 
        //Profile
        Route::get('/profile', [AdminProfile3Controller::class, 'index'])->name('admin3.profile.index');
        Route::put('/profile/update', [AdminProfile3Controller::class, 'updateProfile'])->name('admin3.profile.update');
        Route::put('/profile/update-password', [AdminProfile3Controller::class, 'updatePassword'])->name('admin3.profile.update-password');


        // Pengumuman routes
    Route::prefix('admin/pengumuman')->name('admin3.pengumuman3.')->group(function () {
        Route::get('/', [Pengumuman3Controller::class, 'index'])->name('index');
        Route::post('/', [Pengumuman3Controller::class, 'store'])->name('store');
        Route::put('/{pengumuman}', [Pengumuman3Controller::class, 'update'])->name('update');
        Route::delete('/{pengumuman}', [Pengumuman3Controller::class, 'destroy'])->name('destroy');
        Route::patch('/{pengumuman}/status', [Pengumuman3Controller::class, 'updateStatus'])->name('update.status');

    });

    });
});


// ====================================
// ROUTE ADMIN4
// ====================================
Route::prefix('admin4')->group(function () {
    Route::middleware(['auth:admin', 'checkRole:admin4'])->group(function () {
        Route::get('/', [Admin4Controller::class, 'index'])->name('admin4.dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin4.logout');

        //pengelolaan per direktorat
        Route::get('/admin4/direktorat4', [Direktorat4Controller::class, 'direktorat4'])->name('admin4.direktorat4');
    
        // Perbaikan pada route detail laporan
        Route::get('/admin4/detail/laporan/{id}', [Direktorat4Controller::class, 'detailLaporan'])->name('admin4.detail-laporan4');
                
        // Perbaikan route untuk submit feedback
        Route::post('/admin4/submit-feedback/{id}', [Direktorat4Controller::class, 'submitFeedback'])->name('admin4.submit-feedback');
        Route::post('/admin4/laporan/{id}/update-status', [Direktorat4Controller::class, 'updateStatus'])->name('admin4.update-status');
        Route::get('/admin4direktorat4/{id}', [Direktorat4Controller::class, 'showDirektorat'])->name('admin4.direktorat');
        Route::get('/admin4/direktora4/{direktorat}/map', [Direktorat4Controller::class, 'mapDirektorat'])->name('admin4.direktorat.map');

        // Peserta routes
        Route::get('/peserta', [Peserta4Controller::class, 'index'])->name('admin4.peserta4');
        Route::put('/peserta/{id}', [Peserta4Controller::class, 'update'])->name('admin4.peserta4.update');
        Route::get('/export-datapeserta', [Peserta4Controller::class, 'exportExcel'])->name('admin4.export-datapeserta4');

         // route untuk rekap absensi
         Route::get('/rekap-absensi', [RekapAbsensi4Controller::class, 'index'])->name('admin4.rekapitulasi-absensi4');
         Route::get('/export-absensi', [RekapAbsensi4Controller::class, 'exportExcel'])->name('admin4.export-absensi4');
     
         // Rute untuk rekapitulasi laporan
         Route::get('/rekapitulasi-laporan', [RekapLaporan4Controller::class, 'index'])->name('admin4.rekapitulasi-laporan4');
         Route::get('/export-laporan', [RekapLaporan4Controller::class, 'exportExcel'])->name('admin4.export-laporan4');
 
        //Profile
        Route::get('/profile', [AdminProfile4Controller::class, 'index'])->name('admin4.profile.index');
        Route::put('/profile/update', [AdminProfile4Controller::class, 'updateProfile'])->name('admin4.profile.update');
        Route::put('/profile/update-password', [AdminProfile4Controller::class, 'updatePassword'])->name('admin4.profile.update-password');


        // Pengumuman routes
    Route::prefix('admin/pengumuman')->name('admin4.pengumuman4.')->group(function () {
        Route::get('/', [Pengumuman4Controller::class, 'index'])->name('index');
        Route::post('/', [Pengumuman4Controller::class, 'store'])->name('store');
        Route::put('/{pengumuman}', [Pengumuman4Controller::class, 'update'])->name('update');
        Route::delete('/{pengumuman}', [Pengumuman4Controller::class, 'destroy'])->name('destroy');
        Route::patch('/{pengumuman}/status', [Pengumuman4Controller::class, 'updateStatus'])->name('update.status');

    });
    });
});

// ====================================
// ROUTE ADMIN5
// ====================================
Route::prefix('admin5')->group(function () {
    Route::middleware(['auth:admin', 'checkRole:admin5'])->group(function () {
        Route::get('/', [Admin5Controller::class, 'index'])->name('admin5.dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin5.logout');

        //pengelolaan per direktorat
        Route::get('/admin5/direktorat5', [Direktorat5Controller::class, 'direktorat5'])->name('admin5.direktorat5');
    
        // Perbaikan pada route detail laporan
        Route::get('/admin5/detail/laporan/{id}', [Direktorat5Controller::class, 'detailLaporan'])->name('admin5.detail-laporan5');
                
        // Perbaikan route untuk submit feedback
        Route::post('/admin5/submit-feedback/{id}', [Direktorat5Controller::class, 'submitFeedback'])->name('admin5.submit-feedback');
        Route::post('/admin5/laporan/{id}/update-status', [Direktorat5Controller::class, 'updateStatus'])->name('admin5.update-status');
        Route::get('/admin5direktorat5/{id}', [Direktorat5Controller::class, 'showDirektorat'])->name('admin5.direktorat');
        Route::get('/admin5/direktora5/{direktorat}/map', [Direktorat5Controller::class, 'mapDirektorat'])->name('admin5.direktorat.map');

        // Peserta routes
        Route::get('/peserta', [Peserta5Controller::class, 'index'])->name('admin5.peserta5');
        Route::put('/peserta/{id}', [Peserta5Controller::class, 'update'])->name('admin5.peserta5.update');
        Route::get('/export-datapeserta', [Peserta5Controller::class, 'exportExcel'])->name('admin5.export-datapeserta5');

         // route untuk rekap absensi
         Route::get('/rekap-absensi', [RekapAbsensi5Controller::class, 'index'])->name('admin5.rekapitulasi-absensi5');
         Route::get('/export-absensi', [RekapAbsensi5Controller::class, 'exportExcel'])->name('admin5.export-absensi5');
     
         // Rute untuk rekapitulasi laporan
         Route::get('/rekapitulasi-laporan', [RekapLaporan5Controller::class, 'index'])->name('admin5.rekapitulasi-laporan5');
         Route::get('/export-laporan', [RekapLaporan5Controller::class, 'exportExcel'])->name('admin5.export-laporan5');
 
        //Profile
        Route::get('/profile', [AdminProfile5Controller::class, 'index'])->name('admin5.profile.index');
        Route::put('/profile/update', [AdminProfile5Controller::class, 'updateProfile'])->name('admin5.profile.update');
        Route::put('/profile/update-password', [AdminProfile5Controller::class, 'updatePassword'])->name('admin5.profile.update-password');


        // Pengumuman routes
    Route::prefix('admin/pengumuman')->name('admin5.pengumuman5.')->group(function () {
        Route::get('/', [Pengumuman5Controller::class, 'index'])->name('index');
        Route::post('/', [Pengumuman5Controller::class, 'store'])->name('store');
        Route::put('/{pengumuman}', [Pengumuman5Controller::class, 'update'])->name('update');
        Route::delete('/{pengumuman}', [Pengumuman5Controller::class, 'destroy'])->name('destroy');
        Route::patch('/{pengumuman}/status', [Pengumuman5Controller::class, 'updateStatus'])->name('update.status');

    });
    });
});
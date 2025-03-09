<?php

use App\Http\Controllers\InformasiController;
use App\Http\Controllers\PersyaratanController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\Pendaftaran_SummaryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginAdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CreateController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\Informasi_PesertaController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\SakitController;
use App\Http\Controllers\Laporan_BulananController;
use Illuminate\Support\Facades\Route;

// Route publik
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

// routes/web.php
Route::get('/cek-status', [StatusController::class, 'form'])->name('status.form');
Route::post('/cek-status', [StatusController::class, 'check'])->name('status.check');

// Route autentikasi user
Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [UserAuthController::class, 'authenticate'])->name('login.authenticate');

// Routes untuk user yang sudah login
Route::middleware(['auth:web', 'checkRole:user'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
    
    // User Dashboard untuk menu absensi
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance');
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.check-in');
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.check-out');
    Route::get('/attendance/history', [AttendanceController::class, 'history'])->name('attendance.history');
    // Routes untuk fitur izin
    Route::get('/izin', [IzinController::class, 'index'])->name('izin');
    Route::post('/izin/submit', [IzinController::class, 'submit'])->name('izin.submit');
    // Routes untuk fitur sakit
    Route::get('/sakit', [SakitController::class, 'index'])->name('sakit');
    Route::post('/sakit/store', [SakitController::class, 'store'])->name('sakit.store');
    // Laporan Bulanan
    Route::get('/laporan/bulanan', [App\Http\Controllers\LaporanBulananController::class, 'index'])->name('laporan.bulanan');
    Route::post('/laporan/bulanan/upload', [App\Http\Controllers\LaporanBulananController::class, 'upload'])->name('laporan.bulanan.upload');
    Route::get('/laporan/bulanan/download/{id}', [App\Http\Controllers\LaporanBulananController::class, 'download'])->name('laporan.bulanan.download');
    Route::delete('/laporan/bulanan/delete/{id}', [App\Http\Controllers\LaporanBulananController::class, 'delete'])->name('laporan.bulanan.delete');
    
});


// Routes untuk admin
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
        
        // Admin dashboard untuk menu create admin
        Route::get('/create', [CreateController::class, 'create'])->name('admin.create');
        Route::post('/store', [CreateController::class, 'store'])->name('admin.store');
        
        // Peserta routes
        Route::get('/peserta', [PesertaController::class, 'index'])->name('admin.peserta');
        Route::put('/peserta/{id}', [PesertaController::class, 'update'])->name('admin.peserta.update');
    });
});
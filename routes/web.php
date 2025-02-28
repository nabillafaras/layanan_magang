<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Pendaftaran_SummaryController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\PersyaratanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LoginAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CreateController;

// Routes untuk publik/guest
Route::get('/', function () {
    return view('home');
});
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi');
Route::get('/persyaratan', [PersyaratanController::class, 'index'])->name('persyaratan');

// Routes untuk pendaftaran
Route::get('/pendaftaran', [PendaftaranController::class, 'showForm'])->name('pendaftaran');
Route::post('/pendaftaran/store', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
Route::get('/pendaftaran/summary/{id}', [Pendaftaran_SummaryController::class, 'index'])->name('pendaftaran.summary');

// Login routes
Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [UserAuthController::class, 'authenticate'])->name('login.authenticate');

// Routes untuk user yang sudah login
Route::middleware(['auth:web', 'checkRole:user'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
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
    });
});

//User Dashboard untuk menu absensi
Route::middleware('auth:sanctum')->group(function () {         
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance');
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.check-in');         
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.check-out');         
    Route::get('/attendance/history', [AttendanceController::class, 'history'])->name('attendance.history'); 
});

//Admin dashboard untuk menu create admin

Route::get('/admin/create', [CreateController::class, 'create'])->name('admin.create');
Route::post('/admin/store', [CreateController::class, 'store'])->name('admin.store');
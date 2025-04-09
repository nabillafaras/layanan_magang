<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mendapatkan data pendaftaran berdasarkan nomor pendaftaran
     */
    private function getPendaftaran()
    {
        // Gunakan auth()->user() untuk mendapatkan model User
        $user = auth()->user();
        
        return Pendaftaran::where('nomor_pendaftaran', $user->nomor_pendaftaran)->first();
    }

    public function index()
{
    // Gunakan metode getPendaftaran untuk mendapatkan user
    $user = $this->getPendaftaran();

    if (!$user) {
        return redirect()->back()->with('error', 'Pengguna tidak ditemukan');
    }

    // Ambil data periode magang
    $periodeData = Pendaftaran::where('id', $user->id) // pastikan 'id' milik user
        ->select('tanggal_mulai', 'tanggal_selesai')
        ->first();

    // Ubah format tanggal untuk tampilan
    $tanggalMulai = null;
    $tanggalSelesai = null;
    $sisaHari = null;

    if ($periodeData && $periodeData->tanggal_mulai && $periodeData->tanggal_selesai) {
        // Mengonversi tanggal menjadi format 'd M Y'
        $tanggalMulai = Carbon::parse($periodeData->tanggal_mulai)->format('d M Y');
        $tanggalSelesai = Carbon::parse($periodeData->tanggal_selesai)->format('d M Y');

        // Menghitung sisa hari antara tanggal mulai dan tanggal selesai
        $today = Carbon::now(); // Tanggal saat ini
        $startDate = Carbon::parse($periodeData->tanggal_mulai); // Tanggal mulai
        $endDate = Carbon::parse($periodeData->tanggal_selesai); // Tanggal selesai magang
        $sisaHari = ($endDate->gt($startDate)) ? $startDate->diffInDays($endDate) : 0; // Menghitung selisih hari
    }

    // Kembalikan view profil dengan data pengguna dan periode magang
    return view('user.profile', compact('user', 'tanggalMulai', 'tanggalSelesai', 'sisaHari'));
}


    /**
     * Metode untuk memperbarui profil pengguna
     */
    public function updateProfile(Request $request)
    {
        // Validasi input dengan pesan error yang lebih spesifik
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Maks 2MB
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'no_hp.required' => 'Nomor handphone wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'foto_profile.image' => 'File harus berupa gambar.',
            'foto_profile.mimes' => 'Foto profil harus berformat jpeg, png, atau jpg.',
            'foto_profile.max' => 'Ukuran foto profil maksimal 2MB.'
        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Gunakan metode getPendaftaran untuk mendapatkan user
        $user = $this->getPendaftaran();

        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan');
        }

        // Update data profil
        $user->nama_lengkap = $request->input('nama_lengkap');
        $user->no_hp = $request->input('no_hp');
        $user->email = $request->input('email');

        // Proses upload foto profil
        if ($request->hasFile('foto_profile')) {
            // Hapus foto profil lama jika ada
            if ($user->foto_profile) {
                Storage::delete('public/profile_photos/' . $user->foto_profile);
            }

            // Simpan foto profil baru
            $fotoFile = $request->file('foto_profile');
            $fotoNama = time() . '_' . $fotoFile->getClientOriginalName();
            $fotoFile->storeAs('public/profile_photos', $fotoNama);
            $user->foto_profile = $fotoNama;
        }

        // Simpan perubahan
        $user->save();

        // Kembalikan dengan pesan sukses
        return redirect()->route('profile.index')
            ->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Metode untuk mengubah password
     */
    public function updatePassword(Request $request)
    {
        // Validasi input dengan pesan error yang lebih spesifik
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed'
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Gunakan metode getPendaftaran untuk mendapatkan user
        $user = $this->getPendaftaran();

        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan');
        }

        // Periksa password saat ini
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah']);
        }

        // Update password
        $user->password = Hash::make($request->input('password'));
        $user->save();

        // Kembalikan dengan pesan sukses
        return redirect()->route('profile.index')
            ->with('success', 'Password berhasil diubah');
    }
}
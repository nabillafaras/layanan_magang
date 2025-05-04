<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin; // Model Admin perlu diimport dan digunakan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; // Untuk validasi unique kecuali record saat ini

class AdminProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Mendapatkan data admin yang sedang login
     *
     * @return Admin|null
     */
    private function getAdmin()
    {
        return auth('admin')->user();
    }

    /**
     * Menampilkan halaman profil
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $admin = $this->getAdmin();

        if (!$admin) {
            return redirect()->back()->with('error', 'Admin tidak ditemukan');
        }

        return view('admin.profile', compact('admin'));
    }

    /**
     * Metode untuk mengarahkan ke updateProfile
     * (Ini metode yang akan menangani route resource)
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        return $this->updateProfile($request);
    }

    /**
     * Metode untuk memperbarui profil admin
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        // Dapatkan admin yang sedang login
        $admin = $this->getAdmin();

        if (!$admin) {
            return redirect()->back()->with('error', 'Admin tidak ditemukan');
        }

        // Validasi input dengan aturan unique yang mengecualikan record saat ini
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('admins')->ignore($admin->id)
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('admins')->ignore($admin->id)
            ],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
        ]);

        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Update data profil
            $admin->nama_lengkap = $request->input('nama_lengkap');
            $admin->username = $request->input('username');
            $admin->email = $request->input('email');
            
            // Simpan perubahan
            $admin->save();

            // Kembalikan dengan pesan sukses
            return redirect()->route('admin.profile.index')
                ->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            // Tangani error saat menyimpan
            return redirect()->back()
                ->with('error', 'Gagal memperbarui profil: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Metode untuk mengubah password
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
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

        // Dapatkan admin yang sedang login
        $admin = $this->getAdmin();

        if (!$admin) {
            return redirect()->back()->with('error', 'Admin tidak ditemukan');
        }

        // Periksa password saat ini
        if (!Hash::check($request->input('current_password'), $admin->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah']);
        }

        try {
            // Update password
            $admin->password = Hash::make($request->input('password'));
            $admin->save();

            // Kembalikan dengan pesan sukses
            return redirect()->route('admin.profile.index')
                ->with('success', 'Password berhasil diubah');
        } catch (\Exception $e) {
            // Tangani error saat menyimpan
            return redirect()->back()
                ->with('error', 'Gagal mengubah password: ' . $e->getMessage());
        }
    }
}
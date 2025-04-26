<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CreateController extends Controller

{
    public function __construct()
    {
        // Middleware untuk memastikan hanya admin yang bisa mengakses
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
        if (auth('admin')->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    });
    }
    /**
     * Menampilkan halaman tambah admin baru
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Menyimpan data admin baru ke database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => 'required|string|in:pimpinan,admin,admin1,admin2,admin3,admin4,admin5',
        ]);

        // Simpan data admin baru
        Admin::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Menyimpan role yang dipilih
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.create')
            ->with('success', 'Admin baru berhasil ditambahkan!');
    }
}
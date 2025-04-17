<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class PendaftaranController extends Controller
{
    public function showForm()
    {
        return view('pendaftaran');
    }

    private function generateRandomPassword()
    {
        // Generate a stronger random password with 10 characters including letters, numbers and symbols
        return Str::random(10);
    }

    private function generateRegistrationNumber()
    {
        $prefix = date('Ym');
        $unique = false;
        $number = '';
        
        while (!$unique) {
            // Generate a random 4-digit number
            $randomNum = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $number = $prefix . $randomNum;
            
            // Check if this number already exists
            $exists = Pendaftaran::where('nomor_pendaftaran', $number)->exists();
            if (!$exists) {
                $unique = true;
            }
        }
        
        return $number;
    }

    public function store(Request $request)
    {
        Log::info('Data diterima pada step ' . ($request->step ?? 'tidak diketahui') . ':', $request->all());

        if (!in_array($request->step, [1, 2, 3])) {
            return response()->json(['success' => false, 'message' => 'Step tidak valid'], 400);
        }

        $rules = [
            1 => [
                'nama_lengkap' => 'required|max:255',
                'ttl' => 'required|max:255',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'no_hp' => 'required|regex:/^\d{10,15}$/',
                'email' => 'required|email|unique:pendaftaran,email,' . ($request->id ?? 'NULL'),
            ],
            2 => [
                'asal_universitas' => 'required|max:255',
                'jurusan' => 'required|max:255',
                'prodi' => 'required|max:255',
                'semester' => 'required|integer|min:1',
                'ipk' => 'required|numeric|min:0|max:4',
                'transkrip_nilai' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
                'surat_pengantar' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            ],
            3 => [
                'tanggal_mulai' => 'required|date', // Validasi untuk tanggal mulai
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
                'direktorat' => 'required|max:255',
                'unit_kerja' => 'required|max:255',
                'cv' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
                'foto_profile' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            ]
        ];

        $request->validate($rules[$request->step]);

        $pendaftaran = Pendaftaran::updateOrCreate(
            ['email' => $request->email],
            $request->except(['step', 'transkrip_nilai', 'surat_pengantar', 'cv', 'foto_profile'])
        );

        $fileFields = ['transkrip_nilai' => 'uploads/transkrip', 'surat_pengantar' => 'uploads/surat', 'cv' => 'uploads/cv', 'foto_profile' => 'uploads/foto'];
        foreach ($fileFields as $field => $path) {
            if ($request->hasFile($field)) {
                $filePath = $request->file($field)->storeAs($path, time() . '_' . $request->file($field)->getClientOriginalName());
                $pendaftaran->$field = $filePath;
            }
        }

        if ($request->hasFile('foto_profile')) {
            Log::info('Foto profile received', ['filename' => $request->file('foto_profile')->getClientOriginalName()]);
            $filePath = $request->file('foto_profile')->storeAs('uploads/foto', time() . '_' . $request->file('foto_profile')->getClientOriginalName());
            $pendaftaran->foto_profile = $filePath;
            Log::info('Foto profile path saved', ['path' => $filePath]);
        }

        try {
            // Generate registration number and password only on step 3
            if ($request->step == 3 && !$pendaftaran->nomor_pendaftaran) {
                $pendaftaran->nomor_pendaftaran = $this->generateRegistrationNumber();
                
                // Generate and store random password
                $plainPassword = $this->generateRandomPassword();
                
                // Store both hashed (for authentication) and encrypted (for display) versions
                $pendaftaran->password = Hash::make($plainPassword);
                $pendaftaran->plain_password = Crypt::encryptString($plainPassword);
                
                // Set default status
                if (!$pendaftaran->status) {
                    $pendaftaran->status = 'Diproses';
                }
                
                $pendaftaran->save();

                return response()->json([
                    'success' => true,
                    'redirect' => route('pendaftaran.summary', ['id' => $pendaftaran->id]),
                    'credentials' => [
                        'nomor_pendaftaran' => $pendaftaran->nomor_pendaftaran,
                        'password' => $plainPassword
                    ]
                ]);
            }

            $pendaftaran->save();

            return response()->json([
                'success' => true,
                'redirect' => route('pendaftaran.summary', ['id' => $pendaftaran->id])
            ]);

        } catch (\Exception $e) {
            Log::error('Error menyimpan pendaftaran: ', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data.'], 400);
        }
    }
    
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\StatusDiprosesNotification;

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

    private function generateRegistrationNumber($direktorat, $unitKerja)
    {
        // Format: YYYY + Kode Direktorat + Kode Unit Kerja + Random 4 digit
        $year = date('Y');
        
        // Mapping kode direktorat
        $direktoratCodes = [
            "Sekretariat Jenderal" => "01",
            "Direktorat Jenderal Perlindungan dan Jaminan Sosial" => "02",
            "Direktorat Jenderal Rehabilitasi Sosial" => "03",
            "Direktorat Jenderal Pemberdayaan Sosial" => "04",
            "Inspektorat Jenderal" => "05"
        ];
        
        // Mapping kode unit kerja berdasarkan direktorat
        $unitKerjaCodes = [
            "Sekretariat Jenderal" => [
                "Biro Perencanaan" => "01",
                "Biro Keuangan" => "02",
                "Biro Organisasi dan Sumber Daya Manusia" => "03",
                "Biro Hukum" => "04",
                "Biro Umum" => "05",
                "Biro Hubungan Masyarakat" => "06",
                "Pusat Pendidikan, Pelatihan, dan Pengembangan Profesi Kesejahteraan Sosial" => "07",
                "Pusat Data dan Informasi Kesejahteraan Sosial" => "08"
            ],
            "Direktorat Jenderal Perlindungan dan Jaminan Sosial" => [
                "Sekretariat Direktorat Jenderal" => "01",
                "Direktorat Jaminan Sosial" => "02",
                "Direktorat Perlindungan Sosial Non Kebencanaan" => "03",
                "Direktorat Perlindungan Sosial Korban Bencana" => "04"
            ],
            "Direktorat Jenderal Rehabilitasi Sosial" => [
                "Sekretariat Direktorat Jenderal" => "01",
                "Direktorat Rehabilitasi Sosial Anak" => "02",
                "Direktorat Rehabilitasi Sosial Penyandang Disabilitas" => "03",
                "Direktorat Rehabilitasi Sosial Tuna Sosial dan Korban Perdagangan Orang" => "04",
                "Direktorat Rehabilitasi Sosial Korban Penyalahgunaan Napza, Psikotropika, Zat Adiktif Lainnya, dan ODHA (HIV)" => "05",
                "Direktorat Rehabilitasi Sosial Lanjut Usia" => "06"
            ],
            "Direktorat Jenderal Pemberdayaan Sosial" => [
                "Sekretariat Direktorat Jenderal" => "01",
                "Direktorat Pemberdayaan Sosial Komunitas Adat Terpencil" => "02",
                "Direktorat Pemberdayaan Sosial Keluarga Miskin dan Rentan" => "03",
                "Direktorat Pemberdayaan Sosial Masyarakat" => "04",
                "Direktorat Pemberdayaan Potensi dan Sumber Daya Sosial" => "05"
            ],
            "Inspektorat Jenderal" => [
                "Sekretariat Inspektorat Jenderal" => "01",
                "Inspektorat Bidang Investigasi" => "02",
                "Inspektorat Bidang Perlindungan dan Jaminan Sosial" => "03",
                "Inspektorat Bidang Rehabilitasi Sosial" => "04",
                "Inspektorat Bidang Pemberdayaan Sosial" => "05",
                "Inspektorat Bidang Penunjang" => "06"
            ]
        ];
        
        // Dapatkan kode direktorat
        $direktoratCode = $direktoratCodes[$direktorat] ?? "99"; // Default 99 jika tidak ditemukan
        
        // Dapatkan kode unit kerja
        $unitKerjaCode = $unitKerjaCodes[$direktorat][$unitKerja] ?? "99"; // Default 99 jika tidak ditemukan
        
        // Generate nomor unik
        $unique = false;
        $number = '';
        $attempts = 0;
        $maxAttempts = 100; // Batasi percobaan untuk mencegah infinite loop
        
        while (!$unique && $attempts < $maxAttempts) {
            // Generate random 4-digit number
            $randomNum = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            
            // Format: YYYY + DirCode + UnitCode + Random
            $number = $year . $direktoratCode . $unitKerjaCode . $randomNum;
            
            // Check if this number already exists
            $exists = Pendaftaran::where('nomor_pendaftaran', $number)->exists();
            if (!$exists) {
                $unique = true;
            }
            
            $attempts++;
        }
        
        // Jika gagal generate setelah maxAttempts, gunakan timestamp sebagai fallback
        if (!$unique) {
            $timestamp = substr(time(), -4); // Ambil 4 digit terakhir dari timestamp
            $number = $year . $direktoratCode . $unitKerjaCode . $timestamp;
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
                'tanggal_lahir' => 'required|date',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'no_hp' => 'required|regex:/^\d{10,15}$/',
                'email' => 'required|email|unique:pendaftaran,email,' . ($request->id ?? 'NULL'),
            ],
            2 => [
                // Validasi kategori pendidikan
                'kategori_pendidikan' => 'required|in:mahasiswa,siswa',
                
                // Validasi umum yang selalu dibutuhkan
                'asal_universitas' => 'required|max:255',
                'jurusan' => 'required|max:255',
                'prodi' => 'required|max:255',
                'semester' => 'required|integer|min:1',
                'ipk' => 'required|numeric|min:0',
                'transkrip_nilai' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
                'surat_pengantar' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            ],
            3 => [
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
                'direktorat' => 'required|max:255',
                'unit_kerja' => 'required|max:255',
                'cv' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
                'foto_profile' => 'nullable|file|mimes:jpg,png|max:2048',
            ]
        ];

        // Modifikasi validasi untuk step 2 berdasarkan kategori pendidikan
        if ($request->step == 2) {
            $kategoriPendidikan = $request->kategori_pendidikan;
            
            // Validasi tambahan berdasarkan kategori
            if ($kategoriPendidikan === 'mahasiswa') {
                // Untuk mahasiswa, IPK maksimal 4.00
                $rules[2]['ipk'] = 'required|numeric|min:0|max:4';
            } elseif ($kategoriPendidikan === 'siswa') {
                // Untuk siswa, nilai rata-rata maksimal 100
                $rules[2]['ipk'] = 'required|numeric|min:0|max:100';
                // Semester untuk siswa adalah kelas (10, 11, 12)
                $rules[2]['semester'] = 'required|integer|min:10|max:12';
            }
        }

        $request->validate($rules[$request->step]);

        // Prepare data untuk disimpan
        $dataToSave = $request->except(['step', 'transkrip_nilai', 'surat_pengantar', 'cv', 'foto_profile']);
        
        // Log data yang akan disimpan untuk debugging
        Log::info('Data yang akan disimpan:', $dataToSave);

        $pendaftaran = Pendaftaran::updateOrCreate(
            ['email' => $request->email],
            $dataToSave
        );

        // Handle file uploads
        $fileFields = [
            'transkrip_nilai' => 'uploads/transkrip', 
            'surat_pengantar' => 'uploads/surat', 
            'cv' => 'uploads/cv', 
            'foto_profile' => 'uploads/foto'
        ];
        
        foreach ($fileFields as $field => $path) {
            if ($request->hasFile($field)) {
                // Hapus file lama jika ada
                if ($pendaftaran->$field && Storage::exists($pendaftaran->$field)) {
                    Storage::delete($pendaftaran->$field);
                }
                
                $filePath = $request->file($field)->storeAs(
                    $path, 
                    time() . '_' . $request->file($field)->getClientOriginalName()
                );
                $pendaftaran->$field = $filePath;
                
                Log::info("File {$field} berhasil diupload", ['path' => $filePath]);
            }
        }

        if ($request->hasFile('foto_profile')) {
            Log::info('Foto profile received', [
                'filename' => $request->file('foto_profile')->getClientOriginalName()
            ]);
            
            // Hapus foto lama jika ada
            if ($pendaftaran->foto_profile && Storage::exists($pendaftaran->foto_profile)) {
                Storage::delete($pendaftaran->foto_profile);
            }
            
            $filePath = $request->file('foto_profile')->storeAs(
                'uploads/foto', 
                time() . '_' . $request->file('foto_profile')->getClientOriginalName()
            );
            $pendaftaran->foto_profile = $filePath;
            
            Log::info('Foto profile path saved', ['path' => $filePath]);
        }

        try {
            // Generate registration number and password only on step 3
            if ($request->step == 3 && !$pendaftaran->nomor_pendaftaran) {
                $pendaftaran->nomor_pendaftaran = $this->generateRegistrationNumber(
                    $request->direktorat, 
                    $request->unit_kerja
                );
                
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

                try {
                    Mail::to($pendaftaran->email)->send(new StatusDiprosesNotification($pendaftaran));
                    Log::info('Email notifikasi status diproses berhasil dikirim', [
                        'email' => $pendaftaran->email,
                        'nomor_pendaftaran' => $pendaftaran->nomor_pendaftaran
                    ]);
                } catch (\Exception $e) {
                    Log::error('Gagal mengirim email notifikasi status diproses: ' . $e->getMessage(), [
                        'email' => $pendaftaran->email,
                        'nomor_pendaftaran' => $pendaftaran->nomor_pendaftaran
                    ]);
                }

                Log::info('Pendaftaran berhasil diselesaikan', [
                    'nomor_pendaftaran' => $pendaftaran->nomor_pendaftaran,
                    'kategori_pendidikan' => $pendaftaran->kategori_pendidikan
                ]);

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

            Log::info("Step {$request->step} berhasil disimpan", [
                'pendaftaran_id' => $pendaftaran->id,
                'kategori_pendidikan' => $pendaftaran->kategori_pendidikan ?? 'belum diset'
            ]);

            return response()->json([
                'success' => true,
                'message' => "Step {$request->step} berhasil disimpan"
            ]);

        } catch (\Exception $e) {
            Log::error('Error menyimpan pendaftaran: ', [
                'error' => $e->getMessage(),
                'step' => $request->step,
                'stack_trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false, 
                'message' => 'Terjadi kesalahan saat menyimpan data.'
            ], 400);
        }
    }
}
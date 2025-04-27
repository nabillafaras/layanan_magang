<?php

namespace App\Http\Controllers\Admin5;
use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Pengumuman5Controller extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan hanya admin yang bisa mengakses
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            if (auth('admin')->user()->role !== 'admin5') {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }
    
    /**
     * Menampilkan daftar pengumuman khusus untuk Inspektorat Jenderal
     */
    public function index()
    {
        $pengumuman = Pengumuman::with('admin')
                    ->where('kategori', 'Inspektorat Jenderal')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        
        return view('admin5.pengumuman5', compact('pengumuman'));
    }

    /**
     * Menyimpan pengumuman baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'isi' => 'required|string',
            'content' => 'nullable|file|mimes:pdf,jpg,jpeg,png,mp4,avi,mov|max:10240', // Menerima video dan gambar, max 10MB
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:10240', // Max 10MB
            'status' => 'required|in:draft,published'
            // Menghapus validasi kategori karena nilainya akan diset secara langsung
        ]);

        // Handle content upload jika ada (foto atau video)
        $contentPath = null;
        if ($request->hasFile('content')) {
            $file = $request->file('content');
            $fileName = time() . '_content_' . $file->getClientOriginalName();
            $contentPath = $file->storeAs('public/pengumuman/content', $fileName);
        }
        // Handle file attachment upload jika ada
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $attachmentPath = $file->storeAs('public/pengumuman/attachment', $fileName);
        }

        // Dapatkan admin yang sedang login
        $admin = Auth::guard('admin')->user();

        // Buat pengumuman baru
        $pengumuman = new Pengumuman();
        $pengumuman->title = $request->title;
        $pengumuman->isi = $request->isi;
        $pengumuman->content = $contentPath;
        $pengumuman->status = $request->status;
        $pengumuman->kategori = "Inspektorat Jenderal"; // Set nilai kategori secara langsung
        $pengumuman->attachment = $attachmentPath;
        $pengumuman->admin_id = $admin->id;
        
        if ($request->status == 'published') {
            $pengumuman->published_at = Carbon::now();
        }
        
        $pengumuman->save();

        return redirect()->route('admin5.pengumuman5.index')
            ->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    /**
     * Update data pengumuman
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'isi' => 'required|string',
            'content' => 'nullable|file|mimes:pdf,jpg,jpeg,png,mp4,avi,mov|max:10240', // Menerima video dan gambar, max 10MB
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:10240', // Max 10MB
            'status' => 'required|in:draft,published'
            // Menghapus validasi kategori karena nilainya akan diset secara langsung
        ]);

        $pengumuman = Pengumuman::findOrFail($id);
        
        // Pastikan hanya pengumuman dengan kategori Inspektorat Jenderal yang diupdate
        if ($pengumuman->kategori !== 'Inspektorat Jenderal') {
            return redirect()->route('admin5.pengumuman5.index')
                ->with('error', 'Anda hanya dapat mengedit pengumuman untuk Inspektorat Jenderal!');
        }

        // Handle content upload jika ada (foto atau video)
        if ($request->hasFile('content')) {
            // Hapus file content lama jika ada
            if ($pengumuman->content) {
                Storage::delete($pengumuman->content);
            }
            
            $file = $request->file('content');
            $fileName = time() . '_content_' . $file->getClientOriginalName();
            $contentPath = $file->storeAs('public/pengumuman/content', $fileName);
            $pengumuman->content = $contentPath;
        }

        // Handle file attachment upload jika ada
        if ($request->hasFile('attachment')) {
            // Hapus file attachment lama jika ada
            if ($pengumuman->attachment) {
                Storage::delete($pengumuman->attachment);
            }
            
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $attachmentPath = $file->storeAs('public/pengumuman/attachment', $fileName);
            $pengumuman->attachment = $attachmentPath;
        }

        // Update data pengumuman
        $pengumuman->title = $request->title;
        $pengumuman->isi = $request->isi;
        $pengumuman->kategori = "Inspektorat Jenderal"; // Memastikan kategori tetap Inspektorat Jenderal
        
        // Jika status berubah dari draft ke published
        if ($pengumuman->status == 'draft' && $request->status == 'published') {
            $pengumuman->published_at = Carbon::now();
        }
        
        $pengumuman->status = $request->status;
        $pengumuman->save();

        return redirect()->route('admin5.pengumuman5.index')
            ->with('success', 'Pengumuman berhasil diperbarui!');
    }

    /**
     * Hapus pengumuman
     */
    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        
        // Pastikan hanya pengumuman dengan kategori Inspektorat Jenderal yang dapat dihapus
        if ($pengumuman->kategori !== 'Inspektorat Jenderal') {
            return redirect()->route('admin5.pengumuman5.index')
                ->with('error', 'Anda hanya dapat menghapus pengumuman untuk Inspektorat Jenderal!');
        }
        
        // Hapus file attachment jika ada
        if ($pengumuman->attachment) {
            Storage::delete($pengumuman->attachment);
        }
        // Hapus file content jika ada
        if ($pengumuman->content) {
            Storage::delete($pengumuman->content);
        }
        $pengumuman->delete();

        return redirect()->route('admin5.pengumuman5.index')
            ->with('success', 'Pengumuman berhasil dihapus!');
    }

    /**
     * Mengubah status pengumuman (publish/draft)
     */
    public function updateStatus($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        
        // Pastikan hanya pengumuman dengan kategori Inspektorat Jenderal yang dapat diubah statusnya
        if ($pengumuman->kategori !== 'Inspektorat Jenderal') {
            return redirect()->route('admin5.pengumuman5.index')
                ->with('error', 'Anda hanya dapat mengubah status pengumuman untuk Inspektorat Jenderal!');
        }
        
        if ($pengumuman->status == 'draft') {
            $pengumuman->status = 'published';
            $pengumuman->published_at = Carbon::now();
        } else {
            $pengumuman->status = 'draft';
        }
        
        $pengumuman->save();
        
        return redirect()->route('admin5.pengumuman5.index')
            ->with('success', 'Status pengumuman berhasil diubah!');
    }
}
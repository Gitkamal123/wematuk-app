<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class TugasController extends Controller
{
    /** Tampilkan SEMUA tugas dengan filter dan auto-delete */
    public function index(Request $request)
    {
        // Auto-delete tugas yang sudah lewat deadline
        $this->autoDeleteExpiredTasks();

        $query = Tugas::query();
        
        // Search
        if ($request->has('cari') && $request->cari != '') {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->cari . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->cari . '%');
            });
        }
        
        // Status filter
        if ($request->has('status') && $request->status != '') {
            $now = now();
            switch ($request->status) {
                case 'terlambat':
                    $query->where('deadline', '<', $now);
                    break;
                case 'segera':
                    $query->whereBetween('deadline', [$now, $now->copy()->addDays(3)]);
                    break;
                case 'aktif':
                    $query->where('deadline', '>', $now->copy()->addDays(3));
                    break;
            }
        }
        
        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'deadline_asc':
                    $query->orderBy('deadline', 'asc');
                    break;
                case 'deadline_desc':
                    $query->orderBy('deadline', 'desc');
                    break;
                case 'created_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'created_asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                default:
                    $query->orderBy('deadline', 'asc');
            }
        } else {
            $query->orderBy('deadline', 'asc');
        }
        
        $tugas = $query->paginate(9);
        
        return view('tugas.index', compact('tugas'));
    }


private function autoDeleteExpiredTasks()
{
    try {
        $expiredTasks = Tugas::where('deadline', '<', now())
                            ->whereNull('deleted_at')
                            ->get();
        
        $deletedCount = 0;
        foreach ($expiredTasks as $task) {
            $task->delete();
            $deletedCount++;
        }
        
        if ($deletedCount > 0) {
            Log::info("$deletedCount tugas dihapus otomatis - deadline lewat");

        }
    } catch (\Exception $e) {
        Log::error("Auto-delete error: " . $e->getMessage());
    }
}

    /** Tampilkan form tambah */
    public function create()
    {
        return view('tugas.create');
    }

    /** Simpan tugas baru */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deadline' => 'required|date',
            'file_tugas' => 'nullable|file|mimes:pdf,doc,docx,zip,png,jpg,jpeg|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('file_tugas')) {
            $file = $request->file('file_tugas');
            
            try {
                $base64 = base64_encode(file_get_contents($file));
                $path = 'data:' . $file->getMimeType() . ';base64,' . $base64;
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal mengupload file: ' . $e->getMessage());
            }
        }

        Tugas::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
            'file_path' => $path,
        ]);

        return redirect()->route('home')->with('success', 'Tugas berhasil ditambahkan!');
    }

    /** Tampilkan detail */
    public function show(Tugas $tuga) // Sesuai route parameter {tugas}
    {
        return view('tugas.show', ['tugas' => $tuga]);
    }

    /** Tampilkan form edit */
    public function edit(Tugas $tuga) // Sesuai route parameter {tugas}
    {
        return view('tugas.edit', ['tugas' => $tuga]);
    }

    /** Simpan perubahan */
    public function update(Request $request, Tugas $tuga) // Sesuai route parameter {tugas}
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deadline' => 'required|date',
            'file_tugas' => 'nullable|file|mimes:pdf,doc,docx,zip,png,jpg,jpeg|max:2048',
        ]);
        
        $tuga->judul = $request->judul;
        $tuga->deskripsi = $request->deskripsi;
        $tuga->deadline = $request->deadline;
        
        if ($request->hasFile('file_tugas')) {        
            $file = $request->file('file_tugas');
            try {
                $base64 = base64_encode(file_get_contents($file));
                $tuga->file_path = 'data:' . $file->getMimeType() . ';base64,' . $base64;
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal mengupload file: ' . $e->getMessage());
            }
        }
        
        $tuga->save();
        return redirect()->route('home')->with('success', 'Tugas berhasil diperbarui!');
    }

    /** Hapus tugas (Soft Delete) */
    public function destroy(Tugas $tuga) // Sesuai route parameter {tugas}
    {
        $tuga->delete();
        return redirect()->route('home')->with('success', 'Tugas berhasil dipindahkan ke sampah!');
    }

    /** Cetak laporan */
    public function cetakLaporan()
    {
        $tugas = Tugas::orderBy('deadline', 'asc')->get();
        return view('laporan', ['tugas' => $tugas]); // Sesuai route name 'laporan.cetak'
    }

    /** Tampilkan sampah */
    public function trash()
    {
        $tugas = Tugas::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(10);
        return view('tugas.trash', compact('tugas'));
    }

    /** Pulihkan dari sampah */
    public function restore($id) // Parameter ID karena route {id}
    {
        $tugas = Tugas::withTrashed()->find($id);
        
        if (!$tugas) {
            return redirect()->route('tugas.trash')->with('error', 'Tugas tidak ditemukan.');
        }
        
        $tugas->restore();
        return redirect()->route('tugas.trash')->with('success', 'Tugas berhasil dipulihkan!');
    }

    /** Hapus permanen */
    public function forceDelete($id) // Parameter ID karena route {id}
    {
        $tugas = Tugas::withTrashed()->find($id);
        
        if (!$tugas) {
            return redirect()->route('tugas.trash')->with('error', 'Tugas tidak ditemukan.');
        }
        
        $tugas->forceDelete();
        return redirect()->route('tugas.trash')->with('success', 'Tugas berhasil dihapus permanen!');
    }

    /** Bersihkan sampah */
    public function clearTrash()
    {
        $trashedCount = Tugas::onlyTrashed()->count();
        
        if ($trashedCount === 0) {
            return redirect()->route('tugas.trash')->with('info', 'Tidak ada tugas di sampah.');
        }
        
        Tugas::onlyTrashed()->forceDelete();
        
        return redirect()->route('tugas.trash')->with('success', $trashedCount . ' tugas berhasil dihapus permanen!');
    }

    /** Download file */
    public function downloadFile(Tugas $tuga) // Sesuai route parameter {tugas}
    {
        if (!$tuga->file_path) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        try {
            @list($type, $file_data) = explode(';', $tuga->file_path);
            @list(, $file_data) = explode(',', $file_data);
            $decoded_file = base64_decode($file_data);
            $mime_type = str_replace('data:', '', $type);
            
            // Tentukan ekstensi file
            $extension = $this->getFileExtension($mime_type);

            $filename = 'Tugas-' . Str::slug($tuga->judul) . '.' . $extension;

            return response($decoded_file)
                ->header('Content-Type', $mime_type)
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mendownload file: ' . $e->getMessage());
        }
    }

    /** Preview file */
    public function previewFile(Tugas $tuga) // Sesuai route parameter {tugas}
    {
        if (!$tuga->file_path) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        try {
            @list($type, $file_data) = explode(';', $tuga->file_path);
            @list(, $file_data) = explode(',', $file_data);
            $decoded_file = base64_decode($file_data);
            $mime_type = str_replace('data:', '', $type);

            $filename = 'Preview-' . Str::slug($tuga->judul);

            return response($decoded_file)
                ->header('Content-Type', $mime_type)
                ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat preview file: ' . $e->getMessage());
        }
    }

    /** Helper untuk menentukan ekstensi file */
    private function getFileExtension($mime_type)
    {
        $mime_to_extension = [
            'application/pdf' => 'pdf',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/vnd.ms-excel' => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'application/vnd.ms-powerpoint' => 'ppt',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'image/jpeg' => 'jpg',
            'image/jpg' => 'jpg',
            'image/png' => 'png',
            'application/zip' => 'zip',
            'application/x-zip-compressed' => 'zip',
        ];

        return $mime_to_extension[$mime_type] ?? 'bin';
    }
}
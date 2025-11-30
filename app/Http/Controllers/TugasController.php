<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TugasController extends Controller
{
    /** Tampilkan SEMUA tugas dengan Filter, Sort, dan Cari */
    public function index(Request $request)
    {
        $query = Tugas::query();

        // 1. Search
        if ($request->has('cari') && $request->cari != '') {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->cari . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->cari . '%');
            });
        }

        // 2. Filter Status
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

        // 3. Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'deadline_asc': $query->orderBy('deadline', 'asc'); break;
                case 'deadline_desc': $query->orderBy('deadline', 'desc'); break;
                case 'created_desc': $query->orderBy('created_at', 'desc'); break;
                case 'created_asc': $query->orderBy('created_at', 'asc'); break;
                default: $query->orderBy('deadline', 'asc');
            }
        } else {
            $query->orderBy('deadline', 'asc');
        }
        // Jika data < 9, tombol pagination TIDAK akan muncul (itu normal)
        $tugas = $query->paginate(6); 

        return view('tugas.index', compact('tugas'));
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
            'file_tugas' => 'nullable|file|mimes:pdf,doc,docx,zip,png,jpg|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('file_tugas')) {
            $file = $request->file('file_tugas');
            
            // 1. Ambil isi file & ubah jadi base64
            $base64 = base64_encode(file_get_contents($file));
            
            // 2. Format jadi Data URI (supaya bisa dibaca browser)
            $path = 'data:' . $file->getMimeType() . ';base64,' . $base64;
        }
        // -----------------------------------------

        Tugas::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
            'file_path' => $path, // Simpan string panjang ini ke database
        ]);

        return redirect()->route('home')->with('success', 'Tugas berhasil ditambahkan!');
    }

    /** Tampilkan detail */
    public function show(Tugas $tugas)
    {
        return view('tugas.show', ['tugas' => $tugas]);
    }

    /** Tampilkan form edit */
    public function edit(Tugas $tugas)
    {
        return view('tugas.edit', ['tugas' => $tugas]);
    }

    /** Simpan perubahan (LOGIKA BARU: BASE64) */
    public function update(Request $request, Tugas $tugas)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deadline' => 'required|date',
            'file_tugas' => 'nullable|file|mimes:pdf,doc,docx,zip,png,jpg|max:2048',
        ]);
        
        $tugas->judul = $request->judul;
        $tugas->deskripsi = $request->deskripsi;
        $tugas->deadline = $request->deadline;
        
        if ($request->hasFile('file_tugas')) {        
            
            $file = $request->file('file_tugas');
            $base64 = base64_encode(file_get_contents($file));
                        
            $tugas->file_path = 'data:' . $file->getMimeType() . ';base64,' . $base64;
        }
        // -----------------------
        
        $tugas->save();
        return redirect()->route('home')->with('success', 'Tugas berhasil diperbarui!');
    }

    /** Hapus tugas (Soft Delete) */
    public function destroy(Tugas $tugas)
    {
        $tugas->delete();
        return redirect()->route('home')->with('success', 'Tugas masuk keranjang sampah!');
    }

    /** Cetak laporan */
    public function cetakLaporan()
    {
        $tugas = Tugas::orderBy('deadline', 'asc')->get();
        return view('laporan', ['tugas' => $tugas]);
    }    

    public function trash()
    {
        $tugasDihapus = Tugas::onlyTrashed()->paginate(10);
        return view('tugas.trash', ['tugas' => $tugasDihapus]);
    }

    public function restore($id)
    {
        $tugas = Tugas::withTrashed()->find($id);
        if ($tugas) {
            $tugas->restore();
            return redirect()->route('tugas.trash')->with('success', 'Tugas dikembalikan!');
        }
        return redirect()->route('tugas.trash')->with('error', 'Tugas tidak ditemukan.');
    }

    public function forceDelete($id)
    {
        $tugas = Tugas::withTrashed()->find($id);
        if ($tugas) {
            
            $tugas->forceDelete(); // Hapus data dari DB saja
            return redirect()->route('tugas.trash')->with('success', 'Tugas dihapus permanen!');
        }
        return redirect()->route('tugas.trash')->with('error', 'Tugas tidak ditemukan.');
    }

    public function clearTrash()
    {
        $trashedTasks = Tugas::onlyTrashed()->get();

        if ($trashedTasks->isEmpty()) {
            return redirect()->route('tugas.trash')->with('info', 'Sampah sudah kosong.');
        }
        
        Tugas::onlyTrashed()->forceDelete();

        return redirect()->route('tugas.trash')->with('success', 'Semua sampah dibersihkan!');
    }
    public function downloadFile(Tugas $tugas)
    {
        // 1. Cek apakah ada file
        if (!$tugas->file_path) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        // 2. Pecah string Base64 (Format: "data:application/pdf;base64,JVBERi...")
        // Kita perlu memisahkan "Header" dan "Isi Data"
        @list($type, $file_data) = explode(';', $tugas->file_path);
        @list(, $file_data)      = explode(',', $file_data);

        // 3. Decode Base64 kembali menjadi file fisik (binary)
        $decoded_file = base64_decode($file_data);

        // 4. Deteksi Mime Type untuk menentukan ekstensi file
        // $type isinya seperti "data:application/pdf"
        $mime_type = str_replace('data:', '', $type); 
        
        // Tentukan ekstensi berdasarkan mime type
        $extension = 'bin'; // Default
        if (str_contains($mime_type, 'pdf')) $extension = 'pdf';
        elseif (str_contains($mime_type, 'word') || str_contains($mime_type, 'doc')) $extension = 'docx';
        elseif (str_contains($mime_type, 'sheet') || str_contains($mime_type, 'excel')) $extension = 'xlsx';
        elseif (str_contains($mime_type, 'presentation') || str_contains($mime_type, 'powerpoint')) $extension = 'pptx';
        elseif (str_contains($mime_type, 'image/jpeg')) $extension = 'jpg';
        elseif (str_contains($mime_type, 'image/png')) $extension = 'png';
        elseif (str_contains($mime_type, 'zip')) $extension = 'zip';

        // 5. Buat nama file yang cantik
        $filename = 'Tugas-' . preg_replace('/[^A-Za-z0-9\-]/', '', $tugas->judul) . '.' . $extension;

        // 6. Kirim ke browser sebagai download stream
        return response($decoded_file)
            ->header('Content-Type', $mime_type)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
    public function previewFile(Tugas $tugas)
    {
        // 1. Cek file
        if (!$tugas->file_path) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        // 2. Decode Base64 (Sama seperti download)
        @list($type, $file_data) = explode(';', $tugas->file_path);
        @list(, $file_data)      = explode(',', $file_data);
        $decoded_file = base64_decode($file_data);
        $mime_type = str_replace('data:', '', $type);

        // 3. Buat nama file
        $filename = 'Preview-' . preg_replace('/[^A-Za-z0-9\-]/', '', $tugas->judul);

        // 4. Kirim response dengan mode 'INLINE' (Tampilkan)
        return response($decoded_file)
            ->header('Content-Type', $mime_type)
            ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
    }
}
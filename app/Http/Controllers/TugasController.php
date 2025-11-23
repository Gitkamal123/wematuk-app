<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 

class TugasController extends Controller
{
    /** Tampilkan SEMUA tugas, untuk semua user */
    public function index()
    {
        // Hapus 'orderBy('status')'
        $tugas = Tugas::orderBy('deadline', 'asc')
                      ->paginate(10); 
        
        return view('tugas.index', ['tugas' => $tugas]);
    }

    /** Tampilkan form tambah. Hanya admin. */
    public function create()
    {
        return view('tugas.create');
    }

    /** Simpan tugas baru. Hanya admin. */
    public function store(Request $request)
    {
        // Hapus 'status' dari validasi
        $request->validate([
            'judul' => 'required|string|max:255',
            'deadline' => 'required|date',
            'file_tugas' => 'nullable|file|mimes:pdf,doc,docx,zip,png,jpg|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('file_tugas')) {
            $path = $request->file('file_tugas')->store('dokumen', 'public');
        }

        Tugas::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
            'file_path' => $path,
            // 'status' => $request->status, // <-- Hapus baris ini
        ]);

        return redirect()->route('home')->with('success', 'Tugas berhasil ditambahkan!');
    }

    /** Tampilkan detail 1 tugas. Semua user bisa lihat. */
    public function show(Tugas $tugas)
    {
        return view('tugas.show', ['tugas' => $tugas]);
    }

    /** Tampilkan form edit. Hanya admin. */
    public function edit(Tugas $tugas)
    {
        return view('tugas.edit', ['tugas' => $tugas]);
    }

    /** Simpan perubahan. Hanya admin. */
    public function update(Request $request, Tugas $tugas)
    {
        // Hapus 'status' dari validasi
        $request->validate([
            'judul' => 'required|string|max:255',
            'deadline' => 'required|date',
            'file_tugas' => 'nullable|file|mimes:pdf,doc,docx,zip,png,jpg|max:2048',
        ]);
        
        $tugas->judul = $request->judul;
        $tugas->deskripsi = $request->deskripsi;
        $tugas->deadline = $request->deadline;
        // $tugas->status = $request->status; // <-- Hapus baris ini

        if ($request->hasFile('file_tugas')) {
            if ($tugas->file_path) {
                Storage::disk('public')->delete($tugas->file_path);
            }
            $tugas->file_path = $request->file('file_tugas')->store('dokumen', 'public');
        }
        
        $tugas->save();
        return redirect()->route('home')->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * Hapus tugas. (Sekarang otomatis Soft Delete)
     */
    public function destroy(Tugas $tugas)
    {
        $tugas->delete();
        return redirect()->route('home')->with('success', 'Tugas berhasil dipindahkan ke keranjang sampah!');
    }

    /** Cari tugas. Semua user bisa. */
    public function cari(Request $request)
    {
        $cari = $request->cari;
        // Hapus 'orderBy('status')'
        $tugas = Tugas::where('judul', 'like', "%" . $cari . "%")
                      ->orderBy('deadline', 'asc')
                      ->paginate(10);
        return view('tugas.index', ['tugas' => $tugas]);
    }

    /** Cetak laporan. Semua user bisa. */
    public function cetakLaporan()
    {
        // Hapus 'orderBy('status')'
        $tugas = Tugas::orderBy('deadline', 'asc')->get();
        return view('laporan', ['tugas' => $tugas]);
    }

    // --- FUNGSI SOFT DELETES (Ini TETAP ADA) ---

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
            return redirect()->route('tugas.trash')->with('success', 'Tugas berhasil dikembalikan!');
        }
        return redirect()->route('tugas.trash')->with('error', 'Tugas tidak ditemukan.');
    }

    public function forceDelete($id)
    {
        $tugas = Tugas::withTrashed()->find($id);
        if ($tugas) {
            if ($tugas->file_path) {
                Storage::disk('public')->delete($tugas->file_path);
            }
            $tugas->forceDelete();
            return redirect()->route('tugas.trash')->with('success', 'Tugas berhasil dihapus permanen!');
        }
        return redirect()->route('tugas.trash')->with('error', 'Tugas tidak ditemukan.');
    }
    public function clearTrash()
    {
        // 1. Dapatkan semua tugas yang di-soft-delete
        $trashedTasks = Tugas::onlyTrashed()->get();

        if ($trashedTasks->isEmpty()) {
            return redirect()->route('tugas.trash')->with('info', 'Keranjang sampah sudah kosong.');
        }

        // 2. Iterasi untuk menghapus semua file dari storage
        foreach ($trashedTasks as $tugas) {
            if ($tugas->file_path) {
                Storage::disk('public')->delete($tugas->file_path);
            }
        }
        
        // 3. Hapus semua data dari database (setelah file dihapus)
        Tugas::onlyTrashed()->forceDelete();

        return redirect()->route('tugas.trash')->with('success', 'Keranjang sampah telah berhasil dikosongkan!');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman form edit profil.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', ['user' => $user]);
    }

    /**
     * Simpan perubahan profil (HANYA NAMA).
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi HANYA 'name'
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Simpan HANYA 'name'
        $user->name = $request->name;
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Hapus akun user yang sedang login.
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();
        Auth::logout();

        if ($user->delete()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/')->with('success', 'Akun Anda telah berhasil dihapus.');
        }

        return back()->with('error', 'Terjadi kesalahan saat menghapus akun.');
    }
}
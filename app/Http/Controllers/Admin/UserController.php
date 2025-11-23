<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tugas;
use Illuminate\Support\Facades\Auth; 

class UserController extends Controller
{
    /** Tampilkan Statistik */
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalTugas = Tugas::count();
        return view('admin.dashboard', compact('totalUsers', 'totalTugas'));
    }

    /** Tampilkan Daftar Semua User */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /** Tampilkan Form Edit User (Ubah Peran) */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /** Simpan Perubahan User (HANYA MENGUBAH ROLE) */
    public function update(Request $request, User $user)
    {
        
        if ($user->id == Auth::id()) {
            return back()->with('error', 'Anda tidak bisa role akun Anda sendiri.');
        }
        
        $request->validate([
            'role' => 'required|string|in:admin,user'
        ]);
        
        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Peran user berhasil diperbarui.');
    }

    /** Hapus User */
    public function destroy(User $user)
    {
        if ($user->id == Auth::id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// --- Tambahan untuk override ---
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// --- --------------------- ---

class RegisterController extends Controller
{
    use RegistersUsers;
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Validasi diganti dari 'email' menjadi 'nrp'
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'nrp' => ['required', 'string', 'max:255', 'unique:users'], 
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * User baru dibuat dengan 'nrp', bukan 'email'
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'nrp' => $data['nrp'], // <-- GANTI DARI EMAIL
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Override: Redirect ke halaman login setelah register
     */
    protected function registered(Request $request, $user)
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login dengan NRP Anda.');
    }
}
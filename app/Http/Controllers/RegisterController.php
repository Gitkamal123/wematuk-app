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
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait
    | to provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/'; // Ini adalah halaman 'home' kita

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            // 'role' => 'user' (ini sudah di-handle oleh file migrasi kita)
        ]);
    }

    // 👇👇👇 FUNGSI BARU DITAMBAHKAN DI SINI 👇👇👇
    /**
     * Override: Apa yang terjadi setelah user berhasil terdaftar.
     *
     * Kita akan log user keluar dan arahkan ke halaman login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        // 1. Log user yang baru mendaftar keluar (logout)
        Auth::logout();

        // 2. Arahkan ke halaman login dengan pesan sukses
        // (Pesan ini akan ditampilkan di halaman login jika Anda menambahkannya di view)
        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login untuk melanjutkan.');
    }
}
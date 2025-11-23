<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home'; // Ini akan mengarah ke route('home')

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Beritahu Laravel untuk menggunakan 'nrp' sebagai field login,
     * bukan 'email'.
     */
    public function username()
    {
        return 'nrp';
    }

    /**
     * Override method untuk custom error message
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'login_error' => ['NRP atau Password yang Anda masukkan salah.'],
        ]);
    }
}
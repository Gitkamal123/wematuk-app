@extends('layouts.master')

@section('title', 'Login - WeMaTuK')

@section('content')
    <style>
        /* ===================== */
        /* SIMPLE & ELEGANT      */
        /* ===================== */

        body {
            background: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .login-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 3rem 2.5rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            max-width: 480px;
            width: 100%;
            margin: 0 auto;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }

        .login-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Header */
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .icon-wrapper {
            width: 70px;
            height: 70px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }

        .icon-wrapper:hover {
            transform: scale(1.05) rotate(3deg);
        }

        .login-icon {
            width: 35px;
            height: 35px;
            color: #ffffff;
        }

        .login-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 0.5rem;
        }

        .brand-name {
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .login-subtitle {
            font-size: 0.95rem;
            color: #718096;
        }

        /* Alert */
        .alert-custom {
            padding: 1rem 1.25rem;
            border-radius: 12px;
            border: none;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert-success-custom {
            background: #d4edda;
            color: #155724;
        }

        .alert-danger-custom {
            background: #f8d7da;
            color: #721c24;
        }

        /* Form */
        .form-group-custom {
            margin-bottom: 1.5rem;
        }

        .form-label-custom {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .label-required {
            color: #e53e3e;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input-custom {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            font-size: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.3s ease;
            background: #f7fafc;
        }

        .form-input-custom:focus {
            outline: none;
            border-color: #4a90e2;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        .form-input-custom.is-invalid {
            border-color: #e53e3e;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            pointer-events: none;
        }

        .password-toggle-btn {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #a0aec0;
            cursor: pointer;
            padding: 0.5rem;
            transition: color 0.3s ease;
        }

        .password-toggle-btn:hover {
            color: #4a90e2;
        }

        .invalid-feedback-custom {
            color: #e53e3e;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: block;
        }

        /* Forgot Password Link */
        .forgot-password {
            font-size: 0.85rem;
            color: #4a90e2;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: #2b6cb0;
            text-decoration: underline;
        }

        /* Checkbox */
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .checkbox-custom {
            width: 18px;
            height: 18px;
            margin-right: 0.5rem;
            cursor: pointer;
            accent-color: #4a90e2;
        }

        .checkbox-label {
            font-size: 0.9rem;
            color: #4a5568;
            cursor: pointer;
        }

        /* Button */
        .btn-login {
            width: 100%;
            padding: 0.875rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(74, 144, 226, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-login:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
        }

        .btn-login:active:not(:disabled) {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Footer Link */
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }

        .footer-text {
            color: #718096;
            font-size: 0.9rem;
        }

        .footer-link {
            color: #4a90e2;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .footer-link:hover {
            color: #2b6cb0;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .login-card {
                padding: 2rem 1.5rem;
            }

            .login-title {
                font-size: 1.75rem;
            }
        }
    </style>

    <div class="login-container">
        <div class="login-card" id="loginCard">

            <!-- Header -->
            <div class="login-header">
                <div class="icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="login-icon" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                    </svg>
                </div>
                <h1 class="login-title">Login ke <span class="brand-name">WeMaTuK</span></h1>
                <p class="login-subtitle">Masuk ke akun Anda</p>
            </div>

            <!-- Success Alert -->
            @if (session('success'))
                <div class="alert-custom alert-success-custom">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Error Alert -->
            @if ($errors->has('login_error'))
                <div class="alert-custom alert-danger-custom">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                    <span>{{ $errors->first('login_error') }}</span>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <!-- NRP Field -->
                <div class="form-group-custom">
                    <label for="nrp" class="form-label-custom">
                        NRP <span class="label-required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="input-icon" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                        </svg>
                        <input 
                            id="nrp" 
                            type="text" 
                            class="form-input-custom @error('nrp') is-invalid @enderror"
                            name="nrp" 
                            value="{{ old('nrp') }}" 
                            required 
                            autocomplete="nrp" 
                            autofocus
                            placeholder="Masukkan NRP"
                        >
                    </div>
                    @error('nrp')
                        <span class="invalid-feedback-custom">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-group-custom">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <label for="password" class="form-label-custom" style="margin-bottom: 0;">
                            Password <span class="label-required">*</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-password">
                                Lupa Password?
                            </a>
                        @endif
                    </div>
                    <div class="input-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="input-icon" viewBox="0 0 16 16">
                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                        </svg>
                        <input 
                            id="password" 
                            type="password"
                            class="form-input-custom @error('password') is-invalid @enderror" 
                            name="password"
                            required 
                            autocomplete="current-password"
                            placeholder="Masukkan password"
                        >
                        <button type="button" class="password-toggle-btn" id="togglePassword">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="eye-icon" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="invalid-feedback-custom">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="checkbox-wrapper">
                    <input 
                        class="checkbox-custom" 
                        type="checkbox" 
                        name="remember" 
                        id="remember" 
                        {{ old('remember') ? 'checked' : '' }}
                    >
                    <label class="checkbox-label" for="remember">
                        Ingat saya
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-login" id="loginButton">
                    <span id="buttonText">Login</span>
                </button>

            </form>

            <!-- Footer -->
            @if (Route::has('register'))
                <div class="login-footer">
                    <p class="footer-text">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="footer-link">Daftar di sini</a>
                    </p>
                </div>
            @endif

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Entrance animation
            const card = document.getElementById('loginCard');
            setTimeout(() => {
                card.classList.add('show');
            }, 150);

            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = togglePassword.querySelector('.eye-icon');

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.type === 'password' ? 'text' : 'password';
                passwordInput.type = type;
                
                // Change icon
                if (type === 'text') {
                    eyeIcon.innerHTML = '<path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/><path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/><path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>';
                } else {
                    eyeIcon.innerHTML = '<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>';
                }
            });

            // Form submission with loading state
            const loginForm = document.getElementById('loginForm');
            const loginButton = document.getElementById('loginButton');
            const buttonText = document.getElementById('buttonText');

            loginForm.addEventListener('submit', function() {
                loginButton.disabled = true;
                buttonText.innerHTML = '<div class="spinner"></div> Memproses...';
            });

            // Auto focus on NRP field
            document.getElementById('nrp').focus();
        });
    </script>
@endsection
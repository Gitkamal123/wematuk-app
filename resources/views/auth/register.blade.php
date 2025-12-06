@extends('layouts.master')

@section('title', 'Register - WeMaTuK')

@section('content')
            <style>
                /* ===================== */
                /* SIMPLE & ELEGANT      */
                /* ===================== */

                body {
                    background: #f8f9fa;
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                }

                .register-container {
                    min-height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 2rem 1rem;
                }

                .register-card {
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

                .register-card.show {
                    opacity: 1;
                    transform: translateY(0);
                }

                /* Header */
                .register-header {
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

                .register-icon {
                    width: 35px;
                    height: 35px;
                    color: #ffffff;
                }

                .register-title {
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

                .register-subtitle {
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
                    opacity: 0;
                    transform: translateY(-10px);
                    transition: all 0.4s ease;
                }

                .alert-custom.show {
                    opacity: 1;
                    transform: translateY(0);
                }

                .alert-success-custom {
                    background: #d4edda;
                    color: #155724;
                    border-left: 4px solid #28a745;
                }

                .alert-danger-custom {
                    background: #f8d7da;
                    color: #721c24;
                    border-left: 4px solid #dc3545;
                }

                .alert-warning-custom {
                    background: #fff3cd;
                    color: #856404;
                    border-left: 4px solid #ffc107;
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
                    background: #fef5f5;
                    animation: shake 0.5s ease-in-out;
                }

                .form-input-custom.is-success {
                    border-color: #28a745;
                    background: #f8fff9;
                }

                .input-icon {
                    position: absolute;
                    left: 1rem;
                    top: 50%;
                    transform: translateY(-50%);
                    color: #a0aec0;
                    pointer-events: none;
                    transition: color 0.3s ease;
                }

                .form-input-custom.is-invalid~.input-icon {
                    color: #e53e3e;
                }

                .form-input-custom.is-success~.input-icon {
                    color: #28a745;
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
                    opacity: 0;
                    transform: translateY(-5px);
                    transition: all 0.3s ease;
                }

                .invalid-feedback-custom.show {
                    opacity: 1;
                    transform: translateY(0);
                }

                /* Password Strength */
                .password-strength {
                    margin-top: 0.5rem;
                }

                .strength-bar {
                    height: 4px;
                    background: #e2e8f0;
                    border-radius: 2px;
                    overflow: hidden;
                    margin-bottom: 0.25rem;
                }

                .strength-fill {
                    height: 100%;
                    width: 0%;
                    transition: all 0.3s ease;
                    border-radius: 2px;
                }

                .strength-weak .strength-fill {
                    background: #e53e3e;
                    width: 33%;
                }

                .strength-medium .strength-fill {
                    background: #d69e2e;
                    width: 66%;
                }

                .strength-strong .strength-fill {
                    background: #38a169;
                    width: 100%;
                }

                .strength-text {
                    font-size: 0.75rem;
                    color: #718096;
                }

                .strength-weak .strength-text {
                    color: #e53e3e;
                }

                .strength-medium .strength-text {
                    color: #d69e2e;
                }

                .strength-strong .strength-text {
                    color: #38a169;
                }

                /* Button */
                .btn-register {
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
                    margin-top: 1rem;
                }

                .btn-register:hover:not(:disabled) {
                    transform: translateY(-2px);
                    box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
                }

                .btn-register:active:not(:disabled) {
                    transform: translateY(0);
                }

                .btn-register:disabled {
                    opacity: 0.7;
                    cursor: not-allowed;
                }

                #buttonText {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 10px; 
                    width: 100%;
                }

                .spinner {
                    width: 18px;
                    height: 18px;
                    border: 2px solid rgba(255, 255, 255, 0.3);
                    border-top-color: #ffffff;
                    border-radius: 50%;
                    animation: spin 0.8s linear infinite;
                    flex-shrink: 0;
                }

                @keyframes spin {
                    to {
                        transform: rotate(360deg);
                    }
                }

                @keyframes shake {

                    0%,
                    100% {
                        transform: translateX(0);
                    }

                    25% {
                        transform: translateX(-5px);
                    }

                    75% {
                        transform: translateX(5px);
                    }
                }

                /* Footer Link */
                .register-footer {
                    text-align: center;
                    margin-top: 2rem;
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
                    .register-card {
                        padding: 2rem 1.5rem;
                    }

                    .register-title {
                        font-size: 1.75rem;
                    }
                }
            </style>

            <div class="register-container">
                <div class="register-card" id="registerCard">

                    <!-- Header -->
                    <div class="register-header">
                        <div class="icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="register-icon" viewBox="0 0 16 16">
                                <path
                                    d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm-2 3a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4z" />
                            </svg>
                        </div>
                        <h1 class="register-title">Daftar <span class="brand-name">WeMaTuK</span></h1>
                        <p class="register-subtitle">Buat akun baru Anda</p>
                    </div>

                    <!-- Success Alert -->
                    @if (session('success'))
                        <div class="alert-custom alert-success-custom" id="successAlert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Error Alert Container -->
                    <div id="errorAlertContainer"></div>

                    <!-- Register Form -->
                    <form method="POST" action="{{ route('register') }}" id="registerForm">

                    {{-- <form method="POST" action="{{ route('register') }}" id="registerForm"> --}}
                        @csrf

                        <!-- Nama Lengkap Field -->
                        <div class="form-group-custom">
                            <label for="name" class="form-label-custom">
                                Nama Lengkap <span class="label-required">*</span>
                            </label>
                            <div class="input-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="input-icon" viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                </svg>
                                <input id="name" type="text" class="form-input-custom @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                    placeholder="Masukkan nama lengkap">
                            </div>
                            <div id="nameError" class="invalid-feedback-custom">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <!-- NRP Field -->
                        <div class="form-group-custom">
                            <label for="nrp" class="form-label-custom">
                                NRP <span class="label-required">*</span>
                            </label>
                            <div class="input-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="input-icon" viewBox="0 0 16 16">
                                    <path
                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
                                </svg>
                                <input id="nrp" type="text" class="form-input-custom @error('nrp') is-invalid @enderror" name="nrp"
                                    value="{{ old('nrp') }}" required autocomplete="nrp" placeholder="Masukkan NRP">
                            </div>
                            <div id="nrpError" class="invalid-feedback-custom">
                                @error('nrp')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="form-group-custom">
                            <label for="password" class="form-label-custom">
                                Password <span class="label-required">*</span>
                            </label>
                            <div class="input-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="input-icon" viewBox="0 0 16 16">
                                    <path
                                        d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
                                </svg>
                                <input id="password" type="password"
                                    class="form-input-custom @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password" placeholder="Masukkan password">
                                <button type="button" class="password-toggle-btn" id="togglePassword">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                        class="eye-icon" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                    </svg>
                                </button>
                            </div>
                            <div id="passwordError" class="invalid-feedback-custom">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </div>

                            <!-- Password Strength Indicator -->
                            <div class="password-strength" id="passwordStrength">
                                <div class="strength-bar">
                                    <div class="strength-fill"></div>
                                </div>
                                <div class="strength-text">Kekuatan password</div>
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="form-group-custom">
                            <label for="password-confirmation" class="form-label-custom">
                                Konfirmasi Password <span class="label-required">*</span>
                            </label>
                            <div class="input-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="input-icon" viewBox="0 0 16 16">
                                    <path
                                        d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
                                </svg>
                                <input id="password-confirmation" type="password" class="form-input-custom"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Konfirmasi password">
                                <button type="button" class="password-toggle-btn" id="toggleConfirmPassword">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                        class="eye-icon" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                    </svg>
                                </button>
                            </div>
                            <div id="passwordConfirmationError" class="invalid-feedback-custom"></div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-register" id="registerButton">
                            <span id="buttonText">Daftar Sekarang</span>
                        </button>

                    </form>

                    <!-- Footer -->
                    <div class="register-footer">
                        <p class="footer-text">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="footer-link">Login di sini</a>
                        </p>
                    </div>

                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Entrance animation
                    const card = document.getElementById('registerCard');
                    setTimeout(() => {
                        card.classList.add('show');
                    }, 150);

                    // Show existing alerts
                    const successAlert = document.getElementById('successAlert');
                    if (successAlert) {
                        setTimeout(() => successAlert.classList.add('show'), 300);
                    }

                    // Toggle password visibility
                    function setupPasswordToggle(buttonId, inputId) {
                        const toggleButton = document.getElementById(buttonId);
                        const passwordInput = document.getElementById(inputId);
                        const eyeIcon = toggleButton.querySelector('.eye-icon');

                        toggleButton.addEventListener('click', function () {
                            const type = passwordInput.type === 'password' ? 'text' : 'password';
                            passwordInput.type = type;

                            // Change icon
                            if (type === 'text') {
                                eyeIcon.innerHTML = '<path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/><path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/><path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>';
                            } else {
                                eyeIcon.innerHTML = '<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>';
                            }
                        });
                    }

                    setupPasswordToggle('togglePassword', 'password');
                    setupPasswordToggle('toggleConfirmPassword', 'password-confirmation');

                    // Password strength indicator
                    const passwordInput = document.getElementById('password');
                    const passwordStrength = document.getElementById('passwordStrength');

                    passwordInput.addEventListener('input', function () {
                        const password = this.value;
                        let strength = 0;
                        let text = 'Kekuatan password';

                        if (password.length >= 8) strength++;
                        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
                        if (password.match(/\d/)) strength++;
                        if (password.match(/[^a-zA-Z\d]/)) strength++;

                        passwordStrength.className = 'password-strength';

                        if (password.length > 0) {
                            if (strength <= 1) {
                                passwordStrength.classList.add('strength-weak');
                                text = 'Password lemah';
                            } else if (strength <= 2) {
                                passwordStrength.classList.add('strength-medium');
                                text = 'Password cukup';
                            } else {
                                passwordStrength.classList.add('strength-strong');
                                text = 'Password kuat';
                            }
                        }

                        passwordStrength.querySelector('.strength-text').textContent = text;
                    });

                    // Form validation
                    const registerForm = document.getElementById('registerForm');
                    const registerButton = document.getElementById('registerButton');
                    const buttonText = document.getElementById('buttonText');

                    function showFieldError(fieldId, message) {
                        const field = document.getElementById(fieldId);
                        const errorElement = document.getElementById(fieldId + 'Error');

                        if (field && errorElement) {
                            field.classList.add('is-invalid');
                            errorElement.textContent = message;
                            errorElement.classList.add('show');

                            // Add shake animation
                            field.style.animation = 'none';
                            setTimeout(() => {
                                field.style.animation = 'shake 0.5s ease-in-out';
                            }, 10);
                        }
                    }

                    function clearFieldError(fieldId) {
                        const field = document.getElementById(fieldId);
                        const errorElement = document.getElementById(fieldId + 'Error');

                        if (field && errorElement) {
                            field.classList.remove('is-invalid');
                            errorElement.classList.remove('show');
                        }
                    }

                    // Real-time validation
                    const nameField = document.getElementById('name');
                    const nrpField = document.getElementById('nrp');
                    const passwordField = document.getElementById('password');
                    const confirmPasswordField = document.getElementById('password-confirmation');

                    // Clear errors on input
                    [nameField, nrpField, passwordField, confirmPasswordField].forEach(field => {
                        field.addEventListener('input', function () {
                            clearFieldError(this.id);
                        });
                    });

                    // Form submission
                    registerForm.addEventListener('submit', function (e) {
                        e.preventDefault();

                        let isValid = true;

                        // Validate name
                        if (nameField.value.trim().length < 2) {
                            showFieldError('name', 'Nama harus minimal 2 karakter');
                            isValid = false;
                        }

                        // Validate NRP
                        if (!/^\d+$/.test(nrpField.value.trim())) {
                            showFieldError('nrp', 'NRP harus berupa angka');
                            isValid = false;
                        }

                        // Validate password
                        if (passwordField.value.length < 8) {
                            showFieldError('password', 'Password harus minimal 8 karakter');
                            isValid = false;
                        }

                        // Validate password confirmation
                        if (passwordField.value !== confirmPasswordField.value) {
                            showFieldError('password-confirmation', 'Konfirmasi password tidak sesuai');
                            isValid = false;
                        }

                        if (isValid) {
                            // Show loading state
                            registerButton.disabled = true;
                            buttonText.innerHTML = '<div class="spinner"></div> Membuat akun...';

                            // Submit the form
                            this.submit();
                        }
                    });

                    // Auto focus on name field
                    document.getElementById('name').focus();
                });
            </script>
@endsection
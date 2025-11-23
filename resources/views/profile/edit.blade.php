@extends('layouts.master')

@section('title', 'Profil Saya - WeMaTuK')

@section('content')
    <style>
        /* ===================== */
        /* PROFILE PAGE STYLE    */
        /* ===================== */

        body {
            background: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .profile-container {
            padding: 2rem 0;
            min-height: 80vh;
        }

        /* Header */
        .profile-header {
            margin-bottom: 2rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }

        .profile-header.show {
            opacity: 1;
            transform: translateY(0);
        }

        .profile-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 0.5rem;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
            color: #ffffff;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        /* Profile Card */
        .profile-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            margin-bottom: 1.5rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }

        .profile-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        .card-header-custom {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f7fafc;
        }

        .card-title-custom {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1a202c;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0;
        }

        .icon-wrapper-small {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-wrapper-small svg {
            width: 20px;
            height: 20px;
            color: #ffffff;
        }

        /* Form Elements */
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

        .input-wrapper {
            position: relative;
            transition: transform 0.2s ease;
        }

        .input-wrapper:focus-within {
            transform: translateY(-2px);
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

        .form-input-custom:disabled {
            background: #edf2f7;
            color: #718096;
            cursor: not-allowed;
        }

        .form-input-custom.is-invalid {
            border-color: #e53e3e;
            animation: shake 0.5s ease-in-out;
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

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            pointer-events: none;
            transition: color 0.3s ease;
        }

        .input-wrapper:focus-within .input-icon {
            color: #4a90e2;
        }

        .invalid-feedback-custom {
            color: #e53e3e;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .help-text {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: #718096;
            margin-top: 0.5rem;
        }

        /* Buttons */
        .btn-custom {
            padding: 0.75rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn-custom:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none !important;
        }

        .btn-custom .spinner {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .btn-custom.loading .spinner {
            display: block;
        }

        .btn-custom.loading .btn-text {
            opacity: 0.7;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(74, 144, 226, 0.3);
        }

        .btn-primary-custom:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
        }

        .btn-danger-custom {
            background: #ffffff;
            color: #e53e3e;
            border: 2px solid #e53e3e;
        }

        .btn-danger-custom:hover:not(:disabled) {
            background: #e53e3e;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(229, 62, 62, 0.3);
        }

        /* Danger Zone Card */
        .danger-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            border: 2px solid #fee;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
            transition-delay: 0.2s;
        }

        .danger-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        .danger-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #fee;
        }

        .danger-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #e53e3e;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0;
        }

        .icon-wrapper-danger {
            width: 40px;
            height: 40px;
            background: rgba(229, 62, 62, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-wrapper-danger svg {
            width: 20px;
            height: 20px;
            color: #e53e3e;
        }

        .alert-custom-danger {
            background: rgba(229, 62, 62, 0.1);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            gap: 1rem;
        }

        .alert-icon {
            flex-shrink: 0;
            width: 40px;
            height: 40px;
            color: #e53e3e;
        }

        .alert-content {
            flex: 1;
        }

        .alert-content strong {
            display: block;
            color: #e53e3e;
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .alert-content p {
            color: #718096;
            font-size: 0.9rem;
            margin: 0;
        }

        /* Success Notification */
        .success-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(72, 187, 120, 0.3);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            z-index: 1000;
            transform: translateX(400px);
            transition: transform 0.4s ease;
        }

        .success-notification.show {
            transform: translateX(0);
        }

        .success-notification svg {
            width: 20px;
            height: 20px;
        }

        /* Confirmation Modal */
        .confirmation-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1050;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .confirmation-modal.show {
            opacity: 1;
            visibility: visible;
        }

        .modal-content-custom {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            max-width: 400px;
            width: 90%;
            transform: scale(0.7);
            transition: transform 0.3s ease;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .confirmation-modal.show .modal-content-custom {
            transform: scale(1);
        }

        .modal-icon {
            width: 60px;
            height: 60px;
            background: rgba(229, 62, 62, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .modal-icon svg {
            width: 30px;
            height: 30px;
            color: #e53e3e;
        }

        .modal-title {
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 1rem;
        }

        .modal-text {
            text-align: center;
            color: #718096;
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .modal-btn {
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .modal-btn-cancel {
            background: #e2e8f0;
            color: #4a5568;
        }

        .modal-btn-cancel:hover {
            background: #cbd5e0;
        }

        .modal-btn-confirm {
            background: #e53e3e;
            color: white;
        }

        .modal-btn-confirm:hover {
            background: #c53030;
            transform: translateY(-1px);
        }

        /* Responsive */
        @media (max-width: 768px) {

            .profile-card,
            .danger-card {
                padding: 1.5rem;
            }

            .profile-title {
                font-size: 1.5rem;
            }

            .btn-custom {
                width: 100%;
                justify-content: center;
            }

            .modal-actions {
                flex-direction: column;
            }

            .success-notification {
                right: 10px;
                left: 10px;
                transform: translateY(-100px);
            }

            .success-notification.show {
                transform: translateY(0);
            }
        }
    </style>

    <div class="profile-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <!-- Success Notification -->
                    @if(session('success'))
                        <div class="success-notification" id="successNotification">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Header -->
                    <div class="profile-header" id="profileHeader">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                            <div>
                                <h1 class="profile-title">Pengaturan Profil</h1>
                                <p class="text-muted mb-0">Kelola informasi pribadi Anda</p>
                            </div>
                            <div class="role-badge">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    @if(Auth::user()->role == 'admin')
                                        <path
                                            d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
                                    @else
                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                        <path fill-rule="evenodd"
                                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                    @endif
                                </svg>
                                {{ Auth::user()->role == 'admin' ? 'Administrator' : 'Mahasiswa' }}
                            </div>
                        </div>
                    </div>

                    <!-- Profile Information Card -->
                    <div class="profile-card" id="profileCard">
                        <div class="card-header-custom">
                            <h2 class="card-title-custom">
                                <div class="icon-wrapper-small">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                    </svg>
                                </div>
                                Edit Informasi
                            </h2>
                        </div>

                        <!-- NRP (Read-Only) -->
                        <div class="form-group-custom">
                            <label for="nrp" class="form-label-custom">NRP (Nomor Registrasi Pokok)</label>
                            <div class="input-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="input-icon" viewBox="0 0 16 16">
                                    <path
                                        d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4Zm0 1h8a1 1 0 0 1 1 1v3H3V2a1 1 0 0 1 1-1ZM3 6h10v8a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6Zm3 1a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1H6Zm0 2a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1H6Zm0 2a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1H6Z" />
                                </svg>
                                <input type="text" class="form-input-custom" id="nrp" value="{{ $user->nrp }}" disabled
                                    readonly>
                            </div>
                            <small class="help-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path
                                        d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                </svg>
                                NRP adalah identitas unik Anda dan tidak dapat diubah
                            </small>
                        </div>

                        <!-- Form Edit -->
                        <form action="{{ route('profile.update') }}" method="POST" id="profileForm">
                            @csrf
                            @method('PUT')

                            <!-- Nama Lengkap -->
                            <div class="form-group-custom">
                                <label for="name" class="form-label-custom">Nama Lengkap</label>
                                <div class="input-wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="input-icon" viewBox="0 0 16 16">
                                        <path
                                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
                                    </svg>
                                    <input type="text" class="form-input-custom @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $user->name) }}" required
                                        placeholder="Masukkan nama lengkap">
                                </div>
                                @error('name')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn-custom btn-primary-custom" id="saveButton">
                                    <span class="spinner"></span>
                                    <span class="btn-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z" />
                                        </svg>
                                        Simpan Perubahan
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Danger Zone Card -->
                    <div class="danger-card" id="dangerCard">
                        <div class="danger-header"></div>

                        <!-- Warning Alert -->
                        <div class="alert-custom-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" class="alert-icon" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                <path
                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                            </svg>
                            <div class="alert-content">
                                <strong>Hapus Akun Permanen</strong>
                                <p>Tindakan ini tidak dapat dibatalkan.</p>
                            </div>
                        </div>

                        <!-- Delete Button -->
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn-custom btn-danger-custom" id="deleteAccountButton">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                    <path
                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                </svg>
                                Hapus Akun
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="confirmation-modal" id="confirmationModal">
        <div class="modal-content-custom">
            <div class="modal-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                </svg>
            </div>
            <h3 class="modal-title">Hapus Permanen?</h3>
            <div class="modal-actions">
                <button type="button" class="modal-btn modal-btn-cancel" id="cancelDelete">Batal</button>
                <form action="{{ route('profile.destroy') }}" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="modal-btn modal-btn-confirm">Ya, Hapus Akun</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Entrance animations
            const header = document.getElementById('profileHeader');
            const profileCard = document.getElementById('profileCard');
            const dangerCard = document.getElementById('dangerCard');
            const successNotification = document.getElementById('successNotification');

            setTimeout(() => {
                header.classList.add('show');
            }, 100);

            setTimeout(() => {
                profileCard.classList.add('show');
            }, 200);

            setTimeout(() => {
                dangerCard.classList.add('show');
            }, 300);

            // Show success notification if exists
            if (successNotification) {
                setTimeout(() => {
                    successNotification.classList.add('show');
                }, 500);

                // Auto hide after 5 seconds
                setTimeout(() => {
                    successNotification.classList.remove('show');
                    setTimeout(() => {
                        successNotification.remove();
                    }, 400);
                }, 5000);
            }

            // Focus effect for inputs
            const inputs = document.querySelectorAll('.form-input-custom');
            inputs.forEach(input => {
                input.addEventListener('focus', function () {
                    this.parentElement.style.transform = 'translateY(-2px)';
                });

                input.addEventListener('blur', function () {
                    this.parentElement.style.transform = '';
                });
            });

            // Loading state for save button
            const profileForm = document.getElementById('profileForm');
            const saveButton = document.getElementById('saveButton');

            profileForm.addEventListener('submit', function () {
                saveButton.classList.add('loading');
                saveButton.disabled = true;
            });

            // Delete account confirmation
            const deleteAccountButton = document.getElementById('deleteAccountButton');
            const confirmationModal = document.getElementById('confirmationModal');
            const cancelDelete = document.getElementById('cancelDelete');
            const deleteForm = document.getElementById('deleteForm');

            deleteAccountButton.addEventListener('click', function () {
                confirmationModal.classList.add('show');
            });

            cancelDelete.addEventListener('click', function () {
                confirmationModal.classList.remove('show');
            });

            // Close modal when clicking outside
            confirmationModal.addEventListener('click', function (e) {
                if (e.target === confirmationModal) {
                    confirmationModal.classList.remove('show');
                }
            });

            // Add shake animation to invalid inputs
            const invalidInputs = document.querySelectorAll('.form-input-custom.is-invalid');
            invalidInputs.forEach(input => {
                input.addEventListener('animationend', function () {
                    this.style.animation = '';
                });
            });

            // Real-time validation for name input
            const nameInput = document.getElementById('name');
            if (nameInput) {
                nameInput.addEventListener('input', function () {
                    if (this.value.trim().length < 2) {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                    }
                });
            }
        });
    </script>
@endsection
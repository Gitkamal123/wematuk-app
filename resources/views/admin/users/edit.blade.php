@extends('layouts.master')

@section('title', 'Ubah Role User - SiMatkul')

@section('content')
    <style>
        /* ===================== */
        /* EDIT ROLE STYLES      */
        /* ===================== */

        /* Scoping Wrapper - Agar tidak merusak navbar/sidebar master */
        .edit-role-wrapper {
            padding: 1rem 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        /* Header Animation */
        .edit-role-wrapper .edit-role-header {
            margin-bottom: 2rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }

        .edit-role-wrapper .edit-role-header.show {
            opacity: 1;
            transform: translateY(0);
        }

        .edit-role-wrapper .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #4a90e2;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .edit-role-wrapper .back-button:hover {
            color: #2b6cb0;
            transform: translateX(-3px);
        }

        .edit-role-wrapper .edit-role-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 0.5rem;
        }

        .edit-role-wrapper .edit-role-subtitle {
            color: #6c757d;
            font-size: 1rem;
        }

        /* User Info Card */
        .edit-role-wrapper .user-info-card {
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            color: #ffffff;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
            transition-delay: 0.1s;
            box-shadow: 0 8px 24px rgba(74, 144, 226, 0.3);
            border: none;
        }

        .edit-role-wrapper .user-info-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        .edit-role-wrapper .user-avatar {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .edit-role-wrapper .user-avatar svg {
            width: 40px;
            height: 40px;
            color: #ffffff;
        }

        .edit-role-wrapper .info-label {
            font-size: 0.85rem;
            opacity: 0.9;
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .edit-role-wrapper .info-value {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .edit-role-wrapper .custom-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.3);
            margin: 1.5rem 0;
        }

        /* Edit Form Card */
        .edit-role-wrapper .edit-form-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
            transition-delay: 0.2s;
            border: none;
        }

        .edit-role-wrapper .edit-form-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        .edit-role-wrapper .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .edit-role-wrapper .title-icon-wrapper {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        /* Custom Radio Styling */
        .edit-role-wrapper .role-options {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .edit-role-wrapper .role-option-item {
            position: relative;
            flex: 1;
            min-width: 200px;
        }

        .edit-role-wrapper .role-option-item input[type="radio"] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .edit-role-wrapper .role-label {
            display: block;
            padding: 1.5rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .edit-role-wrapper .role-label:hover {
            border-color: #4a90e2;
            background: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(74, 144, 226, 0.15);
        }

        .edit-role-wrapper .role-option-item input[type="radio"]:checked+.role-label {
            border-color: #4a90e2;
            background: rgba(74, 144, 226, 0.05);
            box-shadow: 0 4px 12px rgba(74, 144, 226, 0.2);
        }

        .edit-role-wrapper .role-icon-box {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            background: #e2e8f0;
            color: #718096;
        }

        .edit-role-wrapper .role-option-item input[type="radio"]:checked+.role-label .role-icon-box {
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
            color: #ffffff;
        }

        .edit-role-wrapper .role-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1a202c;
        }

        .edit-role-wrapper .check-mark {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 24px;
            height: 24px;
            color: #4a90e2;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .edit-role-wrapper .role-option-item input[type="radio"]:checked+.role-label .check-mark {
            opacity: 1;
        }

        /* Custom Button Styling */
        .edit-role-wrapper .custom-btn-group {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #f7fafc;
        }

        .edit-role-wrapper .btn-action {
            padding: 0.75rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .edit-role-wrapper .btn-save {
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
            color: #ffffff;
            border: none;
            box-shadow: 0 4px 14px rgba(74, 144, 226, 0.3);
        }

        .edit-role-wrapper .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
            color: white;
        }

        .edit-role-wrapper .btn-cancel {
            background: #f7fafc;
            color: #4a5568;
            border: 2px solid #e2e8f0;
        }

        .edit-role-wrapper .btn-cancel:hover {
            background: #edf2f7;
            border-color: #cbd5e0;
            transform: translateY(-2px);
            color: #2d3748;
        }

        /* Responsive Fixes */
        @media (max-width: 768px) {
            .edit-role-wrapper .role-options {
                flex-direction: column;
            }

            .edit-role-wrapper .custom-btn-group {
                flex-direction: column-reverse;
            }

            .edit-role-wrapper .btn-action {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="edit-role-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <div class="edit-role-header" id="editRoleHeader">
                        <a href="{{ route('admin.users.index') }}" class="back-button">
                            <i class="fas fa-arrow-left"></i>
                            Kembali ke Daftar User
                        </a>
                        <h1 class="edit-role-title">Ubah Role User</h1>
                        <p class="edit-role-subtitle">Kelola hak akses dan peran pengguna</p>
                    </div>

                    <div class="user-info-card" id="userInfoCard">
                        <div class="user-avatar">
                            <i class="fas fa-user fa-2x"></i>
                        </div>
                        <div class="mb-3">
                            <div class="info-label">Nama Lengkap</div>
                            <div class="info-value">{{ $user->name }}</div>
                        </div>
                        <div class="custom-divider"></div>
                        <div>
                            <div class="info-label">NRP</div>
                            <div class="info-value">{{ $user->nrp }}</div>
                        </div>
                    </div>

                    <div class="edit-form-card" id="editFormCard">
                        <h2 class="section-title">
                            <div class="title-icon-wrapper">
                                <i class="fas fa-user-tag"></i>
                            </div>
                            Pilih Role Baru
                        </h2>

                        <form action="{{ route('admin.users.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <div class="role-options">
                                    <div class="role-option-item">
                                        <input type="radio" name="role" id="role_user" value="user" {{ $user->role == 'user' ? 'checked' : '' }}>
                                        <label for="role_user" class="role-label">
                                            <i class="fas fa-check-circle check-mark"></i>
                                            <div class="role-icon-box">
                                                <i class="fas fa-user fa-lg"></i>
                                            </div>
                                            <div class="role-name">User Biasa</div>
                                        </label>
                                    </div>

                                    <div class="role-option-item">
                                        <input type="radio" name="role" id="role_admin" value="admin" {{ $user->role == 'admin' ? 'checked' : '' }}>
                                        <label for="role_admin" class="role-label">
                                            <i class="fas fa-check-circle check-mark"></i>
                                            <div class="role-icon-box">
                                                <i class="fas fa-crown fa-lg"></i>
                                            </div>
                                            <div class="role-name">Administrator</div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="custom-btn-group">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-action btn-cancel">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-action btn-save">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Animasi masuk (Sequence)
            const header = document.getElementById('editRoleHeader');
            const userInfoCard = document.getElementById('userInfoCard');
            const formCard = document.getElementById('editFormCard');

            // Set timeout berurutan agar halus
            setTimeout(() => header.classList.add('show'), 100);
            setTimeout(() => userInfoCard.classList.add('show'), 200);
            setTimeout(() => formCard.classList.add('show'), 300);

            // Efek hover tambahan untuk kartu
            const cards = document.querySelectorAll('.edit-form-card, .user-info-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function () {
                    if (this.classList.contains('edit-form-card')) {
                        this.style.transform = 'translateY(-5px)';
                    }
                });
                card.addEventListener('mouseleave', function () {
                    if (this.classList.contains('edit-form-card')) {
                        this.style.transform = 'translateY(0)';
                    }
                });
            });
        });
    </script>
@endsection
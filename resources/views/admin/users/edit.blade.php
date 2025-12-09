@extends('layouts.master')

@section('title', 'Ubah Role User - TaskA')

@section('content')
    <style>
        /* ===================== */
        /* EDIT ROLE PAGE        */
        /* ===================== */

        body {
            background: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .edit-role-container {
            padding: 2rem 0;
        }

        /* Header */
        .edit-role-header {
            margin-bottom: 2rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }

        .edit-role-header.show {
            opacity: 1;
            transform: translateY(0);
        }

        .back-button {
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

        .back-button:hover {
            color: #2b6cb0;
            transform: translateX(-3px);
        }

        .edit-role-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 0.5rem;
        }

        .edit-role-subtitle {
            color: #718096;
            font-size: 1rem;
        }

        /* User Info Card */
        .user-info-card {
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
        }

        .user-info-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .user-avatar svg {
            width: 40px;
            height: 40px;
            color: #ffffff;
        }

        .user-info-item {
            margin-bottom: 1rem;
        }

        .user-info-item:last-child {
            margin-bottom: 0;
        }

        .user-info-label {
            font-size: 0.85rem;
            opacity: 0.9;
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .user-info-value {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.3);
            margin: 1.5rem 0;
        }

        /* Edit Form Card */
        .edit-form-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
            transition-delay: 0.2s;
        }

        .edit-form-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        .form-section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .title-icon-wrapper {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .title-icon-wrapper svg {
            width: 20px;
            height: 20px;
            color: #ffffff;
        }

        /* Form Elements */
        .form-group-custom {
            margin-bottom: 2rem;
        }

        .form-label-custom {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.75rem;
        }

        .label-required {
            color: #e53e3e;
        }

        /* Custom Radio Buttons */
        .role-options {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .role-option {
            position: relative;
            flex: 1;
            min-width: 200px;
        }

        .role-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .role-label {
            display: block;
            padding: 1.5rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f7fafc;
        }

        .role-label:hover {
            border-color: #4a90e2;
            background: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(74, 144, 226, 0.15);
        }

        .role-option input[type="radio"]:checked+.role-label {
            border-color: #4a90e2;
            background: rgba(74, 144, 226, 0.05);
            box-shadow: 0 4px 12px rgba(74, 144, 226, 0.2);
        }

        .role-icon-wrapper {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .role-option input[type="radio"]:checked+.role-label .role-icon-wrapper {
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
        }

        .role-option input[type="radio"]:not(:checked)+.role-label .role-icon-wrapper {
            background: #e2e8f0;
        }

        .role-icon {
            width: 24px;
            height: 24px;
            transition: all 0.3s ease;
        }

        .role-option input[type="radio"]:checked+.role-label .role-icon {
            color: #ffffff;
        }

        .role-option input[type="radio"]:not(:checked)+.role-label .role-icon {
            color: #718096;
        }

        .role-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 0.25rem;
        }

        .role-description {
            font-size: 0.85rem;
            color: #718096;
        }

        .check-icon {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 24px;
            height: 24px;
            color: #4a90e2;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .role-option input[type="radio"]:checked+.role-label .check-icon {
            opacity: 1;
        }

        /* Buttons */
        .button-group {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #f7fafc;
        }

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
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(74, 144, 226, 0.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
        }

        .btn-secondary-custom {
            background: #f7fafc;
            color: #4a5568;
            border: 2px solid #e2e8f0;
        }

        .btn-secondary-custom:hover {
            background: #edf2f7;
            border-color: #cbd5e0;
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .edit-form-card {
                padding: 1.5rem;
            }

            .edit-role-title {
                font-size: 1.5rem;
            }

            .role-options {
                flex-direction: column;
            }

            .button-group {
                flex-direction: column-reverse;
            }

            .btn-custom {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="edit-role-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <!-- Header -->
                    <div class="edit-role-header" id="editRoleHeader">
                        <a href="{{ route('admin.users.index') }}" class="back-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                            </svg>
                            Kembali ke Daftar User
                        </a>
                        <h1 class="edit-role-title">Ubah Role User</h1>
                        <p class="edit-role-subtitle">Kelola hak akses dan peran pengguna</p>
                    </div>

                    <!-- User Info Card -->
                    <div class="user-info-card" id="userInfoCard">
                        <div class="user-avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                <path fill-rule="evenodd"
                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                            </svg>
                        </div>
                        <div class="user-info-item">
                            <div class="user-info-label">Nama Lengkap</div>
                            <div class="user-info-value">{{ $user->name }}</div>
                        </div>
                        <div class="divider"></div>
                        <div class="user-info-item">
                            <div class="user-info-label">NRP</div>
                            <div class="user-info-value">{{ $user->nrp }}</div>
                        </div>
                    </div>

                    <!-- Edit Form Card -->
                    <div class="edit-form-card" id="editFormCard">
                        <h2 class="form-section-title">
                            <div class="title-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                    <path
                                        d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
                                </svg>
                            </div>
                            Ubah Role
                        </h2>

                        <form action="{{ route('admin.users.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group-custom">
                                <div class="role-options">
                                    <!-- User Role -->
                                    <div class="role-option">
                                        <input type="radio" name="role" id="role_user" value="user" {{ $user->role == 'user' ? 'checked' : '' }}>
                                        <label for="role_user" class="role-label">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="check-icon" fill="currentColor"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                            </svg>
                                            <div class="role-icon-wrapper">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="role-icon"
                                                    fill="currentColor" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
                                                </svg>
                                            </div>
                                            <div class="role-title">User biasa</div>                                            
                                        </label>
                                    </div>

                                    <!-- Admin Role -->
                                    <div class="role-option">
                                        <input type="radio" name="role" id="role_admin" value="admin" {{ $user->role == 'admin' ? 'checked' : '' }}>
                                        <label for="role_admin" class="role-label">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="check-icon" fill="currentColor"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                            </svg>
                                            <div class="role-icon-wrapper">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="role-icon"
                                                    fill="currentColor" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
                                                </svg>
                                            </div>
                                            <div class="role-title">Administrator</div>                                            
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Button Group -->
                            <div class="button-group">
                                <a href="{{ route('admin.users.index') }}" class="btn-custom btn-secondary-custom">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path
                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                    </svg>
                                    Batal
                                </a>
                                <button type="submit" class="btn-custom btn-primary-custom">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z" />
                                    </svg>
                                    Simpan Perubahan
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
            // Entrance animations
            const header = document.getElementById('editRoleHeader');
            const userInfoCard = document.getElementById('userInfoCard');
            const formCard = document.getElementById('editFormCard');

            setTimeout(() => header.classList.add('show'), 100);
            setTimeout(() => userInfoCard.classList.add('show'), 200);
            setTimeout(() => formCard.classList.add('show'), 300);
        });
    </script>
@endsection
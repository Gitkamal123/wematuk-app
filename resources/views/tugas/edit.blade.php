@extends('layouts.master')

@section('title', 'Edit Tugas - TaskA')

@section('content')
    <style>
        /* ===================== */
        /* EDIT TUGAS PAGE       */
        /* ===================== */

        body {
            background: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .edit-container {
            padding: 2rem 0;
        }

        /* Header */
        .edit-header {
            margin-bottom: 2rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }

        .edit-header.show {
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

        .edit-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 0.5rem;
        }

        .edit-subtitle {
            color: #718096;
            font-size: 1rem;
        }

        /* Edit Card */
        .edit-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
            transition-delay: 0.1s;
        }

        .edit-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Form Elements */
        .form-group-custom {
            margin-bottom: 1.75rem;
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
            padding: 0.75rem 1rem;
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

        .form-textarea-custom {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.3s ease;
            background: #f7fafc;
            resize: vertical;
            min-height: 120px;
        }

        .form-textarea-custom:focus {
            outline: none;
            border-color: #4a90e2;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        /* File Upload */
        .file-upload-wrapper {
            position: relative;
        }

        .file-input-custom {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            border: 2px dashed #e2e8f0;
            border-radius: 12px;
            background: #f7fafc;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-input-custom:hover {
            border-color: #4a90e2;
            background: #ffffff;
        }

        .file-input-custom:focus {
            outline: none;
            border-color: #4a90e2;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        .current-file {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.75rem;
            padding: 0.5rem 1rem;
            background: rgba(74, 144, 226, 0.1);
            border-radius: 8px;
            font-size: 0.85rem;
            color: #4a90e2;
        }

        .current-file a {
            color: #4a90e2;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .current-file a:hover {
            color: #2b6cb0;
            text-decoration: underline;
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
            .edit-card {
                padding: 1.5rem;
            }

            .edit-title {
                font-size: 1.5rem;
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

    <div class="edit-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <!-- Header -->
                    <div class="edit-header" id="editHeader">
                        <a href="{{ route('home') }}" class="back-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                            </svg>
                            Kembali ke Daftar Tugas
                        </a>
                        <h1 class="edit-title">Edit Tugas</h1>
                        <p class="edit-subtitle">Perbarui informasi tugas Anda</p>
                    </div>

                    <!-- Edit Form Card -->
                    <div class="edit-card" id="editCard">
                        <form action="{{ route('tugas.update', $tugas) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Judul Tugas -->
                            <div class="form-group-custom">
                                <label for="judul" class="form-label-custom">
                                    Judul Tugas <span class="label-required">*</span>
                                </label>
                                <input type="text" class="form-input-custom @error('judul') is-invalid @enderror" id="judul"
                                    name="judul" value="{{ old('judul', $tugas->judul) }}" required
                                    placeholder="Masukkan judul tugas">
                                @error('judul')
                                    <small class="help-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="form-group-custom">
                                <label for="deskripsi" class="form-label-custom">
                                    Deskripsi
                                </label>
                                <textarea class="form-textarea-custom @error('deskripsi') is-invalid @enderror"
                                    id="deskripsi" name="deskripsi"
                                    placeholder="Masukkan deskripsi tugas (opsional)">{{ old('deskripsi', $tugas->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <small class="help-text text-danger">{{ $message }}</small>
                                @enderror
                                <small class="help-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                        viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path
                                            d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                    </svg>
                                    Deskripsi membantu Anda mengingat detail tugas
                                </small>
                            </div>

                            <!-- Deadline -->
                            <div class="form-group-custom">
                                <label for="deadline" class="form-label-custom">
                                    Deadline <span class="label-required">*</span>
                                </label>
                                <input type="datetime-local"
                                    class="form-input-custom @error('deadline') is-invalid @enderror" id="deadline"
                                    name="deadline" value="{{ old('deadline', $tugas->deadline) }}" required>
                                @error('deadline')
                                    <small class="help-text text-danger">{{ $message }}</small>
                                @enderror
                                <small class="help-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                    </svg>
                                    Tentukan kapan tugas ini harus selesai
                                </small>
                            </div>

                            <!-- File Upload -->
                            <div class="form-group-custom">
                                <label for="file_tugas" class="form-label-custom">
                                    Upload File Baru
                                </label>
                                <input class="file-input-custom @error('file_tugas') is-invalid @enderror" type="file"
                                    id="file_tugas" name="file_tugas">
                                @error('file_tugas')
                                    <small class="help-text text-danger">{{ $message }}</small>
                                @enderror

                                @if($tugas->file_path)
                                    <span>File saat ini:
                                        <a href="{{ route('tugas.preview', $tugas->id) }}" target="_blank"
                                            class="text-decoration-none fw-bold text-primary">
                                            Lihat File
                                        </a>
                                    </span>
                                @endif

                                <small class="help-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                        viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path
                                            d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                    </svg>
                                    Upload file baru jika ingin mengganti file lama (opsional)
                                </small>
                            </div>

                            <!-- Button Group -->
                            <div class="button-group">
                                <a href="{{ route('home') }}" class="btn-custom btn-secondary-custom">
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
            const header = document.getElementById('editHeader');
            const card = document.getElementById('editCard');

            setTimeout(() => {
                header.classList.add('show');
            }, 100);

            setTimeout(() => {
                card.classList.add('show');
            }, 200);

            // Focus effect for inputs
            const inputs = document.querySelectorAll('.form-input-custom, .form-textarea-custom, .file-input-custom');
            inputs.forEach(input => {
                input.addEventListener('focus', function () {
                    this.style.transform = 'scale(1.01)';
                });

                input.addEventListener('blur', function () {
                    this.style.transform = '';
                });
            });

            // File input preview name
            const fileInput = document.getElementById('file_tugas');
            if (fileInput) {
                fileInput.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        const fileName = this.files[0].name;
                        console.log('File dipilih:', fileName);
                    }
                });
            }
        });
    </script>
@endsection
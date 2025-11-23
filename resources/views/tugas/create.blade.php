@extends('layouts.master')

@section('title', 'Tambah Tugas Baru')

@section('content')
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-2 gradient-text">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                    class="bi bi-plus-circle-fill me-2" viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                </svg>
                Tambah Tugas Baru
            </h2>           
        </div>
        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-with-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-2"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg form-card">
                <div class="card-header gradient-header text-white py-4">
                    <h5 class="mb-0 fw-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                            class="bi bi-pencil-square me-2" viewBox="0 0 16 16">
                            <path
                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                            <path fill-rule="evenodd"
                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                        </svg>
                        Formulir Tugas Baru
                    </h5>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('tugas.store') }}" method="POST" enctype="multipart/form-data" id="tugasForm">
                        @csrf

                        <!-- Judul Tugas -->
                        <div class="mb-4 form-field">
                            <label for="judul" class="form-label fw-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                    class="bi bi-card-heading me-2" viewBox="0 0 16 16">
                                    <path
                                        d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z" />
                                    <path
                                        d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0-5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5z" />
                                </svg>
                                Judul
                                <span class="text-primary">*</span>
                            </label>
                            <input type="text" class="form-control form-control-lg @error('judul') is-invalid @enderror"
                                id="judul" name="judul" placeholder="Masukkan judul tugas..." value="{{ old('judul') }}"
                                required maxlength="255">
                            <div class="d-flex justify-content-between mt-2">                                
                                <small class="text-muted"><span id="judulCounter">0</span>/255 karakter</small>
                            </div>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4 form-field">
                            <label for="deskripsi" class="form-label fw-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                    class="bi bi-text-paragraph me-2" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m4-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5" />
                                </svg>
                                Deskripsi
                            </label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi"
                                name="deskripsi" rows="5" maxlength="1000"
                                placeholder="Masukkan deskripsi tugas (opsional)...">{{ old('deskripsi') }}</textarea>
                            <div class="d-flex justify-content-between mt-2">                                
                                <small class="text-muted"><span id="deskripsiCounter">0</span>/1000 karakter</small>
                            </div>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deadline -->
                        <div class="mb-4 form-field">
                            <label for="deadline" class="form-label fw-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                    class="bi bi-calendar-event me-2" viewBox="0 0 16 16">
                                    <path
                                        d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z" />
                                    <path
                                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                </svg>
                                Batas Waktu (Deadline)
                                <span class="text-primary">*</span>
                            </label>
                            <input type="datetime-local" class="form-control @error('deadline') is-invalid @enderror"
                                id="deadline" name="deadline" value="{{ old('deadline') }}" required>
                            @error('deadline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror                           
                        </div>

                        <!-- Upload File -->
                        <div class="mb-4 form-field">
                            <label for="file_tugas" class="form-label fw-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                    class="bi bi-paperclip me-2" viewBox="0 0 16 16">
                                    <path
                                        d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0z" />
                                </svg>
                                Lampiran File
                            </label>
                            <div class="file-upload-area" id="fileUploadArea">
                                <div class="file-upload-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                        class="bi bi-cloud-upload mb-3" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z" />
                                        <path fill-rule="evenodd"
                                            d="M7.646 4.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V14.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3z" />
                                    </svg>
                                    <p class="mb-2 fw-medium">Upload file pendukung (opsional)</p>
                                    <p class="text-muted small">PDF, Word, Excel, PPT, ZIP, RAR (Maks. 10MB)</p>
                                </div>
                                <input class="form-control d-none @error('file_tugas') is-invalid @enderror" type="file"
                                    id="file_tugas" name="file_tugas"
                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar">
                            </div>
                            <div class="mt-3" id="filePreview"></div>
                            @error('file_tugas')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Info Box -->
                        <div class="alert alert-blue-gradient border-0 d-flex align-items-start mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                class="bi bi-info-circle-fill me-3 mt-1 flex-shrink-0" viewBox="0 0 16 16">
                                <path
                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2" />
                            </svg>
                            <div>
                                <strong class="d-block mb-1">Note:</strong>                                
                                Field yang bertanda <span class="text-primary fw-bold">*</span> wajib diisi.                 
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 justify-content-end pt-4 border-top">
                            <a href="{{ route('home') }}" class="btn btn-lg btn-outline-primary px-4 btn-with-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-x-lg me-2" viewBox="0 0 16 16">
                                    <path
                                        d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                </svg>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-lg btn-primary px-4 btn-gradient" id="submitBtn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-check-lg me-2" viewBox="0 0 16 16">
                                    <path
                                        d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z" />
                                </svg>
                                Simpan Tugas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-blue: #0d6efd;
            --light-blue: #e3f2fd;
            --medium-blue: #90caf9;
            --dark-blue: #0d47a1;
            --gradient-start: #1e3c72;
            --gradient-end: #2a5298;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e3f2fd 100%);
            min-height: 100vh;
        }

        .gradient-text {
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .form-card {
            border-radius: 16px;
            overflow: hidden;
            background: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(13, 110, 253, 0.15) !important;
        }

        .gradient-header {
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            border: none;
        }

        .form-field {
            position: relative;
            padding: 1.5rem;
            background: #fafbfc;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary-blue);
            transition: all 0.3s ease;
        }

        .form-field:hover {
            background: #f0f7ff;
            transform: translateX(5px);
        }

        .form-control,
        .form-select {
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
            background: white;
        }

        .form-label {
            margin-bottom: 0.75rem;
            color: var(--dark-blue);
            font-weight: 600;
        }

        .file-upload-area {
            border: 2px dashed #c5d9f1;
            border-radius: 12px;
            padding: 2.5rem 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f8fbff;
        }

        .file-upload-area:hover {
            border-color: var(--primary-blue);
            background: #f0f7ff;
            transform: scale(1.02);
        }

        .file-upload-placeholder {
            color: #6c757d;
        }

        .file-preview {
            padding: 1rem;
            border-radius: 8px;
            background: linear-gradient(135deg, #e3f2fd, #f0f7ff);
            border: 1px solid #c5d9f1;
        }

        .file-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .file-icon {
            font-size: 28px;
        }

        .file-details {
            flex: 1;
        }

        .file-name {
            font-weight: 600;
            margin-bottom: 4px;
            color: var(--dark-blue);
        }

        .file-size {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .remove-file {
            cursor: pointer;
            color: #dc3545;
            transition: color 0.3s ease;
        }

        .remove-file:hover {
            color: #bd2130;
        }

        .alert-blue-gradient {
            background: linear-gradient(135deg, #e3f2fd, #f0f7ff);
            border: 1px solid #c5d9f1;
            color: #0d47a1;
            border-radius: 12px;
        }

        .btn-gradient {
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            border: none;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(13, 110, 253, 0.3);
            background: linear-gradient(135deg, var(--gradient-end), var(--gradient-start));
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--primary-blue);
            color: white;
            transform: translateY(-2px);
        }

        .btn-with-icon {
            display: inline-flex;
            align-items: center;
        }

        .invalid-feedback {
            color: #dc3545;
            font-weight: 500;
            margin-top: 0.5rem;
        }

        .text-primary {
            color: var(--primary-blue) !important;
        }

        .border-top {
            border-top: 1px solid #e1e5e9 !important;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-field {
            animation: fadeIn 0.5s ease forwards;
        }

        .form-field:nth-child(1) {
            animation-delay: 0.1s;
        }

        .form-field:nth-child(2) {
            animation-delay: 0.2s;
        }

        .form-field:nth-child(3) {
            animation-delay: 0.3s;
        }

        .form-field:nth-child(4) {
            animation-delay: 0.4s;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Character counters
            const judulInput = document.getElementById('judul');
            const deskripsiInput = document.getElementById('deskripsi');
            const judulCounter = document.getElementById('judulCounter');
            const deskripsiCounter = document.getElementById('deskripsiCounter');

            judulInput.addEventListener('input', function () {
                judulCounter.textContent = this.value.length;
            });

            deskripsiInput.addEventListener('input', function () {
                deskripsiCounter.textContent = this.value.length;
            });

            // Initialize counters with current values
            judulCounter.textContent = judulInput.value.length;
            deskripsiCounter.textContent = deskripsiInput.value.length;

            // File upload area functionality
            const fileUploadArea = document.getElementById('fileUploadArea');
            const fileInput = document.getElementById('file_tugas');
            const filePreview = document.getElementById('filePreview');

            fileUploadArea.addEventListener('click', function () {
                fileInput.click();
            });

            fileInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    const fileSize = (file.size / 1024 / 1024).toFixed(2); // Convert to MB

                    // Check file size (max 10MB)
                    if (file.size > 10 * 1024 * 1024) {
                        alert('File terlalu besar. Maksimal ukuran file adalah 10MB.');
                        this.value = '';
                        filePreview.innerHTML = '';
                        return;
                    }

                    // Get file icon based on extension
                    const fileExt = file.name.split('.').pop().toLowerCase();
                    let fileIcon = '📄';
                    let fileType = 'Document';

                    if (['pdf'].includes(fileExt)) {
                        fileIcon = '📕';
                        fileType = 'PDF';
                    } else if (['doc', 'docx'].includes(fileExt)) {
                        fileIcon = '📘';
                        fileType = 'Word';
                    } else if (['xls', 'xlsx'].includes(fileExt)) {
                        fileIcon = '📗';
                        fileType = 'Excel';
                    } else if (['ppt', 'pptx'].includes(fileExt)) {
                        fileIcon = '📙';
                        fileType = 'PowerPoint';
                    } else if (['zip', 'rar'].includes(fileExt)) {
                        fileIcon = '📦';
                        fileType = 'Archive';
                    }

                    filePreview.innerHTML = `
                            <div class="file-preview">
                                <div class="file-info">
                                    <div class="file-icon">${fileIcon}</div>
                                    <div class="file-details">
                                        <div class="file-name">${file.name}</div>
                                        <div class="file-size">${fileSize} MB • ${fileType}</div>
                                    </div>
                                    <div class="remove-file" onclick="clearFileInput()" title="Hapus file">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        `;

                    // Update upload area appearance
                    fileUploadArea.style.borderColor = 'var(--primary-blue)';
                    fileUploadArea.style.background = '#f0f7ff';
                } else {
                    filePreview.innerHTML = '';
                    fileUploadArea.style.borderColor = '#c5d9f1';
                    fileUploadArea.style.background = '#f8fbff';
                }
            });

            // Set minimum datetime to current time
            const now = new Date();
            const timezoneOffset = now.getTimezoneOffset() * 60000; // Offset in milliseconds
            const localISOTime = new Date(now - timezoneOffset).toISOString().slice(0, 16);
            document.getElementById('deadline').min = localISOTime;

            // Form submission handling
            const form = document.getElementById('tugasForm');
            const submitBtn = document.getElementById('submitBtn');

            form.addEventListener('submit', function (e) {
                // Validate deadline is in the future
                const deadlineInput = document.getElementById('deadline');
                const deadlineValue = new Date(deadlineInput.value);

                if (deadlineValue <= now) {
                    e.preventDefault();
                    alert('Batas waktu harus di masa depan.');
                    deadlineInput.focus();
                    return;
                }

                // Change button text and disable during submission
                submitBtn.innerHTML = `
                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                        Menyimpan...
                    `;
                submitBtn.disabled = true;
            });
        });

        function clearFileInput() {
            document.getElementById('file_tugas').value = '';
            document.getElementById('filePreview').innerHTML = '';
            document.getElementById('fileUploadArea').style.borderColor = '#c5d9f1';
            document.getElementById('fileUploadArea').style.background = '#f8fbff';
        }
    </script>
@endsection
@extends('layouts.master')

@section('title', 'Keranjang Sampah - SiMatkul')

@section('content')
    {{-- SweetAlert2 untuk notifikasi --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        /* --- 1. ANIMASI MASUK --- */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 40px, 0);
            }

            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        .trash-container {
            padding: 2rem 0;
            max-width: 1400px;
            margin: 0 auto;
            animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        /* Header & Buttons */
        .trash-header {
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .trash-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1a202c;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0;
        }

        .title-icon {
            width: 35px;
            height: 35px;
            color: #e53e3e;
        }

        /* --- 2. UPDATE TOMBOL & HOVER --- */
        .btn-custom {
            padding: 0.6rem 1.2rem;
            border-radius: 10px;
            font-weight: 600;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.7s ease;
        }
        
        .btn-danger-custom {
            background: #e53e3e;
            color: white;
            box-shadow: 0 4px 6px rgba(229, 62, 62, 0.3);
        }

        .btn-danger-custom:hover {
            background: #c53030;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(229, 62, 62, 0.4);
        }

        /* Tombol Kembali (Biru Gradasi ke Putih) */
        .btn-back {
            background: linear-gradient(135deg, #4a90e2 0%, #3182ce 100%);
            color: #ffffff;
            border: 2px solid transparent;
            box-shadow: 0 4px 6px rgba(74, 144, 226, 0.3);
        }

        .btn-back:hover {
            background: #ffffff;
            color: #3182ce;
            border-color: #3182ce;
            transform: translateX(-5px);
            /* Geser kiri */
            box-shadow: 0 6px 12px rgba(74, 144, 226, 0.2);
        }

        /* Card & Table */
        .table-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-top: 1.5rem;
            /* HAPUS TRANSISI DI SINI AGAR KOTAK TABEL DIAM */
        }

        .table-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-custom th {
            background: linear-gradient(180deg, #f7fafc 0%, #edf2f7 100%);
            padding: 1.25rem 1.5rem;
            text-align: left;
            font-size: 0.85rem;
            text-transform: uppercase;
            color: #4a5568;
            font-weight: 700;
            border-bottom: 2px solid #e2e8f0;
            cursor: default;
            /* Kursor biasa saat di header */
        }

        .table-custom td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #edf2f7;
            vertical-align: middle;
            background-color: #ffffff;            
            transition: background-color 0.3s ease;
        }

        .table-custom tbody tr {
            transition: all 0.7s ease;  
            cursor: default;            
        }

        /* Saat mouse di atas baris data */
        .table-custom tbody tr:hover td {
            background-color: #f8fafc;
            /* Ubah warna background cell */
        }

        .table-custom tbody tr:hover {
            transform: scale(1.01);
            /* Zoom sedikit barisnya */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            /* Bayangan lebih menonjol */
            position: relative;
            /* Agar bayangan terlihat di atas baris lain */
            z-index: 10;
        }

        /* Content Styling */
        .task-item {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .task-icon-wrapper {
            width: 40px;
            height: 40px;
            background: #fff5f5;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e53e3e;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }
        
        .table-custom tbody tr:hover .task-icon-wrapper {
            transform: rotate(15deg);
        }

        .task-info strong {
            display: block;
            color: #2d3748;
            font-size: 1rem;
        }

        .task-info small {
            color: #718096;
            font-size: 0.85rem;
        }

        .badge-date {
            background: #ebf8ff;
            color: #3182ce;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .text-deleted {
            color: #e53e3e;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Actions */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            transition: all 0.3s ease;
        }

        .btn-restore {
            background: #f0fff4;
            color: #38a169;
        }

        .btn-restore:hover {
            background: #38a169;
            color: white;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: #fff5f5;
            color: #e53e3e;
        }

        .btn-delete:hover {
            background: #e53e3e;
            color: white;
            transform: translateY(-2px);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 1rem;
        }

        .empty-icon {
            width: 64px;
            height: 64px;
            color: #cbd5e0;
            margin-bottom: 1rem;
        }

        /* Modal Custom */
        .modal-header-danger {
            background: linear-gradient(135deg, #e53e3e, #c53030);
            color: white;
            border-radius: 16px 16px 0 0;
        }

        .modal-content {
            border-radius: 16px;
            border: none;
        }
    </style>

    <div class="trash-container">
        <div class="container-fluid">

            <div class="trash-header">
                <h1 class="trash-title">
                    <svg xmlns="http://www.w3.org/2000/svg" class="title-icon" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                    </svg>
                    Keranjang Sampah
                </h1>

                <div class="header-actions">
                    <a href="{{ route('home') }}" class="btn-custom btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                    </a>

                    @if($tugas->isNotEmpty())
                        <button type="button" class="btn-custom btn-danger-custom" data-bs-toggle="modal"
                            data-bs-target="#clearAllModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                <path fill-rule="evenodd"
                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                            </svg>
                            Kosongkan Semua
                        </button>
                    @endif
                </div>
            </div>

            <div class="table-card">
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>Judul Tugas</th>
                                <th>Deadline</th>
                                <th>Dihapus Pada</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tugas as $t)
                                <tr>
                                    <td>
                                        <div class="task-item">
                                            <div class="task-icon-wrapper">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    fill="currentColor" viewBox="0 0 16 16">
                                                    <path
                                                        d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z" />
                                                </svg>
                                            </div>
                                            <div class="task-info">
                                                {{-- Pastikan nama kolom sesuai DB (misal: judul atau tugas) --}}
                                                <strong>{{ $t->judul ?? $t->tugas }}</strong>
                                                <small>{{ Str::limit($t->deskripsi, 40) }}</small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge-date">
                                            {{ \Carbon\Carbon::parse($t->deadline)->format('d M Y, H:i') }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="text-deleted">
                                            {{ $t->deleted_at->diffForHumans() }}
                                        </div>
                                    </td>

                                    <td>
                                        <div class="action-buttons">
                                            <form action="{{ route('tugas.restore', $t->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <button type="submit" class="btn-action btn-restore" title="Pulihkan">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2z" />
                                                        <path
                                                            d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z" />
                                                    </svg>
                                                    Pulihkan
                                                </button>
                                            </form>

                                            <button type="button" class="btn-action btn-delete" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $t->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" viewBox="0 0 16 16">
                                                    <path
                                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                    <path fill-rule="evenodd"
                                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </div>

                                        <div class="modal fade" id="deleteModal{{ $t->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header modal-header-danger">
                                                        <h5 class="modal-title fw-bold text-white">Hapus Permanen?</h5>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-center p-4">
                                                        <p class="mb-2">Anda yakin ingin menghapus tugas ini selamanya?</p>
                                                        <h5 class="fw-bold text-danger">{{ $t->judul ?? $t->tugas }}</h5>
                                                        <small class="text-muted">Data yang dihapus tidak bisa kembali!</small>
                                                    </div>
                                                    <div class="modal-footer justify-content-center border-0 pb-4">
                                                        <button type="button" class="btn btn-light border"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('tugas.forceDelete', $t->id) }}" method="POST">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="empty-icon" fill="currentColor"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z" />
                                            </svg>
                                            <h3 style="font-size: 1.25rem; font-weight: 600; color: #4a5568;">Sampah Kosong</h3>
                                            <p style="color: #718096;">Tidak ada tugas yang dihapus.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($tugas->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $tugas->links() }}
                </div>
            @endif

        </div>
    </div>

    @if($tugas->isNotEmpty())
        <div class="modal fade" id="clearAllModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                        <h5 class="modal-title fw-bold text-white">Kosongkan Sampah?</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        <p class="fw-bold mb-2">PERINGATAN!</p>
                        <p>Semua tugas di sampah akan dihapus permanen dan tidak bisa dikembalikan.</p>
                    </div>
                    <div class="modal-footer justify-content-center border-0 pb-4">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('tugas.clearTrash') }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger">Ya, Kosongkan Semua</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
@extends('layouts.master')

@section('title', 'Keranjang Sampah - WeMaTuK')

@section('content')
    <style>
        /* ===================== */
        /* KERANJANG SAMPAH      */
        /* ===================== */

        body {
            background: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .trash-container {
            padding: 2rem 0;
        }

        /* Header */
        .trash-header {
            margin-bottom: 2rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }

        .trash-header.show {
            opacity: 1;
            transform: translateY(0);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .trash-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1a202c;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .title-icon {
            width: 35px;
            height: 35px;
            color: #e53e3e;
        }

        .header-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn-custom {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-danger-custom {
            background: #e53e3e;
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(229, 62, 62, 0.3);
        }

        .btn-danger-custom:hover {
            background: #c53030;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(229, 62, 62, 0.4);
            color: #ffffff;
        }

        .btn-back {
            background: #f7fafc;
            color: #4a5568;
            border: 2px solid #e2e8f0;
        }

        .btn-back:hover {
            background: #edf2f7;
            border-color: #cbd5e0;
            transform: translateY(-2px);
            color: #2d3748;
        }

        /* Info Card */
        .info-card {
            background: rgba(74, 144, 226, 0.1);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
            transition-delay: 0.1s;
        }

        .info-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        .info-icon {
            width: 24px;
            height: 24px;
            color: #4a90e2;
            flex-shrink: 0;
        }

        .info-text {
            color: #2d3748;
            font-size: 0.95rem;
        }

        /* Table Card */
        .table-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 0;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            margin-bottom: 1.5rem;
            overflow: hidden;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
            transition-delay: 0.2s;
        }

        .table-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        .table-custom {
            width: 100%;
            margin: 0;
        }

        .table-custom thead {
            background: #f7fafc;
        }

        .table-custom thead th {
            color: #2d3748;
            font-weight: 600;
            padding: 1rem 1.5rem;
            border: none;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-custom tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f7fafc;
        }

        .table-custom tbody tr:hover {
            background: #f7fafc;
        }

        .table-custom tbody td {
            padding: 1.25rem 1.5rem;
            vertical-align: middle;
            color: #2d3748;
        }

        /* Task Item */
        .task-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .task-icon-wrapper {
            width: 40px;
            height: 40px;
            background: rgba(229, 62, 62, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .task-icon {
            width: 20px;
            height: 20px;
            color: #e53e3e;
        }

        .task-info strong {
            display: block;
            color: #1a202c;
            margin-bottom: 0.25rem;
        }

        .task-info small {
            color: #718096;
            font-size: 0.85rem;
        }

        /* Badges */
        .deadline-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.375rem 0.75rem;
            background: rgba(113, 128, 150, 0.1);
            color: #718096;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .deleted-time {
            display: block;
            color: #718096;
            font-size: 0.85rem;
            margin-bottom: 0.25rem;
        }

        .deleted-relative {
            display: block;
            color: #a0aec0;
            font-size: 0.8rem;
            font-style: italic;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        .btn-action {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .btn-restore {
            background: rgba(72, 187, 120, 0.1);
            color: #48bb78;
        }

        .btn-restore:hover {
            background: #48bb78;
            color: #ffffff;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: rgba(229, 62, 62, 0.1);
            color: #e53e3e;
        }

        .btn-delete:hover {
            background: #e53e3e;
            color: #ffffff;
            transform: translateY(-2px);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 1rem;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            color: #cbd5e0;
        }

        .empty-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .empty-text {
            color: #718096;
        }

        /* Modal */
        .modal-content {
            border-radius: 16px;
            border: none;
        }

        .modal-header-danger {
            background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
            color: #ffffff;
            border-radius: 16px 16px 0 0;
            padding: 1.5rem;
        }

        .modal-title-custom {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
        }

        .modal-body-custom {
            padding: 2rem;
        }

        .alert-danger-custom {
            background: rgba(229, 62, 62, 0.1);
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
            margin-bottom: 0;
        }

        .modal-footer-custom {
            padding: 1.5rem;
            border-top: 1px solid #f7fafc;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .trash-title {
                font-size: 1.5rem;
            }

            .header-content {
                flex-direction: column;
                align-items: stretch;
            }

            .header-actions {
                width: 100%;
            }

            .btn-custom {
                flex: 1;
                justify-content: center;
            }

            .table-card {
                overflow-x: auto;
            }

            .table-custom {
                min-width: 700px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="trash-container">
        <div class="container-fluid">

            <!-- Header -->
            <div class="trash-header" id="trashHeader">
                <div class="header-content">
                    <h1 class="trash-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="title-icon" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                        </svg>
                        Keranjang Sampah
                    </h1>
                    <div class="header-actions">
                        @if($tugas->isNotEmpty())
                            <button type="button" class="btn-custom btn-danger-custom" data-bs-toggle="modal"
                                data-bs-target="#clearTrashModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                </svg>
                                Kosongkan Semua
                            </button>
                        @endif
                        <a href="{{ route('home') }}" class="btn-custom btn-back">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            @if($tugas->isNotEmpty())
                <div class="info-card" id="infoCard">
                    <svg xmlns="http://www.w3.org/2000/svg" class="info-icon" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                        <path
                            d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                    </svg>
                    <span class="info-text">Terdapat <strong>{{ $tugas->total() }}</strong> tugas di keranjang sampah</span>
                </div>
            @endif

            <!-- Table Card -->
            <div class="table-card" id="tableCard">
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>Judul Tugas</th>
                                <th>Deadline</th>
                                <th>Dihapus Pada</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tugas as $t)
                                <tr>
                                    <td>
                                        <div class="task-item">
                                            <div class="task-icon-wrapper">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="task-icon" fill="currentColor" viewBox="0 0 16 16">
                                                    <path
                                                        d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5" />
                                                    <path
                                                        d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                                                </svg>
                                            </div>
                                            <div class="task-info">
                                                <strong>{{ $t->judul }}</strong>
                                                @if($t->deskripsi)
                                                    <small>{{ Str::limit($t->deskripsi, 50) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="deadline-badge">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                            </svg>
                                            {{ \Carbon\Carbon::parse($t->deadline)->format('d M Y, H:i') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="deleted-time">{{ $t->deleted_at->format('d M Y, H:i') }}</span>
                                        <span class="deleted-relative">{{ $t->deleted_at->diffForHumans() }}</span>
                                    </td>

                                    <td>
                                        <div class="action-buttons">
                                            <form action="{{ route('tugas.restore', $t->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn-action btn-restore" title="Pulihkan tugas">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                                        viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2z" />
                                                        <path
                                                            d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466" />
                                                    </svg>
                                                    Pulihkan
                                                </button>
                                            </form>

                                            <button type="button" class="btn-action btn-delete" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $t->id }}" title="Hapus permanen">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                                    viewBox="0 0 16 16">
                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                    <path
                                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </div>

                                        <div class="modal fade" id="deleteModal{{ $t->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header modal-header-danger">
                                                        <h5 class="modal-title modal-title-custom">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                                                            </svg>
                                                            Konfirmasi Penghapusan
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body modal-body-custom">
                                                        <p>Anda yakin ingin menghapus tugas ini secara <strong
                                                                style="color: #e53e3e;">PERMANEN</strong>?</p>
                                                        <div class="alert-danger-custom">
                                                            <strong style="color: #e53e3e;">{{ $t->judul }}</strong>
                                                            <br>
                                                            <small style="color: #718096;">Tindakan ini tidak dapat dibatalkan!</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer modal-footer-custom">
                                                        <button type="button" class="btn-custom btn-back" data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('tugas.forceDelete', $t->id) }}" method="POST"
                                                            style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn-custom btn-danger-custom">Ya, Hapus Permanen</button>
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
                                            <svg xmlns="http://www.w3.org/2000/svg" class="empty-icon" fill="currentColor" viewBox="0 0 16 16">
                                                <path
                                                    d="M4.98 4a.5.5 0 0 0-.39.188L1.54 8H6a.5.5 0 0 1 .5.5 1.5 1.5 0 1 0 3 0A.5.5 0 0 1 10 8h4.46l-3.05-3.812A.5.5 0 0 0 11.02 4zm-1.17-.437A1.5 1.5 0 0 1 4.98 3h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 13H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .106-.374z" />
                                            </svg>
                                            <h3 class="empty-title">Tidak Ada Tugas yang dihapus</h3>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if($tugas->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $tugas->links() }}
                </div>
            @endif

        </div>
    </div>

    <!-- Modal Kosongkan Semua -->
    @if($tugas->isNotEmpty())
        <div class="modal fade" id="clearTrashModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header modal-header-danger">
                        <h5 class="modal-title modal-title-custom">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                            </svg>
                            Peringatan!
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body modal-body-custom">
                        <p style="font-weight: 600; margin-bottom: 1rem;">Anda yakin ingin mengosongkan SELURUH keranjang
                            sampah?</p>
                        <div class="alert-danger-custom">
                            <strong style="color: #e53e3e;">Semua tugas akan dihapus secara permanen!</strong>
                            <br>                            
                        </div>
                    </div>
                    <div class="modal-footer modal-footer-custom">
                        <button type="button" class="btn-custom btn-back" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('tugas.clearTrash') }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-custom btn-danger-custom">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                </svg>
                                Ya, Kosongkan Semua
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Entrance animations
            const header = document.getElementById('trashHeader');
            const infoCard = document.getElementById('infoCard');
            const tableCard = document.getElementById('tableCard');

            setTimeout(() => header.classList.add('show'), 100);
            if (infoCard) setTimeout(() => infoCard.classList.add('show'), 200);
            setTimeout(() => tableCard.classList.add('show'), 300);
        });
    </script>

@endsection
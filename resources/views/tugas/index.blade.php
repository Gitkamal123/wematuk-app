@extends('layouts.master')

@section('title', 'Daftar Tugas - WeMaTuK')

@section('content')
    <style>
        /* ===================== */
        /* DAFTAR TUGAS PAGE     */
        /* ===================== */

        body {
            background: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .tugas-container {
            padding: 2rem 0;
        }

        /* Header */
        .tugas-header {
            margin-bottom: 2rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }

        .tugas-header.show {
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

        .tugas-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1a202c;
            margin: 0;
        }

        .btn-print {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(74, 144, 226, 0.3);
        }

        .btn-print:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
            color: #ffffff;
        }

        /* Search Card */
        .search-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            margin-bottom: 1.5rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
            transition-delay: 0.1s;
        }

        .search-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        .search-wrapper {
            position: relative;
            display: flex;
            gap: 0.75rem;
        }

        .search-input {
            flex: 1;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            font-size: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.3s ease;
            background: #f7fafc;
        }

        .search-input:focus {
            outline: none;
            border-color: #4a90e2;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            pointer-events: none;
        }

        .btn-search {
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(74, 144, 226, 0.3);
        }

        /* Table Card */
        .table-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            margin-bottom: 1.5rem;
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
            background: linear-gradient(135deg, #4a90e2 0%, #63b3ed 100%);
        }

        .table-custom thead th {
            color: #ffffff;
            font-weight: 600;
            padding: 1rem;
            border: none;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-custom thead th:first-child {
            border-radius: 12px 0 0 0;
        }

        .table-custom thead th:last-child {
            border-radius: 0 12px 0 0;
        }

        .table-custom tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f7fafc;
        }

        .table-custom tbody tr:hover {
            background: #f7fafc;
            transform: scale(1.01);
        }

        .table-custom tbody td {
            padding: 1rem;
            vertical-align: middle;
            color: #2d3748;
        }

        .table-custom tbody tr:last-child td:first-child {
            border-radius: 0 0 0 12px;
        }

        .table-custom tbody tr:last-child td:last-child {
            border-radius: 0 0 12px 0;
        }

        /* Badge & Status */
        .deadline-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .deadline-urgent {
            background: rgba(229, 62, 62, 0.1);
            color: #e53e3e;
        }

        .deadline-soon {
            background: rgba(237, 137, 54, 0.1);
            color: #ed8936;
        }

        .deadline-normal {
            background: rgba(72, 187, 120, 0.1);
            color: #48bb78;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .btn-edit {
            background: rgba(237, 137, 54, 0.1);
            color: #ed8936;
        }

        .btn-edit:hover {
            background: #ed8936;
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

        .btn-download {
            color: #4a90e2;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .btn-download:hover {
            color: #2b6cb0;
            text-decoration: underline;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
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

        /* Pagination */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .tugas-title {
                font-size: 1.5rem;
            }

            .header-content {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-print {
                width: 100%;
                justify-content: center;
            }

            .search-wrapper {
                flex-direction: column;
            }

            .btn-search {
                width: 100%;
            }

            .table-card {
                padding: 1rem;
                overflow-x: auto;
            }

            .table-custom {
                min-width: 600px;
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

    <div class="tugas-container">
        <div class="container-fluid">

            <!-- Header -->
            <div class="tugas-header" id="tugasHeader">
                <div class="header-content">
                    <h1 class="tugas-title">Daftar Tugas</h1>
                    <a href="{{ route('laporan.cetak') }}" class="btn-print" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                            <path
                                d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                        </svg>
                        Cetak Tugas
                    </a>
                </div>
            </div>

            <!-- Search Card -->
            <div class="search-card" id="searchCard">
                <form action="{{ route('tugas.cari') }}" method="GET">
                    <div class="search-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                            class="search-icon" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                        <input type="search" name="cari" class="search-input" id="searchInput"
                            placeholder="Cari tugas berdasarkan judul atau deskripsi..." value="{{ request('cari') }}">
                        <button class="btn-search" type="submit">Cari</button>
                    </div>
                </form>
            </div>

            <!-- Table Card -->
            <div class="table-card" id="tableCard">
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>Judul Tugas</th>
                                <th>Deskripsi</th>
                                <th>Deadline</th>
                                <th>File</th>
                                @if(Auth::user()->role == 'admin')
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tugas as $t)
                                <tr>
                                    <td>
                                        <strong>{{ $t->judul }}</strong>
                                    </td>
                                    <td>{{ Str::limit($t->deskripsi, 50) ?: '-' }}</td>
                                    <td>
                                        @php
                                            $deadline = \Carbon\Carbon::parse($t->deadline);
                                            $now = \Carbon\Carbon::now();
                                            $diffInDays = $now->diffInDays($deadline, false);

                                            if ($diffInDays < 0) {
                                                $badgeClass = 'deadline-urgent';
                                            } elseif ($diffInDays <= 3) {
                                                $badgeClass = 'deadline-soon';
                                            } else {
                                                $badgeClass = 'deadline-normal';
                                            }
                                        @endphp
                                        <span class="deadline-badge {{ $badgeClass }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                                <path
                                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                            </svg>
                                            {{ $deadline->format('d M Y, H:i') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($t->file_path)
                                            <a href="{{ Storage::url($t->file_path) }}" target="_blank" download
                                                class="btn-download">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                                    <path
                                                        d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                                                </svg>
                                                Download
                                            </a>
                                        @else
                                            <span style="color: #a0aec0;">-</span>
                                        @endif
                                    </td>

                                    @if(Auth::user()->role == 'admin')
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('tugas.edit', $t) }}" class="btn-action btn-edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        fill="currentColor" viewBox="0 0 16 16">
                                                        <path
                                                            d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form action="{{ route('tugas.destroy', $t) }}" method="POST"
                                                    onsubmit="return confirm('Pindahkan tugas ini ke keranjang sampah?')"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-action btn-delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                            fill="currentColor" viewBox="0 0 16 16">
                                                            <path
                                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                                            <path
                                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ Auth::user()->role == 'admin' ? '5' : '4' }}">
                                        <div class="empty-state">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="empty-icon" fill="currentColor"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z" />
                                            </svg>
                                            <h3 class="empty-title">Belum Ada Tugas</h3>
                                            <p class="empty-text">Saat ini belum ada data tugas yang tersedia.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper">
                {{ $tugas->links() }}
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Entrance animations
            const header = document.getElementById('tugasHeader');
            const searchCard = document.getElementById('searchCard');
            const tableCard = document.getElementById('tableCard');

            setTimeout(() => header.classList.add('show'), 100);
            setTimeout(() => searchCard.classList.add('show'), 200);
            setTimeout(() => tableCard.classList.add('show'), 300);

            // Search input handler
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                function checkSearchInput() {
                    if (searchInput.value === '') {
                        window.location.href = "{{ route('home') }}";
                    }
                }
                searchInput.addEventListener('input', checkSearchInput);
                searchInput.addEventListener('search', checkSearchInput);
            }
        });
    </script>

@endsection
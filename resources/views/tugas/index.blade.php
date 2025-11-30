<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas - WeMaTuK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            padding-top: 1rem;
        }

        .tugas-container {
            padding: 1rem 0;
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

        /* Task Cards Container */
        .tasks-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
            transition-delay: 0.2s;
        }

        .tasks-container.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Task Card */
        .task-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            border-top: 4px solid;
            position: relative;
            overflow: hidden;
        }

        .task-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        /* Color Variations for Task Cards */
        .task-card.color-1 {
            border-color: #4a90e2;
            background: linear-gradient(135deg, #ffffff 0%, #f0f7ff 100%);
        }

        .task-card.color-2 {
            border-color: #48bb78;
            background: linear-gradient(135deg, #ffffff 0%, #f0fff4 100%);
        }

        .task-card.color-3 {
            border-color: #ed8936;
            background: linear-gradient(135deg, #ffffff 0%, #fffaf0 100%);
        }

        .task-card.color-4 {
            border-color: #9f7aea;
            background: linear-gradient(135deg, #ffffff 0%, #faf5ff 100%);
        }

        .task-card.color-5 {
            border-color: #ed64a6;
            background: linear-gradient(135deg, #ffffff 0%, #fff5f7 100%);
        }

        .task-card.color-6 {
            border-color: #38b2ac;
            background: linear-gradient(135deg, #ffffff 0%, #f0fff9 100%);
        }

        /* Task Header */
        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .task-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1a202c;
            margin: 0;
            line-height: 1.3;
        }

        .task-actions {
            display: flex;
            gap: 0.5rem;
        }

        /* Task Description */
        .task-description {
            color: #4a5568;
            margin-bottom: 1.25rem;
            line-height: 1.5;
        }

        /* Task Meta */
        .task-meta {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1.25rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: #718096;
        }

        .meta-icon {
            color: #a0aec0;
            flex-shrink: 0;
        }

        /* Deadline Badge */
        .deadline-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
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
            margin-top: 1rem;
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
            flex: 1;
            justify-content: center;
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
            grid-column: 1 / -1;
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

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1050;
            overflow: hidden;
            outline: 0;
        }

        .modal.show {
            display: block;
        }

        .modal-dialog {
            position: relative;
            width: auto;
            margin: 0.5rem;
            pointer-events: none;
        }

        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - 1rem);
        }

        .modal-content {
            position: relative;
            display: flex;
            flex-direction: column;
            width: 100%;
            pointer-events: auto;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 0.3rem;
            outline: 0;
        }

        .modal-confirm {
            animation: slideInUp 0.3s ease;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header-danger {
            background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
            color: white;
            border-bottom: none;
            border-radius: 12px 12px 0 0;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding: 1rem 1rem;
        }

        .modal-footer-centered {
            display: flex;
            justify-content: center;
            gap: 1rem;
            border-top: none;
            padding: 1rem 1.5rem;
        }

        .modal-footer-centered .btn {
            min-width: 120px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }

        .task-preview {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin: 1rem 0;
        }

        .task-preview-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .task-preview-desc {
            color: #718096;
            font-size: 0.9rem;
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

            .tasks-container {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
            }

            .modal-footer-centered {
                flex-direction: column;
            }

            .modal-footer-centered .btn {
                width: 100%;
            }

            .modal-dialog {
                max-width: 500px;
                margin: 1.75rem auto;
            }
        }

        @media (min-width: 576px) {
            .modal-dialog {
                max-width: 500px;
                margin: 1.75rem auto;
            }
        }
    </style>
</head>
<body>
    <div class="tugas-container">
        <div class="container-fluid">

            <!-- Header -->
            <div class="tugas-header" id="tugasHeader">
                <div class="header-content">
                    <h1 class="tugas-title">Daftar Tugas</h1>
                    <a href="#" class="btn-print" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                        </svg>
                        Cetak Tugas
                    </a>
                </div>
            </div>

            <!-- Search Card -->
            <div class="search-card" id="searchCard">
                <form action="#" method="GET">
                    <div class="search-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="search-icon" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                        <input type="search" name="cari" class="search-input" id="searchInput" placeholder="Cari tugas berdasarkan judul atau deskripsi..." value="">
                        <button class="btn-search" type="submit">Cari</button>
                    </div>
                </form>
            </div>

            <!-- Tasks Container -->
            <div class="tasks-container" id="tasksContainer">
                <!-- Task 1 -->
                <div class="task-card color-1">
                    <div class="task-header">
                        <h3 class="task-title">Lapres</h3>
                        <div class="task-actions">
                            <span class="deadline-badge deadline-normal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                </svg>
                                27 Nov 2025, 07:34
                            </span>
                        </div>
                    </div>
                    
                    <p class="task-description">Laporan praktikum mingguan untuk mata kuliah Pemrograman Web.</p>
                    
                    <div class="task-meta">
                        <div class="meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="meta-icon" viewBox="0 0 16 16">
                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                            </svg>
                            <span>Deadline: 27 November 2025, 07:34</span>
                        </div>
                        <div class="meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="meta-icon" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                            </svg>
                            <a href="#" class="btn-download">Download File</a>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <a href="#" class="btn-action btn-edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                            </svg>
                            Edit
                        </a>
                        <button type="button" class="btn-action btn-delete" onclick="showDeleteModal(1, 'Lapres', 'Laporan praktikum mingguan untuk mata kuliah Pemrograman Web.', '2025-11-27 07:34')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                            </svg>
                            Hapus
                        </button>
                    </div>
                </div>

                <!-- Task 2 -->
                <div class="task-card color-2">
                    <div class="task-header">
                        <h3 class="task-title">Tugas Akhir Semester</h3>
                        <div class="task-actions">
                            <span class="deadline-badge deadline-soon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                </svg>
                                15 Des 2025, 23:59
                            </span>
                        </div>
                    </div>
                    
                    <p class="task-description">Pengembangan aplikasi web untuk mata kuliah Pemrograman Web Lanjut.</p>
                    
                    <div class="task-meta">
                        <div class="meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="meta-icon" viewBox="0 0 16 16">
                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                            </svg>
                            <span>Deadline: 15 Desember 2025, 23:59</span>
                        </div>
                        <div class="meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="meta-icon" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                            </svg>
                            <a href="#" class="btn-download">Download File</a>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <a href="#" class="btn-action btn-edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                            </svg>
                            Edit
                        </a>
                        <button type="button" class="btn-action btn-delete" onclick="showDeleteModal(2, 'Tugas Akhir Semester', 'Pengembangan aplikasi web untuk mata kuliah Pemrograman Web Lanjut.', '2025-12-15 23:59')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                            </svg>
                            Hapus
                        </button>
                    </div>
                </div>

                <!-- Task 3 -->
                <div class="task-card color-3">
                    <div class="task-header">
                        <h3 class="task-title">Presentasi Kelompok</h3>
                        <div class="task-actions">
                            <span class="deadline-badge deadline-urgent">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                </svg>
                                5 Des 2025, 10:00
                            </span>
                        </div>
                    </div>
                    
                    <p class="task-description">Presentasi hasil penelitian tentang teknologi web modern.</p>
                    
                    <div class="task-meta">
                        <div class="meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="meta-icon" viewBox="0 0 16 16">
                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                            </svg>
                            <span>Deadline: 5 Desember 2025, 10:00</span>
                        </div>
                        <div class="meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="meta-icon" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                            </svg>
                            <a href="#" class="btn-download">Download File</a>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <a href="#" class="btn-action btn-edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                            </svg>
                            Edit
                        </a>
                        <button type="button" class="btn-action btn-delete" onclick="showDeleteModal(3, 'Presentasi Kelompok', 'Presentasi hasil penelitian tentang teknologi web modern.', '2025-12-05 10:00')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                            </svg>
                            Hapus
                        </button>
                    </div>
                </div>

                <!-- Task 4 -->
                <div class="task-card color-4">
                    <div class="task-header">
                        <h3 class="task-title">Review Jurnal</h3>
                        <div class="task-actions">
                            <span class="deadline-badge deadline-normal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                </svg>
                                20 Des 2025, 17:00
                            </span>
                        </div>
                    </div>
                    
                    <p class="task-description">Review jurnal tentang perkembangan framework JavaScript modern.</p>
                    
                    <div class="task-meta">
                        <div class="meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="meta-icon" viewBox="0 0 16 16">
                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                            </svg>
                            <span>Deadline: 20 Desember 2025, 17:00</span>
                        </div>
                        <div class="meta-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="meta-icon" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                            </svg>
                            <a href="#" class="btn-download">Download File</a>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <a href="#" class="btn-action btn-edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                            </svg>
                            Edit
                        </a>
                        <button type="button" class="btn-action btn-delete" onclick="showDeleteModal(4, 'Review Jurnal', 'Review jurnal tentang perkembangan framework JavaScript modern.', '2025-12-20 17:00')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                            </svg>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>

        </div>
    </div>

    <!-- Single Delete Confirmation Modal -->
    <div class="modal" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-confirm">
                <div class="modal-header modal-header-danger">
                    <h5 class="modal-title fw-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                        </svg>
                        Konfirmasi Penghapusan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" onclick="closeDeleteModal()" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">Anda yakin ingin memindahkan tugas ini ke keranjang sampah?</p>

                    <div class="task-preview">
                        <div class="task-preview-title" id="modalTaskTitle"></div>
                        <div class="task-preview-desc" id="modalTaskDesc"></div>
                        <div class="task-preview-desc">
                            <small>
                                <strong>Deadline:</strong>
                                <span id="modalTaskDeadline"></span>
                            </small>
                        </div>
                    </div>

                    <div class="alert alert-warning mt-3">
                        <div class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                            </svg>
                            <div>Tugas akan dipindahkan ke keranjang sampah</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer modal-footer-centered">
                    <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                        Batal
                    </button>
                    <form id="deleteForm" method="POST" class="modal-form">
                        <button type="submit" class="btn btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                            </svg>
                            Ya, Pindahkan ke Sampah
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Current task ID for deletion
        let currentTaskId = null;

        function showDeleteModal(taskId, taskTitle, taskDesc, taskDeadline) {
            currentTaskId = taskId;

            // Set modal content
            document.getElementById('modalTaskTitle').textContent = taskTitle;
            document.getElementById('modalTaskDesc').textContent = taskDesc || '-';

            // Format deadline
            const deadline = new Date(taskDeadline);
            const formattedDeadline = deadline.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('modalTaskDeadline').textContent = formattedDeadline;

            // Set form action
            document.getElementById('deleteForm').action = `/tugas/${taskId}`;

            // Show modal
            const modal = document.getElementById('deleteModal');
            modal.style.display = 'block';
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.style.display = 'none';
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
            currentTaskId = null;
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Entrance animations
            const header = document.getElementById('tugasHeader');
            const searchCard = document.getElementById('searchCard');
            const tasksContainer = document.getElementById('tasksContainer');

            setTimeout(() => header.classList.add('show'), 100);
            setTimeout(() => searchCard.classList.add('show'), 200);
            setTimeout(() => tasksContainer.classList.add('show'), 300);

            // Search input handler
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                function checkSearchInput() {
                    if (searchInput.value === '') {
                        // Implement search functionality here
                        console.log('Search cleared');
                    }
                }
                searchInput.addEventListener('input', checkSearchInput);
                searchInput.addEventListener('search', checkSearchInput);
            }

            // Enhanced delete button interactions
            const deleteButtons = document.querySelectorAll('.btn-delete');
            deleteButtons.forEach(btn => {
                btn.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateY(-2px) scale(1.05)';
                });

                btn.addEventListener('mouseleave', function () {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        });
    </script>
</body>
</html>
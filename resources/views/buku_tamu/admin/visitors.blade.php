<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Data Pengunjung - Admin Buku Tamu</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-buku.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-buku.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --font-heading: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --font-body: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --primary: #0284c7;
            --primary-hover: #0369a1;
            --sidebar-bg: #0f172a;
            --sidebar-text: #94a3b8;
            --sidebar-hover: #1e293b;
            --sidebar-active: #0284c7;
            --bg-main: #f8fafc;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --danger: #ef4444;
            --success: #10b981;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--bg-main);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
            transition: transform 0.3s ease;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.05);
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-header h2 {
            font-family: var(--font-heading);
            font-size: 1.1rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
        }

        .sidebar-header p {
            font-size: 0.78rem;
            color: #94a3b8;
            margin-top: 2px;
        }

        .sidebar-nav {
            list-style: none;
            padding: 20px 12px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-family: var(--font-heading);
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .sidebar-nav a:hover {
            color: #ffffff;
            background: var(--sidebar-hover);
        }

        .sidebar-nav a.active {
            color: #ffffff;
            background: var(--sidebar-active);
        }

        .sidebar-nav a i {
            width: 20px;
            font-size: 1rem;
            text-align: center;
        }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logout-btn {
            background: transparent;
            border: none;
            color: #ef4444;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            font-family: var(--font-heading);
            cursor: pointer;
            padding: 6px 10px;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.1);
        }

        /* ===== Main Content Area ===== */
        .main-wrapper {
            margin-left: 260px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .topbar {
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar h1 {
            font-family: var(--font-heading);
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .content-container {
            padding: 32px;
            max-width: 1400px;
            width: 100%;
        }

        /* Filter & Action Card */
        .filter-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 24px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .search-input {
            flex-grow: 1;
            min-width: 240px;
            padding: 10px 14px;
            border: 1.5px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.9rem;
            font-family: var(--font-body);
            color: var(--text-dark);
            outline: none;
            transition: border-color 0.2s;
        }

        .search-input:focus {
            border-color: var(--primary);
        }

        .filter-select {
            padding: 10px 14px;
            border: 1.5px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.9rem;
            font-family: var(--font-body);
            background: #ffffff;
            color: var(--text-dark);
            outline: none;
            cursor: pointer;
        }

        .filter-select:focus {
            border-color: var(--primary);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 8px;
            font-family: var(--font-heading);
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-primary { background: var(--primary); color: #ffffff; }
        .btn-primary:hover { background: var(--primary-hover); }
        .btn-success { background: var(--success); color: #ffffff; }
        .btn-success:hover { background: #059669; }
        .btn-secondary { background: #64748b; color: #ffffff; }
        .btn-secondary:hover { background: #475569; }

        /* Table Card */
        .table-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        }

        .table-responsive {
            overflow-x: auto;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .custom-table th {
            background: #f8fafc;
            padding: 14px 18px;
            font-family: var(--font-heading);
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
        }

        .custom-table td {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.9rem;
            vertical-align: middle;
        }

        .custom-table tr:hover {
            background: #f8fafc;
        }

        .photo-thumb {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid var(--border-color);
            cursor: zoom-in;
            transition: transform 0.15s;
        }

        .photo-thumb:hover {
            transform: scale(1.08);
        }

        .badge-purpose {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-sekretariat { background: #eff6ff; color: #1d4ed8; }
        .badge-aplikasi_informatika { background: #e0f2fe; color: #0369a1; }
        .badge-informasi_komunikasi_publik { background: #fef3c7; color: #b45309; }
        .badge-statistik { background: #ecfdf5; color: #047857; }
        .badge-persandian_keamanan_informasi { background: #fdf2f8; color: #be185d; }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 6px;
            padding: 20px;
        }

        .pagination button {
            padding: 8px 14px;
            border: 1px solid var(--border-color);
            background: #ffffff;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
        }

        .pagination button:hover:not(:disabled) {
            background: #f1f5f9;
        }

        .pagination button.active {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
        }

        .pagination button:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal.open {
            display: flex;
        }

        .modal-content {
            background: #ffffff;
            border-radius: 16px;
            max-width: 480px;
            width: 100%;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h3 {
            font-size: 1.15rem;
            font-family: var(--font-heading);
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            background: #f8fafc;
        }

        .image-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.85);
            z-index: 2100;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .image-modal.open {
            display: flex;
        }

        .image-modal img {
            max-width: 90vw;
            max-height: 85vh;
            border-radius: 12px;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .toast-notify {
            position: fixed;
            bottom: 24px;
            right: 24px;
            padding: 14px 20px;
            border-radius: 10px;
            color: #ffffff;
            font-size: 0.9rem;
            font-weight: 600;
            z-index: 3000;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            display: none;
        }

        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div>
                <h2>Buku Tamu</h2>
                <p>Diskominfo Kab. Madiun</p>
            </div>
        </div>

        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Dashboard Analytics</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.visitors') }}" class="active">
                    <i class="fa-solid fa-users"></i>
                    <span>Data Pengunjung</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.calendar') }}">
                    <i class="fa-regular fa-calendar-days"></i>
                    <span>Kalender Kunjungan</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <div class="small text-muted" id="adminName">Admin</div>
            <button class="logout-btn" onclick="logout()">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>Keluar</span>
            </button>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-wrapper">
        <header class="topbar">
            <h1>Manajemen Data Pengunjung</h1>
            <div class="d-flex align-items-center gap-2">
                <span class="badge" style="background:#e0f2fe; color:#0369a1; padding:6px 12px; border-radius:6px; font-weight:600; font-size:0.85rem;">
                    Buku Tamu Digital
                </span>
            </div>
        </header>

        <main class="content-container">
            <!-- Filter Bar -->
            <div class="filter-card">
                <input type="text" class="search-input" id="nameSearch" placeholder="Cari nama, instansi, telepon, atau keperluan...">
                
                <select id="purposeFilter" class="filter-select">
                    <option value="">Semua Bidang</option>
                    <option value="sekretariat">Sekretariat</option>
                    <option value="aplikasi_informatika">Aplikasi Informatika</option>
                    <option value="persandian_keamanan_informasi">Persandian & Keamanan</option>
                    <option value="informasi_komunikasi_publik">Komunikasi Publik</option>
                    <option value="statistik">Statistik</option>
                </select>

                <input type="date" class="filter-select" id="dateFilter">

                <button type="button" class="btn btn-primary" id="todayFilterBtn">
                    <i class="fa-regular fa-calendar"></i> Hari Ini
                </button>

                <button type="button" class="btn btn-success" onclick="openExportModal()">
                    <i class="fa-solid fa-file-pdf"></i> Export PDF
                </button>
            </div>

            <!-- Data Table Card -->
            <div class="table-card">
                <div id="tableLoading" style="text-align:center; padding: 48px; color: var(--text-muted);">
                    <i class="fa-solid fa-spinner fa-spin fa-2x mb-3" style="color:var(--primary);"></i>
                    <p>Memuat data pengunjung...</p>
                </div>

                <div id="tableContainer" style="display:none;">
                    <div class="table-responsive">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Waktu</th>
                                    <th>Foto</th>
                                    <th>Nama Pengunjung</th>
                                    <th>Kontak</th>
                                    <th>Asal Daerah / Instansi</th>
                                    <th>Tujuan Bidang</th>
                                    <th>Keperluan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="visitorsTableBody"></tbody>
                        </table>
                    </div>
                    <div class="pagination" id="pagination"></div>
                </div>
            </div>
        </main>
    </div>

    <!-- Export Modal -->
    <div id="exportModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Export Laporan PDF</h3>
                <button style="background:none; border:none; font-size:1.5rem; cursor:pointer;" onclick="closeExportModal()">&times;</button>
            </div>
            <form id="exportForm" onsubmit="event.preventDefault(); downloadPDF();">
                <div class="modal-body">
                    <div style="margin-bottom:16px;">
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:6px;">Format Kertas</label>
                        <select id="paperFormat" class="filter-select" style="width:100%;">
                            <option value="f4" selected>F4 (210 x 330 mm)</option>
                            <option value="a4">A4 (210 x 297 mm)</option>
                            <option value="letter">Letter</option>
                            <option value="legal">Legal</option>
                        </select>
                    </div>
                    <div style="margin-bottom:16px;">
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:6px;">Orientasi</label>
                        <select id="paperOrientation" class="filter-select" style="width:100%;">
                            <option value="landscape" selected>Landscape (Mendatar)</option>
                            <option value="portrait">Portrait (Tegak)</option>
                        </select>
                    </div>
                    <div style="margin-bottom:16px;">
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:6px;">Filter Bidang</label>
                        <select id="exportPurpose" class="filter-select" style="width:100%;">
                            <option value="">Semua Bidang</option>
                            <option value="sekretariat">Sekretariat</option>
                            <option value="aplikasi_informatika">Aplikasi Informatika</option>
                            <option value="persandian_keamanan_informasi">Persandian & Keamanan</option>
                            <option value="informasi_komunikasi_publik">Komunikasi Publik</option>
                            <option value="statistik">Statistik</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-size:0.85rem; font-weight:600; margin-bottom:6px;">Filter Bulan (Opsional)</label>
                        <input type="month" id="exportMonth" class="filter-select" style="width:100%;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeExportModal()">Batal</button>
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-download"></i> Unduh PDF</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Hapus Data Pengunjung</h3>
                <button style="background:none; border:none; font-size:1.5rem; cursor:pointer;" onclick="closeDeleteModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data kunjungan ini secara permanen?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Batal</button>
                <button type="button" class="btn btn-primary" style="background:var(--danger);" onclick="confirmDelete()">Hapus Data</button>
            </div>
        </div>
    </div>

    <!-- Image Zoom Modal -->
    <div id="imgModal" class="image-modal" onclick="this.classList.remove('open')">
        <img id="imgPreview" src="" alt="Foto Pengunjung" onclick="event.stopPropagation()">
    </div>

    <div id="toast" class="toast-notify"></div>

    <script>
        const token = localStorage.getItem('admin_token');
        const adminData = JSON.parse(localStorage.getItem('admin_data') || '{}');
        if (!token) window.location.href = '/buku-tamu/admin';

        let currentPage = 1;
        let perPage = 10;
        let totalPages = 1;
        let currentFilters = {};
        let visitorToDelete = null;

        const defaultAvatar = `data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0OCIgaGVpZ2h0PSI0OCIgZmlsbD0ibm9uZSI+PGNpcmNsZSBjeD0iMjQiIGN5PSIyNCIgcj0iMjQiIGZpbGw9IiNFNUU3RUIiLz48cGF0aCBmaWxsPSIjOTA5NUEwIiBkPSJNMjQgMjVjLTMuODY2IDAtNy0zLjEzNC03LTdzMy4xMzQtNyA3LTcgNyAzLjEzNCA3IDctMy4xMzQgNy03IDdabTAgMTRjLTcuNzMyIDAtMTQtMS4yNjgtMTQtNyAwLTUuNzMyIDYuMjY4LTcgMTQtNyA3LjczMiAwIDE0IDEuMjY4IDE0IDcgMCA1LjczMi02LjI2OCA3LTE0IDdaIi8+PC9zdmc+`;

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('adminName').textContent = adminData.name || 'Admin';
            setupFilters();
            loadVisitors(1);
        });

        function setupFilters() {
            const nameSearch = document.getElementById('nameSearch');
            const purposeFilter = document.getElementById('purposeFilter');
            const dateFilter = document.getElementById('dateFilter');
            const todayFilterBtn = document.getElementById('todayFilterBtn');

            let timer;
            nameSearch.addEventListener('input', (e) => {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    const val = e.target.value.trim();
                    if (val) currentFilters.name = val;
                    else delete currentFilters.name;
                    loadVisitors(1);
                }, 350);
            });

            purposeFilter.addEventListener('change', (e) => {
                if (e.target.value) currentFilters.purpose = e.target.value;
                else delete currentFilters.purpose;
                loadVisitors(1);
            });

            dateFilter.addEventListener('change', (e) => {
                if (e.target.value) currentFilters.date = e.target.value;
                else delete currentFilters.date;
                loadVisitors(1);
            });

            todayFilterBtn.addEventListener('click', () => {
                const today = new Date().toISOString().split('T')[0];
                dateFilter.value = today;
                currentFilters.date = today;
                loadVisitors(1);
            });
        }

        async function loadVisitors(page = 1) {
            const loading = document.getElementById('tableLoading');
            const container = document.getElementById('tableContainer');
            loading.style.display = 'block';
            container.style.display = 'none';

            try {
                let url = `/api/visitors?page=${page}`;
                if (currentFilters.purpose) url += `&purpose=${encodeURIComponent(currentFilters.purpose)}`;
                if (currentFilters.date) url += `&date=${encodeURIComponent(currentFilters.date)}`;
                if (currentFilters.name) url += `&name=${encodeURIComponent(currentFilters.name)}`;

                const response = await fetch(url, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                });

                const result = await response.json();
                if (response.ok && result.success) {
                    const meta = result.data;
                    displayVisitors(meta.data || [], meta.from || 1);
                    setupPagination(meta.current_page, meta.last_page);
                } else {
                    document.getElementById('visitorsTableBody').innerHTML = '<tr><td colspan="9" style="text-align:center; padding:32px; color:var(--text-muted);">Tidak ada data pengunjung ditemukan.</td></tr>';
                }
            } catch (err) {
                console.error(err);
                document.getElementById('visitorsTableBody').innerHTML = '<tr><td colspan="9" style="text-align:center; padding:32px; color:var(--danger);">Gagal memuat data pengunjung.</td></tr>';
            } finally {
                loading.style.display = 'none';
                container.style.display = 'block';
            }
        }

        function resolvePhoto(photo) {
            if (!photo) return defaultAvatar;
            const p = String(photo).trim();
            if (/^https?:\/\//i.test(p)) return p;
            if (p.startsWith('/storage/')) return p;
            if (p.startsWith('storage/')) return '/' + p;
            return '/storage/' + p.replace(/^\/+/, '');
        }

        const purposeLabels = {
            sekretariat: 'Sekretariat',
            aplikasi_informatika: 'Aplikasi Informatika',
            informasi_komunikasi_publik: 'Komunikasi Publik',
            statistik: 'Statistik',
            persandian_keamanan_informasi: 'Persandian & Sandi'
        };

        const esc = s => String(s ?? '').replace(/[&<>"']/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', '\'': '&#39;' }[m]));

        function displayVisitors(visitors, fromIndex) {
            const tbody = document.getElementById('visitorsTableBody');
            if (!visitors.length) {
                tbody.innerHTML = '<tr><td colspan="9" style="text-align:center; padding:32px; color:var(--text-muted);">Belum ada data pengunjung.</td></tr>';
                return;
            }

            tbody.innerHTML = visitors.map((v, i) => {
                const dateStr = v.created_at ? new Date(v.created_at).toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' }) : '-';
                const photoSrc = resolvePhoto(v.photo);
                const purposeLabel = purposeLabels[v.purpose] || (v.purpose || '-');
                const badgeClass = `badge-${v.purpose}`;

                return `
                    <tr>
                        <td><strong>${fromIndex + i}</strong></td>
                        <td style="font-size:0.82rem; color:var(--text-muted);">${dateStr}</td>
                        <td>
                            <img src="${photoSrc}" class="photo-thumb" alt="Foto" onclick="zoomPhoto('${photoSrc}')">
                        </td>
                        <td><strong>${esc(v.name)}</strong></td>
                        <td>
                            <div style="font-size:0.85rem;">${esc(v.phone)}</div>
                            <div style="font-size:0.78rem; color:var(--text-muted);">${esc(v.email || '-')}</div>
                        </td>
                        <td>${esc(v.asal_daerah || '-')}</td>
                        <td><span class="badge-purpose ${badgeClass}">${purposeLabel}</span></td>
                        <td style="max-width:220px; font-size:0.85rem; color:var(--text-muted);">${esc(v.notes || '-')}</td>
                        <td>
                            <button type="button" style="background:none; border:none; color:var(--danger); cursor:pointer; font-size:1rem;" onclick="openDeleteModal(${v.id})" title="Hapus Data">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function setupPagination(current, last) {
            const container = document.getElementById('pagination');
            if (last <= 1) { container.innerHTML = ''; return; }

            let html = `<button onclick="loadVisitors(${current - 1})" ${current <= 1 ? 'disabled' : ''}><i class="fa-solid fa-chevron-left"></i></button>`;
            for (let p = 1; p <= last; p++) {
                if (p === 1 || p === last || Math.abs(p - current) <= 1) {
                    html += `<button onclick="loadVisitors(${p})" class="${p === current ? 'active' : ''}">${p}</button>`;
                }
            }
            html += `<button onclick="loadVisitors(${current + 1})" ${current >= last ? 'disabled' : ''}><i class="fa-solid fa-chevron-right"></i></button>`;
            container.innerHTML = html;
        }

        function zoomPhoto(src) {
            document.getElementById('imgPreview').src = src;
            document.getElementById('imgModal').classList.add('open');
        }

        function openExportModal() {
            document.getElementById('exportModal').classList.add('open');
        }

        function closeExportModal() {
            document.getElementById('exportModal').classList.remove('open');
        }

        async function downloadPDF() {
            const format = document.getElementById('paperFormat').value;
            const orientation = document.getElementById('paperOrientation').value;
            const purpose = document.getElementById('exportPurpose').value;
            const month = document.getElementById('exportMonth').value;

            let url = `/api/export/pdf?format=${format}&orientation=${orientation}`;
            if (purpose) url += `&purpose=${encodeURIComponent(purpose)}`;
            if (month) url += `&month=${encodeURIComponent(month)}`;

            window.open(url, '_blank');
            closeExportModal();
            showToast('Laporan PDF sedang diunduh...', 'success');
        }

        function openDeleteModal(id) {
            visitorToDelete = id;
            document.getElementById('deleteModal').classList.add('open');
        }

        function closeDeleteModal() {
            visitorToDelete = null;
            document.getElementById('deleteModal').classList.remove('open');
        }

        async function confirmDelete() {
            if (!visitorToDelete) return;
            try {
                const response = await fetch(`/api/visitors/${visitorToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        Authorization: `Bearer ${token}`,
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                });
                if (response.ok) {
                    showToast('Data pengunjung berhasil dihapus.', 'success');
                    closeDeleteModal();
                    loadVisitors(currentPage);
                } else {
                    showToast('Gagal menghapus data pengunjung.', 'danger');
                }
            } catch (err) {
                showToast('Terjadi kesalahan koneksi.', 'danger');
            }
        }

        function showToast(msg, type = 'success') {
            const toast = document.getElementById('toast');
            toast.style.background = type === 'success' ? '#10b981' : '#ef4444';
            toast.textContent = msg;
            toast.style.display = 'block';
            setTimeout(() => { toast.style.display = 'none'; }, 3500);
        }

        async function logout() {
            try {
                await fetch('{{ route("admin.logout") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
            } catch (e) {}
            localStorage.removeItem('admin_token');
            localStorage.removeItem('admin_data');
            window.location.href = '{{ route("admin.login") }}';
        }
    </script>
</body>
</html>

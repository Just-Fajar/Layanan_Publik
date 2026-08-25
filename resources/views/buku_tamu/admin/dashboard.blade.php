<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dashboard Admin - Buku Tamu Digital</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ===== 1. CSS Variables & Reset ===== */
        :root {
            --primary-color: #4F46E5;
            --primary-hover: #4338CA;
            --secondary-color: #10B981;
            --danger-color: #EF4444;
            --danger-hover: #DC2626;
            --background-color: #F3F4F6;
            --surface-color: #FFFFFF;
            --text-primary: #1F2937;
            --text-secondary: #6B7280;
            --border-color: #E5E7EB;
            --sidebar-bg: #2D3748;
            --sidebar-text: #E2E8F0;
            --sidebar-hover-bg: #4A5568;
            --sidebar-active-bg: var(--primary-color);
            --font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
            --transition-cubic: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--background-color);
            color: var(--text-primary);
            display: flex;
            overflow-x: hidden;
        }

        /* ===== 2. Animasi & Keyframes ===== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
        }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes modalSlideIn { from { opacity: 0; transform: translateY(-30px) } to { opacity: 1; transform: translateY(0) } }

        /* ===== 3. Layout: Sidebar & Main Content ===== */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            z-index: 1000;
            flex-shrink: 0;
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            box-shadow: var(--shadow-lg);
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.show {
            opacity: 1;
            pointer-events: auto;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px 24px;
            border-bottom: 1px solid #4A5568;
        }

        .logo {
            height: 44px;
            width: 44px;
            flex-shrink: 0;
            border-radius: 8px;
        }

        .header-text-container {
            display: flex;
            flex-direction: column;
            line-height: 1.3;
        }

        .header-text-container h2 {
            font-size: 1.1rem;
            color: #fff;
            font-weight: 600;
        }

        .header-text-container p {
            font-size: 0.8rem;
            color: var(--sidebar-text);
        }

        .sidebar-nav {
            flex-grow: 1;
            list-style: none;
            padding-top: 16px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 14px 24px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition-cubic);
            border-left: 3px solid transparent;
            border-radius: 0 8px 8px 0;
            margin-right: 12px;
        }

        .sidebar-nav a:hover {
            background: var(--sidebar-hover-bg);
            color: #fff;
            border-left-color: var(--primary-color);
        }

        .sidebar-nav a.active {
            background: var(--sidebar-active-bg);
            color: #fff;
            border-left-color: #A5B4FC;
            box-shadow: var(--shadow-md);
        }

        .sidebar-nav a .icon {
            width: 24px;
            height: 24px;
            color: var(--sidebar-text);
            transition: color 0.2s ease;
        }

        .sidebar-nav a.active .icon {
            color: #fff;
        }

        .sidebar-footer {
            padding: 24px;
            border-top: 1px solid #4A5568;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        #adminName {
            font-weight: 600;
            color: #fff;
        }

        .logout-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: #4A5568;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.2s ease;
            font-weight: 600;
            box-shadow: var(--shadow-sm);
        }

        .logout-btn:hover {
            background: var(--danger-color);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .main-content {
            margin-left: 0;
            width: 100%;
            transition: margin-left 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
        }

        .main-header {
            padding: 20px 32px;
            background: var(--surface-color);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 990;
            gap: 16px;
        }

        .header-left {
            flex-grow: 1;
        }

        .header-left h1 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .header-left p {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .header-right {
            text-align: right;
            white-space: nowrap;
        }

        .header-right #currentDate {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-secondary);
        }

        .menu-toggle {
            display: block;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            border-radius: 8px;
        }

        .menu-toggle:hover {
            background-color: var(--background-color);
        }

        .menu-toggle .icon {
            width: 30px;
            height: 30px;
            color: var(--text-primary);
        }

        .container {
            padding: 32px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--surface-color);
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--shadow-md);
            transition: var(--transition-cubic);
            border: 1px solid var(--border-color);
        }

        .stat-card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: var(--shadow-lg);
        }

        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .stat-card-header h3 {
            color: var(--text-secondary);
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .stat-card-header .icon {
            width: 24px;
            height: 24px;
        }

        .stat-card .number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
            line-height: 1.2;
        }

        .stat-card .label {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        #semesterSelect {
            width: 100%;
            border: none;
            background: transparent;
            font-family: var(--font-family);
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-top: 4px;
            padding: 4px 0;
            cursor: pointer;
        }

        .stat-card.loading .icon-wrapper,
        .stat-card.loading .number,
        .stat-card.loading .label {
            background: linear-gradient(to right, #eff1f3 4%, #e2e2e2 25%, #eff1f3 36%);
            animation: shimmer 2s infinite linear;
            background-size: 1000px 100%;
        }

        .stat-card.loading .number {
            height: 38px;
            width: 60%;
            margin-bottom: 8px;
            border-radius: 8px;
        }

        .stat-card.loading .label {
            height: 18px;
            width: 80%;
            border-radius: 8px;
        }

        .stat-card.loading .icon-wrapper > .icon {
            display: none;
        }

        .charts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 32px;
        }

        .chart-card {
            background: var(--surface-color);
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
        }

        .chart-card h3 {
            color: var(--text-primary);
            margin-bottom: 20px;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        .data-table-card {
            background: var(--surface-color);
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .table-header h3 {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .filters {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-input {
            padding: 10px 14px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            font-family: var(--font-family);
            background: #F9FAFB;
            transition: border-color 0.2s;
        }

        .filter-input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition-cubic);
            border: none;
            box-shadow: var(--shadow-sm);
            text-decoration: none;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn.btn-primary { background: var(--primary-color); color: #fff; }
        .btn.btn-primary:hover { background: var(--primary-hover); }
        .btn.btn-secondary { background: var(--text-primary); color: #fff; }
        .btn.btn-secondary:hover { background: #000; }
        .btn.btn-success { background: var(--secondary-color); color: #fff; }
        .btn.btn-success:hover { background: #059669; }
        .btn.btn-warning { background: #F59E0B; color: #fff; }
        .btn.btn-warning:hover { background: #D97706; }
        .btn.btn-danger { background: var(--danger-color); color: #fff; }
        .btn.btn-danger:hover { background: var(--danger-hover); }

        .table-wrapper {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .data-table th {
            background: #F9FAFB;
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table td {
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .data-table tbody tr:hover {
            background: #F0F2F5;
        }

        .photo-thumb {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            cursor: zoom-in;
        }

        .purpose-badge {
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }

        .purpose-sekretariat { background:#e0e7ff; color:#3730a3; }
        .purpose-aplikasi_informatika { background:#dbeafe; color:#1e40af; }
        .purpose-informasi_komunikasi_publik { background:#fef3c7; color:#78350f; }
        .purpose-statistik { background:#d1fae5; color:#065f46; }
        .purpose-persandian_keamanan_informasi { background:#fcd5ce; color:#9b1c1c; }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 24px;
        }

        .pagination button {
            padding: 8px 14px;
            border: 1px solid var(--border-color);
            background: var(--surface-color);
            border-radius: 8px;
            cursor: pointer;
            transition: all .2s;
            font-weight: 500;
        }

        .pagination button:hover {
            background: #F3F4F6;
            border-color: #D1D5DB;
        }

        .pagination button.active {
            background: var(--primary-color);
            color: #fff;
            border-color: var(--primary-color);
        }

        .pagination button:disabled {
            opacity: .5;
            cursor: not-allowed;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            inset: 0;
            background: rgba(0,0,0,.5);
            backdrop-filter: blur(4px);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal.open {
            display: flex;
            animation: fadeIn 0.3s ease;
        }

        .modal-content {
            background: var(--surface-color);
            border-radius: 16px;
            width: 100%;
            max-width: 500px;
            box-shadow: var(--shadow-lg);
            animation: modalSlideIn .3s ease-out;
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-secondary);
            line-height: 1;
        }

        .modal-body {
            padding: 24px;
        }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; }
        .form-select { width: 100%; padding: 12px; border: 2px solid var(--border-color); border-radius: 8px; font-size: 14px; }

        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            background: #F9FAFB;
            border-radius: 0 0 16px 16px;
        }

        .image-modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 2000;
            background: rgba(0,0,0,.8);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .image-modal.open {
            display: flex;
            animation: fadeIn 0.3s ease;
        }

        .image-modal img {
            max-width: 90vw;
            max-height: 85vh;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,.5);
        }

        #imgClose {
            position: absolute;
            top: 16px;
            right: 20px;
            cursor: pointer;
            background: rgba(255,255,255,.15);
            color: #fff;
            border: 1px solid rgba(255,255,255,.35);
            padding: 6px 10px;
            border-radius: 10px;
            font-weight: 700;
        }

        #imgMeta {
            position: absolute;
            bottom: 16px;
            left: 20px;
            right: 20px;
            text-align: center;
            color: #fff;
            font-size: 14px;
            opacity: .9;
        }

        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--text-primary);
            color: #fff;
            padding: 14px 20px;
            border-radius: 8px;
            box-shadow: var(--shadow-lg);
            z-index: 3000;
            opacity: 0;
            transform: translateY(20px);
            transition: all .3s ease;
        }

        .toast.show { opacity: 1; transform: translateY(0); }
        .toast.success { background: var(--secondary-color); }
        .toast.error { background: var(--danger-color); }

        .data-table td .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 6px;
            border-radius: 50%;
            transition: background 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .data-table td .action-btn:hover { background: #e5e7eb; }
        .data-table td .action-btn .icon { width: 20px; height: 20px; color: var(--text-secondary); }
        .data-table td .action-btn.delete:hover .icon { color: var(--danger-color); }

        /* ===== 5. Responsive Design ===== */
        @media (min-width: 1025px) {
            .main-content.sidebar-open { margin-left: 260px; }
        }

        @media (max-width: 1024px) {
            .charts-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .main-header { padding: 16px; flex-direction: row; }
            .header-left p { display: none; }
            .container { padding: 16px; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .table-header { flex-direction: column; align-items: stretch; }
        }

        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            {{-- <img src="/images/logo-diskominfo.png" class="logo" alt="Logo Diskominfo"> --}}
            <div class="header-text-container">
                <h2>Buku Tamu</h2>
                <p>Diskominfo Kabupaten Madiun</p>
            </div>
        </div>

        <nav>
            <ul class="sidebar-nav">
                <li>
                    <a href="#dashboard-top">
                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" /></svg>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#data-pengunjung-section">
                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9A3.75 3.75 0 1 1 12 5.25 3.75 3.75 0 0 1 15.75 9z" /><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 20.25a8.25 8.25 0 0 1 15 0" /></svg>
                        <span>Pengunjung</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <div class="user-info">
                <span id="adminName">Loading...</span>
            </div>
            <button class="logout-btn" onclick="logout()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px;"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" /></svg>
                <span>Logout</span>
            </button>
        </div>
    </aside>

    <div class="main-content" id="main-content">
        <header class="main-header">
            <button class="menu-toggle" id="menu-toggle" aria-label="Toggle Menu">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
            </button>
            <div class="header-left">
                <h1>Dashboard</h1>
                <p id="welcomeMessage">Selamat datang kembali!</p>
            </div>
            <div class="header-right">
                <p id="currentDate"></p>
            </div>
        </header>

        <main class="container">
            <div id="dashboard-top" class="stats-grid">
                <div class="stat-card loading" style="animation-delay: 0.1s;">
                    <div class="stat-card-header">
                        <div>
                            <h3>Total Pengunjung</h3>
                            <div class="number" id="totalVisitors">-</div>
                            <div class="label">Semua waktu</div>
                        </div>
                        <div class="icon-wrapper" style="background-image: linear-gradient(135deg, #818cf8 0%, #a78bfa 100%);">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m-7.5-2.962A3 3 0 0 1 3 18.72v-2.172a3 3 0 0 1 3.03-2.962m3.844 6.162a3 3 0 0 1-3.844 0M12 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                        </div>
                    </div>
                </div>
                <div class="stat-card loading" style="animation-delay: 0.2s.">
                    <div class="stat-card-header">
                        <div>
                            <h3>Hari Ini</h3>
                            <div class="number" id="todayVisitors">-</div>
                            <div class="label">Pengunjung hari ini</div>
                        </div>
                        <div class="icon-wrapper" style="background-image: linear-gradient(135deg, #34d399 0%, #a7f3d0 100%);">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0h18" /></svg>
                        </div>
                    </div>
                </div>
                <div class="stat-card loading" style="animation-delay: 0.3s;">
                    <div class="stat-card-header">
                        <div>
                            <h3>Bulan Ini</h3>
                            <div class="number" id="monthVisitors">-</div>
                            <div class="label">Pengunjung bulan ini</div>
                        </div>
                        <div class="icon-wrapper" style="background-image: linear-gradient(135deg, #fbbf24 0%, #fcd34d 100%);">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
                        </div>
                    </div>
                </div>
                <div class="stat-card loading" style="animation-delay: 0.4s;">
                    <div class="stat-card-header">
                        <div>
                            <h3>Semester</h3>
                            <div class="number" id="semesterVisitors">-</div>
                            <select id="semesterSelect" class="label">
                                <option value="1">Semester 1 (Jan–Jun)</option>
                                <option value="2">Semester 2 (Jul–Des)</option>
                            </select>
                        </div>
                        <div class="icon-wrapper" style="background-image: linear-gradient(135deg, #60a5fa 0%, #93c5fd 100%);">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" /></svg>
                        </div>
                    </div>
                </div>
                <div class="stat-card loading" style="animation-delay: 0.5s;">
                    <div class="stat-card-header">
                        <div>
                            <h3>Rata-rata Harian</h3>
                            <div class="number" id="avgVisitors">-</div>
                            <div class="label">Per hari</div>
                        </div>
                        <div class="icon-wrapper" style="background-image: linear-gradient(135deg, #a855f7 0%, #c084fc 100%);">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v18M9.75 3v18M15.75 3v18M21.75 3v18M3.75 9h18M3.75 15h18" /></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="charts-grid">
                <div class="chart-card fade-in-up" style="animation-delay: 0.6s;">
                    <h3>📊 Kunjungan per Tujuan</h3>
                    <div class="chart-container"><canvas id="purposeChart"></canvas></div>
                </div>
                <div class="chart-card fade-in-up" style="animation-delay: 0.7s;">
                    <h3>📈 Trend Kunjungan Bulanan</h3>
                    <div class="chart-container"><canvas id="monthlyChart"></canvas></div>
                </div>
            </div>

            <div id="data-pengunjung-section" class="data-table-card fade-in-up" style="animation-delay: 0.8s;">
                <div class="table-header">
                    <h3>Data Kunjungan</h3>
                    <div class="filters">
                        <button class="btn btn-success" onclick="showExportModal()">Export PDF</button>
                        <a href="/buku-tamu/admin/dashboard/calendar" class="btn btn-warning" target="_blank">Kalender</a>
                    </div>
                </div>

                <div class="filters" style="margin-bottom: 24px; padding-top: 16px; border-top: 1px solid var(--border-color);">
                    <input type="text" id="nameSearch" class="filter-input" placeholder="Cari nama…"/>
                    <select class="filter-input" id="purposeFilter">
                        <option value="">Semua Tujuan</option>
                        <option value="sekretariat">Sekretariat</option>
                        <option value="aplikasi_informatika">Aplikasi Informatika</option>
                        <option value="persandian_keamanan_informasi">Persandian & Keamanan</option>
                        <option value="informasi_komunikasi_publik">Komunikasi Publik</option>
                        <option value="statistik">Statistik</option>
                    </select>
                    <input type="date" class="filter-input" id="dateFilter">
                    <button type="button" id="todayFilter" class="btn btn-primary">Hari Ini</button>
                </div>

                <div id="tableLoading" style="text-align: center; padding: 40px;">
                    <p>Memuat data...</p>
                </div>

                <div id="tableContainer" style="display:none;">
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                            <tr>
                                <th>No</th><th>Tanggal</th><th>Foto</th><th>Nama</th>
                                <th>Email</th><th>Telepon</th><th>Asal Daerah</th><th>Tujuan</th><th>Keperluan</th><th>Aksi</th>
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

    <div id="exportModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Export Laporan PDF</h3>
                <button class="close-btn" onclick="closeExportModal()">&times;</button>
            </div>
            <form id="exportForm" onsubmit="event.preventDefault(); downloadPDF();">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="paperFormat">Format Kertas</label>
                        <select id="paperFormat" class="form-select">
                            <option value="a4">A4 (210 x 297 mm)</option>
                            <option value="f4" selected>F4 (210 x 330 mm)</option>
                            <option value="letter">Letter (216 x 279 mm)</option>
                            <option value="legal">Legal (216 x 356 mm)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="paperOrientation">Orientasi</label>
                        <select id="paperOrientation" class="form-select">
                            <option value="portrait">Portrait (Tegak)</option>
                            <option value="landscape" selected>Landscape (Mendatar)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exportPurpose">Filter Tujuan (Opsional)</label>
                        <select id="exportPurpose" class="form-select">
                            <option value="">Semua Tujuan</option>
                            <option value="sekretariat">Sekretariat</option>
                            <option value="aplikasi_informatika">Aplikasi Informatika</option>
                            <option value="persandian_keamanan_informasi">Persandian & Keamanan</option>
                            <option value="informasi_komunikasi_publik">Komunikasi Publik</option>
                            <option value="statistik">Statistik</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exportMonth">Filter Bulan (Opsional)</label>
                        <input type="month" id="exportMonth" class="form-select">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeExportModal()">Batal</button>
                    <button type="submit" class="btn btn-success">Download PDF</button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Konfirmasi Hapus</h3>
                <button class="close-btn" onclick="closeDeleteModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p id="deleteMessage">Apakah Anda yakin ingin menghapus data pengunjung ini secara permanen?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Batal</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <div id="imgModal" class="image-modal" aria-hidden="true">
        <button id="imgClose" class="close-btn">✕ Tutup</button>
        <img id="imgPreview" src="" alt="Foto" />
        <div id="imgMeta" class="meta"></div>
    </div>

    <div id="toast" class="toast"></div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const navLinks = Array.from(document.querySelectorAll('.sidebar-nav a'));
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menu-toggle');
            const mainContent = document.getElementById('main-content');
            const overlay = sidebar ? createOverlay() : null;

            if (navLinks.length) {
                const initialHash = window.location.hash;
                const initialLink = navLinks.find(link => link.getAttribute('href') === initialHash) || navLinks[0];
                setActiveLink(initialLink);
            }

            navLinks.forEach(link => link.addEventListener('click', handleNavClick));

            if (sidebar && menuToggle && mainContent) {
                menuToggle.addEventListener('click', event => {
                    event.stopPropagation();
                    toggleSidebar();
                });

                if (overlay) overlay.addEventListener('click', closeSidebar);

                document.addEventListener('keydown', event => {
                    if (event.key === 'Escape') closeSidebar();
                });

                window.addEventListener('resize', handleResize);
                handleResize();
            }

            initDashboard();

            function handleNavClick(event) {
                event.preventDefault();
                const targetId = event.currentTarget.getAttribute('href');
                scrollToSection(targetId);
                setActiveLink(event.currentTarget);
                if (window.innerWidth <= 1024) closeSidebar();
            }

            function scrollToSection(targetId) {
                if (!targetId) return;
                if (targetId === '#dashboard-top') {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    return;
                }
                const targetElement = document.querySelector(targetId);
                if (!targetElement) return;
                const offset = Math.max(targetElement.getBoundingClientRect().top + window.scrollY - getHeaderOffset(), 0);
                window.scrollTo({ top: offset, behavior: 'smooth' });
            }

            function setActiveLink(activeLink) {
                navLinks.forEach(link => link.classList.toggle('active', link === activeLink));
            }

            function getHeaderOffset() {
                const header = document.querySelector('.main-header');
                return header ? header.offsetHeight + 16 : 0;
            }

            function createOverlay() {
                const element = document.createElement('div');
                element.className = 'sidebar-overlay';
                document.body.appendChild(element);
                return element;
            }

            function toggleSidebar() {
                if (!sidebar) return;
                const willOpen = !sidebar.classList.contains('open');
                sidebar.classList.toggle('open', willOpen);

                if (window.innerWidth > 1024) {
                    mainContent.classList.toggle('sidebar-open', willOpen);
                    hideOverlay();
                    document.body.style.overflow = '';
                    return;
                }

                if (willOpen) {
                    showOverlay();
                    document.body.style.overflow = 'hidden';
                } else {
                    hideOverlay();
                    document.body.style.overflow = '';
                }
            }

            function closeSidebar() {
                if (!sidebar) return;
                sidebar.classList.remove('open');
                mainContent.classList.remove('sidebar-open');
                hideOverlay();
                document.body.style.overflow = '';
            }

            function handleResize() {
                if (!sidebar) return;
                if (window.innerWidth > 1024) {
                    sidebar.classList.add('open');
                    mainContent.classList.add('sidebar-open');
                    hideOverlay();
                    document.body.style.overflow = '';
                } else {
                    sidebar.classList.remove('open');
                    mainContent.classList.remove('sidebar-open');
                    hideOverlay();
                    document.body.style.overflow = '';
                }
            }

            function showOverlay() {
                if (overlay) overlay.classList.add('show');
            }

            function hideOverlay() {
                if (overlay) overlay.classList.remove('show');
            }
        });

        const defaultAvatar = `data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0OCIgaGVpZ2h0PSI0OCIgZmlsbD0ibm9uZSI+PGNpcmNsZSBjeD0iMjQiIGN5PSIyNCIgcj0iMjQiIGZpbGw9IiNFNUU3RUIiLz48cGF0aCBmaWxsPSIjOTA5NUEwIiBkPSJNMjQgMjVjLTMuODY2IDAtNy0zLjEzNC03LTdzMy4xMzQtNyA3LTcgNyAzLjEzNCA3IDctMy4xMzQgNy03IDdabTAgMTRjLTcuNzMyIDAtMTQtMS4yNjgtMTQtNyAwLTUuNzMyIDYuMjY4LTcgMTQtNyA3LjczMiAwIDE0IDEuMjY4IDE0IDcgMCA1LjczMi02LjI2OCA3LTE0IDdaIi8+PC9zdmc+`;

        function displayCurrentDate() {
            const el = document.getElementById('currentDate');
            if (!el) return;
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            el.textContent = now.toLocaleDateString('id-ID', options);
        }

        function setWelcomeMessage(adminName) {
            const el = document.getElementById('welcomeMessage');
            if (el && adminName) el.textContent = `Selamat datang, ${adminName} 👋`;
        }

        function animateCountUp(el, finalValue, duration = 1500) {
            if (!el) return;
            let startTimestamp = null;
            const step = timestamp => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                el.textContent = Math.floor(progress * finalValue).toLocaleString('id-ID');
                if (progress < 1) window.requestAnimationFrame(step);
            };
            window.requestAnimationFrame(step);
        }

        function toggleStatCardSkeletons(show) {
            document.querySelectorAll('.stat-card').forEach(card => {
                card.classList.toggle('loading', show);
                if (!show) card.classList.add('fade-in-up');
            });
        }

        function debounce(fn, delay = 400) {
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => fn(...args), delay);
            };
        }

        const esc = s => String(s ?? '').replace(/[&<>"']/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', '\'': '&#39;' }[m]));

        function resolvePhotoPath(photo) {
            if (!photo) return defaultAvatar;
            const p = String(photo).trim();
            if (/^https?:\/\//i.test(p)) return p;
            if (p.startsWith('/storage/')) return p;
            if (p.startsWith('storage/')) return '/' + p;
            return '/storage/' + p.replace(/^\/+/, '');
        }

        const token = localStorage.getItem('admin_token');
        const adminData = JSON.parse(localStorage.getItem('admin_data') || '{}');
        if (!token) window.location.href = '/buku-tamu/admin';

        let perPage = 10;
        let currentPage = 1;
        let totalPages = 1;
        let currentFilters = {};
        let purposeChart;
        let monthlyChart;

        async function initDashboard() {
            document.getElementById('adminName').textContent = adminData.name || 'Admin';
            setWelcomeMessage(adminData.name || 'Admin');
            displayCurrentDate();
            await loadStatistics();
            await loadVisitors();
            setupFilters();
            initNameSearch();
        }

        function initNameSearch() {
            const nameSearch = document.getElementById('nameSearch');
            if (!nameSearch) return;
            nameSearch.value = currentFilters.name || '';
            const apply = debounce(value => {
                const trimmed = (value || '').trim();
                if (trimmed) currentFilters.name = trimmed;
                else delete currentFilters.name;
                loadVisitors(1);
            }, 400);
            nameSearch.addEventListener('input', e => apply(e.target.value));
        }

        async function loadStatistics() {
            toggleStatCardSkeletons(true);
            try {
                let url = '/api/statistics';
                const qs = new URLSearchParams();
                if (currentFilters.date) {
                    qs.set('date', String(currentFilters.date));
                } else if (currentFilters.month && currentFilters.year) {
                    qs.set('month', String(currentFilters.month));
                    qs.set('year', String(currentFilters.year));
                }
                const queryString = qs.toString();
                if (queryString) url += `?${queryString}`;

                const response = await fetch(url, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                });
                if (!response.ok) throw new Error(`HTTP ${response.status}`);
                const { data: raw = {} } = await response.json();

                const stats = {
                    total: raw.total ?? 0,
                    today: raw.today ?? 0,
                    this_month: raw.this_month ?? 0,
                    purpose_stats: Array.isArray(raw.purpose_stats) ? raw.purpose_stats : [],
                    monthly_stats: Array.isArray(raw.monthly_stats) ? raw.monthly_stats : []
                };

                animateCountUp(document.getElementById('totalVisitors'), stats.total);
                animateCountUp(document.getElementById('todayVisitors'), stats.today);
                animateCountUp(document.getElementById('monthVisitors'), stats.this_month);
                animateCountUp(document.getElementById('avgVisitors'), stats.total > 0 ? Math.round(stats.total / 30) : 0);

                let selectedYear = new Date().getFullYear();
                if (currentFilters.year) selectedYear = currentFilters.year;

                createPurposeChart(stats.purpose_stats);
                createMonthlyChart(stats.monthly_stats, { year: selectedYear });

                const semesterVisitors = document.getElementById('semesterVisitors');
                const semesterSelect = document.getElementById('semesterSelect');
                if (semesterVisitors && semesterSelect) {
                    const updateSemester = () => {
                        const semester = Number(semesterSelect.value);
                        const yearForSemester = new Date().getFullYear();
                        const months = semester === 1 ? [1, 2, 3, 4, 5, 6] : [7, 8, 9, 10, 11, 12];
                        const count = stats.monthly_stats
                            .filter(item => Number(item.year) === yearForSemester && months.includes(Number(item.month)))
                            .reduce((sum, item) => sum + Number(item.count || 0), 0);
                        animateCountUp(semesterVisitors, count);
                    };
                    updateSemester();
                    semesterSelect.addEventListener('change', updateSemester);
                }
            } catch (error) {
                console.error('Error loading statistics:', error);
            } finally {
                toggleStatCardSkeletons(false);
            }
        }

        function createPurposeChart(data) {
            const ctx = document.getElementById('purposeChart').getContext('2d');
            if (purposeChart) purposeChart.destroy();
            const purposeMap = {
                sekretariat: 'Sekretariat',
                aplikasi_informatika: 'Aplikasi Informatika',
                informasi_komunikasi_publik: 'Komunikasi Publik',
                statistik: 'Statistik',
                persandian_keamanan_informasi: 'Persandian'
            };
            const colorMap = {
                sekretariat: '#8B5CF6',
                aplikasi_informatika: '#3B82F6',
                informasi_komunikasi_publik: '#F59E0B',
                statistik: '#10B981',
                persandian_keamanan_informasi: '#EF4444'
            };
            const source = Array.isArray(data) ? data : [];
            const labels = source.map(item => purposeMap[item.purpose] ?? (item.purpose ?? 'Lainnya'));
            const counts = source.map(item => Number(item.count ?? 0));
            const finalLabels = labels.length ? labels : ['Tidak ada data'];
            const finalCounts = counts.length ? counts : [1];
            const finalColors = source.length ? source.map(item => colorMap[item.purpose] ?? '#D1D5DB') : ['#F3F4F6'];

            purposeChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: finalLabels,
                    datasets: [{
                        data: finalCounts,
                        backgroundColor: finalColors,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: { family: "'Poppins', sans-serif" }
                            }
                        }
                    }
                }
            });
        }

        function createMonthlyChart(data, opts = {}) {
            const ctx = document.getElementById('monthlyChart').getContext('2d');
            if (monthlyChart) monthlyChart.destroy();
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
            const byMonth = Array(12).fill(0);
            const targetYear = opts && opts.year != null ? Number(opts.year) : new Date().getFullYear();

            (Array.isArray(data) ? data : []).forEach(item => {
                const year = Number(item.year);
                const month = Number(item.month);
                const count = Number(item.count || 0);
                if (!month || month < 1 || month > 12) return;
                if (!Number.isNaN(year) && year !== targetYear) return;
                byMonth[month - 1] = count;
            });

            const primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--primary-color').trim() || '#4F46E5';

            monthlyChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Pengunjung',
                        data: byMonth,
                        borderColor: primaryColor,
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                font: { family: "'Poppins', sans-serif" }
                            }
                        },
                        x: { ticks: { font: { family: "'Poppins', sans-serif" } } }
                    }
                }
            });
        }

        async function loadVisitors(page = 1) {
            const loading = document.getElementById('tableLoading');
            const container = document.getElementById('tableContainer');
            try {
                loading.style.display = 'block';
                container.style.display = 'none';

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
                if (response.ok && result?.success) {
                    const meta = result.data;
                    perPage = meta?.per_page ?? perPage;
                    displayVisitors(meta?.data ?? [], meta?.from ?? 1);
                    updatePagination(meta ?? { current_page: 1, last_page: 1 });
                } else {
                    document.getElementById('visitorsTableBody').innerHTML = `<tr><td colspan="9" style="text-align:center; padding: 40px;">Tidak ada data pengunjung</td></tr>`;
                }
            } catch (error) {
                console.error('Error loading visitors:', error);
                document.getElementById('visitorsTableBody').innerHTML = `<tr><td colspan="9" style="text-align:center; padding: 40px; color: var(--danger-color);">Gagal memuat data.</td></tr>`;
            } finally {
                loading.style.display = 'none';
                container.style.display = 'block';
            }
        }

        function displayVisitors(visitors, startFrom = 1) {
            const tbody = document.getElementById('visitorsTableBody');
            tbody.innerHTML = '';
            if (visitors.length === 0) {
                tbody.innerHTML = `<tr><td colspan="9" style="text-align:center; padding: 40px;">Tidak ada data untuk filter yang dipilih.</td></tr>`;
                return;
            }
            visitors.forEach((visitor, index) => {
                const row = document.createElement('tr');
                const prettyDate = new Date(visitor.created_at).toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                const rawPhoto = visitor.photo || visitor.photo_path || visitor.avatar || '';
                const photoUrl = resolvePhotoPath(rawPhoto);
                const purposeClass = `purpose-${visitor.purpose}`;
                const purposeText = {
                    sekretariat: 'Sekretariat',
                    aplikasi_informatika: 'Aplikasi Informatika',
                    informasi_komunikasi_publik: 'Komunikasi Publik',
                    statistik: 'Statistik',
                    persandian_keamanan_informasi: 'Persandian'
                }[visitor.purpose] || (visitor.purpose || '-');

                row.innerHTML = `
                    <td>${startFrom + index}</td>
                    <td>${esc(prettyDate)}</td>
                    <td><img src="${photoUrl}" alt="Foto ${esc(visitor.name || '')}" class="photo-thumb" data-full="${photoUrl}" data-name="${esc(visitor.name || '')}" data-date="${esc(prettyDate)}" onerror="this.onerror=null;this.src='${defaultAvatar}'"/></td>
                    <td><strong>${esc(visitor.name || '-')}</strong></td>
                    <td>${esc(visitor.email || '-')}</td>
                    <td>${esc(visitor.phone || '-')}</td>
                    <td>${esc(visitor.asal_daerah || '-')}</td>
                    <td><span class="purpose-badge ${purposeClass}">${esc(purposeText)}</span></td>
                    <td>${esc(visitor.notes || '-')}</td>
                    <td><button class="action-btn delete" onclick="showDeleteModal(${visitor.id})" title="Hapus Data"><svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:20px;height:20px;"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.134-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.067-2.09 1.02-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg></button></td>
                `;
                tbody.appendChild(row);
            });
        }

        function updatePagination(data) {
            currentPage = data.current_page;
            totalPages = data.last_page;
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';
            if (totalPages <= 1) return;

            const prevBtn = document.createElement('button');
            prevBtn.innerHTML = '&larr; Prev';
            prevBtn.disabled = currentPage === 1;
            prevBtn.onclick = () => { if (currentPage > 1) loadVisitors(currentPage - 1); };
            pagination.appendChild(prevBtn);

            for (let i = Math.max(1, currentPage - 2); i <= Math.min(totalPages, currentPage + 2); i += 1) {
                const pageBtn = document.createElement('button');
                pageBtn.textContent = i;
                pageBtn.className = i === currentPage ? 'active' : '';
                pageBtn.onclick = () => loadVisitors(i);
                pagination.appendChild(pageBtn);
            }

            const nextBtn = document.createElement('button');
            nextBtn.innerHTML = 'Next &rarr;';
            nextBtn.disabled = currentPage === totalPages;
            nextBtn.onclick = () => { if (currentPage < totalPages) loadVisitors(currentPage + 1); };
            pagination.appendChild(nextBtn);
        }

        function setupFilters() {
            const purposeFilter = document.getElementById('purposeFilter');
            const dateFilter = document.getElementById('dateFilter');
            const todayFilter = document.getElementById('todayFilter');

            if (purposeFilter) {
                purposeFilter.value = currentFilters.purpose || '';
                purposeFilter.addEventListener('change', function () {
                    currentFilters.purpose = this.value;
                    loadVisitors(1);
                });
            }

            if (dateFilter) {
                dateFilter.value = currentFilters.date || '';
                dateFilter.addEventListener('change', function () {
                    delete currentFilters.month;
                    delete currentFilters.year;
                    currentFilters.date = this.value;
                    loadVisitors(1);
                    loadStatistics();
                });
            }

            if (todayFilter && dateFilter) {
                todayFilter.addEventListener('click', () => {
                    const now = new Date();
                    const year = now.getFullYear();
                    const month = String(now.getMonth() + 1).padStart(2, '0');
                    const day = String(now.getDate()).padStart(2, '0');
                    dateFilter.value = `${year}-${month}-${day}`;
                    dateFilter.dispatchEvent(new Event('change'));
                });
            }
        }

        let deleteTargetId = null;

        function showDeleteModal(id) {
            deleteTargetId = id;
            document.getElementById('deleteMessage').textContent = "Apakah Anda yakin ingin menghapus data pengunjung ini secara permanen?";
            document.getElementById('deleteModal').classList.add('open');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('open');
            deleteTargetId = null;
        }

        async function confirmDelete() {
            if (!deleteTargetId) return;
            try {
                const response = await fetch(`/api/visitors/${deleteTargetId}`, {
                    method: 'DELETE',
                    headers: {
                        Authorization: `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const result = await response.json();
                if (result.success) {
                    showToast("Data berhasil dihapus", "success");
                    loadVisitors(currentPage);
                    loadStatistics();
                } else {
                    showToast("Gagal menghapus data", "error");
                }
            } catch (error) {
                console.error(error);
                showToast("Terjadi kesalahan saat menghapus data", "error");
            }
            closeDeleteModal();
        }

        function showToast(message, type = "success") {
            const toast = document.getElementById("toast");
            toast.textContent = message;
            toast.className = `toast ${type} show`;
            setTimeout(() => toast.classList.remove("show"), 3000);
        }

        const imgModal = document.getElementById('imgModal');
        const imgPreview = document.getElementById('imgPreview');
        const imgMeta = document.getElementById('imgMeta');
        const imgClose = document.getElementById('imgClose');
        const visitorsTableBody = document.getElementById('visitorsTableBody');

        if (imgPreview) {
            imgPreview.onerror = function () {
                this.onerror = null;
                this.src = defaultAvatar;
            };
        }

        if (visitorsTableBody && imgModal && imgPreview && imgMeta) {
            visitorsTableBody.addEventListener('click', event => {
                const img = event.target.closest('img.photo-thumb');
                if (!img) return;
                imgPreview.src = img.dataset.full || img.src;
                imgMeta.textContent = `${img.dataset.name || ''}${img.dataset.date ? ` • ${img.dataset.date}` : ''}`;
                imgModal.classList.add('open');
            });
        }

        function closeImgModal() {
            if (!imgModal) return;
            imgModal.classList.remove('open');
            if (imgPreview) imgPreview.src = '';
        }

        if (imgClose) imgClose.addEventListener('click', closeImgModal);
        if (imgModal) {
            imgModal.addEventListener('click', event => {
                if (event.target === imgModal) closeImgModal();
            });
        }

        document.addEventListener('keydown', event => {
            if (event.key === 'Escape') closeImgModal();
        });

        function logout() {
            localStorage.removeItem('admin_token');
            localStorage.removeItem('admin_data');
            window.location.href = '/buku-tamu/admin';
        }

        function showExportModal() {
            document.getElementById('exportPurpose').value = currentFilters.purpose || '';
            const exportMonthInput = document.getElementById('exportMonth');
            if (currentFilters.month && currentFilters.year) {
                const month = String(currentFilters.month).padStart(2, '0');
                exportMonthInput.value = `${currentFilters.year}-${month}`;
            } else {
                exportMonthInput.value = '';
            }
            document.getElementById('exportModal').classList.add('open');
        }

        function closeExportModal() {
            document.getElementById('exportModal').classList.remove('open');
        }

        function downloadPDF() {
            const format = document.getElementById('paperFormat').value;
            const orientation = document.getElementById('paperOrientation').value;
            const purpose = document.getElementById('exportPurpose').value;
            const monthYear = document.getElementById('exportMonth').value;
            const params = new URLSearchParams({ format, orientation });
            if (purpose) params.append('purpose', purpose);
            if (monthYear) {
                const [year, month] = monthYear.split('-');
                params.append('month', String(Number(month)));
                params.append('year', year);
            }
            const url = `/api/export/pdf?${params.toString()}`;
            closeExportModal();
            window.open(url, '_blank');
        }

        window.onclick = function (event) {
            if (event.target.classList.contains('modal')) event.target.classList.remove('open');
        };
    </script>
</body>
</html>
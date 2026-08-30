<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dashboard Analytics - Admin Buku Tamu</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-buku.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-buku.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.05);
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
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

        /* ===== Main Wrapper ===== */
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

        .topbar-title h1 {
            font-family: var(--font-heading);
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .topbar-title p {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .content-container {
            padding: 32px;
            max-width: 1400px;
            width: 100%;
        }

        /* ===== Stat Cards Grid ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-info h3 {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 6px;
        }

        .stat-number {
            font-family: var(--font-heading);
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1.1;
        }

        .stat-desc {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .stat-icon.blue { background: #eff6ff; color: #2563eb; }
        .stat-icon.emerald { background: #ecfdf5; color: #059669; }
        .stat-icon.amber { background: #fffbeb; color: #d97706; }
        .stat-icon.purple { background: #faf5ff; color: #7c3aed; }

        /* ===== Charts Grid ===== */
        .charts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 32px;
        }

        .chart-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .chart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .chart-header h3 {
            font-family: var(--font-heading);
            font-size: 1.05rem;
            font-weight: 700;
        }

        .chart-wrapper {
            position: relative;
            height: 280px;
            width: 100%;
        }

        /* ===== Recent Visitors Preview Card ===== */
        .section-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .section-header-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .section-header-box h3 {
            font-family: var(--font-heading);
            font-size: 1.1rem;
            font-weight: 700;
        }

        .btn-view-all {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-family: var(--font-heading);
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 8px;
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            transition: all 0.2s ease;
        }

        .btn-view-all:hover {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
        }

        .simple-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .simple-table th {
            background: #f8fafc;
            padding: 12px 16px;
            font-family: var(--font-heading);
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
        }

        .simple-table td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.9rem;
            vertical-align: middle;
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

        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .charts-grid { grid-template-columns: 1fr; }
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
                <a href="{{ route('admin.dashboard') }}" class="active">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Dashboard Analytics</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.visitors') }}">
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

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-title">
                <h1>Dashboard Statistik Kunjungan</h1>
                <p id="welcomeMessage">Ringkasan aktivitas tamu dan statistik pelayanan digital</p>
            </div>
            <div>
                <span id="currentDate" class="small text-muted font-weight-medium"></span>
            </div>
        </header>

        <main class="content-container">
            <!-- Stat Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Total Pengunjung</h3>
                        <div class="stat-number" id="totalVisitors">0</div>
                        <div class="stat-desc">Akumulasi keseluruhan</div>
                    </div>
                    <div class="stat-icon blue">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Hari Ini</h3>
                        <div class="stat-number" id="todayVisitors">0</div>
                        <div class="stat-desc">Kunjungan tercatat hari ini</div>
                    </div>
                    <div class="stat-icon emerald">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Bulan Ini</h3>
                        <div class="stat-number" id="monthVisitors">0</div>
                        <div class="stat-desc">Total kunjungan bulan berjalan</div>
                    </div>
                    <div class="stat-icon amber">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Semester Ini</h3>
                        <div class="stat-number" id="semesterVisitors">0</div>
                        <div class="stat-desc">Total periode 6 bulan</div>
                    </div>
                    <div class="stat-icon purple">
                        <i class="fa-solid fa-chart-simple"></i>
                    </div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="charts-grid">
                <div class="chart-card">
                    <div class="chart-header">
                        <h3>Distribusi Tujuan Kunjungan</h3>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="purposeChart"></canvas>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="chart-header">
                        <h3>Tren Kunjungan Bulanan ({{ date('Y') }})</h3>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Visitors Table Preview -->
            <div class="section-card">
                <div class="section-header-box">
                    <div>
                        <h3>Kunjungan Terbaru Hari Ini</h3>
                        <p class="small text-muted mb-0">Daftar tamu yang mengisi buku tamu digital hari ini</p>
                    </div>
                    <a href="{{ route('admin.visitors') }}" class="btn-view-all">
                        <span>Buka Halaman Pengunjung</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <div style="overflow-x:auto;">
                    <table class="simple-table">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Nama Tamu</th>
                                <th>Asal Instansi</th>
                                <th>Tujuan Bidang</th>
                                <th>Keperluan</th>
                            </tr>
                        </thead>
                        <tbody id="recentVisitorsBody">
                            <tr>
                                <td colspan="5" style="text-align:center; padding:24px; color:var(--text-muted);">
                                    Memuat data kunjungan terbaru...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        const token = localStorage.getItem('admin_token');
        const adminData = JSON.parse(localStorage.getItem('admin_data') || '{}');
        if (!token) window.location.href = '{{ route("admin.login") }}';

        let purposeChart;
        let monthlyChart;

        const purposeLabels = {
            sekretariat: 'Sekretariat',
            aplikasi_informatika: 'Aplikasi Informatika (Aptika)',
            informasi_komunikasi_publik: 'Informasi & Komunikasi Publik (IKP)',
            statistik: 'Statistik Sektoral',
            persandian_keamanan_informasi: 'Persandian & Keamanan Informasi'
        };

        const esc = s => String(s ?? '').replace(/[&<>"']/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', '\'': '&#39;' }[m]));

        document.addEventListener('DOMContentLoaded', async () => {
            document.getElementById('adminName').textContent = adminData.name || 'Admin';
            document.getElementById('currentDate').textContent = new Date().toLocaleDateString('id-ID', {
                weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
            });

            await loadStatistics();
            await loadRecentVisitors();
        });

        async function loadStatistics() {
            try {
                const response = await fetch('/api/statistics', {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Failed to load stats');
                const { data: raw = {} } = await response.json();

                document.getElementById('totalVisitors').textContent = (raw.total ?? 0).toLocaleString('id-ID');
                document.getElementById('todayVisitors').textContent = (raw.today ?? 0).toLocaleString('id-ID');
                document.getElementById('monthVisitors').textContent = (raw.this_month ?? 0).toLocaleString('id-ID');

                // Semester calculation
                const currentMonth = new Date().getMonth() + 1;
                const currentYear = new Date().getFullYear();
                const semesterMonths = currentMonth <= 6 ? [1, 2, 3, 4, 5, 6] : [7, 8, 9, 10, 11, 12];
                const monthlyStats = Array.isArray(raw.monthly_stats) ? raw.monthly_stats : [];
                const semesterTotal = monthlyStats
                    .filter(m => Number(m.year) === currentYear && semesterMonths.includes(Number(m.month)))
                    .reduce((sum, item) => sum + Number(item.count || 0), 0);

                document.getElementById('semesterVisitors').textContent = semesterTotal.toLocaleString('id-ID');

                renderPurposeChart(raw.purpose_stats || []);
                renderMonthlyChart(raw.monthly_stats || []);
            } catch (e) {
                console.error(e);
            }
        }

        function renderPurposeChart(data) {
            const ctx = document.getElementById('purposeChart').getContext('2d');
            if (purposeChart) purposeChart.destroy();

            const labels = data.map(item => purposeLabels[item.purpose] || item.purpose);
            const counts = data.map(item => Number(item.count || 0));
            const colors = ['#0284c7', '#059669', '#d97706', '#7c3aed', '#db2777'];

            purposeChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels.length ? labels : ['Belum ada data'],
                    datasets: [{
                        data: counts.length ? counts : [1],
                        backgroundColor: counts.length ? colors : ['#e2e8f0'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 12, padding: 16 } }
                    }
                }
            });
        }

        function renderMonthlyChart(data) {
            const ctx = document.getElementById('monthlyChart').getContext('2d');
            if (monthlyChart) monthlyChart.destroy();

            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
            const counts = Array(12).fill(0);
            const currentYear = new Date().getFullYear();

            data.forEach(item => {
                if (Number(item.year) === currentYear && item.month >= 1 && item.month <= 12) {
                    counts[item.month - 1] = Number(item.count || 0);
                }
            });

            monthlyChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: monthNames,
                    datasets: [{
                        label: 'Pengunjung',
                        data: counts,
                        borderColor: '#0284c7',
                        backgroundColor: 'rgba(2, 132, 199, 0.08)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2.5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        async function loadRecentVisitors() {
            const today = new Date().toISOString().split('T')[0];
            const tbody = document.getElementById('recentVisitorsBody');
            try {
                const response = await fetch(`/api/visitors?date=${today}&page=1`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                });

                const result = await response.json();
                const list = result?.data?.data || [];

                if (!list.length) {
                    tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding:24px; color:var(--text-muted);">Belum ada kunjungan yang tercatat untuk hari ini.</td></tr>';
                    return;
                }

                tbody.innerHTML = list.slice(0, 5).map(v => {
                    const timeStr = v.created_at ? new Date(v.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) : '-';
                    const purposeText = purposeLabels[v.purpose] || (v.purpose || '-');
                    const badgeClass = `badge-${v.purpose}`;

                    return `
                        <tr>
                            <td style="font-weight:600; color:var(--primary);">${timeStr}</td>
                            <td><strong>${esc(v.name)}</strong></td>
                            <td>${esc(v.asal_daerah || '-')}</td>
                            <td><span class="badge-purpose ${badgeClass}">${purposeText}</span></td>
                            <td style="color:var(--text-muted); font-size:0.85rem;">${esc(v.notes || '-')}</td>
                        </tr>
                    `;
                }).join('');
            } catch (e) {
                tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding:24px; color:var(--danger);">Gagal memuat kunjungan terbaru.</td></tr>';
            }
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
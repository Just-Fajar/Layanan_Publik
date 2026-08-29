<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Pengunjung - Buku Tamu Digital</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-buku.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-buku.png') }}">
    <style>
        :root {
            --primary: #667eea;
            --primary-dark: #5a67d8;
            --accent: #764ba2;
            --bg-main: #f7f9fc;
            --text-main: #333;
            --text-muted: #667eea;
            --surface: rgba(255, 255, 255, 0.95);
            --border: #e1e5e9;
            --shadow-sm: 0 2px 8px rgba(102, 126, 234, 0.3);
            --shadow-md: 0 10px 30px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 40px rgba(0, 0, 0, 0.1);
            --radius-lg: 20px;
            --radius-md: 15px;
            --transition: all 0.3s ease;
            --purpose-sekretariat: #8b5cf6;
            --purpose-aplikasi_informatika: #3b82f6;
            --purpose-persandian_keamanan_informasi: #f97316;
            --purpose-informasi_komunikasi_publik: #f59e0b;
            --purpose-statistik: #10b981;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ffffff, var(--bg-main));
            min-height: 100vh;
            padding: 20px;
            color: var(--text-main);
        }

        .header {
            background: var(--surface);
            border: 4px solid var(--border);
            border-radius: var(--radius-md);
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: var(--shadow-md);
            backdrop-filter: blur(10px);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .logo {
            height: 50px;
            width: auto;
        }

        .header h1 {
            font-size: 1.8rem;
            font-weight: 600;
        }

        .nav-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
            color: #fff;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .calendar-container {
            background: var(--surface);
            border-radius: var(--radius-lg);
            padding: 30px;
            box-shadow: var(--shadow-lg);
            backdrop-filter: blur(10px);
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
            flex-wrap: wrap;
            gap: 16px;
        }

        .calendar-nav {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-btn {
            background: var(--primary);
            color: #fff;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .nav-btn:hover {
            background: var(--primary-dark);
            transform: scale(1.1);
        }

        .current-month {
            min-width: 200px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background: #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
        }

        .calendar-day-header {
            background: var(--primary);
            color: #fff;
            padding: 15px 5px;
            text-align: center;
            font-weight: 600;
            font-size: 14px;
        }

        .calendar-day {
            background: #fff;
            min-height: 120px;
            padding: 8px;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
        }

        .calendar-day:hover {
            background: #f7fafc;
        }

        .calendar-day.other-month {
            background: #f8f9fa;
            color: #adb5bd;
        }

        .calendar-day.today {
            background: #e3f2fd;
            border: 2px solid #2196f3;
        }

        .day-number {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .visitor-count {
            background: var(--primary);
            color: #fff;
            border-radius: 12px;
            padding: 2px 8px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 5px;
        }

        .visitor-dots {
            display: flex;
            flex-wrap: wrap;
            gap: 2px;
        }

        .visitor-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .legend {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 500;
        }

        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .loading {
            text-align: center;
            padding: 50px;
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        .spinner {
            display: inline-block;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary);
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        .modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 1000;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal.open {
            display: flex;
        }

        .modal-content {
            background: #fff;
            border-radius: var(--radius-lg);
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
            padding: 30px;
            box-shadow: var(--shadow-lg);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .modal-title {
            font-size: 1.3rem;
            font-weight: 600;
        }

        .modal-close {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: none;
            background: transparent;
            font-size: 22px;
            color: #aaa;
            cursor: pointer;
            transition: var(--transition);
        }

        .modal-close:hover {
            background: #f0f0f0;
            color: var(--text-main);
        }

        .visitor-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .visitor-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            border-left: 4px solid var(--primary);
            display: grid;
            gap: 10px;
        }

        .visitor-name {
            font-weight: 600;
        }

        .visitor-details {
            font-size: 14px;
            line-height: 1.4;
            color: #333;
        }

        .visitor-note {
            font-weight: 600;
            color: #050505;
        }

        .purpose-visitor {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            color: #000;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .purpose-visitor.sekretariat { background: var(--purpose-sekretariat); }
        .purpose-visitor.aplikasi_informatika { background: var(--purpose-aplikasi_informatika); }
        .purpose-visitor.persandian_keamanan_informasi { background: var(--purpose-persandian_keamanan_informasi); }
        .purpose-visitor.informasi_komunikasi_publik { background: var(--purpose-informasi_komunikasi_publik); }
        .purpose-visitor.statistik { background: var(--purpose-statistik); }

        .dot-sekretariat { background: var(--purpose-sekretariat); }
        .dot-aplikasi_informatika { background: var(--purpose-aplikasi_informatika); }
        .dot-persandian_keamanan_informasi { background: var(--purpose-persandian_keamanan_informasi); }
        .dot-informasi_komunikasi_publik { background: var(--purpose-informasi_komunikasi_publik); }
        .dot-statistik { background: var(--purpose-statistik); }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .calendar-container { padding: 20px 15px; }
            .calendar-nav { width: 100%; justify-content: center; }
            .current-month { width: 100%; }
            .calendar-day { min-height: 80px; padding: 6px; }
            .day-number { font-size: 14px; }
            .visitor-count { font-size: 10px; padding: 1px 6px; }
            .legend { flex-direction: column; gap: 10px; }
            .modal-content { padding: 20px; }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <div class="header-left">
                <img src="/images/logo-diskominfo.png" alt="Logo Diskominfo" class="logo">
                <h1>Kalender Pengunjung</h1>
            </div>
            <nav class="nav-buttons">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Dashboard</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="calendar-container">
            <div class="calendar-header">
                <div class="calendar-nav">
                    <button type="button" class="nav-btn" data-action="prev-month" aria-label="Bulan sebelumnya">‹</button>
                    <div class="current-month" id="currentMonth">Loading...</div>
                    <button type="button" class="nav-btn" data-action="next-month" aria-label="Bulan selanjutnya">›</button>
                </div>
                <button type="button" class="btn btn-primary" data-action="go-today">Hari Ini</button>
            </div>

            <div id="calendarLoading" class="loading">
                <div class="spinner"></div>
                Memuat data kalender...
            </div>

            <div id="calendarGrid" class="calendar-grid" hidden></div>

            <div class="legend">
                <div class="legend-item"><span class="legend-dot dot-sekretariat"></span><span>Sekretariat</span></div>
                <div class="legend-item"><span class="legend-dot dot-aplikasi_informatika"></span><span>Aplikasi Informatika</span></div>
                <div class="legend-item"><span class="legend-dot dot-persandian_keamanan_informasi"></span><span>Persandian dan Keamanan Informasi</span></div>
                <div class="legend-item"><span class="legend-dot dot-informasi_komunikasi_publik"></span><span>Informasi dan Komunikasi Publik</span></div>
                <div class="legend-item"><span class="legend-dot dot-statistik"></span><span>Statistik</span></div>
            </div>
        </section>
    </main>

    <div id="dayModal" class="modal" aria-hidden="true" role="dialog" aria-modal="true">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modalTitle">Detail Pengunjung</h2>
                <button type="button" class="modal-close" data-action="close-modal" aria-label="Tutup">&times;</button>
            </div>
            <div id="modalContent"></div>
        </div>
    </div>

    <script>
        (() => {
            const API_URL = '/api/visitors?per_page=1000';
            const MONTH_NAMES = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            const DAY_HEADERS = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const PURPOSE_LABELS = {
                sekretariat: 'Sekretariat',
                aplikasi_informatika: 'Aplikasi Informatika',
                persandian_keamanan_informasi: 'Persandian dan Keamanan Informasi',
                informasi_komunikasi_publik: 'Informasi dan Komunikasi Publik',
                statistik: 'Statistik'
            };

            const monthYearFormatter = new Intl.DateTimeFormat('id-ID', { month: 'long', year: 'numeric' });
            const timeFormatter = new Intl.DateTimeFormat('id-ID', { hour: '2-digit', minute: '2-digit' });

            const currentMonthEl = document.getElementById('currentMonth');
            const calendarGridEl = document.getElementById('calendarGrid');
            const calendarLoadingEl = document.getElementById('calendarLoading');
            const modalEl = document.getElementById('dayModal');
            const modalTitleEl = document.getElementById('modalTitle');
            const modalContentEl = document.getElementById('modalContent');

            let currentDate = new Date();
            let visitorData = Object.create(null);

            document.addEventListener('DOMContentLoaded', init);

            function init() {
                attachEventListeners();
                loadVisitorData().then(renderCalendar);
            }

            function attachEventListeners() {
                document.querySelector('[data-action="prev-month"]').addEventListener('click', () => changeMonth(-1));
                document.querySelector('[data-action="next-month"]').addEventListener('click', () => changeMonth(1));
                document.querySelector('[data-action="go-today"]').addEventListener('click', () => { currentDate = new Date(); renderCalendar(); });

                calendarGridEl.addEventListener('click', event => {
                    const dayCell = event.target.closest('.calendar-day[data-date]');
                    if (!dayCell) return;
                    const { date: dateKey, day, monthYear } = dayCell.dataset;
                    showDayDetails(dateKey, Number(day), monthYear);
                });

                modalEl.addEventListener('click', event => {
                    if (event.target === modalEl || event.target.closest('[data-action="close-modal"]')) closeModal();
                });

                document.addEventListener('keydown', event => {
                    if (event.key === 'Escape') closeModal();
                });
            }

            async function loadVisitorData() {
                try {
                    const response = await fetch(API_URL);
                    const json = await response.json();
                    const records = json?.data?.data ?? [];
                    visitorData = records.reduce((acc, item) => {
                        const visitDate = item.visit_date || item.created_at;
                        const dateObject = visitDate ? new Date(visitDate) : null;
                        if (!dateObject || Number.isNaN(dateObject.getTime())) return acc;
                        const key = formatDateKey(dateObject);
                        (acc[key] = acc[key] || []).push(item);
                        return acc;
                    }, Object.create(null));
                } catch (error) {
                    console.error('Error loading visitor data:', error);
                    visitorData = Object.create(null);
                }
            }

            function renderCalendar() {
                currentMonthEl.textContent = `${MONTH_NAMES[currentDate.getMonth()]} ${currentDate.getFullYear()}`;

                const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
                const startDayOfWeek = firstDayOfMonth.getDay();
                const daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();
                const daysInPrevMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 0).getDate();
                const todayKey = formatDateKey(new Date());

                const cells = [
                    ...DAY_HEADERS.map(day => `<div class="calendar-day-header">${day}</div>`),
                    ...createLeadingDays(startDayOfWeek, daysInPrevMonth, todayKey),
                    ...createCurrentMonthDays(daysInMonth, todayKey),
                    ...createTrailingDays(startDayOfWeek, daysInMonth, todayKey)
                ];

                calendarGridEl.innerHTML = cells.join('');
                calendarGridEl.hidden = false;
                calendarLoadingEl.style.display = 'none';
            }

            function createLeadingDays(startDayOfWeek, daysInPrevMonth, todayKey) {
                const cells = [];
                for (let index = startDayOfWeek - 1; index >= 0; index -= 1) {
                    const date = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, daysInPrevMonth - index);
                    cells.push(renderDayCell(date, todayKey, true));
                }
                return cells;
            }

            function createCurrentMonthDays(daysInMonth, todayKey) {
                const cells = [];
                for (let day = 1; day <= daysInMonth; day += 1) {
                    const date = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
                    cells.push(renderDayCell(date, todayKey));
                }
                return cells;
            }

            function createTrailingDays(startDayOfWeek, daysInMonth, todayKey) {
                const totalCells = Math.ceil((startDayOfWeek + daysInMonth) / 7) * 7;
                const remainingCells = totalCells - (startDayOfWeek + daysInMonth);
                const cells = [];
                for (let day = 1; day <= remainingCells; day += 1) {
                    const date = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, day);
                    cells.push(renderDayCell(date, todayKey, true));
                }
                return cells;
            }

            function renderDayCell(date, todayKey, isOtherMonth = false) {
                const day = date.getDate();
                const dateKey = formatDateKey(date);
                const visitors = visitorData[dateKey] || [];
                const classes = ['calendar-day'];
                if (isOtherMonth) classes.push('other-month');
                if (dateKey === todayKey) classes.push('today');

                const visitorMarkup = visitors.length ? buildVisitorSummary(visitors) : '';

                return `
                    <div class="${classes.join(' ')}" data-date="${dateKey}" data-day="${day}" data-month-year="${monthYearFormatter.format(date)}">
                        <div class="day-number">${day}</div>
                        ${visitorMarkup}
                    </div>
                `;
            }

            function buildVisitorSummary(visitors) {
                const purposeCounts = visitors.reduce((acc, { purpose }) => {
                    if (!purpose) return acc;
                    acc[purpose] = (acc[purpose] || 0) + 1;
                    return acc;
                }, Object.create(null));

                const dots = Object.entries(purposeCounts)
                    .map(([purpose, count]) => Array(Math.min(count, 10)).fill(`<span class="visitor-dot dot-${purpose}"></span>`).join(''))
                    .join('');

                return `
                    <div class="visitor-count">${visitors.length} pengunjung</div>
                    <div class="visitor-dots">${dots}</div>
                `;
            }

            function showDayDetails(dateKey, day, monthYear) {
                const visitors = visitorData[dateKey] || [];
                modalTitleEl.textContent = `${day} ${monthYear} - ${visitors.length} Pengunjung`;

                if (!visitors.length) {
                    modalContentEl.innerHTML = '<p style="text-align:center; color:#666; padding:20px;">Tidak ada pengunjung pada tanggal ini.</p>';
                } else {
                    modalContentEl.innerHTML = `
                        <ul class="visitor-list">
                            ${visitors.map(buildVisitorListItem).join('')}
                        </ul>
                    `;
                }

                modalEl.classList.add('open');
                modalEl.setAttribute('aria-hidden', 'false');
            }

            function buildVisitorListItem(visitor) {
                const purposeKey = visitor.purpose || 'lainnya';
                const purposeLabel = PURPOSE_LABELS[purposeKey] || purposeKey;
                const visitDate = new Date(visitor.visit_date || visitor.created_at || Date.now());

                return `
                    <li class="visitor-item">
                        <span class="purpose-visitor ${purposeKey}">${purposeLabel}</span>
                        <div class="visitor-name">Nama: ${escapeHtml(visitor.name || '-')}</div>
                        <div class="visitor-details">
                            <div>Waktu: ${timeFormatter.format(visitDate)} WIB</div>
                            <div>Email: ${escapeHtml(visitor.email || '-')}</div>
                            <div>Telepon: ${escapeHtml(visitor.phone || '-')}</div>
                            <div>Asal Daerah: ${escapeHtml(visitor.asal_daerah || '-')}</div>
                        </div>
                        ${visitor.notes ? `<div class="visitor-note">Keperluan: ${escapeHtml(visitor.notes)}</div>` : ''}
                    </li>
                `;
            }

            function closeModal() {
                modalEl.classList.remove('open');
                modalEl.setAttribute('aria-hidden', 'true');
            }

            function changeMonth(step) {
                currentDate.setMonth(currentDate.getMonth() + step);
                renderCalendar();
            }

            function formatDateKey(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            function escapeHtml(str) {
                return String(str)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }
        })();
    </script>
</body>
</html>
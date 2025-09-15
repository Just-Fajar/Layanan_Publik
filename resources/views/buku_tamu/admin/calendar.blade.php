<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Pengunjung - Buku Tamu Digital</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, white);
            min-height: 100vh;
            padding: 20px;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            border: 4px solid #e1e5e9;
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            color: #333;
        }

        .nav-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
            text-decoration: none;
            color: white;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .calendar-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .calendar-nav {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-btn {
            background: #667eea;
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .nav-btn:hover {
            background: #5a67d8;
            transform: scale(1.1);
        }

        .current-month {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            min-width: 200px;
            text-align: center;
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
            background: #667eea;
            color: white;
            padding: 15px 5px;
            text-align: center;
            font-weight: 600;
            font-size: 14px;
        }

        .calendar-day {
            background: white;
            min-height: 120px;
            padding: 8px;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
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
            background: #667eea;
            color: white;
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
            margin: 1px;
        }

        .dot-sekretariat {
            background: #8b5cf6;
        }

        .dot-aplikasi_informatika {
            background: #3b82f6;
        }

        .dot-persandian_keamanan_informasi {
            background: #f97316;
        }

        .dot-informasi_komunikasi_publik {
            background: #f59e0b;
        }

        .dot-statistik {
            background: #10b981;
        }

        .legend {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
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

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background: white;
            margin: 5% auto;
            padding: 30px;
            border-radius: 20px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
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
            color: #333;
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .close:hover {
            color: #333;
            background: #f0f0f0;
        }

        .visitor-list {
            list-style: none;
        }

        .visitor-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            border-left: 4px solid #667eea;
        }

        .visitor-name {
            font-weight: 600;
            color: #000000;
            margin-bottom: 10px;
        }

        .visitor-note {
            font-weight: 600;
            color: #050505;
            margin-top: 5px;
        }
        .visitor-details {
            font-size: 14px;
            color: #333;
            line-height: 1.4;
        }

        .visitor-purpose {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            color: white;
            margin-top: 5px;
        }

        .purpose-aplikasi {
            background: #3b82f6;
        }

        .purpose-persandian {
            background: #f59e0b;
        }

        .purpose-statistik {
            background: #10b981;
        }
        
.purpose-visitor {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    color: rgb(0, 0, 0);
    text-align: center;
    margin-top: 5px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
}

/* Warna beda-beda untuk tiap purpose */
.purpose-visitor.sekretariat {
    background: #8b5cf6; /* ungu */
}

.purpose-visitor.aplikasi_informatika {
    background: #3b82f6; /* biru */
}

.purpose-visitor.persandian_keamanan_informasi {
    background: #f97316; /* oranye */
}

.purpose-visitor.informasi_komunikasi_publik {
    background: #f59e0b; /* kuning/oranye muda */
}

.purpose-visitor.statistik {
    background: #10b981; /* hijau */
}



        .loading {
            text-align: center;
            padding: 50px;
            color: #667eea;
            font-size: 1.1rem;
        }

        .spinner {
            display: inline-block;
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .calendar-container {
                padding: 20px 15px;
            }

            .calendar-header {
                flex-direction: column;
                gap: 20px;
            }

            .calendar-day {
                min-height: 80px;
                padding: 5px;
            }

            .day-number {
                font-size: 14px;
            }

            .visitor-count {
                font-size: 10px;
                padding: 1px 6px;
            }

            .legend {
                flex-direction: column;
                gap: 10px;
                align-items: center;
            }

            .modal-content {
                margin: 10% auto;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <div class="header-left">
                <img src="/images/logo-diskominfo.png" alt="Logo Diskominfo" class="logo">
                <h1>Kalender Pengunjung</h1>
            </div>
            <div class="nav-buttons">
                <a href="/buku-tamu/admin/dashboard" class="btn btn-primary">Dashboard</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="calendar-container">
            <div class="calendar-header">
                <div class="calendar-nav">
                    <button class="nav-btn" onclick="previousMonth()">‹</button>
                    <div class="current-month" id="currentMonth">Loading...</div>
                    <button class="nav-btn" onclick="nextMonth()">›</button>
                </div>
                <div>
                    <button class="btn btn-primary" onclick="goToToday()">Hari Ini</button>
                </div>
            </div>

            <div id="calendarLoading" class="loading">
                <div class="spinner"></div>
                Memuat data kalender...
            </div>

            <div id="calendarGrid" class="calendar-grid" style="display: none;">
                <!-- Calendar will be generated here -->
            </div>

            <div class="legend">
                <div class="legend-item">
                    <div class="legend-dot dot-sekretariat"></div>
                    <span>Sekretariat</span>
                </div>
                <div class="legend-item">
                    <div class="legend-dot dot-aplikasi_informatika"></div>
                    <span>Aplikasi Informatika</span>
                </div>

                <div class="legend-item">
                    <div class="legend-dot dot-persandian_keamanan_informasi"></div>
                    <span>Persandian dan Keamanan Informasi</span>
                </div>

                <div class="legend-item">
                    <div class="legend-dot dot-informasi_komunikasi_publik"></div>
                    <span>Informasi dan Komunikasi Publik</span>
                </div>

                <div class="legend-item">
                    <div class="legend-dot dot-statistik"></div>
                    <span>Statistik</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for day details -->
    <div id="dayModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="modalTitle">Detail Pengunjung</div>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div id="modalContent">
                <!-- Visitor details will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        let currentDate = new Date();
        let visitorData = {};

        // Initialize calendar
        async function initCalendar() {
            await loadVisitorData();
            renderCalendar();
        }

        // Load visitor data from API
        async function loadVisitorData() {
            try {
                const response = await fetch('/api/visitors?per_page=1000');
                const data = await response.json();

                if (data.success) {
                    // Group visitors by date
                    visitorData = {};
                    data.data.data.forEach(visitor => {
                        const date = new Date(visitor.visit_date).toDateString();
                        if (!visitorData[date]) {
                            visitorData[date] = [];
                        }
                        visitorData[date].push(visitor);
                    });
                }
            } catch (error) {
                console.error('Error loading visitor data:', error);
            }
        }

        // Render calendar
        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            // Update month display
            const monthNames = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            document.getElementById('currentMonth').textContent = `${monthNames[month]} ${year}`;

            // Get first day of month and number of days
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const daysInMonth = lastDay.getDate();
            const startingDayOfWeek = firstDay.getDay();

            // Get previous month's last days
            const prevMonth = new Date(year, month, 0);
            const daysInPrevMonth = prevMonth.getDate();

            let calendarHTML = '';

            // Day headers
            const dayHeaders = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            dayHeaders.forEach(day => {
                calendarHTML += `<div class="calendar-day-header">${day}</div>`;
            });

            // Previous month's trailing days
            for (let i = startingDayOfWeek - 1; i >= 0; i--) {
                const day = daysInPrevMonth - i;
                const date = new Date(year, month - 1, day);
                calendarHTML += renderDay(day, date, true);
            }

            // Current month's days
            for (let day = 1; day <= daysInMonth; day++) {
                const date = new Date(year, month, day);
                calendarHTML += renderDay(day, date, false);
            }

            // Next month's leading days
            const totalCells = Math.ceil((startingDayOfWeek + daysInMonth) / 7) * 7;
            const remainingCells = totalCells - (startingDayOfWeek + daysInMonth);
            for (let day = 1; day <= remainingCells; day++) {
                const date = new Date(year, month + 1, day);
                calendarHTML += renderDay(day, date, true);
            }

            document.getElementById('calendarGrid').innerHTML = calendarHTML;
            document.getElementById('calendarLoading').style.display = 'none';
            document.getElementById('calendarGrid').style.display = 'grid';
        }

        // Render individual day
        function renderDay(day, date, isOtherMonth) {
            const dateString = date.toDateString();
            const visitors = visitorData[dateString] || [];
            const isToday = date.toDateString() === new Date().toDateString();

            let dayClass = 'calendar-day';
            if (isOtherMonth) dayClass += ' other-month';
            if (isToday) dayClass += ' today';

            let visitorHTML = '';
            if (visitors.length > 0) {
                visitorHTML += `<div class="visitor-count">${visitors.length} pengunjung</div>`;

                // Add dots for different purposes
                const purposes = visitors.reduce((acc, visitor) => {
                    acc[visitor.purpose] = (acc[visitor.purpose] || 0) + 1;
                    return acc;
                }, {});

                visitorHTML += '<div class="visitor-dots">';
                Object.entries(purposes).forEach(([purpose, count]) => {
                    for (let i = 0; i < Math.min(count, 10); i++) {
                        visitorHTML += `<div class="visitor-dot dot-${purpose}"></div>`;
                    }
                });
                visitorHTML += '</div>';
            }

            return `
                <div class="${dayClass}" onclick="showDayDetails('${dateString}', ${day}, '${date.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' })}')">
                    <div class="day-number">${day}</div>
                    ${visitorHTML}
                </div>
            `;
        }

        // Show day details in modal
        function showDayDetails(dateString, day, monthYear) {
            const visitors = visitorData[dateString] || [];
            const modal = document.getElementById('dayModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalContent = document.getElementById('modalContent');

            modalTitle.textContent = `${day} ${monthYear} - ${visitors.length} Pengunjung`;

            if (visitors.length === 0) {
                modalContent.innerHTML = '<p style="text-align: center; color: #666; padding: 20px;">Tidak ada pengunjung pada tanggal ini.</p>';
            } else {
                let visitorHTML = '<ul class="visitor-list">';
                visitors.forEach(visitor => {
                    const purposeClass = `purpose-${visitor.purpose}`;
                    const purposeText = {
                        'sekretariat': 'Sekretariat',
                        'aplikasi_informatika': 'Aplikasi Informatika',
                        'persandian_keamanan_informasi': 'Persandian dan Keamanan Informasi',
                        'informasi_komunikasi_publik': 'Informasi dan Komunikasi Publik',
                        'statistik': 'Statistik'
                    }[visitor.purpose] || visitor.purpose;

                    const time = new Date(visitor.visit_date).toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    visitorHTML += `
                        <li class="visitor-item">
                            <div class="purpose-visitor ${visitor.purpose}"> ${purposeText} </div>
                            <div class="visitor-name">Nama: ${visitor.name}</div>
                            <div class="visitor-details">
                                <div>Waktu: ${time} WIB</div>
                                <div>Email: ${visitor.email || '-'}</div>
                                <div>Telepon: ${visitor.phone || '-'}</div>
                                <div>Asal Daerah: ${visitor.asal_daerah || '-'}</div>
                            </div>
                            <div class="visitor-note">
                                ${visitor.notes ? `<div>Keperluan: ${visitor.notes}</div>` : ''}
                            </div>
                        </li>
                    `;
                });
                visitorHTML += '</ul>';
                modalContent.innerHTML = visitorHTML;
            }

            modal.style.display = 'block';
        }

        // Close modal
        function closeModal() {
            document.getElementById('dayModal').style.display = 'none';
        }

        // Navigation functions
        function previousMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        }

        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        }

        function goToToday() {
            currentDate = new Date();
            renderCalendar();
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('dayModal');
            if (event.target === modal) {
                closeModal();
            }
        }

        // Initialize calendar on page load
        initCalendar();
    </script>
</body>
</html>


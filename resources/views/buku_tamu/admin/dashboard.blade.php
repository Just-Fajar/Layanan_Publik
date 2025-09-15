<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Admin - Buku Tamu Digital</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f5f7fa; min-height: 100vh;
    }

    .header {
      background: linear-gradient(135deg, #5fb9d4, #0077b6);
      color: #fff; padding: 20px 0;
      box-shadow: 0 2px 10px rgba(0,0,0,.1);
    }
    .header-content {
      max-width: 1200px; margin: 0 auto; padding: 0 20px;
      display: flex; justify-content: space-between; align-items: center;
    }
    .header-left { display:flex; align-items:center; gap:20px; }
    .logo { height:50px; width:auto; }
    .header h1 { font-size:1.8rem; font-weight:600; }

    .user-info { display:flex; align-items:center; gap:15px; }
    .logout-btn {
      background: rgba(255,255,255,.2); color:#fff; border:none;
      padding:8px 16px; border-radius:20px; cursor:pointer;
      transition: .3s; font-weight:600;
    }
    .logout-btn:hover { background: rgba(255,255,255,.3); }

    .container { max-width:1200px; margin:0 auto; padding:30px 20px; }

    .stats-grid {
      display:grid; grid-template-columns: repeat(auto-fit, minmax(250px,1fr));
      gap:20px; margin-bottom:30px;
    }
    .stat-card {
      background:#fff; border-radius:15px; padding:25px;
      box-shadow:0 5px 15px rgba(0,0,0,.08); transition:.3s;
    }
    .stat-card:hover { transform: translateY(-5px); }
    .stat-card h3 { color:#666; font-size:.9rem; margin-bottom:10px; letter-spacing:1px; text-transform:uppercase; }
    .stat-card .number { font-size:2.5rem; font-weight:700; color:#333; margin-bottom:5px; }
    .stat-card .label { color:#888; font-size:.9rem; }
    .stat-card.primary .number {
      background: linear-gradient(135deg,#667eea,#764ba2);
      -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
    }
    .stat-card.success .number { color:#10b981; }
    .stat-card.warning .number { color:#f59e0b; }
    .stat-card.info .number { color:#3b82f6; }
    .stat-card.semester .number {
      background: linear-gradient(135deg,#60a5fa,#2563eb);
      -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    }
    .stat-card.semester select {
  width: 100%;
  padding: 8px 12px;
  border: 2px solid #e2e8f0;
  border-radius: 8px;
  background: #fff;
  color: #333;          
  font-size: 14px;
  cursor: pointer;
  transition: all 0.3s ease;
}
.stat-card.semester select:focus {
  outline: none;
  border-color: #dbdde0; 
}


    .charts-grid{ display:grid; grid-template-columns:1fr 1fr; gap:30px; margin-bottom:30px; }
    .chart-card{ background:#fff; border-radius:15px; padding:25px; box-shadow:0 5px 15px rgba(0,0,0,.08); }
    .chart-card h3{ color:#333; margin-bottom:20px; font-size:1.2rem; font-weight:600; }
    .chart-container{ position:relative; height:300px; }

    .data-table-card{ background:#fff; border-radius:15px; padding:25px; box-shadow:0 5px 15px rgba(0,0,0,.08); }
    .table-header{
      display:flex; justify-content:space-between; align-items:center;
      margin-bottom:20px; flex-wrap:wrap; gap:15px;
    }
    .table-header h3{ color:#333; font-size:1.2rem; font-weight:600; }

    .filters{ display:flex; gap:10px; flex-wrap:wrap; }
    .filter-select{
      padding:8px 12px; border:2px solid #e1e5e9; border-radius:8px;
      font-size:14px; background:#fff; cursor:pointer;
    }
    .filter-select:focus{ outline:none; border-color:#667eea; }
    .filter-select[type="month"], .form-select[type="month"]{ min-width:190px; }
    .filter-select[type="date"], .form-select[type="date"]{ min-width:190px; }
    #nameSearch{ min-width:200px; }

    .btn-export{
      background:linear-gradient(135deg,#10b981,#059669); color:#fff; border:none;
      padding:8px 16px; border-radius:8px; font-size:14px; font-weight:600; cursor:pointer;
      transition:.3s; box-shadow:0 2px 8px rgba(16,185,129,.3);
    }
    .btn-export:hover{ transform:translateY(-1px); box-shadow:0 4px 12px rgba(16,185,129,.4); }

    table tbody td:first-child{ text-align:center; font-weight:bold; color:#374151; width:50px; }

    .btn-qrcode{
      background:linear-gradient(135deg,#667eea,#764ba2); color:#fff; border:none; padding:8px 16px;
      border-radius:8px; font-size:14px; font-weight:600; cursor:pointer; transition:.3s;
      box-shadow:0 2px 8px rgba(102,126,234,.3); text-decoration:none; display:inline-block;
    }
    .btn-qrcode:hover{ transform:translateY(-1px); box-shadow:0 4px 12px rgba(102,126,234,.4); color:#fff; text-decoration:none; }

    .col-no{ width:56px; text-align:center; font-weight:700; color:#374151; }
    .col-photo{ width:60px; text-align:center; }

    .btn-reset{
      background:linear-gradient(135deg,#6366f1,#4338ca); color:#fff; border:none; padding:8px 14px;
      border-radius:8px; font-size:14px; font-weight:600; cursor:pointer; transition:.3s;
      box-shadow:0 2px 6px rgba(99,102,241,.4);
    }
    .btn-reset:hover{ background:linear-gradient(135deg,#4f46e5,#312e81); transform:translateY(-2px); box-shadow:0 4px 10px rgba(79,70,229,.5); }
    .btn-reset:active{ transform:scale(.96); box-shadow:0 2px 6px rgba(79,70,229,.4); }

    .btn-calendar{
      background:linear-gradient(135deg,#f59e0b,#d97706); color:#fff; border:none; padding:8px 16px;
      border-radius:8px; font-size:14px; font-weight:600; cursor:pointer; transition:.3s;
      box-shadow:0 2px 8px rgba(245,158,11,.3); text-decoration:none; display:inline-block;
    }
    .btn-calendar:hover{ transform:translateY(-1px); box-shadow:0 4px 12px rgba(245,158,11,.4); color:#fff; text-decoration:none; }

    .btn-delete{
      background:linear-gradient(135deg,#ef4444,#dc2626); color:#fff; border:none; padding:6px 12px;
      border-radius:6px; font-size:13px; font-weight:600; cursor:pointer; transition:.3s;
      box-shadow:0 2px 6px rgba(239,68,68,.3);
    }
    .btn-delete:hover{ transform:translateY(-1px); box-shadow:0 4px 10px rgba(239,68,68,.4); }
    .btn-delete:disabled{ background:#e1e5e9; cursor:not-allowed; box-shadow:none; }

    .data-table{ width:100%; border-collapse:collapse; margin-top:15px; }
    .data-table th, .data-table td{ padding:12px; text-align:left; border-bottom:1px solid #e1e5e9; }
    .data-table th{
      background:#f8f9fa; font-weight:600; color:#333; font-size:.9rem; text-transform:uppercase; letter-spacing:.5px;
    }
    .data-table td{ color:#666; }
    .data-table tr:hover{ background:#f8f9fa; }

    .purpose-badge{ padding:4px 12px; border-radius:20px; font-size:.8rem; font-weight:600; text-transform:uppercase; }
    .purpose-sekretariat{ background:#e0e7ff; color:#3730a3; }
    .purpose-aplikasi_informatika{ background:#dbeafe; color:#1e40af; }
    .purpose-informasi_komunikasi_publik{ background:#fef3c7; color:#78350f; }
    .purpose-statistik{ background:#d1fae5; color:#065f46; }
    .purpose-persandian_keamanan_informasi{ background:#fcd5ce; color:#9b1c1c; }

    .photo-thumb{
      width:40px; height:40px; border-radius:50%; object-fit:cover;
      border:2px solid #e1e5e9; cursor:zoom-in;
    }

    .loading{ text-align:center; padding:40px; color:#666; }
    .spinner{ border:3px solid #f3f3f3; border-top:3px solid #667eea; border-radius:50%; width:40px; height:40px; animation:spin 1s linear infinite; margin:0 auto 15px; }
    @keyframes spin{ 0%{transform:rotate(0)} 100%{transform:rotate(360deg)} }

    .toast{
      position:fixed; bottom:20px; right:20px; background:#333; color:#fff; padding:12px 20px; border-radius:8px;
      box-shadow:0 4px 12px rgba(0,0,0,.3); opacity:0; transform:translateY(30px); transition:.4s; z-index:3000;
    }
    .toast.show{ opacity:1; transform:translateY(0); }
    .toast.success{ background:#10b981; } .toast.error{ background:#ef4444; }

    .pagination{ display:flex; justify-content:center; align-items:center; gap:10px; margin-top:20px; }
    .pagination button{
      padding:8px 12px; border:1px solid #e1e5e9; background:#fff; border-radius:6px; cursor:pointer; transition:.3s;
    }
    .pagination button:hover{ background:#f8f9fa; }
    .pagination button.active{ background:#667eea; color:#fff; border-color:#667eea; }
    .pagination button:disabled{ opacity:.5; cursor:not-allowed; }

    @media (max-width:768px){
      .charts-grid{ grid-template-columns:1fr; }
      .header-content{ flex-direction:column; gap:15px; text-align:center; }
      .table-header{ flex-direction:column; align-items:stretch; }
      .filters{ justify-content:center; }
      .data-table{ font-size:.9rem; }
      .data-table th,.data-table td{ padding:8px; }
    }

    .modal{ display:none; position:fixed; z-index:1000; inset:0; background:rgba(0,0,0,.5); backdrop-filter:blur(5px); }
    .modal-content{
      background:#fff; margin:5% auto; padding:0; border-radius:15px; width:90%; max-width:500px;
      box-shadow:0 20px 40px rgba(0,0,0,.2); animation:modalSlideIn .3s ease;
    }
    @keyframes modalSlideIn{ from{opacity:0; transform:translateY(-50px)} to{opacity:1; transform:translateY(0)} }
    .modal-header{
      background:linear-gradient(135deg,#667eea,#764ba2); color:#fff; padding:20px; border-radius:15px 15px 0 0;
      display:flex; justify-content:space-between; align-items:center;
    }
    .modal-header h3{ margin:0; font-size:1.2rem; }
    .close{ font-size:24px; font-weight:bold; cursor:pointer; opacity:.7; transition:.3s; }
    .close:hover{ opacity:1; }
    .modal-body{ padding:25px; }
    .form-group{ margin-bottom:20px; }
    .form-group label{ display:block; margin-bottom:8px; font-weight:600; color:#333; }
    .form-select{
      width:100%; padding:12px; border:2px solid #e1e5e9; border-radius:8px; font-size:14px; background:#fff; transition:border-color .3s;
    }
    .form-select:focus{ outline:none; border-color:#667eea; }
    .modal-footer{ padding:20px 25px; border-top:1px solid #e1e5e9; display:flex; justify-content:flex-end; gap:10px; }
    .btn-secondary{ background:#6c757d; color:#fff; }
    .btn-secondary:hover{ background:#5a6268; }

    .image-modal{ display:none; position:fixed; inset:0; z-index:2000; background:rgba(0,0,0,.8); align-items:center; justify-content:center; padding:20px; }
    .image-modal.open{ display:flex; }
    .image-modal img{ max-width:90vw; max-height:85vh; border-radius:10px; box-shadow:0 10px 30px rgba(0,0,0,.5); }
    .image-modal .close-btn{
      position:absolute; top:16px; right:20px; cursor:pointer; background:rgba(255,255,255,.15); color:#fff;
      border:1px solid rgba(255,255,255,.35); padding:6px 10px; border-radius:10px; font-weight:700;
    }
    .image-modal .meta{ position:absolute; bottom:16px; left:20px; right:20px; text-align:center; color:#fff; font-size:14px; opacity:.9; }

    .col-name{
      max-width:280px; white-space:normal; overflow-wrap:anywhere; word-break:break-word; line-height:1.3; text-align:justify;
    }
    .data-table td{ vertical-align:middle; }

    .semester-select{ border:none; background:transparent; font-size:12px; color:#d05d5d; cursor:pointer; }
  </style>
</head>
<body>
  <div class="header">
    <div class="header-content">
      <div class="header-left">
        <img src="/images/logo-diskominfo.png" class="logo" alt="Logo">
        <h1>Dashboard</h1>
      </div>
      <div class="user-info">
        <span id="adminName">Loading...</span>
        <button class="logout-btn" onclick="logout()">Logout</button>
      </div>
    </div>
  </div>

  <div class="container">
    <!-- Statistics Cards -->
    <div class="stats-grid">
      <div class="stat-card primary">
        <h3>Total Pengunjung</h3>
        <div class="number" id="totalVisitors">-</div>
        <div class="label">Semua waktu</div>
      </div>
      <div class="stat-card success">
        <h3>Hari Ini</h3>
        <div class="number" id="todayVisitors">-</div>
        <div class="label">Pengunjung hari ini</div>
      </div>
      <div class="stat-card warning">
        <h3>Bulan Ini</h3>
        <div class="number" id="monthVisitors">-</div>
        <div class="label">Pengunjung bulan ini</div>
      </div>
      <div class="stat-card semester">
        <h3>Semester</h3>
        <div class="number" id="semesterVisitors">-</div>
        <div class="label">
          <select id="semesterSelect">
            <option value="1">Semester 1 (Jan–Jun)</option>
            <option value="2">Semester 2 (Jul–Des)</option>
          </select>
        </div>
      </div>
      <div class="stat-card info">
        <h3>Rata-rata</h3>
        <div class="number" id="avgVisitors">-</div>
        <div class="label">Per hari</div>
      </div>
    </div>

    <!-- Charts -->
    <div class="charts-grid">
      <div class="chart-card">
        <h3>📊 Kunjungan per Tujuan</h3>
        <div class="chart-container"><canvas id="purposeChart"></canvas></div>
      </div>
      <div class="chart-card">
        <h3>📈 Trend Kunjungan Bulanan</h3>
        <div class="chart-container"><canvas id="monthlyChart"></canvas></div>
      </div>
    </div>

    <!-- Data Table -->
    <div class="data-table-card">
      <div class="table-header">
        <h3>Data Pengunjung</h3>
        <div class="filters">
          <a href="/buku-tamu/admin/dashboard/calendar" class="btn btn-calendar" target="_blank">Kalender</a>
          <a href="/buku-tamu/admin/dashboard/qrcode" class="btn btn-qrcode" target="_blank">QR Code</a>
          <button class="btn btn-export" onclick="showExportModal()">Export PDF</button>

          <!-- 🔎 Cari Nama -->
          <input type="text" id="nameSearch" class="filter-select" placeholder="Cari nama…"/>

          <select class="filter-select" id="purposeFilter">
            <option value="">Semua Tujuan</option>
            <option value="sekretariat">Sekretariat</option>
            <option value="aplikasi_informatika">Aplikasi Informatika</option>
            <option value="persandian_keamanan_informasi">Persandian &amp; Keamanan Informasi</option>
            <option value="informasi_komunikasi_publik">Informasi dan Komunikasi Publik</option>
            <option value="statistik">Statistik</option>
          </select>

          <div style="display:flex; gap:30px; align-items:center;">
            <input type="date" class="filter-select" id="dateFilter">
            <button type="button" id="todayFilter" class="btn-reset">Hari Ini</button>
          </div>
        </div>

        <script>
          // Set today's date (YYYY-MM-DD) dan trigger change
          function setTodayDate() {
            const t = new Date();
            const y = t.getFullYear();
            const m = String(t.getMonth()+1).padStart(2,'0');
            const d = String(t.getDate()).padStart(2,'0');
            const el = document.getElementById('dateFilter');
            el.value = `${y}-${m}-${d}`;
            el.dispatchEvent(new Event('change'));
          }
          document.addEventListener('DOMContentLoaded', setTodayDate);
          document.getElementById('todayFilter').addEventListener('click', setTodayDate);
        </script>
      </div>

      <div id="tableLoading" class="loading">
        <div class="spinner"></div>
        <p>Memuat data...</p>
      </div>

      <div id="tableContainer" style="display:none;">
        <table class="data-table">
          <thead>
          <tr>
            <th>No</th><th>Tanggal</th><th>Foto</th><th>Nama</th>
            <th>Email</th><th>Asal Daerah</th><th>Tujuan</th><th>Keperluan Kunjungan</th><th>Aksi</th>
          </tr>
          </thead>
          <tbody id="visitorsTableBody"></tbody>
        </table>
        <div class="pagination" id="pagination"></div>
      </div>
    </div>
  </div>

  <!-- Export PDF Modal -->
  <div id="exportModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Export Laporan PDF</h3>
        <span class="close" onclick="closeExportModal()">&times;</span>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="paperFormat">Format Kertas:</label>
          <select id="paperFormat" class="form-select">
            <option value="a4">A4 (210 x 297 mm)</option>
            <option value="f4">F4 (210 x 330 mm)</option>
            <option value="letter">Letter (216 x 279 mm)</option>
            <option value="legal">Legal (216 x 356 mm)</option>
          </select>
        </div>
        <div class="form-group">
          <label for="paperOrientation">Orientasi:</label>
          <select id="paperOrientation" class="form-select">
            <option value="portrait">Portrait (Tegak)</option>
            <option value="landscape">Landscape (Mendatar)</option>
          </select>
        </div>
        <div class="form-group">
          <label for="exportPurpose">Filter Tujuan:</label>
          <select id="exportPurpose" class="form-select">
            <option value="">Semua Tujuan</option>
            <option value="sekretariat">Sekretariat</option>
            <option value="aplikasi_informatika">Aplikasi Informatika</option>
            <option value="persandian_keamanan_informasi">Persandian &amp; Keamanan Informasi</option>
            <option value="informasi_komunikasi_publik">Informasi dan Komunikasi Publik</option>
            <option value="statistik">Statistik</option>
          </select>
        </div>
        <div class="form-group">
          <label for="exportMonth">Filter Bulan:</label>
          <input type="month" id="exportMonth" class="form-select" placeholder="Pilih bulan (opsional)">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" onclick="closeExportModal()">Batal</button>
        <button class="btn btn-export" onclick="downloadPDF()">Download PDF</button>
      </div>
    </div>
  </div>

  <!-- Lightbox Foto -->
  <div id="imgModal" class="image-modal" aria-hidden="true">
    <button id="imgClose" class="close-btn">✕ Tutup</button>
    <img id="imgPreview" src="" alt="Foto pengunjung">
    <div id="imgMeta" class="meta"></div>
  </div>

  <script>
    // ====== Auth ======
    const token = localStorage.getItem('admin_token');
    const adminData = JSON.parse(localStorage.getItem('admin_data') || '{}');
    if (!token) { window.location.href = '/buku-tamu/admin'; }
    document.getElementById('adminName').textContent = adminData.name || 'Admin';

    // ====== State ======
    let perPage = 10;
    let currentPage = 1, totalPages = 1;
    let currentFilters = {};
    let purposeChart, monthlyChart;

    // ====== Utils ======
    function debounce(fn, delay=400){ let t; return (...a)=>{clearTimeout(t); t=setTimeout(()=>fn(...a), delay);} }
    const esc = s => String(s ?? '').replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));

    async function fetchDayCount(dateStr){
      const res = await fetch(`/api/visitors?date=${encodeURIComponent(dateStr)}`, {
        headers: { 'Authorization': `Bearer ${token}`, 'Content-Type': 'application/json' }
      });
      if (!res.ok) return 0;
      const json = await res.json();
      return Number(json?.data?.total ?? 0);
    }

    async function fetchYearStats(year){
      const res = await fetch(`/api/statistics?year=${year}`, {
        headers: { 'Authorization': `Bearer ${token}`, 'Content-Type': 'application/json' }
      });
      if (!res.ok) return null;
      const json = await res.json();
      return json?.data || null;
    }

    function sumYearCount(statsData, year){
      const arr = Array.isArray(statsData?.monthly_stats) ? statsData.monthly_stats : [];
      return arr.filter(it => Number(it.year ?? year) === Number(year))
                .reduce((s,it)=> s + Number(it.count ?? 0), 0);
    }
    function monthCountFrom(statsData, month, year){
      const arr = Array.isArray(statsData?.monthly_stats) ? statsData.monthly_stats : [];
      return arr.filter(it => Number(it.month) === Number(month) && Number(it.year ?? year) === Number(year))
                .reduce((s,it)=> s + Number(it.count ?? 0), 0);
    }
    function daysInMonth(year, month){ return new Date(year, month, 0).getDate(); }

    // ====== Init ======
    async function initDashboard(){
      await loadStatistics();
      await loadVisitors();
      setupFilters();
      initNameSearch();
    }

    function initNameSearch(){
      const nameSearch = document.getElementById('nameSearch');
      if (!nameSearch) return;
      nameSearch.value = currentFilters.name || '';
      const apply = debounce(v=>{
        v = (v||'').trim();
        if (v) currentFilters.name = v; else delete currentFilters.name;
        loadVisitors(1);
      }, 400);
      nameSearch.addEventListener('input', e => apply(e.target.value));
    }

    // ====== Statistics ======
    async function loadStatistics(){
      try{
        let url = '/api/statistics';
        const qs = new URLSearchParams();
        if (currentFilters.date){
          qs.set('date', String(currentFilters.date));
        } else if (currentFilters.month && currentFilters.year){
          qs.set('month', String(currentFilters.month));
          qs.set('year', String(currentFilters.year));
        }
        const q = qs.toString(); if (q) url += `?${q}`;

        const response = await fetch(url, { headers:{ 'Authorization':`Bearer ${token}`, 'Content-Type':'application/json' }});
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        const { data:raw = {} } = await response.json();

        const stats = {
          total: raw.total ?? 0, today: raw.today ?? 0, this_month: raw.this_month ?? 0,
          purpose_stats: Array.isArray(raw.purpose_stats) ? raw.purpose_stats : [],
          monthly_stats: Array.isArray(raw.monthly_stats) ? raw.monthly_stats : []
        };

        let totalCard = stats.total, todayCard = stats.today, monthCard = stats.this_month;
        let avgCard = totalCard>0 ? Math.round(totalCard/30) : 0;

        const lblPrimary = document.querySelector('.stat-card.primary .label');
        const lblSuccess = document.querySelector('.stat-card.success .label');
        const lblWarning = document.querySelector('.stat-card.warning .label');
        const lblInfo    = document.querySelector('.stat-card.info .label');
        const parsePickedDate = (v)=>{
          if (!v) return null;
          if (/^\d{4}-\d{2}-\d{2}$/.test(v)){ const [y,m,d]=v.split('-').map(Number); return new Date(y,m-1,d); }
          if (/^\d{2}\/\d{2}\/\d{4}$/.test(v)){ const [d,m,y]=v.split('/').map(Number); return new Date(y,m-1,d); }
          const dt = new Date(v); return isNaN(dt)? null : dt;
        };

        const now = new Date();
        if (!currentFilters.date && !currentFilters.month && !currentFilters.year){
          const yNow = now.getFullYear();
          const totalYear = sumYearCount(stats, yNow);
          totalCard = totalYear;
          if (lblPrimary) lblPrimary.textContent = `Tahun ${yNow}`;
          if (lblSuccess) lblSuccess.textContent = stats.today>0 ? 'Pengunjung hari ini' : 'Belum ada pengunjung hari ini';
          const mn = now.toLocaleString('id-ID',{month:'long'});
          if (lblWarning) lblWarning.textContent = totalYear>0 ? `Pengunjung bulan ${mn}` : `Belum ada pengunjung bulan ${mn}`;
          if (lblInfo) lblInfo.textContent = totalCard>0 ? 'Per hari' : 'Rata-rata per hari';
        }

        if (currentFilters.date){
          const picked = parsePickedDate(currentFilters.date);
          if (picked){
            const y = picked.getFullYear(), m = picked.getMonth()+1;
            let yearStats = await fetchYearStats(y); if (!yearStats) yearStats = stats;

            totalCard = sumYearCount(yearStats, y);
            const mTot = monthCountFrom(yearStats, m, y) || 0;
            monthCard = mTot;
            const isToday = picked.toDateString() === now.toDateString();
            todayCard = isToday ? Number(stats.today ?? 0) : 0;
            avgCard = mTot>0 ? Math.round(mTot / daysInMonth(y,m)) : 0;

            if (lblPrimary) lblPrimary.textContent = `Tahun ${y}`;
            if (lblSuccess) lblSuccess.textContent = (isToday && todayCard>0)? 'Pengunjung hari ini':'Belum ada pengunjung';
            const mn = picked.toLocaleString('id-ID',{month:'long'});
            if (lblWarning) lblWarning.textContent = mTot>0 ? `Pengunjung bulan ${mn}` : `Belum ada pengunjung bulan ${mn}`;
            if (lblInfo) lblInfo.textContent = avgCard>0 ? 'Rata-rata per hari (bulan terpilih)' : 'Belum ada rata-rata';
          }
        } else if (currentFilters.month && currentFilters.year){
          const selMonth = Number(currentFilters.month), selYear = Number(currentFilters.year);
          let yearStats = await fetchYearStats(selYear); if (!yearStats) yearStats = stats;

          totalCard = sumYearCount(yearStats, selYear);
          const mTot = monthCountFrom(yearStats, selMonth, selYear) || 0;
          monthCard = mTot;

          const isCur = (now.getFullYear()===selYear && now.getMonth()+1===selMonth);
          todayCard = isCur ? Number(stats.today ?? 0) : 0;
          avgCard = mTot>0 ? Math.round(mTot / daysInMonth(selYear, selMonth)) : 0;

          const monthName = new Date(selYear, selMonth-1).toLocaleString('id-ID',{month:'long'});
          if (lblPrimary) lblPrimary.textContent = `Tahun ${selYear}`;
          if (lblSuccess) lblSuccess.textContent = (isCur && todayCard>0)? 'Pengunjung hari ini':'Belum ada pengunjung hari ini';
          if (lblWarning) lblWarning.textContent = mTot>0 ? `Pengunjung bulan ${monthName}` : `Belum ada pengunjung bulan ${monthName}`;
          if (lblInfo) lblInfo.textContent = avgCard>0 ? 'Rata-rata per hari (bulan terpilih)' : 'Belum ada rata-rata';
        }

        document.getElementById('totalVisitors').textContent = Number(totalCard) || 0;
        document.getElementById('todayVisitors').textContent = Number(todayCard) || 0;
        document.getElementById('monthVisitors').textContent = Number(monthCard) || 0;
        document.getElementById('avgVisitors').textContent = Number(avgCard) || 0;

        // Charts
        let selectedYear = (()=>{
          if (currentFilters?.date){ const d = parsePickedDate(currentFilters.date); return d ? d.getFullYear() : new Date().getFullYear(); }
          if (currentFilters?.year) return Number(currentFilters.year);
          return new Date().getFullYear();
        })();

        const msArr = Array.isArray(stats.monthly_stats)? stats.monthly_stats : [];
        const yearTotalForCharts = msArr
          .filter(it=> Number(it.year ?? selectedYear) === Number(selectedYear))
          .reduce((s,it)=> s + Number(it.count || 0), 0);

        createPurposeChart(yearTotalForCharts===0 ? [] : stats.purpose_stats);
        createMonthlyChart(stats.monthly_stats, { year: selectedYear });

        // Semester card
        function semesterCountFrom(stats, semester, year){
          if (!stats || !Array.isArray(stats.monthly_stats)) return 0;
          const months = semester===1? [1,2,3,4,5,6] : [7,8,9,10,11,12];
          return stats.monthly_stats
            .filter(it => Number(it.year)===year && months.includes(Number(it.month)))
            .reduce((s,it)=> s + Number(it.count || 0), 0);
        }
        const semesterVisitors = document.getElementById('semesterVisitors');
        const semesterSelect = document.getElementById('semesterSelect');
        const yearForSemester = new Date().getFullYear();
        if (semesterVisitors && semesterSelect){
          const updateSemester = ()=>{
            const sem = Number(semesterSelect.value);
            semesterVisitors.textContent = semesterCountFrom(stats, sem, yearForSemester) || 0;
          };
          updateSemester(); semesterSelect.addEventListener('change', updateSemester);
        }
      }catch(err){ console.error('Error loading statistics:', err); }
    }

    function createPurposeChart(data){
      const ctx = document.getElementById('purposeChart').getContext('2d');
      if (purposeChart) purposeChart.destroy();
      const purposeMap = {
        'sekretariat':'Sekretariat','aplikasi_informatika':'Aplikasi Informatika',
        'informasi_komunikasi_publik':'Informasi & Komunikasi Publik',
        'statistik':'Statistik','persandian_keamanan_informasi':'Persandian & Keamanan Informasi'
      };
      const colorMap = {
        'sekretariat':'#8B5CF6','aplikasi_informatika':'#3B82F6',
        'informasi_komunikasi_publik':'#F59E0B','statistik':'#10B981',
        'persandian_keamanan_informasi':'#EF4444'
      };
      const src = Array.isArray(data)? data : [];
      const labels = src.map(it => purposeMap[it.purpose] ?? (it.purpose ?? 'Tidak diketahui'));
      const counts = src.map(it => Number(it.count ?? 0));
      const finalLabels = labels.length? labels : ['Tidak ada data'];
      const finalCounts = counts.length? counts : [0];
      const finalColors = src.map(it => colorMap[it.purpose] ?? '#D1D5DB');

      purposeChart = new Chart(ctx, {
        type:'doughnut',
        data:{ labels:finalLabels, datasets:[{ data:finalCounts, backgroundColor:finalColors, borderWidth:0 }] },
        options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{ position:'bottom', labels:{ padding:20, usePointStyle:true } } } }
      });
    }

    function createMonthlyChart(data, opts={}){
      const ctx = document.getElementById('monthlyChart').getContext('2d');
      if (monthlyChart) monthlyChart.destroy();
      const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
      const byMonth = Array(12).fill(0);
      const targetYear = (opts && opts.year!=null) ? Number(opts.year) : new Date().getFullYear();

      (Array.isArray(data)? data : []).forEach(it=>{
        const y = Number(it.year), m = Number(it.month), c = Number(it.count || 0);
        if (!m || m<1 || m>12) return;
        if (!isNaN(y) && y!==targetYear) return;
        byMonth[m-1] = c;
      });

      monthlyChart = new Chart(ctx, {
        type:'line',
        data:{ labels:months, datasets:[{ label:'Pengunjung', data:byMonth, borderColor:'#667eea', backgroundColor:'rgba(102,126,234,.1)', borderWidth:3, fill:true, tension:.4 }] },
        options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{ display:false }}, scales:{ y:{ beginAtZero:true, ticks:{ stepSize:1 }}} }
      });
    }

    // ====== Visitors table ======
    async function loadVisitors(page=1){
      const loading = document.getElementById('tableLoading');
      const container = document.getElementById('tableContainer');
      try{
        loading.style.display='block'; container.style.display='none';

        let url = `/api/visitors?page=${page}`;
        if (currentFilters.purpose) url += `&purpose=${encodeURIComponent(currentFilters.purpose)}`;
        if (currentFilters.date)    url += `&date=${encodeURIComponent(currentFilters.date)}`;
        if (currentFilters.month && currentFilters.year) url += `&month=${currentFilters.month}&year=${currentFilters.year}`;
        if (currentFilters.name)    url += `&name=${encodeURIComponent(currentFilters.name)}`; // ← penting

        const response = await fetch(url, { headers:{ 'Authorization':`Bearer ${token}`, 'Content-Type':'application/json' }});
        let result = null; try{ result = await response.json(); }catch(_){}
        if (response.ok && result?.success){
          const meta = result.data;
          perPage = meta?.per_page ?? perPage;
          displayVisitors(meta?.data ?? [], meta?.from ?? 1);
          updatePagination(meta ?? { current_page:1, last_page:1 });
        } else {
          document.getElementById('visitorsTableBody').innerHTML =
            '<tr><td colspan="9" style="text-align:center;color:#666;">Tidak ada data pengunjung</td></tr>';
          console.error('Visitors API error:', response.status, result);
        }
      }catch(err){
        console.error('Error loading visitors:', err);
        document.getElementById('visitorsTableBody').innerHTML =
          '<tr><td colspan="9" style="text-align:center;color:#ef4444;">Gagal memuat data.</td></tr>';
      }finally{
        loading.style.display='none'; container.style.display='block';
      }
    }

    let deleteTargetId = null;
    function deleteVisitor(id){
      deleteTargetId = id;
      document.getElementById('deleteMessage').textContent = "Yakin ingin menghapus data pengunjung ini?";
      document.getElementById('deleteModal').style.display = 'block';
    }
    function closeDeleteModal(){ document.getElementById('deleteModal').style.display='none'; deleteTargetId=null; }

    function showToast(message, type="success"){
      const toast = document.getElementById("toast");
      toast.textContent = message; toast.className = `toast ${type} show`;
      setTimeout(()=> toast.classList.remove("show"), 3000);
    }

    async function confirmDelete(){
      if (!deleteTargetId) return;
      try{
        const response = await fetch(`/api/visitors/${deleteTargetId}`, {
          method:'DELETE',
          headers:{ 'Authorization':`Bearer ${token}`, 'Content-Type':'application/json', 'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content }
        });
        const result = await response.json();
        if (result.success){ showToast("Data berhasil dihapus","success"); loadVisitors(currentPage); loadStatistics(); }
        else { showToast("Gagal menghapus data","error"); }
      }catch(e){ console.error(e); showToast("Terjadi kesalahan saat menghapus data","error"); }
      closeDeleteModal();
    }

    // Lightbox
    const imgModal = document.getElementById('imgModal');
    const imgPreview = document.getElementById('imgPreview');
    const imgMeta = document.getElementById('imgMeta');
    const imgClose = document.getElementById('imgClose');

    document.getElementById('visitorsTableBody').addEventListener('click', e=>{
      const img = e.target.closest('img.photo-thumb'); if (!img) return;
      imgPreview.src = img.dataset.full || img.src;
      imgPreview.alt = img.alt || 'Foto pengunjung';
      imgMeta.textContent = `${img.dataset.name || ''}${img.dataset.date ? ' • '+img.dataset.date : ''}`;
      imgModal.classList.add('open'); imgModal.setAttribute('aria-hidden','false');
    });
    function closeImgModal(){ imgModal.classList.remove('open'); imgModal.setAttribute('aria-hidden','true'); imgPreview.src=''; }
    imgClose.addEventListener('click', closeImgModal);
    imgModal.addEventListener('click', e=>{ if (e.target===imgModal) closeImgModal(); });
    document.addEventListener('keydown', e=>{ if (e.key==='Escape') closeImgModal(); });

    function displayVisitors(visitors, startFrom=1){
      const tbody = document.getElementById('visitorsTableBody'); tbody.innerHTML='';
      visitors.forEach((v, idx)=>{
        const row = document.createElement('tr');
        const prettyDate = new Date(v.visit_date).toLocaleDateString('id-ID',{ day:'2-digit', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit' });
        const photoCell = v.photo_path
          ? `<img src="/storage/${esc(v.photo_path)}" alt="Foto ${esc(v.name || '')}" class="photo-thumb" data-full="/storage/${esc(v.photo_path)}" data-name="${esc(v.name || '')}" data-date="${esc(prettyDate)}">`
          : '<div style="width:40px;height:40px;background:#e1e5e9;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;color:#666;">No Photo</div>';

        const purposeClass = `purpose-${v.purpose}`;
        const purposeText = {
          'sekretariat':'Sekretariat','aplikasi_informatika':'Aplikasi Informatika',
          'informasi_komunikasi_publik':'Informasi dan Komunikasi Publik',
          'statistik':'Statistik','persandian_keamanan_informasi':'Persandian & Keamanan Informasi'
        }[v.purpose] || (v.purpose || '-');

        const number = (startFrom - 1) + (idx + 1);
        row.innerHTML = `
          <td class="col-no">${number}</td>
          <td>${esc(prettyDate)} WIB</td>
          <td>${photoCell}</td>
          <td class="col-name"><strong>${esc(v.name || '-')}</strong></td>
          <td class="col-name">${esc(v.email || '-')}</td>
          <td>${esc(v.asal_daerah || '-')}</td>
          <td><span class="purpose-badge ${purposeClass}">${esc(purposeText)}</span></td>
          <td class="col-name">${esc(v.notes || '-')}</td>
          <td><button class="btn-delete" onclick="deleteVisitor(${v.id})">DELETE</button></td>
        `;
        tbody.appendChild(row);
      });
    }

    function updatePagination(data){
      currentPage = data.current_page; totalPages = data.last_page;
      const pagination = document.getElementById('pagination'); pagination.innerHTML='';

      const prevBtn = document.createElement('button');
      prevBtn.textContent='← Prev'; prevBtn.disabled = currentPage===1;
      prevBtn.onclick = ()=> { if (currentPage>1) loadVisitors(currentPage-1); };
      pagination.appendChild(prevBtn);

      for (let i=Math.max(1,currentPage-2); i<=Math.min(totalPages,currentPage+2); i++){
        const pageBtn = document.createElement('button');
        pageBtn.textContent=i; pageBtn.className = i===currentPage ? 'active' : '';
        pageBtn.onclick = ()=> loadVisitors(i);
        pagination.appendChild(pageBtn);
      }

      const nextBtn = document.createElement('button');
      nextBtn.textContent='Next →'; nextBtn.disabled = currentPage===totalPages;
      nextBtn.onclick = ()=> { if (currentPage<totalPages) loadVisitors(currentPage+1); };
      pagination.appendChild(nextBtn);
    }

    function setupFilters(){
      const purposeSel = document.getElementById('purposeFilter');
      if (purposeSel){
        purposeSel.addEventListener('change', function(){
          currentFilters.purpose = this.value; loadVisitors(1);
        });
      }

      const dateFilter = document.getElementById('dateFilter');
      const clearDateBtn = document.getElementById('clearDateFilter');
      if (dateFilter){
        dateFilter.addEventListener('change', function(){
          if (this.value){
            const [y,m] = this.value.split('-');
            currentFilters.date = this.value;
            currentFilters.year = y;
            currentFilters.month = String(Number(m));
          } else {
            delete currentFilters.date;
          }
          loadVisitors(1); loadStatistics();
        });
      }
      if (clearDateBtn){
        clearDateBtn.addEventListener('click', function(){
          if (dateFilter) dateFilter.value='';
          delete currentFilters.date;
          loadVisitors(1); loadStatistics();
        });
      }

      const monthFilter = document.getElementById('monthFilter');
      const clearMonthBtn = document.getElementById('clearMonthFilter');
      if (monthFilter){
        monthFilter.addEventListener('change', function(){
          if (this.value){
            const [y,m] = this.value.split('-');
            currentFilters.month = String(Number(m));
            currentFilters.year  = y;
          } else { delete currentFilters.month; delete currentFilters.year; }
          loadVisitors(1); loadStatistics();
        });
      }
      if (clearMonthBtn && monthFilter){
        clearMonthBtn.addEventListener('click', function(){
          monthFilter.value = '';
          delete currentFilters.month; delete currentFilters.year;
          loadVisitors(1); loadStatistics();
        });
      }
    }

    function logout(){
      localStorage.removeItem('admin_token');
      localStorage.removeItem('admin_data');
      window.location.href = '/buku-tamu/admin';
    }

    function showExportModal(){
      document.getElementById('exportPurpose').value = currentFilters.purpose || '';
      const exportMonthInput = document.getElementById('exportMonth');
      if (currentFilters.month && currentFilters.year){
        const mm = String(currentFilters.month).padStart(2,'0');
        exportMonthInput.value = `${currentFilters.year}-${mm}`;
      } else exportMonthInput.value = '';
      document.getElementById('exportModal').style.display='block';
    }

    function closeExportModal(){ document.getElementById('exportModal').style.display='none'; }

    function downloadPDF(){
      const format = document.getElementById('paperFormat').value;
      const orientation = document.getElementById('paperOrientation').value;
      const purpose = document.getElementById('exportPurpose').value;
      const monthYear = document.getElementById('exportMonth').value;

      let url = '/api/export/pdf';
      const params = new URLSearchParams();
      params.append('format', format);
      params.append('orientation', orientation);
      if (purpose) params.append('purpose', purpose);
      if (monthYear){
        const [year, month] = monthYear.split('-');
        params.append('month', String(Number(month)));
        params.append('year', year);
      }
      url += '?' + params.toString();
      closeExportModal();
      window.open(url, '_blank');
    }

    // tutup modal saat klik backdrop
    window.onclick = function(e){
      const modal = document.getElementById('exportModal');
      if (e.target === modal) closeExportModal();
    };

    // start
    initDashboard();
  </script>

  <!-- Modal Konfirmasi Hapus -->
  <div id="deleteModal" class="modal">
    <div class="modal-content">
      <div class="modal-header" style="background: linear-gradient(135deg,#ef4444,#dc2626);">
        <h3>Konfirmasi Hapus</h3>
        <span class="close" onclick="closeDeleteModal()">&times;</span>
      </div>
      <div class="modal-body">
        <p id="deleteMessage">Apakah Anda yakin ingin menghapus data ini?</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
        <button class="btn btn-delete" onclick="confirmDelete()">DELETE</button>
      </div>
    </div>
  </div>

  <!-- Toast -->
  <div id="toast" class="toast"></div>
</body>
</html>

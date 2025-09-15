<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengunjung - Buku Tamu Digital</title>
    <style>
        /* ====== PRINT / A4 ====== */
        @page { size: A4; margin: 18mm 15mm 15mm; } /* margin mirip dok resmi */
        @media print {
            a { text-decoration: none; color: #000; }
        }

        /* ====== BASE ====== */
        html, body { margin:2rem; padding:0; }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #111;
        }

        /* ====== KOP SURAT ====== */
        .kop-surat {
            display: table;
            width: 100%;
            margin: 0 0 6px 0; /* kecil supaya mirip contoh */
        }
        .kop-left, .kop-center, .kop-right {
            display: table-cell; vertical-align: middle;
        }
        .kop-left, .kop-right { width: 110px; } /* kanan dummy utk menyeimbangkan center */
        .kop-left img {
            width: 95px; height: auto; display: block;
        }

        /* Teks kop pakai serif agar mirip cetakan surat */
        .kop-center {
            text-align: center;
            font-family: "Times New Roman", Times, Georgia, serif;
            line-height: 1.2; /* rapat seperti contoh */
        }
        .kop-center .l1 {
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .3px;
        }
        .kop-center .l2 {
            font-size: 22px;
            font-weight: 800; /* lebih tebal */
            text-transform: uppercase;
            margin-top: 2px;
        }
        .kop-center .l3, .kop-center .l4 {
            font-size: 12px; margin-top: 2px;
        }
        .kop-center .l5 {
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            text-decoration: underline;
            letter-spacing: 5px; /* ruang antar huruf seperti contoh */
            margin-top: 4px;
        }

        /* Garis ganda pemisah kop (tebal + tipis) */
        .kop-divider { border-top: 3px solid #000; margin: 6px 0 2px; }
        .kop-divider.thin { border-top: 1px solid #000; margin: 0 0 12px; }

        /* ====== JUDUL ====== */
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin:0; font-size: 20px; letter-spacing:.3px; color:#222; }
        .header p { margin: 4px 0 0; color:#555; }

        /* ====== INFO ====== */
        .info { margin-bottom: 14px; }
        .info table { width:100%; border-collapse: collapse; }
        .info td { padding: 4px 0; }

        /* ====== TABEL DATA ====== */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        .data-table th, .data-table td {
            border: 1px solid #fffbfb;
            padding: 6px 8px;
            text-align: left;
            font-size: 10.5px;
        }
        .data-table th {
            background:#f1f1f1;
            font-weight: 700;
            color:#222;
        }
        .data-table tr:nth-child(even) { background:#fafafa; }

        /* ====== BADGE TUJUAN ====== */
        .purpose-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            color: #000000;
            display: inline-block;
        }
        .purpose-sekretariat { background:transparent; }
        .purpose-aplikasi_informatika { background:transparent; }
        .purpose-informasi_komunikasi_publik { background:transparent; }
        .purpose-statistik { background:transparent; }

        /* ====== RINGKASAN ====== */
        .summary {
            background:#ffffff;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 16px;
            border: 1px solid #ffffff;
        }
        .summary h3 { margin: 0 0 8px; color:#222; font-size: 14px; }
        .summary-grid { display: table; width:100%; }
        .summary-item { display: table-cell; text-align:center; padding: 8px; }
        .summary-number { font-size: 18px; font-weight: 800; color:#000000; }
        .summary-label { font-size: 10px; color:#666; margin-top: 4px; }

        /* ====== FOOTER ====== */
        .footer {
            margin-top: 24px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }

               .col-name{
        max-width: 280px;        /* atur sesuai selera: 220–320px */
        white-space: normal;     /* boleh turun baris */
        overflow-wrap: anywhere; /* pecah kata tanpa spasi */
        word-break: break-word;  /* fallback */
        line-height: 1.3;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <div class="kop-surat">
        <div class="kop-left">
            <!-- Pastikan path gambar benar. Untuk dompdf: gunakan public_path(...) -->
            <img src="{{ public_path('images/123.png') }}" alt="Logo Kabupaten Madiun">
        </div>

        <div class="kop-center">
            <div class="l1">PEMERINTAH KABUPATEN MADIUN</div>
            <div class="l2">DINAS KOMUNIKASI DAN INFORMATIKA</div>
            <div class="l3">Jalan Mastrip Nomor 23 Telp/Fax : (0351) 462927</div>
            <div class="l4">Website : diskominfo.madiunkab.go.id &nbsp; - &nbsp; Email : diskominfo@madiunkab.go.id</div>
            <div class="l5">MADIUN - 63117</div>
        </div>

        <div class="kop-right"><!-- dummy: menjaga center benar-benar di tengah --></div>
    </div>
    <div class="kop-divider"></div>
    <div class="kop-divider thin"></div>

    <!-- JUDUL -->
    <div class="header">
        <h1>LAPORAN PENGUNJUNG</h1>
        <p>Buku Tamu Digital</p>
        <p>
        Dicetak pada:
        {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('d F Y, H:i:s') }}
        WIB
        </p>

    </div>

    <!-- INFO UMUM -->
    <div class="info">
        <table>
            <tr>
                <td><strong>Total Pengunjung</strong></td>
                <td>: {{ $visitors->count() }} orang</td>
                <td><strong>Periode</strong></td>
                <td>:
                    @if($visitors->count() > 0)
                        {{ $visitors->last()->visit_date?->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y') }}
                        -
                        {{ $visitors->first()->visit_date?->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>
    </div>

    @if($visitors->count() > 0)
        <!-- RINGKASAN -->
        <div class="summary">
            <h3>Ringkasan Berdasarkan Tujuan</h3>
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-number">{{ $visitors->where('purpose','sekretariat')->count() }}</div>
                    <div class="summary-label">Sekretariat</div>
                </div>
                <div class="summary-item">
                    <div class="summary-number">{{ $visitors->where('purpose','aplikasi_informatika')->count() }}</div>
                    <div class="summary-label">Aplikasi Informatika</div>
                </div>
                <div class="summary-item">
                    <div class="summary-number">{{ $visitors->where('purpose','persandian_keamanan_informasi')->count() }}</div>
                    <div class="summary-label">Persandian dan Keamanan Informasi</div>
                </div>
                <div class="summary-item">
                    <div class="summary-number">{{ $visitors->where('purpose','informasi_komunikasi_publik')->count() }}</div>
                    <div class="summary-label">Informasi dan Komunikasi Publik</div>
                </div>
                <div class="summary-item">
                    <div class="summary-number">{{ $visitors->where('purpose','statistik')->count() }}</div>
                    <div class="summary-label">Statistik</div>
                </div>
            </div>
        </div>

        <!-- TABEL -->
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="10%">Tanggal</th>
                    <th width="15%">Nama</th>
                    <th width="15%">Email</th>
                    <th width="13%">Telepon</th>
                    <th width="15%">Asal Daerah</th>
                    <th width="15%">Tujuan</th>
                    <th width="50%">Keperluan Kunjungan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($visitors as $index => $visitor)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $visitor->visit_date?->timezone('Asia/Jakarta')->format('d/m/Y H:i') . ' WIB' }}</td>
                    <td class="col-name"><strong>{{ $visitor->name }}</strong></td>
                    <td class="col-name">{{ $visitor->email ?: '-' }}</td>
                    <td>{{ $visitor->phone ?: '-' }}</td>
                    <td>{{ $visitor->asal_daerah ?: '-' }}</td>
                    <td>
                        @php
                            $purposeClass = "purpose-" . $visitor->purpose;
                            $purposeText = [
                                "sekretariat" => "Sekretariat",
                                "aplikasi_informatika" => "Aplikasi Informatika",
                                "informasi_komunikasi_publik" => "Informasi dan Komunikasi Publik",
                                "statistik" => "Statistik"
                            ][$visitor->purpose] ?? ucfirst(str_replace('_',' ',$visitor->purpose));
                        @endphp
                        <span class="purpose-badge {{ $purposeClass }}">{{ $purposeText }}</span>
                    </td>
                    <td class="col-name">{{ $visitor->notes ?: '-' }}</td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="text-align:center; padding:50px; color:#666;">
            <h3>Tidak ada data pengunjung</h3>
            <p>Belum ada pengunjung yang terdaftar dalam periode ini.</p>
        </div>
    @endif

    <div class="footer">
        <p>Laporan ini disusun secara otomatis oleh Sistem Buku Tamu Digital</p>
        <p>© {{ date('Y') }} DISKOMINFO KABUPATEN MADIUN</p>
    </div>
</body>
</html>

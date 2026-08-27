<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Buku Tamu Digital - Diskominfo Kabupaten Madiun</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

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
            --primary-light: #f0f9ff;
            --primary-border: #bae6fd;
            --slate-dark: #0f172a;
            --slate-body: #334155;
            --slate-muted: #64748b;
            --slate-light: #f8fafc;
            --border-color: #e2e8f0;
            --success: #059669;
            --danger: #dc2626;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            background: linear-gradient(180deg, #f8fafc 0%, #edf2f7 100%);
            color: var(--slate-body);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
            -webkit-font-smoothing: antialiased;
        }

        .top-nav {
            width: 100%;
            max-width: 680px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--slate-muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            font-family: var(--font-heading);
            padding: 8px 14px;
            border-radius: 10px;
            background: #ffffff;
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .back-link:hover {
            color: var(--primary);
            border-color: var(--primary-border);
            transform: translateX(-2px);
        }

        .form-container {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid var(--border-color);
            box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.06), 0 20px 25px -5px rgba(15, 23, 42, 0.04);
            padding: 40px;
            max-width: 680px;
            width: 100%;
        }

        .header-box {
            text-align: center;
            margin-bottom: 32px;
        }

        .header-logo {
            max-height: 48px;
            width: auto;
            margin-bottom: 16px;
        }

        .header-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--primary-light);
            color: var(--primary);
            border: 1px solid var(--primary-border);
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 4px 12px;
            border-radius: 9999px;
            margin-bottom: 12px;
        }

        .header-title {
            font-family: var(--font-heading);
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--slate-dark);
            letter-spacing: -0.02em;
            margin-bottom: 8px;
        }

        .header-desc {
            font-size: 0.95rem;
            color: var(--slate-muted);
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-label {
            display: block;
            font-family: var(--font-heading);
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--slate-dark);
            margin-bottom: 8px;
        }

        .form-label .req {
            color: var(--danger);
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            font-family: var(--font-body);
            font-size: 0.95rem;
            color: var(--slate-dark);
            background: #ffffff;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        /* Purpose Radio Grid */
        .purpose-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 10px;
        }

        .purpose-option {
            position: relative;
        }

        .purpose-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .purpose-label {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 11px 14px;
            background: var(--slate-light);
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            cursor: pointer;
            font-size: 0.88rem;
            font-weight: 500;
            color: var(--slate-body);
            transition: all 0.2s ease;
        }

        .purpose-label:hover {
            border-color: #cbd5e1;
            background: #ffffff;
        }

        .purpose-option input[type="radio"]:checked + .purpose-label {
            background: var(--primary-light);
            border-color: var(--primary);
            color: var(--primary);
            font-weight: 600;
        }

        /* Camera Section */
        .camera-card {
            background: var(--slate-light);
            border: 1.5px solid var(--border-color);
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 24px;
        }

        .camera-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .camera-title {
            font-family: var(--font-heading);
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--slate-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .camera-viewport {
            position: relative;
            width: 100%;
            max-width: 360px;
            height: 270px;
            margin: 0 auto 16px;
            background: #0f172a;
            border-radius: 14px;
            overflow: hidden;
            border: 2px solid #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .camera-viewport video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .camera-placeholder {
            text-align: center;
            color: #94a3b8;
            padding: 20px;
        }

        .camera-placeholder i {
            font-size: 2.5rem;
            margin-bottom: 8px;
            display: block;
        }

        .photo-preview-box {
            text-align: center;
            display: none;
            margin-bottom: 16px;
        }

        .photo-preview-box img {
            max-width: 360px;
            width: 100%;
            height: 270px;
            object-fit: cover;
            border-radius: 14px;
            border: 2.5px solid var(--success);
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.15);
        }

        .camera-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-custom {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            font-family: var(--font-heading);
            font-size: 0.9rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-primary-custom {
            background-color: var(--primary);
            color: #ffffff;
        }

        .btn-primary-custom:hover {
            background-color: var(--primary-hover);
        }

        .btn-success-custom {
            background-color: var(--success);
            color: #ffffff;
        }

        .btn-success-custom:hover {
            background-color: #047857;
        }

        .btn-secondary-custom {
            background-color: #64748b;
            color: #ffffff;
        }

        .btn-secondary-custom:hover {
            background-color: #475569;
        }

        .btn-submit-main {
            width: 100%;
            padding: 14px;
            font-size: 1rem;
            font-weight: 700;
            background-color: var(--primary);
            color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit-main:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(2, 132, 199, 0.35);
        }

        .btn-submit-main:disabled {
            opacity: 0.65;
            cursor: not-allowed;
            transform: none;
        }

        /* Alert notifications */
        .alert-box {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-info-soft { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
        .alert-success-soft { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .alert-danger-soft { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

        /* Success Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 1050;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-card {
            background: #ffffff;
            border-radius: 20px;
            max-width: 480px;
            width: 100%;
            padding: 32px;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: modalFadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        .modal-icon-success {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: #dcfce7;
            color: var(--success);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 16px;
        }

        @media (max-width: 640px) {
            .form-container {
                padding: 24px 18px;
            }
            .header-title {
                font-size: 1.5rem;
            }
            .purpose-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="top-nav">
        <a href="{{ route('homepage') }}" class="back-link">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

    <div class="form-container">
        <header class="header-box">
            <img class="header-logo" src="{{ asset('images/logo-diskominfo.png') }}" alt="Diskominfo Kabupaten Madiun">
            <br>
            <div class="header-badge">
                <i class="fa-solid fa-clipboard-user"></i> Presensi Tamu
            </div>
            <h1 class="header-title">Buku Tamu Digital</h1>
            <p class="header-desc">Selamat datang di Dinas Komunikasi dan Informatika Kabupaten Madiun. Mohon lengkapi formulir kunjungan Anda di bawah ini.</p>
        </header>

        <div id="alert-container"></div>
        <div id="location-status" class="alert-box alert-info-soft">
            <i class="fa-solid fa-location-dot"></i>
            <span>Memverifikasi status lokasi kunjungan...</span>
        </div>

        <form id="visitorForm">
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">

            <div class="form-group">
                <label for="name" class="form-label">Nama Lengkap <span class="req">*</span></label>
                <input type="text" id="name" name="name" class="form-control" required placeholder="Nama lengkap sesuai identitas" autocomplete="name" />
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Alamat Email (Opsional)</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="contoh@domain.com" autocomplete="email" />
            </div>

            <div class="form-group">
                <label for="phone" class="form-label">Nomor Telepon / WhatsApp <span class="req">*</span></label>
                <input type="tel" id="phone" name="phone" class="form-control" required placeholder="08xxxxxxxxxx" autocomplete="tel" />
            </div>

            <div class="form-group">
                <label for="asal_daerah" class="form-label">Asal Instansi / Daerah <span class="req">*</span></label>
                <input type="text" id="asal_daerah" name="asal_daerah" class="form-control" required placeholder="Contoh: Bappeda, Pemprov Jatim, Media" autocomplete="organization" />
            </div>

            <div class="form-group">
                <label class="form-label">Tujuan Bidang / Bagian <span class="req">*</span></label>
                <div class="purpose-grid" role="radiogroup">
                    <div class="purpose-option">
                        <input type="radio" id="sekretariat" name="purpose" value="sekretariat" required />
                        <label class="purpose-label" for="sekretariat">
                            <i class="fa-solid fa-briefcase"></i> Sekretariat
                        </label>
                    </div>
                    <div class="purpose-option">
                        <input type="radio" id="aplikasi_informatika" name="purpose" value="aplikasi_informatika" required />
                        <label class="purpose-label" for="aplikasi_informatika">
                            <i class="fa-solid fa-laptop-code"></i> Aplikasi Informatika
                        </label>
                    </div>
                    <div class="purpose-option">
                        <input type="radio" id="informasi_komunikasi_publik" name="purpose" value="informasi_komunikasi_publik" required />
                        <label class="purpose-label" for="informasi_komunikasi_publik">
                            <i class="fa-solid fa-bullhorn"></i> Komunikasi Publik
                        </label>
                    </div>
                    <div class="purpose-option">
                        <input type="radio" id="persandian_keamanan_informasi" name="purpose" value="persandian_keamanan_informasi" required />
                        <label class="purpose-label" for="persandian_keamanan_informasi">
                            <i class="fa-solid fa-shield-halved"></i> Persandian & Sandi
                        </label>
                    </div>
                    <div class="purpose-option">
                        <input type="radio" id="statistik" name="purpose" value="statistik" required />
                        <label class="purpose-label" for="statistik">
                            <i class="fa-solid fa-chart-pie"></i> Statistik Sektoral
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="notes" class="form-label">Keperluan / Keterangan Kunjungan</label>
                <textarea id="notes" name="notes" rows="3" class="form-control" placeholder="Tuliskan ringkasan maksud dan keperluan kunjungan Anda..."></textarea>
            </div>

            <!-- Kamera Selfie -->
            <div class="camera-card">
                <div class="camera-header">
                    <div class="camera-title">
                        <i class="fa-solid fa-camera text-primary"></i>
                        <span>Swafoto / Foto Pengunjung</span>
                    </div>
                    <span class="small text-muted">Opsional / Diutamakan</span>
                </div>

                <div class="camera-viewport" id="cameraViewport">
                    <video id="video" autoplay muted playsinline style="display:none;"></video>
                    <canvas id="canvas" style="display:none;"></canvas>
                    <div id="cameraPlaceholder" class="camera-placeholder">
                        <i class="fa-solid fa-camera"></i>
                        <p class="small mb-0">Klik tombol di bawah untuk mengaktifkan kamera</p>
                    </div>
                </div>

                <div class="photo-preview-box" id="photoPreviewBox">
                    <img id="photoPreviewImg" src="" alt="Preview Foto Pengunjung">
                </div>

                <div class="camera-actions">
                    <button type="button" id="startCameraBtn" class="btn-custom btn-primary-custom">
                        <i class="fa-solid fa-video"></i> Buka Kamera
                    </button>
                    <button type="button" id="snapPhotoBtn" class="btn-custom btn-success-custom" style="display:none;">
                        <i class="fa-solid fa-camera"></i> Ambil Foto
                    </button>
                    <button type="button" id="retakePhotoBtn" class="btn-custom btn-secondary-custom" style="display:none;">
                        <i class="fa-solid fa-rotate-right"></i> Ambil Ulang
                    </button>
                </div>
            </div>

            <button type="submit" id="submitBtn" class="btn-submit-main">
                <i class="fa-solid fa-paper-plane"></i> Kirim Data Kunjungan
            </button>
        </form>
    </div>

    <!-- Modal Konfirmasi Sukses -->
    <div class="modal-overlay" id="successModal">
        <div class="modal-card">
            <div class="modal-icon-success">
                <i class="fa-solid fa-check"></i>
            </div>
            <h3 class="header-title" style="font-size: 1.45rem; margin-bottom: 8px;">Presensi Berhasil Disimpan</h3>
            <p class="text-muted small mb-4" id="successModalMsg">Terima kasih atas kunjungan Anda di Diskominfo Kabupaten Madiun.</p>
            <button type="button" class="btn-custom btn-primary-custom w-100" id="closeModalBtn">
                Selesai / Isi Form Baru
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let capturedPhotoBase64 = null;
            let mediaStream = null;

            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const cameraPlaceholder = document.getElementById('cameraPlaceholder');
            const cameraViewport = document.getElementById('cameraViewport');
            const photoPreviewBox = document.getElementById('photoPreviewBox');
            const photoPreviewImg = document.getElementById('photoPreviewImg');
            const startCameraBtn = document.getElementById('startCameraBtn');
            const snapPhotoBtn = document.getElementById('snapPhotoBtn');
            const retakePhotoBtn = document.getElementById('retakePhotoBtn');
            const locationStatus = document.getElementById('location-status');
            const alertContainer = document.getElementById('alert-container');
            const visitorForm = document.getElementById('visitorForm');
            const submitBtn = document.getElementById('submitBtn');
            const successModal = document.getElementById('successModal');
            const closeModalBtn = document.getElementById('closeModalBtn');

            // 1. Geolocation Handling
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        document.getElementById('latitude').value = position.coords.latitude;
                        document.getElementById('longitude').value = position.coords.longitude;
                        locationStatus.className = 'alert-box alert-success-soft';
                        locationStatus.innerHTML = '<i class="fa-solid fa-circle-check"></i> <span>Lokasi kunjungan berhasil diverifikasi.</span>';
                        setTimeout(() => { locationStatus.style.display = 'none'; }, 4000);
                    },
                    function(error) {
                        locationStatus.className = 'alert-box alert-info-soft';
                        locationStatus.innerHTML = '<i class="fa-solid fa-info-circle"></i> <span>Lokasi GPS dilewati / tidak diizinkan. Form tetap dapat dikirim.</span>';
                        setTimeout(() => { locationStatus.style.display = 'none'; }, 4000);
                    },
                    { enableHighAccuracy: false, timeout: 8000, maximumAge: 300000 }
                );
            } else {
                locationStatus.style.display = 'none';
            }

            // 2. Camera Functions
            startCameraBtn.addEventListener('click', async function() {
                try {
                    mediaStream = await navigator.mediaDevices.getUserMedia({
                        video: { width: { ideal: 640 }, height: { ideal: 480 }, facingMode: 'user' },
                        audio: false
                    });
                    video.srcObject = mediaStream;
                    video.style.display = 'block';
                    cameraPlaceholder.style.display = 'none';
                    startCameraBtn.style.display = 'none';
                    snapPhotoBtn.style.display = 'inline-flex';
                } catch (err) {
                    console.warn('Camera access error:', err);
                    alertContainer.innerHTML = '<div class="alert-box alert-danger-soft"><i class="fa-solid fa-triangle-exclamation"></i> <span>Kamera tidak dapat diakses atau izin ditolak. Anda tetap dapat mengirim form tanpa foto.</span></div>';
                }
            });

            snapPhotoBtn.addEventListener('click', function() {
                canvas.width = video.videoWidth || 640;
                canvas.height = video.videoHeight || 480;
                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                capturedPhotoBase64 = canvas.toDataURL('image/jpeg', 0.85);

                // Stop camera stream
                if (mediaStream) {
                    mediaStream.getTracks().forEach(track => track.stop());
                }

                video.style.display = 'none';
                cameraViewport.style.display = 'none';
                photoPreviewImg.src = capturedPhotoBase64;
                photoPreviewBox.style.display = 'block';

                snapPhotoBtn.style.display = 'none';
                retakePhotoBtn.style.display = 'inline-flex';
            });

            retakePhotoBtn.addEventListener('click', async function() {
                capturedPhotoBase64 = null;
                photoPreviewBox.style.display = 'none';
                cameraViewport.style.display = 'flex';
                retakePhotoBtn.style.display = 'none';
                startCameraBtn.style.display = 'inline-flex';
                cameraPlaceholder.style.display = 'block';
            });

            // 3. Form Submission
            visitorForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                alertContainer.innerHTML = '';
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...';

                const formData = {
                    name: document.getElementById('name').value.trim(),
                    email: document.getElementById('email').value.trim() || null,
                    phone: document.getElementById('phone').value.trim(),
                    asal_daerah: document.getElementById('asal_daerah').value.trim(),
                    purpose: document.querySelector('input[name="purpose"]:checked')?.value || '',
                    notes: document.getElementById('notes').value.trim() || null,
                    latitude: document.getElementById('latitude').value || null,
                    longitude: document.getElementById('longitude').value || null,
                    photo: capturedPhotoBase64 || null
                };

                try {
                    const response = await fetch('/api/visitors', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(formData)
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        successModal.classList.add('active');
                    } else {
                        const errMsg = data.message || 'Terjadi kesalahan saat menyimpan data kunjungan.';
                        alertContainer.innerHTML = `<div class="alert-box alert-danger-soft"><i class="fa-solid fa-circle-exclamation"></i> <span>${errMsg}</span></div>`;
                    }
                } catch (err) {
                    console.error('Submit error:', err);
                    alertContainer.innerHTML = '<div class="alert-box alert-danger-soft"><i class="fa-solid fa-triangle-exclamation"></i> <span>Gagal terhubung ke server. Periksa koneksi Anda dan coba lagi.</span></div>';
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Kirim Data Kunjungan';
                }
            });

            closeModalBtn.addEventListener('click', function() {
                successModal.classList.remove('active');
                visitorForm.reset();
                capturedPhotoBase64 = null;
                photoPreviewBox.style.display = 'none';
                cameraViewport.style.display = 'flex';
                cameraPlaceholder.style.display = 'block';
                video.style.display = 'none';
                startCameraBtn.style.display = 'inline-flex';
                snapPhotoBtn.style.display = 'none';
                retakePhotoBtn.style.display = 'none';
            });
        });
    </script>
</body>
</html>
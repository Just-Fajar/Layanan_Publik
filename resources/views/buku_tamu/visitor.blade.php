<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Buku Tamu DISKOMINFO Kabupaten Madiun</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #3B82F6;
            --primary-hover: #2563EB;
            --secondary-color: #10B981;
            --secondary-hover: #059669;
            --danger-color: #EF4444;
            --warning-bg: #fff3cd;
            --warning-text: #856404;
            --warning-border: #ffeeba;
            --background-color: #F3F4F6;
            --surface-color: #FFFFFF;
            --text-primary: #1F2937;
            --text-secondary: #6B7280;
            --border-color: #D1D5DB;
            --border-focus: var(--primary-color);
            --font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--background-color);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 24px;
            color: var(--text-primary);
        }

        .container {
            background: var(--surface-color);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            border: 1px solid #E5E7EB;
            padding: 48px;
            max-width: 650px;
            width: 100%;
            animation: fadeIn .7s ease-out;
        }

        .header {
            text-align: center;
            margin-bottom: 32px;
        }

        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 16px;
        }

        .brand-logo {
            height: 72px;
        }

        .header h1 {
            font-size: 2.3rem;
            font-weight: 700;
            margin-bottom: 8px;
            background: linear-gradient(120deg, var(--primary-color), var(--primary-hover));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .header p {
            color: var(--text-secondary);
            font-size: 1rem;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text-primary);
        }

        .form-control {
            width: 100%;
            padding: 14px 16px;
            border: 1.5px solid var(--border-color);
            border-radius: 12px;
            font-size: 1rem;
            font-family: var(--font-family);
            background-color: #FAFAFA;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--border-focus);
            background-color: var(--surface-color);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

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
        }

        .purpose-option label {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 12px 14px;
            border: 1.5px solid var(--border-color);
            border-radius: 12px;
            font-size: 0.88rem;
            font-weight: 500;
            cursor: pointer;
            background-color: #FAFAFA;
            transition: all 0.2s ease;
            height: 100%;
        }

        .purpose-option input[type="radio"]:checked + label {
            border-color: var(--primary-color);
            background-color: rgba(59, 130, 246, 0.08);
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Camera Section */
        .camera-section {
            background-color: #F9FAFB;
            border: 1.5px dashed var(--border-color);
            border-radius: 16px;
            padding: 24px;
            margin: 24px 0;
            text-align: center;
        }

        .camera-section h3 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--text-primary);
        }

        .camera-instructions {
            font-size: 0.88rem;
            color: var(--text-secondary);
            margin-bottom: 16px;
        }

        .camera-container {
            position: relative;
            width: 100%;
            max-width: 360px;
            height: 270px;
            margin: 0 auto 16px auto;
            background-color: #1F2937;
            border-radius: 14px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #canvas {
            display: none;
        }

        .photo-preview {
            margin: 12px auto;
            max-width: 320px;
        }

        .photo-preview img {
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border: 2px solid var(--secondary-color);
        }

        .camera-controls {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: var(--font-family);
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: #FFFFFF;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        .btn-secondary {
            background-color: #6B7280;
            color: #FFFFFF;
        }

        .btn-secondary:hover {
            background-color: #4B5563;
        }

        .btn-success {
            background-color: var(--secondary-color);
            color: #FFFFFF;
        }

        .btn-success:hover {
            background-color: var(--secondary-hover);
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: #FFFFFF;
            padding: 16px;
            border-radius: 14px;
            font-size: 1.05rem;
            margin-top: 16px;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.25);
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.35);
        }

        .btn:disabled, .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .alert {
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .alert-success {
            background-color: #D1FAE5; color: #065F46; border: 1px solid #A7F3D0;
        }

        .alert-error {
            background-color: #FEE2E2; color: #991B1B; border: 1px solid #FECACA;
        }

        .alert-warning {
            background: var(--warning-bg); color: var(--warning-text); border: 1px solid var(--warning-border);
        }

        #loading {
            display: none;
            text-align: center;
            margin: 20px 0;
        }

        .spinner {
            border: 4px solid #E5E7EB;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            width: 32px;
            height: 32px;
            animation: spin 1s linear infinite;
            margin: 0 auto 8px auto;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            body { padding: 16px; }
            .container { padding: 24px; }
            .header h1 { font-size: 1.8rem; }
            .purpose-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>
    <div class="container">
        <header class="header">
            <div class="brand">
                <img class="brand-logo" src="{{ asset('images/logo-diskominfo.png') }}" alt="Logo Diskominfo Kabupaten Madiun">
            </div>
            <h1>Buku Tamu</h1>
            <p>Selamat datang di Dinas Komunikasi dan Informatika Kabupaten Madiun. Silakan isi data kunjungan Anda.</p>
        </header>

        <div id="alert-container"></div>
        <div id="location-status">
            <div class="alert alert-warning"><i class="fas fa-map-marker-alt mr-2"></i> Memeriksa lokasi Anda...</div>
        </div>

        <form id="visitorForm">
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">

            <div class="form-group">
                <label for="name">Nama Lengkap <span style="color:red">*</span></label>
                <input type="text" id="name" name="name" class="form-control" required placeholder="Masukkan nama lengkap Anda" autocomplete="name" />
            </div>

            <div class="form-group">
                <label for="email">Email (Opsional)</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="nama@email.com" autocomplete="email" />
            </div>

            <div class="form-group">
                <label for="phone">Nomor Telepon <span style="color:red">*</span></label>
                <input type="tel" id="phone" name="phone" class="form-control" required placeholder="08xxxxxxxxxx" autocomplete="tel" />
            </div>

            <div class="form-group">
                <label for="asal_daerah">Asal Instansi / Daerah <span style="color:red">*</span></label>
                <input type="text" id="asal_daerah" name="asal_daerah" class="form-control" required placeholder="Contoh: Pemkab Madiun, Surabaya" autocomplete="organization" />
            </div>

            <div class="form-group">
                <label id="purpose-label">Tujuan Kunjungan <span style="color:red">*</span></label>
                <div class="purpose-grid" role="radiogroup" aria-labelledby="purpose-label">
                    <div class="purpose-option">
                        <input type="radio" id="sekretariat" name="purpose" value="sekretariat" required />
                        <label for="sekretariat">Sekretariat</label>
                    </div>
                    <div class="purpose-option">
                        <input type="radio" id="aplikasi_informatika" name="purpose" value="aplikasi_informatika" required />
                        <label for="aplikasi_informatika">Aplikasi Informatika</label>
                    </div>
                    <div class="purpose-option">
                        <input type="radio" id="persandian_keamanan_informasi" name="purpose" value="persandian_keamanan_informasi" required />
                        <label for="persandian_keamanan_informasi">Persandian & Keamanan</label>
                    </div>
                    <div class="purpose-option">
                        <input type="radio" id="informasi_komunikasi_publik" name="purpose" value="informasi_komunikasi_publik" required />
                        <label for="informasi_komunikasi_publik">Komunikasi Publik</label>
                    </div>
                    <div class="purpose-option">
                        <input type="radio" id="statistik" name="purpose" value="statistik" required />
                        <label for="statistik">Statistik</label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="notes">Keperluan Kunjungan</label>
                <textarea id="notes" name="notes" rows="3" class="form-control" placeholder="Jelaskan keperluan kunjungan Anda..."></textarea>
            </div>

            <!-- Camera Capture Section -->
            <section class="camera-section">
                <h3><i class="fas fa-camera mr-2"></i> Foto Pengunjung</h3>
                <p class="camera-instructions">
                    Silakan aktifkan kamera dan ambil foto selfie Anda sebelum mengirim data.
                </p>

                <div class="camera-container" id="cameraContainer">
                    <video id="video" autoplay muted playsinline style="display:none;"></video>
                    <canvas id="canvas"></canvas>
                    <div id="cameraPlaceholder" style="color: #9CA3AF; text-align: center;">
                        <i class="fas fa-camera text-4xl mb-2" style="font-size: 3rem;"></i>
                        <p style="font-size: 0.9rem;">Kamera belum aktif</p>
                    </div>
                </div>

                <div class="photo-preview" id="photoPreview"></div>

                <div class="camera-controls">
                    <button type="button" id="startCameraBtn" class="btn btn-primary">
                        <i class="fas fa-video mr-1"></i> Aktifkan Kamera
                    </button>
                    <button type="button" id="snapPhotoBtn" class="btn btn-success" style="display:none;">
                        <i class="fas fa-camera-retro mr-1"></i> Ambil Foto (Cekrek)
                    </button>
                    <button type="button" id="retakePhotoBtn" class="btn btn-secondary" style="display:none;">
                        <i class="fas fa-redo mr-1"></i> Ambil Ulang
                    </button>
                </div>
            </section>

            <div id="loading">
                <div class="spinner"></div>
                <p>Menyimpan data kunjungan Anda...</p>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane mr-2"></i> Kirim Data Kunjungan
            </button>
        </form>
    </div>

    <script src="{{ asset('js/geolocation.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const elements = {
                video: document.getElementById('video'),
                canvas: document.getElementById('canvas'),
                cameraContainer: document.getElementById('cameraContainer'),
                cameraPlaceholder: document.getElementById('cameraPlaceholder'),
                startCameraBtn: document.getElementById('startCameraBtn'),
                snapPhotoBtn: document.getElementById('snapPhotoBtn'),
                retakePhotoBtn: document.getElementById('retakePhotoBtn'),
                photoPreview: document.getElementById('photoPreview'),
                visitorForm: document.getElementById('visitorForm'),
                alertContainer: document.getElementById('alert-container'),
                loadingIndicator: document.getElementById('loading'),
                submitBtn: document.querySelector('.btn-submit')
            };

            const ctx = elements.canvas.getContext('2d');
            let photoData = null;
            let stream = null;

            function showAlert(message, type = 'error') {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
                elements.alertContainer.innerHTML = `<div class="alert ${alertClass}">${message}</div>`;
                window.scrollTo({ top: 0, behavior: 'smooth' });
                setTimeout(() => { elements.alertContainer.innerHTML = ''; }, 6000);
            }

            function stopCamera() {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    stream = null;
                }
            }

            // Start Camera
            elements.startCameraBtn.addEventListener('click', async function() {
                try {
                    if (!navigator.mediaDevices?.getUserMedia) {
                        throw new Error('Browser tidak mendukung akses kamera.');
                    }

                    stream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: 'user', width: { ideal: 640 }, height: { ideal: 480 } },
                        audio: false
                    });

                    elements.video.srcObject = stream;
                    elements.video.style.display = 'block';
                    elements.cameraPlaceholder.style.display = 'none';
                    await elements.video.play();

                    elements.startCameraBtn.style.display = 'none';
                    elements.snapPhotoBtn.style.display = 'inline-flex';
                    elements.retakePhotoBtn.style.display = 'none';
                    elements.photoPreview.innerHTML = '';
                    photoData = null;
                } catch (err) {
                    console.error('Camera error:', err);
                    showAlert('Tidak dapat mengakses kamera. Pastikan izin kamera telah diberikan.', 'error');
                }
            });

            // Snap Photo (Cekrek)
            elements.snapPhotoBtn.addEventListener('click', function() {
                elements.canvas.width = elements.video.videoWidth || 640;
                elements.canvas.height = elements.video.videoHeight || 480;
                ctx.drawImage(elements.video, 0, 0, elements.canvas.width, elements.canvas.height);
                photoData = elements.canvas.toDataURL('image/jpeg', 0.85);

                elements.photoPreview.innerHTML = `<img src="${photoData}" alt="Foto Selfie Pengunjung">`;
                elements.video.style.display = 'none';
                elements.cameraPlaceholder.style.display = 'none';
                elements.snapPhotoBtn.style.display = 'none';
                elements.retakePhotoBtn.style.display = 'inline-flex';

                stopCamera();
            });

            // Retake Photo
            elements.retakePhotoBtn.addEventListener('click', function() {
                elements.startCameraBtn.click();
            });

            function toggleLoading(isLoading) {
                elements.loadingIndicator.style.display = isLoading ? 'block' : 'none';
                elements.submitBtn.disabled = isLoading;
                elements.submitBtn.innerHTML = isLoading ? '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...' : '<i class="fas fa-paper-plane mr-2"></i> Kirim Data Kunjungan';
            }

            function resetFormState() {
                elements.visitorForm.reset();
                photoData = null;
                elements.photoPreview.innerHTML = '';
                elements.startCameraBtn.style.display = 'inline-flex';
                elements.snapPhotoBtn.style.display = 'none';
                elements.retakePhotoBtn.style.display = 'none';
                elements.video.style.display = 'none';
                elements.cameraPlaceholder.style.display = 'block';
            }

            // Submit Form
            elements.visitorForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                if (!photoData) {
                    showAlert('Mohon ambil foto selfie terlebih dahulu dengan tombol "Ambil Foto (Cekrek)".', 'error');
                    return;
                }

                toggleLoading(true);

                const formData = new FormData(this);
                const payload = Object.fromEntries(formData.entries());
                payload.photo = photoData;

                try {
                    const response = await fetch('/api/visitors', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    });

                    const result = await response.json();
                    if (!response.ok) {
                        throw new Error(result.message || 'Gagal menyimpan data kunjungan.');
                    }

                    showAlert('Terima kasih! Data kunjungan Anda telah berhasil disimpan.', 'success');
                    resetFormState();
                } catch (error) {
                    console.error('Submit error:', error);
                    showAlert(error.message || 'Gagal terhubung ke server. Periksa koneksi Anda.', 'error');
                } finally {
                    toggleLoading(false);
                }
            });

            window.addEventListener('beforeunload', stopCamera);
        });
    </script>
</body>
</html>
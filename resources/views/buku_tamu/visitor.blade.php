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

    <style>
        /* =============================================
         * 1. VARIABLES & RESET
         * ============================================= */
        :root {
            --primary-color: #3B82F6; /* Blue-500 */
            --primary-hover: #2563EB; /* Blue-600 */
            --secondary-color: #10B981; /* Green-500 */
            --secondary-hover: #059669; /* Green-600 */
            --danger-color: #EF4444; /* Red-500 */
            --warning-bg: #fff3cd;
            --warning-text: #856404;
            --warning-border: #ffeeba;
            --background-color: #F3F4F6; /* Gray-100 */
            --surface-color: #FFFFFF;
            --text-primary: #1F2937; /* Gray-800 */
            --text-secondary: #6B7280; /* Gray-500 */
            --border-color: #D1D5DB; /* Gray-300 */
            --border-focus: var(--primary-color);
            --font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* =============================================
         * 2. LAYOUT & TYPOGRAPHY
         * ============================================= */
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
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 8px;
            background: linear-gradient(120deg, var(--primary-color), var(--primary-hover));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .header p {
            color: var(--text-secondary);
            font-size: 1.1rem;
            line-height: 1.6;
        }

        /* =============================================
         * 3. FORM ELEMENTS
         * ============================================= */
        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-primary);
            font-weight: 600;
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 1rem;
            font-family: var(--font-family);
            transition: all 0.3s ease;
            background-color: #F9FAFB;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--border-focus);
            background: var(--surface-color);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        /* =============================================
         * 4. PURPOSE SELECTION GRID
         * ============================================= */
        .purpose-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .purpose-option input[type="radio"] {
            display: none;
        }

        .purpose-option label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 16px;
            background: #F9FAFB;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .purpose-option label:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .purpose-option input[type="radio"]:checked+label {
            background: var(--primary-color);
            color: var(--surface-color);
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }

        /* =============================================
         * 5. CAMERA & PHOTO SECTION
         * ============================================= */
        .camera-section {
            margin: 40px 0;
            padding: 24px;
            border: 2px dashed var(--border-color);
            border-radius: 16px;
            text-align: center;
            background-color: #F9FAFB;
        }

        .camera-section h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .camera-instructions {
            color: var(--text-secondary);
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .camera-container {
            position: relative;
            display: inline-block;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            background-color: #111;
        }

        #video {
            width: 320px;
            height: 240px;
            object-fit: cover;
            display: block;
        }

        #canvas {
            display: none;
        }

        .flash {
            position: absolute;
            inset: 0;
            background-color: white;
            opacity: 0;
            animation: flash-animation 0.5s ease-out;
        }
        
        @keyframes flash-animation {
            from { opacity: 0.8; }
            to { opacity: 0; }
        }

        .camera-controls {
            margin-top: 24px;
        }

        .photo-preview img {
            max-width: 240px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            border: 4px solid white;
            margin-top: 24px;
        }

        #expressionLabel {
            margin-top: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--primary-hover);
            height: 24px; /* Reserve space to prevent layout shift */
        }

        /* =============================================
         * 6. BUTTONS
         * ============================================= */
        .btn {
            border: none;
            padding: 14px 28px;
            border-radius: 999px;
            font-size: 1rem;
            font-weight: 600;
            font-family: var(--font-family);
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 5px;
        }

        .btn:hover {
            transform: translateY(-3px);
        }

        .btn-primary {
            background-color: var(--surface-color);
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-color);
            color: var(--surface-color);
            box-shadow: 0 7px 20px rgba(59, 130, 246, 0.2);
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
            color: var(--surface-color);
            border: 2px solid var(--secondary-color);
        }

        .btn-secondary:hover {
            background-color: var(--secondary-hover);
            border-color: var(--secondary-hover);
            box-shadow: 0 7px 20px rgba(16, 185, 129, 0.2);
        }

        .btn-submit {
            width: 100%;
            background: var(--primary-color);
            color: var(--surface-color);
            padding: 18px;
            border-radius: 16px;
            font-size: 1.1rem;
            margin-top: 24px;
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.2);
        }

        .btn-submit:hover {
            background: var(--primary-hover);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }

        .btn:disabled, .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* =============================================
         * 7. ALERTS & LOADING INDICATORS
         * ============================================= */
        .alert {
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-weight: 500;
            border-width: 1px;
            border-style: solid;
            animation: fadeIn .3s;
        }

        .alert-success {
            background-color: #D1FAE5; color: #065F46; border-color: #A7F3D0;
        }

        .alert-error {
            background-color: #FEE2E2; color: #991B1B; border-color: #FECACA;
        }

        .alert-warning {
            background: var(--warning-bg); color: var(--warning-text); border: 1px solid var(--warning-border);
        }

        #loading {
            display: none;
            text-align: center;
            margin: 24px 0;
        }

        .spinner {
            border: 4px solid #E5E7EB;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            width: 36px;
            height: 36px;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px auto;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* =============================================
         * 8. RESPONSIVE DESIGN
         * ============================================= */
        @media (max-width: 768px) {
            body { padding: 16px; }
            .container { padding: 24px; }
            .header h1 { font-size: 2.1rem; }
            .purpose-grid { grid-template-columns: 1fr; }
            #video { width: 100%; max-width: 280px; height: auto; }
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
            <div class="alert alert-warning">Memeriksa lokasi Anda...</div>
        </div>

        <form id="visitorForm">
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-control" required />
            </div>

            <div class="form-group">
                <label for="email">Email (Opsional)</label>
                <input type="email" id="email" name="email" class="form-control" />
            </div>

            <div class="form-group">
                <label for="phone">Nomor Telepon</label>
                <input type="tel" id="phone" name="phone" class="form-control" required />
            </div>

            <div class="form-group">
                <label for="asal_daerah">Asal Instansi / Daerah</label>
                <input type="text" id="asal_daerah" name="asal_daerah" class="form-control" required placeholder="Contoh: Pemkab Madiun, Surabaya" />
            </div>

            <div class="form-group">
                <label>Tujuan Kunjungan</label>
                <div class="purpose-grid">
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

            <section class="camera-section">
                <h3>Ambil Foto Anda</h3>
                <p class="camera-instructions">
                    Foto akan diambil <b>otomatis</b> saat Anda <b>tersenyum</b> 😊.
                    <br />Pastikan wajah terlihat jelas dan pencahayaan cukup.
                </p>
                <div class="camera-container" id="cameraContainer">
                    <video id="video" autoplay muted playsinline></video>
                    <canvas id="canvas"></canvas>
                </div>
                <div class="camera-controls">
                    <button type="button" id="startCameraBtn" class="btn btn-primary">Aktifkan Kamera</button>
                    <button type="button" id="retakePhotoBtn" class="btn btn-secondary" style="display:none;">Ambil Ulang</button>
                </div>
                <div class="photo-preview" id="photoPreview"></div>
                <div id="expressionLabel"></div>
            </section>

            <div id="loading">
                <div class="spinner"></div>
                <p>Menyimpan data kunjungan Anda...</p>
            </div>

            <button type="submit" class="btn btn-submit">Kirim Data Kunjungan</button>
        </form>
    </div>

    <script src="{{ asset('js/geolocation.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // ===== 1. ELEMENT SELECTORS & GLOBAL VARIABLES =====
            const elements = {
                video: document.getElementById('video'),
                canvas: document.getElementById('canvas'),
                cameraContainer: document.getElementById('cameraContainer'),
                startCameraBtn: document.getElementById('startCameraBtn'),
                retakePhotoBtn: document.getElementById('retakePhotoBtn'),
                photoPreview: document.getElementById('photoPreview'),
                expressionLabel: document.getElementById('expressionLabel'),
                visitorForm: document.getElementById('visitorForm'),
                alertContainer: document.getElementById('alert-container'),
                loadingIndicator: document.getElementById('loading'),
                submitBtn: document.querySelector('.btn-submit')
            };
            const ctx = elements.canvas.getContext('2d');

            let photoData = null;
            let stream = null;
            let detectionIntervalId = null;
            let isDetecting = false;
            let autoShotArmed = true;
            let happyFrames = 0;
            
            const config = {
                HAPPY_THRESHOLD: 0.85,
                HAPPY_HOLD_FRAMES: 4,
                DETECTION_INTERVAL: 300,
                FACE_API_MODELS_URL: '/models' // Ensure this path is correct in your public folder
            };

            const ekspresiID = {
                neutral: "Netral", happy: "Senang", sad: "Sedih", angry: "Marah",
                fearful: "Takut", disgusted: "Jijik", surprised: "Terkejut"
            };

            // ===== 2. UTILITY FUNCTIONS =====
            function showAlert(message, type = 'error') {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
                elements.alertContainer.innerHTML = `<div class="alert ${alertClass}">${message}</div>`;
                setTimeout(() => { elements.alertContainer.innerHTML = ''; }, 6000);
            }

            function triggerFlash() {
                const flash = document.createElement('div');
                flash.className = 'flash';
                elements.cameraContainer.appendChild(flash);
                setTimeout(() => flash.remove(), 500);
            }

            function stopCamera() {
                if (detectionIntervalId) {
                    clearInterval(detectionIntervalId);
                    detectionIntervalId = null;
                }
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    stream = null;
                }
                isDetecting = false;
            }

            async function takeSnapshotAndStop() {
                if (elements.video.readyState < 2) {
                    await new Promise(resolve => elements.video.addEventListener('loadeddata', resolve, { once: true }));
                }
                
                triggerFlash();
                elements.canvas.width = elements.video.videoWidth || 320;
                elements.canvas.height = elements.video.videoHeight || 240;
                ctx.drawImage(elements.video, 0, 0, elements.canvas.width, elements.canvas.height);
                photoData = elements.canvas.toDataURL('image/jpeg', 0.85);
                
                elements.photoPreview.innerHTML = `<img src="${photoData}" alt="Foto Kunjungan">`;
                elements.video.style.display = 'none';
                elements.retakePhotoBtn.style.display = 'inline-block';
                
                stopCamera();
            }
            
            function toggleLoading(isLoading) {
                elements.loadingIndicator.style.display = isLoading ? 'block' : 'none';
                elements.submitBtn.disabled = isLoading;
                elements.submitBtn.textContent = isLoading ? 'Menyimpan...' : 'Kirim Data Kunjungan';
            }

            function resetFormState() {
                elements.visitorForm.reset();
                photoData = null;
                elements.photoPreview.innerHTML = '';
                elements.expressionLabel.textContent = '';
                elements.startCameraBtn.style.display = 'inline-block';
                elements.retakePhotoBtn.style.display = 'none';
                elements.video.style.display = 'block';
            }

            // ===== 3. FACE DETECTION LOGIC =====
            async function runDetectionTick() {
                if (isDetecting || !elements.video.srcObject) return;
                isDetecting = true;

                try {
                    const detection = await faceapi
                        .detectSingleFace(elements.video, new faceapi.TinyFaceDetectorOptions({ inputSize: 416, scoreThreshold: 0.4 }))
                        .withFaceExpressions();

                    let label = 'Arahkan wajah ke kamera...';
                    if (detection?.expressions) {
                        const expressions = detection.expressions;
                        const bestExpression = Object.keys(expressions).reduce((a, b) => expressions[a] > expressions[b] ? a : b);
                        label = `Ekspresi: ${ekspresiID[bestExpression] || bestExpression} (${(expressions[bestExpression] * 100).toFixed(0)}%)`;

                        if (autoShotArmed && expressions.happy >= config.HAPPY_THRESHOLD) {
                            happyFrames++;
                            if (happyFrames >= config.HAPPY_HOLD_FRAMES) {
                                autoShotArmed = false;
                                elements.expressionLabel.textContent = `Foto berhasil diambil! 😊`;
                                await takeSnapshotAndStop();
                                return; // Stop detection after successful snapshot
                            }
                        } else {
                            happyFrames = 0;
                        }
                    } else {
                        happyFrames = 0;
                    }
                    elements.expressionLabel.textContent = label;
                } catch (err) {
                    // console.warn("Face detection tick error:", err); // Optional: for debugging
                } finally {
                    isDetecting = false;
                }
            }

            // ===== 4. EVENT LISTENERS & INITIALIZATION =====
            elements.startCameraBtn.addEventListener('click', async function() {
                stopCamera();
                elements.video.style.display = 'block';
                elements.photoPreview.innerHTML = '';
                this.style.display = 'none';

                try {
                    if (!navigator.mediaDevices?.getUserMedia) {
                        throw new Error('Browser tidak mendukung akses kamera.');
                    }
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: 'user', width: { ideal: 640 }, height: { ideal: 480 } },
                        audio: false
                    });
                    elements.video.srcObject = stream;
                    await elements.video.play();
                    
                    autoShotArmed = true;
                    happyFrames = 0;
                    
                    detectionIntervalId = setInterval(runDetectionTick, config.DETECTION_INTERVAL);
                } catch (err) {
                    console.error('getUserMedia error:', err);
                    showAlert('Tidak dapat mengakses kamera. Pastikan izin kamera telah diaktifkan.', 'error');
                    this.style.display = 'inline-block';
                }
            });

            elements.retakePhotoBtn.addEventListener('click', function() {
                this.style.display = 'none';
                elements.startCameraBtn.click();
            });

            elements.visitorForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                if (!photoData) {
                    showAlert('Mohon ambil foto terlebih dahulu dengan tersenyum ke kamera.', 'error');
                    return;
                }
                stopCamera();
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
                        throw new Error(result.message || `HTTP error! Status: ${response.status}`);
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

            async function initFaceApi() {
                try {
                    await Promise.all([
                        faceapi.nets.tinyFaceDetector.loadFromUri(config.FACE_API_MODELS_URL),
                        faceapi.nets.faceLandmark68Net.loadFromUri(config.FACE_API_MODELS_URL),
                        faceapi.nets.faceExpressionNet.loadFromUri(config.FACE_API_MODELS_URL)
                    ]);
                    elements.startCameraBtn.disabled = false;
                    elements.startCameraBtn.textContent = 'Aktifkan Kamera';
                } catch (err) {
                    console.error('Gagal memuat model face-api:', err);
                    showAlert('Gagal memuat fitur kamera. Silakan muat ulang halaman.', 'error');
                }
            }
            
            // Initial setup
            elements.startCameraBtn.disabled = true;
            elements.startCameraBtn.textContent = 'Memuat model...';
            initFaceApi();
            
            window.addEventListener('beforeunload', stopCamera);
        });
    </script>
</body>
</html>
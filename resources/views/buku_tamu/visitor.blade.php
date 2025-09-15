<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buku Tamu DISKOMINFO</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  /* background: url("{{ asset('images/Kabupaten-Madiun.jpg') }}") no-repeat center center fixed; */
  background-size: cover;
  min-height: 100vh;
  margin: 0;

  display: flex;              /* aktifkan flexbox */
  justify-content: center;    /* center horizontal */
  align-items: center;        /* center vertical */
  padding: 20px;              /* jaga jarak biar di HP gak nempel pinggir */
}

.container {
  background: white;
  border-radius: 20px;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
  border: 3px solid #e1e5e9;
  padding: 40px;
  max-width: 600px;
  width: 100%;
  animation: slideUp 0.6s ease-out;
}


    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .header {
      text-align: center;
      margin-bottom: 30px;
    }

.header h1 {
  font-size: 2.3rem;
  margin-bottom: 10px;
  font-weight: 700;
  background: linear-gradient(135deg, #1c76cf, #769feb);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

    .header p {
      color: #666;
      font-size: 1.1rem;
    }

    .brand {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      margin-bottom: 14px;
    }

    .brand-logo {
      height: 64px;
      width: auto;
      object-fit: contain;
      image-rendering: -webkit-optimize-contrast;
    }

    .brand-name {
      font-size: 1.1rem;
      font-weight: 700;
      color: #2b3a67;
      letter-spacing: .3px;
    }

    @media (max-width: 768px) {
      .brand-logo { height: 52px; }
      .brand-name { font-size: 1rem; }
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: #333;
      font-weight: 600;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 12px 16px;
      border: 2px solid #e1e5e9;
      border-radius: 10px;
      font-size: 16px;
      transition: all 0.3s ease;
      background: #f8f9fa;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      outline: none;
      border-color: #bec1ce;
      background: white;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .camera-section {
      margin: 30px 0;
      text-align: center;
    }

    .camera-container {
      position: relative;
      display: inline-block;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    #video {
      width: 300px;
      height: 225px;
      object-fit: cover;
    }

    #canvas {
      display: none;
    }

    .camera-controls {
      margin-top: 20px;
    }

    .btn {
      background: linear-gradient(135deg, #42a5f5, #1e88e5);
      color: white;
      border: none;
      padding: 12px 24px;
      border-radius: 25px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin: 5px;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .btn:active {
      transform: translateY(0);
    }

    .btn-secondary {
      background: linear-gradient(135deg, #4facfe, #00f2fe);
    }

    .btn-success {
      background: linear-gradient(135deg, #4facfe, #00f2fe);
    }

    .photo-preview {
      margin-top: 20px;
      text-align: center;
    }

    .photo-preview img {
      max-width: 200px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .purpose-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 15px;
      margin-top: 10px;
    }

    .purpose-option {
      position: relative;
    }

    .purpose-option input[type="radio"] {
      display: none;
    }

    .purpose-option label {
      display: block;
      padding: 15px;
      background: #f8f9fa;
      border: 2px solid #e1e5e9;
      border-radius: 10px;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s ease;
      font-weight: 600;
    }
.purpose-option input[type="radio"]:checked + label {
  background: linear-gradient(135deg, #42a5f5, #1e88e5);
  color: white;
  border-color: #1e88e5;
  transform: scale(1.05);
}


    .submit-btn {
      width: 100%;
      background: linear-gradient(135deg, #42a5f5, #1e88e5);
      color: white;
      border: none;
      padding: 16px;
      border-radius: 15px;
      font-size: 18px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 20px;
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
    }

    .submit-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }

    .submit-btn:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
    }

    .alert {
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 20px;
      font-weight: 600;
    }

    .alert-success {
      background: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .alert-error {
      background: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }
    
    .alert-warning {
      background: #fff3cd;
      color: #856404;
      border: 1px solid #ffeeba;
    }

    #location-status {
      margin-bottom: 20px;
    }

    .loading {
      display: none;
      text-align: center;
      margin: 20px 0;
    }

    .spinner {
      border: 3px solid #f3f3f3;
      border-top: 3px solid #667eea;
      border-radius: 50%;
      width: 30px;
      height: 30px;
      animation: spin 1s linear infinite;
      margin: 0 auto;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    @media (max-width: 768px) {
      .container {
        padding: 20px;
        margin: 10px;
      }

      .header h1 {
        font-size: 2rem;
      }

      #video {
        width: 250px;
        height: 188px;
      }

      .purpose-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Header -->
    <div class="header">
      <div class="brand">
        <img class="brand-logo"
             src="{{ asset('images/logo-diskominfo.png') }}"
             alt="Diskominfo Kabupaten Madiun"
             loading="eager" decoding="async"
             onerror="this.style.display='none'">
      </div>
      <h1>Buku Tamu</h1>
      <p>Terima kasih telah berkunjung. Silakan isi data kunjungan Anda.</p>
    </div>

    <div id="alert-container"></div>

    <!-- Location Status -->
    <div id="location-status">
      <div class="alert alert-warning">Memeriksa lokasi Anda...</div>
    </div>

    <!-- Form -->
    <form id="visitorForm">
      <!-- Hidden fields for location data -->
      <input type="hidden" id="latitude" name="latitude">
      <input type="hidden" id="longitude" name="longitude">

      <div class="form-group">
        <label for="name">Nama Lengkap</label>
        <input type="text" id="name" name="name" required>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email">
      </div>

      <div class="form-group">
        <label for="phone">Nomor Telepon</label>
        <input type="tel" id="phone" name="phone">
      </div>

      <div class="form-group">
        <label for="asal_daerah">Asal Daerah</label>
        <input type="text" id="asal_daerah" name="asal_daerah" placeholder="Contoh: Madiun, Surabaya, Jakarta">
      </div>

      <div class="form-group">
  <label>Tujuan Kunjungan</label>
  <div class="purpose-grid">
    <div class="purpose-option">
      <input type="radio" id="sekretariat" name="purpose" value="sekretariat" required>
      <label for="sekretariat">Sekretariat</label>
    </div>

    <div class="purpose-option">
      <input type="radio" id="aplikasi_informatika" name="purpose" value="aplikasi_informatika" required>
      <label for="aplikasi_informatika">Aplikasi Informatika</label>
    </div>

    <div class="purpose-option">
      <input type="radio" id="persandian_keamanan_informasi" name="purpose" value="persandian_keamanan_informasi" required>
      <label for="persandian_keamanan_informasi">Persandian &amp; Keamanan Informasi</label>
    </div>

    <div class="purpose-option">
      <input type="radio" id="informasi_komunikasi_publik" name="purpose" value="informasi_komunikasi_publik" required>
      <label for="informasi_komunikasi_publik">Informasi dan Komunikasi Publik</label>
    </div>

    <div class="purpose-option">
      <input type="radio" id="statistik" name="purpose" value="statistik" required>
      <label for="statistik">Statistik</label>
    </div>
  </div>
</div>


      <div class="form-group">
        <label for="notes">Keperluan Kunjungan</label>
        <textarea id="notes" name="notes" rows="3" placeholder="Jelaskan keperluan kunjungan Anda..."></textarea>
      </div>

      <!-- Camera Section -->
      <div class="camera-section">
        <h3>Foto</h3>
        <p style="color: #666; margin-bottom: 15px;">Ambil foto untuk keperluan dokumentasi</p>

        <div class="camera-container">
          <video id="video" autoplay></video>
          <canvas id="canvas"></canvas>
        </div>

        <div class="camera-controls">
          <button type="button" id="startCamera" class="btn">Aktifkan Kamera</button>
          <button type="button" id="capturePhoto" class="btn btn-secondary" style="display: none;">Ambil Foto</button>
          <button type="button" id="retakePhoto" class="btn btn-success" style="display: none;">Foto Ulang</button>
        </div>

        <div class="photo-preview" id="photoPreview"></div>
      </div>

      <!-- Loading -->
      <div class="loading" id="loading">
        <div class="spinner"></div>
        <p>Menyimpan data...</p>
      </div>

      <button type="submit" class="submit-btn">Daftar Kunjungan</button>
    </form>
  </div>

  <script src="{{ asset('js/geolocation.js') }}"></script>
  <script>
    let video = document.getElementById('video');
    let canvas = document.getElementById('canvas');
    let ctx = canvas.getContext('2d');
    let photoData = null;
    let stream = null;

    // Camera controls
    document.getElementById('startCamera').addEventListener('click', async function() {
      try {
        stream = await navigator.mediaDevices.getUserMedia({
          video: { width: 300, height: 225, facingMode: 'user' }
        });
        video.srcObject = stream;

        this.style.display = 'none';
        document.getElementById('capturePhoto').style.display = 'inline-block';
      } catch (err) {
        showAlert('Tidak dapat mengakses kamera. Pastikan browser memiliki izin kamera.', 'error');
      }
    });

    document.getElementById('capturePhoto').addEventListener('click', function() {
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      ctx.drawImage(video, 0, 0);

      photoData = canvas.toDataURL('image/jpeg', 0.8);

      // Show preview
      const preview = document.getElementById('photoPreview');
      preview.innerHTML = `<img src="${photoData}" alt="Foto Selfie">`;

      // Stop camera
      if (stream) {
        stream.getTracks().forEach(track => track.stop());
      }
      video.style.display = 'none';

      // Show retake button
      this.style.display = 'none';
      document.getElementById('retakePhoto').style.display = 'inline-block';
    });

    document.getElementById('retakePhoto').addEventListener('click', function() {
      photoData = null;
      document.getElementById('photoPreview').innerHTML = '';
      video.style.display = 'block';

      this.style.display = 'none';
      document.getElementById('startCamera').style.display = 'inline-block';
    });

    // Form submission
    document.getElementById('visitorForm').addEventListener('submit', async function(e) {
      e.preventDefault();

      const formData = new FormData(this);
      const data = {
        name: formData.get('name'),
        email: formData.get('email'),
        phone: formData.get('phone'),
        asal_daerah: formData.get('asal_daerah'),
        purpose: formData.get('purpose'),
        notes: formData.get('notes'),
        photo: photoData,
        latitude: formData.get('latitude'),
        longitude: formData.get('longitude')
      };

      // Show loading
      document.getElementById('loading').style.display = 'block';
      document.querySelector('.submit-btn').disabled = true;

      try {
        const response = await fetch('/api/visitors', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
          showAlert('Terima kasih! Data kunjungan Anda telah berhasil disimpan.', 'success');
          this.reset();
          photoData = null;
          document.getElementById('photoPreview').innerHTML = '';
          document.getElementById('startCamera').style.display = 'inline-block';
          document.getElementById('capturePhoto').style.display = 'none';
          document.getElementById('retakePhoto').style.display = 'none';
          video.style.display = 'block';
        } else {
          showAlert('❌ Terjadi kesalahan: ' + (result.message || 'Silakan coba lagi'), 'error');
        }
      } catch (error) {
        showAlert('❌ Terjadi kesalahan koneksi. Silakan coba lagi.', 'error');
      } finally {
        document.getElementById('loading').style.display = 'none';
        document.querySelector('.submit-btn').disabled = false;
      }
    });

    function showAlert(message, type) {
      const alertContainer = document.getElementById('alert-container');
      const alertClass = type === 'success' ? 'alert-success' : 'alert-error';

      alertContainer.innerHTML = `<div class="alert ${alertClass}">${message}</div>`;

      // Auto hide after 5 seconds
      setTimeout(() => {
        alertContainer.innerHTML = '';
      }, 5000);
    }

    // Default show video
    video.style.display = 'block';
  </script>
</body>
</html>

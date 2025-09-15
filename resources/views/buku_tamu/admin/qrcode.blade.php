<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code - Buku Tamu Digital</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg,white);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .qr-container {
            background: white;
            border: 4px solid #e1e5e9;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        .header {
            margin-bottom: 30px;
        }

        .logo {
            height: 60px;
            width: auto;
            margin-bottom: 20px;
        }

        .header h1 {
            color: #333;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 1.1rem;
        }

        .qr-code-wrapper {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
            border: 3px dashed #667eea;
        }

        .qr-code {
            width: 100%;
            max-width: 300px;
            height: auto;
        }

        .buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
        }

        .btn-upload {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
        }

        .btn-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.6);
        }

        @media (max-width: 768px) {
            .qr-container {
                padding: 30px 20px;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        .loading {
            display: none;
            color: #667eea;
            font-size: 1.1rem;
            margin: 20px 0;
        }

        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Sembunyikan input file asli */
        #fileInput {
            display: none;
        }
    </style>
</head>
<body>
    <div class="qr-container">
        <div class="header">
            <img src="/images/logo-diskominfo.png" alt="Logo Diskominfo" class="logo">
            <h1>QR Code Buku Tamu</h1>
            <p>Scan untuk akses cepat ke form registrasi</p>
        </div>

        <div class="qr-code-wrapper">
            <div class="loading" id="qrLoading">
                <div class="spinner"></div>
                Memuat QR Code...
            </div>
            <img src="" alt="Masukan Foto QR Code" class="qr-code" id="qrImage" onload="hideLoading()">
        </div>

<!-- Tombol Upload & Download & Print -->
<div class="buttons">
    <label for="fileInput" class="btn btn-upload">Pilih Foto</label>
    <a href="#" id="printBtn" class="btn btn-primary">Print QR Code</a>
    <a href="#" id="downloadBtn" class="btn btn-secondary">Download QR Code</a>
</div>

   

        <!-- Input file tersembunyi -->
        <input type="file" id="fileInput" accept="image/*">

        <!-- Tombol dashboard di bawah -->
        <div class="buttons" style="margin-top: 25px;">
            <a href="/buku-tamu/admin/dashboard" class="btn btn-primary">
                Kembali ke Dashboard
            </a>
        </div>
    </div>

<script>
  function hideLoading() {
    document.getElementById('qrLoading').style.display = 'none';
  }

  // Ganti gambar kalau user upload
  // Ganti gambar kalau user upload
document.getElementById('fileInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('qrImage').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Download QR Code
document.getElementById('downloadBtn').addEventListener('click', function(e) {
    e.preventDefault();
    const qrImage = document.getElementById('qrImage');
    if (!qrImage.src) return alert("Silakan pilih QR Code terlebih dahulu!");
    const link = document.createElement('a');
    link.href = qrImage.src;
    link.download = "qr-code.png";
    link.click();
});

// Print QR Code
document.getElementById('printBtn').addEventListener('click', function(e) {
    e.preventDefault();
    const qrImage = document.getElementById('qrImage');
    if (!qrImage.src) return alert("Silakan pilih QR Code terlebih dahulu!");

    const printWindow = window.open('', '_blank');
    if (!printWindow) return alert("Popup diblokir. Izinkan popup untuk mencetak QR Code.");

    printWindow.document.write(`
        <html>
        <head>
            <title>Print QR Code</title>
            <style>
                body {
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    height:100vh;
                    margin:0;
                }
                img {
                    max-width:100%;
                    height:auto;
                }
            </style>
        </head>
        <body>
            <img id="printQr" src="${qrImage.src}" />
        </body>
        </html>
    `);

    printWindow.document.close();

    // Tunggu gambar load sepenuhnya sebelum print
    const printImg = printWindow.document.getElementById('printQr');
    printImg.onload = function() {
        setTimeout(() => {  // beri delay kecil agar browser sempat render
            printWindow.focus();
            printWindow.print();
        }, 200);
    };
});


</script>
</body>
</html>

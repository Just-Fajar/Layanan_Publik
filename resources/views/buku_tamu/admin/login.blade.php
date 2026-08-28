<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Buku Tamu Digital</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-buku.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-buku.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* =============================================
         * 1. VARIABLES & RESET
         * ============================================= */
        :root {
            --primary-color: #3B82F6;
            --primary-hover: #2563EB;
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

        /* =============================================
         * 2. LAYOUT & TYPOGRAPHY
         * ============================================= */
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            font-family: var(--font-family);
            background-color: var(--background-color);
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 48px;
            background: var(--surface-color);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, .1);
            animation: fadeIn .7s ease-out;
        }

        .header {
            text-align: center;
            margin-bottom: 32px;
        }

        .brand-logo {
            height: 64px;
            margin-bottom: 16px;
        }

        .header h1 {
            margin-bottom: 8px;
            color: var(--text-primary);
            font-size: 2rem;
            font-weight: 700;
        }

        .header p {
            color: var(--text-secondary);
            font-size: 1rem;
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
            font-size: .95rem;
            font-weight: 600;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper .icon {
            position: absolute;
            top: 50%;
            left: 16px;
            width: 20px;
            height: 20px;
            color: var(--text-secondary);
            pointer-events: none;
            transform: translateY(-50%);
        }

        .form-control {
            width: 100%;
            padding: 14px 18px 14px 48px;
            font-family: var(--font-family);
            font-size: 1rem;
            background: #F9FAFB;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            transition: all .3s ease;
        }

        .form-control:focus {
            outline: none;
            background: var(--surface-color);
            border-color: var(--border-focus);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, .15);
        }

        .form-control:focus+.icon {
            color: var(--primary-color);
        }

        /* =============================================
         * 4. BUTTONS & LINKS
         * ============================================= */
        .login-btn {
            width: 100%;
            margin-top: 10px;
            padding: 16px;
            color: #fff;
            font-size: 1.1rem;
            font-weight: 600;
            background: var(--primary-color);
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(59, 130, 246, .2);
            cursor: pointer;
            transition: all .3s ease;
        }

        .login-btn:hover {
            background: var(--primary-hover);
            box-shadow: 0 8px 25px rgba(59, 130, 246, .3);
            transform: translateY(-3px);
        }

        .login-btn:disabled {
            opacity: .6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .back-link {
            margin-top: 32px;
            text-align: center;
        }

        .back-link a {
            color: var(--primary-color);
            font-weight: 500;
            text-decoration: none;
            transition: color .3s ease;
        }

        .back-link a:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        /* =============================================
         * 5. ALERTS & LOADERS
         * ============================================= */
        .alert {
            padding: 16px;
            margin-bottom: 24px;
            font-weight: 500;
            border: 1px solid transparent;
            border-radius: 12px;
            animation: fadeIn .3s;
        }

        .alert-success { background: #D1FAE5; color: #065F46; border-color: #A7F3D0; }
        .alert-error { background: #FEE2E2; color: #991B1B; border-color: #FECACA; }

        .loading {
            display: none;
            margin-top: 16px;
            color: var(--text-secondary);
            text-align: center;
        }

        .spinner {
            width: 24px;
            height: 24px;
            margin: 0 auto 8px auto;
            border: 3px solid #E5E7EB;
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* =============================================
         * 6. ANIMATIONS & RESPONSIVE
         * ============================================= */
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(.95) }
            to { opacity: 1; transform: scale(1) }
        }

        @keyframes spin {
            from { transform: rotate(0deg) }
            to { transform: rotate(360deg) }
        }

        @media (max-width: 480px) {
            .login-container { padding: 24px; }
            .header h1 { font-size: 1.8rem; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <header class="header">
            <img class="brand-logo" src="{{ asset('images/logo-diskominfo.png') }}" alt="Logo Instansi" loading="lazy">
            <h1>Admin Panel</h1>
            <p>Silakan masuk untuk mengelola buku tamu.</p>
        </header>

        <div id="alert-container"></div>

        <form id="loginForm" method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrapper">
                    <input type="text" id="username" name="username" class="form-control" required placeholder="Masukkan username" autocomplete="username">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" class="form-control" required placeholder="Masukkan password" autocomplete="current-password">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
            </div>

            <div class="loading" id="loading">
                <div class="spinner"></div>
                <p>Memverifikasi...</p>
            </div>

            <button type="submit" class="login-btn">Masuk</button>
        </form>

        <div class="back-link">
            <a href="/">← Kembali ke Homepage</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Element Selectors ---
            const elements = {
                loginForm: document.getElementById('loginForm'),
                loadingIndicator: document.getElementById('loading'),
                submitBtn: document.querySelector('.login-btn'),
                alertContainer: document.getElementById('alert-container'),
                csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            };

            // --- Utility Functions ---
            const showAlert = (message, type = 'error') => {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
                elements.alertContainer.innerHTML = `<div class="alert ${alertClass}">${message}</div>`;
                setTimeout(() => {
                    elements.alertContainer.innerHTML = '';
                }, 5000);
            };

            const toggleLoading = (isLoading) => {
                elements.loadingIndicator.style.display = isLoading ? 'block' : 'none';
                elements.submitBtn.disabled = isLoading;
            };

            // --- Event Listener ---
            elements.loginForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                toggleLoading(true);

                const formData = new FormData(this);
                const payload = Object.fromEntries(formData.entries());

                try {
                    const response = await fetch('{{ route("admin.login.submit") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': elements.csrfToken,
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify(payload)
                    });

                    const result = await response.json();

                    if (response.ok && result.success) {
                        if (result.data?.admin) {
                            localStorage.setItem('admin_data', JSON.stringify(result.data.admin));
                        }
                        showAlert('Login berhasil! Mengarahkan ke dashboard...', 'success');
                        setTimeout(() => {
                            window.location.href = result.data?.redirect || '{{ route("admin.dashboard") }}';
                        }, 1000);
                    } else {
                        showAlert(result.message || 'Username atau password salah.', 'error');
                        toggleLoading(false);
                    }
                } catch (error) {
                    console.error('Login Error:', error);
                    showAlert('Terjadi kesalahan koneksi. Silakan coba lagi.', 'error');
                    toggleLoading(false);
                }
            });
        });
    </script>
</body>
</html>
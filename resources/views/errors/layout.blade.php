<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title') - Diskominfo Kabupaten Madiun</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-diskominfo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-diskominfo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --bg-dark: #070c18;
            --bg-card: rgba(15, 23, 42, 0.75);
            --border-card: rgba(255, 255, 255, 0.1);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --brand-primary: #0284c7;
            --brand-hover: #0369a1;
            --brand-cyan: #38bdf8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient Glow Backgrounds */
        .ambient-glow-top {
            position: absolute;
            top: -150px;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 450px;
            background: radial-gradient(circle, rgba(2, 132, 199, 0.22) 0%, rgba(2, 132, 199, 0) 70%);
            filter: blur(60px);
            pointer-events: none;
            z-index: 0;
        }

        .ambient-glow-bottom {
            position: absolute;
            bottom: -150px;
            right: 10%;
            width: 500px;
            height: 400px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.16) 0%, rgba(99, 102, 241, 0) 70%);
            filter: blur(70px);
            pointer-events: none;
            z-index: 0;
        }

        /* Header */
        .error-header {
            position: relative;
            z-index: 10;
            padding: 28px 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-link {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text-main);
            transition: opacity 0.2s ease;
        }

        .brand-link:hover {
            opacity: 0.9;
        }

        .brand-logo {
            height: 42px;
            width: auto;
        }

        /* Main Container */
        .error-main {
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            flex-grow: 1;
        }

        .error-card {
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-card);
            border-radius: 28px;
            padding: 48px 40px;
            max-width: 560px;
            width: 100%;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 40px rgba(2, 132, 199, 0.08);
            animation: cardAppear 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes cardAppear {
            from {
                opacity: 0;
                transform: translateY(24px) scale(0.97);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Error Badge & Code */
        .error-visual-wrapper {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
        }

        .error-code-badge {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 5rem;
            font-weight: 900;
            line-height: 1;
            letter-spacing: -0.04em;
            background: linear-gradient(135deg, #ffffff 30%, var(--brand-cyan) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: floatText 4s ease-in-out infinite;
        }

        @keyframes floatText {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }

        .error-icon-box {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 16px;
            background: rgba(2, 132, 199, 0.15);
            border: 1px solid rgba(56, 189, 248, 0.3);
            color: var(--brand-cyan);
            box-shadow: 0 8px 20px rgba(2, 132, 199, 0.2);
            animation: pulseGlow 3s ease-in-out infinite;
        }

        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 8px 20px rgba(2, 132, 199, 0.2); }
            50% { box-shadow: 0 12px 28px rgba(56, 189, 248, 0.4); }
        }

        /* Typography */
        .error-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.65rem;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1.3;
            margin-bottom: 14px;
            letter-spacing: -0.01em;
        }

        .error-desc {
            font-size: 0.95rem;
            line-height: 1.65;
            color: var(--text-muted);
            margin-bottom: 32px;
        }

        /* Action Buttons */
        .error-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
        }

        .btn-action-primary {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.92rem;
            font-weight: 700;
            color: #ffffff;
            background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-hover) 100%);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 12px 24px;
            border-radius: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 10px 20px -5px rgba(2, 132, 199, 0.4);
            cursor: pointer;
        }

        .btn-action-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 26px -5px rgba(2, 132, 199, 0.5);
            background: linear-gradient(135deg, #0369a1 0%, #075985 100%);
        }

        .btn-action-secondary {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.92rem;
            font-weight: 600;
            color: #cbd5e1;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid var(--border-card);
            padding: 12px 20px;
            border-radius: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .btn-action-secondary:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.25);
        }

        /* Footer */
        .error-footer {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 20px;
            font-size: 0.82rem;
            color: #64748b;
        }

        @media (max-width: 575.98px) {
            .error-card {
                padding: 36px 24px;
            }
            .error-code-badge {
                font-size: 4rem;
            }
            .error-title {
                font-size: 1.35rem;
            }
            .btn-action-primary,
            .btn-action-secondary {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <div class="ambient-glow-top"></div>
    <div class="ambient-glow-bottom"></div>

    <!-- Top Header -->
    <header class="error-header">
        <a href="{{ route('homepage') }}" class="brand-link" aria-label="Portal Utama Diskominfo Kabupaten Madiun">
            <img src="{{ asset('images/logo-diskominfo.png') }}" alt="Logo Diskominfo" class="brand-logo" width="160" height="42">
        </a>
    </header>

    <!-- Main Error Content -->
    <main class="error-main">
        <div class="error-card">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="error-footer">
        &copy; {{ date('Y') }} Dinas Komunikasi dan Informatika Pemerintah Kabupaten Madiun.
    </footer>

</body>
</html>

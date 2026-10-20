<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SplitTrip') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; }

            body {
                background: #F4F3FF;
                margin: 0;
                padding: 0;
                min-height: 100vh;
            }

            /* ── NAVBAR ── */
            .app-navbar {
                background: #fff;
                border-bottom: 1px solid #EDE9FE;
                position: sticky;
                top: 0;
                z-index: 50;
                box-shadow: 0 1px 3px rgba(124,58,237,0.06);
            }

            .navbar-inner {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 24px;
                height: 64px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .navbar-logo {
                display: flex;
                align-items: center;
                gap: 10px;
                text-decoration: none;
            }

            .logo-mark {
                width: 36px;
                height: 36px;
                background: linear-gradient(135deg, #7C3AED, #4F46E5);
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 3px 10px rgba(124,58,237,0.35);
                flex-shrink: 0;
            }

            .logo-text {
                font-size: 17px;
                font-weight: 800;
                color: #1F1147;
                letter-spacing: -0.3px;
            }

            .navbar-links {
                display: flex;
                align-items: center;
                gap: 4px;
            }

            .nav-link {
                padding: 8px 14px;
                border-radius: 8px;
                font-size: 14px;
                font-weight: 500;
                color: #6B7280;
                text-decoration: none;
                transition: all 0.15s ease;
            }

            .nav-link:hover { background: #F5F3FF; color: #7C3AED; }
            .nav-link.active { background: #EDE9FE; color: #7C3AED; font-weight: 600; }

            .navbar-right {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .user-chip {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 6px 12px 6px 6px;
                border-radius: 50px;
                border: 1px solid #EDE9FE;
                cursor: pointer;
                background: #fff;
                transition: all 0.15s;
                position: relative;
            }
            .user-chip:hover { background: #F5F3FF; border-color: #C4B5FD; }

            .user-avatar {
                width: 30px;
                height: 30px;
                border-radius: 50%;
                background: linear-gradient(135deg, #7C3AED, #4F46E5);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-weight: 700;
                font-size: 12px;
            }

            .user-name {
                font-size: 13px;
                font-weight: 600;
                color: #374151;
            }

            .dropdown-menu {
                position: absolute;
                top: calc(100% + 8px);
                right: 0;
                background: white;
                border: 1px solid #EDE9FE;
                border-radius: 12px;
                box-shadow: 0 10px 40px rgba(124,58,237,0.12);
                min-width: 180px;
                overflow: hidden;
                display: none;
                z-index: 100;
            }

            .dropdown-menu.show { display: block; animation: dropIn 0.15s ease; }

            @keyframes dropIn {
                from { opacity: 0; transform: translateY(-6px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .dropdown-item {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 10px 16px;
                font-size: 13px;
                color: #374151;
                text-decoration: none;
                transition: background 0.1s;
                cursor: pointer;
                border: none;
                background: none;
                width: 100%;
                text-align: left;
                font-family: 'Plus Jakarta Sans', sans-serif;
                font-weight: 500;
            }
            .dropdown-item:hover { background: #F5F3FF; color: #7C3AED; }
            .dropdown-item.danger:hover { background: #FEF2F2; color: #EF4444; }
            .dropdown-divider { height: 1px; background: #F3F4F6; margin: 4px 0; }

            /* ── PAGE CONTENT ── */
            .page-content {
                max-width: 1200px;
                margin: 0 auto;
                padding: 32px 24px;
            }

            /* ── CARDS ── */
            .card {
                background: white;
                border-radius: 16px;
                border: 1px solid #EDE9FE;
                box-shadow: 0 2px 8px rgba(124,58,237,0.06);
            }

            /* ── BUTTONS ── */
            .btn-primary {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 10px 20px;
                background: linear-gradient(135deg, #7C3AED, #4F46E5);
                color: white;
                border: none;
                border-radius: 10px;
                font-size: 14px;
                font-weight: 600;
                font-family: 'Plus Jakarta Sans', sans-serif;
                cursor: pointer;
                text-decoration: none;
                transition: all 0.2s ease;
                box-shadow: 0 4px 12px rgba(124,58,237,0.25);
                white-space: nowrap;
            }
            .btn-primary:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 20px rgba(124,58,237,0.35);
                color: white;
            }

            .btn-secondary {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 10px 20px;
                background: white;
                color: #374151;
                border: 1.5px solid #E5E7EB;
                border-radius: 10px;
                font-size: 14px;
                font-weight: 600;
                font-family: 'Plus Jakarta Sans', sans-serif;
                cursor: pointer;
                text-decoration: none;
                transition: all 0.2s ease;
                white-space: nowrap;
            }
            .btn-secondary:hover { border-color: #C4B5FD; color: #7C3AED; background: #F5F3FF; }

            .btn-danger {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 8px 14px;
                background: #FEF2F2;
                color: #DC2626;
                border: 1.5px solid #FEE2E2;
                border-radius: 8px;
                font-size: 13px;
                font-weight: 600;
                font-family: 'Plus Jakarta Sans', sans-serif;
                cursor: pointer;
                text-decoration: none;
                transition: all 0.15s;
            }
            .btn-danger:hover { background: #FEE2E2; border-color: #FECACA; }

            .btn-warning {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 8px 14px;
                background: #FFFBEB;
                color: #D97706;
                border: 1.5px solid #FDE68A;
                border-radius: 8px;
                font-size: 13px;
                font-weight: 600;
                font-family: 'Plus Jakarta Sans', sans-serif;
                cursor: pointer;
                text-decoration: none;
                transition: all 0.15s;
            }
            .btn-warning:hover { background: #FEF3C7; }

            /* ── FORM INPUTS ── */
            .form-input {
                width: 100%;
                padding: 11px 14px;
                border: 1.5px solid #E5E7EB;
                border-radius: 10px;
                font-size: 14px;
                font-family: 'Plus Jakarta Sans', sans-serif;
                color: #111827;
                background: #FAFAFA;
                transition: all 0.2s;
                outline: none;
            }
            .form-input:focus {
                border-color: #7C3AED;
                background: #fff;
                box-shadow: 0 0 0 3px rgba(124,58,237,0.1);
            }
            .form-input::placeholder { color: #9CA3AF; }

            .form-label {
                display: block;
                font-size: 13px;
                font-weight: 600;
                color: #374151;
                margin-bottom: 6px;
                letter-spacing: 0.2px;
            }

            /* ── BADGE ── */
            .badge {
                display: inline-flex;
                align-items: center;
                padding: 3px 10px;
                border-radius: 50px;
                font-size: 11px;
                font-weight: 600;
                letter-spacing: 0.3px;
            }
            .badge-purple { background: #EDE9FE; color: #7C3AED; }
            .badge-green { background: #ECFDF5; color: #059669; }
            .badge-blue { background: #EFF6FF; color: #2563EB; }
            .badge-orange { background: #FFF7ED; color: #D97706; }

            /* ── SUCCESS ALERT ── */
            .alert-success {
                background: #ECFDF5;
                border: 1px solid #A7F3D0;
                color: #065F46;
                padding: 12px 16px;
                border-radius: 10px;
                font-size: 14px;
                font-weight: 500;
                display: flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 20px;
            }

            .alert-error {
                background: #FEF2F2;
                border: 1px solid #FECACA;
                color: #991B1B;
                padding: 12px 16px;
                border-radius: 10px;
                font-size: 13px;
                margin-bottom: 20px;
            }

            /* Mobile hamburger */
            .mobile-menu { display: none; }
            @media (max-width: 640px) {
                .navbar-links { display: none; }
                .mobile-menu { display: flex; }
                .page-content { padding: 20px 16px; }
            }
        </style>
    </head>
    <body>
        <!-- NAVBAR -->
        <nav class="app-navbar">
            <div class="navbar-inner">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="navbar-logo">
                    <div class="logo-mark">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                            <path d="M2 17l10 5 10-5"/>
                            <path d="M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <span class="logo-text">SplitTrip</span>
                </a>

                <!-- Nav Links -->
                <div class="navbar-links">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('trips.index') }}" class="nav-link {{ request()->routeIs('trips.*') ? 'active' : '' }}">
                        My Trips
                    </a>
                </div>

                <!-- Right side -->
                <div class="navbar-right">
                    <div class="user-chip" onclick="toggleDropdown()" id="user-chip-btn">
                        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <svg width="12" height="12" fill="none" stroke="#9CA3AF" stroke-width="2.5" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>

                        <div class="dropdown-menu" id="user-dropdown">
                            <div style="padding: 12px 16px 8px; border-bottom: 1px solid #F3F4F6;">
                                <div style="font-weight: 700; font-size: 13px; color: #111827;">{{ Auth::user()->name }}</div>
                                <div style="font-size: 12px; color: #9CA3AF; margin-top: 2px;">{{ Auth::user()->email }}</div>
                            </div>
                            <div style="padding: 4px 0;">
                                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    Edit Profil
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item danger">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- PAGE CONTENT -->
        <main>
            {{ $slot }}
        </main>

        <script>
            function toggleDropdown() {
                const dd = document.getElementById('user-dropdown');
                dd.classList.toggle('show');
            }
            document.addEventListener('click', function(e) {
                const chip = document.getElementById('user-chip-btn');
                const dd = document.getElementById('user-dropdown');
                if (chip && !chip.contains(e.target)) {
                    dd.classList.remove('show');
                }
            });
        </script>
    </body>
</html>

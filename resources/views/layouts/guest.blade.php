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
            :root {
                --brand-primary: #7C3AED;
                --brand-secondary: #4F46E5;
                --brand-accent: #06B6D4;
            }

            * { font-family: 'Plus Jakarta Sans', sans-serif; }

            .auth-gradient-bg {
                background: linear-gradient(135deg, #0D0B1E 0%, #130F2E 40%, #1A0A3D 70%, #0F1733 100%);
                position: relative;
                overflow: hidden;
            }

            .orb-1 {
                position: absolute;
                width: 450px;
                height: 450px;
                background: radial-gradient(circle, rgba(124,58,237,0.25) 0%, transparent 70%);
                border-radius: 50%;
                top: -100px;
                left: -100px;
                animation: floatOrb 8s ease-in-out infinite;
            }

            .orb-2 {
                position: absolute;
                width: 350px;
                height: 350px;
                background: radial-gradient(circle, rgba(6,182,212,0.18) 0%, transparent 70%);
                border-radius: 50%;
                bottom: -80px;
                right: -80px;
                animation: floatOrb 10s ease-in-out infinite reverse;
            }

            .orb-3 {
                position: absolute;
                width: 200px;
                height: 200px;
                background: radial-gradient(circle, rgba(79,70,229,0.2) 0%, transparent 70%);
                border-radius: 50%;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                animation: pulse-slow 6s ease-in-out infinite;
            }

            @keyframes floatOrb {
                0%, 100% { transform: translateY(0px) scale(1); }
                50% { transform: translateY(-30px) scale(1.05); }
            }

            @keyframes pulse-slow {
                0%, 100% { opacity: 0.4; transform: translate(-50%, -50%) scale(1); }
                50% { opacity: 0.7; transform: translate(-50%, -50%) scale(1.15); }
            }

            .floating-card {
                background: rgba(255,255,255,0.03);
                border: 1px solid rgba(255,255,255,0.08);
                backdrop-filter: blur(12px);
                border-radius: 20px;
                padding: 20px;
                animation: float-card 5s ease-in-out infinite;
            }

            .floating-card:nth-child(2) { animation-delay: -2s; }
            .floating-card:nth-child(3) { animation-delay: -4s; }

            @keyframes float-card {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }

            .auth-form-panel {
                background: rgba(255,255,255,0.97);
            }

            .auth-input {
                width: 100%;
                padding: 12px 16px;
                border: 1.5px solid #E5E7EB;
                border-radius: 12px;
                font-size: 14px;
                font-family: 'Plus Jakarta Sans', sans-serif;
                transition: all 0.2s ease;
                background: #FAFAFA;
                color: #111827;
                outline: none;
            }

            .auth-input:focus {
                border-color: #7C3AED;
                background: #fff;
                box-shadow: 0 0 0 3px rgba(124,58,237,0.12);
            }

            .auth-input::placeholder { color: #9CA3AF; }

            .auth-btn {
                width: 100%;
                padding: 13px 24px;
                background: linear-gradient(135deg, #7C3AED 0%, #4F46E5 100%);
                color: white;
                border: none;
                border-radius: 12px;
                font-size: 15px;
                font-weight: 600;
                font-family: 'Plus Jakarta Sans', sans-serif;
                cursor: pointer;
                transition: all 0.25s ease;
                position: relative;
                overflow: hidden;
            }

            .auth-btn::before {
                content: '';
                position: absolute;
                top: 0; left: -100%;
                width: 100%; height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
                transition: left 0.5s ease;
            }

            .auth-btn:hover::before { left: 100%; }

            .auth-btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 8px 25px rgba(124,58,237,0.4);
            }

            .auth-btn:active { transform: translateY(0); }

            .input-wrapper {
                position: relative;
            }

            .input-icon {
                position: absolute;
                left: 14px;
                top: 50%;
                transform: translateY(-50%);
                color: #9CA3AF;
                pointer-events: none;
            }

            .input-with-icon {
                padding-left: 42px !important;
            }

            .brand-logo-mark {
                width: 44px;
                height: 44px;
                background: linear-gradient(135deg, #7C3AED, #4F46E5);
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 4px 15px rgba(124,58,237,0.4);
            }

            .divider-or {
                display: flex;
                align-items: center;
                gap: 12px;
                color: #9CA3AF;
                font-size: 13px;
                margin: 20px 0;
            }

            .divider-or::before, .divider-or::after {
                content: '';
                flex: 1;
                height: 1px;
                background: #E5E7EB;
            }

            .feature-badge {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                background: rgba(124,58,237,0.15);
                border: 1px solid rgba(124,58,237,0.3);
                color: rgba(255,255,255,0.9);
                padding: 8px 16px;
                border-radius: 50px;
                font-size: 13px;
                font-weight: 500;
                margin-bottom: 32px;
            }

            .stat-card {
                background: rgba(255,255,255,0.06);
                border: 1px solid rgba(255,255,255,0.1);
                border-radius: 16px;
                padding: 16px 20px;
                backdrop-filter: blur(8px);
            }

            .check-custom {
                width: 16px;
                height: 16px;
                accent-color: #7C3AED;
                cursor: pointer;
            }

            @media (max-width: 768px) {
                .left-panel { display: none; }
            }

            .error-msg {
                color: #EF4444;
                font-size: 12px;
                margin-top: 6px;
                display: flex;
                align-items: center;
                gap: 4px;
            }

            .session-status {
                background: rgba(16,185,129,0.1);
                border: 1px solid rgba(16,185,129,0.3);
                color: #059669;
                padding: 10px 14px;
                border-radius: 10px;
                font-size: 13px;
                margin-bottom: 16px;
            }
        </style>
    </head>
    <body style="margin:0; padding:0; background:#0D0B1E; min-height:100vh; display:flex;">

        <!-- Full-screen split layout -->
        <div style="display:flex; width:100%; min-height:100vh;">

            <!-- ===== LEFT PANEL — Brand/Hero ===== -->
            <div class="auth-gradient-bg left-panel" style="flex:1; display:flex; flex-direction:column; justify-content:space-between; padding:48px; min-height:100vh; position:relative;">
                <!-- Glowing orbs -->
                <div class="orb-1"></div>
                <div class="orb-2"></div>
                <div class="orb-3"></div>

                <!-- Grid lines overlay -->
                <div style="position:absolute;inset:0;background-image:linear-gradient(rgba(124,58,237,0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(124,58,237,0.05) 1px, transparent 1px);background-size:50px 50px;pointer-events:none;"></div>

                <!-- Logo -->
                <div style="position:relative;z-index:10;">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div class="brand-logo-mark">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                                <path d="M2 17l10 5 10-5"/>
                                <path d="M2 12l10 5 10-5"/>
                            </svg>
                        </div>
                        <span style="color:white;font-weight:700;font-size:18px;letter-spacing:-0.3px;">SplitTrip</span>
                    </div>
                </div>

                <!-- Hero text -->
                <div style="position:relative;z-index:10;">
                    <div class="feature-badge">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Untuk para travelers Indonesia
                    </div>

                    <h1 style="color:white;font-size:clamp(32px,4vw,52px);font-weight:800;line-height:1.15;letter-spacing:-1.5px;margin:0 0 20px;">
                        Split setiap<br>
                        <span style="background:linear-gradient(90deg,#A78BFA,#06B6D4);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">petualangan</span><br>
                        dengan adil.
                    </h1>

                    <p style="color:rgba(255,255,255,0.55);font-size:16px;line-height:1.7;margin:0 0 48px;max-width:400px;">
                        Catat pengeluaran trip bareng teman, hitung tanggungan masing-masing secara otomatis, tanpa drama hitung manual.
                    </p>

                    <!-- Stats row -->
                    <div style="display:flex;gap:16px;flex-wrap:wrap;">
                        <div class="stat-card" style="flex:1;min-width:140px;">
                            <div style="color:#A78BFA;font-size:28px;font-weight:800;letter-spacing:-0.5px;">Multi</div>
                            <div style="color:rgba(255,255,255,0.5);font-size:13px;margin-top:2px;">Payer per expense</div>
                        </div>
                        <div class="stat-card" style="flex:1;min-width:140px;">
                            <div style="color:#06B6D4;font-size:28px;font-weight:800;letter-spacing:-0.5px;">3 cara</div>
                            <div style="color:rgba(255,255,255,0.5);font-size:13px;margin-top:2px;">Split otomatis</div>
                        </div>
                        <div class="stat-card" style="flex:1;min-width:140px;">
                            <div style="color:#34D399;font-size:28px;font-weight:800;letter-spacing:-0.5px;">Real-time</div>
                            <div style="color:rgba(255,255,255,0.5);font-size:13px;margin-top:2px;">Kalkulasi saldo</div>
                        </div>
                    </div>
                </div>

                <!-- Bottom floating cards (decorative) -->
                <div style="position:relative;z-index:10;">
                    <div style="display:flex;gap:12px;align-items:flex-end;">
                        <div class="floating-card" style="flex:1;">
                            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                                <div style="width:32px;height:32px;background:rgba(167,139,250,0.2);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                    <svg width="16" height="16" fill="none" stroke="#A78BFA" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                                </div>
                                <span style="color:rgba(255,255,255,0.7);font-size:12px;font-weight:600;">Sewa Villa</span>
                            </div>
                            <div style="color:white;font-size:18px;font-weight:700;">Rp 2.400.000</div>
                            <div style="color:rgba(255,255,255,0.4);font-size:11px;margin-top:4px;">dibayar oleh 3 orang</div>
                        </div>
                        <div class="floating-card" style="flex:1;">
                            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                                <div style="width:32px;height:32px;background:rgba(6,182,212,0.2);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                    <svg width="16" height="16" fill="none" stroke="#06B6D4" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8h1a4 4 0 010 8h-1"/><path d="M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
                                </div>
                                <span style="color:rgba(255,255,255,0.7);font-size:12px;font-weight:600;">Makan Siang</span>
                            </div>
                            <div style="color:white;font-size:18px;font-weight:700;">Rp 450.000</div>
                            <div style="color:rgba(255,255,255,0.4);font-size:11px;margin-top:4px;">4 dari 6 anggota</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== RIGHT PANEL — Login Form ===== -->
            <div class="auth-form-panel" style="width:100%;max-width:480px;display:flex;flex-direction:column;justify-content:center;padding:48px 56px;min-height:100vh;position:relative;">

                <!-- Mobile logo (visible only on mobile) -->
                <div style="display:none;align-items:center;gap:10px;margin-bottom:40px;" class="mobile-logo">
                    <div class="brand-logo-mark">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                            <path d="M2 17l10 5 10-5"/>
                            <path d="M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <span style="font-weight:700;font-size:18px;color:#111827;">SplitTrip</span>
                </div>

                <!-- Greeting -->
                <div style="margin-bottom:40px;">
                    @isset($heading)
                        {{ $heading }}
                    @else
                        <h2 style="font-size:30px;font-weight:800;color:#111827;letter-spacing:-0.8px;margin:0 0 8px;">Selamat datang! 👋</h2>
                        <p style="color:#6B7280;font-size:15px;margin:0;">Masuk untuk melihat trip dan pengeluaranmu.</p>
                    @endisset
                </div>

                {{ $slot }}

                <!-- Footer -->
                @isset($footer)
                    {{ $footer }}
                @else
                    <div style="margin-top:40px;padding-top:24px;border-top:1px solid #F3F4F6;text-align:center;">
                        <p style="color:#9CA3AF;font-size:13px;margin:0;">
                            Belum punya akun?
                            <a href="{{ route('register') }}" style="color:#7C3AED;font-weight:600;text-decoration:none;margin-left:4px;">Daftar sekarang →</a>
                        </p>
                    </div>
                @endisset
            </div>
        </div>

        <style>
            @media (max-width: 768px) {
                .left-panel { display: none !important; }
                .mobile-logo { display: flex !important; }
                .auth-form-panel {
                    max-width: 100% !important;
                    padding: 40px 24px !important;
                    background: #0D0B1E !important;
                    color: white !important;
                }
                .auth-form-panel h2 { color: white !important; }
                .auth-form-panel p { color: rgba(255,255,255,0.5) !important; }
                .auth-input {
                    background: rgba(255,255,255,0.08) !important;
                    border-color: rgba(255,255,255,0.15) !important;
                    color: white !important;
                }
                .auth-input:focus {
                    background: rgba(255,255,255,0.12) !important;
                    border-color: #7C3AED !important;
                }
                .auth-input::placeholder { color: rgba(255,255,255,0.35) !important; }
                .divider-or { color: rgba(255,255,255,0.3) !important; }
                .divider-or::before, .divider-or::after { background: rgba(255,255,255,0.1) !important; }
                .auth-form-panel [style*="border-top"] { border-top-color: rgba(255,255,255,0.08) !important; }
                .auth-form-panel [style*="color:#6B7280"] { color: rgba(255,255,255,0.5) !important; }
                .auth-form-panel [style*="color:#9CA3AF"] { color: rgba(255,255,255,0.4) !important; }
                label { color: rgba(255,255,255,0.8) !important; }
            }
        </style>
    </body>
</html>

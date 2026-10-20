<x-guest-layout>
    {{-- Session Status --}}
    @if (session('status'))
        <div class="session-status" role="alert">
            <svg style="display:inline;width:14px;height:14px;margin-right:6px;vertical-align:-2px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" id="login-form">
        @csrf

        {{-- Email --}}
        <div style="margin-bottom: 20px;">
            <label for="email" style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:8px;letter-spacing:0.3px;">
                Alamat Email
            </label>
            <div class="input-wrapper">
                <svg class="input-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <input
                    id="email"
                    class="auth-input input-with-icon"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="nama@email.com"
                    style="{{ $errors->get('email') ? 'border-color:#EF4444;background:#FEF2F2;' : '' }}"
                >
            </div>
            @if ($errors->get('email'))
                @foreach ($errors->get('email') as $message)
                    <div class="error-msg">
                        <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </div>
                @endforeach
            @endif
        </div>

        {{-- Password --}}
        <div style="margin-bottom: 20px;">
            <label for="password" style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:8px;letter-spacing:0.3px;">
                Password
            </label>
            <div class="input-wrapper" id="password-wrapper">
                <svg class="input-icon" id="password-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>
                </svg>
                <input
                    id="password"
                    class="auth-input input-with-icon"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan password"
                    style="padding-right: 44px; {{ $errors->get('password') ? 'border-color:#EF4444;background:#FEF2F2;' : '' }}"
                >
                {{-- Toggle show/hide password --}}
                <button
                    type="button"
                    id="toggle-password"
                    onclick="togglePassword()"
                    style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#9CA3AF;padding:0;display:flex;align-items:center;"
                    aria-label="Toggle password visibility"
                >
                    <svg id="eye-open" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:block;">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                    </svg>
                    <svg id="eye-closed" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none;">
                        <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>
                    </svg>
                </button>
            </div>
            @if ($errors->get('password'))
                @foreach ($errors->get('password') as $message)
                    <div class="error-msg">
                        <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </div>
                @endforeach
            @endif
        </div>

        {{-- Remember me + Forgot password --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;" for="remember_me">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="check-custom"
                    style="border-radius:4px;"
                >
                <span style="font-size:13px;color:#6B7280;font-weight:500;">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a
                    href="{{ route('password.request') }}"
                    id="forgot-password-link"
                    style="font-size:13px;color:#7C3AED;font-weight:600;text-decoration:none;transition:color 0.2s;"
                    onmouseover="this.style.color='#6D28D9'"
                    onmouseout="this.style.color='#7C3AED'"
                >
                    Lupa password?
                </a>
            @endif
        </div>

        {{-- Submit button --}}
        <button type="submit" id="login-submit-btn" class="auth-btn">
            <span id="btn-text" style="display:flex;align-items:center;justify-content:center;gap:8px;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                Masuk Sekarang
            </span>
            <span id="btn-loading" style="display:none;align-items:center;justify-content:center;gap:8px;">
                <svg style="animation:spin 1s linear infinite;" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
                Sedang masuk...
            </span>
        </button>
    </form>

    <style>
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    </style>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            eyeOpen.style.display = isPassword ? 'none' : 'block';
            eyeClosed.style.display = isPassword ? 'block' : 'none';
        }

        document.getElementById('login-form').addEventListener('submit', function() {
            document.getElementById('btn-text').style.display = 'none';
            document.getElementById('btn-loading').style.display = 'flex';
            document.getElementById('login-submit-btn').disabled = true;
        });
    </script>
</x-guest-layout>

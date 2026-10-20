<x-guest-layout>
    {{-- Custom heading --}}
    <x-slot name="heading">
        <h2 style="font-size:28px;font-weight:800;color:#111827;letter-spacing:-0.8px;margin:0 0 8px;">Reset password 🔒</h2>
        <p style="color:#6B7280;font-size:14px;margin:0;line-height:1.6;">
            Buat password baru untuk akun <strong>{{ $request->email }}</strong>.
        </p>
    </x-slot>

    {{-- Custom footer --}}
    <x-slot name="footer">
        <div style="margin-top:32px;padding-top:24px;border-top:1px solid #F3F4F6;text-align:center;">
            <p style="color:#9CA3AF;font-size:13px;margin:0;">
                Kembali ke
                <a href="{{ route('login') }}" style="color:#7C3AED;font-weight:600;text-decoration:none;margin-left:4px;">halaman masuk →</a>
            </p>
        </div>
    </x-slot>

    <form method="POST" action="{{ route('password.store') }}" id="reset-form">
        @csrf

        {{-- Token --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        {{-- Email --}}
        <div style="margin-bottom: 18px;">
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
                    value="{{ old('email', $request->email) }}"
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
        <div style="margin-bottom: 18px;">
            <label for="password" style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:8px;letter-spacing:0.3px;">
                Password Baru
            </label>
            <div class="input-wrapper">
                <svg class="input-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>
                </svg>
                <input
                    id="password"
                    class="auth-input input-with-icon"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="Min. 8 karakter"
                    style="padding-right: 44px; {{ $errors->get('password') ? 'border-color:#EF4444;background:#FEF2F2;' : '' }}"
                >
                <button type="button" onclick="togglePass('password','eye-open-pw','eye-closed-pw')"
                    style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#9CA3AF;padding:0;display:flex;" aria-label="Tampilkan password">
                    <svg id="eye-open-pw" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:block;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    <svg id="eye-closed-pw" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
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

        {{-- Confirm Password --}}
        <div style="margin-bottom: 28px;">
            <label for="password_confirmation" style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:8px;letter-spacing:0.3px;">
                Konfirmasi Password Baru
            </label>
            <div class="input-wrapper">
                <svg class="input-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                <input
                    id="password_confirmation"
                    class="auth-input input-with-icon"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Ulangi password baru"
                    style="padding-right: 44px; {{ $errors->get('password_confirmation') ? 'border-color:#EF4444;background:#FEF2F2;' : '' }}"
                >
                <button type="button" onclick="togglePass('password_confirmation','eye-open-pc','eye-closed-pc')"
                    style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#9CA3AF;padding:0;display:flex;" aria-label="Tampilkan konfirmasi">
                    <svg id="eye-open-pc" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:block;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    <svg id="eye-closed-pc" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                </button>
            </div>
            @if ($errors->get('password_confirmation'))
                @foreach ($errors->get('password_confirmation') as $message)
                    <div class="error-msg">
                        <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </div>
                @endforeach
            @endif
        </div>

        {{-- Submit --}}
        <button type="submit" id="reset-submit-btn" class="auth-btn">
            <span id="reset-btn-text" style="display:flex;align-items:center;justify-content:center;gap:8px;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                Simpan Password Baru
            </span>
            <span id="reset-btn-loading" style="display:none;align-items:center;justify-content:center;gap:8px;">
                <svg style="animation:spin 1s linear infinite;" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
                Menyimpan...
            </span>
        </button>
    </form>

    <style>
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    </style>

    <script>
        function togglePass(inputId, openId, closedId) {
            const input = document.getElementById(inputId);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            document.getElementById(openId).style.display = isPassword ? 'none' : 'block';
            document.getElementById(closedId).style.display = isPassword ? 'block' : 'none';
        }

        document.getElementById('reset-form').addEventListener('submit', function() {
            document.getElementById('reset-btn-text').style.display = 'none';
            document.getElementById('reset-btn-loading').style.display = 'flex';
            document.getElementById('reset-submit-btn').disabled = true;
        });
    </script>
</x-guest-layout>

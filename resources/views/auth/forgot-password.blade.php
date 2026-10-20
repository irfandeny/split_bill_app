<x-guest-layout>
    {{-- Custom heading --}}
    <x-slot name="heading">
        <h2 style="font-size:28px;font-weight:800;color:#111827;letter-spacing:-0.8px;margin:0 0 8px;">Lupa password? 🔑</h2>
        <p style="color:#6B7280;font-size:14px;margin:0;line-height:1.6;">
            Masukkan email akunmu, kami akan kirimkan link untuk reset password.
        </p>
    </x-slot>

    {{-- Custom footer --}}
    <x-slot name="footer">
        <div style="margin-top:32px;padding-top:24px;border-top:1px solid #F3F4F6;text-align:center;">
            <p style="color:#9CA3AF;font-size:13px;margin:0;">
                Ingat password?
                <a href="{{ route('login') }}" style="color:#7C3AED;font-weight:600;text-decoration:none;margin-left:4px;">Kembali masuk →</a>
            </p>
        </div>
    </x-slot>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="session-status" role="alert" style="margin-bottom: 20px;">
            <svg style="display:inline;width:14px;height:14px;margin-right:6px;vertical-align:-2px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" id="forgot-form">
        @csrf

        {{-- Email --}}
        <div style="margin-bottom: 24px;">
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

        {{-- Submit --}}
        <button type="submit" id="forgot-submit-btn" class="auth-btn">
            <span id="forgot-btn-text" style="display:flex;align-items:center;justify-content:center;gap:8px;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                Kirim Link Reset Password
            </span>
            <span id="forgot-btn-loading" style="display:none;align-items:center;justify-content:center;gap:8px;">
                <svg style="animation:spin 1s linear infinite;" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
                Mengirim...
            </span>
        </button>
    </form>

    <style>
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    </style>

    <script>
        document.getElementById('forgot-form').addEventListener('submit', function() {
            document.getElementById('forgot-btn-text').style.display = 'none';
            document.getElementById('forgot-btn-loading').style.display = 'flex';
            document.getElementById('forgot-submit-btn').disabled = true;
        });
    </script>
</x-guest-layout>

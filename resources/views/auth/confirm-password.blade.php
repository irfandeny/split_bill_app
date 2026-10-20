<x-guest-layout>
    <x-slot name="heading">
        <h2 style="font-size:28px;font-weight:800;color:#111827;letter-spacing:-0.8px;margin:0 0 8px;">Konfirmasi password 🛡️</h2>
        <p style="color:#6B7280;font-size:14px;margin:0;line-height:1.6;">
            Ini area aman. Masukkan password untuk melanjutkan.
        </p>
    </x-slot>

    <x-slot name="footer">
        <div style="display:none;"></div>
    </x-slot>

    <form method="POST" action="{{ route('password.confirm') }}" id="confirm-form">
        @csrf

        <div style="margin-bottom: 24px;">
            <label for="password" style="display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:8px;letter-spacing:0.3px;">
                Password
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
                    autocomplete="current-password"
                    placeholder="Masukkan password kamu"
                    style="padding-right: 44px; {{ $errors->get('password') ? 'border-color:#EF4444;background:#FEF2F2;' : '' }}"
                >
                <button type="button" onclick="togglePass()"
                    style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#9CA3AF;padding:0;display:flex;" aria-label="Tampilkan password">
                    <svg id="eye-open" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:block;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    <svg id="eye-closed" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
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

        <button type="submit" class="auth-btn">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-right: 8px; display: inline;"><polyline points="20 6 9 17 4 12"/></svg>
            Konfirmasi & Lanjutkan
        </button>
    </form>

    <script>
        function togglePass() {
            const input = document.getElementById('password');
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            document.getElementById('eye-open').style.display = isPassword ? 'none' : 'block';
            document.getElementById('eye-closed').style.display = isPassword ? 'block' : 'none';
        }
    </script>
</x-guest-layout>

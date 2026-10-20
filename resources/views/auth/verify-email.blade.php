<x-guest-layout>
    <x-slot name="heading">
        <h2 style="font-size:28px;font-weight:800;color:#111827;letter-spacing:-0.8px;margin:0 0 8px;">Verifikasi email kamu 📬</h2>
        <p style="color:#6B7280;font-size:14px;margin:0;line-height:1.65;">
            Makasih udah daftar! Cek inbox emailmu dan klik link verifikasi yang sudah kami kirim. Kalau tidak ada, klik tombol di bawah untuk kirim ulang.
        </p>
    </x-slot>

    <x-slot name="footer">
        <div style="display:none;"></div>
    </x-slot>

    @if (session('status') == 'verification-link-sent')
        <div class="session-status" style="margin-bottom: 24px;">
            <svg style="display:inline;width:14px;height:14px;margin-right:6px;vertical-align:-2px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Link verifikasi baru sudah dikirim ke emailmu!
        </div>
    @endif

    {{-- Illustration --}}
    <div style="text-align: center; padding: 28px 0 32px; border: 1.5px dashed #DDD6FE; border-radius: 16px; background: #FAFAFE; margin-bottom: 28px;">
        <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #EDE9FE, #DDD6FE); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px;">
            <svg width="28" height="28" fill="none" stroke="#7C3AED" stroke-width="1.5" viewBox="0 0 24 24">
                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <p style="font-size: 14px; color: #6B7280; margin: 0;">Cek folder <strong style="color: #374151;">Inbox</strong> atau <strong style="color: #374151;">Spam</strong> emailmu</p>
    </div>

    <div style="display: flex; flex-direction: column; gap: 12px;">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="auth-btn">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:inline;margin-right:8px;vertical-align:-2px;"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="width:100%;padding:12px;background:none;border:1.5px solid #E5E7EB;border-radius:12px;color:#6B7280;font-size:14px;font-weight:600;font-family:'Plus Jakarta Sans',sans-serif;cursor:pointer;transition:all 0.15s;" onmouseover="this.style.borderColor='#C4B5FD';this.style.color='#7C3AED'" onmouseout="this.style.borderColor='#E5E7EB';this.style.color='#6B7280'">
                Keluar dari akun ini
            </button>
        </form>
    </div>
</x-guest-layout>

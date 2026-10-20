<x-app-layout>
    <div class="page-content">

        <!-- Breadcrumb -->
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 24px; font-size: 13px; color: #9CA3AF;">
            <a href="{{ route('trips.index') }}" style="color: #7C3AED; font-weight: 600; text-decoration: none;">My Trips</a>
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            <span>Buat Trip Baru</span>
        </div>

        <div style="max-width: 520px;">
            <div style="margin-bottom: 28px;">
                <h1 style="font-size: 26px; font-weight: 800; color: #1F1147; letter-spacing: -0.5px; margin: 0 0 6px;">Buat Trip Baru</h1>
                <p style="color: #6B7280; font-size: 14px; margin: 0;">Kasih nama tripmu, lalu undang teman-teman untuk mulai.</p>
            </div>

            <div class="card" style="padding: 32px;">
                @if ($errors->any())
                    <div class="alert-error">
                        <ul style="margin: 0; padding-left: 16px; list-style: disc;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('trips.store') }}">
                    @csrf

                    <div style="margin-bottom: 24px;">
                        <label for="trip-name" class="form-label">Nama Trip</label>
                        <div style="position: relative;">
                            <svg style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9CA3AF;" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <input
                                id="trip-name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                placeholder="cth: Bali Weekend, Bandung Trip, dll"
                                class="form-input"
                                style="padding-left: 42px;"
                            >
                        </div>
                        @error('name')
                            <p style="color: #EF4444; font-size: 12px; margin-top: 6px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div style="display: flex; gap: 12px;">
                        <button type="submit" class="btn-primary" id="create-trip-submit" style="flex: 1; justify-content: center;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Buat Trip
                        </button>
                        <a href="{{ route('trips.index') }}" class="btn-secondary" style="flex: 1; justify-content: center;">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

            <!-- Info tip -->
            <div style="display: flex; gap: 12px; background: #F5F3FF; border: 1px solid #DDD6FE; border-radius: 12px; padding: 16px; margin-top: 16px;">
                <svg width="18" height="18" fill="none" stroke="#7C3AED" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink: 0; margin-top: 1px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <p style="font-size: 13px; color: #5B21B6; margin: 0; line-height: 1.6;">
                    Setelah trip dibuat, kamu bisa tambah anggota dan mulai catat pengeluaran.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
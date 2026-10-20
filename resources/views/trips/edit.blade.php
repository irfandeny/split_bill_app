<x-app-layout>
    <div class="page-content">

        <!-- Breadcrumb -->
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 24px; font-size: 13px; color: #9CA3AF;">
            <a href="{{ route('trips.index') }}" style="color: #7C3AED; font-weight: 600; text-decoration: none;">My Trips</a>
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            <a href="{{ route('trips.show', $trip) }}" style="color: #7C3AED; font-weight: 600; text-decoration: none;">{{ $trip->name }}</a>
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            <span>Edit Trip</span>
        </div>

        <div style="max-width: 520px;">
            <div style="margin-bottom: 28px;">
                <h1 style="font-size: 26px; font-weight: 800; color: #1F1147; letter-spacing: -0.5px; margin: 0 0 6px;">Edit Trip</h1>
                <p style="color: #6B7280; font-size: 14px; margin: 0;">Ubah nama trip "{{ $trip->name }}".</p>
            </div>

            <div class="card" style="padding: 32px;">
                <form method="POST" action="{{ route('trips.update', $trip) }}">
                    @csrf
                    @method('PUT')

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
                                value="{{ old('name', $trip->name) }}"
                                required
                                autofocus
                                class="form-input"
                                style="padding-left: 42px;"
                            >
                        </div>
                        @error('name')
                            <p style="color: #EF4444; font-size: 12px; margin-top: 6px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div style="display: flex; gap: 12px;">
                        <button type="submit" class="btn-primary" style="flex: 1; justify-content: center;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('trips.show', $trip) }}" class="btn-secondary" style="flex: 1; justify-content: center;">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
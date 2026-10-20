<x-app-layout>
    <div class="page-content">

        <!-- Page header -->
        <div style="margin-bottom: 28px;">
            <h1 style="font-size: 26px; font-weight: 800; color: #1F1147; letter-spacing: -0.5px; margin: 0 0 4px;">My Trips</h1>
            <p style="color: #6B7280; font-size: 14px; margin: 0;">Semua perjalananmu yang pernah tercatat di sini.</p>
        </div>

        @if (session('success'))
            <div class="alert-success">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Create trip card + list -->
        <div style="display: grid; grid-template-columns: 1fr; gap: 20px;">

            <!-- Header row with CTA -->
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                <span style="font-size: 15px; font-weight: 700; color: #374151;">
                    {{ $trips->count() }} Trip {{ $trips->count() === 1 ? 'ditemukan' : 'ditemukan' }}
                </span>
                <a href="{{ route('trips.create') }}" class="btn-primary" id="create-trip-btn">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Buat Trip Baru
                </a>
            </div>

            @if ($trips->isEmpty())
                <!-- Empty state -->
                <div class="card" style="padding: 64px 32px; text-align: center;">
                    <div style="width: 72px; height: 72px; background: linear-gradient(135deg, #EDE9FE, #DDD6FE); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <svg width="32" height="32" fill="none" stroke="#7C3AED" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 style="font-size: 18px; font-weight: 700; color: #1F1147; margin: 0 0 8px;">Belum ada trip nih!</h3>
                    <p style="color: #9CA3AF; font-size: 14px; margin: 0 0 24px; max-width: 300px; margin-left: auto; margin-right: auto;">Buat trip pertamamu dan mulai catat semua pengeluaran bareng teman.</p>
                    <a href="{{ route('trips.create') }}" class="btn-primary" style="display: inline-flex;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Buat Trip Pertama
                    </a>
                </div>
            @else
                <!-- Trip cards grid -->
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px;">
                    @foreach ($trips as $trip)
                        <a href="{{ route('trips.show', $trip) }}" class="card trip-card" style="padding: 24px; text-decoration: none; display: block; transition: all 0.2s ease; position: relative; overflow: hidden;" id="trip-card-{{ $trip->id }}">
                            <!-- Top accent line -->
                            <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #7C3AED, #4F46E5);"></div>

                            <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 16px;">
                                <div style="width: 44px; height: 44px; background: linear-gradient(135deg, #EDE9FE, #DDD6FE); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <svg width="20" height="20" fill="none" stroke="#7C3AED" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <span class="badge badge-purple">{{ $trip->created_at->format('M Y') }}</span>
                            </div>

                            <h3 style="font-size: 16px; font-weight: 700; color: #1F1147; margin: 0 0 6px; letter-spacing: -0.2px;">{{ $trip->name }}</h3>
                            <p style="color: #9CA3AF; font-size: 13px; margin: 0 0 16px;">Dibuat {{ $trip->created_at->diffForHumans() }}</p>

                            <div style="display: flex; align-items: center; gap: 16px; padding-top: 14px; border-top: 1px solid #F3F4F6;">
                                <div style="display: flex; align-items: center; gap: 5px; color: #6B7280; font-size: 12px; font-weight: 500;">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                                    {{ $trip->members_count ?? $trip->members()->count() }} anggota
                                </div>
                                <div style="display: flex; align-items: center; gap: 5px; color: #6B7280; font-size: 12px; font-weight: 500;">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                                    {{ $trip->expenses()->count() }} expense
                                </div>
                                <div style="margin-left: auto; color: #7C3AED;">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

        </div>
    </div>

    <style>
        .trip-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(124,58,237,0.12) !important;
            border-color: #C4B5FD !important;
        }
    </style>
</x-app-layout>
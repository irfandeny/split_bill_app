<x-app-layout>
    <div class="page-content">

        <!-- Hero greeting -->
        <div style="background: linear-gradient(135deg, #1F1147 0%, #2D1A6E 50%, #1A3048 100%); border-radius: 20px; padding: 36px 40px; margin-bottom: 28px; position: relative; overflow: hidden;">
            <!-- Decorative orb -->
            <div style="position: absolute; top: -60px; right: -60px; width: 220px; height: 220px; background: radial-gradient(circle, rgba(124,58,237,0.3) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
            <div style="position: absolute; bottom: -40px; left: 30%; width: 160px; height: 160px; background: radial-gradient(circle, rgba(6,182,212,0.15) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>

            <div style="position: relative; z-index: 1;">
                <p style="color: rgba(255,255,255,0.55); font-size: 14px; margin: 0 0 8px; font-weight: 500;">Selamat datang kembali 👋</p>
                <h1 style="color: white; font-size: 28px; font-weight: 800; letter-spacing: -0.5px; margin: 0 0 20px;">{{ Auth::user()->name }}</h1>

                <a href="{{ route('trips.index') }}" class="btn-primary" style="background: rgba(255,255,255,0.15); box-shadow: none; border: 1.5px solid rgba(255,255,255,0.25); backdrop-filter: blur(8px);">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Lihat Semua Trip
                </a>
            </div>
        </div>

        <!-- Quick actions -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 28px;">
            <a href="{{ route('trips.create') }}" class="card" style="padding: 24px; text-decoration: none; display: flex; align-items: center; gap: 16px; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-2px)';this.style.borderColor='#C4B5FD'" onmouseout="this.style.transform='';this.style.borderColor='#EDE9FE'">
                <div style="width: 44px; height: 44px; background: linear-gradient(135deg, #7C3AED, #4F46E5); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(124,58,237,0.3); flex-shrink: 0;">
                    <svg width="20" height="20" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                </div>
                <div>
                    <p style="font-size: 14px; font-weight: 700; color: #1F1147; margin: 0 0 2px;">Buat Trip Baru</p>
                    <p style="font-size: 12px; color: #9CA3AF; margin: 0;">Mulai perjalanan baru</p>
                </div>
            </a>

            <a href="{{ route('trips.index') }}" class="card" style="padding: 24px; text-decoration: none; display: flex; align-items: center; gap: 16px; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-2px)';this.style.borderColor='#C4B5FD'" onmouseout="this.style.transform='';this.style.borderColor='#EDE9FE'">
                <div style="width: 44px; height: 44px; background: linear-gradient(135deg, #06B6D4, #0891B2); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(6,182,212,0.3); flex-shrink: 0;">
                    <svg width="20" height="20" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <p style="font-size: 14px; font-weight: 700; color: #1F1147; margin: 0 0 2px;">My Trips</p>
                    <p style="font-size: 12px; color: #9CA3AF; margin: 0;">Lihat semua tripmu</p>
                </div>
            </a>

            <a href="{{ route('profile.edit') }}" class="card" style="padding: 24px; text-decoration: none; display: flex; align-items: center; gap: 16px; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-2px)';this.style.borderColor='#C4B5FD'" onmouseout="this.style.transform='';this.style.borderColor='#EDE9FE'">
                <div style="width: 44px; height: 44px; background: linear-gradient(135deg, #10B981, #059669); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(16,185,129,0.3); flex-shrink: 0;">
                    <svg width="20" height="20" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div>
                    <p style="font-size: 14px; font-weight: 700; color: #1F1147; margin: 0 0 2px;">Edit Profil</p>
                    <p style="font-size: 12px; color: #9CA3AF; margin: 0;">Ubah info akun</p>
                </div>
            </a>
        </div>

        <!-- How it works -->
        <div class="card" style="padding: 28px;">
            <h2 style="font-size: 16px; font-weight: 700; color: #1F1147; margin: 0 0 20px;">Cara kerja SplitTrip</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px;">
                @foreach ([
                    ['icon' => '<path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>', 'step' => '1', 'title' => 'Buat Trip', 'desc' => 'Beri nama trip dan undang teman-teman'],
                    ['icon' => '<rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/>', 'step' => '2', 'title' => 'Catat Expense', 'desc' => 'Input pengeluaran dengan multi-payer & split'],
                    ['icon' => '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>', 'step' => '3', 'title' => 'Hitung Otomatis', 'desc' => 'Tanggungan tiap orang dihitung secara real-time'],
                    ['icon' => '<polyline points="20 6 9 17 4 12"/>', 'step' => '4', 'title' => 'Catat Pelunasan', 'desc' => 'Input settlement manual saat teman bayar'],
                ] as $item)
                    <div style="display: flex; flex-direction: column; align-items: center; text-align: center; gap: 12px; padding: 16px; border-radius: 12px; background: #FAFAFA; border: 1px solid #F3F4F6;">
                        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #EDE9FE, #DDD6FE); border-radius: 14px; display: flex; align-items: center; justify-content: center; position: relative;">
                            <svg width="20" height="20" fill="none" stroke="#7C3AED" stroke-width="2" viewBox="0 0 24 24">{!! $item['icon'] !!}</svg>
                            <div style="position: absolute; top: -6px; right: -6px; width: 18px; height: 18px; background: #7C3AED; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 700; color: white;">{{ $item['step'] }}</div>
                        </div>
                        <div>
                            <p style="font-size: 13px; font-weight: 700; color: #1F1147; margin: 0 0 4px;">{{ $item['title'] }}</p>
                            <p style="font-size: 12px; color: #9CA3AF; margin: 0; line-height: 1.5;">{{ $item['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>

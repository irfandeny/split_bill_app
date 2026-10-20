<x-app-layout>
    <div class="page-content">

        <!-- Breadcrumb -->
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 24px; font-size: 13px; color: #9CA3AF;">
            <a href="{{ route('trips.index') }}" style="color: #7C3AED; font-weight: 600; text-decoration: none;">My Trips</a>
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            <span>{{ $trip->name }}</span>
        </div>

        @if (session('success'))
            <div class="alert-success">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Trip Header -->
        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; flex-wrap: wrap; margin-bottom: 28px;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 52px; height: 52px; background: linear-gradient(135deg, #7C3AED, #4F46E5); border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 14px rgba(124,58,237,0.3);">
                    <svg width="24" height="24" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 style="font-size: 24px; font-weight: 800; color: #1F1147; letter-spacing: -0.5px; margin: 0 0 4px;">{{ $trip->name }}</h1>
                    <p style="color: #9CA3AF; font-size: 13px; margin: 0;">Dibuat {{ $trip->created_at->format('d M Y') }} · {{ $trip->members->count() }} anggota</p>
                </div>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ route('trips.edit', $trip) }}" class="btn-warning" id="edit-trip-btn">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Edit Trip
                </a>
                <form method="POST" action="{{ route('trips.destroy', $trip) }}" onsubmit="return confirm('Yakin hapus trip ini beserta semua data pengeluarannya?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger" id="delete-trip-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                        Hapus Trip
                    </button>
                </form>
            </div>
        </div>

        <!-- Two column layout on desktop -->
        <div style="display: grid; grid-template-columns: 320px 1fr; gap: 24px; align-items: start;">

            <!-- LEFT: Members panel -->
            <div>
                <div class="card" style="overflow: hidden;">
                    <div style="padding: 20px 24px; border-bottom: 1px solid #F3F4F6; display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <h2 style="font-size: 15px; font-weight: 700; color: #1F1147; margin: 0 0 2px;">Anggota Trip</h2>
                            <p style="font-size: 12px; color: #9CA3AF; margin: 0;">{{ $trip->members->count() }} orang</p>
                        </div>
                        <span class="badge badge-purple">{{ $trip->members->count() }}</span>
                    </div>

                    @if ($trip->members->isEmpty())
                        <div style="padding: 32px; text-align: center;">
                            <svg width="32" height="32" fill="none" stroke="#C4B5FD" stroke-width="1.5" viewBox="0 0 24 24" style="margin: 0 auto 10px; display: block;"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                            <p style="font-size: 13px; color: #9CA3AF; margin: 0;">Belum ada anggota.</p>
                        </div>
                    @else
                        <ul style="list-style: none; margin: 0; padding: 8px 0;">
                            @foreach ($trip->members as $member)
                                <li style="display: flex; align-items: center; justify-content: space-between; padding: 10px 20px; gap: 12px; transition: background 0.1s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #EDE9FE, #DDD6FE); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: #7C3AED; flex-shrink: 0;">
                                            {{ strtoupper(substr($member->name, 0, 1)) }}
                                        </div>
                                        <span style="font-size: 14px; font-weight: 500; color: #374151;">{{ $member->name }}</span>
                                    </div>
                                    <form method="POST" action="{{ route('trips.members.destroy', [$trip, $member]) }}" onsubmit="return confirm('Hapus anggota {{ $member->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: none; border: none; cursor: pointer; color: #D1D5DB; padding: 4px; display: flex; transition: color 0.15s;" onmouseover="this.style.color='#EF4444'" onmouseout="this.style.color='#D1D5DB'" title="Hapus anggota">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <!-- Add member form -->
                    <div style="padding: 16px 20px; border-top: 1px solid #F3F4F6; background: #FAFAFA;">
                        <form method="POST" action="{{ route('trips.members.store', $trip) }}" style="display: flex; gap: 8px;" id="add-member-form">
                            @csrf
                            <input
                                type="text"
                                name="name"
                                placeholder="Nama anggota baru..."
                                required
                                class="form-input"
                                style="flex: 1; font-size: 13px; padding: 9px 12px;"
                                id="new-member-name"
                            >
                            <button type="submit" class="btn-primary" style="padding: 9px 14px; font-size: 13px;">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                Tambah
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Expenses panel -->
            <div>
                <div class="card" style="overflow: hidden;">
                    <div style="padding: 20px 24px; border-bottom: 1px solid #F3F4F6; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                        <div>
                            <h2 style="font-size: 15px; font-weight: 700; color: #1F1147; margin: 0 0 2px;">Daftar Pengeluaran</h2>
                            <p style="font-size: 12px; color: #9CA3AF; margin: 0;">
                                Total: <strong style="color: #7C3AED;">Rp{{ number_format($trip->expenses->sum('total_amount'), 0, ',', '.') }}</strong>
                                dari {{ $trip->expenses->count() }} expense
                            </p>
                        </div>
                        @if ($trip->members->isNotEmpty())
                            <a href="{{ route('expenses.create', $trip) }}" class="btn-primary" id="add-expense-btn" style="font-size: 13px; padding: 8px 16px;">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                Tambah Expense
                            </a>
                        @endif
                    </div>

                    @if ($trip->expenses->isEmpty())
                        <div style="padding: 48px 32px; text-align: center;">
                            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #EDE9FE, #DDD6FE); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px;">
                                <svg width="24" height="24" fill="none" stroke="#7C3AED" stroke-width="1.5" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                            </div>
                            <p style="font-size: 14px; font-weight: 600; color: #374151; margin: 0 0 4px;">Belum ada pengeluaran</p>
                            <p style="font-size: 13px; color: #9CA3AF; margin: 0;">
                                {{ $trip->members->isEmpty() ? 'Tambah anggota dulu sebelum mencatat expense.' : 'Klik "Tambah Expense" untuk mulai mencatat.' }}
                            </p>
                        </div>
                    @else
                        <div style="padding: 8px 0;">
                            @foreach ($trip->expenses as $expense)
                                <div class="expense-row" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 24px; gap: 16px; border-bottom: 1px solid #F9FAFB; transition: background 0.1s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                                    <div style="display: flex; align-items: center; gap: 14px; min-width: 0;">
                                        <div style="width: 38px; height: 38px; background: #F5F3FF; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <svg width="17" height="17" fill="none" stroke="#7C3AED" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                                        </div>
                                        <div style="min-width: 0;">
                                            <p style="font-size: 14px; font-weight: 600; color: #1F1147; margin: 0 0 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $expense->title }}</p>
                                            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                                <span style="font-size: 13px; color: #7C3AED; font-weight: 700;">Rp{{ number_format($expense->total_amount, 0, ',', '.') }}</span>
                                                <span class="badge {{ match($expense->split_method) { 'equal' => 'badge-green', 'custom_amount' => 'badge-blue', 'percentage' => 'badge-orange', default => 'badge-purple' } }}">
                                                    {{ match($expense->split_method) { 'equal' => 'Rata', 'custom_amount' => 'Custom', 'percentage' => 'Persentase', default => $expense->split_method } }}
                                                </span>
                                                @if ($expense->expense_date)
                                                    <span style="font-size: 11px; color: #9CA3AF;">{{ \Carbon\Carbon::parse($expense->expense_date)->format('d M') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('expenses.edit', [$trip, $expense]) }}" class="btn-warning" style="font-size: 12px; padding: 6px 12px; white-space: nowrap;">Edit</a>
                                    <form method="POST" action="{{ route('expenses.destroy', [$trip, $expense]) }}" onsubmit="return confirm('Hapus expense \'{{ $expense->title }}\'?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger" style="font-size: 12px; padding: 6px 12px; white-space: nowrap;">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        <!-- Expense summary footer -->
                        <div style="padding: 14px 24px; background: #F9FAFB; border-top: 1px solid #F3F4F6; display: flex; align-items: center; justify-content: space-between;">
                            <span style="font-size: 13px; color: #6B7280; font-weight: 500;">Total semua pengeluaran</span>
                            <span style="font-size: 16px; font-weight: 800; color: #7C3AED;">Rp{{ number_format($trip->expenses->sum('total_amount'), 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <style>
            @media (max-width: 900px) {
                div[style*="grid-template-columns: 320px 1fr"] {
                    grid-template-columns: 1fr !important;
                }
            }
        </style>
    </div>
</x-app-layout>
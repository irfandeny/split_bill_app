<x-app-layout>
    @php
        $editing = isset($expense);
        $formConfig = [
            'members' => $trip->members->map(fn ($m) => ['id' => $m->id, 'name' => $m->name])->values(),
            'totalAmount' => old('total_amount', $editing ? $expense->total_amount : 0),
            'splitMethod' => old('split_method', $editing ? $expense->split_method : 'equal'),
            'payers' => array_values(old('payers', $editing ? $expense->payers->map(fn ($p) => [
                'trip_member_id' => $p->trip_member_id, 'amount_paid' => $p->amount_paid,
            ])->all() : [['trip_member_id' => '', 'amount_paid' => '']])),
            'participants' => array_values(old('participants', session()->hasOldInput() ? [] : ($editing ? $expense->participants->map(fn ($p) => [
                'trip_member_id' => $p->trip_member_id, 'share_amount' => $p->share_amount,
                'share_percentage' => $p->share_percentage,
            ])->all() : []))),
        ];
    @endphp
    <div class="page-content">

        <!-- Breadcrumb -->
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 24px; font-size: 13px; color: #9CA3AF;">
            <a href="{{ route('trips.index') }}" style="color: #7C3AED; font-weight: 600; text-decoration: none;">My Trips</a>
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            <a href="{{ route('trips.show', $trip) }}" style="color: #7C3AED; font-weight: 600; text-decoration: none;">{{ $trip->name }}</a>
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            <span>{{ $editing ? 'Edit Expense' : 'Tambah Expense' }}</span>
        </div>

        <div style="max-width: 720px;">
            <div style="margin-bottom: 28px;">
                <h1 style="font-size: 26px; font-weight: 800; color: #1F1147; letter-spacing: -0.5px; margin: 0 0 6px;">{{ $editing ? 'Edit Expense' : 'Tambah Expense' }}</h1>
                <p style="color: #6B7280; font-size: 14px; margin: 0;">Catat pengeluaran untuk trip <strong>{{ $trip->name }}</strong>.</p>
            </div>

            @if ($errors->any())
                <div class="alert-error" style="margin-bottom: 20px;">
                    <ul style="margin: 0; padding-left: 16px; list-style: disc; font-size: 13px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ $editing ? route('expenses.update', [$trip, $expense]) : route('expenses.store', $trip) }}"
                x-data="expenseForm({{ Illuminate\Support\Js::from($formConfig) }})"
                @submit="beforeSubmit"
                id="expense-form">
                @csrf
                @if ($editing)
                    @method('PUT')
                @endif

                <!-- ── SECTION 1: Info Dasar ── -->
                <div class="card" style="padding: 28px; margin-bottom: 20px;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 24px;">
                        <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #7C3AED, #4F46E5); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <span style="color: white; font-weight: 800; font-size: 13px;">1</span>
                        </div>
                        <h2 style="font-size: 15px; font-weight: 700; color: #1F1147; margin: 0;">Info Pengeluaran</h2>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div style="grid-column: 1 / -1;">
                            <label class="form-label" for="expense-title">Nama Pengeluaran</label>
                            <input id="expense-title" type="text" name="title" value="{{ old('title', $editing ? $expense->title : '') }}" required
                                class="form-input" placeholder="cth: Sewa motor, Makan siang, dll">
                        </div>

                        <div>
                            <label class="form-label" for="expense-amount">Total Nominal (Rp)</label>
                            <div style="position: relative;">
                                <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); font-size: 13px; font-weight: 600; color: #9CA3AF;">Rp</span>
                                <input id="expense-amount" type="number" step="0.01" name="total_amount"
                                    x-model.number="totalAmount" required
                                    class="form-input" style="padding-left: 40px;"
                                    placeholder="0">
                            </div>
                        </div>

                        <div>
                            <label class="form-label" for="expense-date">Tanggal (opsional)</label>
                            <input id="expense-date" type="date" name="expense_date" value="{{ old('expense_date', $editing ? $expense->expense_date?->format('Y-m-d') : '') }}"
                                class="form-input">
                        </div>

                        <div style="grid-column: 1 / -1;">
                            <label class="form-label" for="expense-notes">Catatan (opsional)</label>
                            <textarea id="expense-notes" name="notes" rows="2"
                                class="form-input" style="resize: vertical;"
                                placeholder="Catatan tambahan...">{{ old('notes', $editing ? $expense->notes : '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- ── SECTION 2: Siapa yang Bayar ── -->
                <div class="card" style="padding: 28px; margin-bottom: 20px;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 24px;">
                        <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #7C3AED, #4F46E5); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <span style="color: white; font-weight: 800; font-size: 13px;">2</span>
                        </div>
                        <h2 style="font-size: 15px; font-weight: 700; color: #1F1147; margin: 0;">Siapa yang Bayar?</h2>
                    </div>

                    <template x-for="(payer, index) in payers" :key="index">
                        <div style="display: flex; gap: 12px; margin-bottom: 12px; align-items: flex-start;">
                            <div style="flex: 1;">
                                <select :name="'payers[' + index + '][trip_member_id]'" x-model="payer.trip_member_id" required class="form-input">
                                    <option value="">-- Pilih Anggota --</option>
                                    <template x-for="member in members" :key="member.id">
                                        <option :value="member.id" x-text="member.name"></option>
                                    </template>
                                </select>
                            </div>
                            <div style="flex: 1; position: relative;">
                                <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); font-size: 13px; font-weight: 600; color: #9CA3AF; pointer-events: none;">Rp</span>
                                <input type="number" step="0.01" :name="'payers[' + index + '][amount_paid]'"
                                    x-model.number="payer.amount_paid" placeholder="Nominal dibayar" required
                                    class="form-input" style="padding-left: 40px;">
                            </div>
                            <button type="button" @click="removePayer(index)" x-show="payers.length > 1"
                                style="width: 40px; height: 42px; background: #FEF2F2; border: 1.5px solid #FEE2E2; border-radius: 10px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #DC2626; flex-shrink: 0; transition: all 0.15s;"
                                onmouseover="this.style.background='#FEE2E2'" onmouseout="this.style.background='#FEF2F2'">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="pointer-events: none;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            </button>
                        </div>
                    </template>

                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-top: 8px;">
                        <button type="button" @click="addPayer()"
                            style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; color: #7C3AED; background: #F5F3FF; border: 1.5px solid #DDD6FE; border-radius: 8px; cursor: pointer; padding: 8px 14px; font-family: 'Plus Jakarta Sans', sans-serif; transition: all 0.15s;" onmouseover="this.style.background='#EDE9FE'" onmouseout="this.style.background='#F5F3FF'">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="pointer-events: none; flex-shrink: 0;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Tambah Payer
                        </button>
                        <div :class="payersTotalMatches ? 'payer-ok' : 'payer-err'"
                            style="font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 8px; transition: all 0.2s;">
                            <svg x-show="payersTotalMatches" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                            <svg x-show="!payersTotalMatches" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            Total: Rp<span x-text="formatNumber(payersTotal)"></span>
                            <span style="opacity: 0.6;">/ Rp<span x-text="formatNumber(totalAmount)"></span></span>
                        </div>
                    </div>
                </div>

                <!-- ── SECTION 3: Siapa yang Ikut ── -->
                <div class="card" style="padding: 28px; margin-bottom: 24px;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                        <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #7C3AED, #4F46E5); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <span style="color: white; font-weight: 800; font-size: 13px;">3</span>
                        </div>
                        <h2 style="font-size: 15px; font-weight: 700; color: #1F1147; margin: 0;">Siapa yang Ikut Menanggung?</h2>
                    </div>

                    <!-- Split method selector -->
                    <div style="display: flex; gap: 8px; margin-bottom: 24px; flex-wrap: wrap; padding: 8px 0;">
                        <label style="flex: 1; min-width: 100px; cursor: pointer;">
                            <input type="radio" x-model="splitMethod" value="equal" name="split_method" style="display: none;">
                            <div :class="splitMethod === 'equal' ? 'split-tab active' : 'split-tab'" style="text-align: center; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; border: 1.5px solid; cursor: pointer; transition: all 0.15s; user-select: none;">
                                <div>⚖️</div>
                                <div style="margin-top: 4px;">Rata</div>
                            </div>
                        </label>
                        <label style="flex: 1; min-width: 100px; cursor: pointer;">
                            <input type="radio" x-model="splitMethod" value="custom_amount" name="split_method" style="display: none;">
                            <div :class="splitMethod === 'custom_amount' ? 'split-tab active' : 'split-tab'" style="text-align: center; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; border: 1.5px solid; cursor: pointer; transition: all 0.15s; user-select: none;">
                                <div>✏️</div>
                                <div style="margin-top: 4px;">Custom</div>
                            </div>
                        </label>
                        <label style="flex: 1; min-width: 100px; cursor: pointer;">
                            <input type="radio" x-model="splitMethod" value="percentage" name="split_method" style="display: none;">
                            <div :class="splitMethod === 'percentage' ? 'split-tab active' : 'split-tab'" style="text-align: center; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; border: 1.5px solid; cursor: pointer; transition: all 0.15s; user-select: none;">
                                <div>%</div>
                                <div style="margin-top: 4px;">Persentase</div>
                            </div>
                        </label>
                    </div>

                    <!-- Participants list -->
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <template x-for="(participant, index) in participants" :key="participant.trip_member_id">
                            <div :class="participant.selected ? 'participant-row selected' : 'participant-row'"
                                style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; border: 1.5px solid; transition: all 0.15s; cursor: pointer;"
                                @click="participant.selected = !participant.selected">

                                <template x-if="participant.selected">
                                    <input type="hidden" :name="'participants[' + index + '][trip_member_id]'" :value="participant.trip_member_id">
                                </template>

                                <!-- Avatar -->
                                <div style="width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; flex-shrink: 0; transition: all 0.15s;"
                                    :style="participant.selected ? 'background: linear-gradient(135deg, #7C3AED, #4F46E5); color: white;' : 'background: #F3F4F6; color: #6B7280;'"
                                    x-text="participant.name.charAt(0).toUpperCase()"></div>

                                <span style="flex: 1; font-size: 14px; font-weight: 500; color: #374151;" x-text="participant.name"></span>

                                <!-- Custom amount input -->
                                <template x-if="participant.selected && splitMethod === 'custom_amount'">
                                    <div style="position: relative;" @click.stop>
                                        <span style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); font-size: 12px; color: #9CA3AF; font-weight: 600;">Rp</span>
                                        <input type="number" step="0.01" :name="'participants[' + index + '][share_amount]'"
                                            x-model.number="participant.share_amount" placeholder="Nominal"
                                            class="form-input" style="width: 140px; padding-left: 34px; font-size: 13px; padding-top: 8px; padding-bottom: 8px;">
                                    </div>
                                </template>

                                <!-- Percentage input -->
                                <template x-if="participant.selected && splitMethod === 'percentage'">
                                    <div style="position: relative;" @click.stop>
                                        <input type="number" step="0.01" max="100" :name="'participants[' + index + '][share_percentage]'"
                                            x-model.number="participant.share_percentage" placeholder="0"
                                            class="form-input" style="width: 100px; padding-right: 32px; font-size: 13px; padding-top: 8px; padding-bottom: 8px;">
                                        <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); font-size: 12px; color: #9CA3AF; font-weight: 600;">%</span>
                                    </div>
                                </template>

                                <!-- Equal share display -->
                                <template x-if="participant.selected && splitMethod === 'equal'">
                                    <span style="font-size: 13px; font-weight: 700; color: #7C3AED;" x-text="'Rp ' + formatNumber(equalShare)"></span>
                                </template>

                                <!-- Checkbox indicator -->
                                <div style="width: 20px; height: 20px; border-radius: 6px; border: 2px solid; display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: all 0.15s;"
                                    :style="participant.selected ? 'background: #7C3AED; border-color: #7C3AED;' : 'background: white; border-color: #D1D5DB;'">
                                    <svg x-show="participant.selected" width="11" height="11" fill="none" stroke="white" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Validation totals -->
                    <div style="margin-top: 12px;">
                        <div x-show="splitMethod === 'custom_amount'"
                            :class="customTotalMatches ? 'payer-ok' : 'payer-err'"
                            style="font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 8px;">
                            Total porsi: Rp<span x-text="formatNumber(customTotal)"></span> / Rp<span x-text="formatNumber(totalAmount)"></span>
                        </div>
                        <div x-show="splitMethod === 'percentage'"
                            :class="percentageTotalMatches ? 'payer-ok' : 'payer-err'"
                            style="font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 8px;">
                            Total: <span x-text="percentageTotal"></span>% / 100%
                        </div>
                    </div>
                </div>

                <!-- Submit buttons -->
                <div style="display: flex; gap: 12px;">
                    <button type="submit" class="btn-primary" id="save-expense-btn" style="flex: 1; justify-content: center; padding: 13px;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        {{ $editing ? 'Simpan Perubahan' : 'Simpan Expense' }}
                    </button>
                    <a href="{{ route('trips.show', $trip) }}" class="btn-secondary" style="flex: 1; justify-content: center; padding: 13px;">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <style>
            .split-tab {
                border-color: #E5E7EB;
                color: #6B7280;
                background: #FAFAFA;
            }
            .split-tab.active, .split-tab:hover {
                border-color: #7C3AED;
                color: #7C3AED;
                background: #F5F3FF;
            }
            .participant-row {
                border-color: #E5E7EB;
                background: #FAFAFA;
            }
            .participant-row.selected {
                border-color: #C4B5FD;
                background: #F5F3FF;
            }
            .participant-row:hover {
                border-color: #C4B5FD;
            }
            .payer-ok {
                background: #ECFDF5;
                color: #059669;
            }
            .payer-err {
                background: #FEF2F2;
                color: #DC2626;
            }
            @media (max-width: 580px) {
                div[style*="grid-template-columns: 1fr 1fr"] {
                    grid-template-columns: 1fr !important;
                }
            }
        </style>

        {{-- Logic Alpine.data('expenseForm') sudah dipindahkan ke resources/js/app.js
             agar terdaftar SEBELUM Alpine.start() dipanggil. --}}
    </div>
</x-app-layout>

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Daftarkan semua Alpine.data components di sini, SEBELUM Alpine.start()
// agar tersedia saat Alpine memproses DOM.

Alpine.data('expenseForm', (config) => ({
    members: config.members,
    totalAmount: Number(config.totalAmount ?? 0),
    splitMethod: config.splitMethod ?? 'equal',
    payers: (config.payers?.length ? config.payers : [{ trip_member_id: '', amount_paid: '' }])
        .map(p => ({ ...p, trip_member_id: String(p.trip_member_id) })),
    participants: config.members.map(m => {
        const saved = (config.participants ?? []).find(p => String(p.trip_member_id) === String(m.id));
        return {
            trip_member_id: m.id,
            name: m.name,
            selected: Boolean(saved),
            share_amount: saved?.share_amount ?? '',
            share_percentage: saved?.share_percentage ?? '',
        };
    }),

    addPayer() {
        this.payers.push({ trip_member_id: '', amount_paid: '' });
    },
    removePayer(index) {
        this.payers.splice(index, 1);
    },

    get payersTotal() {
        return this.payers.reduce((sum, p) => sum + (parseFloat(p.amount_paid) || 0), 0);
    },
    get payersTotalMatches() {
        return this.totalAmount > 0 && Math.abs(this.payersTotal - this.totalAmount) < 0.01;
    },
    get selectedParticipants() {
        return this.participants.filter(p => p.selected);
    },
    get equalShare() {
        const count = this.selectedParticipants.length;
        return count > 0 ? this.totalAmount / count : 0;
    },
    get customTotal() {
        return this.selectedParticipants.reduce((sum, p) => sum + (parseFloat(p.share_amount) || 0), 0);
    },
    get customTotalMatches() {
        return this.totalAmount > 0 && Math.abs(this.customTotal - this.totalAmount) < 0.01;
    },
    get percentageTotal() {
        return this.selectedParticipants.reduce((sum, p) => sum + (parseFloat(p.share_percentage) || 0), 0);
    },
    get percentageTotalMatches() {
        return Math.abs(this.percentageTotal - 100) < 0.01;
    },
    formatNumber(n) {
        return new Intl.NumberFormat('id-ID').format(n || 0);
    },
    beforeSubmit(e) {
        if (this.selectedParticipants.length === 0) {
            alert('Pilih minimal 1 participant.');
            e.preventDefault();
            return;
        }
        if (!this.payersTotalMatches) {
            alert('Total nominal payer harus sama dengan total expense.');
            e.preventDefault();
            return;
        }
        if (this.splitMethod === 'custom_amount' && !this.customTotalMatches) {
            alert('Total porsi custom harus sama dengan total expense.');
            e.preventDefault();
            return;
        }
        if (this.splitMethod === 'percentage' && !this.percentageTotalMatches) {
            alert('Total persentase harus 100%.');
            e.preventDefault();
            return;
        }
    }
}));

Alpine.start();

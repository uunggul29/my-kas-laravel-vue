<script setup>
import { router, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, watch } from 'vue';
import Swal from 'sweetalert2';

const props = defineProps({
    transactions: {
        type: Array,
        default: () => []
    },
    summary: {
        type: Object,
        default: () => ({ total_masuk: 0, total_keluar: 0, saldo_akhir: 0 })
    },
    errors: Object
});

const form = useForm({
    deskripsi: '',
    nominal: '',
    jenis: 'masuk'
});

const displayNominal = ref('');

// Watcher untuk format ribuan otomatis saat mengetik
watch(displayNominal, (newValue) => {
    let cleanNumber = newValue.replace(/\D/g, '');
    form.nominal = cleanNumber;
    displayNominal.value = cleanNumber ? new Intl.NumberFormat('id-ID').format(cleanNumber) : '';
});

const formatRupiah = (number) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(number || 0);
};

const tambahTransaksi = () => {
    form.post('/kas', {
        onSuccess: () => {
            form.reset();
            displayNominal.value = '';
            Swal.fire({
                title: 'Berhasil!',
                text: 'Transaksi telah dicatat.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        },
        onError: () => {
            Swal.fire({
                title: 'Gagal!',
                text: 'Periksa kembali inputan Anda.',
                icon: 'error',
                confirmButtonColor: '#2563eb'
            });
        },
        preserveScroll: true
    });
};

const hapusTransaksi = (id) => {
    if (!id) return;

    Swal.fire({
        title: 'Yakin hapus?',
        text: "Data akan hilang permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Ya, Hapus!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/kas/${id}`, {
                preserveScroll: true,
                // Inertia akan menangani redirect dari Controller secara otomatis
                onSuccess: () => {
                    Swal.fire({
                        title: 'Terhapus!',
                        icon: 'success',
                        timer: 1000,
                        showConfirmButton: false
                    });
                }
            });
        }
    });
};
</script>

<template>
    <AppLayout>
        <div class="max-w-4xl mx-auto space-y-10 py-4">

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card Pemasukan -->
                <div class="group relative bg-white p-5 rounded-[1.8rem] shadow-lg border border-emerald-50 transition-all hover:shadow-xl">
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-10 h-10 bg-emerald-500 text-white rounded-xl flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-[9px] font-black text-emerald-600/60 uppercase tracking-[0.2em] mb-1">Pemasukan</p>
                            <p class="text-xl font-black text-slate-800 tracking-tight">
                                {{ formatRupiah(summary?.total_masuk) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card Pengeluaran -->
                <div class="group relative bg-white p-5 rounded-[1.8rem] shadow-lg border border-rose-50 transition-all hover:shadow-xl">
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-10 h-10 bg-rose-500 text-white rounded-xl flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-[9px] font-black text-rose-600/60 uppercase tracking-[0.2em] mb-1">Pengeluaran</p>
                            <p class="text-xl font-black text-slate-800 tracking-tight">
                                {{ formatRupiah(summary?.total_keluar) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card Saldo Akhir -->
                <div class="group relative bg-slate-900 p-5 rounded-[1.8rem] shadow-xl overflow-hidden transition-all hover:scale-[1.02]">
                    <div class="absolute -right-4 -bottom-4 w-16 h-16 bg-blue-500/20 rounded-full blur-xl"></div>
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-[9px] font-black text-blue-300 uppercase tracking-[0.2em] mb-1">Saldo Bersih</p>
                            <p class="text-xl font-black text-white italic whitespace-nowrap">
                                {{ formatRupiah(summary?.saldo_akhir) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Input Form -->
            <div class="bg-white rounded-[2.5rem] p-8 shadow-2xl border border-slate-100">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-1.5 h-8 bg-blue-600 rounded-full"></div>
                    <h2 class="text-xl font-black text-slate-800 tracking-tight">Catat Baru</h2>
                </div>
                <form @submit.prevent="tambahTransaksi" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="text-[11px] font-bold text-slate-500 uppercase ml-2">Detail Transaksi</label>
                            <input v-model="form.deskripsi" type="text" placeholder="Gaji, Makan, dll..."
                                class="w-full bg-slate-50 border-slate-100 rounded-2xl py-4 px-5 text-sm outline-none focus:ring-4 focus:ring-blue-100 transition-all">
                            <p v-if="errors?.deskripsi" class="text-rose-500 text-[10px] font-bold ml-2">{{ errors.deskripsi }}</p>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-bold text-slate-500 uppercase ml-2">Nominal (Rp)</label>
                            <input v-model="displayNominal" type="text" inputmode="numeric" placeholder="0"
                                class="w-full bg-slate-50 border-slate-100 rounded-2xl py-4 px-5 text-sm font-bold outline-none focus:ring-4 focus:ring-blue-100 transition-all">
                            <p v-if="errors?.nominal" class="text-rose-500 text-[10px] font-bold ml-2">{{ errors.nominal }}</p>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[11px] font-bold text-slate-500 uppercase ml-2">Kategori</label>
                            <select v-model="form.jenis"
                                class="w-full bg-slate-50 border-slate-100 rounded-2xl py-4 px-5 text-sm font-bold outline-none focus:ring-4 focus:ring-blue-100 transition-all">
                                <option value="masuk">Pemasukan (+)</option>
                                <option value="keluar">Pengeluaran (-)</option>
                            </select>
                        </div>
                    </div>
                    <button :disabled="form.processing"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-5 rounded-2xl shadow-lg transition-all active:scale-[0.98] disabled:opacity-50">
                        {{ form.processing ? 'Sedang Memproses...' : 'Simpan Data' }}
                    </button>
                </form>
            </div>

            <!-- List Section -->
            <div class="space-y-6">
                <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em] ml-2">Arsip Riwayat</h3>
                <div class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-slate-50">
                    <div v-if="transactions && transactions.length > 0" class="divide-y divide-slate-50">
                        <div v-for="t in transactions" :key="t?.id || Math.random()"
                            class="p-6 flex justify-between items-center group hover:bg-slate-50 transition-all">
                            <div class="flex items-center gap-5">
                                <div :class="t?.jenis === 'masuk' ? 'bg-emerald-500 text-white shadow-emerald-200' : 'bg-rose-500 text-white shadow-rose-200'"
                                    class="w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg shrink-0 group-hover:scale-110 transition-transform">
                                    <svg v-if="t?.jenis === 'masuk'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-700 capitalize leading-tight mb-1">
                                        {{ t?.deskripsi || 'Tanpa Deskripsi' }}
                                    </h4>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">
                                        {{ t?.created_at ? new Date(t.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : '-' }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-6">
                                <span :class="t?.jenis === 'masuk' ? 'text-emerald-600' : 'text-rose-600'" class="text-lg font-black tracking-tight">
                                    {{ t?.jenis === 'masuk' ? '+' : '-' }} {{ formatRupiah(t?.nominal).replace('Rp', '').trim() }}
                                </span>
                                <button @click="hapusTransaksi(t.id)"
                                    class="opacity-0 group-hover:opacity-100 p-3 text-slate-300 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div v-else class="py-20 text-center space-y-3">
                        <div class="text-4xl opacity-20 grayscale">📁</div>
                        <p class="text-slate-400 font-bold italic tracking-wide">Belum ada catatan hari ini.</p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

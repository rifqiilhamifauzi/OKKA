<template>
    <Head title="Rekap Data Keuangan - OKKA Admin" />

    <AdminLayout>
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
            <div>
                <h2 class="text-2xl font-bold text-stone-800 font-plus-jakarta-sans">Rekap Data Keuangan</h2>
                <p class="text-stone-600 text-sm mt-1">Laporan estimasi pendapatan dari pendaftar yang telah disetujui (Approved).</p>
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <select v-model="filterForm.event_id" @change="applyFilters" class="block w-full sm:w-48 rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="all">Semua Event Aktif</option>
                    <option v-for="event in allEvents" :key="event.id" :value="event.id">
                        {{ event.name }}
                    </option>
                </select>
                <a :href="`/admin/finances/export?event_id=${filterForm.event_id}`" class="hidden sm:flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export ke Excel
                </a>
                <button @click="printReport" class="hidden sm:flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Laporan
                </button>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl shadow-lg p-6 text-white relative overflow-hidden">
                <div class="absolute right-0 top-0 opacity-10">
                    <svg class="w-32 h-32 -mr-6 -mt-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                </div>
                <p class="text-emerald-100 text-sm font-medium mb-1 relative z-10">Total Estimasi Pendapatan</p>
                <h3 class="text-4xl font-bold font-plus-jakarta-sans relative z-10">{{ formatRupiah(summary.grand_total) }}</h3>
                <p class="text-emerald-200 text-xs mt-2 relative z-10">Berdasarkan pendaftar berstatus 'Approved'</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex flex-col justify-center">
                <div class="flex items-center gap-4">
                    <div class="p-4 bg-blue-50 rounded-full text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-stone-500 text-sm font-medium mb-1">Total Peserta Lolos (Approved)</p>
                        <h3 class="text-3xl font-bold text-stone-900 font-plus-jakarta-sans">{{ summary.total_approved_participants }} <span class="text-base font-normal text-stone-500">orang</span></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Table -->
        <div class="bg-white shadow-sm rounded-lg border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-stone-800 font-plus-jakarta-sans">Rincian per Event</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white text-stone-500 text-sm uppercase tracking-wider border-b border-slate-200">
                            <th class="px-6 py-3 font-medium">Nama Event</th>
                            <th class="px-6 py-3 font-medium">Status Event</th>
                            <th class="px-6 py-3 font-medium text-right">Harga Tiket</th>
                            <th class="px-6 py-3 font-medium text-right">Peserta Lolos</th>
                            <th class="px-6 py-3 font-medium text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-stone-800 divide-y divide-slate-200">
                        <tr v-for="event in eventFinances" :key="event.id" class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-medium text-stone-900">
                                {{ event.name }}
                            </td>
                            <td class="px-6 py-4">
                                <span v-if="event.status === 'active'" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Aktif</span>
                                <span v-else-if="event.status === 'draft'" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-stone-100 text-stone-800">Draft</span>
                                <span v-else class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Selesai</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                {{ event.registration_fee > 0 ? formatRupiah(event.registration_fee) : 'Gratis' }}
                            </td>
                            <td class="px-6 py-4 text-right font-medium text-blue-600">
                                {{ event.approved_count }}
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-stone-900">
                                {{ formatRupiah(event.subtotal) }}
                            </td>
                        </tr>
                        <tr v-if="eventFinances.length === 0">
                            <td colspan="5" class="px-6 py-12 text-center text-stone-500">
                                Belum ada data event.
                            </td>
                        </tr>
                        <tr v-else class="bg-slate-50 font-bold">
                            <td colspan="4" class="px-6 py-4 text-right text-stone-700">Total Keseluruhan</td>
                            <td class="px-6 py-4 text-right text-emerald-600 text-base">{{ formatRupiah(summary.grand_total) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3';
import { onMounted, onUnmounted, reactive } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    eventFinances: Array,
    allEvents: Array,
    summary: Object,
    filters: Object,
});

const filterForm = reactive({
    event_id: props.filters?.event_id || 'all',
});

const applyFilters = () => {
    let params = {};
    if (filterForm.event_id && filterForm.event_id !== 'all') {
        params.event_id = filterForm.event_id;
    }

    router.get('/admin/finances', params, {
        preserveState: true,
        replace: true,
    });
};

const formatRupiah = (number) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    }).format(number);
};

const printReport = () => {
    window.print();
};

let interval = null;
onMounted(() => {
    // Live polling for financial data
    interval = setInterval(() => {
        router.reload({ only: ['eventFinances', 'summary'], preserveScroll: true, preserveState: true });
    }, 10000);
});

onUnmounted(() => {
    if (interval) clearInterval(interval);
});
</script>

<template>
    <Head title="Admin Dashboard - OKKA" />

    <AdminLayout>
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
            <div>
                <h2 class="text-2xl font-bold text-stone-800 font-plus-jakarta-sans">Ikhtisar Pendaftaran</h2>
                <p class="text-stone-600 text-sm mt-1">
                    Data terkini untuk event: <strong>{{ activeEvent ? activeEvent.name : 'Semua Event Aktif' }}</strong>
                </p>
            </div>
            
            <!-- Event Filter -->
            <div class="w-full sm:w-64">
                <select v-model="filterForm.event_id" @change="applyFilters" class="block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="all">Semua Event Aktif</option>
                    <option v-for="event in events" :key="event.id" :value="event.id">
                        {{ event.name }}
                    </option>
                </select>
            </div>
        </div>

        <div v-if="!events || events.length === 0" class="bg-amber-50 border border-amber-200 text-amber-800 p-4 rounded-md mb-6">
            Peringatan: Tidak ada event yang terdaftar saat ini.
        </div>
        
        <div v-else>
            <!-- 4 Metric Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-stone-500 mb-1">Total Pendaftar</p>
                        <p class="text-3xl font-bold text-stone-900 font-plus-jakarta-sans">{{ metrics.total }}</p>
                    </div>
                    <div class="p-3 bg-slate-100 rounded-full text-stone-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
                <!-- Pending -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 flex items-center justify-between border-b-4 border-b-amber-500">
                    <div>
                        <p class="text-sm font-medium text-stone-500 mb-1">Menunggu Pembayaran</p>
                        <p class="text-3xl font-bold text-amber-600 font-plus-jakarta-sans">{{ metrics.pending }}</p>
                    </div>
                    <div class="p-3 bg-amber-50 rounded-full text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <!-- Paid -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 flex items-center justify-between border-b-4 border-b-blue-500">
                    <div>
                        <p class="text-sm font-medium text-stone-500 mb-1">Menunggu Verifikasi</p>
                        <p class="text-3xl font-bold text-blue-600 font-plus-jakarta-sans">{{ metrics.paid }}</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-full text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                </div>
                <!-- Approved -->
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 flex items-center justify-between border-b-4 border-b-amber-400">
                    <div>
                        <p class="text-sm font-medium text-stone-500 mb-1">Lolos (Approved)</p>
                        <p class="text-3xl font-bold text-amber-500 font-plus-jakarta-sans">{{ metrics.approved }}</p>
                    </div>
                    <div class="p-3 bg-amber-50 rounded-full text-amber-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Recent Registrations Table -->
            <div class="bg-white shadow-sm rounded-lg border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-stone-800 font-plus-jakarta-sans">Pendaftar Terbaru</h3>
                    <a href="/admin/registrations" class="text-sm text-amber-600 hover:text-blue-800 font-medium">Lihat Semua &rarr;</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white text-stone-500 text-sm uppercase tracking-wider border-b border-slate-200">
                                <th class="px-6 py-3 font-medium">No. Daftar</th>
                                <th class="px-6 py-3 font-medium">Nama Peserta</th>
                                <th class="px-6 py-3 font-medium">NIM</th>
                                <th class="px-6 py-3 font-medium">Status</th>
                                <th class="px-6 py-3 font-medium">Tanggal Daftar</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-blue-800 divide-y divide-slate-200">
                            <tr v-for="reg in recentRegistrations" :key="reg.id" class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-medium text-stone-900">{{ reg.registration_number }}</td>
                                <td class="px-6 py-4">{{ reg.user.name }}</td>
                                <td class="px-6 py-4">{{ reg.detail ? reg.detail.identity_number : '-' }}</td>
                                <td class="px-6 py-4">
                                    <span v-if="reg.status === 'pending'" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                        Pending
                                    </span>
                                    <span v-else-if="reg.status === 'paid'" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Paid
                                    </span>
                                    <span v-else-if="reg.status === 'approved'" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-blue-800">
                                        Approved
                                    </span>
                                    <span v-else class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-stone-800">
                                        {{ reg.status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-stone-500">{{ new Date(reg.created_at).toLocaleDateString('id-ID') }}</td>
                            </tr>
                            <tr v-if="recentRegistrations.length === 0">
                                <td colspan="5" class="px-6 py-8 text-center text-stone-500">
                                    Belum ada pendaftar untuk saat ini.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3';
import { onMounted, onUnmounted, reactive } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    events: Array,
    activeEvent: Object,
    metrics: Object,
    recentRegistrations: Array,
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

    router.get('/admin/dashboard', params, {
        preserveState: true,
        replace: true,
    });
};

let interval = null;

onMounted(() => {
    // Live update every 10 seconds
    interval = setInterval(() => {
        router.reload({ only: ['metrics', 'recentRegistrations'], preserveScroll: true, preserveState: true });
    }, 10000);
});

onUnmounted(() => {
    if (interval) clearInterval(interval);
});
</script>

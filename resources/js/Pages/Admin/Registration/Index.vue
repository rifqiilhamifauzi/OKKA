<template>
    <Head title="Manajemen Registrasi - OKKA Admin" />

    <AdminLayout>
        <div class="mb-6 flex justify-between items-end">
            <div>
                <h2 class="text-2xl font-bold text-stone-800 font-plus-jakarta-sans">Daftar Registrasi</h2>
                <p class="text-stone-600 text-sm mt-1">Kelola pendaftaran peserta untuk {{ activeEvent ? activeEvent.name : 'Event Aktif' }}</p>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-lg border border-slate-200 overflow-hidden">
            <!-- Filter & Search Bar -->
            <div class="p-4 border-b border-slate-200 bg-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex gap-2 w-full sm:w-auto">
                    <select v-model="filterForm.event_id" @change="applyFilters" class="block w-full sm:w-48 rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="all">Semua Event Aktif</option>
                        <option v-for="event in events" :key="event.id" :value="event.id">
                            {{ event.name }}
                        </option>
                    </select>
                    <select v-model="filterForm.status" @change="applyFilters" class="block w-full sm:w-48 rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="all">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="w-full sm:w-64">
                    <form @submit.prevent="applyFilters" class="relative">
                        <input type="text" v-model="filterForm.search" placeholder="Cari Nama, NIM, No. Daftar..." class="block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm pl-10">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white text-stone-500 text-sm uppercase tracking-wider border-b border-slate-200">
                            <th class="px-6 py-3 font-medium">No. Daftar</th>
                            <th class="px-6 py-3 font-medium">Nama Event</th>
                            <th class="px-6 py-3 font-medium">Peserta</th>
                            <th class="px-6 py-3 font-medium">NIM</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3 font-medium">Tanggal</th>
                            <th class="px-6 py-3 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-blue-800 divide-y divide-slate-200">
                        <tr v-for="reg in registrations.data" :key="reg.id" class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-medium text-stone-900">{{ reg.registration_number }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-800 border border-blue-100">
                                    {{ reg.event ? reg.event.name : '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-stone-900">{{ reg.user.name }}</div>
                                <div class="text-stone-500 text-xs">{{ reg.user.email }}</div>
                            </td>
                            <td class="px-6 py-4">{{ reg.detail ? reg.detail.identity_number : '-' }}</td>
                            <td class="px-6 py-4">
                                <div class="relative inline-block w-32">
                                    <select 
                                        :value="reg.status" 
                                        @change="updateStatus(reg.id, $event.target.value)"
                                        class="block w-full appearance-none border py-1.5 px-3 pr-8 rounded-lg text-xs font-semibold leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors cursor-pointer shadow-sm"
                                        :class="{
                                            'bg-amber-50 text-amber-800 border-amber-200 focus:border-amber-500 focus:ring-amber-500': reg.status === 'pending',
                                            'bg-blue-50 text-blue-800 border-blue-200 focus:border-blue-500 focus:ring-blue-500': reg.status === 'paid',
                                            'bg-emerald-50 text-emerald-800 border-emerald-200 focus:border-emerald-500 focus:ring-emerald-500': reg.status === 'approved',
                                            'bg-red-50 text-red-800 border-red-200 focus:border-red-500 focus:ring-red-500': reg.status === 'rejected',
                                            'bg-white text-stone-700 border-slate-200 focus:border-blue-500 focus:ring-blue-500': !['pending', 'paid', 'approved', 'rejected'].includes(reg.status)
                                        }"
                                    >
                                        <option value="pending" class="bg-amber-50 text-amber-800 font-medium">Pending</option>
                                        <option value="paid" class="bg-blue-50 text-blue-800 font-medium">Paid</option>
                                        <option value="approved" class="bg-emerald-50 text-emerald-800 font-medium">Approved</option>
                                        <option value="rejected" class="bg-red-50 text-red-800 font-medium">Rejected</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-stone-500" :class="{
                                        'text-amber-800': reg.status === 'pending',
                                        'text-blue-800': reg.status === 'paid',
                                        'text-emerald-800': reg.status === 'approved',
                                        'text-red-800': reg.status === 'rejected'
                                    }">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-stone-500">{{ new Date(reg.created_at).toLocaleDateString('id-ID') }}</td>
                            <td class="px-6 py-4 text-right flex justify-end gap-2 items-center">
                                <button @click="openProofModal(reg.payment_proof)" class="text-indigo-600 hover:text-white font-medium bg-indigo-50 hover:bg-indigo-600 px-3 py-1.5 rounded border border-indigo-100 transition-colors">Lihat Bukti</button>
                                <a :href="`/admin/registrations/${reg.id}`" class="text-amber-600 hover:text-stone-800 font-medium bg-amber-50 hover:bg-amber-100 px-3 py-1.5 rounded border border-amber-100 transition-colors">Detail</a>
                                <button @click="deleteRegistration(reg.id)" class="text-red-600 hover:text-white font-medium bg-red-50 hover:bg-red-600 px-3 py-1.5 rounded border border-red-100 transition-colors">Hapus</button>
                            </td>
                        </tr>
                        <tr v-if="registrations.data.length === 0">
                            <td colspan="7" class="px-6 py-12 text-center text-stone-500">
                                Tidak ada data pendaftaran yang ditemukan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex justify-between items-center" v-if="registrations.links && registrations.links.length > 3">
                <div class="text-sm text-stone-500">
                    Menampilkan <span class="font-medium">{{ registrations.from || 0 }}</span> sampai <span class="font-medium">{{ registrations.to || 0 }}</span> dari <span class="font-medium">{{ registrations.total }}</span> hasil
                </div>
                <div class="flex gap-1">
                    <template v-for="(link, i) in registrations.links" :key="i">
                        <a v-if="link.url" :href="link.url" class="px-3 py-1 border rounded text-sm transition" :class="{'bg-amber-600 text-white border-amber-600': link.active, 'bg-white text-stone-600 border-slate-300 hover:bg-slate-100': !link.active}" v-html="link.label"></a>
                        <span v-else class="px-3 py-1 border border-slate-200 bg-slate-50 text-stone-400 rounded text-sm" v-html="link.label"></span>
                    </template>
                </div>
            </div>
        </div>

        <!-- Proof Modal -->
        <div v-if="showProofModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-sm" @click.self="closeProofModal">
            <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full overflow-hidden flex flex-col max-h-[90vh]">
                <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                    <h3 class="font-bold text-stone-800 text-lg">Bukti Pembayaran</h3>
                    <button @click="closeProofModal" class="text-stone-400 hover:text-red-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-6 overflow-y-auto flex-1 flex justify-center items-center bg-slate-100">
                    <img v-if="selectedProofUrl" :src="selectedProofUrl" alt="Bukti Pembayaran" class="max-w-full max-h-[70vh] object-contain rounded shadow-sm border border-slate-200">
                    <div v-else class="text-stone-500 italic">Bukti pembayaran tidak tersedia.</div>
                </div>
                <div class="p-4 border-t border-slate-100 bg-slate-50 flex justify-end">
                    <button @click="closeProofModal" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg font-medium hover:bg-slate-300 transition-colors">Tutup</button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3';
import { reactive, watch, ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

import { onMounted, onUnmounted } from 'vue';

const props = defineProps({
    registrations: Object,
    filters: Object,
    activeEvent: Object,
    events: Array,
});

const filterForm = reactive({
    search: props.filters.search || '',
    status: props.filters.status || 'all',
    event_id: props.filters.event_id || 'all',
});

const applyFilters = () => {
    let params = {};
    if (filterForm.search) params.search = filterForm.search;
    if (filterForm.status && filterForm.status !== 'all') params.status = filterForm.status;
    if (filterForm.event_id && filterForm.event_id !== 'all') params.event_id = filterForm.event_id;

    router.get('/admin/registrations', params, {
        preserveState: true,
        replace: true,
    });
};

// Optional: Auto search on type (debounce can be added for better perf)
let searchTimeout;
watch(() => filterForm.search, () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        applyFilters();
    }, 500);
});

let interval = null;

onMounted(() => {
    // Live update every 10 seconds, only refreshing the 'registrations' prop
    interval = setInterval(() => {
        router.reload({ only: ['registrations'], preserveScroll: true, preserveState: true });
    }, 10000);
});

onUnmounted(() => {
    if (interval) clearInterval(interval);
});

const deleteRegistration = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus data pendaftaran ini? Tindakan ini tidak dapat dibatalkan.')) {
        router.delete(`/admin/registrations/${id}`, {
            preserveScroll: true,
            onSuccess: () => {
                // Optionally show a notification here
            }
        });
    }
};

const updateStatus = (id, newStatus) => {
    if (confirm(`Apakah Anda yakin ingin mengubah status pendaftar ini menjadi ${newStatus.toUpperCase()}?`)) {
        router.patch(`/admin/registrations/${id}/status`, {
            status: newStatus
        }, {
            preserveScroll: true,
        });
    }
};

const showProofModal = ref(false);
const selectedProofUrl = ref(null);

const openProofModal = (proofPath) => {
    if (proofPath) {
        selectedProofUrl.value = `/storage/${proofPath}`;
        showProofModal.value = true;
    } else {
        alert('Bukti pembayaran belum diunggah untuk pendaftar ini.');
    }
};

const closeProofModal = () => {
    showProofModal.value = false;
    selectedProofUrl.value = null;
};
</script>

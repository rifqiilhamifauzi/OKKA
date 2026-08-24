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
                                <div class="font-medium text-stone-900">{{ reg.user.name }}</div>
                                <div class="text-stone-500 text-xs">{{ reg.user.email }}</div>
                            </td>
                            <td class="px-6 py-4">{{ reg.detail ? reg.detail.identity_number : '-' }}</td>
                            <td class="px-6 py-4">
                                <span v-if="reg.status === 'pending'" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Pending</span>
                                <span v-else-if="reg.status === 'paid'" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Paid</span>
                                <span v-else-if="reg.status === 'approved'" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Approved</span>
                                <span v-else-if="reg.status === 'rejected'" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejected</span>
                                <span v-else class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-stone-800">{{ reg.status }}</span>
                            </td>
                            <td class="px-6 py-4 text-stone-500">{{ new Date(reg.created_at).toLocaleDateString('id-ID') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a :href="`/admin/registrations/${reg.id}`" class="text-amber-600 hover:text-stone-800 font-medium bg-amber-50 px-3 py-1 rounded border border-amber-100">Detail</a>
                            </td>
                        </tr>
                        <tr v-if="registrations.data.length === 0">
                            <td colspan="6" class="px-6 py-12 text-center text-stone-500">
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
    </AdminLayout>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3';
import { reactive, watch } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    registrations: Object,
    filters: Object,
    activeEvent: Object,
});

const filterForm = reactive({
    search: props.filters.search || '',
    status: props.filters.status || 'all',
});

const applyFilters = () => {
    let params = {};
    if (filterForm.search) params.search = filterForm.search;
    if (filterForm.status && filterForm.status !== 'all') params.status = filterForm.status;

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
</script>

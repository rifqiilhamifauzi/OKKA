<template>
    <Head title="Riwayat Update - OKKA Admin" />

    <AdminLayout>
        <div class="mb-6 flex justify-between items-end">
            <div>
                <h2 class="text-2xl font-bold text-stone-800 font-plus-jakarta-sans">Riwayat Update</h2>
                <p class="text-stone-600 text-sm mt-1">Pantau seluruh aktivitas dan perubahan yang dilakukan oleh Admin.</p>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-lg border border-slate-200 overflow-hidden">
            <!-- Filter & Search Bar -->
            <div class="p-4 border-b border-slate-200 bg-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="w-full sm:w-64 ml-auto">
                    <form @submit.prevent="applyFilters" class="relative">
                        <input type="text" v-model="filterForm.search" placeholder="Cari aksi, deskripsi, admin..." class="block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm pl-10">
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
                            <th class="px-6 py-3 font-medium">Waktu</th>
                            <th class="px-6 py-3 font-medium">Admin</th>
                            <th class="px-6 py-3 font-medium">Aksi</th>
                            <th class="px-6 py-3 font-medium">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-blue-800 divide-y divide-slate-200">
                        <tr v-for="log in logs.data" :key="log.id" class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-stone-500 whitespace-nowrap">
                                {{ new Date(log.created_at).toLocaleString('id-ID') }}
                            </td>
                            <td class="px-6 py-4 font-medium text-stone-900">
                                {{ log.user ? log.user.name : 'Sistem/Tidak Diketahui' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" :class="getActionBadgeColor(log.action)">
                                    {{ log.action }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-stone-600">
                                {{ log.description }}
                            </td>
                        </tr>
                        <tr v-if="logs.data.length === 0">
                            <td colspan="4" class="px-6 py-12 text-center text-stone-500">
                                Belum ada riwayat aktivitas yang tercatat.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex justify-between items-center" v-if="logs.links && logs.links.length > 3">
                <div class="text-sm text-stone-500">
                    Menampilkan <span class="font-medium">{{ logs.from || 0 }}</span> sampai <span class="font-medium">{{ logs.to || 0 }}</span> dari <span class="font-medium">{{ logs.total }}</span> hasil
                </div>
                <div class="flex gap-1">
                    <template v-for="(link, i) in logs.links" :key="i">
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
import { reactive, watch, onMounted, onUnmounted } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    logs: Object,
    filters: Object,
});

const filterForm = reactive({
    search: props.filters.search || '',
});

const applyFilters = () => {
    let params = {};
    if (filterForm.search) params.search = filterForm.search;

    router.get('/admin/activity-logs', params, {
        preserveState: true,
        replace: true,
    });
};

let searchTimeout;
watch(() => filterForm.search, () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        applyFilters();
    }, 500);
});

// Auto refresh live data every 10 seconds
let interval = null;
onMounted(() => {
    interval = setInterval(() => {
        router.reload({ only: ['logs'], preserveScroll: true, preserveState: true });
    }, 10000);
});
onUnmounted(() => {
    if (interval) clearInterval(interval);
});

// Helper for UI badges
const getActionBadgeColor = (action) => {
    const act = action.toLowerCase();
    if (act.includes('create') || act.includes('store')) return 'bg-emerald-100 text-emerald-800';
    if (act.includes('delete') || act.includes('destroy')) return 'bg-red-100 text-red-800';
    if (act.includes('update') || act.includes('edit')) return 'bg-amber-100 text-amber-800';
    return 'bg-blue-100 text-blue-800';
};
</script>

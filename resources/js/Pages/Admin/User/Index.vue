<template>
    <Head title="Manajemen Pengguna - OKKA Admin" />

    <AdminLayout>
        <div class="mb-6 flex justify-between items-end">
            <div>
                <h2 class="text-2xl font-bold text-stone-800 font-plus-jakarta-sans">Data Pengguna</h2>
                <p class="text-stone-600 text-sm mt-1">Kelola data seluruh pengguna terdaftar di sistem.</p>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-lg border border-slate-200 overflow-hidden">
            <!-- Filter & Search Bar -->
            <div class="p-4 border-b border-slate-200 bg-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex gap-2 w-full sm:w-auto">
                    <select v-model="filterForm.role" @change="applyFilters" class="block w-full sm:w-48 rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="all">Semua Peran</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="w-full sm:w-64">
                    <form @submit.prevent="applyFilters" class="relative">
                        <input type="text" v-model="filterForm.search" placeholder="Cari Nama atau Email..." class="block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm pl-10">
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
                            <th class="px-6 py-3 font-medium">Nama</th>
                            <th class="px-6 py-3 font-medium">Email</th>
                            <th class="px-6 py-3 font-medium">Peran</th>
                            <th class="px-6 py-3 font-medium">Bergabung Pada</th>
                            <th class="px-6 py-3 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-blue-800 divide-y divide-slate-200">
                        <tr v-for="user in users.data" :key="user.id" class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <img v-if="user.avatar" :src="user.avatar" class="h-8 w-8 rounded-full mr-3 border border-slate-200" :alt="user.name">
                                    <div v-else class="h-8 w-8 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center mr-3 font-bold text-xs uppercase">{{ user.name.charAt(0) }}</div>
                                    <span class="font-medium text-stone-900">{{ user.name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-stone-600">{{ user.email }}</td>
                            <td class="px-6 py-4">
                                <span v-if="user.role === 'admin'" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Admin</span>
                                <span v-else class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">User</span>
                            </td>
                            <td class="px-6 py-4 text-stone-500">{{ new Date(user.created_at).toLocaleDateString('id-ID') }}</td>
                            <td class="px-6 py-4 text-right">
                                <button v-if="user.role !== 'admin'" @click="deleteUser(user.id)" class="text-red-600 hover:text-white font-medium bg-red-50 hover:bg-red-600 px-3 py-1 rounded border border-red-100 transition-colors">
                                    Hapus
                                </button>
                                <span v-else class="text-stone-400 text-xs italic px-3 py-1">Tidak dapat dihapus</span>
                            </td>
                        </tr>
                        <tr v-if="users.data.length === 0">
                            <td colspan="5" class="px-6 py-12 text-center text-stone-500">
                                Tidak ada data pengguna yang ditemukan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex justify-between items-center" v-if="users.links && users.links.length > 3">
                <div class="text-sm text-stone-500">
                    Menampilkan <span class="font-medium">{{ users.from || 0 }}</span> sampai <span class="font-medium">{{ users.to || 0 }}</span> dari <span class="font-medium">{{ users.total }}</span> hasil
                </div>
                <div class="flex gap-1">
                    <template v-for="(link, i) in users.links" :key="i">
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

import { onMounted, onUnmounted } from 'vue';

const props = defineProps({
    users: Object,
    filters: Object,
});

const filterForm = reactive({
    search: props.filters.search || '',
    role: props.filters.role || 'all',
});

const applyFilters = () => {
    let params = {};
    if (filterForm.search) params.search = filterForm.search;
    if (filterForm.role && filterForm.role !== 'all') params.role = filterForm.role;

    router.get('/admin/users', params, {
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

let interval = null;

onMounted(() => {
    // Live update every 10 seconds, only refreshing the 'users' prop
    interval = setInterval(() => {
        router.reload({ only: ['users'], preserveScroll: true, preserveState: true });
    }, 10000);
});

onUnmounted(() => {
    if (interval) clearInterval(interval);
});

const deleteUser = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus data pengguna ini? Semua data pendaftaran terkait juga akan terhapus. Tindakan ini tidak dapat dibatalkan.')) {
        router.delete(`/admin/users/${id}`, {
            preserveScroll: true,
            onSuccess: () => {
                // Notifikasi sukses (bisa ditambahkan jika ada komponen toast)
            },
            onError: (errors) => {
                if (errors.error) {
                    alert(errors.error);
                }
            }
        });
    }
};
</script>

<template>
    <Head title="Manajemen Event - Admin OKKA" />

    <AdminLayout>
        <template #header>
            <h2 class="font-bold text-xl text-stone-800 leading-tight">Manajemen Event</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <!-- Flash Messages -->
                <div v-if="$page.props.flash?.success" class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl shadow-sm text-sm font-medium flex items-center">
                    <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $page.props.flash.success }}
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                    <div class="p-6 bg-white border-b border-slate-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-stone-800">Daftar Event</h3>
                        <button @click="openCreateModal" class="bg-blue-600 hover:bg-blue-700 text-white shadow-md px-4 py-2 rounded-lg font-medium text-sm transition shadow-sm flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Buat Event Baru
                        </button>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-stone-500">
                            <thead class="text-xs text-blue-800 uppercase bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-bold">Nama Event</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Harga</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Jadwal</th>
                                    <th scope="col" class="px-6 py-4 font-bold text-center">Total Pendaftar</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Status</th>
                                    <th scope="col" class="px-6 py-4 font-bold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="event in events" :key="event.id" class="bg-white border-b border-slate-100 hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 font-medium text-stone-900">
                                        {{ event.name }}
                                        <div class="text-xs text-stone-400 font-normal mt-0.5">{{ event.slug }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        Rp {{ Number(event.registration_fee).toLocaleString('id-ID') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs">
                                        {{ new Date(event.start_date).toLocaleDateString('id-ID') }} - 
                                        {{ new Date(event.end_date).toLocaleDateString('id-ID') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="bg-slate-100 text-stone-800 text-xs font-bold px-2.5 py-1 rounded-full border border-slate-200">
                                            {{ event.registrations_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span v-if="event.status === 'active'" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-blue-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                            Aktif
                                        </span>
                                        <span v-else-if="event.status === 'completed'" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                            Selesai
                                        </span>
                                        <span v-else class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-stone-800">
                                            Draft
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end space-x-2">
                                            <button @click="openEditModal(event)" class="text-xs text-stone-600 hover:text-stone-800 font-medium px-2 py-1 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded transition">
                                                Edit
                                            </button>
                                            <button @click="deleteEvent(event.id)" class="text-xs text-red-600 hover:text-red-800 font-medium px-2 py-1 bg-red-50 hover:bg-red-100 rounded transition">
                                                Hapus
                                            </button>
                                            <button v-if="event.status === 'draft' || event.status === 'completed'" @click="updateStatus(event.id, 'active')" class="text-xs text-amber-500 hover:text-blue-800 font-medium px-2 py-1 bg-amber-50 hover:bg-amber-50 rounded transition">
                                                Aktifkan
                                            </button>
                                            <button v-if="event.status === 'active'" @click="updateStatus(event.id, 'completed')" class="text-xs text-blue-600 hover:text-blue-800 font-medium px-2 py-1 bg-blue-50 hover:bg-blue-100 rounded transition">
                                                Selesaikan
                                            </button>
                                            <button v-if="event.status === 'active'" @click="updateStatus(event.id, 'draft')" class="text-xs text-stone-600 hover:text-stone-800 font-medium px-2 py-1 bg-slate-100 hover:bg-slate-200 rounded transition">
                                                Jadikan Draft
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="events.length === 0">
                                    <td colspan="6" class="px-6 py-8 text-center text-stone-500 italic">
                                        Belum ada event yang dibuat.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create/Edit Event Modal -->
        <div v-if="showModal" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Background backdrop -->
            <div class="fixed inset-0 bg-blue-950 bg-opacity-75 transition-opacity" aria-hidden="true" @click="closeModal"></div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <!-- Modal panel -->
                    <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <form @submit.prevent="submitEvent">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-bold text-stone-900 mb-4 font-plus-jakarta-sans" id="modal-title">{{ isEditing ? 'Edit Event' : 'Buat Event Baru' }}</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-blue-800 mb-1">Nama Event</label>
                                    <input v-model="form.name" type="text" class="w-full border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm" placeholder="Contoh: OKKA 2027" required>
                                    <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-blue-800 mb-1">Harga Pendaftaran (Rp)</label>
                                    <input v-model="form.price" type="number" class="w-full border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm" required min="0">
                                    <div v-if="form.errors.price" class="text-red-500 text-xs mt-1">{{ form.errors.price }}</div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-blue-800 mb-1">Tanggal Mulai</label>
                                        <input v-model="form.start_date" type="date" class="w-full border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm" required>
                                        <div v-if="form.errors.start_date" class="text-red-500 text-xs mt-1">{{ form.errors.start_date }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-blue-800 mb-1">Tanggal Selesai</label>
                                        <input v-model="form.end_date" type="date" class="w-full border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm" required>
                                        <div v-if="form.errors.end_date" class="text-red-500 text-xs mt-1">{{ form.errors.end_date }}</div>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-blue-800 mb-1">Deskripsi Singkat (Opsional)</label>
                                    <textarea v-model="form.description" rows="3" class="w-full border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-100">
                            <button type="submit" :disabled="form.processing" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-400 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 transition">
                                {{ isEditing ? 'Simpan Perubahan' : 'Simpan Event' }}
                            </button>
                            <button type="button" @click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-blue-800 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-400 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                                Batal
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    events: Array
});

const showModal = ref(false);
const isEditing = ref(false);
const editId = ref(null);

const form = useForm({
    name: '',
    price: 185000,
    start_date: '',
    end_date: '',
    description: ''
});

const openCreateModal = () => {
    isEditing.value = false;
    editId.value = null;
    form.reset();
    showModal.value = true;
};

const openEditModal = (event) => {
    isEditing.value = true;
    editId.value = event.id;
    form.name = event.name;
    form.price = Number(event.registration_fee);
    // Format dates for input type="date"
    form.start_date = event.start_date ? new Date(event.start_date).toISOString().split('T')[0] : '';
    form.end_date = event.end_date ? new Date(event.end_date).toISOString().split('T')[0] : '';
    form.description = event.description || '';
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    form.reset();
    form.clearErrors();
};

const submitEvent = () => {
    if (isEditing.value) {
        form.put(`/admin/events/${editId.value}`, {
            preserveScroll: true,
            onSuccess: () => closeModal()
        });
    } else {
        form.post('/admin/events', {
            preserveScroll: true,
            onSuccess: () => closeModal()
        });
    }
};

const updateStatus = (id, status) => {
    if (confirm(`Apakah Anda yakin ingin mengubah status event ini menjadi ${status}?`)) {
        router.patch(`/admin/events/${id}/status`, { status: status }, {
            preserveScroll: true
        });
    }
};

const deleteEvent = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus event ini? Data tidak dapat dikembalikan!')) {
        router.delete(`/admin/events/${id}`, {
            preserveScroll: true,
            onError: (errors) => {
                if (errors.error) alert(errors.error);
            }
        });
    }
};
</script>

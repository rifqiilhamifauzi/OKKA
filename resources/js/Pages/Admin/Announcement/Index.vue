<template>
    <Head title="Manajemen Pengumuman - Admin OKKA" />

    <AdminLayout>
        <template #header>
            <h2 class="font-bold text-xl text-stone-800 leading-tight">Manajemen Pengumuman</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
                
                <!-- Form Buat Pengumuman -->
                <div class="w-full md:w-1/3">
                    <div class="bg-white p-6 shadow-sm sm:rounded-xl border border-slate-200 sticky top-6">
                        <h3 class="text-lg font-bold text-stone-800 mb-4">{{ isEditing ? 'Edit Pengumuman' : 'Buat Pengumuman' }}</h3>
                        
                        <div v-if="$page.props.flash?.success" class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-2 rounded-lg text-sm">
                            {{ $page.props.flash.success }}
                        </div>

                        <form @submit.prevent="submitAnnouncement" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-blue-800 mb-1">Judul Pengumuman</label>
                                <input v-model="form.title" type="text" class="w-full border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm" required>
                                <div v-if="form.errors.title" class="text-red-500 text-xs mt-1">{{ form.errors.title }}</div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-blue-800 mb-1">Visibilitas</label>
                                <select v-model="form.visibility" class="w-full border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm text-sm">
                                    <option value="global">Global (Seluruh User)</option>
                                    <option value="participants">Hanya Peserta Terdaftar OKKA</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-blue-800 mb-1">Isi Pengumuman</label>
                                <!-- Simple Rich Text Toolbar -->
                                <div class="border border-slate-300 border-b-0 rounded-t-lg bg-slate-50 p-2 flex space-x-2">
                                    <button type="button" @click="formatText('bold')" class="p-1.5 text-stone-600 hover:bg-slate-200 rounded" title="Bold"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M15.6 11.8c1-.7 1.6-1.8 1.6-2.8a4 4 0 0 0-4-4H7v14h7.4a4.5 4.5 0 0 0 1.2-8.2zM10 7.5h3a1.5 1.5 0 1 1 0 3h-3v-3zm3.4 9H10v-3.5h3.4a1.8 1.8 0 1 1 0 3.5z"/></svg></button>
                                    <button type="button" @click="formatText('italic')" class="p-1.5 text-stone-600 hover:bg-slate-200 rounded" title="Italic"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M10 5v3h2.2l-3.4 8H6v3h8v-3h-2.2l3.4-8H18V5h-8z"/></svg></button>
                                    <button type="button" @click="addLink" class="p-1.5 text-stone-600 hover:bg-slate-200 rounded" title="Link"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg></button>
                                </div>
                                <div ref="editor" contenteditable="true" class="w-full min-h-[150px] border border-slate-300 rounded-b-lg shadow-sm text-sm p-3 focus:outline-none focus:ring-1 focus:ring-amber-400 focus:border-amber-400 bg-white overflow-y-auto" @input="updateContent"></div>
                                <div v-if="form.errors.content" class="text-red-500 text-xs mt-1">{{ form.errors.content }}</div>
                            </div>
                            
                            <div class="flex items-center">
                                <input v-model="form.is_published" id="is_published" type="checkbox" class="rounded border-slate-300 text-amber-500 focus:ring-amber-400">
                                <label for="is_published" class="ml-2 block text-sm text-stone-900">
                                    Langsung Terbitkan *(Publish)*
                                </label>
                            </div>

                            <div class="pt-4 flex gap-2">
                                <button type="submit" :disabled="form.processing" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white shadow-md px-4 py-2 rounded-lg font-bold text-sm transition shadow-sm disabled:opacity-50">
                                    {{ isEditing ? 'Simpan Perubahan' : 'Posting Pengumuman' }}
                                </button>
                                <button v-if="isEditing" type="button" @click="cancelEdit" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-stone-800 rounded-lg text-sm font-medium transition">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Daftar Pengumuman -->
                <div class="w-full md:w-2/3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                            <h3 class="text-lg font-bold text-stone-800">Histori Pengumuman</h3>
                        </div>
                        
                        <div class="divide-y divide-slate-100">
                            <div v-for="announcement in announcements" :key="announcement.id" class="p-6 hover:bg-slate-50 transition relative group">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="text-lg font-bold text-stone-900 font-plus-jakarta-sans">{{ announcement.title }}</h4>
                                        <div class="flex items-center gap-3 mt-1 text-xs text-stone-500">
                                            <span>{{ new Date(announcement.created_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) }}</span>
                                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium" :class="announcement.visibility === 'global' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800'">
                                                {{ announcement.visibility === 'global' ? 'Global' : 'Peserta OKKA' }}
                                            </span>
                                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium" :class="announcement.is_published ? 'bg-amber-50 text-blue-800' : 'bg-slate-200 text-stone-800'">
                                                {{ announcement.is_published ? 'Published' : 'Draft' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button @click="editAnnouncement(announcement)" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <button @click="deleteAnnouncement(announcement.id)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="prose prose-sm prose-stone max-w-none mt-4 text-stone-600" v-html="announcement.content"></div>
                            </div>
                            
                            <div v-if="announcements.length === 0" class="p-12 text-center text-stone-500 italic">
                                Belum ada pengumuman yang dipublikasikan.
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    announcements: Array
});

const editor = ref(null);
const isEditing = ref(false);
const editingId = ref(null);

const form = useForm({
    title: '',
    content: '',
    visibility: 'global',
    is_published: true
});

const formatText = (command) => {
    document.execCommand(command, false, null);
    editor.value.focus();
    updateContent();
};

const addLink = () => {
    const url = prompt('Masukkan URL tautan:');
    if (url) {
        document.execCommand('createLink', false, url);
        editor.value.focus();
        updateContent();
    }
};

const updateContent = () => {
    form.content = editor.value.innerHTML;
};

const editAnnouncement = (announcement) => {
    isEditing.value = true;
    editingId.value = announcement.id;
    form.title = announcement.title;
    form.content = announcement.content;
    form.visibility = announcement.visibility;
    form.is_published = announcement.is_published ? true : false; // ensure boolean
    
    if (editor.value) {
        editor.value.innerHTML = announcement.content;
    }
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

const cancelEdit = () => {
    isEditing.value = false;
    editingId.value = null;
    form.reset();
    if (editor.value) {
        editor.value.innerHTML = '';
    }
};

const submitAnnouncement = () => {
    if (!form.content || form.content === '<br>') {
        form.errors.content = 'Isi pengumuman wajib diisi.';
        return;
    }

    if (isEditing.value) {
        form.put(`/admin/announcements/${editingId.value}`, {
            preserveScroll: true,
            onSuccess: () => cancelEdit()
        });
    } else {
        form.post('/admin/announcements', {
            preserveScroll: true,
            onSuccess: () => cancelEdit()
        });
    }
};

const deleteAnnouncement = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')) {
        router.delete(`/admin/announcements/${id}`, {
            preserveScroll: true
        });
    }
};
</script>

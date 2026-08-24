<template>
    <Head title="Pendaftaran OKKA" />

    <UserLayout>
        <div class="max-w-3xl mx-auto">
            <div class="bg-white p-8 shadow-sm sm:rounded-lg border border-slate-200">
                <div class="mb-8 border-b border-slate-200 pb-4">
                    <h2 class="text-2xl font-bold text-stone-900 font-plus-jakarta-sans">Form Pendaftaran OKKA</h2>
                    <p class="text-stone-600 mt-1">Lengkapi data di bawah ini untuk mendaftar pada {{ activeEvent.name }}.</p>
                </div>

                <div v-if="form.hasErrors" class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-md text-sm">
                    Mohon periksa kembali isian Anda. Ada beberapa data yang tidak valid.
                </div>

                <form @submit.prevent="submit">
                    <div class="space-y-6">
                        
                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-sm font-medium text-blue-800">Nama Lengkap</label>
                            <input type="text" v-model="form.full_name" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <div v-if="form.errors.full_name" class="text-red-500 text-xs mt-1">{{ form.errors.full_name }}</div>
                        </div>

                        <!-- Email (Readonly from user) -->
                        <div>
                            <label class="block text-sm font-medium text-blue-800">Email</label>
                            <input type="text" :value="user.email" disabled class="mt-1 block w-full rounded-md border-slate-300 bg-slate-100 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <!-- NIM -->
                        <div>
                            <label class="block text-sm font-medium text-blue-800">NIM / Nomor Induk Mahasiswa</label>
                            <input type="text" v-model="form.identity_number" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Contoh: 123456789">
                            <div v-if="form.errors.identity_number" class="text-red-500 text-xs mt-1">{{ form.errors.identity_number }}</div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block text-sm font-medium text-blue-800">Jenis Kelamin</label>
                            <select v-model="form.gender" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="" disabled>Pilih jenis kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <div v-if="form.errors.gender" class="text-red-500 text-xs mt-1">{{ form.errors.gender }}</div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tempat Lahir -->
                            <div>
                                <label class="block text-sm font-medium text-blue-800">Tempat Lahir</label>
                                <input type="text" v-model="form.birth_place" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <div v-if="form.errors.birth_place" class="text-red-500 text-xs mt-1">{{ form.errors.birth_place }}</div>
                            </div>
                            
                            <!-- Tanggal Lahir -->
                            <div>
                                <label class="block text-sm font-medium text-blue-800">Tanggal Lahir</label>
                                <input type="date" v-model="form.birth_date" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <div v-if="form.errors.birth_date" class="text-red-500 text-xs mt-1">{{ form.errors.birth_date }}</div>
                            </div>
                        </div>

                        <!-- Nomor HP -->
                        <div>
                            <label class="block text-sm font-medium text-blue-800">Nomor HP / WhatsApp</label>
                            <input type="text" v-model="form.phone" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Contoh: 081234567890">
                            <div v-if="form.errors.phone" class="text-red-500 text-xs mt-1">{{ form.errors.phone }}</div>
                        </div>

                        <!-- Status Pramuka -->
                        <div>
                            <label class="block text-sm font-medium text-blue-800 mb-2">Status Pramuka</label>
                            <div class="flex items-center space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" v-model="form.scout_status" :value="true" class="text-amber-500 focus:ring-amber-400 border-slate-300">
                                    <span class="ml-2 text-sm text-blue-800">Sudah pernah ikut Pramuka</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" v-model="form.scout_status" :value="false" class="text-amber-500 focus:ring-amber-400 border-slate-300">
                                    <span class="ml-2 text-sm text-blue-800">Belum pernah</span>
                                </label>
                            </div>
                            <div v-if="form.errors.scout_status" class="text-red-500 text-xs mt-1">{{ form.errors.scout_status }}</div>
                        </div>

                    </div>

                    <div class="mt-8 pt-5 border-t border-slate-200 flex justify-end gap-3">
                        <a href="/dashboard" class="bg-white py-2 px-4 border border-slate-300 rounded-md shadow-sm text-sm font-medium text-blue-800 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-400">
                            Batal
                        </a>
                        <button type="submit" :disabled="form.processing" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-400 disabled:opacity-50">
                            {{ form.processing ? 'Menyimpan...' : 'Kirim Pendaftaran' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </UserLayout>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import UserLayout from '@/Layouts/UserLayout.vue';

const props = defineProps({
    activeEvent: Object,
    user: Object,
});

const form = useForm({
    full_name: props.user.name,
    identity_number: '',
    gender: '',
    birth_place: '',
    birth_date: '',
    phone: '',
    scout_status: null,
});

const submit = () => {
    form.post('/registration/store');
};
</script>

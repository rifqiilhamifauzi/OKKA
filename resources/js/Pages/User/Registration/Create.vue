<template>
    <Head :title="`Pendaftaran ${activeEvent.name}`" />

    <UserLayout>
        <div class="max-w-3xl mx-auto">
            <div class="bg-white p-8 shadow-sm sm:rounded-lg border border-slate-200">
                <div class="mb-8 border-b border-slate-200 pb-4">
                    <h2 class="text-2xl font-bold text-stone-900 font-plus-jakarta-sans">Form Pendaftaran {{ activeEvent.name }}</h2>
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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Fakultas -->
                            <div>
                                <label class="block text-sm font-medium text-blue-800">Fakultas</label>
                                <input type="text" v-model="form.faculty" list="faculty-list" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Ketik atau pilih fakultas...">
                                <datalist id="faculty-list">
                                    <option v-for="faculty in faculties" :key="faculty" :value="faculty"></option>
                                </datalist>
                                <div v-if="form.errors.faculty" class="text-red-500 text-xs mt-1">{{ form.errors.faculty }}</div>
                            </div>
                            
                            <!-- Jurusan -->
                            <div>
                                <label class="block text-sm font-medium text-blue-800">Jurusan</label>
                                <input type="text" v-model="form.major" list="major-list" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Ketik atau pilih jurusan...">
                                <datalist id="major-list">
                                    <option v-for="major in majors" :key="major" :value="major"></option>
                                </datalist>
                                <div v-if="form.errors.major" class="text-red-500 text-xs mt-1">{{ form.errors.major }}</div>
                            </div>
                        </div>

                        <!-- Ukuran Baju -->
                        <div>
                            <label class="block text-sm font-medium text-blue-800">Ukuran Baju</label>
                            <select v-model="form.tshirt_size" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="" disabled>Pilih ukuran baju</option>
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                                <option value="XXXL">XXXL</option>
                            </select>
                            <div v-if="form.errors.tshirt_size" class="text-red-500 text-xs mt-1">{{ form.errors.tshirt_size }}</div>
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

const faculties = [
    'Fakultas Ushuluddin',
    'Fakultas Tarbiyah dan Keguruan',
    'Fakultas Syariah dan Hukum',
    'Fakultas Dakwah dan Komunikasi',
    'Fakultas Adab dan Humaniora',
    'Fakultas Psikologi',
    'Fakultas Sains dan Teknologi',
    'Fakultas Ilmu Sosial dan Ilmu Politik',
    'Fakultas Ekonomi dan Bisnis Islam'
];

const majors = [
    'Aqidah dan Filsafat Islam',
    'Studi Agama-Agama',
    'Ilmu Al-Qur\'an dan Tafsir',
    'Ilmu Hadits',
    'Tasawuf dan Psikoterapi',
    'Manajemen Pendidikan Islam',
    'Pendidikan Agama Islam',
    'Pendidikan Bahasa Arab',
    'Pendidikan Bahasa Inggris',
    'Pendidikan Matematika',
    'Pendidikan Biologi',
    'Pendidikan Fisika',
    'Pendidikan Kimia',
    'Pendidikan Guru Madrasah Ibtidaiyah',
    'Pendidikan Islam Anak Usia Dini (PIAUD)',
    'Tadris Bahasa Indonesia',
    'Hukum Keluarga',
    'Hukum Ekonomi Syari\'ah',
    'Hukum Tata Negara',
    'Perbandingan Mazhab dan Hukum',
    'Ilmu Hukum',
    'Hukum Pidana Islam',
    'Bimbingan Konseling Islam',
    'Komunikasi dan Penyiaran Islam',
    'Manajemen Dakwah',
    'Pengembangan Masyarakat Islam',
    'Ilmu Komunikasi Jurnalistik',
    'Ilmu Komunikasi Humas',
    'Manajemen Haji dan Umrah',
    'Sejarah Peradaban Islam',
    'Bahasa dan Sastra Arab',
    'Sastra Inggris',
    'Ilmu Perpustakaan dan Informasi Islam',
    'Psikologi',
    'Matematika',
    'Biologi',
    'Fisika',
    'Kimia',
    'Teknik Informatika',
    'Agroteknologi',
    'Teknik Elektro',
    'Teknik Lingkungan',
    'Administrasi Publik',
    'Sosiologi',
    'Ilmu Politik',
    'Akuntansi Syari\'ah',
    'Ekonomi Syari\'ah',
    'Manajemen Keuangan Syari\'ah',
    'Manajemen',
    'Manajemen Industri Halal',
    'Bisnis Digital'
];

const form = useForm({
    event_id: props.activeEvent.id,
    full_name: props.user.name,
    identity_number: '',
    gender: '',
    birth_place: '',
    birth_date: '',
    phone: '',
    scout_status: null,
    faculty: '',
    major: '',
    tshirt_size: '',
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        event_id: props.activeEvent.id,
    })).post('/registration/store');
};
</script>

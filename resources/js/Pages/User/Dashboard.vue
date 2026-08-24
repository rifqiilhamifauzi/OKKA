<template>
    <Head title="Dashboard - OKKA" />

    <UserLayout>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-white border-b border-slate-200">
                <div class="flex items-center">
                    <img v-if="$page.props.auth.user.avatar" :src="$page.props.auth.user.avatar" alt="Avatar" class="h-12 w-12 rounded-full mr-4">
                    <div v-else class="h-12 w-12 rounded-full bg-amber-600 text-white flex items-center justify-center text-xl font-bold mr-4">
                        {{ $page.props.auth.user.name.charAt(0) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-stone-800 font-plus-jakarta-sans">
                            Halo, {{ $page.props.auth.user.name }}!
                        </h2>
                        <p class="text-stone-600 text-sm">Selamat datang di Dashboard OKKA.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Event Lists / Registrations -->
            <div class="md:col-span-2 space-y-6">
                
                <div v-if="$page.props.flash?.success" class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-md text-sm">
                    {{ $page.props.flash.success }}
                </div>
                <div v-if="$page.props.errors?.error" class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-md text-sm">
                    {{ $page.props.errors.error }}
                </div>

                <div v-if="$page.props.activeEvents.length === 0" class="bg-white p-6 shadow-sm sm:rounded-lg border border-slate-200">
                    <h3 class="text-lg font-bold text-stone-800 font-plus-jakarta-sans mb-2">Event OKKA</h3>
                    <p class="text-stone-600 text-sm">Saat ini belum ada periode pendaftaran OKKA yang aktif.</p>
                </div>

                <div v-for="event in $page.props.activeEvents" :key="event.id" class="bg-white p-6 shadow-sm sm:rounded-lg border border-slate-200">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-stone-800 font-plus-jakarta-sans">{{ event.name }}</h3>
                            <p class="text-xs text-stone-500 mt-1">{{ new Date(event.start_date).toLocaleDateString('id-ID') }} s/d {{ new Date(event.end_date).toLocaleDateString('id-ID') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="block text-sm font-bold text-amber-600">Rp {{ Number(event.registration_fee).toLocaleString('id-ID') }}</span>
                        </div>
                    </div>
                    
                    <p v-if="event.description" class="text-sm text-stone-600 mb-4">{{ event.description }}</p>

                    <!-- Belum Daftar -->
                    <div v-if="!$page.props.registrations[event.id]">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-stone-800">
                                Belum Mendaftar
                            </span>
                        </div>
                        <a :href="`/registration/create?event_id=${event.id}`" class="inline-block bg-blue-600 hover:bg-blue-700 text-white shadow-md px-4 py-2 rounded font-medium text-sm transition text-center shadow-sm">
                            Mulai Pendaftaran
                        </a>
                    </div>
                    
                    <!-- Sudah Daftar -->
                    <div v-else>
                        <div class="flex flex-col sm:flex-row gap-4 mb-4 pt-4 border-t border-slate-100">
                            <div>
                                <span class="block text-xs font-semibold text-stone-400 uppercase tracking-wider mb-1">Status</span>
                                <span v-if="$page.props.registrations[event.id].status === 'pending'" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">Menunggu Pembayaran</span>
                                <span v-else-if="$page.props.registrations[event.id].status === 'paid'" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">Verifikasi</span>
                                <span v-else-if="$page.props.registrations[event.id].status === 'approved'" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-amber-100">Lolos</span>
                                <span v-else class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">{{ $page.props.registrations[event.id].status }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-semibold text-stone-400 uppercase tracking-wider mb-1">Nomor Pendaftaran</span>
                                <strong class="text-stone-800 text-sm font-mono">{{ $page.props.registrations[event.id].registration_number }}</strong>
                            </div>
                        </div>
                        
                        <!-- Form Pembayaran Pending -->
                        <div v-if="$page.props.registrations[event.id].status === 'pending'" class="mt-4">
                            <button v-if="activePaymentEventId !== event.id" @click="activePaymentEventId = event.id" class="w-full bg-amber-500 hover:bg-amber-600 text-stone-900 px-4 py-2 rounded font-bold text-sm transition shadow-sm">
                                Lanjut ke Pembayaran
                            </button>
                            
                            <div v-if="activePaymentEventId === event.id" class="bg-amber-50 border border-amber-200 rounded-lg p-4 mt-2">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="font-bold text-amber-800 text-sm">Instruksi Pembayaran Manual</h4>
                                    <button @click="activePaymentEventId = null" class="text-stone-400 hover:text-stone-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                </div>
                                <p class="text-sm text-blue-800 mb-3">Silakan lakukan pembayaran biaya pendaftaran sebesar <strong class="text-stone-900">Rp {{ Number(event.registration_fee).toLocaleString('id-ID') }}</strong> ke rekening berikut:</p>
                                
                                <div class="bg-white p-3 rounded border border-slate-200 mb-3 flex justify-between items-center">
                                    <div>
                                        <span class="block text-xs text-stone-500 uppercase font-bold">Bank BRI</span>
                                        <strong class="text-stone-900 font-mono text-lg tracking-wider">0750 0103 2327 506</strong>
                                        <span class="block text-xs text-stone-500">a.n. MERIS LAUDY FEBRIAN</span>
                                    </div>
                                </div>

                                <p class="text-sm text-blue-800 mb-4">Setelah melakukan transfer, silakan unggah foto bukti transfer Anda di bawah ini:</p>
                                
                                <form @submit.prevent="submitPayment(event.id)" class="space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-blue-800 mb-1">Bukti Transfer (JPG/PNG, Max 2MB)</label>
                                        <input type="file" @change="e => paymentForm.payment_proof = e.target.files[0]" accept="image/jpeg,image/png" class="block w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-amber-100 file:text-amber-700 hover:file:bg-amber-200 border border-slate-200 rounded-md bg-white">
                                        <div v-if="paymentForm.errors.payment_proof" class="text-red-500 text-xs mt-1">{{ paymentForm.errors.payment_proof }}</div>
                                    </div>
                                    
                                    <button type="submit" :disabled="paymentForm.processing" class="w-full inline-flex justify-center items-center bg-amber-500-blue-950 px-4 py-2 rounded font-bold text-sm transition shadow-sm">
                                        <svg v-if="paymentForm.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Unggah Bukti Pembayaran
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Status Paid -->
                        <div v-if="$page.props.registrations[event.id].status === 'paid'" class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="font-bold text-blue-800 text-sm mb-1">Sedang Diverifikasi</h4>
                            <p class="text-sm text-blue-800">Pembayaran Anda sedang kami periksa. Mohon tunggu maksimal 1x24 jam.</p>
                        </div>

                        <!-- Status Approved -->
                        <div v-if="$page.props.registrations[event.id].status === 'approved'" class="mt-4 bg-amber-50 border border-amber-100 rounded-lg p-4">
                            <h4 class="font-bold text-blue-800 text-sm mb-1">Pendaftaran Selesai!</h4>
                            <p class="text-sm text-blue-800">Anda telah resmi terdaftar sebagai peserta OKKA. Nantikan informasi kegiatan selanjutnya.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Announcements Sidebar -->
            <div class="space-y-6">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg border border-slate-200">
                    <h3 class="text-lg font-bold text-stone-800 font-plus-jakarta-sans mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                        Pengumuman
                    </h3>
                    
                    <div class="space-y-4">
                        <div v-for="announcement in $page.props.announcements" :key="announcement.id" class="border-b border-slate-100 pb-4 last:border-0 last:pb-0">
                            <h4 class="font-bold text-stone-900 text-sm">{{ announcement.title }}</h4>
                            <div class="text-xs text-stone-400 mt-1 mb-2">
                                {{ new Date(announcement.created_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) }}
                            </div>
                            <div class="prose prose-sm prose-stone text-stone-600" v-html="announcement.content"></div>
                        </div>

                        <div v-if="$page.props.announcements.length === 0" class="text-stone-500 text-sm italic text-center py-4 bg-slate-50 rounded-lg border border-slate-100">
                            Belum ada pengumuman terbaru.
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 shadow-sm sm:rounded-lg border border-slate-200">
                    <form @submit.prevent="logout">
                        <button type="submit" class="w-full text-red-600 hover:text-red-800 text-sm font-medium transition py-2 hover:bg-red-50 rounded-lg">
                            Keluar dari sistem
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </UserLayout>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import UserLayout from '@/Layouts/UserLayout.vue';

const form = useForm({});
const paymentForm = useForm({
    event_id: null,
    payment_proof: null,
});

const activePaymentEventId = ref(null);

const submitPayment = (eventId) => {
    paymentForm.event_id = eventId;
    paymentForm.post('/payment/upload', {
        preserveScroll: true,
        onSuccess: () => {
            activePaymentEventId.value = null;
            paymentForm.reset();
        }
    });
};

const logout = () => {
    form.post('/logout');
};
</script>

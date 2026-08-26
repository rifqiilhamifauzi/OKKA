<template>
    <Head title="Dashboard - OKKA" />

    <UserLayout>
        <div class="flex flex-col lg:flex-row gap-6 items-start">
            
            <!-- Left Column: Profile Card -->
            <div class="w-full lg:w-1/3 xl:w-1/4">
                <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden sticky top-6">
                    <div class="p-6 text-center border-b border-slate-100 bg-gradient-to-b from-slate-50 to-white">
                        <img v-if="$page.props.auth.user.avatar" :src="$page.props.auth.user.avatar" alt="Avatar" class="h-28 w-28 mx-auto rounded-full shadow-md object-cover border-4 border-white mb-4">
                        <div v-else class="h-28 w-28 mx-auto rounded-full bg-gradient-to-br from-amber-500 to-amber-600 text-white flex items-center justify-center text-5xl font-bold shadow-md border-4 border-white mb-4">
                            {{ $page.props.auth.user.name.charAt(0) }}
                        </div>
                        <h2 class="text-lg font-bold text-stone-800 font-plus-jakarta-sans mb-1 leading-tight">
                            {{ $page.props.auth.user.name }}
                        </h2>
                        <p class="text-stone-500 text-xs">{{ $page.props.auth.user.email }}</p>
                    </div>
                    
                    <div v-if="latestDetail" class="p-5 space-y-4">
                        <div>
                            <span class="block text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                NIM / ID
                            </span>
                            <span class="text-stone-800 font-semibold text-sm">{{ latestDetail.identity_number || '-' }}</span>
                        </div>
                        <div class="w-full h-px bg-slate-100"></div>
                        <div>
                            <span class="block text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                Fakultas
                            </span>
                            <span class="text-stone-800 font-semibold text-sm">{{ latestDetail.faculty || '-' }}</span>
                        </div>
                        <div class="w-full h-px bg-slate-100"></div>
                        <div>
                            <span class="block text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                Jurusan
                            </span>
                            <span class="text-stone-800 font-semibold text-sm">{{ latestDetail.major || '-' }}</span>
                        </div>
                    </div>
                    
                    <!-- Profile Card End -->
                </div>
            </div>

            <!-- Right Column: Content -->
            <div class="w-full lg:w-2/3 xl:w-3/4 space-y-6">
                
                <!-- Event Lists / Registrations -->
            <div class="space-y-6">
                
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
                        <div class="mb-4 bg-slate-50 p-4 rounded-lg flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border border-slate-100">
                            <div>
                                <span class="block text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-1">Status</span>
                                <span v-if="$page.props.registrations[event.id].status === 'pending'" class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">Pending</span>
                                <span v-else-if="$page.props.registrations[event.id].status === 'paid'" class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">Paid</span>
                                <span v-else-if="$page.props.registrations[event.id].status === 'approved'" class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">Approved</span>
                                <span v-else class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-red-100 text-red-800 border border-red-200">Rejected</span>
                            </div>
                            <div class="sm:text-right">
                                <span class="block text-[10px] font-bold text-stone-400 uppercase tracking-widest mb-1">Nomor Pendaftaran</span>
                                <strong class="text-stone-900 text-base font-mono bg-white px-2 py-1 rounded border border-slate-200 inline-block shadow-sm tracking-widest">{{ $page.props.registrations[event.id].registration_number }}</strong>
                            </div>
                        </div>
                        
                        <!-- Form Pembayaran Pending / Rejected -->
                        <div v-if="['pending', 'rejected'].includes($page.props.registrations[event.id].status)" class="mt-4">
                            
                            <div v-if="$page.props.registrations[event.id].status === 'rejected'" class="mb-4 bg-red-50 border border-red-200 rounded-lg p-4">
                                <h4 class="font-bold text-red-800 text-sm mb-1">Pembayaran Ditolak</h4>
                                <p class="text-sm text-red-800">Bukti pembayaran Anda sebelumnya ditolak. Silakan unggah ulang bukti pembayaran yang benar.</p>
                            </div>

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
                                    
                                    <button type="submit" :disabled="paymentForm.processing" class="w-full inline-flex justify-center items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-bold text-sm transition shadow-sm">
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
                            <h4 class="font-bold text-blue-800 text-sm mb-1">Menunggu Keputusan</h4>
                            <p class="text-sm text-blue-800">Pembayaran Anda sedang kami periksa. Mohon tunggu maksimal 1x24 jam untuk Approve/Reject.</p>
                        </div>

                        <!-- Status Approved -->
                        <div v-if="$page.props.registrations[event.id].status === 'approved'" class="mt-4 bg-amber-50 border border-amber-100 rounded-lg p-4">
                            <h4 class="font-bold text-blue-800 text-sm mb-1">Pendaftaran Selesai!</h4>
                            <p class="text-sm text-blue-800">Anda telah resmi terdaftar sebagai peserta OKKA. Nantikan informasi kegiatan selanjutnya.</p>
                        </div>
                    </div>
                </div>
            </div>
            </div> <!-- Close Right Column -->
        </div> <!-- Close Main Flex Container -->
    </UserLayout>
</template>

<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import UserLayout from '@/Layouts/UserLayout.vue';

const page = usePage();

const latestDetail = computed(() => {
    const regs = Object.values(page.props.registrations || {});
    return regs.length > 0 ? regs[0].detail : null;
});

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

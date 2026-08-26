<template>
    <Head :title="`Detail ${registration.user.name} - Admin OKKA`" />

    <AdminLayout>
        <!-- Top Action Bar -->
        <div class="mb-8 bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
            <!-- Decorative Accent -->
            <div class="absolute top-0 left-0 w-1 h-full bg-amber-400"></div>
            
            <div>
                <a href="/admin/registrations" class="text-amber-500 hover:text-blue-800 text-sm font-semibold flex items-center mb-3 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar
                </a>
                <h2 class="text-3xl font-extrabold text-stone-900 font-plus-jakarta-sans tracking-tight">Profil Peserta</h2>
                <div class="flex items-center gap-3 mt-2">
                    <span class="text-stone-500 text-sm font-medium">No. Pendaftaran:</span>
                    <span class="bg-slate-100 text-stone-800 font-mono px-2 py-0.5 rounded text-sm border border-slate-200">{{ registration.registration_number }}</span>
                </div>
            </div>

            <!-- Action Buttons for Status -->
            <div class="flex flex-col sm:flex-row gap-3">
                <span class="text-xs font-bold text-stone-400 uppercase tracking-widest sm:hidden mb-1">Ubah Status:</span>
                <button @click="updateStatus('pending')" :class="registration.status === 'pending' ? 'bg-amber-500 text-white shadow-md shadow-amber-500/20' : 'bg-white text-stone-600 border border-slate-200 hover:bg-slate-50'" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                    Pending
                </button>
                <button @click="updateStatus('paid')" :class="registration.status === 'paid' ? 'bg-blue-500 text-white shadow-md shadow-blue-500/20' : 'bg-white text-stone-600 border border-slate-200 hover:bg-slate-50'" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                    Paid
                </button>
                <button @click="updateStatus('approved')" :class="registration.status === 'approved' ? 'bg-amber-500-blue-950 shadow-md shadow-amber-500/20' : 'bg-white text-stone-600 border border-slate-200 hover:bg-slate-50'" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                    Approve
                </button>
                <button @click="updateStatus('rejected')" :class="registration.status === 'rejected' ? 'bg-red-500 text-white shadow-md shadow-red-500/20' : 'bg-white text-stone-600 border border-slate-200 hover:bg-slate-50'" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                    Reject
                </button>
            </div>
        </div>

        <div v-if="$page.props.flash?.success" class="mb-8 bg-amber-50 border-l-4 border-amber-400 p-4 rounded shadow-sm flex items-center">
            <svg class="w-5 h-5 text-amber-400 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span class="text-blue-800 font-medium text-sm">{{ $page.props.flash.success }}</span>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Left Column: Status & Account -->
            <div class="xl:col-span-1 space-y-8">
                <!-- Premium Status Card -->
                <div class="bg-gradient-to-br from-blue-950 to-blue-900 rounded-2xl shadow-lg p-1 relative overflow-hidden">
                    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI4IiBoZWlnaHQ9IjgiPgo8cmVjdCB3aWR0aD0iOCIgaGVpZ2h0PSI4IiBmaWxsPSIjZmZmIiBmaWxsLW9wYWNpdHk9IjAuMDUiLz4KPHBhdGggZD0iTTAgMEw4IDhaTTAgOEw4IDBaIiBzdHJva2U9IiMwMDAiIHN0cm9rZS1vcGFjaXR5PSIwLjA1Ii8+Cjwvc3ZnPg==')] opacity-20"></div>
                    
                    <div class="bg-blue-950 rounded-xl p-6 relative z-10">
                        <h3 class="text-xs font-bold text-stone-400 uppercase tracking-widest mb-6">Status Pendaftaran</h3>
                        
                        <div class="flex flex-col items-center justify-center py-4">
                            <div class="w-20 h-20 rounded-full flex items-center justify-center mb-4 shadow-inner"
                                 :class="{
                                     'bg-amber-500/20 text-amber-400': registration.status === 'pending',
                                     'bg-blue-500/20 text-blue-400': registration.status === 'paid',
                                     'bg-amber-400/20 text-amber-300': registration.status === 'approved',
                                     'bg-red-500/20 text-red-400': registration.status === 'rejected',
                                 }">
                                <svg v-if="registration.status === 'approved'" class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <svg v-else-if="registration.status === 'pending'" class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <svg v-else-if="registration.status === 'paid'" class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                <svg v-else class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </div>
                            <span class="text-2xl font-extrabold text-white uppercase tracking-wider font-plus-jakarta-sans">{{ registration.status }}</span>
                        </div>
                        
                        <div class="mt-6 pt-6 border-t border-blue-900 text-center">
                            <span class="block text-stone-500 text-xs uppercase tracking-wider mb-1">Tanggal Pendaftaran</span>
                            <span class="text-slate-300 font-medium">{{ new Date(registration.created_at).toLocaleString('id-ID', { dateStyle: 'long', timeStyle: 'short' }) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Account Info -->
                <div class="bg-white p-6 shadow-sm rounded-2xl border border-slate-200">
                    <h3 class="text-xs font-bold text-stone-400 uppercase tracking-widest mb-4">Informasi Akun</h3>
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-stone-400 border border-slate-200">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div>
                            <strong class="block text-stone-900 text-lg font-plus-jakarta-sans leading-tight">{{ registration.user.name }}</strong>
                            <span class="text-stone-500 text-sm">{{ registration.user.email }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Registration Detail -->
            <div class="xl:col-span-2">
                <div class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="text-xl font-bold text-stone-900 font-plus-jakarta-sans">Biodata Formulir</h3>
                        <p class="text-stone-500 text-sm mt-1">Data yang diisi oleh pendaftar saat registrasi.</p>
                    </div>
                    
                    <div v-if="!registration.detail" class="p-12 text-center text-stone-500">
                        <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Data formulir tidak ditemukan atau belum lengkap.
                    </div>
                    <div v-else class="p-8">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            
                            <!-- NIM -->
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <dt class="text-xs font-bold text-stone-400 uppercase tracking-widest mb-1">NIM / Nomor Induk</dt>
                                <dd class="text-stone-900 font-medium text-lg">{{ registration.detail.identity_number }}</dd>
                            </div>
                            
                            <!-- Jenis Kelamin -->
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <dt class="text-xs font-bold text-stone-400 uppercase tracking-widest mb-1">Jenis Kelamin</dt>
                                <dd class="text-stone-900 font-medium flex items-center">
                                    <span v-if="registration.detail.gender === 'L'" class="flex items-center text-blue-700 bg-blue-100 px-3 py-1 rounded-md text-sm"><svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>Laki-laki</span>
                                    <span v-else-if="registration.detail.gender === 'P'" class="flex items-center text-pink-700 bg-pink-100 px-3 py-1 rounded-md text-sm"><svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>Perempuan</span>
                                </dd>
                            </div>

                            <!-- TTL -->
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 md:col-span-2">
                                <dt class="text-xs font-bold text-stone-400 uppercase tracking-widest mb-1">Tempat, Tanggal Lahir</dt>
                                <dd class="text-stone-900 font-medium">
                                    {{ registration.detail.birth_place }}, {{ new Date(registration.detail.birth_date).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) }}
                                </dd>
                            </div>

                            <!-- Fakultas -->
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <dt class="text-xs font-bold text-stone-400 uppercase tracking-widest mb-1">Fakultas</dt>
                                <dd class="text-stone-900 font-medium">{{ registration.detail.faculty || '-' }}</dd>
                            </div>

                            <!-- Jurusan -->
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <dt class="text-xs font-bold text-stone-400 uppercase tracking-widest mb-1">Jurusan</dt>
                                <dd class="text-stone-900 font-medium">{{ registration.detail.major || '-' }}</dd>
                            </div>

                            <!-- Ukuran Baju -->
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <dt class="text-xs font-bold text-stone-400 uppercase tracking-widest mb-1">Ukuran Baju</dt>
                                <dd class="text-stone-900 font-medium font-bold text-amber-600">{{ registration.detail.tshirt_size || '-' }}</dd>
                            </div>

                            <!-- HP -->
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <dt class="text-xs font-bold text-stone-400 uppercase tracking-widest mb-1">Nomor HP / WhatsApp</dt>
                                <dd class="flex items-center gap-3 mt-1">
                                    <span class="text-stone-900 font-medium">{{ registration.detail.phone }}</span>
                                    <a :href="`https://wa.me/${registration.detail.phone.replace(/[^0-9]/g, '').replace(/^0/, '62')}`" target="_blank" class="inline-flex items-center justify-center bg-amber-400 text-stone-900-amber-500 transition shadow-sm shadow-amber-400/30" title="Hubungi via WhatsApp">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    </a>
                                </dd>
                            </div>

                            <!-- Pramuka -->
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <dt class="text-xs font-bold text-stone-400 uppercase tracking-widest mb-1">Status Kepramukaan</dt>
                                <dd class="mt-1">
                                    <span v-if="registration.detail.scout_status" class="inline-flex items-center px-3 py-1 rounded-md text-sm font-semibold bg-amber-50 text-blue-800 border border-amber-100">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Pernah Mengikuti
                                    </span>
                                    <span v-else class="inline-flex items-center px-3 py-1 rounded-md text-sm font-semibold bg-slate-200 text-blue-800 border border-slate-300">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                        Belum Pernah
                                    </span>
                                </dd>
                            </div>

                            <!-- Bukti Pembayaran -->
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 md:col-span-2">
                                <dt class="text-xs font-bold text-stone-400 uppercase tracking-widest mb-2">Bukti Pembayaran</dt>
                                <dd class="mt-1">
                                    <div v-if="registration.payment_proof" class="mt-2">
                                        <a :href="`/storage/${registration.payment_proof}`" target="_blank" class="block max-w-sm overflow-hidden rounded-lg border border-slate-200 shadow-sm hover:shadow-md transition">
                                            <img :src="`/storage/${registration.payment_proof}`" alt="Bukti Pembayaran" class="w-full h-auto object-cover max-h-64 hover:scale-105 transition-transform duration-300">
                                        </a>
                                        <p class="text-xs text-stone-500 mt-2 italic">Klik gambar untuk melihat ukuran penuh</p>
                                    </div>
                                    <div v-else class="text-stone-500 italic text-sm py-2">
                                        Belum ada bukti pembayaran yang diunggah.
                                    </div>
                                </dd>
                            </div>

                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    registration: Object,
});

const updateStatus = (newStatus) => {
    if (confirm(`Apakah Anda yakin ingin mengubah status pendaftar ini menjadi ${newStatus.toUpperCase()}?`)) {
        router.patch(`/admin/registrations/${props.registration.id}/status`, {
            status: newStatus
        }, {
            preserveScroll: true,
        });
    }
};
</script>

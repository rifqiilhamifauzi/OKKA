<template>
    <UserLayout>
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-800 font-plus-jakarta-sans">Riwayat Event</h2>
            <p class="text-slate-500 text-sm mt-1">Daftar event yang telah selesai dan Anda ikuti</p>
        </div>

        <div v-if="historyRegistrations.length === 0" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-700 mb-1 font-plus-jakarta-sans">Belum ada riwayat event</h3>
            <p class="text-slate-500 text-sm max-w-md mx-auto">Anda belum memiliki event yang telah selesai diikuti.</p>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="reg in historyRegistrations" :key="reg.id" class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col group hover:shadow-md transition-shadow">
                <div class="bg-slate-50 px-5 py-4 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                            Selesai
                        </span>
                    </div>
                    <span class="text-xs font-medium text-slate-500">
                        {{ new Date(reg.event.end_date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }}
                    </span>
                </div>
                <div class="p-5 flex-1 flex flex-col">
                    <h3 class="font-bold text-lg text-slate-800 font-plus-jakarta-sans mb-1 line-clamp-2" :title="reg.event.name">
                        {{ reg.event.name }}
                    </h3>
                    <div class="mt-4 pt-4 border-t border-slate-100 mt-auto">
                        <div class="flex flex-col gap-1 text-sm">
                            <span class="text-slate-500 text-xs uppercase tracking-wider font-semibold">Nomor Pendaftaran</span>
                            <span class="font-mono font-bold text-slate-700 tracking-wider bg-slate-100 px-2 py-1 rounded inline-block w-max">{{ reg.registration_number }}</span>
                        </div>
                        <div class="mt-4 flex items-center gap-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Keikutsertaan Disetujui
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>

<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import { usePage } from '@inertiajs/vue3';

defineProps({
    historyRegistrations: {
        type: Array,
        required: true
    }
});
</script>

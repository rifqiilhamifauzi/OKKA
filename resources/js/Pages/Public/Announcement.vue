<template>
    <Head title="Pengumuman OKKA" />

    <PublicLayout>
        <section class="py-24 bg-slate-50 min-h-screen">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-extrabold text-stone-900 font-plus-jakarta-sans mb-4">Pengumuman Terbaru</h1>
                    <p class="text-xl text-stone-600">Dapatkan informasi dan pembaruan resmi terkait OKKA.</p>
                </div>

                <div v-if="announcements.length === 0" class="bg-slate-200 h-64 rounded-xl flex items-center justify-center">
                    <span class="text-stone-500">Belum ada pengumuman saat ini.</span>
                </div>

                <div class="space-y-6">
                    <div v-for="announcement in announcements" :key="announcement.id" class="bg-white p-6 shadow-sm rounded-xl border border-slate-200">
                        <div class="mb-4">
                            <h2 class="text-2xl font-bold text-stone-900 font-plus-jakarta-sans">{{ announcement.title }}</h2>
                            <p class="text-sm text-stone-500 mt-1">{{ new Date(announcement.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}</p>
                        </div>
                        <div v-if="announcement.image" class="mb-6">
                            <img :src="'/storage/' + announcement.image" alt="Announcement Image" class="w-full max-h-96 object-cover rounded-lg shadow-sm">
                        </div>
                        <div class="prose prose-stone max-w-none text-stone-700" v-html="announcement.content"></div>
                    </div>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

defineProps({
    announcements: Array,
});
</script>

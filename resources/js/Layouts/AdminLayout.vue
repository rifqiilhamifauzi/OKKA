<template>
    <div class="min-h-screen bg-slate-100 flex flex-col md:flex-row relative">
        <!-- Mobile Sidebar Overlay -->
        <div v-if="isSidebarOpen" @click="isSidebarOpen = false" class="fixed inset-0 bg-stone-900 bg-opacity-50 z-20 md:hidden transition-opacity"></div>

        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-30 w-64 bg-blue-950 text-slate-300 transform transition-transform duration-300 ease-in-out md:relative md:translate-x-0 flex-shrink-0" :class="{'translate-x-0': isSidebarOpen, '-translate-x-full': !isSidebarOpen}">
            <div class="p-4 bg-blue-950 flex justify-between items-center">
                <h1 class="text-xl font-bold text-white font-plus-jakarta-sans">OKKA Admin</h1>
                <button @click="isSidebarOpen = false" class="text-slate-400 hover:text-white md:hidden">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <nav class="p-4 flex flex-col h-[calc(100vh-60px)] overflow-y-auto">
                <Link href="/admin/dashboard" @click="isSidebarOpen = false" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200" :class="{ 'bg-blue-900 text-white shadow-md': $page.url.startsWith('/admin/dashboard'), 'text-stone-400 hover:bg-blue-900 hover:text-white': !$page.url.startsWith('/admin/dashboard') }">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0 transition-colors duration-200" :class="{ 'text-amber-300': $page.url.startsWith('/admin/dashboard'), 'text-stone-500 group-hover:text-slate-300': !$page.url.startsWith('/admin/dashboard') }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </Link>

                <Link href="/admin/events" @click="isSidebarOpen = false" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 mt-2" :class="{ 'bg-blue-900 text-white shadow-md': $page.url.startsWith('/admin/events'), 'text-stone-400 hover:bg-blue-900 hover:text-white': !$page.url.startsWith('/admin/events') }">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0 transition-colors duration-200" :class="{ 'text-amber-300': $page.url.startsWith('/admin/events'), 'text-stone-500 group-hover:text-slate-300': !$page.url.startsWith('/admin/events') }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Data Event
                </Link>
                
                <Link href="/admin/registrations" @click="isSidebarOpen = false" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 mt-2" :class="{ 'bg-blue-900 text-white shadow-md': $page.url.startsWith('/admin/registrations'), 'text-stone-400 hover:bg-blue-900 hover:text-white': !$page.url.startsWith('/admin/registrations') }">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0 transition-colors duration-200" :class="{ 'text-amber-300': $page.url.startsWith('/admin/registrations'), 'text-stone-500 group-hover:text-slate-300': !$page.url.startsWith('/admin/registrations') }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Data Pendaftar
                </Link>

                <Link href="/admin/users" @click="isSidebarOpen = false" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 mt-2" :class="{ 'bg-blue-900 text-white shadow-md': $page.url.startsWith('/admin/users'), 'text-stone-400 hover:bg-blue-900 hover:text-white': !$page.url.startsWith('/admin/users') }">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0 transition-colors duration-200" :class="{ 'text-amber-300': $page.url.startsWith('/admin/users'), 'text-stone-500 group-hover:text-slate-300': !$page.url.startsWith('/admin/users') }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Data Pengguna
                </Link>

                <Link href="/admin/finances" @click="isSidebarOpen = false" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 mt-2" :class="{ 'bg-blue-900 text-white shadow-md': $page.url.startsWith('/admin/finances'), 'text-stone-400 hover:bg-blue-900 hover:text-white': !$page.url.startsWith('/admin/finances') }">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0 transition-colors duration-200" :class="{ 'text-amber-300': $page.url.startsWith('/admin/finances'), 'text-stone-500 group-hover:text-slate-300': !$page.url.startsWith('/admin/finances') }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Data Keuangan
                </Link>

                <Link href="/admin/announcements" @click="isSidebarOpen = false" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 mt-2" :class="{ 'bg-blue-900 text-white shadow-md': $page.url.startsWith('/admin/announcements'), 'text-stone-400 hover:bg-blue-900 hover:text-white': !$page.url.startsWith('/admin/announcements') }">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0 transition-colors duration-200" :class="{ 'text-amber-300': $page.url.startsWith('/admin/announcements'), 'text-stone-500 group-hover:text-slate-300': !$page.url.startsWith('/admin/announcements') }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    Pengumuman
                </Link>

                <Link href="/admin/activity-logs" @click="isSidebarOpen = false" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 mt-2" :class="{ 'bg-blue-900 text-white shadow-md': $page.url.startsWith('/admin/activity-logs'), 'text-stone-400 hover:bg-blue-900 hover:text-white': !$page.url.startsWith('/admin/activity-logs') }">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0 transition-colors duration-200" :class="{ 'text-amber-300': $page.url.startsWith('/admin/activity-logs'), 'text-stone-500 group-hover:text-slate-300': !$page.url.startsWith('/admin/activity-logs') }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Riwayat Update
                </Link>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden bg-slate-100 min-w-0">
            <header class="bg-white shadow px-4 sm:px-6 py-4 flex justify-between items-center z-10 sticky top-0">
                <div class="flex items-center">
                    <button @click="isSidebarOpen = true" class="mr-4 text-stone-500 hover:text-stone-700 focus:outline-none md:hidden">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <h2 class="text-lg font-semibold text-stone-800 hidden sm:block">Admin Area</h2>
                </div>
                <div class="flex items-center gap-3 sm:gap-4">
                    <span class="text-xs sm:text-sm font-medium text-stone-600 truncate max-w-[120px] sm:max-w-xs">{{ $page.props.auth.user.name }}</span>
                    <form @submit.prevent="logout">
                        <button type="submit" class="text-xs sm:text-sm text-red-600 hover:text-red-800 font-medium">Logout</button>
                    </form>
                </div>
            </header>
            <div class="flex-1 p-4 sm:p-6 overflow-y-auto">
                <slot />
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';

const isSidebarOpen = ref(false);

const logout = () => {
    router.post('/logout');
};
</script>

<template>
    <div class="min-h-screen bg-slate-100 flex flex-col md:flex-row">
        <!-- Sidebar -->
        <aside class="w-full md:w-64 bg-blue-950 text-slate-300 flex-shrink-0">
            <div class="p-4 bg-blue-950">
                <h1 class="text-xl font-bold text-white font-plus-jakarta-sans">OKKA Admin</h1>
            </div>
            <nav class="p-4 flex flex-col">
                <Link href="/admin/dashboard" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200" :class="{ 'bg-blue-900 text-white shadow-md': $page.url.startsWith('/admin/dashboard'), 'text-stone-400 hover:bg-blue-900 hover:text-white': !$page.url.startsWith('/admin/dashboard') }">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0 transition-colors duration-200" :class="{ 'text-amber-300': $page.url.startsWith('/admin/dashboard'), 'text-stone-500 group-hover:text-slate-300': !$page.url.startsWith('/admin/dashboard') }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </Link>

                <Link href="/admin/events" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 mt-2" :class="{ 'bg-blue-900 text-white shadow-md': $page.url.startsWith('/admin/events'), 'text-stone-400 hover:bg-blue-900 hover:text-white': !$page.url.startsWith('/admin/events') }">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0 transition-colors duration-200" :class="{ 'text-amber-300': $page.url.startsWith('/admin/events'), 'text-stone-500 group-hover:text-slate-300': !$page.url.startsWith('/admin/events') }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Data Event
                </Link>
                
                <Link href="/admin/registrations" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 mt-2" :class="{ 'bg-blue-900 text-white shadow-md': $page.url.startsWith('/admin/registrations'), 'text-stone-400 hover:bg-blue-900 hover:text-white': !$page.url.startsWith('/admin/registrations') }">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0 transition-colors duration-200" :class="{ 'text-amber-300': $page.url.startsWith('/admin/registrations'), 'text-stone-500 group-hover:text-slate-300': !$page.url.startsWith('/admin/registrations') }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Data Pendaftar
                </Link>

                <Link href="/admin/announcements" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 mt-2" :class="{ 'bg-blue-900 text-white shadow-md': $page.url.startsWith('/admin/announcements'), 'text-stone-400 hover:bg-blue-900 hover:text-white': !$page.url.startsWith('/admin/announcements') }">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0 transition-colors duration-200" :class="{ 'text-amber-300': $page.url.startsWith('/admin/announcements'), 'text-stone-500 group-hover:text-slate-300': !$page.url.startsWith('/admin/announcements') }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    Pengumuman
                </Link>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow flex flex-col h-screen overflow-hidden">
            <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-stone-800">Admin Area</h2>
                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-stone-600">{{ $page.props.auth.user.name }}</span>
                    <form @submit.prevent="logout">
                        <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">Logout</button>
                    </form>
                </div>
            </header>
            <div class="flex-grow p-6 overflow-y-auto bg-slate-100">
                <slot />
            </div>
        </main>
    </div>
</template>

<script setup>
import { router, Link } from '@inertiajs/vue3';

const logout = () => {
    router.post('/logout');
};
</script>

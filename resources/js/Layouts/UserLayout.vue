<template>
    <div class="h-screen app-viewport bg-slate-100 flex overflow-hidden">
        
        <!-- Mobile Sidebar Overlay -->
        <div v-if="isMobileMenuOpen" @click="isMobileMenuOpen = false" class="fixed inset-0 bg-slate-900/20 backdrop-blur-sm z-20 lg:hidden transition-all duration-300"></div>
        
        <!-- Left Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-30 w-64 bg-slate-900 text-white flex flex-col transform transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0 flex-shrink-0 shadow-xl" :class="{'translate-x-0': isMobileMenuOpen, '-translate-x-full': !isMobileMenuOpen}">
            <div class="p-6 border-b border-slate-800 flex justify-between items-center">
                <h1 class="text-xl font-bold font-plus-jakarta-sans text-white tracking-wide">Dashboard User</h1>
                <button @click="isMobileMenuOpen = false" class="text-slate-400 hover:text-white lg:hidden">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="/dashboard" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200" :class="{ 'bg-blue-600 text-white shadow-md': $page.url === '/dashboard', 'text-slate-400 hover:bg-slate-800 hover:text-white': $page.url !== '/dashboard' }">
                    <svg class="w-5 h-5 mr-3 opacity-75 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Home
                </a>
                <a href="/user/history" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200" :class="{ 'bg-blue-600 text-white shadow-md': $page.url.startsWith('/user/history'), 'text-slate-400 hover:bg-slate-800 hover:text-white': !$page.url.startsWith('/user/history') }">
                    <svg class="w-5 h-5 mr-3 opacity-75 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Riwayat Event
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800 mt-auto">
                <form @submit.prevent="logout" class="w-full">
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r from-red-900/40 to-red-600/10 hover:from-red-600 hover:to-red-500 text-red-400 hover:text-white rounded-xl font-bold transition-all duration-300 border border-red-500/30 hover:border-red-500 shadow-lg shadow-red-900/20 hover:shadow-red-500/40 group">
                        <svg class="mr-2 h-5 w-5 flex-shrink-0 transition-transform duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden relative z-10">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-slate-200 relative z-20">
                <div class="px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                    <div class="flex items-center">
                        <!-- Mobile Menu Button -->
                        <button @click="isMobileMenuOpen = true" class="mr-4 text-stone-500 hover:text-blue-600 focus:outline-none lg:hidden">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                        <h1 class="text-xl font-bold text-blue-800 font-plus-jakarta-sans lg:hidden">OKKA</h1>
                    </div>
                    <nav class="flex items-center gap-3">
                        <!-- Notification Bell -->
                        <button @click="isSidebarOpen = true" class="relative p-2 text-stone-500 hover:text-amber-500 hover:bg-amber-50 rounded-full transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span v-if="$page.props.announcements && $page.props.announcements.length > 0" class="absolute top-1 right-1.5 flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500 border-2 border-white"></span>
                            </span>
                        </button>
                    </nav>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-slate-100 p-4 sm:p-6 lg:p-8">
                <div class="max-w-7xl mx-auto">
                    <slot />
                </div>
            </main>
        </div>

        <!-- Slide-out Sidebar Overlay -->
        <div v-if="isSidebarOpen" class="fixed inset-0 z-50 overflow-hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
            <div class="absolute inset-0 bg-transparent transition-opacity" @click="isSidebarOpen = false"></div>
            <div class="fixed inset-y-0 right-0 max-w-sm w-full flex pointer-events-auto">
                <div class="w-full h-full bg-white shadow-2xl border-l border-slate-200 flex flex-col animate-slide-in-right transform transition-transform duration-300 ease-in-out">
                    <!-- Sidebar Header -->
                    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
                        <h2 class="text-lg font-bold text-stone-800 font-plus-jakarta-sans flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                            Pengumuman
                        </h2>
                        <button @click="isSidebarOpen = false" class="text-stone-400 hover:text-stone-600 rounded-full p-1 hover:bg-slate-200 transition">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    
                    <!-- Sidebar Content -->
                    <div class="flex-1 overflow-y-auto p-6">
                        <div v-if="!$page.props.announcements || $page.props.announcements.length === 0" class="text-center text-stone-500 py-8">
                            Belum ada pengumuman.
                        </div>
                        <div v-else class="space-y-6">
                            <div v-for="announcement in $page.props.announcements" :key="announcement.id" class="border-b border-slate-100 pb-5 last:border-0 last:pb-0">
                                <h4 class="font-bold text-stone-900 mb-1">{{ announcement.title }}</h4>
                                <p class="text-xs text-stone-400 mb-3">{{ new Date(announcement.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) }}</p>
                                <div v-if="announcement.image" class="mb-3">
                                    <img :src="'/storage/' + announcement.image" alt="Announcement Image" class="w-full max-h-48 object-cover rounded-lg shadow-sm">
                                </div>
                                <div class="text-sm text-stone-600 prose prose-sm" v-html="announcement.content"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { usePushNotifications } from '@/Composables/usePushNotifications';

const isSidebarOpen = ref(false);
const isMobileMenuOpen = ref(false);
const form = useForm({});
const { subscribeToPushNotifications } = usePushNotifications();

const logout = () => {
    form.post('/logout');
};

// Close sidebar on escape key
const onKeyDown = (e) => {
    if (e.key === 'Escape' && isSidebarOpen.value) {
        isSidebarOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener('keydown', onKeyDown);
    
    // Attempt to subscribe to push notifications
    if (Notification.permission !== 'denied') {
        subscribeToPushNotifications();
    }
});

onUnmounted(() => {
    document.removeEventListener('keydown', onKeyDown);
});
</script>

<style>
.app-viewport {
    height: 100vh; /* Fallback for browsers that do not support dvh */
    height: 100dvh;
}
@keyframes slideInRight {
    from {
        transform: translateX(100%);
    }
    to {
        transform: translateX(0);
    }
}
.animate-slide-in-right {
    animation: slideInRight 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}
</style>



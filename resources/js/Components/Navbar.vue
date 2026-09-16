<template>
    <nav class="bg-slate-50/90 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/">
                        <span class="text-2xl font-bold text-blue-950 font-plus-jakarta-sans tracking-tight">OKKA</span>
                    </a>
                </div>
                
                <!-- Center Links -->
                <div class="hidden md:flex md:items-center md:space-x-8">
                    <a href="/about" class="text-stone-600 hover:text-blue-900 text-sm font-semibold transition-colors">Tentang</a>
                    <a href="/program" class="text-stone-600 hover:text-blue-900 text-sm font-semibold transition-colors">Program</a>
                    <a href="/schedule" class="text-stone-600 hover:text-blue-900 text-sm font-semibold transition-colors">Jadwal</a>
                    <a href="/faq" class="text-stone-600 hover:text-blue-900 text-sm font-semibold transition-colors">FAQ</a>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center space-x-4">
                    <a v-if="!$page.props.auth.user" href="/login" class="relative inline-flex items-center px-6 py-2.5 text-sm font-bold rounded-full text-white bg-blue-950 shadow-md hover:bg-blue-800 focus:outline-none transition">
                        Daftar
                    </a>
                    <a v-else href="/dashboard" class="relative inline-flex items-center px-6 py-2.5 text-sm font-bold rounded-full text-white bg-blue-950 shadow-md hover:bg-blue-800 focus:outline-none transition">
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>

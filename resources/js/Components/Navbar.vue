<template>
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex-shrink-0 flex items-center">
                        <span class="text-2xl font-bold text-blue-800 font-plus-jakarta-sans tracking-tight">OKKA</span>
                    </a>
                    <div class="hidden md:ml-6 md:flex md:space-x-8">
                        <a href="/about" class="text-stone-600 hover:text-amber-600 inline-flex items-center px-1 pt-1 text-sm font-medium transition-colors">Tentang</a>
                        <a href="/program" class="text-stone-600 hover:text-amber-600 inline-flex items-center px-1 pt-1 text-sm font-medium transition-colors">Program</a>
                        <a href="/schedule" class="text-stone-600 hover:text-amber-600 inline-flex items-center px-1 pt-1 text-sm font-medium transition-colors">Jadwal</a>
                        <a href="/faq" class="text-stone-600 hover:text-amber-600 inline-flex items-center px-1 pt-1 text-sm font-medium transition-colors">FAQ</a>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a v-if="!$page.props.auth.user" href="/login" class="relative inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-amber-600 shadow-sm hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 transition">
                            Login / Daftar
                        </a>
                        <a v-else href="/dashboard" class="relative inline-flex items-center px-4 py-2 border border-slate-300 text-sm font-medium rounded-md text-blue-800 bg-white shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-600 transition">
                            Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>

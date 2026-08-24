<template>
    <Head title="Login - OKKA" />

    <div class="min-h-screen bg-slate-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden">
        
        <!-- Background Decoration (Topographic / Journey line subtle representation) -->
        <div class="absolute inset-0 pointer-events-none opacity-5">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,100 Q150,50 300,150 T600,100 T900,200 T1200,50" fill="none" stroke="currentColor" stroke-width="2"/>
                <path d="M0,200 Q150,150 300,250 T600,200 T900,300 T1200,150" fill="none" stroke="currentColor" stroke-width="2"/>
                <path d="M0,300 Q150,250 300,350 T600,300 T900,400 T1200,250" fill="none" stroke="currentColor" stroke-width="2"/>
            </svg>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-stone-900 font-plus-jakarta-sans tracking-tight">
                Mulai Perjalananmu
            </h2>
            <p class="mt-2 text-center text-sm text-stone-600 font-inter">
                Atau <a href="/" class="font-medium text-amber-600 hover:text-amber-500">kembali ke beranda</a>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md relative z-10">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 border border-slate-200">
                
                <div v-if="$page.props.errors.error" class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-md text-sm">
                    {{ $page.props.errors.error }}
                </div>

                <div>
                    <a href="/auth/google" class="w-full flex justify-center py-3 px-4 border border-slate-300 rounded-md shadow-sm bg-white text-sm font-medium text-blue-800 hover:bg-slate-50 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-600">
                        <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        Login dengan Google
                    </a>
                </div>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-200" />
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-stone-500">
                                Hanya untuk mahasiswa terdaftar
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
</script>

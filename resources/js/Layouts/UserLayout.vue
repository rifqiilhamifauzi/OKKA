<template>
    <div class="min-h-screen bg-slate-100 flex flex-col">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-blue-800 font-plus-jakarta-sans">OKKA Dashboard</h1>
                <nav>
                    <a href="#" class="text-stone-600 hover:text-amber-600 px-3 py-2 font-medium">Dashboard</a>
                    <a href="#" class="text-stone-600 hover:text-amber-600 px-3 py-2 font-medium">Registration</a>
                </nav>
            </div>
        </header>

        <main class="flex-grow py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <slot />
            </div>
        </main>
    </div>
</template>

<script setup>
// User Layout
</script>

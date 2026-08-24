<template>
    <div class="min-h-screen bg-slate-50 flex flex-col font-inter">
        <Navbar />

        <main class="flex-grow">
            <slot />
        </main>

        <Footer />
    </div>
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
</script>

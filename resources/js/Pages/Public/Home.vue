<template>
    <Head title="Beranda - OKKA 2026" />

    <PublicLayout>
        <!-- 1. Hero Section -->
        <section class="relative bg-[#fafaf9] overflow-hidden pt-12 pb-24 md:pt-16 md:pb-32">
            <!-- Particle Background -->
            <ParticleBackground />
            
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center">
                    
                    <!-- Left Column: Content -->
                    <div class="flex flex-col items-start text-left order-2 lg:order-1">
                        <!-- Badge -->
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-slate-200 text-blue-950 text-xs font-bold mb-6">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 mr-2"></span>
                            Orientasi Kepramukaan & Kepemimpinan
                        </div>
                        
                        <!-- Title -->
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-blue-950 leading-[1.1] mb-6 font-plus-jakarta-sans tracking-tight">
                            Membangun Masa<br>
                            Depan Bersama <span class="text-amber-500 relative whitespace-nowrap">OKKA 2026<svg class="absolute -bottom-2 left-0 w-full h-3 text-amber-300 -z-10" viewBox="0 0 100 10" preserveAspectRatio="none"><path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="4" fill="transparent"/></svg></span>
                        </h1>
                        
                        <!-- Description -->
                        <p class="text-lg md:text-xl text-slate-600 mb-10 leading-relaxed font-inter max-w-lg">
                            Membentuk karakter adaptif, berintegritas, dan berjiwa pemimpin untuk masa depan yang lebih baik dalam satu platform cerdas.
                        </p>
                        
                        <!-- Actions -->
                        <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                            <a href="/login" class="px-8 py-3.5 bg-blue-950 hover:bg-blue-900 text-white font-bold rounded-full shadow-lg transition-all transform hover:-translate-y-1 text-base flex items-center justify-center">
                                Daftar Sekarang
                            </a>
                            <a href="#about" @click.prevent="scrollToAbout" class="px-8 py-3.5 bg-white hover:bg-slate-50 border border-slate-300 text-blue-950 font-bold rounded-full transition-all text-base flex items-center justify-center shadow-sm">
                                Pelajari Lebih Lanjut
                            </a>
                        </div>
                    </div>
                    
                    <!-- Right Column: Visual/Video Placeholder -->
                    <div class="relative w-full max-w-[220px] sm:max-w-xs md:max-w-md mx-auto lg:ml-auto order-1 lg:order-2 mb-6 md:mb-10 lg:mb-0">
                        <!-- Connecting lines graphic in background -->
                        <div class="absolute -inset-10 z-0 hidden md:block">
                            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="w-full h-full opacity-10 text-blue-900">
                                <path fill="currentColor" d="M44.7,-76.4C58.9,-69.2,71.8,-59.1,81.1,-46.4C90.4,-33.7,96.1,-18.4,96.6,-3C97.1,12.4,92.5,27.8,84,41.2C75.5,54.6,63.1,66.1,49.1,73.5C35.1,80.9,19.5,84.2,4.3,80.9C-10.9,77.6,-25.7,67.7,-40.4,59.3C-55.1,50.9,-69.7,44,-78.9,32.3C-88.1,20.6,-91.9,4.1,-89.2,-11.3C-86.5,-26.7,-77.3,-41,-65.4,-52.1C-53.5,-63.2,-39,-71,-24.8,-75.4C-10.6,-79.8,3.2,-80.8,17.4,-80C31.6,-79.2,45.8,-76.6,44.7,-76.4Z" transform="translate(100 100)" />
                            </svg>
                        </div>
                        
                        <!-- The Video Bumper Placeholder -->
                        <div class="relative z-10 w-full aspect-square rounded-[2rem] bg-slate-200 overflow-hidden shadow-2xl border-4 border-white/80 flex items-center justify-center group bg-black">
                            
                            <!-- Video Tag -->
                            <video 
                                src="/videos/bumper-okka.mp4" 
                                autoplay 
                                loop 
                                muted 
                                playsinline
                                class="absolute inset-0 w-full h-full object-cover transform scale-[1.15]">
                            </video>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>

        <!-- 2. About OKKA -->
        <section id="about" class="py-24 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                    <div>
                        <h2 class="text-3xl font-extrabold text-stone-900 font-plus-jakarta-sans mb-6">Apa itu OKKA?</h2>
                        <p class="text-lg text-stone-600 mb-8 leading-relaxed">
                            OKKA (Orientasi Kepramukaan dan Kepemimpinan Mahasiswa) merupakan wadah pembinaan karakter yang mengintegrasikan nilai-nilai kepramukaan dan kepemimpinan bagi Pramuka Penegak, Pramuka Pandega, serta calon pendidik. OKKA menjadi ruang bagi peserta untuk mengaktualisasikan potensi diri maupun kelompok, membangun karakter, meningkatkan kompetensi dan profesionalisme, serta menumbuhkan sikap mandiri dan kepedulian terhadap masyarakat.
                        </p>
                        <a href="/about" class="text-amber-600 font-bold hover:text-amber-500 flex items-center">
                            Selengkapnya tentang OKKA
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                    <div class="mt-12 lg:mt-0">
                        <div class="bg-slate-200 rounded-2xl h-80 flex items-center justify-center overflow-hidden shadow-xl group">
                            <img src="/images/okka-1.png" alt="Tentang OKKA" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. Why OKKA -->
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-extrabold text-stone-900 font-plus-jakarta-sans">Mengapa Anda Harus Mengikuti OKKA?</h2>
                    <p class="mt-4 text-lg text-stone-600 leading-relaxed max-w-4xl mx-auto">Karena OKKA bukan sekadar kegiatan orientasi, tetapi menjadi proses pembentukan karakter dan kepemimpinan. Melalui OKKA, peserta diajak untuk memahami hak dan kewajibannya sebagai warga negara sekaligus sebagai anggota Pramuka, serta menumbuhkan kesadaran untuk berperan dan bertanggung jawab dalam kehidupan beragama, berbangsa, dan bernegara.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto bg-amber-50 text-amber-600 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-stone-900 mb-3 font-plus-jakarta-sans">Kepemimpinan Adaptif</h3>
                        <p class="text-stone-600">Latih kemampuan memimpin dan dipimpin dalam situasi yang dinamis dan tak terduga.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-stone-900 mb-3 font-plus-jakarta-sans">Jaringan Pertemanan</h3>
                        <p class="text-stone-600">Bangun relasi solid lintas fakultas dan jurusan sejak hari pertama kuliah.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto bg-blue-100 text-blue-700 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-stone-900 mb-3 font-plus-jakarta-sans">Kecerdasan Ekologis</h3>
                        <p class="text-stone-600">Tingkatkan kesadaran dan kepedulian terhadap lingkungan hidup.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. Program -->
        <section class="py-24 bg-blue-950 text-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="mb-16">
                    <h2 class="text-3xl font-extrabold font-plus-jakarta-sans mb-4">Program Unggulan</h2>
                    <p class="text-stone-400 text-lg">Rangkaian aktivitas yang dirancang khusus untuk Anda.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-blue-900 p-6 rounded-xl border border-blue-800 hover:border-amber-400 transition">
                        <h4 class="text-amber-300 font-bold mb-2">01</h4>
                        <h3 class="text-xl font-bold mb-3 font-plus-jakarta-sans">Lokakarya-Kelas Umum-Talkshow</h3>
                        <p class="text-stone-400 text-sm">Wadah berbagi wawasan, inspirasi, dan pengalaman bersama pemateri inspiratif.</p>
                    </div>
                    <div class="bg-blue-900 p-6 rounded-xl border border-blue-800 hover:border-amber-500 transition">
                        <h4 class="text-amber-400 font-bold mb-2">02</h4>
                        <h3 class="text-xl font-bold mb-3 font-plus-jakarta-sans">Orientasi Kepramukaan</h3>
                        <p class="text-stone-400 text-sm">Membangun karakter, kedisiplinan, dan jiwa kepemimpinan melalui nilai kepramukaan.</p>
                    </div>
                    <div class="bg-blue-900 p-6 rounded-xl border border-blue-800 hover:border-blue-500 transition">
                        <h4 class="text-blue-400 font-bold mb-2">03</h4>
                        <h3 class="text-xl font-bold mb-3 font-plus-jakarta-sans">Coaching</h3>
                        <p class="text-stone-400 text-sm">Pendampingan untuk mengembangkan potensi, keterampilan, dan kepemimpinan peserta.</p>
                    </div>
                    <div class="bg-blue-900 p-6 rounded-xl border border-blue-800 hover:border-purple-500 transition">
                        <h4 class="text-purple-400 font-bold mb-2">04</h4>
                        <h3 class="text-xl font-bold mb-3 font-plus-jakarta-sans">Kegiatan lainnya</h3>
                        <p class="text-stone-400 text-sm">Grand Opening, Campus Care, Art Performance, Pengenalan Gugus depan</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. Experience / Journey & Timeline (Simplified combined view) -->
        <section class="py-24 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-extrabold text-stone-900 font-plus-jakarta-sans">Timeline Kegiatan</h2>
                    <p class="mt-4 text-xl text-stone-600">Catat tanggal penting agar Anda tidak terlewat.</p>
                </div>
                
                <div class="relative">
                    <!-- Vertical Line -->
                    <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-amber-100"></div>
                    
                    <div class="space-y-12">
                        <!-- Item 1 -->
                        <div class="relative flex items-center justify-between">
                            <div class="w-5/12 text-right pr-8">
                                <h4 class="text-xl font-bold text-stone-900">Pendaftaran Buka</h4>
                                <p class="text-stone-600">Gelombang 2</p>
                            </div>
                            <div class="w-10 h-10 bg-amber-500 rounded-full border-4 border-white shadow flex items-center justify-center z-10"></div>
                            <div class="w-5/12 pl-8">
                                <span class="inline-block bg-amber-50 text-blue-800 font-bold px-3 py-1 rounded">26 Agustus 2026</span>
                            </div>
                        </div>
                        <!-- Item 2 -->
                        <div class="relative flex items-center justify-between">
                            <div class="w-5/12 text-right pr-8">
                                <span class="inline-block bg-amber-100 text-amber-800 font-bold px-3 py-1 rounded">22 Oktober 2026</span>
                            </div>
                            <div class="w-10 h-10 bg-amber-500 rounded-full border-4 border-white shadow flex items-center justify-center z-10"></div>
                            <div class="w-5/12 pl-8">
                                <h4 class="text-xl font-bold text-stone-900">Pendaftaran Tutup</h4>
                                <p class="text-stone-600">Batas akhir pembayaran</p>
                            </div>
                        </div>
                        <!-- Item 3 -->
                        <div class="relative flex items-center justify-between">
                            <div class="w-5/12 text-right pr-8">
                                <h4 class="text-xl font-bold text-stone-900">Pelaksanaan OKKA</h4>
                                <p class="text-stone-600">Kampus UIN SGD Bandung</p>
                            </div>
                            <div class="w-10 h-10 bg-blue-800 rounded-full border-4 border-white shadow flex items-center justify-center z-10"></div>
                            <div class="w-5/12 pl-8">
                                <span class="inline-block bg-slate-200 text-stone-800 font-bold px-3 py-1 rounded">30-31 Oktober 2026</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 6. Statistics -->
        <section class="py-16 bg-blue-800 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-4xl font-extrabold mb-2 font-plus-jakarta-sans">1,000+</div>
                        <div class="text-amber-100">Peserta Per Tahun</div>
                    </div>
                    <div>
                        <div class="text-4xl font-extrabold mb-2 font-plus-jakarta-sans">50+</div>
                        <div class="text-amber-100">Fasilitator Ahli</div>
                    </div>
                    <div>
                        <div class="text-4xl font-extrabold mb-2 font-plus-jakarta-sans">2</div>
                        <div class="text-amber-100">Hari Pelaksanaan</div>
                    </div>
                    <div>
                        <div class="text-4xl font-extrabold mb-2 font-plus-jakarta-sans">100%</div>
                        <div class="text-amber-100">Pengalaman Berharga</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 7. Gallery Placeholder -->
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-stone-900 font-plus-jakarta-sans mb-12 text-center">Galeri Kegiatan</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-slate-200 h-48 rounded-lg overflow-hidden group shadow-md relative">
                        <img src="/images/okka-2.png" alt="Galeri OKKA 1" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    </div>
                    <div class="bg-slate-200 h-48 rounded-lg md:col-span-2 overflow-hidden group shadow-md relative">
                        <img src="/images/okka-3.png" alt="Galeri OKKA 2" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    </div>
                    <div class="bg-slate-200 h-48 rounded-lg overflow-hidden group shadow-md relative">
                        <img src="/images/okka-4.png" alt="Galeri OKKA 3" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    </div>
                    <div class="bg-slate-200 h-48 rounded-lg overflow-hidden group shadow-md relative">
                        <img src="/images/okka-5.png" alt="Galeri OKKA 4" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    </div>
                    <div class="bg-slate-200 h-48 rounded-lg overflow-hidden group shadow-md relative">
                        <img src="/images/okka-6.png" alt="Galeri OKKA 5" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    </div>
                    <div class="bg-slate-200 h-48 rounded-lg md:col-span-2 overflow-hidden group shadow-md relative">
                        <img src="/images/okka-7.png" alt="Galeri OKKA 6" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    </div>
                </div>
            </div>
        </section>

        <!-- 8. FAQ -->
        <section class="py-24 bg-slate-50">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-stone-900 font-plus-jakarta-sans mb-12 text-center">Pertanyaan Populer (FAQ)</h2>
                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
                        <h4 class="text-lg font-bold text-stone-900 mb-2">Apakah kegiatan ini wajib?</h4>
                        <p class="text-stone-600">Ya, OKKA merupakan kegiatan orientasi wajib bagi seluruh mahasiswa baru sesuai dengan peraturan akademik universitas.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
                        <h4 class="text-lg font-bold text-stone-900 mb-2">Bagaimana jika saya memiliki kondisi medis khusus?</h4>
                        <p class="text-stone-600">Anda dapat melampirkan surat keterangan dokter saat pendaftaran. Panitia medis akan menyesuaikan intensitas kegiatan untuk Anda.</p>
                    </div>
                </div>
                <div class="mt-8 text-center">
                    <a href="/faq" class="text-amber-600 font-bold hover:underline">Lihat semua pertanyaan &rarr;</a>
                </div>
            </div>
        </section>

        <!-- 9. CTA Registration -->
        <section class="py-24 bg-blue-950 relative overflow-hidden">
            <div class="absolute inset-0 bg-blue-900 opacity-20"></div>
            <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl font-extrabold text-white font-plus-jakarta-sans mb-6">Siap Memulai Perjalanan Anda?</h2>
                <p class="text-xl text-slate-300 mb-10">Segera amankan kursi Anda.</p>
                <a href="/login" class="inline-block px-10 py-5 bg-gradient-to-r from-amber-400 to-amber-600 hover:from-amber-300 hover:to-amber-500 text-blue-950 border border-amber-300 text-lg font-extrabold rounded-lg shadow-xl shadow-amber-500/20 transition-all transform hover:scale-105">
                    Daftar ke OKKA 2026
                </a>
            </div>
        </section>
    </PublicLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import ParticleBackground from '@/Components/ParticleBackground.vue';

const scrollToAbout = () => {
    const el = document.getElementById('about');
    if (el) {
        el.scrollIntoView({ behavior: 'smooth' });
    }
};
</script>

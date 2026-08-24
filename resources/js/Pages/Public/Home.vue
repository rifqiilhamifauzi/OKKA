<template>
    <Head title="Beranda - OKKA 2026" />

    <PublicLayout>
        <!-- 1. Hero Section -->
        <section class="relative bg-blue-950 text-white overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div class="absolute inset-0 bg-blue-900 mix-blend-multiply opacity-60"></div>
                <!-- Placeholder for Hero Image -->
                <div class="w-full h-full bg-blue-900"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-blue-950 to-transparent"></div>
            </div>
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-5 pb-24 md:pt-8 md:pb-24 flex flex-col items-center text-center">
                <!-- Main Logo Image -->
                <img src="/images/okka-logo.png"
                        alt="OKKA 2026"
                            class="w-[280px] mb-8 drop-shadow-2xl hover:scale-105 transition-transform duration-500 object-contain">
                
                <!-- Description -->
                <h2 class="text-xl md:text-2xl text-amber-400 font-bold tracking-widest uppercase mb-4 drop-shadow">
                    Orientasi Kepramukaan dan Kepemimpinan
                </h2>
                <p class="text-lg md:text-xl text-slate-200 max-w-3xl mb-10 font-inter leading-relaxed drop-shadow-md">
                    Membentuk karakter adaptif, berintegritas, dan berjiwa pemimpin untuk masa depan yang lebih baik.
                </p>
                
                <!-- Call to Actions -->
                <div class="flex flex-col sm:flex-row gap-4 mt-2">
                    <a href="/login" class="px-8 py-4 bg-gradient-to-r from-amber-400 to-amber-600 hover:from-amber-300 hover:to-amber-500 text-blue-950 border border-amber-300 font-extrabold rounded-lg shadow-xl shadow-amber-500/20 transition-all transform hover:-translate-y-1 hover:scale-105 text-lg flex items-center justify-center">
                        Daftar Sekarang
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    <a href="#about" class="px-8 py-4 bg-blue-950/40 hover:bg-blue-950/60 backdrop-blur-md border border-slate-500/30 text-white font-bold rounded-lg transition text-lg flex items-center justify-center">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
            
            <!-- Journey Line Decorative Element -->
            <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
                <svg class="relative block w-full h-12" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="#f8fafc"></path>
                    <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="#f8fafc"></path>
                    <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="#f8fafc"></path>
                </svg>
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
                                <p class="text-stone-600">Gelombang 1</p>
                            </div>
                            <div class="w-10 h-10 bg-amber-500 rounded-full border-4 border-white shadow flex items-center justify-center z-10"></div>
                            <div class="w-5/12 pl-8">
                                <span class="inline-block bg-amber-50 text-blue-800 font-bold px-3 py-1 rounded">26 Agustus 2026</span>
                            </div>
                        </div>
                        <!-- Item 2 -->
                        <div class="relative flex items-center justify-between">
                            <div class="w-5/12 text-right pr-8">
                                <span class="inline-block bg-amber-100 text-amber-800 font-bold px-3 py-1 rounded">13 September 2026</span>
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
                                <span class="inline-block bg-slate-200 text-stone-800 font-bold px-3 py-1 rounded">26-27 September 2026</span>
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
</script>

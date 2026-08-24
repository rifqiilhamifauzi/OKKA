<template>
    <footer class="bg-blue-950 text-slate-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <h2 class="text-2xl font-bold text-white font-plus-jakarta-sans mb-4">OKKA 2026</h2>
                    <p class="text-sm font-inter text-stone-400 max-w-sm">
                        Orientasi Kepramukaan dan Kepemimpinan Mahasiswa. Wadah orientasi mahasiswa yang membentuk generasi muda berkarakter, berintegritas, adaptif, dan memiliki jiwa kepemimpinan.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2 text-sm font-inter">
                        <li><a href="/about" class="hover:text-amber-400 transition-colors">Tentang OKKA</a></li>
                        <li><a href="/program" class="hover:text-amber-400 transition-colors">Program</a></li>
                        <li><a href="/schedule" class="hover:text-amber-400 transition-colors">Jadwal</a></li>
                        <li><a href="/faq" class="hover:text-amber-400 transition-colors">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Hubungi Kami</h3>
                    <ul class="space-y-2 text-sm font-inter">
                        <li>Gedung Aula Student Center Lt. 4</li>
                        <li>UIN Sunan Gunung Djati Bandung</li>
                        <li><a href="mailto:sgd.pkw@gmail.com" class="hover:text-amber-400 transition-colors">sgd.pkw@gmail.com</a></li>
                        <li>+62 812-2359-5260</li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-blue-900 text-center text-sm text-stone-500">
                &copy; {{ new Date().getFullYear() }} OKKA - Orientasi Kepramukaan dan Kepemimpinan Mahasiswa. All rights reserved.
            </div>
        </div>
    </footer>
</template>

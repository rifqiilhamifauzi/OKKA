<template>
    <Head title="Admin Dashboard - OKKA" />

    <AdminLayout>
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
            <div>
                <h2 class="text-2xl font-bold text-stone-800 font-plus-jakarta-sans">Ikhtisar Pendaftaran</h2>
                <p class="text-stone-600 text-sm mt-1">
                    Data terkini untuk event: <strong class="text-blue-700">{{ activeEvent ? activeEvent.name : 'Semua Event Aktif' }}</strong>
                </p>
            </div>
            
            <!-- Event Filter -->
            <div class="w-full sm:w-64">
                <select v-model="filterForm.event_id" @change="applyFilters" class="block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-white">
                    <option value="all">Semua Event Aktif</option>
                    <option v-for="event in events" :key="event.id" :value="event.id">
                        {{ event.name }}
                    </option>
                </select>
            </div>
        </div>

        <div v-if="!events || events.length === 0" class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-md mb-6">
            Peringatan: Tidak ada event yang terdaftar saat ini.
        </div>
        
        <div v-else>
            <!-- 4 Metric Cards (Modern Blue Design) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total -->
                <div class="bg-blue-900 rounded-2xl shadow-md p-6 flex flex-col justify-between text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-800 rounded-full opacity-50 blur-xl"></div>
                    <div class="relative z-10 flex items-center justify-between mb-4">
                        <div class="p-2 bg-blue-800/80 rounded-lg text-blue-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <span class="text-xs font-bold bg-blue-800/80 px-2 py-1 rounded-full text-blue-100 border border-blue-700/50">Total</span>
                    </div>
                    <div class="relative z-10">
                        <p class="text-sm font-medium text-blue-100/80 mb-1">Total Pendaftar</p>
                        <p class="text-3xl font-bold font-plus-jakarta-sans tracking-tight">{{ metrics.total }}</p>
                    </div>
                </div>
                
                <!-- Pending -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-slate-50 rounded-lg text-amber-500 border border-slate-100 group-hover:bg-amber-50 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Menunggu Pembayaran</p>
                        <p class="text-3xl font-bold text-slate-800 font-plus-jakarta-sans tracking-tight">{{ metrics.pending }}</p>
                    </div>
                </div>

                <!-- Paid -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-slate-50 rounded-lg text-blue-600 border border-slate-100 group-hover:bg-blue-50 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Menunggu Verifikasi</p>
                        <p class="text-3xl font-bold text-slate-800 font-plus-jakarta-sans tracking-tight">{{ metrics.paid }}</p>
                    </div>
                </div>

                <!-- Approved -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-blue-50 rounded-lg text-blue-600 border border-blue-100 group-hover:bg-blue-100 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-xs font-bold bg-blue-100 px-2 py-1 rounded-full text-blue-700">Lolos</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Lolos (Approved)</p>
                        <p class="text-3xl font-bold text-blue-600 font-plus-jakarta-sans tracking-tight">{{ metrics.approved }}</p>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                
                <!-- Main Trend Chart -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 font-plus-jakarta-sans">Tren Pendaftaran</h3>
                            <p class="text-xs text-slate-500">Pertumbuhan pendaftar dari waktu ke waktu</p>
                        </div>
                    </div>
                    <div class="h-72 w-full">
                        <Bar 
                            v-if="chartData.trends && Object.keys(chartData.trends).length > 0"
                            :data="trendChartData" 
                            :options="barChartOptions" 
                        />
                        <div v-else class="w-full h-full flex items-center justify-center text-slate-400 text-sm">
                            Belum ada data pendaftaran
                        </div>
                    </div>
                </div>

                <!-- Gender Donut Chart -->
                <div class="bg-gradient-to-br from-blue-50 to-white rounded-2xl shadow-sm border border-blue-100 p-6 relative overflow-hidden">
                    <h3 class="text-lg font-bold text-slate-800 font-plus-jakarta-sans mb-1">Statistik Peserta</h3>
                    <p class="text-xs text-slate-500 mb-6">Distribusi Jenis Kelamin</p>
                    <div class="h-56 w-full flex justify-center">
                        <Doughnut 
                            v-if="chartData.gender && Object.keys(chartData.gender).length > 0"
                            :data="genderChartData" 
                            :options="doughnutOptions" 
                        />
                        <div v-else class="w-full h-full flex items-center justify-center text-slate-400 text-sm">
                            Belum ada data
                        </div>
                    </div>
                </div>
            </div>

            <!-- Secondary Charts (Faculty & Major) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Faculty Chart -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-lg font-bold text-slate-800 font-plus-jakarta-sans mb-1">Distribusi Fakultas</h3>
                    <p class="text-xs text-slate-500 mb-6">Pendaftar berdasarkan fakultas</p>
                    <div class="h-64 w-full">
                        <Bar 
                            v-if="chartData.faculty && Object.keys(chartData.faculty).length > 0"
                            :data="facultyChartData" 
                            :options="horizontalBarOptions" 
                        />
                        <div v-else class="w-full h-full flex items-center justify-center text-slate-400 text-sm">
                            Belum ada data
                        </div>
                    </div>
                </div>
                
                <!-- Major Chart -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-lg font-bold text-slate-800 font-plus-jakarta-sans mb-1">Distribusi Jurusan</h3>
                    <p class="text-xs text-slate-500 mb-6">Pendaftar berdasarkan jurusan (Top 5)</p>
                    <div class="h-64 w-full flex justify-center">
                        <Doughnut 
                            v-if="chartData.major && Object.keys(chartData.major).length > 0"
                            :data="majorChartData" 
                            :options="doughnutOptions" 
                        />
                        <div v-else class="w-full h-full flex items-center justify-center text-slate-400 text-sm">
                            Belum ada data
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Registrations Table -->
            <div class="bg-white shadow-sm rounded-2xl border border-slate-100 overflow-hidden mb-6">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-white">
                    <h3 class="text-lg font-bold text-stone-800 font-plus-jakarta-sans">Pendaftar Terbaru</h3>
                    <a href="/admin/registrations" class="text-sm text-blue-600 hover:text-blue-800 font-bold transition-colors">Lihat Semua &rarr;</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-100 font-semibold">
                                <th class="px-6 py-4 rounded-tl-lg">No. Daftar</th>
                                <th class="px-6 py-4">Nama Peserta</th>
                                <th class="px-6 py-4">NIM</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Tanggal Daftar</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                            <tr v-for="reg in recentRegistrations" :key="reg.id" class="hover:bg-slate-50/50 transition duration-150">
                                <td class="px-6 py-4 font-mono font-medium text-slate-900">{{ reg.registration_number }}</td>
                                <td class="px-6 py-4 font-medium">{{ reg.user.name }}</td>
                                <td class="px-6 py-4">{{ reg.detail ? reg.detail.identity_number : '-' }}</td>
                                <td class="px-6 py-4">
                                    <span v-if="reg.status === 'pending'" class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-amber-100 text-amber-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span> Pending
                                    </span>
                                    <span v-else-if="reg.status === 'paid'" class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-blue-100 text-blue-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5"></span> Paid
                                    </span>
                                    <span v-else-if="reg.status === 'approved'" class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-100 text-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Approved
                                    </span>
                                    <span v-else class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-slate-100 text-slate-800">
                                        {{ reg.status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-500">{{ new Date(reg.created_at).toLocaleDateString('id-ID') }}</td>
                            </tr>
                            <tr v-if="recentRegistrations.length === 0">
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    Belum ada pendaftar untuk saat ini.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3';
import { onMounted, onUnmounted, reactive, computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Bar, Doughnut } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement)

const props = defineProps({
    events: Array,
    activeEvent: Object,
    metrics: Object,
    recentRegistrations: Array,
    filters: Object,
    chartData: {
        type: Object,
        default: () => ({ trends: {}, gender: {}, faculty: {}, major: {} })
    }
});

const filterForm = reactive({
    event_id: props.filters?.event_id || 'all',
});

const applyFilters = () => {
    let params = {};
    if (filterForm.event_id && filterForm.event_id !== 'all') {
        params.event_id = filterForm.event_id;
    }

    router.get('/admin/dashboard', params, {
        preserveState: true,
        replace: true,
        only: ['metrics', 'recentRegistrations', 'chartData', 'activeEvent']
    });
};

let interval = null;

onMounted(() => {
    // Live update every 10 seconds, only requesting necessary data
    interval = setInterval(() => {
        router.reload({ only: ['metrics', 'recentRegistrations', 'chartData'], preserveScroll: true, preserveState: true });
    }, 10000);
});

onUnmounted(() => {
    if (interval) clearInterval(interval);
});

// Chart Configurations
const chartColors = {
    primary: '#1e40af', // blue-800
    secondary: '#3b82f6', // blue-500
    light: '#93c5fd', // blue-300
    dark: '#1e3a8a', // blue-900
    accent: '#f59e0b', // amber-500
    gray: '#f1f5f9'
};

const trendChartData = computed(() => ({
    labels: Object.keys(props.chartData.trends || {}),
    datasets: [{
        label: 'Jumlah Pendaftar',
        data: Object.values(props.chartData.trends || {}),
        backgroundColor: chartColors.primary,
        borderRadius: 6,
        barPercentage: 0.6,
    }]
}));

const barChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { display: false }
    },
    scales: {
        y: { 
            beginAtZero: true, 
            grid: { color: chartColors.gray, drawBorder: false },
            ticks: { stepSize: 1 }
        },
        x: { grid: { display: false, drawBorder: false } }
    }
};

const genderChartData = computed(() => {
    const keys = Object.keys(props.chartData.gender || {});
    const values = Object.values(props.chartData.gender || {});
    return {
        labels: keys,
        datasets: [{
            data: values,
            backgroundColor: [chartColors.primary, chartColors.light],
            borderWidth: 0,
            hoverOffset: 4
        }]
    };
});

const doughnutOptions = {
    responsive: true,
    maintainAspectRatio: false,
    cutout: '75%',
    plugins: {
        legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
    }
};

const facultyChartData = computed(() => ({
    labels: Object.keys(props.chartData.faculty || {}),
    datasets: [{
        label: 'Jumlah Pendaftar',
        data: Object.values(props.chartData.faculty || {}),
        backgroundColor: chartColors.secondary,
        borderRadius: 4,
    }]
}));

const horizontalBarOptions = {
    indexAxis: 'y',
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: {
        x: { beginAtZero: true, grid: { color: chartColors.gray, drawBorder: false }, ticks: { stepSize: 1 } },
        y: { grid: { display: false, drawBorder: false } }
    }
};

const majorChartData = computed(() => {
    // Top 5 majors
    const entries = Object.entries(props.chartData.major || {}).sort((a,b) => b[1]-a[1]).slice(0, 5);
    return {
        labels: entries.map(e => e[0]),
        datasets: [{
            data: entries.map(e => e[1]),
            backgroundColor: [chartColors.dark, chartColors.primary, chartColors.secondary, chartColors.light, chartColors.accent],
            borderWidth: 0,
        }]
    };
});
</script>

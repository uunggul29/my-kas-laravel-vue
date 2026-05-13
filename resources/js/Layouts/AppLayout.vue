<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

// Pastikan appName punya fallback
const appName = computed(() => page.props.appName || 'Kas Pintar');

// Perbaiki logika user agar selalu menghasilkan string, minimal spasi
const user = computed(() => {
    return page.props.auth?.user?.name || 'Pengguna';
});
</script>

<template>
    <div class="min-h-screen bg-[#f8fafc] font-sans text-slate-900 flex flex-col">
        <!-- Header / Navbar dengan Efek Glassmorphism -->
        <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
            <div class="max-w-5xl mx-auto px-6 h-20 flex justify-between items-center">

                <!-- Logo & Brand -->
                <Link href="/kas" class="flex items-center gap-3 group transition-all">
                    <div
                        class="bg-blue-600 p-2 rounded-xl text-white shadow-lg shadow-blue-200 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-lg leading-tight tracking-tight text-slate-800">{{ appName }}</span>
                        <span class="text-[10px] uppercase tracking-widest text-blue-600 font-bold">Personal
                            Finance</span>
                    </div>
                </Link>

                <!-- Menu Navigasi Tengah -->
                <div class="hidden md:flex items-center bg-slate-100 p-1.5 rounded-full border border-slate-200">
                    <Link href="/kas" class="px-6 py-2 rounded-full text-sm font-semibold transition-all duration-300"
                        :class="$page.url === '/kas' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500 hover:text-slate-800'">
                        Dashboard
                    </Link>
                    <!-- Kamu bisa tambah link lain di sini nanti -->
                </div>

                <!-- Profile / Status -->
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Selamat Datang</p>
                        <p class="text-sm font-bold text-slate-700">{{ user }}</p>
                    </div>

                    <!-- Tombol Logout -->
                    <Link href="/logout" method="post" as="button"
                        class="text-xs font-bold text-rose-500 hover:text-rose-700 bg-rose-50 px-3 py-2 rounded-xl transition-all">
                        Keluar
                    </Link>

                    <div class="relative group cursor-pointer">
                        <div
                            class="w-11 h-11 bg-gradient-to-tr from-blue-600 to-indigo-500 rounded-2xl flex items-center justify-center border-2 border-white shadow-md transform group-hover:rotate-6 transition-transform">
                            <!-- Ganti baris ini -->
                            <span class="text-white font-bold text-sm">
                                {{ (user || 'P').charAt(0).toUpperCase() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Area Konten Utama dengan Padding yang Lebih Nyaman -->
        <main class="max-w-5xl mx-auto w-full py-10 px-6 flex-grow">
            <!-- Slot untuk konten halaman -->
            <slot />
        </main>

        <!-- Footer yang Lebih Elegan -->
        <footer class="mt-auto border-t border-slate-200 bg-white py-8">
            <div class="max-w-5xl mx-auto px-6 flex flex-col md:flex-row justify-center items-center gap-4">
                <p class="text-slate-400 text-xs">
                    &copy; 2026 — Dibuat dengan ❤️ untuk Masa Depan Finansial.
                </p>
            </div>
        </footer>
    </div>
</template>

<style scoped>
/* Menambahkan transisi halus saat pindah halaman melalui Inertia */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref, onMounted, onBeforeUnmount } from 'vue';

const page = usePage();

const appName = computed(() => page.props.appName || 'MyKas');

const user = computed(() => {
    return page.props.auth?.user?.name || 'Pengguna';
});

const showDropdown = ref(false);

const toggleDropdown = () => {
    showDropdown.value = !showDropdown.value;
};

const closeDropdown = (event) => {
    if (!event.target.closest('.profile-dropdown')) {
        showDropdown.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', closeDropdown);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', closeDropdown);
});
</script>

<template>
    <div class="min-h-screen bg-[#f8fafc] font-sans text-slate-900 flex flex-col">

        <!-- Navbar -->
        <nav class="sticky top-0 z-50 border-b border-slate-200 bg-white/80 backdrop-blur-md">
            <div class="max-w-6xl mx-auto px-6 h-20 flex items-center justify-between">

                <!-- Logo -->
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
                        <span class="font-bold text-lg leading-tight tracking-tight text-slate-800">
                            {{ appName }}
                        </span>

                        <span class="text-[10px] uppercase tracking-widest text-blue-600 font-bold">
                            Personal Finance
                        </span>
                    </div>
                </Link>

                <!-- Menu -->
                <div class="hidden md:flex items-center bg-slate-100 p-1.5 rounded-full border border-slate-200">
                    <Link href="/kas" class="px-6 py-2 rounded-full text-sm font-semibold transition-all duration-300"
                        :class="$page.url === '/kas'
                                ? 'bg-white text-blue-600 shadow-sm'
                                : 'text-slate-500 hover:text-slate-800'
                            ">
                        Dashboard
                    </Link>
                </div>

                <!-- Profile -->
                <div class="relative profile-dropdown">

                    <!-- Trigger -->
                    <button @click="toggleDropdown"
                        class="flex items-center gap-3 rounded-2xl px-2 py-1.5 hover:bg-slate-100 transition-all">

                        <div class="text-right hidden sm:block">
                            <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">
                                Selamat Datang
                            </p>

                            <p class="text-sm font-bold text-slate-700">
                                {{ user }}
                            </p>
                        </div>

                        <!-- Avatar -->
                        <div
                            class="w-11 h-11 bg-gradient-to-tr from-blue-600 to-indigo-500 rounded-2xl flex items-center justify-center border-2 border-white shadow-md">
                            <span class="text-white font-bold text-sm">
                                {{ (user || 'P').charAt(0).toUpperCase() }}
                            </span>
                        </div>
                    </button>

                    <!-- Dropdown -->
                    <transition enter-active-class="transition duration-200 ease-out"
                        enter-from-class="opacity-0 scale-95 translate-y-1"
                        enter-to-class="opacity-100 scale-100 translate-y-0"
                        leave-active-class="transition duration-150 ease-in"
                        leave-from-class="opacity-100 scale-100 translate-y-0"
                        leave-to-class="opacity-0 scale-95 translate-y-1">
                        <div v-if="showDropdown"
                            class="absolute right-0 mt-3 w-56 rounded-2xl border border-slate-200 bg-white shadow-2xl overflow-hidden">

                            <!-- Menu -->
                            <div class="p-2">

                                <!-- Profil -->
                                <Link href="/profile"
                                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-blue-600 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5.121 17.804A9 9 0 1118.88 17.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>

                                    Profil Saya
                                </Link>

                                <!-- Logout -->
                                <Link href="/logout" method="post" as="button"
                                    class="w-full flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-rose-500 hover:bg-rose-50 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5m-6 14h6" />
                                    </svg>

                                    Keluar
                                </Link>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <main class="max-w-6xl mx-auto w-full py-10 px-6 flex-grow">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="mt-auto border-t border-slate-200 bg-white py-8">
            <div class="max-w-6xl mx-auto px-6 flex justify-center items-center">
                <p class="text-slate-400 text-xs">
                    © {{ new Date().getFullYear() }} MyKas - All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>

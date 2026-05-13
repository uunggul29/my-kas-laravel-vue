<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-900 via-blue-700 to-cyan-500 px-4">
        <div class="w-full max-w-md">

            <!-- Card -->
            <div class="rounded-3xl bg-white/95 backdrop-blur-md p-8 shadow-2xl border border-white/20">
                <slot />
            </div>

            <!-- Footer -->
            <p class="mt-6 text-center text-sm text-white/80">
                © {{ new Date().getFullYear() }} MyKas - All rights reserved.
            </p>
        </div>
    </div>
</template>

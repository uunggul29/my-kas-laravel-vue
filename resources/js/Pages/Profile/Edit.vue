<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const page = usePage();

// Computed untuk memastikan data user tersedia atau fallback ke 'Pengguna'
const userName = computed(() => page.props.auth?.user?.name || 'Pengguna');
</script>

<template>

    <Head :title="`Profil ${userName}`" />

    <AppLayout>
        <div class="max-w-4xl mx-auto space-y-10 py-4">

            <!-- Header Section -->
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-8 bg-blue-600 rounded-full"></div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">
                    Pengaturan Profil
                </h2>
            </div>

            <!-- Bagian Form: Menggunakan v-if sebagai proteksi tambahan agar tidak layar putih -->
            <div v-if="page.props.auth?.user" class="space-y-10">

                <!-- Perbarui Informasi Profil -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100">
                    <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status"
                        class="max-w-xl" />
                </div>

                <!-- Perbarui Password -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <!-- Hapus Akun -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-2xl shadow-rose-100/50 border border-rose-50">
                    <DeleteUserForm class="max-w-xl" />
                </div>

            </div>

            <!-- State Loading / Error Handling -->
            <div v-else class="bg-white p-20 rounded-[2.5rem] text-center shadow-xl">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-600 mb-4">
                </div>
                <p class="text-slate-500 font-medium">Memuat data profil...</p>
            </div>

        </div>
    </AppLayout>
</template>

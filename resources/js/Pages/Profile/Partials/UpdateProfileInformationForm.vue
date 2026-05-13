<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <section class="rounded-3xl bg-white p-8 shadow-2xl border border-gray-100">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex items-center gap-4">
                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-700" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>

                <div>
                    <h2 class="text-3xl font-bold text-gray-800">
                        Informasi Profil
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Perbarui informasi akun dan alamat email Anda.
                    </p>
                </div>
            </div>
        </header>

        <!-- Form -->
        <form @submit.prevent="form.patch(route('profile.update'))" class="space-y-6">
            <!-- Nama -->
            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                <InputLabel for="name" value="Nama Lengkap" class="mb-2 text-sm font-semibold text-gray-700" />

                <TextInput id="name" type="text"
                    class="block w-full rounded-xl border-gray-300 bg-white text-gray-800 shadow-sm focus:border-gray-400 focus:ring-gray-300"
                    v-model="form.name" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap" />

                <InputError class="mt-2 text-sm" :message="form.errors.name" />
            </div>

            <!-- Email -->
            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                <InputLabel for="email" value="Alamat Email" class="mb-2 text-sm font-semibold text-gray-700" />

                <TextInput id="email" type="email"
                    class="block w-full rounded-xl border-gray-300 bg-white text-gray-800 shadow-sm focus:border-gray-400 focus:ring-gray-300"
                    v-model="form.email" required autocomplete="username" placeholder="Masukkan email" />

                <InputError class="mt-2 text-sm" :message="form.errors.email" />
            </div>

            <!-- Verifikasi Email -->
            <div v-if="mustVerifyEmail && user.email_verified_at === null"
                class="rounded-2xl border border-yellow-200 bg-yellow-50 p-5">
                <p class="text-sm text-gray-700">
                    Alamat email Anda belum diverifikasi.
                </p>

                <Link :href="route('verification.send')" method="post" as="button"
                    class="mt-3 rounded-xl bg-gray-800 px-5 py-2 text-sm font-medium text-white transition hover:bg-gray-700">
                    Kirim Ulang Verifikasi
                </Link>

                <Transition enter-active-class="transition duration-300 ease-out"
                    enter-from-class="opacity-0 translate-y-2" leave-active-class="transition duration-200 ease-in"
                    leave-to-class="opacity-0">
                    <div v-show="status === 'verification-link-sent'"
                        class="mt-3 rounded-xl bg-green-100 px-4 py-3 text-sm font-medium text-green-700">
                        Link verifikasi berhasil dikirim ulang.
                    </div>
                </Transition>
            </div>

            <!-- Tombol -->
            <div class="flex items-center gap-4 pt-2">
                <PrimaryButton :disabled="form.processing"
                    class="rounded-xl bg-gray-900 px-6 py-3 text-sm font-semibold text-white shadow-md transition duration-300 hover:bg-gray-800">
                    Simpan Perubahan
                </PrimaryButton>

                <Transition enter-active-class="transition duration-300 ease-out"
                    enter-from-class="opacity-0 translate-x-2" leave-active-class="transition duration-200 ease-in"
                    leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful"
                        class="rounded-xl bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700">
                        ✔ Berhasil disimpan
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>

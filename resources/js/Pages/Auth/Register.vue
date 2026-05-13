<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () =>
            form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register MyKas" />

        <!-- Header -->
        <div class="mb-5 text-center">
            <h2 class="text-2xl font-bold text-gray-800">
                Buat Akun
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Daftar untuk mulai mengelola keuangan
            </p>
        </div>

        <!-- Form -->
        <form @submit.prevent="submit" class="space-y-4">

            <!-- Nama -->
            <div>
                <InputLabel
                    for="name"
                    value="Nama Lengkap"
                    class="text-gray-700"
                />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full rounded-2xl border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Masukkan nama lengkap"
                />

                <InputError
                    class="mt-1"
                    :message="form.errors.name"
                />
            </div>

            <!-- Email -->
            <div>
                <InputLabel
                    for="email"
                    value="Email"
                    class="text-gray-700"
                />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full rounded-2xl border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                    v-model="form.email"
                    required
                    autocomplete="username"
                    placeholder="Masukkan email"
                />

                <InputError
                    class="mt-1"
                    :message="form.errors.email"
                />
            </div>

            <!-- Password -->
            <div>
                <InputLabel
                    for="password"
                    value="Password"
                    class="text-gray-700"
                />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full rounded-2xl border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    placeholder="Masukkan password"
                />

                <InputError
                    class="mt-1"
                    :message="form.errors.password"
                />
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <InputLabel
                    for="password_confirmation"
                    value="Konfirmasi Password"
                    class="text-gray-700"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full rounded-2xl border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Ulangi password"
                />

                <InputError
                    class="mt-1"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <!-- Redirect Login -->
            <div class="text-center pt-1">
                <p class="text-sm text-gray-600">
                    Sudah punya akun?
                    <Link
                        :href="route('login')"
                        class="font-semibold text-blue-600 transition hover:text-blue-800"
                    >
                        Masuk
                    </Link>
                </p>
            </div>

            <!-- Button -->
            <button
                type="submit"
                :disabled="form.processing"
                class="w-full rounded-2xl bg-gradient-to-r from-blue-700 to-cyan-500 py-2.5 text-base font-semibold text-white shadow-lg transition duration-300 hover:scale-[1.01] hover:from-blue-800 hover:to-cyan-600 disabled:opacity-50"
            >
                {{
                    form.processing
                        ? 'Loading...'
                        : 'Daftar Sekarang'
                }}
            </button>
        </form>
    </GuestLayout>
</template>

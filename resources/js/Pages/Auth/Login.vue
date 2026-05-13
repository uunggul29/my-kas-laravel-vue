<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Login MyKas" />

        <!-- Header -->
        <div class="mb-6 text-center">
            <h2 class="text-3xl font-bold text-gray-800">
                Selamat Datang
            </h2>

            <p class="mt-2 text-gray-500">
                Silakan masuk untuk melanjutkan
            </p>
        </div>

        <!-- Status -->
        <div v-if="status" class="mb-4 rounded-xl bg-green-100 px-4 py-3 text-sm font-medium text-green-700">
            {{ status }}
        </div>

        <!-- Form -->
        <form @submit.prevent="submit" class="space-y-5">

            <!-- Email -->
            <div>
                <InputLabel for="email" value="Email" class="text-gray-700" />

                <div class="relative mt-2">
                    <TextInput id="email" type="email"
                        class="block w-full rounded-2xl border-gray-300 py-3 pl-4 pr-4 focus:border-blue-500 focus:ring-blue-500"
                        v-model="form.email" required autofocus autocomplete="username" placeholder="Masukkan email" />
                </div>

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between">
                    <InputLabel for="password" value="Password" class="text-gray-700" />
                </div>

                <div class="relative mt-2">
                    <TextInput id="password" type="password"
                        class="block w-full rounded-2xl border-gray-300 py-3 pl-4 pr-4 focus:border-blue-500 focus:ring-blue-500"
                        v-model="form.password" required autocomplete="current-password"
                        placeholder="Masukkan password" />
                </div>

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <!-- Button -->
            <button type="submit" :disabled="form.processing"
                class="w-full rounded-2xl bg-gradient-to-r from-blue-700 to-cyan-500 py-3 text-lg font-semibold text-white shadow-lg transition duration-300 hover:scale-[1.02] hover:from-blue-800 hover:to-cyan-600 disabled:opacity-50">
                {{ form.processing ? 'Loading...' : 'Login' }}
            </button>

            <!-- Register Redirect -->
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun?
                    <Link :href="route('register')" class="font-semibold text-blue-600 transition hover:text-blue-800">
                        Daftar sekarang
                    </Link>
                </p>
            </div>
        </form>
    </GuestLayout>
</template>

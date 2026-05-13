<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }

            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section class="rounded-3xl border border-gray-100 bg-white p-8 shadow-2xl">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex items-center gap-4">
                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-700" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2h-1V9a5 5 0 00-10 0v2H6a2 2 0 00-2 2v6a2 2 0 002 2zm3-10V9a3 3 0 016 0v2H9z" />
                    </svg>
                </div>

                <div>
                    <h2 class="text-3xl font-bold text-gray-800">
                        Ubah Password
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Gunakan password yang kuat agar akun Anda tetap aman.
                    </p>
                </div>
            </div>
        </header>

        <!-- Form -->
        <form @submit.prevent="updatePassword" class="space-y-6">
            <!-- Password Lama -->
            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                <InputLabel for="current_password" value="Password Saat Ini"
                    class="mb-2 text-sm font-semibold text-gray-700" />

                <TextInput id="current_password" ref="currentPasswordInput" v-model="form.current_password"
                    type="password"
                    class="block w-full rounded-xl border-gray-300 bg-white text-gray-800 shadow-sm focus:border-gray-400 focus:ring-gray-300"
                    autocomplete="current-password" placeholder="Masukkan password saat ini" />

                <InputError :message="form.errors.current_password" class="mt-2 text-sm" />
            </div>

            <!-- Password Baru -->
            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                <InputLabel for="password" value="Password Baru" class="mb-2 text-sm font-semibold text-gray-700" />

                <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                    class="block w-full rounded-xl border-gray-300 bg-white text-gray-800 shadow-sm focus:border-gray-400 focus:ring-gray-300"
                    autocomplete="new-password" placeholder="Masukkan password baru" />

                <InputError :message="form.errors.password" class="mt-2 text-sm" />
            </div>

            <!-- Konfirmasi Password -->
            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                <InputLabel for="password_confirmation" value="Konfirmasi Password"
                    class="mb-2 text-sm font-semibold text-gray-700" />

                <TextInput id="password_confirmation" v-model="form.password_confirmation" type="password"
                    class="block w-full rounded-xl border-gray-300 bg-white text-gray-800 shadow-sm focus:border-gray-400 focus:ring-gray-300"
                    autocomplete="new-password" placeholder="Ulangi password baru" />

                <InputError :message="form.errors.password_confirmation" class="mt-2 text-sm" />
            </div>

            <!-- Tombol -->
            <div class="flex items-center gap-4 pt-2">
                <PrimaryButton :disabled="form.processing"
                    class="rounded-xl bg-gray-900 px-6 py-3 text-sm font-semibold text-white shadow-md transition duration-300 hover:bg-gray-800">
                    Simpan Password
                </PrimaryButton>

                <Transition enter-active-class="transition duration-300 ease-out"
                    enter-from-class="opacity-0 translate-x-2" leave-active-class="transition duration-200 ease-in"
                    leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful"
                        class="rounded-xl bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700">
                        ✔ Password berhasil diperbarui
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>

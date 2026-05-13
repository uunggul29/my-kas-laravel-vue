<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="rounded-3xl border border-red-100 bg-white p-8 shadow-2xl">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex items-center gap-4">
                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-red-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h10" />
                    </svg>
                </div>

                <div>
                    <h2 class="text-3xl font-bold text-gray-800">
                        Hapus Akun
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Menghapus akun akan menghapus seluruh data secara permanen.
                    </p>
                </div>
            </div>
        </header>

        <!-- Warning Box -->
        <div class="rounded-2xl border border-red-200 bg-red-50 p-5 text-sm text-gray-700">
            Setelah akun dihapus, semua data, informasi, dan resource akun Anda
            tidak dapat dikembalikan lagi. Pastikan Anda sudah menyimpan data
            penting sebelum melanjutkan.
        </div>

        <!-- Button -->
        <div class="mt-6">
            <DangerButton @click="confirmUserDeletion"
                class="rounded-xl bg-red-500 px-6 py-3 text-sm font-semibold text-white shadow-md transition duration-300 hover:bg-red-600">
                Hapus Akun
            </DangerButton>
        </div>

        <!-- Modal -->
        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-8">
                <!-- Modal Header -->
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-red-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-red-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M5.07 19H18.93c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.338 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">
                            Konfirmasi Hapus Akun
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Tindakan ini tidak dapat dibatalkan.
                        </p>
                    </div>
                </div>

                <!-- Description -->
                <p class="mt-6 text-sm leading-relaxed text-gray-600">
                    Untuk melanjutkan proses penghapusan akun, silakan masukkan
                    password Anda sebagai konfirmasi keamanan.
                </p>

                <!-- Input -->
                <div class="mt-6">
                    <InputLabel for="password" value="Password" class="mb-2 text-sm font-semibold text-gray-700" />

                    <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                        class="block w-full rounded-xl border-gray-300 bg-white text-gray-800 shadow-sm focus:border-red-300 focus:ring-red-200"
                        placeholder="Masukkan password" @keyup.enter="deleteUser" />

                    <InputError :message="form.errors.password" class="mt-2 text-sm" />
                </div>

                <!-- Actions -->
                <div class="mt-8 flex justify-end gap-3">
                    <SecondaryButton @click="closeModal"
                        class="rounded-xl border border-gray-300 bg-white px-5 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100">
                        Batal
                    </SecondaryButton>

                    <DangerButton
                        class="rounded-xl bg-red-500 px-5 py-2 text-sm font-semibold text-white shadow-md transition duration-300 hover:bg-red-600"
                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="deleteUser">
                        Ya, Hapus Akun
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>

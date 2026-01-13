<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
//import { Head, useForm } from '@inertiajs/inertia-vue3';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <BreezeGuestLayout class="relative text-white">
        <div class="px-8 lg:px-32 relative overflow-hidden min-h-full ">
            <div class="w-full h-full opacity-20  blur-lg absolute top-0 left-0 bg-black"></div>
            <div class="py-24    lg:py-32 relative">
                <div class="text-xl font-bold w-full lg:pb-24">
                    <div class="w-full font-bold text-xl lg:text-3xl text-center text-white">Mot de passe oublié</div>
                </div>
            </div>
            <Head title="Forgot Password" />

            <div class="mb-4 text-sm text-white">
                Vous avez oublié votre mot de passe ? Pas de problème. Indiquez-nous votre adresse électronique et nous vous enverrons un lien de réinitialisation du mot de passe qui vous permettra d'en choisir un nouveau.    </div>

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <!-- <BreezeValidationErrors class="mb-4" /> -->
            <div class="flex flex-wrap justify-center relative w-full pb-16 lg:pb-24">
                <form @submit.prevent="submit">
                    <div>
                        <BreezeLabel for="email" value="Email"  class=" text-white"/>
                        <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Email Password Reset Link
                        </BreezeButton>
                    </div>
                </form>
            </div>
        </div>
    </BreezeGuestLayout>
</template>

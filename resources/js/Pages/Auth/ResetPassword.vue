<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <BreezeGuestLayout class="relative text-white">
        <div class="px-8 lg:px-32 relative overflow-hidden min-h-full ">
            <div class="w-full h-full opacity-20  blur-lg absolute top-0 left-0 bg-black"></div>
            <div :class="'h-screen'" class=" w-full">
                <div class="pt-8 px-4 md:pt-16 md:px-16 lg:pt-32 lg:px-32">
                <div class="py-24    lg:py-32 relative">
                    <div class="text-xl font-bold w-full lg:pb-24">
                        <div class="w-full font-bold text-xl lg:text-3xl text-center text-white">Renouveler le mot de passe</div>
                    </div>
                </div>
                    <Head title="Reset Password" />

                    <!-- <BreezeValidationErrors class="mb-4" /> -->

                    <form @submit.prevent="submit">
                        <div>
                            <BreezeLabel  class=" text-white" for="email" value="Email" />
                            <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username" />
                        </div>

                        <div class="mt-4">
                            <BreezeLabel  class=" text-white" for="password" value="Password" />
                            <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
                        </div>

                        <div class="mt-4">
                            <BreezeLabel  class=" text-white" for="password_confirmation" value="Confirm Password" />
                            <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Reset Password
                            </BreezeButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </BreezeGuestLayout>
</template>

<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/GuestAbsolute.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
//import { Head, useForm } from '@inertiajs/inertia-vue3';
import { Head, useForm } from '@inertiajs/vue3';

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
        <div :style="'background-image: url(/storage/home/login2.jpg)'" class="bg-cover bg-center w-full h-screen absolute top-0 left-0 blur-lg hidden md:block"></div>
        <div :style="'background-image: url(/storage/home/login2.jpg)'" class="bg-cover bg-center w-full h-screen absolute top-0 left-0 blur-lg block md:hidden"></div>
        <div class="w-full h-full opacity-20  blur-lg absolute top-0 left-0 bg-black"></div>
        <div class="px-8 md:px-16 lg:px-32 relative overflow-hidden min-h-full ">
            <div class="relative">
                <div class="">
                <div class="pt-32  relative">
                    <div class="text-xl font-bold w-full py-8 md:py-16 lg:py-16">
                        <div class="w-full font-bold text-xl lg:text-3xl text-center text-white">Réinitialiser le mot de passe</div>
                    </div>
                </div>
                    <Head title="Reset Password" />

                    <!-- <BreezeValidationErrors class="mb-4" /> -->
                    <div class="flex flex-wrap justify-center relative">
                        <form @submit.prevent="submit" class="w-full lg:w-1/3">
                            <div>
                                <BreezeLabel  class=" text-white" for="email" value="Email" />
                                <BreezeInput id="email" type="email" class="mt-1 block w-full text-black" v-model="form.email" required autofocus autocomplete="username" />
                            </div>

                            <div class="mt-4">
                                <BreezeLabel  class=" text-white" for="password" value="Mot de passe" />
                                <BreezeInput id="password" type="password" class="mt-1 block w-full text-black" v-model="form.password" required autocomplete="new-password" />
                            </div>

                            <div class="mt-4">
                                <BreezeLabel  class=" text-white" for="password_confirmation" value="Confirmer le mot de passe" />
                                <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full text-black" v-model="form.password_confirmation" required autocomplete="new-password" />
                            </div>
                            <div>
                                <div class="w-full error-msg" v-if="form.errors.email">{{ form.errors.email }}</div>
                                <div class="w-full error-msg" v-if="form.errors.password">{{ form.errors.password }}</div>
                                <div class="w-full error-msg" v-if="form.errors.password_confirmation">{{ form.errors.password_confirmation }}</div>
                            </div>

                            <div class="flex justify-center mt-4">
                                <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Réinitialiser le mot de passe
                                </BreezeButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeGuestLayout>
</template>

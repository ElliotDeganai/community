<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeGuestLayout from '@/Layouts/GuestAbsolute.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
//import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <BreezeGuestLayout class="relative text-white">
        <div :style="'background-image: url(/storage/home/login2.jpg)'" class="bg-cover bg-center w-full h-screen absolute top-0 left-0 blur-lg hidden md:block"></div>
        <div :style="'background-image: url(/storage/home/login2.jpg)'" class="bg-cover bg-center w-full h-screen absolute top-0 left-0 blur-lg block md:hidden"></div>
        <div class="w-full h-full opacity-20  blur-lg absolute top-0 left-0 bg-black"></div>
        <div class="container-px-lg relative overflow-hidden flex flex-wrap justify-center content-center h-screen">
            <div class="w-full ">
                <div class="font-bold w-full ">
                    <div class="w-full font-bold section-title text-center text-white">Connecte-toi</div>
                </div>
            </div>
            <Head title="Log in" />

            <!-- <BreezeValidationErrors class="mb-4" /> -->

            <div v-if="status" class="my-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <div class="flex flex-wrap justify-center content-center relative w-full ">
                <form class="w-full lg:w-1/3" @submit.prevent="submit">
                    <div>
                        <BreezeLabel class="text-white" for="email" value="Email" />
                        <BreezeInput id="email" type="email" class="mt-1 block w-full text-slate-900 form-fields" placeholder="email@hotmail.com" v-model="form.email" required autofocus autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <BreezeLabel class="text-white" for="password" value="Password" />
                        <BreezeInput id="password" type="password" class="mt-1 block w-full text-slate-900 " v-model="form.password" required autocomplete="current-password" />
                    </div>
                    <div>
                        <div class="w-full error-msg" v-if="form.errors.email">{{ form.errors.email }}</div>
                        <div class="w-full error-msg" v-if="form.errors.password">{{ form.errors.password }}</div>
                    </div>

                        <!--                     <div class="block mt-4">
                        <label class="flex items-center">
                            <BreezeCheckbox name="remember" v-model:checked="form.remember" />
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                    </div> -->

                    <div class="flex justify-around mt-4 z-70">
                       <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-white py-4 text-sm z-70">
                            Mot de passe oublié ?
                        </Link>

                        <BreezeButton class="ml-4 z-70" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Connexion
                        </BreezeButton>
                    </div>
                </form>
            </div>
        </div>
    </BreezeGuestLayout>
</template>

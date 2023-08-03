<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

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
        <div :style="'background-image: url(/storage/home/login.jpg)'" class="bg-cover bg-center w-full h-screen absolute top-0 left-0 blur-lg"></div>
        <div class="px-8 lg:px-32 relative overflow-hidden ">
<!--             <div class="pt-32 w-full h-full absolute top-0 left-0">
                <div class="w-full h-full flex flex-wrap">
                    <div class="w-1/4" :key="i" v-for="i in 24">
                        <div class="w-full py-8 flex flex-wrap justify-center content-center items-stretch text-xs md:text-sm ">
                            <a class="self-center px-2" href="https://www.elliot-deganai.com/">
                                <img :src="'/storage/base/ED_2_Noir_Sans_fond_no_space.png'" class="object-contain h-6 md:h-16 " alt="" />
                            </a>
                        </div>
                    </div>
                </div>
                <div class="w-full h-full opacity-95 absolute top-0 left-0 bg-white"></div>
            </div> -->
            <div class="py-24    lg:py-32 relative">
                <div class="text-xl font-bold w-full lg:pb-24">
                    <div class="w-full font-bold text-xl lg:text-3xl text-center text-white">Connecte-toi</div>
                </div>
            </div>
            <Head title="Log in" />

            <BreezeValidationErrors class="mb-4" />

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <div class="flex flex-wrap justify-center relative w-full pb-16 lg:pb-24">
                <form class="w-full lg:w-1/3" @submit.prevent="submit">
                    <div>
                        <BreezeLabel class="text-white" for="email" value="Email" />
                        <BreezeInput id="email" type="email" class="mt-1 block w-full" placeholder="email@hotmail.com" v-model="form.email" required autofocus autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <BreezeLabel class="text-white" for="password" value="Password" />
                        <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
                    </div>
                    <div>
                        <div class="text-red-700" v-if="form.errors.email">{{ form.errors.email }}</div>
                        <div class="text-red-700" v-if="form.errors.password">{{ form.errors.password }}</div>
                    </div>

<!--                     <div class="block mt-4">
                        <label class="flex items-center">
                            <BreezeCheckbox name="remember" v-model:checked="form.remember" />
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                    </div> -->

                    <div class="flex justify-around mt-4">
<!--                         <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-white py-4 text-sm ">
                            Forgot your password?
                        </Link> -->

                        <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Log in
                        </BreezeButton>
                    </div>
                </form>
            </div>
        </div>
    </BreezeGuestLayout>
</template>

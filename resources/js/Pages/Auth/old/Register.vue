<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
//import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { Head, Link, useForm } from '@inertiajs/vue3';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';

defineProps({
    getroles: Array,
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    roles: [],
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const isChecked = (role) => {
    //console.log(this.form.roles.find(roleU => roleU.id === role.id) !== undefined, role.name)
    return form.roles.find(roleU => roleU === role.id) !== undefined;
};
const CheckRole = (role) => {
    form.roles.find(roleU => roleU === role.id) === undefined ?
    form.roles.push(role.id) : form.roles.splice(form.roles.indexOf(role.id), 1);
}


</script>

<template>
    <BreezeAuthenticatedLayout>
        <div class="px-32 relative h-full">
            <div class="pt-32 w-full h-full absolute top-0 left-0">
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
            </div>
            <div class="py-32 relative">
                <div class="text-xl font-bold w-full">
                    <div class="w-full font-bold text-5xl uppercase text-center">Register a new user</div>
                </div>
            </div>
            <Head title="Register" />

            <BreezeValidationErrors class="mb-4" />

            <div class="flex flex-wrap justify-center relative w-full">
                <form @submit.prevent="submit" class="relative w-1/3">
                    <div>
                        <BreezeLabel for="name" value="Name" />
                        <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                    </div>

                    <div class="mt-4">
                        <BreezeLabel for="email" value="Email" />
                        <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <BreezeLabel for="password" value="Password" />
                        <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
                    </div>

                    <div class="mt-4">
                        <BreezeLabel for="password_confirmation" value="Confirm Password" />
                        <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
                    </div>

                    <div class="py-4">
                        <div class="label-fields">Roles</div>
                        <div class="checkbox py-4 flex flex-wrap" :key="role.id" v-for="role in getroles">
                            <label class="label-fields">
                                <input type="checkbox" :name="'roles'+role.id" :value="role"
                                @change="CheckRole(role)" :checked="isChecked(role)"/>
                                {{role.name}}
                            </label>
                        </div>
                    </div>

                    <div class="flex flex-wrap justify-between w-full mt-4">
                        <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                            Already registered?
                        </Link>

                        <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Register
                        </BreezeButton>
                    </div>
                </form>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

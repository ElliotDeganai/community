<script setup>
import { ref } from 'vue';
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
import BreezeNavLink from '@/Components/NavLink.vue';
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
//import { Link } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/vue3'
import { mapState } from 'vuex';
import {computed} from "vue";
import {useStore} from "vuex";

const store = useStore();
const modal = computed(() => store.state.delete_modal);
const delete_model = computed(() => store.state.model);
const delete_route = computed(() => store.state.delete_route);
const delete_type = computed(() => store.state.type);

const showingNavigationDropdown = ref(false);

</script>

<template>
    <div :class="[modal ? 'h-screen overflow-hidden' : '']" class="relative">
        <div class="min-h-screen relative">
            <nav class="bg-white border-b  z-50 border-gray-200 fixed top-0 w-full">
                <!-- Primary Navigation Menu -->
                <div class=" mx-auto px-4 sm:px-6 lg:px-16">
                    <div class="flex justify-between h-16">
                        <div class="flex flex-wrap">
                            <!-- Logo -->
                            <Link :href="route('admin')" class="shrink-0 flex items-center">
                                <div class="h-16">
                                    <!-- <BreezeApplicationLogo class="block h-9 w-auto" /> -->
                                    <img :src="'/storage/base/ED_2_Noir_Sans_fond_no_space.png'" alt="" class="h-full" />
                                </div>
                                <div class="text-2xl font-bold">CMS</div>
                            </Link>
                            <!-- Navigation Links -->
                            <div class="hidden sm:flex sm:items-center sm:ml-6">
                                <!-- Settings Dropdown -->
                                <div class="ml-3 relative flex">
                                    <BreezeDropdown v-if="$page.props.auth.isDev || $page.props.auth.isAdmin || $page.props.auth.isEditor" align="right" width="48">
                                        <template #trigger>
                                            <span class="inline-flex py-2  rounded-md">
                                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                    Pages

                                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <BreezeDropdownLink :href="route('pages.index')" method="get" as="button">
                                                Page List
                                            </BreezeDropdownLink>

                                            <BreezeDropdownLink v-if="$page.props.auth.isDev" :href="route('pages.create')" method="get" as="button">
                                                New Page
                                            </BreezeDropdownLink>
                                        </template>
                                    </BreezeDropdown>
                                    <BreezeDropdown v-if="$page.props.auth.isDev" align="right" width="48">
                                        <template #trigger>
                                            <span class="inline-flex py-2 rounded-md">
                                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                    Templates

                                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <BreezeDropdownLink :href="route('categories.index')" method="get" as="button">
                                                Template List
                                            </BreezeDropdownLink>

                                            <BreezeDropdownLink :href="route('categories.create')" method="get" as="button">
                                                New template
                                            </BreezeDropdownLink>
                                        </template>
                                    </BreezeDropdown>
                                    <BreezeDropdown v-if="!$page.props.auth.isClient" align="right" width="48">
                                        <template #trigger>
                                            <span class="inline-flex py-2  rounded-md">
                                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                    Resources

                                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <BreezeDropdownLink :href="route('posts.index')" method="get" as="button">
                                                Resources List
                                            </BreezeDropdownLink>

                                            <BreezeDropdownLink :href="route('posts.create')" method="get" as="button">
                                                New Resource
                                            </BreezeDropdownLink>
                                        </template>
                                    </BreezeDropdown>
                                    <BreezeDropdown v-if="$page.props.auth.isDev" align="right" width="48">
                                        <template #trigger>
                                            <span class="inline-flex py-2  rounded-md">
                                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                    Settings

                                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <BreezeDropdownLink :href="route('posts.index_type', 'Text')" method="get" as="button">
                                                Free Text
                                            </BreezeDropdownLink>
                                            <BreezeDropdownLink :href="route('posts.index_type', 'Contact Forms')" method="get" as="button">
                                                Contact Form
                                            </BreezeDropdownLink>
                                            <BreezeDropdownLink :href="route('posts.index_type', 'FAQs')" method="get" as="button">
                                                FAQ
                                            </BreezeDropdownLink>

                                            <BreezeDropdownLink :href="route('posts.index_type', 'Footers')" method="get" as="button">
                                                Footer
                                            </BreezeDropdownLink>
                                        </template>
                                    </BreezeDropdown>

                                    <Link v-if="$page.props.auth.isDev || $page.props.auth.isAdmin || $page.props.auth.isEditor" :href="route('users.index')" class="py-3 px-3 items-center">Manage Users</Link>

                                    <div class="px-8 py-2">
                                        <Link :href="route('home')" class="shrink-0 flex items-center px-3 py-2 bg-slate-900 rounded-md font-bold text-white">See Website</Link>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <BreezeDropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <BreezeDropdownLink :href="route('admin')" as="button">
                                            Admin
                                        </BreezeDropdownLink>
                                        <BreezeDropdownLink v-if="($page.props.auth.isDev || $page.props.auth.isAdmin || $page.props.auth.isEditor || $page.props.auth.isCollaborator) && $page.props.calendar == 1" :href="route('calendar.index')" as="button">
                                            Gérer mes RDV
                                        </BreezeDropdownLink>
                                        <BreezeDropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </BreezeDropdownLink>
                                    </template>
                                </BreezeDropdown>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">{{ $page.props.auth.user.name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <BreezeResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </BreezeResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
            <div class="w-full py-8 flex flex-wrap justify-center content-center items-stretch text-xs md:text-sm ">

                    <div class="self-center">Made by </div>
                    <a class="self-center px-2" href="https://www.elliot-deganai.com/">
                        <img :src="'/storage/base/ED_2_Noir_Sans_fond_no_space.png'" class="object-contain h-6 md:h-10 " alt="" />
                    </a>
                    <div class="self-center">Web Factory</div>

            </div>
        </div>
        <div v-if="modal && delete_model" @click="$store.commit('UNSET_DELETE_MODAL')" class="z-60 bg-black absolute opacity-75 w-full h-full top-0 left-0"></div>
        <div v-if="modal && delete_model" class="z-60 absolute w-full h-full top-0 left-0 flex flex-wrap justify-center content-center">
            <div class="w-1/4 h-56 p-8 bg-gray-200 rounded-md">
                <div class="font-bold text-2xl">Confirm</div>
                <div class="py-4">You will delete the {{delete_type}} {{delete_model.name}}, Are you sure ?</div>
                <div class="flex flex-wrap justify-around">
                    <button class="" @click="$store.dispatch('unset_model')">Cancel</button>
                    <div class="">
                        <Link @click="$store.dispatch('unset_model')" as="button" data-message="Are you sure ?" class="btn-delete" method="delete" :href="route(delete_route, delete_model.id)" :preserve-state="false">
                            Submit
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

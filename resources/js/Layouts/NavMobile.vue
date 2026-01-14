<template>
    <div class="bg-sky-900 text-white h-full">
            <div class="flex flex-wrap items-center px-1 md:px-4 py-8">
                <div class="base:hidden lg:hidden xl:hidden">
                    <Menu class="cursor-pointer" @click.prevent="toggleLateral" :getSize="5" />
                </div>
                <Link :href="route('home')" class="shrink-0 flex items-center">
                    <div class="h-8 px-1">
                        <img :src="'/storage/base/ED 2 Blanc Sans fond.png'" class="object-contain h-full" alt="" />
                    </div>
                    <div class="text-xs md:text-lg lg:text-2xl font-bold">{{$page.props.app_name}}</div>
                </Link>
            </div>
            <div class="px-2 md:px-8 py-2">
                <Link :href="route('home')" class="text-xs md:text-base text-center shrink-0 px-1 md:px-3 py-1 md:py-2 bg-white rounded-md font-bold text-sky-900">See Website</Link>
            </div>

            <div v-if="$page.props.pages.length > 0" class=" block base:hidden lg:hidden xl:hidden flex-wrap justify-around" >
                <div :class="[((page.url_name !== 'home' && page.url_name !== 'resume')  && $page.props.auth.user) || (page.url_name === 'resume' && $page.props.auth.user && !$page.props.auth.isClient && !$page.props.auth.isEditor) ? '' : 'hidden']" class="py-2 px-3 shrink-0 flex flex-wrap justify-between" :key="page.id" v-for="page in $page.props.pages">
                    <Link v-if="((page.url_name !== 'home' && page.url_name !== 'resume')  && $page.props.auth.user) || (page.url_name === 'resume' && $page.props.auth.user && !$page.props.auth.isClient && !$page.props.auth.isEditor)" :href="route(page.url_name)" :class="[page.id === $page.props.getpage.id ? 'underline underline-offset-8' : '']" class="shrink-0 uppercase flex items-center font-bold">{{ page.title }}</Link>
                </div>
            </div>
            <div class="flex items-center md:ml-6">
                <!-- Settings Dropdown -->
                <div class="md:ml-3 relative md:flex">
                    <BreezeDropdown class="mx-2" v-if="$page.props.auth.isDev || $page.props.auth.isAdmin || $page.props.auth.isEditor" align="left" width="48">
                        <template #trigger>
                            <span class="inline-flex py-2  rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-xs md:text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
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
                    <BreezeDropdown class="mx-2" v-if="$page.props.auth.isDev" align="left" width="48">
                        <template #trigger>
                            <span class="inline-flex py-2 rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-xs md:text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
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
                    <BreezeDropdown class="mx-2" v-if="!$page.props.auth.isClient" align="left" width="48">
                        <template #trigger>
                            <span class="inline-flex py-2  rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-xs md:text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
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
                    <BreezeDropdown class="mx-2" v-if="$page.props.auth.isDev" align="left" width="48">
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
                            <BreezeDropdownLink :href="route('posts.index_type', 'Legal')" method="get" as="button">
                                Free Text
                            </BreezeDropdownLink>
                            <BreezeDropdownLink :href="route('posts.index_type', 'Contact Form')" method="get" as="button">
                                Contact Form
                            </BreezeDropdownLink>
                            <BreezeDropdownLink :href="route('posts.index_type', 'FAQ')" method="get" as="button">
                                FAQ
                            </BreezeDropdownLink>
                        </template>
                    </BreezeDropdown>

                    <Link v-if="$page.props.auth.isDev || $page.props.auth.isAdmin || $page.props.auth.isEditor" :href="route('users.index')" class="py-3 px-3 items-center">Manage Users</Link>

                </div>
            </div>
    </div>
</template>
<script>
//import { Link } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/vue3'
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
import BreezeNavLink from '@/Components/NavLink.vue';
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import DocValue from '../Pages/Home/Help/DocumentationValue.vue'
import Palm from '../Pages/Help/Icon/Palm.vue'
import store from '../Store/index'
import Vuex from "vuex";
import Modal from './Help/Modal.vue'
import Cart from '../Pages/Help/Icon/Cart.vue'
import Menu from '../Pages/Help/Icon/Menu.vue'
import Loading from '../Pages/Home/Client/Help/Loading.vue';

export default {
    components: {Link, BreezeDropdown, BreezeDropdownLink, BreezeNavLink, BreezeResponsiveNavLink, BreezeApplicationLogo, DocValue, Modal, Cart, Palm, Loading, Menu},
    store: store,
    //layout: BreezeGuestLayout,
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
        getpages: Array
    },
    data() {
        return {
            pages: this.getpages,
            scrollPosition: null,
            siteReady: false,
            loadingUp: true,
        }
    },
    methods: {
        ...Vuex.mapActions([
            "setDb", "getCardItems", "unset_product_modal",
            "saveCartItem", "addCartItemQuantity"
        ]),
        setProductCart(product){
            let product_in_cart = this.cart.filter(item => item.id == product.id);
            if (product_in_cart.length == 0) {
                let cart_item = {
                    product: product,
                    quantity: 1
                };
                //console.log(cart_item)
                this.saveCartItem(cart_item);
            } else {
                this.addCartItemQuantity(product_in_cart[0]);
            }
        },
        updateScroll() {
            this.scrollPosition = window.pageYOffset;
        },
        onSiteReady(){
        //this.loadingUp = !this.loadingUp;
            let self = this;
        setTimeout(function(){
            self.textClass='';
            self.siteReady = true;
            }, 3000);
        },
        loadingSite(){
            let self = this;
            setTimeout(function(){
                //self.textClass='';
                self.loadingUp = false;
            }, 1000);
        },
        fadeLoading(){
            this.loadingUp = false;
        },
        toggleLateral(){
            this.$emit('toggleLateral');
        }
    },
    computed:{
        ...Vuex.mapState([
            "cart", "product"
        ]),
        getScroll() {
            return this.scrollPosition;
        },
        isLoading() {
            return this.loadingUp && this.$page.url === '/';
        }
    },
    async created() {
        await this.$store.dispatch('setDb');
        this.$store.dispatch('setCartProducts', this.$page.props.posts);
        await this.$store.dispatch('getCartItems');
    },
    mounted() {
        window.addEventListener('scroll', this.updateScroll);
        this.loadingSite();
        console.log(this.$page.url)
    },
}
</script>
<style>



    .loading-fade-leave-active{
        animation: LoadingFadeOut 2s 1s ease-in-out;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
    }

    @keyframes LoadingFadeOut{
        from{ opacity: 1; }
        to{ opacity: 0; }
    }


</style>

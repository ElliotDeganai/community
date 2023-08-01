<template>
    <div class="bg-amber-50  relative" style="font-family:  'Kalam', cursive;">

        <div class="w-full h-full flex flex-wrap absolute top-0 left-0 overflow-hidden">
            <div class="w-1/4 hidden lg:inline" :key="i" v-for="i in 24">
                <div class="w-full py-4 flex flex-wrap justify-center content-center items-stretch text-xs md:text-sm ">
                    <Palm :getSize="10" />
                </div>
            </div>
            <div :class="[]" class="w-1/4 inline lg:hidden" :key="i" v-for="i in 48">
                <div class="w-full py-1 lg:py-4 flex flex-wrap justify-center content-center items-stretch text-xs md:text-sm ">
                    <Palm :getSize="10" />
                </div>
            </div>
        </div>
        <div :class="[product ? 'h-screen overflow-hidden' : 'min-h-screen h-full']" class="relative ">
            <nav :class="[scrollPosition === null || scrollPosition < 0.1 ? 'text-white' : 'bg-amber-50 text-amber-900']" class="border-b fixed top-0 w-full border-gray-200 z-60">
                <!-- Primary Navigation Menu -->
                <div class=" mx-auto px-4 sm:px-6 lg:px-16">
                    <div class="flex justify-between h-16">
                        <div class="flex ">
                            <!-- Logo -->
                            <Link :href="route('home')" class="shrink-0 flex items-center">
                                <div class="h-16">
                                    <!-- <BreezeApplicationLogo class="block h-9 w-auto" /> -->
                                    <img :src="'../storage/home/level35.png'" alt="" class="h-full" />
                                </div>
                                <div class="text-lg lg:text-2xl font-bold">Level 35</div>
                            </Link>
                        </div>
<!--                         <div>
                            <router-link to="/default">Go to Home</router-link>
                        </div> -->
                        <div v-if="$page.props.pages.length > 0" class="flex flex-wrap justify-around w-1/3" >
                            <div class="py-2 px-3 shrink-0 flex flex-wrap justify-between" :key="page.id" v-for="page in $page.props.pages">
                                <Link v-if="page.url_name !== 'home'" :href="route(page.url_name)" class="shrink-0 uppercase flex items-center font-bold">{{ page.title }}</Link>
                            </div>
                        </div>
                        <div v-if="$page.props.is_ecommerce == 1" class="py-2 px-3 shrink-0 flex items-center" >
                            <Link :href="route('checkout')" class="text-white font-bold px-3 py-2 bg-sky-900 flex flex-wrap rounded-full">
                                <span class="pr-4"><Cart :getSize="5" /></span>
                                <span>Cart {{ cart.length }}</span>
                            </Link>
                        </div>

                        <div v-if="$page.props.auth.user" class="sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="lg:ml-3 relative">
                                <BreezeDropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white/75 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                <span class="text-xs lg:text-base">{{ $page.props.auth.user.name }}</span>
                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <BreezeDropdownLink v-if="$page.props.auth.isDev || $page.props.auth.isAdmin || $page.props.auth.isEditor" :href="route('admin')" as="button">
                                            Admin
                                        </BreezeDropdownLink>
                                        <BreezeDropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </BreezeDropdownLink>
                                    </template>
                                </BreezeDropdown>
                            </div>
                        </div>
                        <!-- <Link v-else :href="route('login')" class="shrink-0 flex items-center font-bold text-xl text-stone-800 rounded-full px-3 py-2 bg-white">Connecte-toi</Link> -->
                    </div>
                </div>
            </nav>
            <div class="relative h-full min-h-screen">
                <main class="h-full relative">
                    <!-- <div class=" bg-white absolute opacity-90 w-full h-full top-0 left-0"></div> -->
                    <slot class="relative" />
                </main>
                <div v-if="!$page.props.auth.user" class="w-full absolute bottom-0 left-0 h-24 bg-black opacity-50 blur-lg z-50">
                </div>
                <div :class="[$page.props.auth.user ? '' : 'absolute bottom-0 left-0 text-white z-60']"  class="w-full py-8 flex flex-wrap justify-center content-center items-stretch text-xs md:text-sm ">
                    <div class="self-center">Made by </div>
                    <a class="self-center px-2" href="https://www.elliot-deganai.com/">
                        <img v-if="!$page.props.auth.user" :src="'/storage/base/ED 2 Blanc Sans fond.png'" class="object-contain h-6 md:h-10 " alt="" />
                        <img v-else :src="'/storage/base/ED_2_Noir_Sans_fond_no_space.png'" class="object-contain h-6 md:h-10 " alt="" />
                    </a>
                    <div class="self-center">Web Factory</div>
                </div>
                <div v-if="product" @click="unset_product_modal()" class="z-60 bg-black absolute opacity-75 w-full h-full top-0 left-0"></div>
                <Modal v-if="product">
                </Modal>
            </div>
        </div>
    </div>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3';
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

export default {
    components: {Link, BreezeDropdown, BreezeDropdownLink, BreezeNavLink, BreezeResponsiveNavLink, BreezeApplicationLogo, DocValue, Modal, Cart, Palm},
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

    },
    computed:{
        ...Vuex.mapState([
            "cart", "product"
        ]),
        getScroll() {
            return this.scrollPosition;
        }
    },
    async created() {
        await this.$store.dispatch('setDb');
        this.$store.dispatch('setCartProducts', this.$page.props.posts);
        await this.$store.dispatch('getCartItems');
    },
    mounted() {
        window.addEventListener('scroll', this.updateScroll);
    },
}
</script>
<style>
     .navFade-enter-active{
        animation: navFadeInVisibility .4s linear, navFadeIn .4s linear;
        position: absolute;
        left: 0;
        right: 0;

        width: 100%;
    }

       .navFade-leave-active, .navFade-leave-to, .navFade-leave{
        animation: navFadeOutVisibility .4s linear, navFadeOut .4s linear;
        position: absolute !important;

        left: 0;
        right: 0;

        width: 100%;

    }

     @keyframes navFadeIn{
        from{ transform: translateY(-100%); }
        to{ transform: translateY(0); }
    }
    @keyframes navFadeInVisibility{
        from{ opacity: 0; }
        to{ opacity: 1; }
    }

    @keyframes navFadeOut{
        from{ transform: translateY(0); }
        to{ transform: translateY(100%); }

    }

    @keyframes navFadeOutVisibility{
        from{ opacity: 1; }
        to{ opacity: 0; }
    }

    @keyframes top-triggerInVisibility{
        from{ opacity: 0; }
        to{ opacity: 0.5; }
    }

        @keyframes top-triggerOutVisibility{
        from{ opacity: 0.5; }
        to{ opacity: 0; }
    }

     .top-trigger-enter-active{
        animation: top-triggerInVisibility .4s ease, bounce .5s ease-in;
    }

       .top-trigger-leave-active, .navFade-leave-to, .navFade-leave{
        animation: top-triggerOutVisibility .4s ease;
    }

    .bounce {
    animation: bounce 1s .5s;
    }

    @keyframes bounce {
    0% { transform: scale(1);}
    50% { transform: scale(1.6);}
    60% { transform: scale(0.6);}
    80% { transform: scale(0.95);}
    100% { transform: scale(1);}
    }

     .nav-mobile-enter-active{
        animation: nav-mobileInVisibility .4s linear, nav-mobileIn .4s linear;
    }

       .nav-mobile-leave-active, .nav-mobile-leave-to, .nav-mobile-leave{
        animation: nav-mobileOutVisibility .4s linear, nav-mobileOut .4s linear;
    }

     @keyframes nav-mobileIn{
        from{ transform: translateX(-100%); }
        to{ transform: translateX(0); }
    }
    @keyframes nav-mobileInVisibility{
        from{ opacity: 0; }
        to{ opacity: 1; }
    }

    @keyframes nav-mobileOut{
        from{ transform: translateX(0); }
        to{ transform: translateX(-100%); }

    }

    @keyframes nav-mobileOutVisibility{
        from{ opacity: 1; }
        to{ opacity: 0; }
    }

     .nav-mobile-enter-active{
        animation: nav-mobileInVisibility .4s linear, nav-mobileIn .4s linear;
    }


</style>


<template>
    <div class="bg-amber-50  relative" style="font-family:  'Kalam', cursive;">

        <transition name="loading-fade">
            <loading class="z-70" v-if="isLoading"></loading>
        </transition>
        <div v-show="!isLoading">

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
            <div :class="[product ? 'h-screen overflow-hidden' : 'min-h-screen h-full']" class="relative w-full">
                <Navbar @toggleLateral="changeMobileNav" class="" />

                <div class="relative h-full min-h-screen">
                    <main  class="h-full relative">
                        <!-- <div class=" bg-white absolute opacity-90 w-full h-full top-0 left-0"></div> -->
                        <slot class="relative"  />
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
                <div class="relative w-full h-full base:hidden lg:hidden xl:hidden z-70 top-0 left-0">
                    <transition name="nav-mobile">
                        <div v-if="mobileNav" @toggleLateral="changeMobileNav" @click="changeMobileNav" class="z-70 lg:hidden xl:hidden fixed w-full h-full bg-black opacity-75 top-0 left-0">
                        </div>
                    </transition>

                    <transition name="nav-mobile">
                        <div v-if="mobileNav" @toggleLateral="changeMobileNav" @click="changeMobileNav" class="z-70 lg:hidden xl:hidden fixed w-3/5 h-full top-0">
                            <NavMobile class="" />
                        </div>
                    </transition>
                </div>
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
import Loading from '../Pages/Home/Client/Help/Loading.vue';
import Navbar from './Navbar.vue'
import NavMobile from './NavMobile.vue'

export default {
    components: {Link, BreezeDropdown, BreezeDropdownLink, BreezeNavLink, BreezeResponsiveNavLink, BreezeApplicationLogo, DocValue, Modal, Cart, Palm, Loading, Navbar, NavMobile},
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
            mobileNav: false,
            textClass: '',
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

        changeMobileNav(){
            this.mobileNav = !this.mobileNav;
            if(this.mobileNav){
                this.textClass = 'h-screen overflow-hidden'
            }else{
                this.textClass = ''
            }
        },
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


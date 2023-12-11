<template>
    <nav :class="[((scrollPosition === null && $page.url !== '/resume') || (scrollPosition < 0.1 && $page.url !== '/resume')) ? 'text-white border-b' : 'bg-red-900 border-b text-white']" class=" fixed top-0 w-full border-gray-200 z-60">
        <div class=" mx-auto px-4 sm:px-6 lg:px-16">
            <div class="flex justify-between h-16">
                <div class="flex ">
                    <div class="base:hidden lg:hidden xl:hidden">
                        <Menu class="cursor-pointer" @click.prevent="toggleLateral" :getSize="5" />
                    </div>
                    <Link :href="route('home')" class="shrink-0 flex items-center">
                        <div class="h-16 px-2 py-3">
                            <img :src="'../storage/home/claus-2.png'" alt="" class="h-full" />
                        </div>
                        <div class="text-lg lg:text-2xl font-bold">Secret Santa</div>
                    </Link>
                </div>
                <div v-if="$page.props.pages.length > 0" class="base:flex lg:flex xl:flex flex-wrap justify-around hidden sm:hidden " >
                    <div :class="[((page.url_name !== 'home' && page.url_name !== 'resume')  && $page.props.auth.user) || (page.url_name === 'resume' && $page.props.auth.user && !$page.props.auth.isClient && !$page.props.auth.isEditor) ? '' : 'hidden']" class="py-2 px-3 shrink-0 flex flex-wrap justify-between" :key="page.id" v-for="page in $page.props.pages">
                        <Link v-if="((page.url_name !== 'home' && page.url_name !== 'resume')  && $page.props.auth.user) || (page.url_name === 'resume' && $page.props.auth.user && !$page.props.auth.isClient && !$page.props.auth.isEditor)" :href="route(page.url_name)" :class="[$page.props.getpage ? page.id === $page.props.getpage.id : false ? 'underline underline-offset-8' : '']" class="shrink-0 uppercase flex items-center font-bold">{{ page.title }}</Link>
                    </div>
                </div>
                <div v-if="$page.props.is_ecommerce == 1" class="py-2 px-3 shrink-0 flex items-center" >
                    <Link :href="route('checkout')" class="text-white font-bold px-3 py-2 bg-sky-900 flex flex-wrap rounded-full">
                        <span class="pr-4"><Cart :getSize="5" /></span>
                        <span>Cart {{ cart.length }}</span>
                    </Link>
                </div>

                <div v-if="$page.props.auth.user" class="sm:flex sm:items-center sm:ml-6">
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
                                <BreezeDropdownLink v-if="$page.props.auth.isDev || $page.props.auth.isAdmin" :href="route('admin')" as="button">
                                    Admin
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
        <div>
            <transition name="nav">
                <div class="relative overflow-hidden" v-if="$page.props.getpage ? $page.props.getpage.url_name !== 'wishlist' && $page.props.auth.user : false">
                    <div v-if="$page.props.pages.filter(p => p.url_name === 'wishlist')[0]" class="py-3 bg-white text-red-900 w-full text-center flex flex-wrap justify-center">
                        <Link :href="route($page.props.pages.filter(p => p.url_name === 'wishlist')[0].url_name)" class="shrink-0 uppercase flex items-center font-bold">Ma wishlist</Link>
                    </div>
                </div>
            </transition>
        </div>
    </nav>

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
            border: 'border-b'
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
        },
        scrollToRsvp() {
            this.$refs.rsvp.scrollIntoView({ behavior: 'smooth' });
            console.log('gotorsvp')
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
    },
}
</script>
<style scope>
    .loading-fade-leave-active{
        animation: LoadingFadeOut 2s 1s ease-in-out;

    }

    @keyframes LoadingFadeOut{
        from{ opacity: 1; }
        to{ opacity: 0; }
    }

     .nav-enter-active{
        animation: navInVisibility .4s linear, navIn .4s linear;
    }

       .nav-leave-active, .nav-leave-to, .nav-leave{
        animation: navOutVisibility .4s linear, navOut .4s linear;
    }

     @keyframes navIn{
        from{ transform: translateY(-100%); }
        to{ transform: translateY(0); }
    }
    @keyframes navInVisibility{
        from{ opacity: 0; }
        to{ opacity: 1; }
    }

    @keyframes navOut{
        from{ transform: translateY(0); }
        to{ transform: translateY(-100%); }

    }

    @keyframes navOutVisibility{
        from{ opacity: 1; }
        to{ opacity: 0; }
    }

     .nav-enter-active{
        animation: navInVisibility .4s linear, navIn .4s linear;
    }


.scale {
  animation: scale 2s linear infinite;
}

@keyframes scale {
  0% { transform: scale(1); }
  50% { transform: scale(2); }
  100% { transform: scale(1); }
}
</style>

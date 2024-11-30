<template>
    <div class="bg-white h-full">
            <div class="flex flex-wrap px-4">
                <div class="base:hidden lg:hidden xl:hidden">
                    <Menu class="cursor-pointer" @click.prevent="toggleLateral" :getSize="5" />
                </div>
                <Link :href="route('home')" class="shrink-0 ">
                    <div class="h-16">
                        <img :src="'/storage/base/ED_2_Noir_Sans_fond_no_space.png'" class="object-contain h-full" alt="" />
                    </div>
                    <div class="text-lg lg:text-2xl font-bold">LaraCMS</div>
                </Link>
                <Link :href="route('login')" class="shrink-0 flex items-center">Login</Link>
            </div>

            <div v-if="$page.props.pages.length > 0" class=" block base:hidden lg:hidden xl:hidden flex-wrap justify-around" >
                <div :class="[((page.url_name !== 'home' && page.url_name !== 'resume')  && $page.props.auth.user) || (page.url_name === 'resume' && $page.props.auth.user && !$page.props.auth.isClient && !$page.props.auth.isEditor) ? '' : 'hidden']" class="py-2 px-3 shrink-0 flex flex-wrap justify-between" :key="page.id" v-for="page in $page.props.pages">
                    <Link v-if="((page.url_name !== 'home' && page.url_name !== 'resume')  && $page.props.auth.user) || (page.url_name === 'resume' && $page.props.auth.user && !$page.props.auth.isClient && !$page.props.auth.isEditor)" :href="route(page.url_name)" :class="[page.id === $page.props.getpage.id ? 'underline underline-offset-8' : '']" class="shrink-0 uppercase flex items-center font-bold">{{ page.title }}</Link>
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

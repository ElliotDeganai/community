<template>
    <div class="bg-sky-900 text-white h-full py-8 pl-4">
            <div class="flex flex-wrap ">
<!--                 <div class="base:hidden lg:hidden xl:hidden">
                    <Menu class="cursor-pointer" @click.prevent="toggleLateral" :getSize="5" />
                </div> -->
                <Link @click.prevent="toggleLateral()" :href="route('home')" class="shrink-0 flex items-center">
                    <div class="h-8 md:h-12 px-2 py-1 rounded-full">
                        <img :src="logo_light" alt="" class="h-full" />
                    </div>
                    <div class="text-lg lg:text-2xl font-bold text-wrap ">{{ site_name }}</div>
                </Link>
            </div>

            <div class="md:ml-3 relative lg:flex">
                <BreezeDropdown v-if="$page.props.auth.isDev || $page.props.auth.isAdmin || $page.props.auth.isEditor" align="left" width="48">
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
                        <Link @click.prevent="toggleLateral()" :href="route('pages.index')" class="breeze-button-dropdown">
                            Page List
                        </Link>
                        <Link @click.prevent="toggleLateral()" v-if="$page.props.auth.isDev" :href="route('pages.create')" class="breeze-button-dropdown">
                            New Page
                        </Link>
                    </template>
                </BreezeDropdown>
                <BreezeDropdown v-if="$page.props.auth.isDev" align="left" width="48">
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
                        <Link @click.prevent="toggleLateral()" :href="route('categories.index')"  class="breeze-button-dropdown">
                            Template List
                        </Link>
                        <Link @click.prevent="toggleLateral()" :href="route('categories.create')" class="breeze-button-dropdown">
                            New template
                        </Link>
                    </template>
                </BreezeDropdown>
                <BreezeDropdown v-if="!$page.props.auth.isClient" align="left" width="48">
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
                        <Link @click.prevent="toggleLateral()" :href="route('posts.index')"  class="breeze-button-dropdown">
                            Resources List
                        </Link>
                        <Link @click.prevent="toggleLateral()" :href="route('posts.create')"  class="breeze-button-dropdown">
                            New Resource
                        </Link>
                    </template>
                </BreezeDropdown>
                <div class="lg:px-8 py-2">
                    <Link @click.prevent="toggleLateral()" :href="route('parameters.show', $page.props.site_infos.id)" class="breeze-button-dropdown">Settings</Link>
                </div>
                <Link @click.prevent="toggleLateral()" v-if="$page.props.auth.isDev || $page.props.auth.isAdmin || $page.props.auth.isEditor" :href="route('users.index')" class="breeze-button-dropdown">Manage Users</Link>

                <div class="lg:px-8 py-2">
                    <Link @click.prevent="toggleLateral()" :href="route('home')" class="breeze-button-dropdown">See Website</Link>
                </div>
            </div>

            <div v-if="$page.props.auth.user" class="flex items-center py-4">
                <div class="lg:ml-3 relative">
                    <BreezeDropdown align="left" width="48">
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
                            <div @click.prevent="toggleLateral()">
                                <Link @click.prevent="toggleLateral()" :href="route('admin')" v-if="$page.props.auth.isDev || $page.props.auth.isAdmin || $page.props.auth.isEditor" class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                    Admin
                                </Link>
                                <Link @click.prevent="toggleLateral()" v-if="($page.props.auth.isDev || $page.props.auth.isAdmin || $page.props.auth.isEditor || $page.props.auth.isCollaborator) && $page.props.calendar == 1" :href="route('calendar.index')" class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                    Gérer mes RDV
                                </Link>
                                <Link @click.prevent="toggleLateral()" :href="route('logout')" class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                    Déconnexion
                                </Link>
                            </div>
                        </template>
                    </BreezeDropdown>
                </div>
            </div>
            <div  class="flex items-center py-4" v-else>
                <div class="lg:ml-3 relative">
                    <Link @click.prevent="toggleLateral()" :href="route('login')" class="shrink-0 uppercase flex items-center font-bold">Connexion</Link>
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
            site_name: this.$page.props.site_infos.site_name,
            logo_light: this.$page.props.site_infos.medias.filter(m => m.collection_name == 'logo_light').length > 0 ? this.$page.props.site_infos.medias.filter(m => m.collection_name == 'logo_light')[0].original_url : '/storage/base/ED 2 Blanc Sans fond.png',
            logo_dark: this.$page.props.site_infos.medias.filter(m => m.collection_name == 'logo_dark').length > 0 ? this.$page.props.site_infos.medias.filter(m => m.collection_name == 'logo_dark')[0].original_url : '/storage/base/ED_2_Noir_Sans_fond_no_space.png'
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

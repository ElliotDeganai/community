<template>
    <div class="w-full h-24 flex flex-wrap justify-around navbar z-30 text-purple-600 bg-black border-b border-purple-900">
        <div class="w-1/10 flex flex-wrap h-full content-center justify-center">
            <Link :href="route('home')"><img class="w-24 object-contain" :src="'/storage/home/logo.jpg'"/></Link>
        </div>
        <div class="w-3/5 h-full flex flex-wrap content-center justify-around">
            <div class="border-purple-400 text-xl font-bold uppercase hover:text-purple-400 py-3 px-3">
                <Link :class="[currentPage === '/news' ? 'text-purple-400' : '']" :href="route('news')" class="block relative uppercase w-full px-4 py-2">
                    <div :class="[currentPage === '/news' ? '' : 'hidden']" class="absolute rounded-md w-full h-full top-0 left-0 bg-white opacity-10"></div>
                    News
                </Link>
            </div>
            <div class="border-purple-400 text-xl font-bold cursor-pointer uppercase hover:text-purple-400 py-3 px-3">
                <Link :class="[currentPage === '/shop' ? 'text-purple-400' : '']"  :href="route('shop')" method="get" as="button" class="block relative uppercase w-full px-4 py-2">
                    <div :class="[currentPage === '/shop' ? '' : 'hidden']" class="absolute rounded-md w-full h-full top-0 left-0 bg-white opacity-10"></div>
                    Shop
                </Link>
            </div>
            <div class="border-purple-400 text-xl font-bold cursor-pointer uppercase hover:text-purple-400 py-3 px-3">
                <Link :class="[currentPage === '/free' ? 'text-purple-400' : '']"  :href="route('free')" method="get" as="button" class="block relative uppercase w-full px-4 py-2">
                    <div :class="[currentPage === '/free' ? '' : 'hidden']" class="absolute rounded-md w-full h-full top-0 left-0 bg-white opacity-10"></div>
                    Free Download
                </Link>
            </div>
            <div class="border-purple-400 text-xl font-bold cursor-pointer uppercase hover:text-purple-400 py-3 px-3">
                <Link :class="[currentPage === '/faq' ? 'text-purple-400' : '']"  :href="route('faq')" method="get" as="button" class="block relative uppercase w-full px-4 py-2">
                    <div :class="[currentPage === '/faq' ? '' : 'hidden']" class="absolute rounded-md w-full h-full top-0 left-0 bg-white opacity-10"></div>
                    Faq
                </Link>
            </div>
            <div class="border-purple-400 text-xl font-bold cursor-pointer uppercase hover:text-purple-400 py-3 px-3">
                <Link :class="[currentPage === '/about' ? 'text-purple-400' : '']"  :href="route('about')" method="get" as="button" class="block relative uppercase w-full px-4 py-2">
                    <div :class="[currentPage === '/about' ? '' : 'hidden']" class="absolute rounded-md w-full h-full top-0 left-0 bg-white opacity-10"></div>
                    About us
                </Link>
            </div>
        </div>
        <div class="w-3/10 h-full flex flex-wrap justify-around">
            <div class="w-1/2 h-full flex flex-wrap content-center justify-between">
                <a href="#" class="w-1/4 hover:text-purple-400 flex flex-wrap justify-center px-1">
                    <Facebook getColor="" getSize="6"/>
                </a>
                <a href="#" class="w-1/4 hover:text-purple-400 flex flex-wrap justify-center px-1">
                    <Instagram getColor="" getSize="6"/>
                </a>
                <a href="#" class="w-1/4 hover:text-purple-400 flex flex-wrap justify-center px-1">
                    <Youtube getColor="" getSize="6"/>
                </a>
                <a href="#" class="w-1/4 hover:text-purple-400 flex flex-wrap justify-center px-1">
                    <Twitter getColor="" getSize="6"/>
                </a>
            </div>
            <div class="w-1/2 h-full flex flex-wrap justify-around">
                <div class="w-full h-full flex flex-wrap content-center justify-center">
                    <div class="cursor-pointer hover:text-purple-400 px-2 flex flex-wrap content-center justify-center">
                        <Search getSize="4" class="block lg:hidden" />
                        <Search getSize="5" class="hidden lg:block" />
                    </div>
                    <div class="cursor-pointer hover:text-purple-400 px-2 flex flex-wrap content-center justify-center relative">
                        <Cart getSize="4" class="block lg:hidden" />
                        <Cart getSize="5" class="hidden lg:block" />
                        <div class="flex flex-wrap content-center justify-center absolute text-xs w-4 h-4 bg-red-600 text-white bottom-0 right-0 rounded-full">
                            <span>2</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Search from './Icon/Search.vue'
import Cart from './Icon/Cart.vue'
import Youtube from './Icon/Youtube.vue'
import Instagram from './Icon/Instagram.vue'
import Facebook from './Icon/Facebook.vue'
import Twitter from './Icon/Twitter.vue'
//import { Link } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/vue3'
export default {
    components: {
        Search, Cart, Youtube, Instagram, Facebook, Twitter, Link
    },
    props: {
        linkList: Array,
        getpage: Array,
    },
    data() {
        return{
            pageSelected: this.getpage,
            logo_url: '',
            socials: [
            ],
            pages: [
            ]
        }
    },
    methods: {
        changePage(id){
            this.pageSelected = id;
            this.$emit('pageChanged', id)
        }
    },
    computed: {
        currentPage() {
            return this.$page.url;
        },
    },
    mounted() {
    },
}
</script>
<style>

.navbar {
    box-shadow: 0 0 10px 2px rgba(0, 0, 0, .2);
}
</style>

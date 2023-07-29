<template>
    <div class="w-full bg-black text-purple-600 flex flex-wrap p-16 relative">
        <div class="absolute top-0 left-0 w-full h-full bg-white opacity-10"></div>
        <div class="w-full z-10 flex flex-wrap justify-around">
            <div class="w-1/4 flex flex-wrap content-center justify-center">
                <div>
                    <img class="w-36 object-contain" :src="'/storage/home/logo-transparent.png'" />
                </div>
            </div>
            <div class="w-1/4 text-center flex flex-wrap justify-col">
                <div class="text-2xl font-bold w-full pb-8 uppercase">Menu</div>
                <ul class="w-full flex flex-wrap justify-around">
                    <li class="border-purple-400 w-full text-xl uppercase hover:text-purple-400 py-3 px-3">
                        <Link  :href="route('news')" class="block uppercase w-full px-4 py-2">
                            News
                        </Link>
                    </li>
                    <li class="border-purple-400 w-full text-xl cursor-pointer uppercase hover:text-purple-400 py-3 px-3">
                        <Link  :href="route('shop')" method="get" as="button" class="block uppercase w-full px-4 py-2">
                            Shop
                        </Link>
                    </li>
                    <li class="border-purple-400 w-full text-xl cursor-pointer uppercase hover:text-purple-400 py-3 px-3">
                        <Link  :href="route('free')" method="get" as="button" class="block uppercase w-full px-4 py-2">
                            Free Download
                        </Link>
                    </li>
                    <li class="border-purple-400 w-full text-xl cursor-pointer uppercase hover:text-purple-400 py-3 px-3">
                        <Link  :href="route('faq')" method="get" as="button" class="block uppercase w-full px-4 py-2">
                            Faq
                        </Link>
                    </li>
                    <li class="border-purple-400 w-full text-xl cursor-pointer uppercase hover:text-purple-400 py-3 px-3">
                        <Link  :href="route('about')" method="get" as="button" class="block uppercase w-full px-4 py-2">
                            About us
                        </Link>
                    </li>
                </ul>
            </div>
            <div class="w-1/4 text-center flex flex-wrap justify-col">
                <div class="text-2xl font-bold w-full uppercase">Terms</div>
                <a href="#" class="text-lg w-full uppercase hover:text-purple-400 py-2">
                    Terms of service
                </a>
                <a href="#" class="text-lg w-full uppercase hover:text-purple-400 py-2">
                    Privacy policy
                </a>
            </div>
            <div class="w-1/4 flex flex-wrap justify-around">
                <div class="w-full h-full flex flex-wrap content-center justify-between">
                    <a href="#" class="w-1/4 hover:text-purple-400 flex flex-wrap justify-center">
                        <Facebook getColor="" getSize="8"/>
                    </a>
                    <a href="#" class="w-1/4 hover:text-purple-400 flex flex-wrap justify-center">
                        <Instagram getColor="" getSize="8"/>
                    </a>
                    <a href="#" class="w-1/4 hover:text-purple-400 flex flex-wrap justify-center">
                        <Youtube getColor="" getSize="8"/>
                    </a>
                    <a href="#" class="w-1/4 hover:text-purple-400 flex flex-wrap justify-center">
                        <Twitter getColor="" getSize="8"/>
                    </a>
                </div>
            </div>
        </div>
        <div class="flex z-10 flex-wrap justify-center w-full py-8">
            <div>Copyright © 2021 Music-Plug-Corner</div>
            <div class="w-full flex flex-wrap justify-center items-stretch content-center py-2 md:py-4">
                <div class="flex flex-wrap content-center items-stretch self-center text-xs">
                    <div class="h-full self-center flex flex-wrap items-stretch content-center"><div class="">By</div></div>
                    <a class="self-center" href="https://elliot-deganai.com/">
                        <div class="w-4 h-4 md:w-8 md:h-8 bg-contain bg-no-repeat bg-center mx-2" :style="'background-image: url(/storage/home/ED_purple.png)'"></div>
                    </a>
                    <div class="h-full flex flex-wrap content-center self-center items-stretch"><div class="self-center">Web Factory</div></div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Youtube from './Icon/Youtube.vue'
import Instagram from './Icon/Instagram.vue'
import Facebook from './Icon/Facebook.vue'
import Twitter from './Icon/Twitter.vue'
import { Link } from '@inertiajs/inertia-vue3';
export default {
    components: {
        Youtube, Instagram, Facebook, Twitter, Link
    },
    props: {
        linkList: Array
    },
    data() {
        return{
            logo_url: '',
            socials: [
                {
                    link: '#',
                    image: '../../images/social/facebook.png'
                },
                {
                    link: '#',
                    image: '../../images/social/twitter.jpg'
                },
                {
                    link: '#',
                    image: '../../images/social/instagram.jpg'
                },
                {
                    link: '#',
                    image: '../../images/social/youtube.png'
                },
            ],
            pages: [
                {
                    id: 1,
                    link: '#',
                    text: 'Vst Plugins'
                },
                {
                    id: 2,
                    link: '#',
                    text: 'Sample Pack'
                },
                {
                    id: 3,
                    link: '#',
                    text: 'Free Download'
                },
                {
                    id: 4,
                    link: '#',
                    text: 'About Us'
                },
                {
                    id: 5,
                    link: '#',
                    text: 'FAQ'
                },
            ]
        }
    },
    methods: {

    },
    mounted() {

    },
}
</script>
<style>

</style>

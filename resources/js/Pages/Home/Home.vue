<template>
    <div class="relative h-full min-h-screen ">
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
        <div class="pt-32 z-10 relative">
            <div class="px-6 py-4 w-full font-bold text-5xl uppercase text-center">
                LaraCMS
            </div>
            <div class="text-3xl text-gray-700 w-full flex flex-wrap justify-center py-8">
                <div class="">
                    Let's build something great together !
                </div>
            </div>
            <div class="py-16 flex flex-wrap justify-center w-full">
                <div class="w-1/3">
                    <div class="p-4 w-full rounded-md border-t border-r border-l last:border-b border-stone-700" :key="faq.id" v-for="faq in this.faqs">
                        <div class="relative w-full">
                            <button @click.prevent="changeIndex(faq.id)" class="font-bold w-full text-center text-2xl uppercase">{{faq.title}}</button>
                            <button @click.prevent="changeIndex(faq.id)" class="font-bold text-2xl absolute right-0 top-0">+</button>
                            <div v-if="index === faq.id" class="w-full py-8 text-xl text-justify text-gray-700">{{faq.body}}</div>
                            <div v-if="index === faq.id && faq.id === 1" class="w-full pb-8 text-xl text-justify text-gray-700">phone: <a href="tel:+33616211447">+33 6 16 21 14 47</a> or <a>+41 76 284 45 43</a></div>
                            <div v-if="index === faq.id && faq.id === 1" class="w-full pb-8 text-xl text-justify text-gray-700">email: <a href="mailto:edeganai@gmail.com">edeganai@gmail.com</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Layout from '../../Layouts/Guest.vue';
import { Link } from '@inertiajs/inertia-vue3';
export default {
    layout: Layout,
    components: {Link},
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
    },
    data() {
        return {
            faqs: [
                {
                    id: 0,
                    title: 'How it works ?',
                    body: 'Once login, you will have to create your resources templates and your resources instances that will be the Core data of your application. Then, we will work together to define the design of the website and I will develop it for you.'
                },
                {
                    id: 1,
                    title: 'How to use it ?',
                    body: 'Just contact me and I will create your admin access so that you can start working on your website.',
                    phone: '+33 6 16 21 14 47 or +41 76 284 45 43',
                    email: 'edeganai@gmail.com'
                },
                {
                    id: 2,
                    title: 'What makes our product special ?',
                    body: 'With LaraCMS, you can define specific attributes for each type of resource within a large number of attributes types. For example, if you want to create a country type resource, you can define that your country type resources will all have a text type attribute for the country name, an image type attribute for the country flag and a number type attribute for your country population.'
                },
            ],
            index: null
        }
    },
    methods: {
        setIndex(index){
            this.index = index;
        },
        unsetIndex(){
            this.index = null;
        },
        changeIndex(index){
            if (this.index === index) {
                this.unsetIndex();
            }else {
                this.setIndex(index);
            }
        }
    },
}
</script>

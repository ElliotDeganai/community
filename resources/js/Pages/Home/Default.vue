<template>
    <div class="px-32 relative">
        <div class="pt-32 w-full h-full min-h-screen absolute top-0 left-0">
            <div class="w-full h-full flex flex-wrap">
                <div class="w-1/4" :key="i" v-for="i in 24">
                    <div class="w-full py-8 flex flex-wrap justify-center content-center items-stretch text-xs md:text-sm ">
                        <a class="self-center px-2" href="https://www.elliot-deganai.com/">
                            <img :src="'/storage/base/ED_2_Noir_Sans_fond_no_space.png'" class="object-contain h-6 md:h-16 " alt="" />
                        </a>
                    </div>
                </div>
            </div>
            <div class="w-full h-full min-h-screen opacity-95 absolute top-0 left-0 bg-white"></div>
        </div>
        <div class="relative py-32 text-4xl font-bold text-center w-full uppercase">Default page</div>
        <div class="relative">
            <div class="py-8">
                <div class="text-lg">This is the default page where you can see all your resources and their related resources. Your developper is currently developping the different pages of your application. As soon the page are ready, the default page will no longer be used.</div>
            </div>
            <div class="py-2 text-2xl font-bold capitalize">Resources: </div>
            <div :key="category.id" v-for="category in categories">
                <div class="py-4 flex">
                    <div @click="toggleCategory(category.id)" class="py-2 px-3 bg-sky-900 cursor-pointer text-white w-1/12">Display</div>
                    <div class="font-bold py-2 px-3">Category name: {{ category.name }}</div>
                </div>
                <div :ref="'category_'+category.id" class="w-full block pl-8">
                    <div class="relative py-2 flex flex-wrap" :key="post.id" v-for="post in category.posts">
                        <div class="flex w-full">
                            <div @click="toggleDisplay(post.id)" class="py-2 px-3 cursor-pointer bg-sky-300 w-1/12">Display</div>
                            <div class="font-bold py-2 px-3">{{ post.name }}</div>
                        </div>
                        <div :ref="'post_'+post.id" class="relative p-8 border hidden w-full" >
                            <div class="relative" :key="docValue.id" v-for="docValue in post.doc_values">
                                <div>Documentation name: {{ docValue.documentation.name }}</div>
                                <DocValue v-if="docValue" class="w-full h-32" :getobject="docValue" :getdoc="getValue(docValue)" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <Checkout class="z-50 relative" :getintent="intent" /> -->
    </div>
</template>
<script>
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import helpers from '../../helpers'
import DocValue from './Help/DocumentationValue.vue'
import Checkout from '../Stripe/Checkout.vue'
export default {
    props: ['getposts', 'getcategories', 'getintent'],
    components:  {BreezeGuestLayout, DocValue, Checkout},
    layout: BreezeGuestLayout,
    data() {
        return {
            posts: this.getposts,
            categories: this.getcategories,
            intent: this.getintent
        }
    },
    methods: {
        getValue(docValue){
            return helpers.getValue(docValue);
        },
/*         categories(){
            let categories = [];
            this.getcategories.forEach(element => {
                let category = {
                    deploy: false,
                    category: element
                }
                categories.push(category);
            });
            return categories;
        },
        categoryDeploy(category){
            return category.deploy;
        }, */
        toggleDisplay(id){
            let refKey = 'post_'+id;
            let element = this.$refs[refKey][0];
            element.classList.contains('hidden') ? element.classList.replace('hidden', 'block') : element.classList.replace('block', 'hidden');
        },
        toggleCategory(id){
            let refKey = 'category_'+id;
            let element = this.$refs[refKey][0];
            element.classList.contains('hidden') ? element.classList.replace('hidden', 'block') : element.classList.replace('block', 'hidden');
        },
    },
    computed: {
/*         categories(){
            let categories = [];
            this.getcategories.forEach(element => {
                let category = {
                    deploy: false,
                    category: element
                }
                categories.push(category);
            });
            return categories;
        } */
    },
    mounted() {
    },
}
</script>

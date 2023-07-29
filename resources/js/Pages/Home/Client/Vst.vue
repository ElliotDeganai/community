<template>
    <div class="px-32 relative">
        <div class="pt-32 w-full h-full min-h-screen absolute top-0 left-0">
<!--             <div class="w-full h-full flex flex-wrap">
                <div class="w-1/4" :key="i" v-for="i in 24">
                    <div class="w-full py-8 flex flex-wrap justify-center content-center items-stretch text-xs md:text-sm ">
                        <a class="self-center px-2" href="https://www.elliot-deganai.com/">
                            <img :src="'/storage/base/ED_2_Noir_Sans_fond_no_space.png'" class="object-contain h-6 md:h-16 " alt="" />
                        </a>
                    </div>
                </div>
            </div>
            <div class="w-full h-full min-h-screen opacity-95 absolute top-0 left-0 bg-white"></div> -->
        </div>
        <div class="relative py-32 text-4xl font-bold text-center w-full">VST</div>
    </div>
</template>
<script>
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import helpers from '../../../helpers'
import DocValue from './../Help/DocumentationValue.vue'
import Checkout from '../../Stripe/Checkout.vue'
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

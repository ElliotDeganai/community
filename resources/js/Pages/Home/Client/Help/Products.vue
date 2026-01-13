<template>
    <div class="text-white px-24 relative">
<!--         <div :style="'background-image: url(./images/background/product-top.png)'" class="bg-repeat bg-cover w-full h-1/2 absolute top-0 left-0  opacity-50"></div>
        <div :style="'background-image: url(./images/background/product-bottom.png)'" class="bg-repeat bg-cover bg-center w-full h-1/2 absolute left-0 bottom-0 opacity-50"></div> -->
<!--         <div class="w-full pt-24 z-10">
            <div class="uppercase text-4xl text-white w-full text-center z-20">Products</div>
        </div> -->
        <ProductCart :getsection="section" />
    </div>
</template>
<script>
//import { Link } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/vue3'
import Vuex from "vuex";
import ProductCart from './ProductCart.vue'
export default {
    components: {
        Link, ProductCart
    },
    props: {
        getproducts: Array,
        //getcategories: Array,
        getsection: Object,
    },
    data() {
        return{
            products: this.getsection.category.posts,
            section: this.getsection,
            imagePath: './assets/images/'

        }
    },
    methods: {
        ...Vuex.mapActions([
            "set_product_modal"
        ]),
        setProduct(product){
            this.set_product_modal(product);
        }
    },
    computed: {
    },
    created() {
    },
}
</script>
<style>

</style>

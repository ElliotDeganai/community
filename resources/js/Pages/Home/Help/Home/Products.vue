<template>
    <div class="text-white px-24 relative">
<!--         <div :style="'background-image: url(./images/background/product-top.png)'" class="bg-repeat bg-cover w-full h-1/2 absolute top-0 left-0  opacity-50"></div>
        <div :style="'background-image: url(./images/background/product-bottom.png)'" class="bg-repeat bg-cover bg-center w-full h-1/2 absolute left-0 bottom-0 opacity-50"></div> -->
        <div class="w-full pt-24 z-10">
            <div class="uppercase text-4xl text-white w-full text-center z-20">Product</div>
        </div>
        <div v-if="products.length != 0" class="relative  py-8 md:py-24 flex flex-wrap justify-center">
            <div class="w-1/4 group p-8" :key="product.id" v-for="product in this.products">
                <Link :href="route('product', product.id)" class="w-full cursor-pointer group-hover:border-white border-transparent">
                     <div class="relative overflow-hidden h-56">
                        <div class="bg-white group-hover:opacity-30 opacity-20 z-10 absolute top-0 w-full h-full"></div>
                        <div v-if="product.price === 0" class="bg-green-400 w-20 h-8 text-white font-bold uppercase absolute top-0 -left-6 px-4 py-0.5 transform -rotate-45 mt-3"></div>
                        <div v-if="product.price === 0" class="bg-green-400 z-10 text-white font-bold uppercase absolute text-sm top-0 left-0 px-4 py-1 ml-8">Free</div>
                        <div class="z-20 w-full h-full"><img :src="$helpers.getImageUrl(product)" class="object-contain z-20 relative h-full w-full" /></div>
                     </div>
                    <div class="relative p-8">
                        <div class="bg-white group-hover:opacity-20 opacity-10 absolute top-0 left-0 w-full h-full"></div>
                        <div class="text-center truncate">{{$helpers.getDocValue(section, product, 'Product Name')}}</div>
                        <div v-if="product.price !== 0" class="text-center">{{$helpers.getDocValue(section, product, 'Product Price')}} €</div>
                        <div v-else class="text-center uppercase">Free</div>
                    </div>
                </Link>
            </div>
        </div>
    </div>
</template>
<script>
//import { Link } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/vue3'
export default {
    components: {
        Link
    },
    props: {
        getproducts: Array,
        getcategories: Array,
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
    },
    computed: {
    },
    created() {
    },
}
</script>
<style>

</style>

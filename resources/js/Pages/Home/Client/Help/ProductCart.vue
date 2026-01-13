<template>
    <div class="text-white relative">
        <div v-if="products.length != 0" class="relative flex flex-wrap justify-center">
            <div class="w-1/4 group p-8" :key="product.id" v-for="product in this.products">
                <div class="w-full cursor-pointer group-hover:border-white border-transparent">
                     <Link :href="route('item_Product', product.id)" class="relative w-full inline-block overflow-hidden h-56">
                        <div class="bg-white group-hover:opacity-30 opacity-20 z-10 absolute top-0 w-full h-full"></div>
                        <div v-if="product.price === 0" class="bg-green-400 w-20 h-8 text-white font-bold uppercase absolute top-0 -left-6 px-4 py-0.5 transform -rotate-45 mt-3"></div>
                        <div v-if="product.price === 0" class="bg-green-400 z-10 text-white font-bold uppercase absolute text-sm top-0 left-0 px-4 py-1 ml-8">Free</div>
                        <div class="z-20 w-full h-full"><img :src="$helpers.getImageUrl(product)" class="object-contain z-20 relative h-full w-full" /></div>
                     </Link>
                    <div class="relative">
                        <Link :href="route('item_Product', product.id)" class="p-8 inline-block w-full h-full relative">
                            <div class="bg-white group-hover:opacity-20 opacity-10 absolute top-0 left-0 w-full h-full"></div>
                            <div class="text-center truncate">{{product.name}}</div>
                            <div v-if="product.price !== 0" class="text-center">{{$helpers.getDocValue(section, product, 'Price').docValue}} €</div>
                            <div v-else class="text-center uppercase">Free</div>
                        </Link>
                        <div class="flex flex-wrap justify-center w-full h-full">
                            <div class="w-full flex flex-wrap justify-between h-full">
                                <div class="w-full h-full">
                                    <div @click.prevent="setProductCart(product)" class="py-2 w-full h-full px-3 text-center bg-sky-900 text-white font-bold">Add to cart</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
//import { Link } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/vue3'
import Vuex from "vuex";
export default {
    components: {
        Link
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
            "set_product_modal","saveCartItem", "addCartItemQuantity"
        ]),
        setProduct(product){
            this.set_product_modal(product);
        },
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
        }
    },
    computed: {
        ...Vuex.mapState([
            "cart", "product"
        ])
    },
    created() {
    },
}
</script>
<style>

</style>

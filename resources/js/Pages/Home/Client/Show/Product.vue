<template>
    <div class="px-32">
        <div :style="'background-image: url(/storage/home/carousel/carousel.png)'" class="bg-repeat bg-center w-full h-full absolute top-0 left-0 opacity-40"></div>
        <div class="pt-32 w-full h-full min-h-screen">
            <div class="w-full flex flex-wrap justify-center content-center py-24 z-10">
                <div class="flex">
                    <div class="uppercase text-4xl text-white z-20">{{post.name}}</div>
                    <div class="px-8 z-20">
                        <div class="z-20">
                            <div class="z-20">
                                <div @click.prevent="setProductCart(product)" class="z-20 cursor-pointer py-2 w-full h-full px-3 text-center bg-sky-900 text-white font-bold">Add to cart</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-8">
                <div>
                    <div :key="doc.id" v-for="doc in post.doc_values">
                        <DocValue :imgSize="{height: 64, width: 64}" v-if="getValue(doc)" :getdoc="getValue(doc)" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import helpers from '../../../../helpers'
import DocValue from '../../Help/DocumentationValue.vue'
import Checkout from '../../../Stripe/Checkout.vue'
import store from '../../../../Store/index';
import Vuex from "vuex";
import ProductCart from '../Help/ProductCart.vue';
export default {
    props: ['getpost'],
    components:  {BreezeGuestLayout, DocValue, Checkout, ProductCart},
    layout: BreezeGuestLayout,
    data() {
        return {
            post: this.getpost
        }
    },
    methods: {
        getValue(docValue){
            return helpers.getValue(docValue);
        },
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
        getFieldDocValue(field, post){
            return helpers.getFieldDocValue(field, post);
        },
        ...Vuex.mapActions([
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
        }
    },
    computed: {
        ...Vuex.mapState([
            "cart"
        ])
    },
    mounted() {
    },
}
</script>

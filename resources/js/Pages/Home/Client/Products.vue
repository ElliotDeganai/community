<template>
    <div class="px-32">
        <div :style="'background-image: url(/storage/home/carousel/carousel.png)'" class="bg-repeat bg-center w-full h-full absolute top-0 left-0 opacity-40"></div>
        <div class="pt-32 w-full h-full min-h-screen">
            <div class="w-full py-24 z-10">
                <div class="uppercase text-4xl text-white w-full text-center z-20">Products</div>
            </div>
            <div class="py-16">
                <ProductCart :getsection="sections[0]" />
            </div>
        </div>
    </div>
</template>
<script>
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import helpers from '../../../helpers'
import DocValue from './../Help/DocumentationValue.vue'
import Checkout from '../../Stripe/Checkout.vue'
import store from '../../../Store/index';
import Vuex from "vuex";
import ProductCart from './Help/ProductCart.vue';
export default {
    props: ['getposts', 'getcategories', 'getintent'],
    components:  {BreezeGuestLayout, DocValue, Checkout, ProductCart},
    layout: BreezeGuestLayout,
    data() {
        return {
            page: this.$page.props.pages.filter(page => page.title == 'Products')[0],
            sections: this.$page.props.pages.filter(page => page.title == 'Products')[0].page_sections
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

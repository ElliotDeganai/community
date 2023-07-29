<template>
    <div v-if="product" class="z-60 absolute w-full h-full top-0 left-0 flex flex-wrap justify-center content-center">
        <div class="w-2/3 h-80 p-8 border border-slate-300 bg-slate-900 text-white">
            <div class="font-bold text-2xl w-full text-center pb-8">{{product.name}}</div>
            <div>
                <div :key="docValue.id" v-for="docValue in product.doc_values">
                    <div class="w-full flex flex-wrap justify-center" v-if="$helpers.getValue(docValue).type == 'image'">
                        <DocValue class="w-1/2 h-56" :getdoc="$helpers.getValue(docValue)" />
                    </div>
                    <div v-else><DocValue :getdoc="$helpers.getValue(docValue)" /></div>
                </div>
            </div>
            <div class="py-8 flex flex-wrap justify-center w-full">
                <div class="w-1/2 flex flex-wrap justify-between">
                    <div>
                        <button @click.prevent="setProductCart(product)" class="py-2 w-full px-3 bg-sky-800 text-white font-bold">Add to cart</button>
                    </div>
                    <div>
                        <button @click.prevent="unset_product_modal()" class="py-2 w-full px-3 bg-red-800 text-white font-bold">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import DocValue from '../../Pages/Home/Help/DocumentationValue.vue'
import Vuex from "vuex";
export default {
    props: [],
    components:  {DocValue},
    data() {
        return {
        }
    },
    methods: {
        ...Vuex.mapActions([
            "setDb", "getCardItems", "unset_product_modal",
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
            "cart", "product"
        ])
    },
    mounted() {
    },
}
</script>

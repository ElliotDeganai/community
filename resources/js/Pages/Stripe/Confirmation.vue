<template>
  <div class="pt-32 px-32">
    <div class="relative text-4xl font-bold text-center w-full uppercase">Payment confimation</div>
    <div class="py-8">
        <div class="py-8">Your payment has been confirmed.</div>
        <div>
            <div>Payment details:</div>
            <div class="py-8">
                <div class="font-bold px-8 flex flex-wrap w-full bg-slate-800 text-white">
                    <div class="w-1/3">Products</div>
                    <div class="w-1/3">Quantity</div>
                    <div class="w-1/3">Amount</div>
                </div>
                <div class="px-8">
                    <div class="py-4 flex flex-wrap border-b" :key="product.id" v-for="product in order.posts">
                        <div class="w-1/3">{{ product.name }}</div>
                        <div class="w-1/3">{{ product.pivot.quantity }}</div>
                        <div class="w-1/3">{{ getPrice(product.doc_values) }}</div>
                    </div>
                </div>
                <div class="flex flex-wrap justify-between w-full py-4 px-8">
                    <div class="w-1/3 font-bold uppercase">Total</div>
                    <div class="w-1/3">{{ order.total }}</div>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>

//import { Inertia } from '@inertiajs/inertia'
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import CheckoutForm from './CheckoutForm.vue'
import store from '../../Store/index'
import Vuex from "vuex";
import helpers from '../../helpers'

export default {
    components: {BreezeGuestLayout, CheckoutForm},
    store: store,
    layout: BreezeGuestLayout,
    props: ['getorder'],
    data() {
        return {
            order: this.getorder
        }
    },
    computed:{
        ...Vuex.mapState([
            "cart"
        ])
    },
    methods: {
            ...Vuex.mapActions([
                "setDb", "getCardItems", "deleteCartItems", "deleteCartItem"
            ]),
            getPrice(docValues){
                return helpers.getPrice(docValues);
            },
            getTotal(){
                let sum = 0;
                this.cart.forEach(c => {
                    sum = sum+ c.quantity*this.getPrice(c.product.doc_values)
                });
                return sum;
            },
            resetCart(){
                this.$store.dispatch('deleteCartItems', this.cart)
            }
    },
    async mounted () {
        this.resetCart();
    }
}

</script>

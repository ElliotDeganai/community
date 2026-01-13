<template>
            <form class="w-full max-w-xl">
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="py-4 w-full">Your personal details:</div>
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                        First Name
                    </label>
                    <input v-model="customer.first_name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="text" placeholder="Jane">
                    <p class="text-red-500 text-xs italic">Please fill out this field.</p>
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                        Last Name
                    </label>
                    <input v-model="customer.last_name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Doe">
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                        Email
                    </label>
                    <input v-model="customer.email" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="email" placeholder="Doe">
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-2">
                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-city">
                        City
                    </label>
                    <input v-model="customer.city" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-city" type="text" placeholder="Albuquerque">
                </div>
                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-zip">
                        Zip Code
                    </label>
                    <input v-model="customer.zip_code" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-zip" type="text" placeholder="90210">
                </div>
                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
                        State
                    </label>
                    <input v-model="customer.state" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state" type="text" placeholder="France">
                </div>
            </div>


                <div class="flex flex-wrap -mx-2 mt-4">
                    <div class="p-2 w-full">
                        <div class="relative">
                            <label for="card-element" class="leading-7 text-sm text-gray-600">Credit Card Info</label>
                            <div id="card-element"></div>
                        </div>
                    </div>
                </div>
                <div class="p-2 w-full">
                    <button
                        class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                        @click="processPayment"
                        :disabled="paymentProcessing"
                        v-text="paymentProcessing ? 'Processing' : 'Pay Now'"
                    ></button>
                </div>
        </form>
</template>
<script>

import {loadStripe} from '@stripe/stripe-js';
//import { Inertia } from '@inertiajs/inertia'
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'
import BreezeGuestLayout from '@/Layouts/Guest.vue';
const form = reactive({
    first_name: 'Admin',
    last_name: 'Tester',
    email: 'admin@admin.fr',
    address: '123 rue de la paix',
    city: 'Paris',
    zip_code: '75000',
    payment_method_id: null,
    amount: null,
    cart: [
        'product 1', 'product 2'
    ]
})

export default {
    components: {BreezeGuestLayout},
    layout: BreezeGuestLayout,
    props: ['getintent'],
    data() {
        return {
            intent: this.getintent,
            stripe: null,
            cardElement: null,
            customer: {
                first_name: 'Admin',
                last_name: 'Tester',
                email: 'admin@admin.fr',
                address: '123 rue de la paix',
                city: 'Paris',
                zip_code: '75000',
                payment_method_id: null,
                amount: null,
                cart: [
                    'product 1', 'product 2'
                ]
            },
            paymentProcessing: false
        }
    },
    methods: {
            async processPayment() {
                this.paymentProcessing = true;
                const {paymentMethod, error} = await this.stripe.createPaymentMethod(
                    'card', this.cardElement, {
                        billing_details: {
                            name: this.customer.first_name + ' ' + this.customer.last_name,
                            email: this.customer.email,
                            address: {
                                line1: this.customer.address,
                                city: this.customer.city,
                                state: this.customer.state,
                                postal_code: this.customer.zip_code
                            }
                        }
                    }
                );
                if (error) {
                    this.paymentProcessing = false;
                    console.error(error);
                } else {
                    console.log(paymentMethod);
                    this.customer.payment_method_id = paymentMethod.id;
                    //this.customer.amount = this.$store.state.cart.reduce((acc, item) => acc + (item.price * item.quantity), 0);
                    this.customer.amount = 1009;
                    //this.customer.cart = JSON.stringify(this.$store.state.cart);
                    this.customer.cart = [
                        'product 1', 'product 2'
                    ]
                    form.address = this.customer.address;
                    form.amount = this.customer.amount;
                    form.cart = this.customer.cart;
                    form.city = this.customer.city;
                    form.email = this.customer.email;
                    form.first_name = this.customer.first_name;
                    form.last_name = this.customer.last_name;
                    form.payment_method_id = this.customer.payment_method_id;
                    form.zip_code = this.customer.zip_code;

                    router.post('/payment', form);
/*                         .then((response) => {
                            this.paymentProcessing = false;
                            console.log(response);
                            //this.$store.commit('updateOrder', response.data);
                            //this.$store.dispatch('clearCart');
                            //this.$router.push({ name: 'order.summary' });
                        })
                        .catch((error) => {
                            this.paymentProcessing = false;
                            console.error(error);
                        }); */
                }
            },
            submitPayment(){
                this.$emit('submitPayment', form)
            }
    },
    async mounted () {
        console.log(process.env.MIX_STRIPE_KEY);
        this.stripe = await loadStripe(this.$stripe.pk);

        const elements = this.stripe.elements();
        this.cardElement = elements.create('card', {
            classes: {
                base: 'bg-gray-100 rounded border border-gray-300 focus:border-indigo-600 text-base outline-non text-gray-700 p-3 leading-8 transition-colors duration-200'
            }
        })
        this.cardElement.mount('#card-element');
    }
}

</script>

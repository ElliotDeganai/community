<template>
  <div class="pt-32 px-32 w-full min-h-screen">
    <div class="py-8">
      <div>
        <div
          class="relative pb-32 text-4xl font-bold text-center w-full uppercase"
        >
          Your cart
        </div>
        <div>
          <div>
            <div class="py-4 font-bold">The products in the cart:</div>
            <div
              class="font-bold px-8 py-2 flex flex-wrap w-full bg-sky-900 text-white"
            >
              <div class="w-1/3">Products</div>
              <div class="w-1/3">Quantity</div>
              <div class="w-1/3">Amount</div>
            </div>
            <div class="">
              <div
                class="py-4 border-b"
                :key="product.id"
                v-for="product in cart"
              >
                <div class="px-8 flex flex-wrap">
                  <div class="w-1/3">{{ product.product.name }}</div>
                  <div class="w-1/3">X {{ product.quantity }}</div>
                  <div class="w-1/3">
                    {{ getPrice(product.product.doc_values) }}
                  </div>
                </div>
              </div>
            </div>
            <div class="font-bold uppercase py-4">Total: {{ getTotal() }}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="relative">
      <form class="w-full">
        <div class="flex flex-wrap -mx-3 mb-6">
          <div class="py-4 w-full font-bold">Your personal details:</div>
          <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
            <label
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
              for="grid-first-name"
            >
              First Name
            </label>
            <input
              v-model="customer.first_name"
              class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
              id="grid-first-name"
              type="text"
              placeholder="Jane"
            />
            <p class="text-red-500 text-xs italic">
              Please fill out this field.
            </p>
          </div>
          <div class="w-full md:w-1/2 px-3">
            <label
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
              for="grid-last-name"
            >
              Last Name
            </label>
            <input
              v-model="customer.last_name"
              class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
              id="grid-last-name"
              type="text"
              placeholder="Doe"
            />
          </div>
          <div class="w-full md:w-1/2 px-3">
            <label
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
              for="grid-last-name"
            >
              Email
            </label>
            <input
              v-model="customer.email"
              class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
              id="grid-last-name"
              type="email"
              placeholder="Doe"
            />
          </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-2">
          <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
            <label
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
              for="grid-city"
            >
              City
            </label>
            <input
              v-model="customer.city"
              class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
              id="grid-city"
              type="text"
              placeholder="Albuquerque"
            />
          </div>
          <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
            <label
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
              for="grid-zip"
            >
              Zip Code
            </label>
            <input
              v-model="customer.zip_code"
              class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
              id="grid-zip"
              type="text"
              placeholder="90210"
            />
          </div>
          <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
            <label
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
              for="grid-state"
            >
              State
            </label>
            <input
              v-model="customer.state"
              class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
              id="grid-state"
              type="text"
              placeholder="France"
            />
          </div>
        </div>

        <div class="flex flex-wrap -mx-2 mt-4">
          <div class="p-2 w-full">
            <div class="relative">
              <label for="card-element" class="leading-7 text-sm text-gray-600"
                >Credit Card Info</label
              >
              <div id="card-element"></div>
            </div>
          </div>
        </div>
        <div class="p-2 w-full">
          <button
            class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
            @click="processPayment"
            :disabled="paymentProcessing"
            v-text="paymentProcessing ? 'Processing' : 'Pay Now Stripe'"
          ></button>
        </div>
        <div class="p-2 w-full">
          <button
            class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
            @click="processPayment"
            :disabled="paymentProcessing"
            v-text="paymentProcessing ? 'Processing' : 'Pay Paypal'"
          ></button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>

import {loadStripe} from '@stripe/stripe-js';
//import { Inertia } from '@inertiajs/inertia'
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import CheckoutForm from './CheckoutForm.vue'
import store from '../../Store/index'
import Vuex from "vuex";
import helpers from '../../helpers'
const form = reactive({
    first_name: 'Admin',
    last_name: 'Tester',
    email: 'admin@admin.fr',
    address: '123 rue de la paix',
    city: 'Paris',
    zip_code: '75000',
    payment_method_id: null,
    amount: 0,
    cart: [
        'product 1', 'product 2'
    ]
})

export default {
    components: {BreezeGuestLayout, CheckoutForm},
    store: store,
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
                amount: null
            },
            paymentProcessing: false
        }
    },
    computed:{
        ...Vuex.mapState([
            "cart"
        ])
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
                    console.log('test')
                    this.customer.payment_method_id = paymentMethod.id;
                    //this.customer.amount = this.$store.state.cart.reduce((acc, item) => acc + (item.price * item.quantity), 0);
                    this.customer.amount = 1009;
                    //this.customer.cart = JSON.stringify(this.$store.state.cart);
                    form.address = this.customer.address;
                    form.amount = this.getTotal();
                    form.cart = this.cart;
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
            getPrice(docValues){
                return helpers.getPrice(docValues);
            },
            getTotal(){
                let sum = 0;
                this.cart.forEach(c => {
                    sum = sum+ c.quantity*this.getPrice(c.product.doc_values)
                });
                return sum;
            }
    },
    async mounted () {
        this.stripe = await loadStripe(this.$stripe.pk);

        const elements = this.stripe.elements();
        this.cardElement = elements.create('card', {
            classes: {
                base: 'bg-gray-100 rounded border border-gray-300 focus:border-indigo-600 text-base outline-non text-gray-700 p-3 leading-8 transition-colors duration-200'
                ,hidePostalCode: true,
            }
        })
        this.cardElement.mount('#card-element');

/*  paypal.Button.render({
     env: 'sandbox', // Optional: specify 'sandbox'  environment
     client: {
        sandbox:    'xxxx',
        production: 'xxxx'
       },
     locale: 'en_US',
     style: {
         size: 'large',
         color: 'gold',
         shape: 'pill',
         label: 'checkout',
         tagline: 'true'
        },
     commit: true, // Optional: show a 'Pay Now' button in the checkout flow

        payment: function(resolve, reject) {
        // Set up the payment here, when the buyer clicks on the button

          let returnUrl = "_YOUR_RETURN_URL";
          let amount = 20

          //Here call your own API server
    return new Promise((resolve, reject) => {
     axios.post('/checkout-paypal', {
            return_url: returnUrl,
            amount:amount
        }, {
                headers: { 'Authorization': 'Bearer ' + state.token }
            })
            .then(res => {
                resolve(res.data.id)
            })
            .catch(error => {
                reject(error)
            })
    })

        },
  onAuthorize: function(data) {
   // Execute the payment here, when the buyer approves the transaction

    return new Promise((resolve, reject) => {
        axios.post('/execute-paypal',  {
            payer_id: data.payerID,
            payment_id: data.paymentID,
        }, {
                headers: { 'Authorization': 'Bearer ' +
    state.token }
            })
            .then(res => {
                resolve(res)
            })
            .catch(error => {
                reject(error)
            })
    }, '#paypal-button');
    }*/
}
}

</script>

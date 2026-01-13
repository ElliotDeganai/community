<template>
    <div class="" >
        <div class="py-24 px-32">
            <div><div class="text-4xl py-8 w-full text-center font-bold">Prendre RDV</div></div>
            <div>
                <div>
                    <div></div>
                    <div>
                        <div class="py-4">
                            <label class="label-fields"  for="category">Choisissez le formateur</label>
                            <select @change.prevent="" v-model="trainer" id="trainer" name="trainer" class="w-1/5 form-fields">
                                <option :key="user.id" v-for="user in users" :value="user">{{user.name}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="trainer !== null" class="py-16">
                <Calendar  :getappointments="getappointments" :errors="$page.props.errors" :gettrainer="dynamicTrainer"/>
            </div>
            <div class="pt-8">
                <div>
                    <div class="w-full bg-teal-800 text-white text-center py-8">Mes rendez-vous</div>
                    <div class="py-8">
                        <div class="w-full border-b flex flex-wrap content-center" :key="appointment.id" v-for="appointment in appointments.filter(a => hasUser(a, $page.props.auth.user.id))">
                            <div class="w-1/5 flex items-center justify-center">{{ formatDate(appointment.meeting_date) }}</div>
                            <div class="w-1/5 flex items-center justify-center">{{ appointment.users.filter(u => u.pivot.type == 'trainer')[0].name }}</div>
                            <div  class="w-1/5 flex items-center justify-center">
                                <span :class="[appointment.status == 'accepted' && appointment.status != 'pending' ? 'bg-green-600 text-white rounded-full px-3 py-2' : appointment.status == 'declined' && appointment.status != 'pending' ? 'bg-red-600 text-white px-3 py-2 rounded-full' : ' px-3 py-2 bg-slate-200 rounded-full']">
                                    {{ appointment.status }}
                                </span>
                            </div>
                            <div class="w-1/5 px-3 flex items-center justify-center">
                                <button class="btn-delete" @click="this.$store.dispatch('set_model', {model: appointment, route: 'appointment', type: 'appointment'})">Supprimer le rendez-vous</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import Carousel from './../Help/Carousel/Carousel.vue'
import helpers from '../../../helpers'
import DocValue from './../Help/DocumentationValue.vue'
import Checkout from '../../Stripe/Checkout.vue'
import store from '../../../Store/index';
import Vuex from "vuex";
import Products from './Help/Products.vue'
import Speak from './Help/Speak.vue'
//import { useForm } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/vue3";
//import { Link } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/vue3'
import Down from '../../Help/Icon/Down.vue'
import Gift from '../../Help/Icon/Gift.vue'
import Loading from '../Client/Help/Loading.vue'
import Calendar from '../../Help/Calendar/Calendar.vue'
import moment from 'moment';
export default {
/*     setup(props) {
        const form = useForm({
            user:
        });
        return { form };
    }, */
    props: ['getposts', 'getcategories', 'getintent', 'getappointments', 'getusers'],
    components:  {BreezeGuestLayout, DocValue, Carousel, Products, Speak, Link, Down, Loading, Gift, Calendar},
    layout: BreezeGuestLayout,
    data() {
        return {
            form : useForm({
                id: this.$page.props.auth.user ? this.$page.props.auth.user.id : null,
                user: this.$page.props.auth.user ? this.$page.props.auth.user : null,
            }),
            appointments: this.getappointments,
            users: this.getusers,
            trainer: null
        }
    },
    methods: {
        formatDate(date){
            return moment(date).format('YYYY-MM-DD');
        },
        formatDatetime(date){
            return moment(date).format('YYYY-MM-DD HH:mm');
        },
        getMeetingEndDate(date){
            let dt_plus = new Date(date);
            dt_plus = dt_plus.setHours(dt_plus.getHours() + Number(this.$page.props.calendar_slot_time));
            return moment(dt_plus).format('YYYY-MM-DD HH:mm');
        },
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
        },
        submit() {
            let self = this;
                    this.form.has_answered = 1;
            this.form.put(route("users.update", this.form.id),  {
                onSuccess: (form) => {
                    self.updateMode = false;
                },
                preserveScroll: true
            });
        },
        cancel() {
            this.updateMode = false;
        },
        changeAnswers() {
            this.updateMode = !this.updateMode;
        },
        setUpdateMode() {
            this.updateMode = !this.updateMode;
        },
        scrollToRsvp() {
            this.$refs.summary.scrollIntoView({ behavior: 'smooth' });
        },
        replaceUser(text) {
            if (text) {
                return text.replace("%user%", '<span class="font-bold">'+this.$page.props.auth.user.name+'</span>');
            } else {
                return null;
            }
        },
        createDiv(text) {
            if (text) {
                return '<div>'+text+'</div>';
            } else {
                return null;
            }
        },

        hasUser(appointment, userId) {
            return appointment.users.some(u => u.id === userId);
        }
    },
    computed: {
        ...Vuex.mapState([
            "cart"
        ]),
        dynamicTrainer() {
            return this.trainer;
        },
    },
    mounted() {
        this.$emit("siteReady");
    },
}
</script>

<style>

.loader {
  animation: bouncing 1s linear infinite;
}

@keyframes bouncing {
  0% { transform: translateY(0); }
  50% { transform: translateY(-30%); }
  100% { transform: translateY(0); }

}
</style>

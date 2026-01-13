<template>
    <div class="" >
        <div class="py-24 px-32">
            <Calendar :getcategory="appointmentCategory" :errors="$page.props.errors"/>
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
export default {
/*     setup(props) {
        const form = useForm({
            user:
        });
        return { form };
    }, */
    props: ['getposts', 'getcategories', 'getintent'],
    components:  {BreezeGuestLayout, DocValue, Carousel, Products, Speak, Link, Down, Loading, Gift, Calendar},
    layout: BreezeGuestLayout,
    data() {
        return {
            page: this.$page.props.pages.filter(page => page.title == 'Home')[0],
            sections: this.$page.props.pages.filter(page => page.title == 'Home')[0].page_sections,
            appointmentSectionCat: this.getAppointmentSection() ? this.getAppointmentSection().category.posts[0] : null,
            form : useForm({
                id: this.$page.props.auth.user ? this.$page.props.auth.user.id : null,
                user: this.$page.props.auth.user ? this.$page.props.auth.user : null,
            }),
            appointmentCategory: this.getAppointmentSection() ? this.getAppointmentSection().category : null
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
        },
        getAppointmentSection(){
            return this.$helpers.getSection(this.$page.props.pages.filter(page => page.title == 'Appointment')).length > 0 ? this.$helpers.getSection(this.$page.props.pages.filter(page => page.title == 'Appointment')[0], 'Appointment') : null;
        },
        getCadeauSection(){
            return this.$helpers.getSection(this.$page.props.pages.filter(page => page.title == 'Home')[0], 'Cadeau');
        },
        getValueByFieldName_campaign(field_name) {
            return this.$helpers.getFieldDocValueObject(this.$helpers.getSectionField(this.getCampaignSection(), field_name) , this.campaign).docValue;
        },
        getValueByFieldName_cadeau(field_name, post) {
            return this.$helpers.getFieldDocValueObject(this.$helpers.getSectionField(this.getCadeauSection(), field_name) , post).docValue;
        },
        getSummarySection(){
            return this.$helpers.getSection(this.$page.props.pages.filter(page => page.title == 'Home')[0], 'Summary');
        },
        getRsvpSection(){
            return this.$helpers.getSection(this.$page.props.pages.filter(page => page.title == 'Home')[0], 'RSVP');
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
    },
    computed: {
        ...Vuex.mapState([
            "cart"
        ])
    },
    mounted() {
        this.$emit("siteReady");
        let roles = [];
        if (this.form.roles) {
            for (let index = 0; index < this.form.roles.length; index++) {
                roles.push(this.form.roles[index].id);
            }
            this.form.roles = [];
            this.form.roles = roles;
        }
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

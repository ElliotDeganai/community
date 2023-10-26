<template>
    <div class="" >
        <div class="relative z-50">
            <div>
                <div class="h-screen w-full">
                    <div class="w-full h-full relative">
                        <img class="w-full h-full object-cover" :src="$helpers.getImageUrl(getCoverSection().category.posts[1])" />
                        <div v-if="$page.props.auth.user" class="flex flex-wrap content-center justify-center w-full h-48 absolute bottom-0 py-16">
                            <Down @click="scrollToRsvp()" class="cursor-pointer opacity-75 loader" :getSize="16" :getColor="'text-white'" />
                        </div>
                    </div>
                </div>
                <div ref="instruction" class="px-4 lg:px-32  py-8 lg:py-16">
                    <div>
                        <div class="title-home">Les instructions de vol de votre hotesse préférée</div>
                        <div class="flex flex-wrap relative py-8 lg:py-16">
                            <div class="w-full relative" :key="field.id" v-for="field in getAudioSection().page_fields">
                                <div class="w-full h-full rounded-xl z-0 absolute top-0 left-0 opacity-25 bg-amber-800"></div>
                                <div class="py-8 px-4" v-if="$helpers.getFieldDocValueObject(field, getAudioSection().category.posts[0]) !== ''">
                                    <div :class="[field.name === 'Image' ? 'absolute left-0 top-0' : '']" class="">
                                        <DocValue :imgSize="{width: 'full', height: '76'}" :getdoc="$helpers.getFieldDocValueObject(field, getAudioSection().category.posts[0])" :getobject="getAudioSection().category.posts[0]" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="py-8">
                        <div class="title-home">Les billets</div>
                        <div>
                            <div class="px-3 py-3 rounded-xl md:rounded-2xl bg-amber-900 text-white">Répondre au RSVP</div>
                        </div>
                        <div>
                            <div class="w-full" :key="field.id" v-for="field in getPassSection().page_fields">
                                <div class="py-2 md:py-4 lg:py-8" v-if="$helpers.getFieldDocValueObject(field, getPass()) !== ''">
                                    <div class="w-full">
                                        <DocValue :imgSize="{width: 'full', height: '76', minHeight: '48'}" :getdoc="$helpers.getFieldDocValueObject(field, getPass())" :getobject="getPass()" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 lg:px-16 border border-amber-200 rounded-lg py-2 md:py-4 lg:py-8">
                        <div class="title-home">Informations supplémentaires</div>
                        <div id="rsvp" ref="rsvp">
                            <div class="w-full summary-home" :key="field.id" v-for="field in getFlightInfoSection().page_fields">
                                <div class="py-2 md:py-4 lg:py-8 flex" v-if="$helpers.getFieldDocValueObject(field, getFlightInfoSection().category.posts[0]) !== ''">
                                    <div class="pr-2 md:pr-4 lg:pr-8" v-if="field.name == 'Flight'">
                                        <Plane v-if="flight_taken === 0" @click.prevent="submit" :getSize="6" class="cursor-pointer scaleup label-fields" />
                                        <Plane v-else :getSize="6" class="text-amber-900" />
                                    </div>
                                    <div v-if="field.name == 'Flight'" class="">
                                        <DocValue class="label-fields cursor-pointer" @click.prevent="submit" v-if="flight_taken === 0" :getdoc="$helpers.getFieldDocValueObject(field, getFlightInfoSection().category.posts[0])" :getobject="getFlightInfoSection().category.posts[0]" />
                                        <div v-else>
                                            <div class="px-3 py-3 rounded-xl md:rounded-2xl bg-amber-900 text-white">Welcome on board! Je te remercie de ta confiance et suis honorée d'etre ton hote! Stay tunned!</div>
                                        </div>
                                    </div>
                                    <div v-else class="">
                                        <div class="flex">
                                            <div class="pr-2 md:pr-4 lg:pr-8">
                                                <Minus @click.prevent="toggleUserList()" v-if="toggleUsers" :getSize="6" class="cursor-pointer label-fields" />
                                                <Add @click.prevent="toggleUserList()" v-else :getSize="6" class="cursor-pointer label-fields" />
                                            </div>
                                            <DocValue class="cursor-pointer label-fields" @click.prevent="toggleUserList()" :setheight="true" :getdoc="$helpers.getFieldDocValueObject(field, getFlightInfoSection().category.posts[0])" :getobject="getFlightInfoSection().category.posts[0]" />
                                        </div>
                                        <div class="relative" v-show="toggleUsers">
                                            <transition name="slide" class="relative">
                                                <div class="relative py-4 px-4">
                                                    <div class="w-full h-full rounded-xl z-0 absolute top-0 left-0 opacity-25 bg-amber-800"></div>
                                                    <div class="z-10 pl-2 md:pl-4 lg:pl-8" :key="user.id" v-for="user in $page.props.getusers.filter(user => user.team === $page.props.auth.user.team)">
                                                        <span class="z-10 relative">-</span> <span class="z-10 relative">{{user.name}}</span>
                                                    </div>
                                                </div>
                                            </transition>
                                        </div>
                                    </div>
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
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import Carousel from './../Help/Carousel/Carousel.vue'
import helpers from '../../../helpers'
import DocValue from './../Help/DocumentationValue.vue'
import Checkout from '../../Stripe/Checkout.vue'
import store from '../../../Store/index';
import Vuex from "vuex";
import Products from './Help/Products.vue'
import Speak from './Help/Speak.vue'
import { useForm } from "@inertiajs/inertia-vue3";
import { Link } from '@inertiajs/inertia-vue3';
import Down from '../../Help/Icon/Down.vue'
import Add from '../../Help/Icon/Add.vue'
import Minus from '../../Help/Icon/Minus.vue'
import Plane from '../Help/Icon/Plane.vue'
import Loading from '../Client/Help/Loading.vue'
export default {
/*     setup(props) {
        const form = useForm({
            user:
        });
        return { form };
    }, */
    props: ['getposts', 'getcategories', 'getintent'],
    components:  {BreezeGuestLayout, DocValue, Carousel, Products, Speak, Link, Down, Loading, Plane, Add, Minus},
    layout: BreezeGuestLayout,
    data() {
        return {
            page: this.$page.props.pages.filter(page => page.title == 'Boarding')[0],
            sections: this.$page.props.pages.filter(page => page.title == 'Boarding')[0].page_sections,
            toggleUsers: false,
            flight_taken: 0,
            form : useForm({
                id: this.$page.props.auth.user ? this.$page.props.auth.user.id : null,
                user: this.$page.props.auth.user ? this.$page.props.auth.user : null,
                roles: this.$page.props.auth.user ? this.$page.props.auth.user.roles : null,
                name: this.$page.props.auth.user ? this.$page.props.auth.user.name : null,
                has_answered: this.$page.props.auth.user ? this.$page.props.auth.user.has_answered : null,
                has_company: this.$page.props.auth.user ? this.$page.props.auth.user.has_company : null,
                is_accompanied: this.$page.props.auth.user ? this.$page.props.auth.user.is_accompanied : null,
                is_partying: this.$page.props.auth.user ? this.$page.props.auth.user.is_partying : null,
                flight_taken: this.$page.props.auth.user ? this.$page.props.auth.user.flight_taken : null,
            }),
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
        toggleUserList(){
            this.toggleUsers = !this.toggleUsers;
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
        getCoverSection(){
            return this.$helpers.getSection(this.$page.props.pages.filter(page => page.title == 'Boarding')[0], 'Cover');
        },
        getAudioSection(){
            return this.$helpers.getSection(this.$page.props.pages.filter(page => page.title == 'Boarding')[0], 'Audio');
        },
        getFlightInfoSection(){
            return this.$helpers.getSection(this.$page.props.pages.filter(page => page.title == 'Boarding')[0], 'Flight info');
        },
        getPassSection(){
            return this.$helpers.getSection(this.$page.props.pages.filter(page => page.title == 'Boarding')[0], 'Pass');
        },
        getPass(){
            let user_team = this.$page.props.auth.user.team;
            let pass = null;
            switch (user_team) {
                case 'paris':
                    pass = this.getPassSection().category.posts[0];
                    break;
                case 'lux':
                    pass = this.getPassSection().category.posts[1];
                    break;
                case 'swiss':
                    pass = this.getPassSection().category.posts[2];
                    break;

                default:
                    break;
            }
            return pass;
        },
        submit() {
            let self = this;

            this.form.flight_taken = 1;
            this.form.put(route("users.update", this.form.id),  {
                onSuccess: (form) => {
                    this.flight_taken = 1;
                    //self.updateMode = false;
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
            this.$refs.instruction.scrollIntoView({ behavior: 'smooth' });
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
        getValueByFieldName(field_name) {
            return this.$helpers.getFieldDocValueObject(this.$helpers.getSectionField(this.getRsvpSection(), field_name) , this.rsvp).docValue;
        },
    },
    computed: {
        ...Vuex.mapState([
            "cart"
        ])
    },
    mounted() {
        if (this.form.flight_taken === 1) {
            this.flight_taken = 1;
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

.scaleup {
  animation: scaleup 1s linear infinite;
}

@keyframes scaleup {
  0% { transform: scale(1); }
  50% { transform: scale(2); }
  100% { transform: translateY(1); }
}

     .slide-enter-active{
        animation: slideInVisibility .4s linear, slideIn .4s linear;
        position: absolute;
        left: 0;
        right: 0;
        width: 100%;
    }

       .slide-leave-active, .slide-leave-to, .slide-leave{
        animation: slideOutVisibility .4s linear, slideOut .4s linear;
        position: absolute !important;
        left: 0;
        right: 0;
        width: 100%;
    }

     @keyframes slideIn{
        from{ transform: translateY(-100%); }
        to{ transform: translateY(0); }
    }
    @keyframes slideInVisibility{
        from{ opacity: 0; }
        to{ opacity: 1; }
    }

    @keyframes slideOut{
        from{ transform: translateY(0); }
        to{ transform: translateY(100%); }

    }

    @keyframes slideOutVisibility{
        from{ opacity: 1; }
        to{ opacity: 0; }
    }

html {
  scroll-behavior: smooth;
}
</style>

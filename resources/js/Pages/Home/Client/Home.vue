<template>
    <div class="text-white" >
        <div class="relative z-50">
            <div>
                <div :class="[$page.props.auth.user ? '' : 'h-screen']" class=" w-full">
                    <div v-if="!$page.props.auth.user" class="w-full h-full relative">
                        <video class="w-full h-full object-cover" autoplay muted loop>
                            <source src="/storage/video/intro-2.mp4" type="video/mp4">
                            <source src="/storage/video/intro-2.mp4" type="video/ogg">
                            Your browser does not support the video tag.
                        </video>
                        <div v-if="!$page.props.auth.user" class="absolute top-0 left-0 w-full h-full text-white">
                            <div class="w-full h-full flex flex-wrap justify-center content-center">
                                <Link :href="route('login')" class="shrink-0 flex items-center font-bold text-lg lg:text-4xl text-stone-800 rounded-full px-6 py-4 bg-white/75">Connecte-toi</Link>
                            </div>
                        </div>
                    </div>
                    <div v-else class="pt-8 px-4 md:pt-16 md:px-16 lg:pt-32 lg:px-32">
                       <div>
                            <div class="pt-16" >
                                <div>
                                    <div>
                                        <div class="title-home">{{campaign.name}}</div>
                                    </div>
                                    <div class="py-8">
                                        <div class="py-4 font-bold text-xl">Budget : {{getValueByFieldName_campaign("Budget")}} €</div>
                                        <div class="py-4">Description : {{campaign.body}}</div>
                                    </div>
                                </div>
                            </div>
                       </div>

                       <div v-if="$page.props.auth.user.user">
                            <div class="header-config-client">Mon tiré au sort : <span class="px-3 rounded-full bg-white text-red-900">{{$page.props.auth.user.user.name}}</span></div>
                            <!-- <div>Mon tiré au sort: <span class="px-3 rounded-full bg-white text-red-900">{{$page.props.auth.user.user.name}}</span></div> -->
                            <div class="py-4">
                                <div v-if="list.length > 0" class="py-4">Voici sa liste : </div>
                                <div v-if="list.length > 0">
                                    <div class="w-full border-white border-t-4 first:border-0" :key="gift.id" v-for="gift in list">
                                        <div>
                                            <div class="flex flex-wrap content-center h-full pt-8">
                                                <div v-if="($page.props.auth.isDev || $page.props.auth.isAdmin) || gift.user_id === $page.props.auth.user.user.id" class="h-16 flex flex-wrap content-center">
                                                    <div class="flex flex-wrap rounded-full bg-white text-red-900 py-2 px-3">
                                                        <Gift :getSize="6" />
                                                        <span class="px-3 font-bold">{{gift.name}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="py-8">{{gift.body}}</div>
                                            <div class="">
                                                <div class="w-full">
                                                    <div class="w-full" :key="field.id" v-for="field in getCadeauSection().page_fields">
                                                        <div class="py-2 md:py-4 lg:py-4 flex" v-if="$helpers.getFieldDocValueObject(field, gift) !== ''">
                                                            <div class="">
                                                                <DocValue class="" :getdoc="$helpers.getFieldDocValueObject(field, gift)" :getobject="gift" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-8" v-else>
                                    <div class="rounded-md py-8 px-3 bg-white text-red-900">Ton tiré au sort n'a pas encore ajouté de cadeaux dans sa liste. Contactes le discrètement pour lui demander d'ajouter des idées !</div>
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
import Gift from '../../Help/Icon/Gift.vue'
import Loading from '../Client/Help/Loading.vue'
export default {
/*     setup(props) {
        const form = useForm({
            user:
        });
        return { form };
    }, */
    props: ['getposts', 'getcategories', 'getintent'],
    components:  {BreezeGuestLayout, DocValue, Carousel, Products, Speak, Link, Down, Loading, Gift},
    layout: BreezeGuestLayout,
    data() {
        return {
            page: this.$page.props.pages.filter(page => page.title == 'Home')[0],
            sections: this.$page.props.pages.filter(page => page.title == 'Home')[0].page_sections,
            campaign: this.getCampaignSection().category.posts[0],
            list: this.$page.props.auth.user ? this.getCadeauSection().category.posts.filter(cad => cad.user_id == this.$page.props.auth.user.user.id) : [] ,
            mylist: this.$page.props.auth.user ? this.getCadeauSection().category.posts.filter(cad => cad.user_id == this.$page.props.auth.user.id) : [],
            users: this.getusers,
            model: this.$page.props.auth.user,
            updateMode: false,
            form : useForm({
                id: this.$page.props.auth.user ? this.$page.props.auth.user.id : null,
                user: this.$page.props.auth.user ? this.$page.props.auth.user : null,
                roles: this.$page.props.auth.user ? this.$page.props.auth.user.roles : null,
                name: this.$page.props.auth.user ? this.$page.props.auth.user.name : null,
                has_answered: this.$page.props.auth.user ? this.$page.props.auth.user.has_answered : null,
                has_company: this.$page.props.auth.user ? this.$page.props.auth.user.has_company : null,
                is_accompanied: this.$page.props.auth.user ? this.$page.props.auth.user.is_accompanied : null,
                is_partying: this.$page.props.auth.user ? this.$page.props.auth.user.is_partying : null,
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
        getCampaignSection(){
            return this.$helpers.getSection(this.$page.props.pages.filter(page => page.title == 'Home')[0], 'Campagne');
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

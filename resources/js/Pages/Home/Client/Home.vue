<template>
    <div class="" >
        <div class="">
            <div class="">
                <div>
                    <div v-if="page.header_title !== null">
                        <div :class="page.medias.length > 0 ? 'h-screen' : '' " class="relative flex flex-wrap justify-center content-center">
                            <img v-if="page.medias.length > 0" class="w-full h-full object-cover" :src="$helpers.getObjectImage(page)" />
                            <div v-if="page.medias.length > 0" class="w-full h-full absolute top-0 left-0 bg-black opacity-50"></div>
                            <div v-if="page.header_title || page.header_subtitle" :class="[page.medias.length > 0 ? 'text-white' : '']" class="w-full h-full absolute top-0 left-0 flex flex-wrap justify-center content-center">
                                <div v-if="page.header_title" class="font-bold text-4xl lg:text-6xl w-full text-center">{{page.header_title}}</div>
                                <div v-if="page.header_subtitle" class="font-bold lg:text-xl text-center">{{page.header_subtitle}}</div>
                                <div class="w-full text-center py-8" v-if="!$page.props.auth.user"><Link :href="route('login')" class="text-lg font-bold bg-gray-800 px-3 py-2 rounded-md text-white">Se connecter pour ajouter un projet</Link></div>
                                <div class="w-full text-center py-8" v-else>
                                    <Link :href="route('posts.create_type', 'Projet')" class="text-base lg:text-lg font-bold bg-sky-800 px-3 py-2 rounded-md text-white">
                                        Ajouter un nouveau projet
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="$page.props.auth.user" class="">
                <div v-if="getProjetSection()" class="">
                    <div class="px-4 md:px-8 xl:px-24 py-16">
                        <div class="text-4xl pb-4 w-full text-center font-bold">Projets</div>
                        <div class="w-full flex flex-wrap justify-center py-16">
                            <div :key="projet.id" v-for="projet in getProjects" class="px-4 xl:px-12 py-4 md:w-1/2 lg:w-1/3">
                                <Link :href="route('item_Projet', projet.id )" class="">
                                    <div class="projet-card overflow-hidden relative">
                                        <div class="h-48 md:h-48 lg:h-48 w-full">
                                            <img v-if="$helpers.getProductImage(projet) !== null" class="w-full lg:max-w-xl h-full object-cover" :src="$helpers.getProductImage(projet)" />
                                        </div>
                                        <div class="p-4 xl:p-16 ">
                                            <div class="font-bold text-lg lg:text-2xl pb-8 w-full">{{projet.name}}</div>
                                            <div class="text-base lg:text-xl py-4 min-h-16">{{projet.body}}</div>
                                            <div class="text-xs lg:text-base text-slate-500">Publié par {{projet.user.name}}</div>
                                            <div><div class="text-xs lg:text-base">Deadline: {{getValueByFieldName_projet('Deadline', projet)}}</div></div>
                                        </div>

                                        <div class="w-full text-xs lg:text-base text-white font-bold px-3 py-2 bg-sky-900 bottom-0 flex flex-wrap justify-center"><Link :href="route('posts.edit', projet.id)" class="">Mettre à jour</Link></div>
<!--                                         <div class="w-full" :key="field.id" v-for="field in getProjetSection().page_fields">
                                            <div class="py-2 md:py-4 lg:py-4 flex w-full" v-if="$helpers.getFieldDocValueObject(field, projet) !== ''">
                                                <div v-if="field.name !== 'Image'" class="overflow-hidden">
                                                    <DocValue class="overflow-hidden" :getdoc="$helpers.getFieldDocValueObject(field, projet)" :getobject="projet" />
                                                </div>
                                                <div class="w-full" v-else>
                                                    <div class="h-48 md:h-64 lg:h-78 w-full" v-if="$helpers.getFieldDocValueObject(field, projet).medias.length > 0">
                                                        <img v-if="$helpers.getFieldDocValueObject(field, projet).medias[0]" class="w-full lg:max-w-xl h-full object-conver" :src="$helpers.getFieldDocValueObject(field, projet).medias[0].original_url" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </Link>
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
import Carousel from '../Help/Carousel/Carousel.vue'
import helpers from '../../../helpers'
import DocValue from '../Help/DocumentationValue.vue'
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
import Phone from '../../Help/Icon/Phone.vue'
import Mail from '../../Help/Icon/Mail.vue'
import Loading from './Help/Loading.vue'
import Calendar from '../../Help/Calendar/Calendar.vue'
import Calendly from './Help/Calendly.vue'
import moment from 'moment';
export default {
/*     setup(props) {
        const form = useForm({
            user:
        });
        return { form };
    }, */
    props: ['getposts', 'getcategories', 'getintent'],
    components:  {BreezeGuestLayout, DocValue, Carousel, Products, Speak, Link, Down, Loading, Gift, Calendar, Calendly, Phone, Mail},
    layout: BreezeGuestLayout,
    data() {
        return {
            page: this.$page.props.pages.filter(page => page.title == 'Home')[0],
            sections: this.$page.props.pages.filter(page => page.title == 'Home')[0].page_sections,
            section_projet: this.getProjetSection(),
            //campaign: this.getCampaignSection().category.posts[0],
            form : useForm({
                id: this.$page.props.auth.user ? this.$page.props.auth.user.id : null,
                user: this.$page.props.auth.user ? this.$page.props.auth.user : null,
            })
        }
    },
    methods: {
        formatDate(date){
            return moment(date).format('YYYY-MM-DD');
        },
        getValueByFieldName(field_name) {
            return this.$helpers.getFieldDocValueObject(this.$helpers.getSectionField(this.getCampaignSection(), field_name) , this.campaign).docValue;
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
        getProjetSection(){
            return this.$helpers.getSection(this.$page.props.pages.filter(page => page.title == 'Home')[0], 'Projet');
        },
        getValueByFieldName_campaign(field_name) {
            return this.$helpers.getFieldDocValueObject(this.$helpers.getSectionField(this.getCampaignSection(), field_name) , this.campaign).docValue;
        },
        getValueByFieldName_projet(field_name, post) {
            return this.$helpers.getFieldDocValueObject(this.$helpers.getSectionField(this.getProjetSection(), field_name) , post).docValue;
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
        ]),
        getProjects(){
            if (this.$page.props.auth.isClient) {
                return this.getProjetSection().category.posts.filter(p => p.user_id == this.$page.props.auth.user.id);
            } else {
                return this.getProjetSection().category.posts;
            }
        },
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
        console.log(this.$page.props);
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


.projet-card:hover {
    transform: translateY(-5px);
}


.projet-card {
    background-color: #FFFFFF;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
}


.projets {
    background-color: #EDE7E3;
}


.review-card {
    background-color: #FFFFFF;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
}


.reviews {
    background-color: #F5F5F5;
}
</style>

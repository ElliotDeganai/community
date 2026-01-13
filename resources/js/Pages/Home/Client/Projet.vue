<template>
    <div class="" >
        <div class="">
            <div class="">
                <div>
                    <div v-if="page.header_title !== null">
                        <div :class="page.medias.length > 0 ? 'h-screen' : 'h-72' " class="relative flex flex-wrap justify-center content-center">
                            <img v-if="page.medias.length > 0" class="w-full h-full object-cover" :src="$helpers.getObjectImage(page)" />
                            <div v-if="page.medias.length > 0" class="w-full h-full absolute top-0 left-0 bg-black opacity-50"></div>
                            <div v-if="page.header_title || page.header_subtitle" :class="[page.medias.length > 0 ? 'text-white' : '']" class="w-full h-full absolute top-0 left-0 flex flex-wrap justify-center content-center">
                                <div v-if="page.header_title" class="font-bold text-6xl w-full text-center">{{page.header_title}}</div>
                                <div v-if="page.header_subtitle" class="font-bold text-xl">{{page.header_subtitle}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="$page.props.auth.user" class="">
                <div v-if="getProjetSection() && !selectProjet" class="projets">
                    <div class="px-24 py-16">
                        <div class="text-4xl pb-4 w-full text-center font-bold">Derniers projets</div>
                        <div class="w-full flex flex-wrap justify-center py-16">
                            <div :key="projet.id" v-for="projet in getProjetSection().category.posts" class="px-12 py-4 w-1/3">
                                <div @click.prevent="selectProjet = projet" class="projet-card h-full overflow-hidden cursor-pointer">
                                    <div class="w-full">
                                        <div class="h-48 md:h-48 lg:h-48 w-full">
                                            <img class="w-full lg:max-w-xl h-full object-cover" :src="$helpers.getProductImage(projet)" />
                                        </div>
                                        <div class="p-16 ">
                                            <div class="font-bold text-2xl pb-8 w-full">{{projet.name}}</div>
                                            <div class="text-xl py-4">{{projet.body}}</div>
                                            <div class=" text-slate-500">Publié par {{projet.user.name}}</div>
                                            <div><div class="text-white font-bold px-3 py-2 bg-teal-900 rounded-full inline-block">Statut: {{getValueByFieldName_projet('Status', projet)}}</div></div>
                                            <div><div class="">Deadline: {{getValueByFieldName_projet('Deadline', projet)}}</div></div>
                                        </div>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div class="px-32 pb-24">
                        <div class="">
                            <div class="bg-sky-800 text-white rounded-t-lg pt-8">
                                <div><div class="font-bold text-4xl pb-8 w-full text-center">{{selectProjet.name}}</div></div>
                                <div><div class="font-bold text-lg pb-8 w-full text-center">{{formatDate(selectProjet.created_at)}}</div></div>
                            </div>
                            <div class=" px-8">
                                <div class="py-8">
                                    <div class="flex flex-wrap">
                                        <div class="w-1/4 pr-4">
                                            <div class="bg-slate-200 rounded-lg p-8 ">
                                                <div>Deadline</div>
                                                <div class="font-bold text-2xl pb-8 w-full">{{formatDate(getValueByFieldName_projet('Deadline', selectProjet))}}</div>
                                            </div>
                                        </div>
                                        <div class="w-1/4 px-2">
                                            <div class="p-8 bg-slate-200 rounded-lg">
                                                <div>Client</div>
                                                <div class="font-bold text-2xl pb-8 w-full">{{selectProjet.user.name}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-8">
                                    <div class="text-xl">Description du projet:</div>
                                    <div v-html="getValueByFieldName_projet('Description', selectProjet)" class=""></div>
                                </div>

                                <div @click.prevent="selectProjet = null" class="text-white font-bold px-3 cursor-pointer inline-block py-2 bg-teal-900 rounded-full">Retourner sur la liste</div>
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
import moment from 'moment';
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
            page: this.$page.props.pages.filter(page => page.title == 'Projet')[0],
            sections: this.$page.props.pages.filter(page => page.title == 'Projet')[0].page_sections,
            section_projet: this.getProjetSection(),
            //campaign: this.getCampaignSection().category.posts[0],
            form : useForm({
                id: this.$page.props.auth.user ? this.$page.props.auth.user.id : null,
                user: this.$page.props.auth.user ? this.$page.props.auth.user : null,
            }),
            selectProjet: null
        }
    },
    methods: {
        formatDate(date){
            return moment(date).format('DD-MM-YYYY');
        },
        setProjet(projet) {
            this.selectProjet = projet;
        },
        unsetProjet() {
            this.selectProjet = null;
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
            return this.$helpers.getSection(this.$page.props.pages.filter(page => page.title == 'Projet')[0], 'Projet');
        },
        getValueByFieldName_campaign(field_name) {
            return this.$helpers.getFieldDocValueObject(this.$helpers.getSectionField(this.getCampaignSection(), field_name) , this.campaign).docValue;
        },
        getValueByFieldName_projet(field_name, post) {
            return this.$helpers.getFieldDocValueObject(this.$helpers.getSectionField(this.getProjetSection(), field_name) , post).docValue;
        },
        getSummarySection(){
            return this.$helpers.getSection(this.$page.props.pages.filter(page => page.title == 'Projet')[0], 'Summary');
        },
        getRsvpSection(){
            return this.$helpers.getSection(this.$page.props.pages.filter(page => page.title == 'Projet')[0], 'RSVP');
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
        getLatestReviews() {

        }
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

<template>
    <div class="text-white" >
        <div class="relative z-50">
            <div>
                <div :class="[$page.props.auth.user ? '' : 'h-screen']" class=" w-full">
                    <div class="pt-8 px-4 md:pt-16 md:px-16 lg:pt-32 lg:px-32">
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
                       <div>
                            <div>
                                <div v-if="$page.props.status.message" class="p-4 rounded-md bg-blue-100 text-blue-700 bold">{{$page.props.status.message}}</div>
                            </div>
                       </div>
                       <div>
                            <div>
                                <div class="py-4">
                                    <div class="header-config-client">Ma liste</div>
                                    <div class="py-4">
                                        <div class="w-full border-white border-t-4 first:border-0  py-4 lg:py-8" :key="gift.id" v-for="gift in mylist">
                                            <div>
                                                <div class="flex flex-wrap content-center h-full py-8">
                                                    <div v-if="($page.props.auth.isDev || $page.props.auth.isAdmin) || gift.user_id === $page.props.auth.user.id" class="h-16 flex flex-wrap content-center">
                                                        <Link class="flex flex-wrap rounded-full bg-white text-red-900 py-2 px-3" :href="route('posts.edit_gift', gift.id)">
                                                            <span class="pr-3 font-bold text-xl">{{gift.name}}</span>
                                                            <Edit :getSize="6" />
                                                        </Link>
                                                    </div>
                                                    <div class="px-3">
                                                        <button v-if="($page.props.auth.isDev || $page.props.auth.isAdmin) || gift.user_id === $page.props.auth.user.id" class="btn-delete" @click="this.$store.dispatch('set_model', {model: gift, route: 'resource', type: 'resource'})"><Trash :getSize="6" /></button>
                                                    </div>
                                                </div>
                                                <div>{{gift.body}}</div>
                                                <div>
                                                    <div class="w-full">
                                                        <div class="w-full" :key="field.id" v-for="field in getCadeauSection().page_fields">
                                                            <div class="py-2 md:py-4 lg:py-4 flex w-full" v-if="$helpers.getFieldDocValueObject(field, gift) !== ''">
                                                                <div v-if="field.name !== 'Image'" class="">
                                                                    <DocValue class="" :getdoc="$helpers.getFieldDocValueObject(field, gift)" :getobject="gift" />
                                                                </div>
                                                                <div class="w-full" v-else>
                                                                    <div class="h-48 md:h-64 lg:h-78 w-full" v-if="$helpers.getFieldDocValueObject(field, gift).medias.length > 0">
                                                                        <img class="w-full lg:max-w-xl h-full object-conver" :src="$helpers.getFieldDocValueObject(field, gift).medias[0].original_url" />
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
                                <div>
                                    <div class="py-4">
                                        <Link :href="route('posts.create_gift')" class="text-lg font-bold bg-white px-3 py-2 rounded-md text-red-900">
                                            Ajouter un voeu
                                        </Link>
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
//import { useForm } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/vue3";
//import { Link } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/vue3'
import Down from '../../Help/Icon/Down.vue'
import Trash from '../../Help/Icon/Trash.vue'
import Edit from '../../../Pages/Help/Icon/Edit.vue'
import Loading from '../Client/Help/Loading.vue'
import { mapActions } from 'vuex'
export default {
/*     setup(props) {
        const form = useForm({
            user:
        });
        return { form };
    }, */
    //store: store,
    props: ['getposts', 'getcategories', 'getintent'],
    components:  {BreezeGuestLayout, DocValue, Carousel, Products, Speak, Link, Down, Loading, Trash, Edit},
    layout: BreezeGuestLayout,
    data() {
        return {
            page: this.$page.props.pages.filter(page => page.title == 'Wishlist')[0],
            sections: this.$page.props.pages.filter(page => page.title == 'Wishlist')[0].page_sections,
            campaign: this.getCampaignSection().category.posts[0],
            list: this.$page.props.auth.user.user ? this.getCadeauSection().category.posts.filter(cad => cad.user_id == this.$page.props.auth.user.user.id) : [],
            mylist: this.getCadeauSection().category.posts.filter(cad => cad.user_id == this.$page.props.auth.user.id),
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
            return this.$helpers.getSection(this.$page.props.pages.filter(page => page.title == 'Wishlist')[0], 'Campagne');
        },
        getCadeauSection(){
            return this.$helpers.getSection(this.$page.props.pages.filter(page => page.title == 'Wishlist')[0], 'Cadeau');
        },
        getValueByFieldName_campaign(field_name) {
            return this.$helpers.getFieldDocValueObject(this.$helpers.getSectionField(this.getCampaignSection(), field_name) , this.campaign).docValue;
        },
        getValueByFieldName_cadeau(field_name, post) {
            return this.$helpers.getFieldDocValueObject(this.$helpers.getSectionField(this.getCadeauSection(), field_name) , post).docValue;
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
        submit_delete(post) {
            Inertia.delete(route("posts.delete", post.id));
        },
        ...mapActions([
            'set_model'
        ]),
    },
    computed: {
        ...Vuex.mapState([
            "cart"
        ]),
        delete_model () {
            return this.$store.state.model;
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

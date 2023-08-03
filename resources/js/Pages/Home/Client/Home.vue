<template>
    <div class="" >
        <div class="relative z-50">
            <div>
                <div class="h-screen w-full">
                    <div class="w-full h-full relative">
                        <img v-if="$page.props.auth.user" class="w-full h-full object-cover" :src="$helpers.getImageUrl(getCoverSection().category.posts[0])" />
                        <video class="w-full h-full object-cover" v-else autoplay muted loop>
                            <source src="/storage/video/intro-2.mp4" type="video/mp4">
                            <source src="/storage/video/intro-2.mp4" type="video/ogg">
                            Your browser does not support the video tag.
                        </video>
                        <div v-if="!$page.props.auth.user" class="absolute top-0 left-0 w-full h-full text-white">
                            <div class="w-full h-full flex flex-wrap justify-center content-center">
                                <Link :href="route('login')" class="shrink-0 flex items-center font-bold text-lg lg:text-2xl text-stone-800 rounded-full px-3 py-2 bg-white/75">Connecte-toi</Link>
                            </div>
                        </div>
                        <div v-if="$page.props.auth.user" class="flex flex-wrap content-center justify-center w-full h-48 absolute bottom-0 py-16">
                            <Down @click="scrollToRsvp()" class="cursor-pointer opacity-75 loader" :getSize="16" :getColor="'text-white'" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative px-0 lg:px-32 xl:px-32" v-if="$page.props.auth.user">
            <div ref="summary" class="px-8 lg:px-32 xl:px-32 py-8 lg:py-16">
                <div class="title-home">{{getSummarySection().category.posts[0].name}}</div>
                <div class="summary-home" :key="post.id" v-for="post in getSummarySection().category.posts">
                    <div class="">
                        <div class="w-full" :key="field.id" v-for="field in getSummarySection().page_fields">
                            <div class="py-8" v-if="$helpers.getFieldDocValueObject(field, post) !== ''">
                                <div class="w-full">
                                    <DocValue :getdoc="$helpers.getFieldDocValueObject(field, post)" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div ref="explanations" class="">
                        <video class="w-full h-56 lg:h-90 object-cover" controls>
                            <source class="w-full h-full" src="/storage/video/Level35.mp4" type="video/mp4">
                            <source class="w-full h-full" src="/storage/video/Level35.mp4" type="video/ogg">
                            Your browser does not support the video tag.
                        </video>
                </div>
            </div>
        </div>
        <div class="relative" v-if="$page.props.auth.user">
            <div ref="targetRef" class="px-4 lg:px-32 py-8">
                <div class="px-4 lg:px-16 border border-amber-200 rounded-lg py-8">
                    <div>
                        <div class="title-home">{{getValueByFieldName("Title")}}</div>
                    </div>
                    <div v-if="$page.props.status.message" class="p-2 lg:p-4 rounded-md bg-blue-100 text-blue-700 bold">{{$page.props.status.message}}</div>
                    <div class="py-8 summary-home">
                        <div v-if="$page.props.auth.user.has_answered && !updateMode">
                            <div v-html="replaceUser(createDiv(getValueByFieldName('Answer - Description')))">
                            </div>
                            <div>
                                <div class="py-4">
                                    <label class="label-fields">
                                        {{getValueByFieldName("Question - Coming")}} <span class="px-2 rounded-full bg-amber-900 text-white" v-if="$page.props.auth.user.is_partying == 0">{{getValueByFieldName("Option - No")}}</span> <span class="px-2 rounded-full bg-amber-900 text-white" v-else>{{getValueByFieldName("Option - Yes")}}</span>
                                    </label>
                                </div>
                                <div v-if="$page.props.auth.user.has_company" class="py-4">
                                    <label class="label-fields">
                                        {{getValueByFieldName("Question - Plus 1")}} <span class="px-2 rounded-full bg-amber-900 text-white" v-if="$page.props.auth.user.is_accompanied == 0">{{getValueByFieldName("Option - No")}}</span> <span class="px-2 rounded-full bg-amber-900 text-white" v-else>{{getValueByFieldName("Option - Yes")}}</span>
                                    </label>
                                </div>
                                <div class="">
                                    <button @click.prevent="changeAnswers()" class="btn-submit-fields">{{getValueByFieldName("Button - Change answers")}}</button>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <form @submit.prevent="submit">

                                <div v-html="replaceUser(createDiv(getValueByFieldName('Question - Description')))">
                                </div>
                                <div>
                                    <div></div>
                                    <div class="py-4">
                                        <label class="label-fields"  for="is_partying">{{getValueByFieldName("Question - Coming")}}</label>
                                        <div class="py-2">
                                            <input type="radio" class=" form-fields" id="is_partying" name="is_partying" v-model="form.is_partying" value="0" /> {{getValueByFieldName("Option - No")}}
                                            <input type="radio" class=" form-fields" id="is_partying" name="is_partying" v-model="form.is_partying" value="1" /> {{getValueByFieldName("Option - Yes")}}
                                            <!-- <div class="error-msg" v-if="errors.is_partying">{{ errors.is_partying }}</div> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="py-4" v-if="form.user.has_company">


                                    <div v-html="replaceUser(createDiv(getValueByFieldName('Question - Plus 1 - Description')))">
                                    </div>
                                    <div class="py-4">
                                        <label class="label-fields"  for="is_accompanied">{{getValueByFieldName("Question - Plus 1")}}</label>
                                        <div class="py-2">
                                            <input type="radio" class=" form-fields" id="is_accompanied" name="is_accompanied" v-model="form.is_accompanied" value="0" /> {{getValueByFieldName("Option - No")}}
                                            <input type="radio" class=" form-fields" id="is_accompanied" name="is_accompanied" v-model="form.is_accompanied" value="1" /> {{getValueByFieldName("Option - Yes")}}
                                            <!-- <div class="error-msg" v-if="errors.is_accompanied">{{ errors.is_accompanied }}</div> -->
                                        </div>
                                    </div>
                                </div>
                                <div class=" flex flex-wrap justify-around w-full">
                                    <button class="btn-submit-fields" type="submit">{{getValueByFieldName("Button - Validate")}}</button>
                                    <button @click.prevent="cancel()" class="btn-submit-fields">{{getValueByFieldName("Button - Cancel")}}</button>
                                </div>
                            </form>
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
export default {
/*     setup(props) {
        const form = useForm({
            user:
        });
        return { form };
    }, */
    props: ['getposts', 'getcategories', 'getintent'],
    components:  {BreezeGuestLayout, DocValue, Carousel, Products, Speak, Link, Down},
    layout: BreezeGuestLayout,
    data() {
        return {
            page: this.$page.props.pages.filter(page => page.title == 'Home')[0],
            sections: this.$page.props.pages.filter(page => page.title == 'Home')[0].page_sections,
            rsvp: this.getRsvpSection().category.posts[0],
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
            })
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
        getCoverSection(){
            return this.$helpers.getSection(this.$page.props.pages.filter(page => page.title == 'Home')[0], 'Cover');
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
        getValueByFieldName(field_name) {
            return this.$helpers.getFieldDocValueObject(this.$helpers.getSectionField(this.getRsvpSection(), field_name) , this.rsvp).docValue;
        }
    },
    computed: {
        ...Vuex.mapState([
            "cart"
        ])
    },
    mounted() {
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
  animation: loading 1s linear infinite;
}

@keyframes loading {
  0% { transform: translateY(0); }
  50% { transform: translateY(-30%); }
  100% { transform: translateY(0); }

}
</style>

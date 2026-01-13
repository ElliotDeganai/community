<template>
    <div class="min-h-screen" >
        <div class="">
            <div v-if="$page.props.auth.user" class="">
                <div>
                    <div class="px-4 md:px-16 xl:px-32 py-24">
                        <div class="border rounded-lg overflow-hidden">
                            <div class="bg-sky-900 text-white py-4">
                                <div><div class="font-bold text-xl lg:text-4xl pb-8 w-full text-center">{{projet.name}}</div></div>
                                <div><div class="font-bold text-base lg:text-lg w-full text-center">{{formatDate(projet.created_at)}}</div></div>
                            </div>
                            <div class=" p-8">
                                <div class="py-8">
                                    <div class="flex flex-wrap">
                                        <div class="w-1/2 md:w-1/3 xl:w-1/4 pr-4">
                                            <div class="bg-slate-200 rounded-lg p-2 md:p-4 xl:p-8 ">
                                                <div class="text-xs md:text-base">Deadline</div>
                                                <div class="font-bold text-base md:text-lg xl:text-2xl pb-2 md:pb-8 w-full">{{formatDate(getValueByFieldName_projet('Deadline', projet))}}</div>
                                            </div>
                                        </div>
                                        <div class="w-1/2 md:w-1/3 xl:w-1/4 px-2">
                                            <div class="p-2 md:p-4 xl:p-8 bg-slate-200 rounded-lg">
                                                <div class="text-xs md:text-base">Client</div>
                                                <div class="font-bold text-base md:text-lg xl:text-2xl pb-2 md:pb-8 w-full truncate">{{projet.user.name}}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="h-48 md:h-56 lg:h-72 w-full py-4 md:py-8 flex flex-wrap justify-center">
                                        <img @click.prevent="this.$store.dispatch('set_image_modal', {image: $helpers.getProductImage(projet)})" v-if="$helpers.getProductImage(projet) !== null" class="w-full lg:w-full h-full object-contain cursor-pointer" :src="$helpers.getProductImage(projet)" />
                                    </div>
                                </div>
                                <div class="py-2 md:py-8">
                                    <div class="text-base md:text-xl font-bold pb-4">Description du projet:</div>
                                    <div v-html="getValueByFieldName_projet('Description', projet)" class="text-xs md:text-base"></div>
                                </div>


                                <div v-if="$helpers.getGalleryImages(projet.doc_values.filter(dv => dv.documentation.type == 'gallery')[0])" class="py-2 md:py-8">
                                    <div class="text-base md:text-xl font-bold pb-4">Maquette</div>
                                    <div class="w-full py-4 md:py-8 flex flex-wrap justify-center">
                                        <div :key="img" v-for="img in $helpers.getGalleryImages(projet.doc_values.filter(dv => dv.documentation.type == 'gallery')[0])" class="w-1/2 md:w-1/3 xl:w-1/4 p-4">
                                            <img @click.prevent="this.$store.dispatch('set_image_modal', {image: img})" v-if="img !== null" class="w-full lg:w-full h-full object-contain cursor-pointer" :src="img" />
                                        </div>
                                    </div>
                                </div>

                                <div class="md:flex md:flex-wrap">
                                    <div class="md:pr-8"><Link :href="route('home')" class="text-white font-bold px-3 py-2 bg-sky-900">Retourner à la liste</Link></div>
                                    <div class="py-8 md:py-0"><Link :href="route('posts.edit', projet.id)" class="text-white font-bold px-3 py-2 bg-sky-900">Mettre à jour</Link></div>
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
import helpers from '../../../../helpers'
import DocValue from '../../Help/DocumentationValue.vue'
import store from '../../../../Store/index';
import moment from 'moment';
import Vuex from "vuex";
import { useForm } from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3'
export default {
/*     setup(props) {
        const form = useForm({
            user:
        });
        return { form };
    }, */
    props: ['getpost', 'getprojetsection', 'getfields'],
    components:  {BreezeGuestLayout, DocValue, Link},
    layout: BreezeGuestLayout,
    data() {
        return {
            projet: this.getpost,
            section: this.getprojetsection,
            fields: this.getfields
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
        getValue(docValue){
            return helpers.getValue(docValue);
        },
        getFieldDocValue(field, post){
            return helpers.getFieldDocValue(field, post);
        },
        ...Vuex.mapActions([
            "saveCartItem", "addCartItemQuantity", "set_image_modal"
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
        getValueByFieldName_projet(field_name, post) {
            this.section.page_fields = this.fields;
            return this.$helpers.getFieldDocValueObject(this.$helpers.getSectionField(this.section, field_name) , post).docValue;
        },
    },
    computed: {
        ...Vuex.mapState([
            "cart", "image_modal", "model"
        ]),
        getLatestReviews() {

        }
    },
    mounted() {
        this.$emit("siteReady");
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

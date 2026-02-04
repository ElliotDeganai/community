<template>
    <div class="px-4 md:px-32">
        <div class="py-16 md:py-32">
            <div class="text-xl font-bold w-full">
                <div class="text-center w-full uppercase">Paramètres du site</div>
            </div>
        </div>
        <div class="text-xs md:text-base">From here, you can edit your site parameters</div>
        <div>
            <div>
                <div v-if="$page.props.status.message" class="p-4 rounded-md bg-blue-100 text-blue-700 bold">{{$page.props.status.message}}</div>
                <div>
                    <div class="py-2">
                        <form  @submit.prevent="submit">
                            <Fields @modelSubmited="submit()" :getmodel="form"  :errors="errors"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Layout from '../../../Layouts/Authenticated.vue';
import Fields from '../../Help/Form/Parameters/Fields.vue'
import { reactive } from 'vue'
//import { Inertia } from '@inertiajs/inertia'
import { router } from '@inertiajs/vue3'
//import { useForm } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/vue3";
export default {
    layout: Layout,
    components: {Fields},
    setup(props) {
        function getParentPost(){
            if (props.getpost.post && props.getParentCategory) {
                return props.getParentCategory.posts.filter(post => post.id == props.getpost.post.id)[0];
            }else {
                return null;
            }
        }
        const parentPost = getParentPost();
        const form = useForm({
            _method: 'put',
            id: props.getpost.id,
            site_name: props.getpost.site_name,
            email: props.getpost.email,
            phone: props.getpost.phone,
            address: props.getpost.address,
            postal_code: props.getpost.postal_code,
            country: props.getpost.country,
            facebook: props.getpost.facebook,
            instagram: props.getpost.instagram,
            linkedin: props.getpost.linkedin,
            youtube: props.getpost.youtube,
            //images: null,
            logo_light: new Array(),
            logo_dark: new Array(),
            logo_footer: new Array(),
            medias_logo_light: props.getpost.medias.filter(m => m.collection_name == 'logo_light'),
            medias_logo_dark: props.getpost.medias.filter(m => m.collection_name == 'logo_dark'),
            medias_logo_footer: props.getpost.medias.filter(m => m.collection_name == 'logo_footer')
        })
        return { form, getParentPost, parentPost };
    },
    props: {
        getpost: Object,
        errors: Object,
        getcategories: Array,
        getusers: Array,
        getParentCategory: Object
    },
    methods: {
        submit() {
            this.form.post(route("parameters.update", this.getpost.id), {
                forceFormData: true,
            });
        }
    },
    data() {
        return {
            parentCategory: this.getParentCategory,
            //parentPost: this.getParentCategory.posts.filter(post => post.id == this.getpost.post.id)[0]
        }
    },
    created() {
        this.getpost.images = new Array();
        this.getpost.logo_light = new Array();
        this.getpost.logo_dark = new Array();
        this.getpost.logo_footer = new Array();
    },
}
</script>

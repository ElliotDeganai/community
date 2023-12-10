<template>
    <div class="pt-8 px-4 md:pt-16 md:px-16 lg:pt-32 lg:px-32 text-white">
        <div class="py-16 lg:py-32">
            <div class="text-xl font-bold w-full">
                <div class="text-center w-full uppercase">Mettre à jour une idée</div>
            </div>
        </div>
        <div>Donnes au moins un nom à ton idée. Les autres champs ne sont pas obligatoires.</div>
        <div>
            <div>
                <div v-if="$page.props.status.message" class="p-4 rounded-md bg-blue-100 text-blue-700 bold">{{$page.props.status.message}}</div>
                <div>
                    <div class="py-2">
                        <form  @submit.prevent="submit">
                            <Fields  @modelSubmited="submit()" :getmodel="form" :categories="getcategories" :getparent="getParentPost()"
                                :getparentcategory="parentCategory" :getparentpost="getParentPost()" :errors="errors"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Layout from '../../../../../Layouts/Guest.vue';
import Fields from '../Field/Fields.vue'
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { useForm } from "@inertiajs/inertia-vue3";
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
            name: props.getpost.name,
            slug: props.getpost.slug,
            body: props.getpost.body,
            published: props.getpost.published,
            published_at: props.getpost.published_at,
            category_id: props.getpost.category,
            doc_values: props.getpost.doc_values,
            excerpt: props.getpost.excerpt,
            post_id: parentPost
        })
        return { form, getParentPost, parentPost };
    },
    props: {
        getpost: Object,
        errors: Object,
        getcategories: Array,
        getParentCategory: Object
    },
    methods: {
        submit() {
            this.form.post(route("posts.update", this.getpost.id), {
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
        this.getpost.doc_values.forEach(element => {
            element.images = new Array();
            element.gallery = new Array();
            element.carousel = new Array();
            element.audio = new Array();
        });
    },
}
</script>

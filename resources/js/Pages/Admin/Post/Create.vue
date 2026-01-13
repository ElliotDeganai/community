<template>
    <div class="px-4 md:px-32">
        <div class="py-16 md:py-32">
            <div v-if="$page.props.auth.isDev || $page.props.auth.isAdmin || $page.props.auth.isEditor" class="text-xl font-bold w-full">
                <div v-if="type" class="text-center w-full uppercase">Create a new {{getcategories[0].name}} resources</div>
                <div v-else class="text-center w-full uppercase">Create a resource</div>
            </div>
            <div v-else class="text-xl font-bold w-full">
                <div class="text-center w-full uppercase">Créer un nouveau projet</div>
            </div>
        </div>
        <div  class="text-xs md:text-base" v-if="$page.props.auth.isDev || $page.props.auth.isAdmin || $page.props.auth.isEditor">From this page you can create your resources and their associated documentation values</div>
        <div v-if="type && getcategories[0] && ($page.props.auth.isDev || $page.props.auth.isAdmin || $page.props.auth.isEditor)" class="py-8 text-xs md:text-lg">
            <Link :href="route('posts.edit', getcategories[0].id )" class="font-bold bg-gray-800 px-3 py-2 rounded-md text-white">
                Edit the {{getcategories[0].name}} template
            </Link>
        </div>
        <div>
            <div>
                <div>
                    <div class="py-2">
                        <form  @submit.prevent="submit">
                            <div>
                                <Fields v-if="$page.props.auth.isDev || $page.props.auth.isAdmin || $page.props.auth.isEditor" @modelSubmited="submit()" :getparent="getparent" :getparentpost="getparent"
                                 :getmodel="form" :categories="getcategories" :errors="errors" />
                                <FieldsProjet v-else @modelSubmited="submit()" :getparent="getparent" :getparentpost="getparent"
                                 :getmodel="form" :categories="getcategories" :errors="errors" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Layout from '../../../Layouts/Authenticated.vue';
import Fields from '../../Help/Form/Post/Fields.vue'
import FieldsProjet from '../../Help/Form/Post/FieldsProjet.vue'
import { reactive } from 'vue'
//import { Inertia } from '@inertiajs/inertia'
import { router } from '@inertiajs/vue3'
export default {
    setup (props) {
        const form = reactive({
            name: null,
            slug: null,
            body: null,
            published: 0,
            published_at: null,
            category_id: null,
            post_id: null,
            doc_values: [],
            excerpt: null,
            image: null,
        });
        const getparent = props.getparent;

        function submit() {
            router.post('/admin/posts', form);
        }

        return { form, submit, getparent }
    },
    layout: Layout,
    props: {
        errors: Object,
        getcategories: Array,
        gettype: Object,
        getparent: Object,
        getpage: Object,
    },
    data() {
        return {
            type: this.gettype,
        }
    },
    components: {Fields,FieldsProjet},
    created() {
        if(this.type){
            this.form.category_id = this.getcategories[0];
        }
    },
}
</script>

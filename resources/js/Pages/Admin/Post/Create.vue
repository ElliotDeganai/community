<template>
    <div class="px-32">
        <div class="py-32">
            <div class="text-xl font-bold w-full">
                <div v-if="type" class="text-center w-full uppercase">Create a new {{getcategories[0].name}} resources</div>
                <div v-else class="text-center w-full uppercase">Create a resource</div>
            </div>
        </div>
        <div>From this page you can create your resources and their associated documentation values</div>
        <div v-if="type && getcategories[0]" class="py-8">
            <Link :href="route('posts.edit', getcategories[0].id )" class="text-lg font-bold bg-gray-800 px-3 py-2 rounded-md text-white">
                Edit the {{getcategories[0].name}} template
            </Link>
        </div>
        <div>
            <div>
                <div>
                    <div class="py-2">
                        <form  @submit.prevent="submit">
                            <div>
                                <Fields @modelSubmited="submit()" :getmodel="form" :categories="getcategories" :errors="errors" />
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
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
export default {
    setup () {
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
        })

        function submit() {
            Inertia.post('/admin/posts', form);
        }

        return { form, submit }
    },
    layout: Layout,
    props: {
        errors: Object,
        getcategories: Array,
        gettype: Object,
    },
    data() {
        return {
            type: this.gettype,
        }
    },
    components: {Fields},
    created() {
        if(this.type){
            this.form.category_id = this.getcategories[0];
        }
    },
}
</script>

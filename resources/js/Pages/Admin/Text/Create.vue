<template>
    <div class="px-32">
        <div class="py-32">
            <div class="text-xl font-bold w-full">
                <div class="text-center w-full uppercase">Create a Free text</div>
            </div>
        </div>
        <div>From this page you can create your free text and their associated documentation values</div>
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
//import { Inertia } from '@inertiajs/inertia'
import { router } from '@inertiajs/vue3'
export default {
    setup () {
        const form = reactive({
            title: null,
            slug: null,
            body: null,
            published: 0,
            published_at: null,
            category_id: null,
            doc_values: [],
            excerpt: null,
            image: null,
        })

        function submit() {
            router.post('/admin/posts', form);
        }

        return { form, submit }
    },
    layout: Layout,
    props: {
        errors: Object,
        getcategories: Array
    },
    components: {Fields},
}
</script>

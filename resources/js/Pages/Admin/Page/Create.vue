<template>
    <div class="px-32">
        <div class="py-32">
            <div class="text-xl font-bold w-full">
                <div class="text-center w-full uppercase">Create a Page</div>
            </div>
        </div>
        <div>From here you can create your pages and define which category will be used on the page</div>
        <div>
            <div>
                <div>
                    <div class="py-2">
                        <form  @submit.prevent="submit">
                            <div>
                                <Fields @modelSubmited="submit()" :getmodel="form" :errors="errors"
                                    :getcategories="getcategories"
                                    :getiteration="getiteration" />
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
import Fields from '../../Help/Form/Page/PageToCategory.vue'
import { reactive } from 'vue'
//import { Inertia } from '@inertiajs/inertia'
import { router } from '@inertiajs/vue3'
export default {
    setup () {
        const form = reactive({
            header_title: null,
            header_subtitle: null,
            title: null,
            url: null,
            url_name: null,
            template: null,
            description: null,
            published: 0,
            published_at: null,
            categories: [],
            page_sections: [],
            page_fields: [],
            images: []
        })

        function submit() {
            router.post('/admin/pages', form);
        }

        return { form, submit }
    },
    layout: Layout,
    props: {
        errors: Object,
        getiteration: Number,
        getcategories: Array
    },
    components: {Fields},
}
</script>

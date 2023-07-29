<template>
    <div class="px-32">
        <div class="py-32">
            <div class="text-xl font-bold w-full">
                <div class="text-center w-full uppercase">Edit a page</div>
            </div>
        </div>
        <div>From here you can edit your pages and their associated categories</div>
        <div>
            <div>
                <div v-if="$page.props.status.message" class="p-4 rounded-md bg-blue-100 text-blue-700 bold">{{$page.props.status.message}}</div>
                <div>
                    <div class="py-2">
                        <form  @submit.prevent="submit">
                            <Fields
                                :getcategories="getcategories"
                                :getiteration="getiteration"
                                @modelSubmited="submit()"
                                :getmodel="form"
                                :errors="errors"
                            />
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
import { Inertia } from '@inertiajs/inertia'
import { useForm } from "@inertiajs/inertia-vue3";
export default {
    layout: Layout,
    components: {Fields},
    setup(props) {
        const form = useForm({
            id: props.getpage.id,
            title: props.getpage.title,
            url: props.getpage.url,
            url_name: props.getpage.url_name,
            template: props.getpage.template,
            description: props.getpage.description,
            start_categories: props.getpage.categories,
            page_sections: props.getpage.page_sections,
            categories: []
        });
        return { form };
    },
    props: {
        getpage: Object,
        errors: Object,
        getiteration: Number,
        getcategories: Array
    },
    methods: {
        submit() {
            this.form.put(route("pages.update", this.form));
        },
    },
}
</script>

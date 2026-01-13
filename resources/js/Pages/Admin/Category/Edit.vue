<template>
    <div class="px-32">
        <div class="py-32">
            <div class="text-xl font-bold w-full">
                <div class="text-center w-full uppercase">Edit a template</div>
            </div>
        </div>
        <div>From here you can edit your templates and their associated documentation</div>
        <div>
            <div>
                <div v-if="$page.props.status.message" class="p-4 rounded-md bg-blue-100 text-blue-700 bold">{{$page.props.status.message}}</div>
                <div>
                    <div class="py-2">
                        <form  @submit.prevent="submit">
                            <Fields
                                :getcategories="getcategories"
                                :getiteration="getiteration"
                                :getiterationoption="getiterationoption"
                                @modelSubmited="submit()"
                                :getmodel="form"
                                :errors="errors"
                                :getchildcategories="getcategory.categories"
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
import Fields from '../../Help/Form/Category/Fields.vue'
import { reactive } from 'vue'
//import { Inertia } from '@inertiajs/inertia'
import { router } from '@inertiajs/vue3'
//import { useForm } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/vue3";
export default {
    layout: Layout,
    components: {Fields},
    setup(props) {
        const form = useForm({
            id: props.getcategory.id,
            name: props.getcategory.name,
            description: props.getcategory.description,
            is_product: props.getcategory.is_product,
            category_id: props.getcategory.category,
            documentations: props.getcategory.documentations,
        });
        return { form };
    },
    props: {
        getcategory: Object,
        errors: Object,
        getiteration: Number,
        getiterationoption: Number,
        getcategories: Array
    },
    methods: {
        submit() {
            this.form.put(route("categories.update", this.getcategory.id));
        },
    },
}
</script>

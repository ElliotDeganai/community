<template>
    <div class="px-32">
        <div class="py-32">
            <div class="text-xl font-bold w-full">
                <div class="text-center w-full uppercase">Create a template</div>
            </div>
        </div>
        <div>From here you can create your templates and their associated documentation</div>
        <div>
            <div>
                <div>
                    <div class="py-2">
                        <form  @submit.prevent="submit">
                            <div>
                                <Fields
                                    :getcategories="getcategories"
                                    :getiteration="getiteration"
                                    :getiterationoption="getiterationoption"
                                    @modelSubmited="submit()"
                                    :getmodel="form"
                                    :errors="errors" :gettype="type"
                                />
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
import Fields from '../../Help/Form/Category/Fields.vue'
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
export default {
    setup () {
        const form = reactive({
            name: null,
            type: null,
            is_product: false,
            description: null,
            category_id: null,
            documentations: [],
        })

        function submit() {
            Inertia.post('/admin/categories', form);
        }

        return { form, submit }
    },
    layout: Layout,
    props: {
        errors: Object,
        getiteration: Number,
        getiterationoption: Number,
        getcategories: Array,
        gettype: String
    },
    components: {Fields},
    data() {
        return {
            type: this.gettype,
        }
    },
    created() {
        if(this.type){
            this.form.category_id = this.getcategories[0];
        }
    },
}
</script>

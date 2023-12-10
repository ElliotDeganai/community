<template>
    <div class="px-32 text-white">
        <div class="py-32">
            <div class="text-xl font-bold w-full">
                <div class="text-center w-full uppercase">Ajouter une nouvelle idée</div>
            </div>
        </div>
        <div>Donnes au moins un nom à ton idée. Les autres champs ne sont pas obligatoires.</div>
<!--         <div v-if="type && getcategories[0]" class="py-8">
            <Link :href="route('posts.edit', getcategories[0].id )" class="text-lg font-bold bg-gray-800 px-3 py-2 rounded-md text-white">
                Edit the {{getcategories[0].name}} template
            </Link>
        </div> -->
        <div>
            <div>
                <div>
                    <div class="py-2">
                        <form  @submit.prevent="submit">
                            <div>
                                <Fields @modelSubmited="submit()" :getparent="getparent" :getmodel="form" :categories="getcategories" :errors="errors" />
                            </div>
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
        getparent: Object,
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

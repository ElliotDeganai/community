<template>
    <div class="pt-8 px-4 md:pt-16 md:px-16 lg:pt-32 lg:px-32 text-white">
        <div class="py-16 lg:py-32">
            <div class="text-xl font-bold w-full">
                <div class="text-center w-full uppercase">Ajouter un voeu</div>
            </div>
        </div>
        <div class="font-bold md:text-lg">Seul le champs "Ton voeu" est obligatoire.</div>
        <div class="py-2 text-xs md:text-base">
            <div>Ci-dessous, tu trouveras une explication de chaque champ non obligatoire:</div>
            <ul class="list-disc pl-2 md:pl-4">
                <li>Le champ "Description détaillée de ton voeu" complète le nom inscrit dans le champ "Ton voeu" et te permet de décrire avec plus de détaille ton voeu.</li>
                <li>Le champ "Image" te permet d'ajouter une image qui permettra d'illustrer ton voeu.</li>
                <li>Le champ "Lien" te permet d'ajouter le lien direct vers la page internet où on peut trouver ton voeu.</li>
            </ul>
        </div>
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
//import { Inertia } from '@inertiajs/inertia'
import { router } from '@inertiajs/vue3'
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
            router.post('/admin/posts', form);
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
    mounted() {
        console.log(this.$page.props);
    },
}
</script>

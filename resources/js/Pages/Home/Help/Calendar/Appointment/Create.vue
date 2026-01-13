<template>
    <div class="">
        <div class="font-bold py-8 w-full">
            Your appointment
        </div>
        <div class="w-full">
            <form class="w-full">
                <div>{{formatDate(getdate)}}</div>
                <Fields :getmodel="form" @modelSubmited="submit()" class="w-full" />
            </form>
        </div>
    </div>
</template>
<script>
import Fields from './Fields.vue'
import { reactive } from 'vue'
//import { Inertia } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import moment from 'moment';
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

        function formatDate(date){
            return moment(date).format('YYYY-MM-DD');
        }

        function formatTime(date){
            return moment(date).format('HH:mm:ss');
        }

        return { form, submit, formatDate, formatTime }
    },
    components: { Fields },
    props: ["getdate"],
    data() {
        return {

        }
    },

}
</script>

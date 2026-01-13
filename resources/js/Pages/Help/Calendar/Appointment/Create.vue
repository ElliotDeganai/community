<template>
    <div class="">
        <div class="font-bold py-8 w-full">
            Your appointment
        </div>
        <div class="w-full">
            <form class="w-full">
                <div>{{formatDate(getdate)}}</div>
                <Fields @submit.prevent="submit" :errors="errors" :getmodel="form" @modelSubmited="submit()" class="w-full" />
            </form>
        </div>
    </div>
</template>
<script>
import Fields from './Fields.vue'
import { reactive } from 'vue'
//import { Inertia } from '@inertiajs/inertia'
import { useForm } from "@inertiajs/vue3";
import { router } from '@inertiajs/vue3'
import {computed} from "vue";
import moment from 'moment'
export default {
    //props: ["getdate", "getcategory", "errors"],
    props: {
        getcategory: Object,
        getdate: Date,
        getdocumentation: Object,
        errors: Object
    },
    setup (props) {
        let doc = {
            documentation_id: props.getcategory.documentations[0] ? props.getcategory.documentations[0].id : null,
            value_text: null,
            value_number: null,
            value_html: null,
            value_date: null,
            value_date_time: props.getdate,
            value_number:null,
            value_price:null,
            value_list: null,
            value_link: null,
            value_gallery:null,
            value_image:null,
            value_carousel:null,
            images: [],
            gallery: [],
            carousel: [],
            audio: [],
        };
        //this.model.doc_values.push(doc);
        const form = useForm({
            name: null,
            slug: null,
            body: null,
            published: 0,
            published_at: null,
            category_id: props.getcategory ? props.getcategory : null,
            post_id: null,
            doc_values: [doc],
            excerpt: null,
            image: null,
        })

        function submit() {
            form.doc_values = [];
            form.doc_values = [
                {
                    documentation_id: props.getcategory.documentations[0] ? props.getcategory.documentations[0].id : null,
                    value_text: null,
                    value_number: null,
                    value_html: null,
                    value_date: null,
                    value_date_time: props.getdate,
                    value_number:null,
                    value_price:null,
                    value_list: null,
                    value_link: null,
                    value_gallery:null,
                    value_image:null,
                    value_carousel:null,
                    images: [],
                    gallery: [],
                    carousel: [],
                    audio: [],
                }
            ];
            router.post('/admin/posts', form);
        }

        function formatDate(date){
            return moment(date).format('YYYY-MM-DD');
        }

        function formatTime(date){
            return moment(date).format('HH:mm:ss');
        }



        return { form, submit, formatDate,  formatTime}
    },
    components: { Fields },
    data() {
        return {

        }
    },
    mounted() {
    },
}
</script>

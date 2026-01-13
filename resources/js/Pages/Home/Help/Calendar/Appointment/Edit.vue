<template>
    <div class="">
        <div class="font-bold py-8 w-full">
            Your appointment
        </div>
        <div class="w-full">
            <form class="w-full">
                <div>{{formatDate(getdate)}}</div>
                <!-- <input v-model="getdate" type="datetime-local" class="border px-3 py-2" placeholder="Date" /> -->
                <Fields :getmodel="form" @modelSubmited="submit" class="w-full" />
            </form>
        </div>
    </div>
</template>
<script>
import Fields from './Fields.vue'
import { reactive } from 'vue'
//import { Inertia } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import moment from 'moment'
export default {
    props: ["getdate", "getappointment"],
    setup (props) {
        const form = reactive({
            name: props.getappointment.name,
            phone: props.getappointment.phone,
            email: props.getappointment.email,
            date: props.getappointment.date,
            comment: props.getappointment.comment,
        })

        function formatDate(date){
            return moment(date).format('YYYY-MM-DD');
        }

        function formatTime(date){
            return moment(date).format('HH:mm:ss');
        }

/*         function submit() {
            Inertia.put('/appointment', form);
        } */

        return { form, formatDate, formatTime }
    },
    components: { Fields },
    data() {
        return {

        }
    },
    methods: {
        submit() {
            this.form.put(route("appointment.update", this.getappointment.id));
        },
    },

}
</script>

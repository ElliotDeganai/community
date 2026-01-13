<template>
    <div>
        <input type="text" class="border px-3 py-2" placeholder="Name" v-model="getmodel.name" />
        <textarea class="w-full h-48 border px-3 py-2" placeholder="Comment" v-model="getmodel.body"/>
        <div class="">
            <button  @click.prevent="submitModel()" class="btn-submit-fields" value="Submit">
                Submit
            </button>
        </div>
        <Errors :errors="errors" />
    </div>
</template>
<script>
import Errors from '../../Form/Errors.vue';
export default {
    components: {Errors},
    props: {
        getmodel: Object,
        errors: Object
    },
    data() {
        return {
            appointment: this.getmodel
        }
    },
    methods: {
        submitModel(){
            this.setSlug();
            this.$emit('modelSubmited', this.appointment);
        },
        setSlug() {
            if ((this.appointment.slug === null || this.appointment.slug === '') && (this.appointment.name !== null && this.appointment.name !== '')) {
                this.appointment.slug = this.appointment.name.replaceAll(' ', '-').toLowerCase(); // $& means the whole matched string
            }
        },
    },
    mounted() {
    },
}
</script>

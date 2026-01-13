<template>
    <div>
        <input type="text" class="border px-3 py-2" placeholder="Name" />
        <textarea class="w-full h-48 border px-3 py-2" placeholder="Comment" />
        <div class="">
            <button  @click.prevent="submitModel()" class="btn-submit-fields" value="Submit">
                Submit
            </button>
        </div>
    </div>
</template>
<script>
export default {
    props: ["getmodel"],
    data() {
        return {
            appointment: this.getmodel
        }
    },
    methods: {
        submitModel(){
            this.$emit('modelSubmited', this.appointment);
        },
    }
}
</script>

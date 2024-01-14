<template>
    <div class="right">
        <div>
            <img alt="Logo chargement" class="object-contain w-56 h-56" :src="'/storage/base/ED 2 Blanc Sans fond.png'" />
        </div>
        <div>
            <p>{{message}}</p>
        </div>
    </div>
</template>
<script>
import BreezeGuestLayout from '@/Layouts/Guest.vue';
export default {
    components:  {BreezeGuestLayout},
    layout: BreezeGuestLayout,
    props: {
        getmessage: String,
    },
    data() {
        return{
            message: this.getmessage
        }
    },
    methods: {
    },
    computed: {
    },
    created() {
    },
    mounted() {
    },
}
</script>
<style>

</style>

<template>
    <div class="left">
        <div>
            <img alt="Logo chargement" class="object-contain w-56 h-56" :src="'/storage/base/ED 2 Blanc Sans fond.png'" />
        </div>
        <div class="w-1/3">
            <small></small>
            <p :class="[this.$page.props.auth.user.id === message.user_id ? 'text-left':'text-right']" class="" :key="message.id" v-for="message in messages">{{message.content}}</p>
        </div>
    </div>
</template>
<script>
import BreezeGuestLayout from '@/Layouts/Guest.vue';
export default {
    components:  {BreezeGuestLayout},
    layout: BreezeGuestLayout,
    props: {
        getmessages: Array,
    },
    data() {
        return{
            //messages: this.getmessages
        }
    },
    methods: {
    },
    computed: {
        messages() {
            return this.getmessages
        }
    },
    created() {
    },
}
</script>
<style>

</style>

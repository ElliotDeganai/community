
<template>
    <div>
        pusher test
    </div>
</template>
<script>
import BreezeGuestLayout from '@/Layouts/Guest.vue';
        Echo.channel('notification')
            .listen('MessageNotification', (e) => {
                console.log(e.message);
            });
export default {
    components:  {BreezeGuestLayout},
    layout: BreezeGuestLayout,
    props: {
    },
    data() {
        return{
        }
    },
    methods: {
    },
    computed: {
    },
    created() {
        Echo.channel('notification')
            .listen('MessageNotification', (e) => {
                console.log(e.message);
            });
    },
    mounted() {
        console.log(Echo);
        Echo.channel('notification')
            .listen('MessageNotification', (e) => {
                console.log(e.message);
            });
        //alert('Show without refresh!');
    },
}
</script>
<style>

</style>


<template>
    <div>
        <div>pusher test</div>
        <div>
            <button></button>
        </div>
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
        submit() {
            let self = this;
            this.form.post(route("broadcast", {message: self.message}), {
                forceFormData: true,
            });
        }
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
        //console.log(Echo);
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

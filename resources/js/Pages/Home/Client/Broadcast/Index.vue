<template>
    <div class="chat pt-32 px-24 text-white">

        <div class="top">
            <div>
                <p>Ross Edlin</p>
                <small>Online</small>
            </div>
        </div>

        <div class="messages">
            <Receive :getmessages="messages" />
        </div>

        <div class="bottom">
            <div>
                <form @submit.prevent="submit">
                    <input v-model="form.content" class="text-slate-900" type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off" />
                    <button class="px-3 py-2 border border-white" type="submit">Send</button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import Receive from './Receive.vue';
import { Inertia } from '@inertiajs/inertia'
import { reactive } from 'vue'
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    components:  {BreezeGuestLayout, Receive},
    setup(props) {
        const form = useForm({
            content: null,
            conversation_id: props.getconversation.id
        });
        return { form };
    },
    layout: BreezeGuestLayout,
    props: {
        getmessages: Array,
        getconversation: Object,
    },
    data() {
        return{
            //messages: this.getmessages,
            conversation: this.getconversation
        }
    },
    methods: {
        submit() {
            let self = this;
            this.form.post(route("broadcast", self.form), {
                preserveState: false,
                onSuccess: () => this.form.reset(),
            });
        }
    },
    computed: {
        messages() {
            return this.getmessages
        }
    },
    created() {
        window.Echo.private('App.Models.User.'+this.$page.props.auth.user.id).notification((notification) => {
            console.log(notification);
         })
    },
    mounted() {
/*       let pusherScript = document.createElement('script')
      pusherScript.setAttribute('src', 'https://js.pusher.com/7.2/pusher.min.js')
      document.head.appendChild(pusherScript);

      let gapisScript = document.createElement('script')
      gapisScript.setAttribute('src', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js')
      document.head.appendChild(gapisScript); */
      this.form.content = null;
/*       console.log(Echo.channel('public'));
        Echo.channel('public')
            .listen('PusherBroadcast', (e) => {
                console.log(e.message);
            }); */
    },
}
</script>
<style>

</style>


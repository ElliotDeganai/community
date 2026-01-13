<template>
    <div class="relative ">
        <div v-if="$page.props.auth.isDev || $page.props.auth.isAdmin" class="pt-16 px-4 md:pt-16 md:px-16 lg:pt-32 lg:px-32 w-full h-full">
            <div class="pt-16">
                <div class="py-8">Résumé</div>
<!--                 <div>
                    <div class="w-full">
                        <div>Les rendez-vous à venir :</div>
                        <div class="flex flex-wrap py-2">
                            <div class="w-1/6 font-bold">Titre</div>
                            <div class="w-1/6 font-bold">Date</div>
                            <div class="w-1/6 font-bold">Client</div>
                            <div class="w-2/6  font-bold">Message</div>
                        </div>
                        <div :key="appointment.id" v-for="appointment in getFutureAppointments" class="flex flex-wrap content-center border-t py-2">
                            <div class="w-1/6">{{appointment.name}}</div>
                            <div class="w-1/6">{{getValueByFieldName("Date", appointment)}}</div>
                            <div class="w-1/6">{{appointment.user.name}}</div>
                            <div class="w-2/6 truncate">{{appointment.body}}</div>
                            <button v-if="$page.props.auth.isDev || $page.props.auth.isAdmin" class="btn-delete" @click="this.$store.dispatch('set_model', {model: appointment  , route: 'resource', type: 'resource'})">Delete</button>
                        </div>
                    </div>
                </div> -->
                <div>
                    <MyTable :getheader="['Id', 'Titre', 'Date', 'Client', 'Message']" :gettitle="'Les rendez-vous à venir'" :getvalues="getFutureAppointments" :getColLength="'1/6'" />
                </div>

                <div>
                    <MyTable :getheader="['Id', 'Titre', 'Date', 'Client', 'Message']" :gettitle="'Les rendez-vous passés'" :getvalues="getOldAppointments" :getColLength="'1/6'" />
                </div>

            </div>
        </div>
    </div>
</template>
<script>
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import helpers from '../../../helpers'
import DocValue from './../Help/DocumentationValue.vue'
import MyTable from './Help/MyTable.vue'
import Couple from '../Help/Icon/Couple.vue'
//import { useForm } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/vue3";
import store from '../../../Store/index';
import Vuex from "vuex";
//import { Link } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
export default {
    components:  {BreezeGuestLayout, DocValue, Couple, Link, MyTable},
    layout: BreezeGuestLayout,
    props: {
        getcampaigns: Array,
        getsection: Object,
        getusers: Array
    },
    data() {
        return{
            appointments: this.getAppointmentSection().category.posts,
            users: this.getusers,
            editors: this.getusers.filter(u => u.roles),
            page: this.$page.props.pages.filter(page => page.title == 'Resume')[0],
            sections: this.$page.props.pages.filter(page => page.title == 'Resume')[0].page_sections,
            updateMode: false,
            launched: false,
            form : useForm({
                users: this.getusers
            }),
        }
    },
    methods: {
        getAppointmentSection(){
            return this.$helpers.getSection(this.$page.props.pages.filter(page => page.title == 'Resume')[0], 'Appointment');
        },
        getValueByFieldName(field_name, obj_field) {
            return this.$helpers.getFieldDocValueObject(this.$helpers.getSectionField(this.getAppointmentSection(), field_name) , obj_field).docValue;
        },
        getValue(doc_value) {
            return this.$helpers.getValue(doc_value);
        },
        ...Vuex.mapActions([
            "saveCartItem", "addCartItemQuantity", "set_model"
        ]),
        startCampaign() {
            let user_count = this.getEditors.length-1;
            let pioche = [];
            let final = [];
            let self = this;
            this.getEditors.forEach(user => {
                pioche.push(user);
            });
            pioche = this.shuffleBis(pioche);
            //console.log(pioche)
            while (this.compareArray(pioche, this.getEditors)) {
                pioche = this.shuffleBis(pioche);
            }

            for (let index = 0; index < this.getEditors.length; index++) {
                const element = this.users.filter(u => u.id === this.getEditors[index].id)[0];
                element.new_user = pioche[index].id;
            }

            //console.log(this.isCampaignLogic(this.getEditors))
            if (this.isCampaignLogic(this.getEditors)) {
                this.launched = true;
            } else {
                self.startCampaign();
            }


        },
        shuffle (array)  {
            let start_array = array;
            let temp = array.sort(() => Math.random() - 0.5);
            let self = this;
            while (this.compareArray(temp, start_array)) {
                let temp = array.sort(() => Math.random() - 0.5);
            }
            return temp;

        },
        isCampaignLogic(array) {
            let isLogic = true;

            for (let index = 0; index < array.length; index++) {
                const giver = array[index];
                const receiver = array.filter(u => u.id === giver.new_user)[0];
                //console.log(giver, 'giver');
                //console.log(receiver, 'receiver');
                if (giver.new_user === giver.id) {
                    isLogic = false;
                    return isLogic;
                }
                if (giver.new_user === receiver.id && receiver.new_user === giver.id) {
                    isLogic = false;
                    return isLogic;
                }
                return isLogic;
            }
        },
        compareArray(a1, a2){
            for (let index = 0; index < a1.length; index++) {
                if (a1[index].id === a2[index].id) {
                    return true;
                }
            }
            return false;
        },
        shuffleBis(array){
          for (let i = array.length - 1; i > 0; i--) {
                let j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        },
        submit() {
            let self = this;
            this.form.put(route("users.campaign", this.form),  {
                onSuccess: (form) => {
                    self.updateMode = false;
                },
                preserveScroll: true
            });
        },
        cancel() {
            this.updateMode = false;
        },
        changeAnswers() {
            this.updateMode = !this.updateMode;
        },
        setUpdateMode() {
            this.updateMode = !this.updateMode;
        },
        getUser(id) {
            return this.users.filter(u => u.id === id)[0];
        },
        submit_delete(post) {
            router.delete(route("posts.delete", post.id));
        },
        formatModelTable(modelToFormat) {
            let formatted = {
                id: modelToFormat.id,
                name: modelToFormat.name,
                date: this.getValueByFieldName("Date", modelToFormat),
                user: modelToFormat.user.name,
                message: modelToFormat.body
            }
            return formatted;
        },
        ...Vuex.mapActions([
            'set_model'
        ]),
    },
    computed: {
        gameStarted() {
            let started = false;
            this.users.forEach(u => {
                if (u.user_id !== null) {
                    started = true;
                }
            });
            return started;
        },
        getEditors() {
            let editors = [];
            this.getusers.forEach(user => {
                if (user.roles.filter(r => r.name === 'editor').length !== 0) {
                    editors.push(user)
                }
            });
            return editors;
        },
        isEditor() {
            if (this.$page.props.auth.user.roles.filter(r => r.name === 'editor').length > 0) {
                return true;
            }
            return false;
        },
        getSortedAppointments() {
            return this.appointments.sort((a, b) => new Date(b.doc_values[0].current_value) - new Date(a.doc_values[0].current_value));
        },
        getOldAppointments() {
            let arr = [];
            let list = this.appointments.filter(apt => new Date(apt.doc_values[0].current_value) < new Date());
            let listSort = list.sort((a, b) => new Date(a.doc_values[0].current_value) - new Date(b.doc_values[0].current_value));
            for (let index = 0; index < listSort.length; index++) {
                const element = listSort[index];
                arr.push(this.formatModelTable(element));
            }
            return arr;
        },
        getFutureAppointments() {
            let arr = [];
            let list = this.appointments.filter(apt => new Date(apt.doc_values[0].current_value) > new Date());
            for (let index = 0; index < list.length; index++) {
                const element = list[index];
                arr.push(this.formatModelTable(element));
            }
            return arr;
        },
        ...Vuex.mapState([
            "cart"
        ])
    },
    created() {
    },
}
</script>
<style>

</style>

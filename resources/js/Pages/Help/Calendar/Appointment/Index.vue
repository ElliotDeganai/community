<template>
    <div class="" >
        <div class="py-24 px-32">
            <div>
                <div>
                    <div><div class="text-4xl py-8 w-full text-center font-bold">Gestion de mon calendrier</div></div>
                    <div>
                        <div>
                            <div class="w-1/2 py-8">
                                <label class="label-fields">
                                    Les jours ou je suis disponible
                                </label>
                                <div class="flex flex-wrap">
                                    <div class="w-1/7">
                                        <input v-model="formCalendar.monday" type="checkbox" id="monday" name="monday">
                                        <label for="monday">Lundi</label>
                                    </div>
                                    <div class="w-1/7">
                                        <input v-model="formCalendar.tuesday" type="checkbox" id="tuesday" name="tuesday">
                                        <label for="tuesday">Mardi</label>
                                    </div>
                                    <div class="w-1/7">
                                        <input v-model="formCalendar.wednesday" type="checkbox" id="wednesday" name="wednesday">
                                        <label for="wednesday">Mercredi</label>
                                    </div>
                                    <div class="w-1/7">
                                        <input v-model="formCalendar.thursday" type="checkbox" id="thursday" name="thursday">
                                        <label for="thursday">Jeudi</label>
                                    </div>
                                    <div class="w-1/7">
                                        <input v-model="formCalendar.friday" type="checkbox" id="friday" name="friday">
                                        <label for="friday">Vendredi</label>
                                    </div>
                                    <div class="w-1/7">
                                        <input v-model="formCalendar.saturday" type="checkbox" id="saturday" name="saturday">
                                        <label for="saturday">Samedi</label>
                                    </div>
                                    <div class="w-1/7">
                                        <input v-model="formCalendar.sunday" type="checkbox" id="sunday" name="sunday">
                                        <label for="sunday">Dimanche</label>
                                    </div>
                                </div>
                            </div>
                            <div class="py-4 w-1/3">
                                <label class="label-fields">
                                    Disponibilité
                                </label>
                                <div v-if="!formCalendar.is_off" class="py-2">
                                    <div @click.prevent="toggleOff()" :class="[formCalendar.is_off ? ' bg-green-300' : ' bg-stone-300']" class="cursor-pointer w-16 h-6 rounded-full relative shadow-lg">
                                        <span :class="[form.is_off ? 'right-0 bg-green-800' : 'left-0 bg-stone-700']" class="absolute -top-1  w-8 h-8 rounded-full shadow-lg"></span>
                                    </div>
                                    <div class="block">Je suis disponible</div>
                                </div>
                                <div v-else class="py-2">
                                    <div @click.prevent="toggleOff()" :class="[formCalendar.is_off ? ' bg-green-300' : ' bg-stone-300']" class="cursor-pointer w-16 h-6 rounded-full relative shadow-lg">
                                        <span :class="[form.is_off ? 'left-0 bg-green-800' : 'right-0 bg-stone-700']" class="absolute -top-1  w-8 h-8 rounded-full shadow-lg"></span>
                                    </div>
                                    <div class="block">Je suis en vacance</div>
                                </div>
                                <div v-if="formCalendar.is_off">
                                    <label class="label-fields py-4">
                                        Jusqu'au
                                    </label>
                                    <div><input v-model="formCalendar.return_date" type="date" class="form-fields" /></div>
                                </div>
                            </div>
                        </div>
                        <div class="py-8">
                            <div>
                                <div @click.prevent="submitCalendar()" class="btn-submit-fields cursor-pointer">Enregister les modifications</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div><div class="text-4xl py-8 w-full text-center font-bold">Gestion des RDV</div></div>
            <div>
                <div>
                    <div class="w-full bg-teal-800 text-white text-center py-8">RDV</div>
<!--                     <div>
                        <div class="w-full border-b flex flex-wrap content-center" :key="appointment.id" v-for="appointment in appointments">
                            <div class="w-1/4">{{ formatDate(appointment.meeting_date) }}</div>
                            <div class="w-1/4">{{ getMeetingEndDate(appointment.meeting_date) }}</div>
                            <div class="w-1/4">{{ appointment.status }}</div>
                            <div class="w-1/4 px-3">
                                <button class="btn-delete" @click="this.$store.dispatch('set_model', {model: appointment, route: 'appointment', type: 'appointment'})">Supprimer le rendez-vous</button>
                            </div>
                        </div>
                    </div> -->
                    <div class="py-8">
                        <div>
                            <div v-if="$page.props.status.message !== null" class="py-8">
                                <div v-if="$page.props.status.message" class="p-4 rounded-md bg-blue-100 text-blue-700 bold">{{$page.props.status.message}}</div>
                            </div>
                            <div v-if="appointments.length !== 0" class="w-full">
                                <div class="w-full">
                                    <div class="w-full font-bold flex flex-wrap py-4 border-b-2 border-gray-800">
                                        <div class="w-1/12 flex items-center justify-center">
                                        </div>
                                        <div class="text-left w-1/8 flex items-center justify-center">Date</div>
                                        <div class="text-left w-1/8 flex items-center justify-center">Statut</div>
                                        <div class="text-left w-1/8 flex items-center justify-center">Client</div>
                                        <div class="text-left w-1/8 flex items-center justify-center">Mis à jour le</div>
                                        <div class="text-left w-1/8 flex items-center justify-center"></div>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class="w-full" :key="appointment.id" v-for="appointment in appointments">
                                        <div class="w-full flex flex-wrap py-4 border-b border-gray-200">
                                            <div class="w-1/12 py-2 flex items-center justify-center">
                                                <button @click.prevent="deploy(appointment)" type="button">
                                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="text-left w-1/8 py-2 flex items-center justify-center">{{ formatDate(appointment.meeting_date) }}</div>
                                            <div  class="text-left w-1/8 py-2 flex items-center justify-center">
                                                <span :class="[appointment.status == 'accepted' && appointment.status != 'pending' ? 'bg-green-600 text-white rounded-full px-3 py-2' : appointment.status == 'declined' && appointment.status != 'pending' ? 'bg-red-600 text-white px-3 py-2 rounded-full' : 'px-3 py-2 bg-slate-200 rounded-full']">
                                                    {{ appointment.status }}
                                                </span>
                                            </div>
                                            <div v-if="getUserWithRole(appointment, 'requestor').length > 0" class="text-left w-1/8 py-2 flex items-center justify-center">{{ getUserWithRole(appointment, 'requestor')[0].name }}</div>
                                            <div v-else class="text-left w-1/8 py-2 flex items-center justify-center">{{  }}</div>
                                            <div class="text-left w-1/8 py-2 flex items-center justify-center">{{formatDatetime(appointment.updated_at)}}</div>
                                            <div v-if="(!$page.props.auth.isClient) && appointment.status !== 'accepted' && appointment.status !== 'declined'" class="px-3  flex items-center justify-center">
                                                <button class="btn-add" @click.prevent="this.updateAppointment(appointment, 'accepted')">Accepter le RDV</button>
                                            </div>
                                            <div v-if="(!$page.props.auth.isClient) && appointment.status !== 'declined' && appointment.status !== 'accepted'" class="px-3  flex items-center justify-center">
                                                <button class="btn-delete" @click.prevent="this.updateAppointment(appointment, 'declined')">Refuser le RDV</button>
                                            </div>
        <!--                                     <div class="">
                                                <Link as="button" data-message="Are you sure ?" class="btn-delete" method="delete" :href="route('categories.destroy', category.id)" :preserve-state="false">
                                                    Delete
                                                </Link>
                                            </div> -->
                                        </div>
                                        <div class="w-full" v-if="detail !== null">
                                            <div v-if="detail.id === appointment.id" class="w-full bg-stone-100">
                                                <div class="uppercase font-bold text-lg py-2 w-full text-white bg-gray-900 text-center">Message du client</div>
                                                <div class="w-full">
                                                    <div class="w-full flex flex-wrap py-2">
                                                        <div>{{appointment.comment}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-wrap py-8 justify-center w-full">
                                <pagination :getpagination="pagination" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import store from '../../../../Store/index';
import Vuex from "vuex";
//import { useForm } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/vue3";
//import { Link } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/vue3'
import moment from 'moment';
import Pagination from '../../Pagination.vue'
import Check from '../../Icon/Check.vue';
export default {
/*     setup(props) {
        const form = useForm({
            user:
        });
        return { form };
    }, */
    props: ['getposts', 'getcategories', 'getintent', 'getappointments'],
    components:  {BreezeGuestLayout, Link, Pagination, Check},
    layout: BreezeGuestLayout,
    data() {
        return {
            form : useForm({
                id: null,
                status: null

            }),
            formCalendar : useForm({
                id: this.$page.props.auth.user.calendar.id,
                availability_type: this.$page.props.auth.user.calendar.availability_type,
                beginning_hour: this.$page.props.auth.user.calendar.beginning_hour,
                description: this.$page.props.auth.user.calendar.description,
                ending_hour: this.$page.props.auth.user.calendar.ending_hour,
                friday: this.$page.props.auth.user.calendar.friday,
                is_off: this.$page.props.auth.user.calendar.is_off,
                return_date: this.formatDateForInput(this.$page.props.auth.user.calendar.return_date),
                saturday: this.$page.props.auth.user.calendar.saturday,
                slot_duration_time: this.$page.props.auth.user.calendar.slot_duration_time,
                slot_duration_unit: this.$page.props.auth.user.calendar.slot_duration_unit,
                sunday: this.$page.props.auth.user.calendar.sunday,
                thursday: this.$page.props.auth.user.calendar.thursday,
                tuesday: this.$page.props.auth.user.calendar.tuesday,
                wednesday: this.$page.props.auth.user.calendar.wednesday,
                monday: this.$page.props.auth.user.calendar.monday

            }),
            appointments: this.getappointments.data,
            pagination: this.getappointments,
            detail: null,
            days: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']
        }
    },
    methods: {
        formatDateForInput(date) {
            if (!date) return '';
            // Si c'est déjà un string au bon format → on le garde
            if (typeof date === 'string' && date.match(/^\d{4}-\d{2}-\d{2}$/)) {
                return date;
            }
            // Sinon on utilise moment ou Date pour extraire seulement la date
            return moment(date).format('YYYY-MM-DD');
            // ou sans moment :
            // return new Date(date).toISOString().split('T')[0];
        },
        getUserWithRole(appointment, role) {
            return appointment.users.filter(u => u.pivot.type == role);
        },
        toggleOff() {
            this.formCalendar.is_off = !this.formCalendar.is_off;
        },
        updateAppointment(appointment, type){
            switch (type) {
                case 'accepted':
                    appointment.status = 'accepted';
                    this.form.id = appointment.id;
                    this.form.status = appointment.status;
                    this.form.put(route("calendar.update", this.form.id),  {
                        onSuccess: (form) => {
                            self.updateMode = false;
                        },
                        preserveScroll: true,            // garde la position du scroll
                        preserveState: false
                    });
                    break;
                case 'declined':
                    appointment.status = 'declined';
                    this.form.id = appointment.id;
                    this.form.status = appointment.status;
                    this.form.put(route("calendar.update", this.form.id),  {
                        onSuccess: (form) => {
                            self.updateMode = false;
                        },
                        preserveScroll: true,            // garde la position du scroll
                        preserveState: false
                    });
                    break;

                default:
                    this.form.appointment = appointment;
                    this.form.put(route("calendar.update", this.form),  {
                        onSuccess: (form) => {
                            self.updateMode = false;
                        },
                        preserveScroll: true,            // garde la position du scroll
                        preserveState: false
                    });
                    break;
            }
        },
        formatDate(date){
            return moment(date).format('YYYY-MM-DD');
        },
        formatDatetime(date){
            return moment(date).format('YYYY-MM-DD HH:mm');
        },
        getMeetingEndDate(date){
            let dt_plus = new Date(date);
            dt_plus = dt_plus.setHours(dt_plus.getHours() + Number(this.$page.props.calendar_slot_time));
            return moment(dt_plus).format('YYYY-MM-DD HH:mm');
        },
        getValue(docValue){
            return helpers.getValue(docValue);
        },
        toggleDisplay(id){
            let refKey = 'post_'+id;
            let element = this.$refs[refKey][0];
            element.classList.contains('hidden') ? element.classList.replace('hidden', 'block') : element.classList.replace('block', 'hidden');
        },
        toggleCategory(id){
            let refKey = 'category_'+id;
            let element = this.$refs[refKey][0];
            element.classList.contains('hidden') ? element.classList.replace('hidden', 'block') : element.classList.replace('block', 'hidden');
        },
        getFieldDocValue(field, post){
            return helpers.getFieldDocValue(field, post);
        },
        ...Vuex.mapActions([
            "saveCartItem", "addCartItemQuantity"
        ]),
        setProductCart(product){
            let product_in_cart = this.cart.filter(item => item.id == product.id);
            if (product_in_cart.length == 0) {
                let cart_item = {
                    product: product,
                    quantity: 1
                };
                //console.log(cart_item)
                this.saveCartItem(cart_item);
            } else {
                this.addCartItemQuantity(product_in_cart[0]);
            }
        },
        submit() {
            let self = this;
                    this.form.has_answered = 1;
            this.form.put(route("users.update", this.form.id),  {
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
        scrollToRsvp() {
            this.$refs.summary.scrollIntoView({ behavior: 'smooth' });
        },
        replaceUser(text) {
            if (text) {
                return text.replace("%user%", '<span class="font-bold">'+this.$page.props.auth.user.name+'</span>');
            } else {
                return null;
            }
        },
        createDiv(text) {
            if (text) {
                return '<div>'+text+'</div>';
            } else {
                return null;
            }
        },
        showDetails(appointment){
            this.detail = appointment;
        },
        reduceDetails(){
            this.detail = null;
        },
        deploy(appointment){
            if (this.detail === null) {
                this.showDetails(appointment);
            }else{
                this.reduceDetails();
            }
        },
        submitCalendar() {
            if (!this.formCalendar.is_off) {
                this.formCalendar.return_date = null;
            }
            this.formCalendar.put(route("calendar.updateCalendar", this.formCalendar.id),  {
                onSuccess: (form) => {
                    self.updateMode = false;
                },
                preserveScroll: true,            // garde la position du scroll
                preserveState: false
            });
        },
    },
    computed: {
        ...Vuex.mapState([
            "cart"
        ])
    },
    mounted() {
        this.$emit("siteReady");
    },
}
</script>

<style>

.loader {
  animation: bouncing 1s linear infinite;
}

@keyframes bouncing {
  0% { transform: translateY(0); }
  50% { transform: translateY(-30%); }
  100% { transform: translateY(0); }

}
</style>

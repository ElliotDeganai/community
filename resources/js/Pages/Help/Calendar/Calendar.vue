<template>
    <div>
        <div class="flex flex-wrap">
            <div class="w-3/5 border rounded-lg p-4">
                <Top @prevMonth="decreaseMonth()" @nextMonth="increaseMonth()" @resetCalendar="reset()" :getMonth="dynamicMonth" :getYear="dynamicYear" class="w-full h-1/8 py-4" />
                <Grid :getcalendar="dynamicTrainer.calendar" :getDays="getCurrentDays" :getSelectionDay="dynamicDay" @changeDay="changeDay" :getevents="getevents" :getoccupied="dynamicTrainer.calendar.appointments" class="w-full py-4 h-7/8" />
                <!-- <Create :getdate="dynamicDay" :getcategory="appointmentCategory" :errors="errors" class="w-full" /> -->
            </div>
            <div class="w-2/5 px-16">
                <div class="border rounded-lg px-4 py-8">
                    <div>
                        <div>
                            <div v-if="form.duration_unit == 'H'" class="py-4">Choisissez votre creneau pour le {{getDateOnly(day)}} :</div>
                            <div v-else class="py-4">Jour sélectionné {{getDateOnly(day)}} :</div>
                            <div class="py-4">
<!--                                 <select v-model="form.meeting_date" name="cars" id="cars">
                                    <option :disabled="isSlotOccupied(slot)" :key="slot" v-for="slot in slots" :value="slot">{{displaySlot(slot)}}</option>
                                </select> -->
                                <div v-if="form.duration_unit == 'H'" class="flex flex-wrap">
                                    <div class="w-1/2 px-3 py-2" :key="slot" v-for="slot in slots">
                                        <div @click.prevent="form.meeting_date = slot" :class="[isDateEquals(slot, form.meeting_date) ? 'bg-teal-900 text-white font-bold' : 'border-teal-900 text-teal-900 ' ]" class="px-3 py-2 text-center border cursor-pointer rounded-lg">{{displaySlot(slot)}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="py-8">
                        <div>
                            <textarea v-model="form.comment" class="px-3 py-2 border w-full h-64"></textarea>
                        </div>
                    </div>
                    <div class="py-8">
                        <div>
                            <div @click.prevent="submitRequest()" class="btn-submit-fields cursor-pointer">Envoyer la demande</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <div>
            <div v-if="$page.props.status.message !== null" class="py-8">
                <div v-if="$page.props.status.message" class="p-4 rounded-md bg-blue-100 text-blue-700 bold">{{$page.props.status.message}}</div>
            </div>
         </div>
    </div>
</template>
<script>
import Top from './Header.vue'
import Grid from './Grid.vue'
import Fields from './Appointment/Fields.vue'
import Create from './Appointment/Create.vue'
import moment from 'moment'
import { useForm } from "@inertiajs/vue3";
//import { Inertia } from '@inertiajs/inertia'
import { router } from '@inertiajs/vue3'
import momentTimezone from 'moment-timezone/builds/moment-timezone-with-data'
export default {
    props: ["getevents", "getcategory", "errors", "getappointments", "gettrainer"],
    components: {Top, Grid, Fields, Create},
    data() {
        return {
            month: this.getCurrentMonth(),
            year: this.getCurrentYear(),
            day: this.getCurrentDay(),
            appointmentCategory: this.getcategory,
            slots: [],
            selectSlot: null,
            occupiedSlots: [],
            begginning: 9,
            ending: 19,
            form: useForm({
                meeting_date: null,
                comment: null,
                duration_time: this.$page.props.calendar_slot_time,
                duration_unit: this.$page.props.calendar_slot_time_unit,
                type: 'intervention',
                requestor: this.$page.props.auth.user.id,
                trainer: null,
                status: 'pending',
                calendar_id: null
            }),
            appointments: this.getappointments
        }
    },
    methods: {
        getDateOnly(dt) {
            return moment(dt).format('YYYY-MM-DD')
        },
        getDateHour(dt) {
            return moment(dt).format('HH:mm')
        },
        displaySlot(slot) {
const local = moment(slot).tz('Europe/Paris'); // slot est en UTC

    const start = local.format('HH:mm');
    const end   = local.clone().add(this.$page.props.calendar_slot_time, 'hours').format('HH:mm');

    return `${start} - ${end}`;
        },
        changeDay(day) {
            this.day = day;
            this.fakeSlots();
        },
        reset() {
            this.month = this.getCurrentMonth();
            this.year = this.getCurrentYear();
            this.day = this.getCurrentDay();
        },
        decreaseMonth() {
            switch (this.month) {
                case 0:
                    this.month = 11;
                    this.year = this.year-1;
                    break;
                default:
                    this.month = this.month-1;
                    break;
            }
        },
        increaseMonth() {
            switch (this.month) {
                case 11:
                    this.month = 0;
                    this.year = this.year+1;
                    break;
                default:
                    this.month = this.month+1;
                    break;
            }
        },
        getCurrentYear() {
            let current = new Date();
            return current.getFullYear();
        },
        getCurrentMonth() {
            let current = new Date();
            return current.getMonth()
        },
        getCurrentDay() {
            let current = new Date();
            return current;
        },
        getDays(month, year) {
            let date = new Date(year, month, 1);
            let days = [];
            while (date.getMonth() === month) {
                days.push(new Date(date));
                date.setDate(date.getDate()+1);
            }
            return days;
        },
        fakeSlots() {
            this.slots = [];

            const selectedDay = moment(this.day).startOf('day'); // jour à 00:00 local

            const slotDuration = Number(this.$page.props.calendar_slot_time); // ex: 2
            const startHour = this.begginning; // ex: 8
            const endHour   = this.ending;     // ex: 18

            for (let hour = startHour; hour < endHour; hour += slotDuration) {
                const slotLocal = selectedDay.clone().hour(hour).minute(0);

                // On stocke la valeur en UTC (format que Laravel comprend parfaitement)
                const slotUtc = slotLocal.clone().utc().format('YYYY-MM-DD HH:mm:ss');
                if (!this.isSlotOccupied(slotUtc)) {
                    this.slots.push(slotUtc);
                }
            }
        },
        fakeOccupiedSlots() {
            for (let index = 0; index < this.appointments.length; index++) {
                const element = new Date(this.appointments[index].meeting_date);
                this.occupiedSlots.push(element)
            }
        },
        isDateEquals(date1, date2) {
            let day1 = new Date(date1);
            let day2 = new Date(date2);
            return (day1.getDate() == day2.getDate()) && (day1.getMonth() == day2.getMonth()) && (day1.getFullYear() == day2.getFullYear()) && (day1.getHours() == day2.getHours())
        },
        isSlotOccupied(slot) {
            for (let index = 0; index < this.occupiedSlots.length; index++) {
                const element = this.occupiedSlots[index];
                if (this.isDateEquals(slot, element)) {
                    return true;
                }
            }
            return false;
        },
        submitRequest() {
            //router.post('/appointment', this.form);
            this.day.setHours(2);
            this.day.setMinutes(0);
            this.day.setSeconds(0);
            this.form.meeting_date = this.day;
            this.form.trainer = this.gettrainer.id;
            this.form.calendar_id = this.dynamicTrainer.calendar.id;
            this.form.post(route("calendar.store", this.form),  {
                onSuccess: (form) => {
                    self.updateMode = false;
                },
                preserveScroll: true,            // garde la position du scroll
                preserveState: false
            });
        },
        getFirstAvailableDay() {
            const current = new Date();
        },

    },
    computed: {
        currentDate() {
            const current = new Date();
            const date = `${current.getDate()}/${current.getMonth()+1}/${current.getFullYear()}`;
            return date;
        },
        currentDateFull() {
            const current = new Date();
            return current;
        },
        dynamicMonth() {
            return this.month;
        },
        dynamicYear() {
            return this.year;
        },
        dynamicDay() {
            //return moment(this.day).format('DD-MM-YYYY HH:mm');
            return moment(this.day).format();
        },
        getCurrentDays() {
            return this.getDays(this.dynamicMonth, this.dynamicYear);
        },
        dynamicTrainer() {
            return this.gettrainer;
        },
    },
    mounted() {
        this.fakeOccupiedSlots();
        this.fakeSlots();
    },
}
</script>
